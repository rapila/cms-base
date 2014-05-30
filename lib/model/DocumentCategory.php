<?php

require_once 'model/om/BaseDocumentCategory.php';


/**
 * @package model
 */ 
class DocumentCategory extends BaseDocumentCategory {
	
	public function getDocumentCount() {
		return $this->countDocuments();
	}
	
	public function getNameWithExternallyManagedState() {
		if($this->getIsExternallyManaged() === false) {
			return $this->getName();
		}
		return $this->getName().' [!]';
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
		if($this->getDocumentCount() == 0) {
			$aArray[] = StringPeer::getString('wns.none');
		} else if($this->getDocumentCount() === 1) {
			$aArray[] = $this->getDocumentCount().' '.StringPeer::getString('wns.document');
		} else {
			$aArray[] = $this->getDocumentCount().' '.StringPeer::getString('wns.documents');
		}
		$aArray[] = LinkUtil::link(array('documents'), 'AdminManager', array('document_category_id' => $this->getId()));
		return $aArray;
	}

}

