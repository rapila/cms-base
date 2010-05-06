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
		$aResult = $oLink->toArray(BasePeer::TYPE_PHPNAME, false);
		$aResult['CreatedInfo'] = $oLink->getCreatedAtFormatted().' / '.($oLink->getUserRelatedByCreatedBy() ? $oLink->getUserRelatedByCreatedBy()->getUserName() : '');
		$aResult['UpdatedInfo'] = $oLink->getUpdatedAtFormatted().' / '.($oLink->getUserRelatedByUpdatedBy() ? $oLink->getUserRelatedByUpdatedBy()->getUserName() : '');
		return $aResult;
	}
	
	public function saveData($aLinkData) {
		if($this->iLinkId === null) {
			$oLink = new Link();
		} else {
			$oLink = LinkPeer::retrieveByPK($this->iLinkId);
		}
		$oLink->setUrl(LinkUtil::getUrlWithProtocolIfNotSet($aLinkData['url']));
		$oLink->setName($aLinkData['name']);
		$oLink->setLinkCategoryId($aLinkData['link_category_id']);
		$oLink->setDescription($aLinkData['description']);
		$oLink->setIsInactive(isset($aLinkData['is_inactive']));
		return $oLink->save();
	}
}