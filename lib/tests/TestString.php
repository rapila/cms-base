<?php
/**
 * @package test
 */
class TestString {
	public static function suite() {
		$oResult = new PHPUnit_Framework_TestSuite("String test suite");
		foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
			if(StringUtil::endsWith($sFileName, "Tests.php") && StringUtil::startsWith($sFileName, "String")) {
				$oResult->addTestFile($sFilePath);
			}
		}
		return $oResult;
	}
}