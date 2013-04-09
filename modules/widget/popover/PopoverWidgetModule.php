<?php
class PopoverWidgetModule extends PersistentWidgetModule {
	private $oDelegate;
	
	public function __construct($sSessionKey = null, $oDelegate) {
		parent::__construct($sSessionKey);
		$this->oDelegate = $oDelegate;
	}

	public function popoverContents() {
		$aContents = $this->oDelegate->popoverContents($this);
		foreach($aContents as $iKey => $mValue) {
			if($mValue instanceof TagWriter) {
				$mValue = $mValue->parse();
			}
			if($mValue instanceof Template) {
				$mValue = $mValue->render();
			}
			if(is_object($mValue)) {
				$mValue = $mValue->__toString();
			}
			$aContents[$iKey] = $mValue;
		}
		return $aContents;
	}

	public function getElementType() {
		return "input";
	}
	
	public static function includeResources($oResourceIncluder = null) {
		if($oResourceIncluder === null) {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$oResourceIncluder->addResource('widget/popover/jquery.popover.js');
		$oResourceIncluder->addResource(array(DIRNAME_WEB, 'js', 'widget', 'popover', 'jquery.popover.css'));
		self::includeWidgetResources(false, $oResourceIncluder);
	}
}
