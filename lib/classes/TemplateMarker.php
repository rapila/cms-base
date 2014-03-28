<?php
class TemplateMarker {
	public $oTemplate;
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
	public function destroy() {
		$this->oTemplate->replaceAt($this, null);
		$this->oTemplate = null;
	}
	public function __toString() { return '--marker--'; }
}
