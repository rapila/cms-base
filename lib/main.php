<?php
try {
	require_once 'inc.php';
	set_error_handler(array('ErrorHandler', "handleError"));
	$oManager = Manager::getManager();
	$oManager->render();
	Autoloader::saveIncludeCache();
} catch (Exception $oException) {
	ErrorHandler::handleException($oException);
}