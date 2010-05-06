<?php

abstract class FileModule extends Module {
	protected static $MODULE_TYPE = 'file';
	
	protected $aPath;
	
	public function __construct($aRequestPath) {
		$this->aPath = $aRequestPath;
	}
	
	public abstract function renderFile();
}