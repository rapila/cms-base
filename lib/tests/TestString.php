<?php
/**
 * @package test
 */
class TestString {
  public static function suite() {
    $oResult = new PHPUnit_Framework_TestSuite("String test suite");
    foreach(Util::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
      if(Util::endsWith($sFileName, "Tests.php") && Util::startsWith($sFileName, "String")) {
        $oResult->addTestFile($sFileName);
      }
    }
    return $oResult;
  }
}