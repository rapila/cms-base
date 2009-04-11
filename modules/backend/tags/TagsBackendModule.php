<?php
/**
 * @package modules.backend
 */
class TagsBackendModule extends BackendModule {
  
  private $oTag = null;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $iId = Manager::peekNextPathItem();
      $this->oTag = TagPeer::retrieveByPk($iId);
    }
  }
  
  public function getChooser() { 
    $sSearch = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : null;
    $aTags = TagPeer::getTagsSorted($sSearch);
    $oTemplate = $this->constructTemplate('list');
    
    if($aTags != null) {
      $oTemplate->replaceIdentifier("new_link", $this->link(), Template::NO_HTML_ESCAPE);
      $this->parseTree($oTemplate, $aTags, $this->oTag);
    } else {
      $oTemplate->replaceIdentifier("message_notags", StringPeer::getString('tags.none'));
    }
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oTag === null) {
      return $this->constructTemplate("module_info");
    }
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier("action", $this->link($this->oTag->getId()));
    $oTemplate->replaceIdentifier("id", $this->oTag->getId());
    $oTemplate->replaceIdentifier("name", $this->oTag->getName());  
    $aTagInstances = $this->oTag->getTagInstances();
    $oInstanceTemplate = $this->constructTemplate("tag_instance");
    if($aTagInstances === null) {
      $oInstanceTemplate = $this->constructTemplate("tag_instance");
      $oInstanceTemplate->replaceIdentifier("title", 'keine Instanzen'); 
      $oTemplate->replaceIdentifier("tag_instances", $oInstanceTemplate);  
    } else {
      foreach($aTagInstances as $oTagInstance) {
        $oInstanceTemplate = $this->constructTemplate("tag_instance");
        $oInstanceTemplate->replaceIdentifier("name", $oTagInstance->getName());
        $oInstanceTemplate->replaceIdentifier("action", $this->link($this->oTag->getId()));
        $oInstanceTemplate->replaceIdentifier("tag_id", $this->oTag->getId());
        $oInstanceTemplate->replaceIdentifier("tagged_item_id", $oTagInstance->getTaggedItemId());
        $oInstanceTemplate->replaceIdentifier("model_name", $oTagInstance->getModelName());
        $oTemplate->replaceIdentifierMultiple("tag_instances", $oInstanceTemplate);
      }
    }
    return $oTemplate;
  }
  
  public function deleteInstance($oTag=null) {
    if($oTag === null) {
      $oTag = $this->oTag;
    }
    if($oTag === null) {
      return;
    }
    $oTagInstance = TagInstancePeer::retrieveByPk($oTag->getId(), $_POST['tagged_item_id'], $_POST['model_name']);
    if($oTagInstance === null) {
      return;
    }
    $oTagInstance->delete();
    if($this->oTag === $oTag && count($oTag->getTagInstances()) === 0) {
      $this->oTag = null;
    }
  }
      
  public function save() {
    if($this->oTag === null) {
      $this->oTag = new Tag();
    }
    $this->oTag->save();
  }
  
  //Ajax-related methods
  public function getAjax($aRequestPath) {
    $aTags = array();
    $sMethod = array_shift($aRequestPath);
    switch($sMethod) {
      case "all_tags":
        $aTags = TagPeer::doSelect(new Criteria());
      break;
      case "tags_for":
        $sModelName = $_REQUEST['model_name'];
        $sTaggedItemId = $_REQUEST['tagged_item_id'];
        $aTags = TagPeer::tagInstancesForModel($sModelName, $sTaggedItemId);
      break;
      case "add_tag":
        $aTags = $this->addTag();
      break;
      case "save_tags":
        return $this->saveTags();
      break;
      case "remove_tag":
        $aTags = $this->removeTag();
      break;
    }
    $aTagNames = array();
    $oTemplate = $this->constructTemplate("ajax_tag_list");
    foreach($aTags as $oTag) {
      if($oTag instanceof TagInstance) {
        $oTag = $oTag->getTag();
      }
      $oTagTemplate = $this->constructTemplate("ajax_tag");
      $oTagTemplate->replaceIdentifier("name", $oTag->getName());
      $oTagTemplate->replaceIdentifier("id", $oTag->getId());
      $oTagTemplate->replaceIdentifier("quantity", $oTag->countTagInstances());
      $oTemplate->replaceIdentifierMultiple("tags", $oTagTemplate);
    }
    print $oTemplate->render();
  }
  
  private function saveTags() {
    $oTemplate = $this->constructTemplate("ajax_tag_list");
    if($_REQUEST['model_name'] === "Page" && !Session::getSession()->getUser()->mayEditPageDetails(PagePeer::retrieveByPk($_REQUEST['tagged_item_id']))) {
      return print $oTemplate->render();
    }
    try {
      $aTagInstances = TagPeer::tagInstancesForModel($_REQUEST['model_name'], $_REQUEST['tagged_item_id']);
      foreach($aTagInstances as $oTagInstance) {
        $oTagInstance->delete();
      }
      $aTags = explode(",", $_REQUEST['tags']);
      foreach($aTags as $sTag) {
        if($sTag === "") {
          continue;
        }
        TagInstancePeer::newTagInstance($sTag, $_REQUEST['model_name'], $_REQUEST['tagged_item_id']);
      }
    } catch(Exception $e) {}
    
    print $oTemplate->render();
  }
  
  private function addTag() {
    try {
      if(!$this->mayEditTag()) {
        throw new Exception("You don't have the permissions to edit this tag");
      }
      $sTag = $_REQUEST['tag'];
      if(!StringUtil::normalize($sTag)) {
        throw new Exception("Tag is empty");
      }
      return array(TagInstancePeer::newTagInstance($sTag, $_REQUEST['model_name'], $_REQUEST['tagged_item_id']));
    } catch(Exception $e) {}
    return array();
  }
  
  private function removeTag() {
    try {
      if(!$this->mayEditTag()) {
        throw new Exception("You don't have the permissions to edit this tag");
      }
      $sTag = $_REQUEST['tag'];
      $oTag = TagPeer::retrieveByName($sTag);
      if($oTag === null) {
        throw new Exception("Tag does not exist");
      }
      $oTagInstance = TagInstancePeer::retrieveByPk($oTag->getId(), $_REQUEST['tagged_item_id'], $_REQUEST['model_name']);
      if($oTagInstance === null) {
        throw new Exception("There is no instance of the tag for this model/id");
      }
      $oTagInstance->delete();
    } catch(Exception $e) {}
    return array();
  }
  
  public function hasSearch() {
    return true;
  }
  
  private static function mayEditTag() {
    return !($_REQUEST['model_name'] === "Page" && !Session::getSession()->getUser()->mayEditPageDetails(PagePeer::retrieveByPk($_REQUEST['tagged_item_id'])));
  }
}
