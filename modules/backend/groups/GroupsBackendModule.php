<?php
/**
 * @package modules.backend
 */
class GroupsBackendModule extends BackendModule {
  
  private $oGroup = null;
  private $sNameSpace = null;
  
  public function __construct() { 
    if(Manager::hasNextPathItem()) {
      $this->oGroup = GroupPeer::retrieveByPk(Manager::usePath());
    }
  }
  
  public function getChooser() {
    $sSearch = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : null;
    $aGroups = GroupPeer::getGroupsBySearch($sSearch);

    $oTemplate = $this->constructTemplate("list");
    $oGroupTemplatePrototype = $this->constructTemplate("list_item");
    
    foreach($aGroups as $oGroup) {
      $oGroupTemplate = clone $oGroupTemplatePrototype;
      $oGroupTemplate->replaceIdentifier("link", $this->link($oGroup->getId()));
      $oGroupTemplate->replaceIdentifier("name", $oGroup->getName());
      if($this->oGroup && ($this->oGroup->getId() == $oGroup->getId())) {
        $oGroupTemplate->replaceIdentifier('class_active', ' active');
      }
      $oTemplate->replaceIdentifierMultiple("result", $oGroupTemplate);
    }
    return $oTemplate;
  }
  
  public function getDetail() {
    if($this->oGroup === null) {
      $oTemplate = $this->constructTemplate("module_info");
      $oTemplate->replaceIdentifier('create_link', TagWriter::quickTag('a', array('href' => LinkUtil::link('groups', null, array('action' => 'create'))), StringPeer::getString('group.create')));
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate("detail");
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'help', 'href' => LinkUtil::link('groups', null, array('get_module_info' => 'true')))));
    
    if($this->oGroup->getId() !== null) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring("delete_item", array('name' => $this->oGroup->getName()));
      $oDeleteTemplate->replaceIdentifier("action", $this->link($this->oGroup->getId()));
      $oDeleteTemplate->replaceIdentifier("delete_icon", 'delete');
      $oDeleteTemplate->replaceIdentifier("delete_label", StringPeer::getString('delete'));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    
    $oTemplate->replaceIdentifier("id", $this->oGroup->getId());
    $oTemplate->replaceIdentifier("action", $this->link($this->oGroup->getId()));
    $oTemplate->replaceIdentifier("name", $this->oGroup->getName());

    $oGroupRightPartTemplate = $this->constructTemplate('group_right_part');
    $aRights = $this->oGroup->getRightsJoinPage();
    $aPages = PagePeer::getRootPage()->getTree(true);
    foreach($aRights as $oRight) {
      $oRightTemplate = $this->constructTemplate("group_rights");
      $oRightTemplate->replaceIdentifier("options_pages", TagWriter::optionsFromArray($aPages, $oRight->getPageId()));
      $oRightTemplate->replaceIdentifier("right_id", $oRight->getId());
      $oRightTemplate->replaceIdentifier("may_edit_page_details", $oRight->getMayEditPageDetails() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
      $oRightTemplate->replaceIdentifier("may_edit_page_contents", $oRight->getMayEditPageContents() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
      $oRightTemplate->replaceIdentifier("may_create_children", $oRight->getMayCreateChildren() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
      $oRightTemplate->replaceIdentifier("may_delete", $oRight->getMayDelete() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
      $oRightTemplate->replaceIdentifier("may_view_page", $oRight->getMayViewPage() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
      $oRightTemplate->replaceIdentifier("is_inherited", $oRight->getIsInherited() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
      $oGroupRightPartTemplate->replaceIdentifierMultiple("group_rights", $oRightTemplate);
    }
    $oTemplate->replaceIdentifier("group_rights_part", $oGroupRightPartTemplate);
    
    //Clone area (prototype)
    $oRightTemplate = $this->constructTemplate("group_rights");
    $oRightTemplate->replaceIdentifier("options_pages", TagWriter::optionsFromArray($aPages));
    $oRightTemplate->replaceIdentifier("right_id", "new_");
    $oTemplate->replaceIdentifierMultiple("group_right", $oRightTemplate);

    return $oTemplate;
  }
  
  public function create() {
    $this->oGroup = new Group();
    $this->oGroup->setCreatedAt(date('c'));
    $this->oGroup->setCreatedBy(Session::getSession()->getUserId());
  }
  
  public function delete() {
    if($this->oGroup !== null) {
      $this->oGroup->delete();
      $this->oGroup=null;
    }
  }

  public function validateForm($oFlash) {
    $oFlash->checkForValue('name');
  }

  public function save() {
    if($this->oGroup === null) {
      $this->create();
    }
    if(isset($_POST['submit'])) {
      $this->oGroup->fromArray($_POST, BasePeer::TYPE_PHPNAME);
    }
    $this->oGroup->setName($_POST['name']);
    
    if(!$this->oGroup->isNew()) {
      foreach($this->oGroup->getRightsJoinPage() as $oRights) {
      }
    }
    
    //Rights
    if (isset($_POST['right_numbers'])) {
      $aRights = array();
      foreach($_POST['right_numbers'] as $iRightId) {
        $iPageId = $_POST['page_id_'.$iRightId];
        $oRight = RightPeer::retrieveByPk($iRightId);
        if ($oRight === null) {
          $oRight = new Right();
        }

        $oRight->setPageId($iPageId);
        $oPage = PagePeer::retrieveByPk($iPageId);
        $oRight->setGroup($this->oGroup);
        $oRight->setMayCreateChildren(isset($_POST['may_create_children_'.$iRightId]));
        $oRight->setMayEditPageDetails(isset($_POST['may_edit_page_details_'.$iRightId]));
        $oRight->setMayEditPageContents(isset($_POST['may_edit_page_contents_'.$iRightId]));
        $oRight->setMayDelete(isset($_POST['may_delete_'.$iRightId]));
        $oRight->setMayViewPage(isset($_POST['may_view_page_'.$iRightId]));
        $oRight->setIsInherited(isset($_POST['is_inherited_'.$iRightId]));
        
        if ((!$oRight->getMayCreateChildren() && !$oRight->getMayEditPageDetails() && !$oRight->getMayEditPageContents() && !$oRight->getMayDelete() && !$oRight->getMayViewPage()) || $oPage === null) {
          $oRight->delete();
          continue;
        } else {
          $sRightKey = $oRight->getPageId().($oRight->getIsInherited() ? "_inherited" : "_uninherited");
          if (!isset($aRights[$sRightKey])) {
            $aRights[$sRightKey] = $oRight;
          } else {
            $oOtherRight = $aRights[$sRightKey];
            $oOtherRight->setMayCreateChildren($oOtherRight->getMayCreateChildren() || $oRight->getMayCreateChildren());
            $oOtherRight->setMayEditPageDetails($oOtherRight->getMayEditPageDetails() || $oRight->getMayEditPageDetails());
            $oOtherRight->setMayDelete($oOtherRight->getMayDelete() || $oRight->getMayDelete());
            $oOtherRight->setMayViewPage($oOtherRight->getMayViewPage() || $oRight->getMayViewPage());
            $oOtherRight->setIsInherited($oOtherRight->getIsInherited() || $oRight->getIsInherited());
            $oRight->delete();
            continue;
          }
        }
      }
      if(Flash::noErrors()) {
        foreach($aRights as $oRight) {
          $oRight->save();
        }
      }
    }
    
    if(Flash::noErrors()) {
      $this->oGroup->setUpdatedAt(date('c'));
      $this->oGroup->setUpdatedBy(Session::getSession()->getUserId());
      $this->oGroup->save();
      LinkUtil::redirect($this->link($this->oGroup->getId()));
    }
  }
  
  public function hasSearch() {
    return true;
  }
  
  public function getNewEntryActionParams() {
    return array('action' => $this->link());
  }
}
