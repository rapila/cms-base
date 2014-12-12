<?php
/**
 * @package modules.widget
 * description: general usage for custom list filtering
 */
class BooleanInputWidgetModule extends PersistentWidgetModule {
	
	private $bIsTrue;
	
	public function __construct($sSessionKey = null, $sDefaultSelection = true) {
		parent::__construct($sSessionKey);
		$this->bIsTrue = $sDefaultSelection;
	}
	
	public function getElementType() {
		return new TagWriter('input', array('type' => 'checkbox', 'name' => 'yes_or_no', 'checked' => ($this->bIsTrue ? 'checked' : '')));
	}
}