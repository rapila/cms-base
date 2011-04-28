<?php

require_once 'model/om/BaseRight.php';


/**
 * @package model
 */ 
class Right extends BaseRight {
	public function getMayEditPageStructure() {
		return $this->getMayEditPageContents();
	}
}

