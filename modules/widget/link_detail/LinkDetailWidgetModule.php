<?php
/**
 * @package modules.widget
 */
class LinkDetailWidgetModule extends PersistentWidgetModule {

	private $iLinkId = null;
	
	public function setLinkId($iLinkId) {
		$this->iLinkId = $iLinkId;
	}
	
	public function linkData() {
		$oLink = LinkQuery::create()->findPk($this->iLinkId);
		if($oLink === null) {
			return array();
		}
		$aResult = $oLink->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oLink);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oLink);
		return $aResult;
	}
	
	private function validate($aLinkData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aLinkData);
		$oFlash->checkForValue('name', 'name_required');
		$oFlash->checkForValue('url', 'url_required');
		$oFlash->finishReporting();
	}
	
	public function saveData($aLinkData) {
		if($this->iLinkId === null) {
			$oLink = new Link();
		} else {
			$oLink = LinkQuery::create()->findPk($this->iLinkId);
		}
		$oLink->setUrl(LinkUtil::getUrlWithProtocolIfNotSet($aLinkData['url']));
		$oLink->setName($aLinkData['name']);
		$oLink->setLinkCategoryId($aLinkData['link_category_id'] == null ? null : $aLinkData['link_category_id']);
		$oLink->setDescription($aLinkData['description']);
		if(isset($aLinkData['language_id'])) {
  		$oLink->setLanguageId($aLinkData['language_id'] != null ? $aLinkData['language_id'] : null);
		}
		$this->validate($aLinkData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		if($oLink->getLinkCategoryId() != null) {
			if($oLink->isNew() || $oLink->isColumnModified(LinkPeer::LINK_CATEGORY_ID)) {
				$oLink->setSort(LinkQuery::create()->filterByLinkCategoryId($oLink->getLinkCategoryId())->count() + 1);
			} 
		}
		$oLink->setIsInactive(isset($aLinkData['is_inactive']));
		$oLink->save();
		return $oLink->getId();
	}
}