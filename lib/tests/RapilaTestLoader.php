<?php
/**
 * @package test
 */
require_once 'base/lib/inc.php';

Cache::clearAllCaches();

spl_autoload_register(function($sClassName) {
	$sFileName = "$sClassName.php";
	$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, 'tests', $sFileName)->find();
	if($sPath !== null) {
		require $sPath;
		return true;
	}
});
