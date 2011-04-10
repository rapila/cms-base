<?php

require_once 'model/om/BaseLinkCategory.php';

/**
 * @package		 model
 */
class LinkCategory extends BaseLinkCategory {

	public function getLinkCount() {
		return $this->countLinks();
	}
			
	public function getLinkToLinkData() {
		if($this->getLinkCount() == 0) {
			return '-';
		}
		$aArray = array();
		if($this->getLinkCount() === 1) {
			$aArray[] = $this->getLinkCount().' '.StringPeer::getString('wns.link');
		} else {
			$aArray[] = $this->getLinkCount().' '.StringPeer::getString('wns.links');
		}
		$aArray[] = LinkUtil::link(array('links'), 'AdminManager', array('link_category_id' => $this->getId()));
		return $aArray;
	}

}

