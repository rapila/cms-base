<?php

abstract class TemplatePart {
	protected $oTemplate;

	public function destroy() {
		$this->oTemplate->replaceAt($this, null);
		$this->oTemplate = null;
	}
	public function setTemplate(Template $oTemplate) {
		$this->oTemplate = $oTemplate;
	}
	public abstract function __toString();
}
