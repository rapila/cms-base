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
	
	public function getTagData() {
		$oTag = TagPeer::retrieveByPK($this->iTagId);
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
	
	public function removeTaggedItem($mRemoveData) {
		$oTagInstance = TagInstancePeer::retrieveByPK($iTagId, $iTaggedItemId, $sModelName);
		if($oTagInstance) {
			$oTagInstance->delete();
		}
		return true;
	}
	
	private function validate($aTagData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aTagData);
		$oFlash->checkForValue('name', 'tag_name_required');
		if($this->iTagId !== null) {
			if(TagQuery::create()->filterByName($aTagData['name'])->count() > 0) {
				$oFlash->addMessage('tag_name_exists');
			}
		}
		$oFlash->finishReporting();
	}
	
	public function saveData($aTagData) {
		if($this->iTagId === null) {
			$oTag = new Document();
		} else {
			$oTag = TagPeer::retrieveByPK($this->iTagId);
		}
		$oTag->setName($aTagData['name']);
		$this->validate($aTagData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
	}
}