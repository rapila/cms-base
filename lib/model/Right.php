<?php

require_once 'model/om/BaseRight.php';


/**
 * @package model
 */ 
class Right extends BaseRight {
	
	/**
	* Returns whether the right allows editing the page structure (creating, moving and deleting objects).
	* Currently aliased to may_edit_page_contents
	*/
	public function getMayEditPageStructure() {
		return $this->getMayEditPageContents();
	}
	
	public function rightFits($mPage, $sMethodName) {
		$oPage = $mPage;
		if($mPage instanceof Page) {
			$mPage = $mPage->getId();
		}
		if($this->getPage() !== null && $mPage === $this->getPage()->getId()) {
			return call_user_func(array($this, $sMethodName));
		}
		if($this->getIsInherited() && $mPage !== null) {
			if(!is_object($oPage)) {
				$oPage = PagePeer::retrieveByPK($mPage);
			}
			if($oPage !== null && $oPage->getParent() !== null) {
				return $this->rightFits($oPage->getParent(), $sMethodName);
			}
		}
		return false;
	}
}

