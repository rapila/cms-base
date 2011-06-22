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
}

