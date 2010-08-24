<?php
/**
 * @package modules.frontend
 */

class LinkListFrontendModule extends DynamicFrontendModule {
	
	const LIST_ITEM_POSTFIX = '_item';
	
	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		$oCriteria = new Criteria();
		$bOneTagnameOnly = false;
		if(isset($aOptions['tags']) && is_array($aOptions['tags']) && (count($aOptions['tags']) > 0)) {
			$aLinks = LinkPeer::getLinksByTagName($aOptions['tags']);
			$bOneTagnameOnly = count($aOptions['tags']) === 1;
		} else {
			$aLinks = LinkPeer::getLinksSorted();
		}
		try {
			$oListTemplate = new Template($aOptions['list_template']);
			if($bOneTagnameOnly) {
        $oListTemplate->replaceIdentifier('tag_name', StringPeer::getString('tagname.'.$aOptions['tags'][0], null, $aOptions['tags'][0]));
			}
			foreach($aLinks as $i => $oLink) {
				$oItemTemplate = new Template($aOptions['list_template'].self::LIST_ITEM_POSTFIX);
				$oItemTemplate->replaceIdentifier('model', 'Link');
				$oItemTemplate->replaceIdentifier('name', $oLink->getName());
				$oItemTemplate->replaceIdentifier('link_text', $oLink->getName());
				$oItemTemplate->replaceIdentifier('title', $oLink->getName());
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
		$aListTags = TagPeer::doSelect(TagPeer::getTagsUsedInModelCriteria('Link'));
		$aListCategories = LinkCategoryPeer::doSelect(new Criteria());
		$oTemplate = $this->constructTemplate('backend');
		if(count($aListTags) > 0) {
			$oTemplate->replaceIdentifier('tags', TagWriter::optionsFromObjects($aListTags, 'getName', 'getName', @$aOptions['tags'], false));
		}
		if(count($aListCategories) > 0) {
			$oTemplate->replaceIdentifier('categories', TagWriter::optionsFromObjects($aListCategories, 'getId', 'getName', @$aOptions['categories'], false));
		}
		if(isset($aOptions['tags']) && is_array($aOptions['tags'])) {
			foreach($aOptions['tags'] as $sTagName) {
				$oTemplate->replaceIdentifierMultiple('links_edit_link', TagWriter::quickTag('a', array('class' => 'edit_related_link highlight', 'href' => LinkUtil::link(array('links'), 'AdminManager', array('selected_tag_name' => $sTagName))), StringPeer::getString('edit_module', null, null,array('module_name' => StringPeer::getString('links'))).(' ['.$sTagName.']')));
			}
		}
		if(isset($aOptions['categories']) && is_array($aOptions['categories'])) {
			foreach($aOptions['categories'] as $iCategoryId) {
				$oTemplate->replaceIdentifierMultiple('links_edit_link', TagWriter::quickTag('a', array('class' => 'edit_related_link highlight', 'href' => LinkUtil::link(array('links'), 'AdminManager', array('link_category_id' => $iCategoryId))), StringPeer::getString('edit_module', null, null,array('module_name' => StringPeer::getString('links'))).(' ['.$iCategoryId.']')));
			}
		}
		$aListTemplates = BackendManager::getSiteTemplatesForListOutput(self::LIST_ITEM_POSTFIX);
		$oTemplate->replaceIdentifier('list_templates', TagWriter::optionsFromArray($aListTemplates, @$aOptions['list_template'], false));
		return $oTemplate;
	} 
	
	public function getSaveData() {
		$aData = array('list_template' => $_POST['list_template']);
		if(isset($_POST['tags'])) {
			$_POST['tags'] = is_array($_POST['tags']) ? $_POST['tags'] : array($_POST['tags']);
			$aData = array_merge($aData, $_POST['tags']);
		}
		if(isset($_POST['categories'])) {
			$_POST['categories'] = is_array($_POST['categories']) ? $_POST['categories'] : array($_POST['categories']);
			$aData = array_merge($aData, $_POST['categories']);
		}
		return serialize($aData);
	}
}
