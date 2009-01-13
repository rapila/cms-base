<?php
/**
 * @package test
 */
class TestStaticClasses {
  public static function suite() {
    $oResult = new PHPUnit_Framework_TestSuite("Template test suite");
    foreach(Util::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
      if(Util::endsWith($sFileName, "Tests.php") && (Util::startsWith($sFileName, "PasswordHash") || Util::startsWith($sFileName, "Util") || Util::startsWith($sFileName, "Static"))) {
        $oResult->addTestFile($sFileName);
      }
    }
    return $oResult;
  }
}