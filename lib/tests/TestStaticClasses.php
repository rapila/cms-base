<?php
/**
 * @package test
 */
class TestStaticClasses {
	public static function suite() {
		$oResult = new PHPUnit\Framework\TestSuite("Template test suite");
		foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
			if(StringUtil::endsWith($sFileName, "Tests.php") && (StringUtil::startsWith($sFileName, "PasswordHash") || StringUtil::startsWith($sFileName, "Util") || StringUtil::startsWith($sFileName, "Static"))) {
				$oResult->addTestFile($sFilePath);
			}
		}
		return $oResult;
	}
}