<?php

abstract class TemplatePart {
	protected $oTemplate;

	public function destroy() {
		if(!($this->oTemplate instanceof Template)) {
			ErrorHandler::log($this);
			ErrorHandler::trace();
		}
		$this->oTemplate->replaceAt($this, null);
		$this->oTemplate = null;
	}
	public function setTemplate($oTemplate) {
		$this->oTemplate = $oTemplate;
	}
	public abstract function __toString();
}
