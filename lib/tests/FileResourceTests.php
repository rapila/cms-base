<?php
/**
* @package test
*/

class FileResourceTests extends PHPUnit_Framework_TestCase {
	
	protected function setUp() {
		exec('mkdir -p "'.MAIN_DIR.'/plugins/test_only/test"');
	}
	protected function tearDown() {
		exec('rm -R "'.MAIN_DIR.'/plugins/test_only/test"');
	}
	
	public function testIndexFileFullPathOnly() {
		$sFileResource = new FileResource(MAIN_DIR.'/index.php');
		$this->assertSame(MAIN_DIR.'/index.php', $sFileResource->getFullPath());
		$this->assertSame('', $sFileResource->getInstancePrefix());
		$this->assertSame('index.php', $sFileResource->getRelativePath());
	}
	
	public function testPluginsDirFullPathOnly() {
		$sFileResource = new FileResource(MAIN_DIR.'/plugins');
		$this->assertSame(MAIN_DIR.'/plugins', $sFileResource->getFullPath());
		$this->assertSame('', $sFileResource->getInstancePrefix());
		$this->assertSame('plugins', $sFileResource->getRelativePath());
	}
	
	public function testPluginsDirFullPathOnlyWithTrailingSlash() {
		$sFileResource = new FileResource(MAIN_DIR.'/plugins/');
		$this->assertSame(MAIN_DIR.'/plugins', $sFileResource->getFullPath());
		$this->assertSame('', $sFileResource->getInstancePrefix());
		$this->assertSame('plugins', $sFileResource->getRelativePath());
	}
	
	public function testPluginsDirItemFullPathOnly() {
		$sFileResource = new FileResource(MAIN_DIR.'/plugins/test_only');
		$this->assertSame(MAIN_DIR.'/plugins/test_only', $sFileResource->getFullPath());
		$this->assertSame('', $sFileResource->getInstancePrefix());
		$this->assertSame('plugins/test_only', $sFileResource->getRelativePath());
	}
	
	public function testPluginsDirItemFullPathOnlyWithTrailingSlash() {
		$sFileResource = new FileResource(MAIN_DIR.'/plugins/test_only/');
		$this->assertSame(MAIN_DIR.'/plugins/test_only', $sFileResource->getFullPath());
		$this->assertSame('', $sFileResource->getInstancePrefix());
		$this->assertSame('plugins/test_only', $sFileResource->getRelativePath());
	}
	
	public function testPluginsDirSubItemFullPathOnly() {
		$sFileResource = new FileResource(MAIN_DIR.'/plugins/test_only/test');
		$this->assertSame(MAIN_DIR.'/plugins/test_only/test', $sFileResource->getFullPath());
		$this->assertSame('plugins/test_only/', $sFileResource->getInstancePrefix());
		$this->assertSame('test', $sFileResource->getRelativePath());
	}
	
	public function testPluginsDirSubItemFullPathOnlyWithTrailingSlash() {
		$sFileResource = new FileResource(MAIN_DIR.'/plugins/test_only/test/');
		$this->assertSame(MAIN_DIR.'/plugins/test_only/test', $sFileResource->getFullPath());
		$this->assertSame('plugins/test_only/', $sFileResource->getInstancePrefix());
		$this->assertSame('test', $sFileResource->getRelativePath());
	}
	
	public function testSiteDirSubItemFullPathOnly() {
		$sFileResource = new FileResource(SITE_DIR.'/web');
		$this->assertSame(SITE_DIR.'/web', $sFileResource->getFullPath());
		$this->assertSame('site/', $sFileResource->getInstancePrefix());
		$this->assertSame('web', $sFileResource->getRelativePath());
	}
	
	public function testSiteDirSubItemFullPathOnlyWithTrailingSlash() {
		$sFileResource = new FileResource(SITE_DIR.'/web/');
		$this->assertSame(SITE_DIR.'/web', $sFileResource->getFullPath());
		$this->assertSame('site/', $sFileResource->getInstancePrefix());
		$this->assertSame('web', $sFileResource->getRelativePath());
	}
}