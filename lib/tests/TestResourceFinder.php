<?php
/**
 * @package test
 */
class TestResourceFinder {
	public static function suite() {
		$oResult = new PHPUnit\Framework\TestSuite("ResourceFinder test suite");
		foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
			if(StringUtil::endsWith($sFileName, "Tests.php") && (StringUtil::startsWith($sFileName, "ResourceFinder") || StringUtil::startsWith($sFileName, "FileResource") || StringUtil::startsWith($sFileName, "ResourceIncluder"))) {
				$oResult->addTestFile($sFilePath);
			}
		}
		return $oResult;
	}
}