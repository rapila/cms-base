<?php
/**
 * @package modules.widget
 */
class TagDetailWidgetModule extends PersistentWidgetModule {
	private $iTagId = null;
	const SIDEBAR_CHANGED = 'sidebar_changed';
	
	public function setTagId($iTagId) {
		$this->iTagId = $iTagId;
	}
	
	public function getTagString($sLanguageId) {
		$oTag = TagQuery::create()->findPk($this->iTagId);
		if($oTag === null) {
			return null;
		}
		$sTagName = $oTag->getName();
		return TranslationPeer::getString("tag.$sTagName", $sLanguageId, '');
	}
	
	public function tagData() {
		$oTag = TagQuery::create()->findPk($this->iTagId);
		if($oTag === null) {
			$oTag = new Tag();
		}
		$aResult = $oTag->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oTag);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oTag);
		$aResult['tagged_models_and_items'] = array();
		foreach($oTag->getTagInstances() as $oTagInstance) {
			$oCorrObject = $oTagInstance->getCorrespondingDataEntry();
			if($oCorrObject) {
				$aResult['tagged_models_and_items'][] = array('name' => Util::nameForObject($oCorrObject), 'tagged_item_id' => $oTagInstance->getTaggedItemId(), 'model_name' => $oTagInstance->getModelName());
			} else {
				$oTagInstance->delete();
			}
		}
		return $aResult;
	}
	
	public function deleteTaggedItem($iTagId, $iTaggedItemId, $sModelName) {
		$oResult = new stdClass();
		$oResult->removed = true;
		$oResult->model_removed = false;
		$oTagInstance = TagInstanceQuery::create()->findPk(array($iTagId, $iTaggedItemId, $sModelName));
		if($oTagInstance) {
			$sModelName = $oTagInstance->getModelName();
			$oTagInstance->delete();
			$oResult->model_removed = TagInstanceQuery::create()->filterByModelName($sModelName)->count() === 0;
		}
		return $oResult;
	}
	
	private function validate($aTagData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aTagData);
		$oFlash->checkForValue('name', 'tag_name_required');
		$oCriteria = TagQuery::create()->filterByName($aTagData['name']);
		if($this->iTagId !== null) {
			$oCriteria->exclude($this->iTagId);
		}
		if($oCriteria->count() > 0) {
			$oFlash->addMessage('tag_name_exists');
		}
		$oFlash->finishReporting();
	}
	
	public function saveData($aTagData) {
		$aTagData['name'] = StringUtil::normalize($aTagData['name']);
		if($this->iTagId === null) {
			$oTag = new Tag();
		} else {
			$oTag = TagQuery::create()->findPk($this->iTagId);
		}
		$this->validate($aTagData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$sStringName = "tag.{$aTagData['name']}";
		if($oTag->getName() !== $aTagData['name']) {
			//Rename Strings for the tag
			$sOldStringName = "tag.{$oTag->getName()}";
			foreach(TranslationQuery::create()->filterByStringKey($sOldStringName)->find() as $oString) {
				$sLanguageId = $oString->getLanguageId();
				//You can’t technically rename strings because string_key is the PKEY so we delete it and re-generate
				$oString->delete();
				$oString = new Translation();
				$oString->setStringKey($sStringName);
				$oString->setLanguageId($sLanguageId);
				$oString->save();
			}
			$oTag->setName($aTagData['name']);
		}
		foreach($aTagData['edited_languages'] as $iIndex => $sLanguageId) {
			TranslationPeer::addOrUpdateString($sStringName, $aTagData['text'][$iIndex], $sLanguageId);
		}
		$oTag->save();
	}
}