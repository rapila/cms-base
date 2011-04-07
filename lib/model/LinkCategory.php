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
		$aArray = array();
		$aArray[] = $this->getLinkCount().' '.StringPeer::getString('wns.links');
		$aArray[] = LinkUtil::link(array('links'), 'AdminManager', array('link_category_id' => $this->getId()));
		return $aArray;
	}

}

