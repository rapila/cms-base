<?php
/**
 * @package modules.widget
 */
class DocumentCategoryManagedInputWidgetModule extends WidgetModule {
	
	private $bInternallyManagedOnly;
	
	public function __construct($sSessionKey, $sDefaultSelection = true) {
		parent::__construct($sSessionKey);
		$this->bInternallyManagedOnly = $sDefaultSelection;
	}
	
	public function getElementType() {
		return new TagWriter('input', array('type' => 'checkbox', 'name' => 'internally_managed_only', 'checked' => ($this->bInternallyManagedOnly ? 'checked' : '')));
	}
}
