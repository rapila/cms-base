<?php
/**
 * @package test
 */
require_once 'base/lib/inc.php';

Cache::clearAllCaches();

if(!class_exists('PHPUnit_Framework_TestSuite')) {
	class_alias('PHPUnit\\Framework\\TestSuite', 'PHPUnit_Framework_TestSuite');
	class_alias('PHPUnit\\Framework\\TestCase', 'PHPUnit_Framework_TestCase');
}

spl_autoload_register(function($sClassName) {
	$sFileName = "$sClassName.php";
	$sPath = ResourceFinder::create()->addPath(DIRNAME_LIB, 'tests', $sFileName)->find();
	if($sPath !== null) {
		require $sPath;
		return true;
	}
});
