<?php
class TemplateMarker extends TemplatePart {
	public $aContents;
	public $bIsContext;

	public function __construct($oTemplate, $aContents, $bIsContext = false) {
		$this->oTemplate = $oTemplate;
		$this->aContents = array();
		foreach($aContents as $mContent) {
			if($mContent instanceof TemplateIdentifier) {
				$mContent = clone $mContent;
			}
			$this->aContents[] = $mContent;
		}
		$this->bIsContext = $bIsContext;
	}

	public function replace() {
		$this->oTemplate->replaceAt($this, $this->aContents);
		$this->oTemplate = null;
	}

	public function __toString() { return '--marker--'; }

	public function __sleep() {
		$aVars = get_object_vars($this);
		unset($aVars['oTemplate']);
		return array_keys($aVars);
	}
}
