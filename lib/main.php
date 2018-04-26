<?php
/** @mainpage rapila: another PHP CMS
 * @section intro_sec The rapila CMS
 * Find out more at the <a href="http://rapi.la">web site</a>.
 * @section install_sec Installation
 * Installation is <a href="https://github.com/rapila/cms-base/wiki/Installation">documented</a> in the <a href="https://github.com/rapila/cms-base/wiki">Wiki</a>
 */
try {
	require_once 'inc.php';
	set_error_handler(array('ErrorHandler', "handleError"));
	$oManager = Manager::getManager();
	$oManager->render();
	Autoloader::saveIncludeCache();
} catch (Exception $oException) {
	if(!class_exists('ErrorHandler')) {
		var_dump($oException);
	} else {
		ErrorHandler::handleException($oException);
	}
}
