<?php
/**
 * @package modules.widget
 */
class LinkDetailWidgetModule extends PersistentWidgetModule {

	private $iLinkId = null;
	
	public function setLinkId($iLinkId) {
		$this->iLinkId = $iLinkId;
	}
	
	public function getLinkData() {
		$oLink = LinkPeer::retrieveByPK($this->iLinkId);
		if($oLink === null) {
			return array();
		}
		$aResult = $oLink->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['CreatedInfo'] = Util::formatCreatedAtForAdmin($oLink).' / '.Util::getCreatedByIfSet($oLink);
		$aResult['UpdatedInfo'] = Util::formatUpdatedAtForAdmin($oLink).' / '.Util::getUpdatedByIfSet($oLink);
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
			$oLink = LinkPeer::retrieveByPK($this->iLinkId);
		}
		$this->validate($aLinkData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}

		$oLink->setUrl(LinkUtil::getUrlWithProtocolIfNotSet($aLinkData['url']));
		$oLink->setName($aLinkData['name']);
		$oLink->setLinkCategoryId($aLinkData['link_category_id']);
		$oLink->setDescription($aLinkData['description']);
		$oLink->setIsInactive(isset($aLinkData['is_inactive']));
		return $oLink->save();
	}
}