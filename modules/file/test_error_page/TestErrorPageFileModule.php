<?php
class TestErrorPageFileModule extends FileModule {
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		if(ErrorHandler::getEnvironment() === 'production') {
			exit;
		}
	}

	public function renderFile() {
		ErrorHandler::displayErrorMessage(array('message' => 'custom'));
	}
}