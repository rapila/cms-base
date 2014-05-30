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

	public function __sleep() {
		$aVars = get_object_vars($this);
		unset($aVars['oTemplate']);
		return array_keys($aVars);
	}

}
