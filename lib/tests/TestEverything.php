<?php
/**
 * @package test
 */
class TestEverything {
	public static function suite() {
		$oResult = new PHPUnit\Framework\TestSuite("Complete test suite");
		foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
			if(StringUtil::endsWith($sFileName, ".php") && StringUtil::startsWith($sFileName, "Test") && !StringUtil::startsWith($sFileName, "TestUtil") && $sFilePath !== __FILE__) {
				require_once($sFilePath);
				$oResult->addTest(call_user_func(array(substr($sFileName, 0, -strlen('.php')), "suite")));
			}
		}
		return $oResult;
	}
}