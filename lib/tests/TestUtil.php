<?php
/**
 * @package test
 */
class TestUtil {
  public static function suite() {
    $oResult = new PHPUnit_Framework_TestSuite("Util test suite");
    foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
      if(Util::endsWith($sFileName, "Tests.php") && Util::startsWith($sFileName, "Util")) {
        $oResult->addTestFile($sFileName);
      }
    }
    return $oResult;
  }
}