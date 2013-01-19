<?php
/**
 * @package modules.widget
 */
class ExternallyManagedInputWidgetModule extends WidgetModule {
	
	private $bExcludeExternallyManaged;
	
	public function __construct($sDefaultSelection = true) {
		$this->bExcludeExternallyManaged = $sDefaultSelection;
	}
	
	public function getElementType() {
		return new TagWriter('input', array('type' => 'checkbox', 'name' => 'exclude_externally_managed', 'checked' => ($this->bExcludeExternallyManaged ? 'checked' : '')));
	}
}
