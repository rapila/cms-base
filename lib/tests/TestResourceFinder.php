<?php
/**
 * @package test
 */
class TestResourceFinder {
  public static function suite() {
    $oResult = new PHPUnit_Framework_TestSuite("ResourceFinder test suite");
    foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
      if(StringUtil::endsWith($sFileName, "Tests.php") && (StringUtil::startsWith($sFileName, "ResourceFinder") || StringUtil::startsWith($sFileName, "FileResource"))) {
        $oResult->addTestFile($sFileName);
      }
    }
    return $oResult;
  }
}