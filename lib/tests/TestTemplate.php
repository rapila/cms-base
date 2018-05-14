<?php
/**
 * @package test
 */
class TestTemplate {
	public static function suite() {
		$oResult = new PHPUnit\Framework\TestSuite("Template test suite");
		foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
			if(StringUtil::endsWith($sFileName, "Tests.php") && StringUtil::startsWith($sFileName, "Template")) {
				$oResult->addTestFile($sFilePath);
			}
		}
		return $oResult;
	}
}