<?php

require_once 'model/om/BaseDocumentCategory.php';


/**
 * @package model
 */	
class DocumentCategory extends BaseDocumentCategory {
	
	public function getDocumentCount() {
		return $this->countDocuments();
	}
	
	public function getExtras() {
		if($this->getMaxWidth() != null) {
			return $this->getMaxWidth().'px';
		}
	}
	
	public function getDocumentLinkData() {
		$aArray = array();
		$aArray[] = $this->getDocumentCount().' '.StringPeer::getString('documents');
		$aArray[] = LinkUtil::link(array('documents'), 'AdminManager', array('document_category_id' => $this->getId()));
		return $aArray;
	}
}

