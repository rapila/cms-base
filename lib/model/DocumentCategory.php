<?php

require_once 'model/om/BaseDocumentCategory.php';


/**
 * @package model
 */	
class DocumentCategory extends BaseDocumentCategory {
	
	public function getDocumentCount() {
		return $this->countDocuments();
	}

}

