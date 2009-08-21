<?php
/**
* @package test
*/

class ResourceFinderTests extends PHPUnit_Framework_TestCase {
  public function testFindMain() {
    $sMainPath = ResourceFinder::findResource(array('lib', 'main.php'));
    $this->assertSame(MAIN_DIR.'/base/lib/main.php', $sMainPath);
  }
  
  public function testFindMainAsObject() {
    $oMain = ResourceFinder::findResourceObject(array('lib', 'main.php'));
    $this->assertSame(MAIN_DIR.'/base/lib/main.php', $oMain->getFullPath());
  }
  
  public function testFindMainObjectEqual() {
    $oMain = ResourceFinder::findResourceObject(array('lib', 'main.php'));
    $this->assertEquals(new FileResource($oMain->getFullPath()), $oMain);
  }
  
  public function testFindMainSelfEqual() {
    $oMain = ResourceFinder::findResourceObject(array('lib', 'tests', 'ResourceFinderTests.php'));
    $this->assertEquals(new FileResource($oMain->getFullPath()), $oMain);
  }
  
  public function testFindAllMain() {
    $aMainPaths = ResourceFinder::findAllResources(array('lib', 'main.php'));
    $this->assertSame(array(MAIN_DIR.'/base/lib/main.php'), $aMainPaths);
  }
  
  public function testFindAllMainByExpression() {
    $aMainPaths = ResourceFinder::findResourceByExpressions(array('lib', 'main.php'));
    $this->assertSame(1, count($aMainPaths));
    $this->assertSame(MAIN_DIR.'/base/lib/main.php', ArrayUtil::assocPeek($aMainPaths));
  }
  
  public function testFindAllMainByExpressionAndObject() {
    $aMainPaths = ResourceFinder::findResourceByExpressions(array('lib', 'main.php'));
    $this->assertSame(1, count($aMainPaths));
    $oFileRes = new FileResource(ArrayUtil::assocPeek($aMainPaths));
    $this->assertSame(array($oFileRes->getRelativePath() => MAIN_DIR.'/base/lib/main.php'), $aMainPaths);
  }
}