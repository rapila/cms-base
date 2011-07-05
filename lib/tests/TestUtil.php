<?php
/**
 * @package test
 */
class TestUtil {
	public static function suite() {
		$oResult = new PHPUnit_Framework_TestSuite("Util test suite");
		foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
			if(StringUtil::endsWith($sFileName, "Tests.php") && StringUtil::startsWith($sFileName, "Util")) {
				$oResult->addTestFile($sFileName);
			}
		}
		return $oResult;
	}
}