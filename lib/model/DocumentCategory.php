<?php

require_once 'model/om/BaseDocumentCategory.php';


/**
 * @package model
 */ 
class DocumentCategory extends BaseDocumentCategory {
	
	public function getDocumentCount() {
		return $this->countDocuments();
	}
	
	public function getSettings() {
		if($this->getMaxWidth() != null) {
			return $this->getMaxWidth().'px';
		}
	}
	
	public function getTitle() {
		$iCount = $this->countDocuments();
		return $this->getName().' ['.($iCount === 0 ? '-' : $iCount).']';
	}
	
	public function getLinkToDocumentData() {
		$aArray = array();
		$aArray[] = $this->getDocumentCount().' '.StringPeer::getString('wns.documents');
		$aArray[] = LinkUtil::link(array('documents'), 'AdminManager', array('document_category_id' => $this->getId()));
		return $aArray;
	}
}

