<?php
/**
 * @package test
 */
class TestTemplate {
  public static function suite() {
    $oResult = new PHPUnit_Framework_TestSuite("Template test suite");
    foreach(Util::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
      if(Util::endsWith($sFileName, "Tests.php") && Util::startsWith($sFileName, "Template")) {
        $oResult->addTestFile($sFileName);
      }
    }
    return $oResult;
  }
}