<?php

abstract class TemplatePart {
	protected $oTemplate;

	public function destroy() {
		$this->oTemplate->replaceAt($this, null);
		$this->oTemplate = null;
	}
	public abstract function __toString();
}
