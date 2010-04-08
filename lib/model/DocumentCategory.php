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
}

