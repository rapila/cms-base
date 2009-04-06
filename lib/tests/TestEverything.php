<?php
/**
 * @package test
 */
class TestEverything {
  public static function suite() {
    $oResult = new PHPUnit_Framework_TestSuite("Complete test suite");
    foreach(ResourceFinder::getFolderContents(dirname(__FILE__)) as $sFileName => $sFilePath) {
      if(Util::endsWith($sFileName, ".php") && Util::startsWith($sFileName, "Test") && !Util::startsWith($sFileName, "TestUtil") && $sFilePath !== __FILE__) {
        require_once($sFilePath);
        $oResult->addTest(call_user_func(array(substr($sFileName, 0, -strlen('.php')), "suite")));
      }
    }
    return $oResult;
  }
}