<?php
/**
 * @package modules.frontend
 */

class LinkListFrontendModule extends DynamicFrontendModule {
  
  const LIST_ITEM_POSTFIX = '_item';
  
  public function renderFrontend() {
    $aOptions = @unserialize($this->getData());
    $oCriteria = new Criteria();
    $bOneTagnameOnly = true;
    if(isset($aOptions['tags']) && is_array($aOptions['tags']) && (count($aOptions['tags']) > 0)) {
      $aLinks = LinkPeer::getLinksByTagName($aOptions['tags']);
      $bOneTagnameOnly = count($aOptions['tags']) === 1;
    } else {
      $aLinks = LinkPeer::getLinksSorted();
    }
    
    try {
      $oListTemplate = new Template($aOptions['list_template']);
      if($bOneTagnameOnly) {
        $oListTemplate->replaceIdentifier('tag_name', $aOptions['tags'][0]);
      }
      foreach($aLinks as $i => $oLink) {
        $oItemTemplate = new Template($aOptions['list_template'].self::LIST_ITEM_POSTFIX);
        $oItemTemplate->replaceIdentifier('name', $oLink->getName());
        $oItemTemplate->replaceIdentifier('description', $oLink->getDescription());
        $oItemTemplate->replaceIdentifier('url', $oLink->getUrl());
        $oListTemplate->replaceIdentifierMultiple('items', $oItemTemplate);
      }
    } catch(Exception $e) {
      $oListTemplate = new Template("", null, true);
    }
    return $oListTemplate;
  }

  
  public function renderBackend() {
    $aOptions = @unserialize($this->getData());
    $aListTags = TagPeer::getTagsUsedInModel('Link');
    $oTemplate = $this->constructTemplate('backend');
    $oTemplate->replaceIdentifier('tags', TagWriter::optionsFromObjects($aListTags, 'getName', 'getName', @$aOptions['tags'], false));
    if(isset($aOptions['tags']) && is_array($aOptions['tags'])) {
      foreach($aOptions['tags'] as $sTagName) {
        $oTemplate->replaceIdentifierMultiple('links_edit_link', TagWriter::quickTag('a', array('href' => LinkUtil::link(array('links'), 'BackendManager', array('selected_tag_name' => $sTagName))), StringPeer::getString('edit_module', null, null,array('module_name' => StringPeer::getString('links'))).(' ['.$sTagName.']')));
      }
    }
    $aListTemplates = BackendManager::getSiteTemplatesForListOutput(self::LIST_ITEM_POSTFIX);
    $oTemplate->replaceIdentifier('list_templates', TagWriter::optionsFromArray($aListTemplates, @$aOptions['list_template'], false));
    return $oTemplate;
  } 
  
  public function save(Blob $oData) {
    $_POST['tags'] = is_array($_POST['tags']) ? $_POST['tags'] : array($_POST['tags']);
    $oData->setContents(serialize(array('tags' => $_POST['tags'], 'list_template' => $_POST['list_template'])));
  }
}
