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
		$aMainPaths = ResourceFinder::findResourcesByExpressions(array('lib', 'main.php'));
		$this->assertSame(1, count($aMainPaths));
		$this->assertSame(MAIN_DIR.'/base/lib/main.php', ArrayUtil::assocPeek($aMainPaths));
	}
	
	public function testFindAllMainByExpressionAndObject() {
		$aMainPaths = ResourceFinder::findResourcesByExpressions(array('lib', 'main.php'));
		$this->assertSame(1, count($aMainPaths));
		$oFileRes = new FileResource(ArrayUtil::assocPeek($aMainPaths));
		$this->assertSame(array($oFileRes->getRelativePath() => MAIN_DIR.'/base/lib/main.php'), $aMainPaths);
	}

	public function testOptionalPathItemByExpressionPlaintext() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, array('production'), 'config.yml'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/config.yml', MAIN_DIR.'/base/config/production/config.yml'), $aConfigPaths);
	}

	public function testOptionalPathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, array(ResourceFinder::ANY_NAME_OR_TYPE_PATTERN), 'config.yml'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/config.yml', MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/staging/config.yml',MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}

	public function testAnyPathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, true, 'config.yml'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/staging/config.yml',MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}

	public function testAnyOptionalPathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, array(true), 'config.yml'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/config.yml', MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/staging/config.yml',MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}

	public function testDirPathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, false, 'config.yml'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/staging/config.yml',MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}

	public function testDirOptionalPathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, array(false), 'config.yml'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/config.yml', MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/staging/config.yml',MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}

	public function testRecursivePathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_WEB, 'css', array(), '/^.+\.custom\.css$/'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/web/css/admin/theme/jquery-ui-1.7.2.custom.css', MAIN_DIR.'/base/web/css/preview/theme/jquery-ui-1.7.2.custom.css'), $aConfigPaths);
	}

	public function testOptionalPathItemAtEnd() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, 'test', array('config.yml')), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/test', MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}
	
	public function testOptionalDirPathItemsAtEnd() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, array(false), array('config.yml')), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config', MAIN_DIR.'/base/config/config.yml', MAIN_DIR.'/base/config/development', MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/staging', MAIN_DIR.'/base/config/staging/config.yml',MAIN_DIR.'/base/config/test', MAIN_DIR.'/base/config/test/config.yml'), $aConfigPaths);
	}
	
	public function testOptionalPathItemsAtEnd() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, array(true), array('config.yml')), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config', MAIN_DIR.'/base/config/config.yml', MAIN_DIR.'/base/config/db_config.yml', MAIN_DIR.'/base/config/development', MAIN_DIR.'/base/config/development/config.yml', MAIN_DIR.'/base/config/production', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/resource_includer.yml', MAIN_DIR.'/base/config/schema.xml', MAIN_DIR.'/base/config/staging', MAIN_DIR.'/base/config/staging/config.yml', MAIN_DIR.'/base/config/synonyms.yml', MAIN_DIR.'/base/config/test', MAIN_DIR.'/base/config/test/config.yml', MAIN_DIR.'/base/config/user_defaults.yml'), $aConfigPaths);
	}
	
	public function testOptionalRecursivePathItemAtEnd() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_CONFIG, 'production', array()), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(MAIN_DIR.'/base/config/production', MAIN_DIR.'/base/config/production/config.yml', MAIN_DIR.'/base/config/production/resource_includer.yml'), $aConfigPaths);
	}
	
	public function testNoRecursivePathItemByExpression() {
		$aConfigPaths = ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_WEB, 'css', array(true), '/^.+\.custom\.css$/'), ResourceFinder::SEARCH_BASE_ONLY);
		$this->assertSame(array(), $aConfigPaths);
	}
}
