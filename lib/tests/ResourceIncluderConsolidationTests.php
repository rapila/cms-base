<?php

/**
* @package test
*/
class ResourceIncluderConsolidationTests extends PHPUnit\Framework\TestCase {
	private $oIncluder;

	private static $CACHED_INCLUDE;
	
	protected function setUp() {
		// Reset overrides for test
		Settings::clearOverrides();
		Cache::clearAllCaches();
		$this->oIncluder = new ResourceIncluder();
	}

	public static function setUpBeforeClass() {
		exec('mkdir -p "'.MAIN_DIR.'/'.DIRNAME_PLUGINS.'/test_only/web/css"');
		file_put_contents(MAIN_DIR.'/'.DIRNAME_PLUGINS.'/test_only/web/css/ResourceIncluderConsolidationTests.css', <<<EOT
@import url("fineprint.css") print;
@import url("chrome://communicator/skin/");
@import url("//example.com/skin/");
@import "http://example.com/skin1/";
@import 'http://example.com/skin2/';
@import url('./../landscape.css') screen and (orientation:landscape);

@font-face {
	font-family: "WebFont";
	src: local('test'), url("../fonts/WebFont.woff") format('woff')
	     url('./fonts:media/WebFont.eot');
}

html {
	background-image: url('../images/test.png');
}

EOT
);
	
	self::$CACHED_INCLUDE = new Cache('consolidated-'.ResourceIncluder::RESOURCE_PREFIX_INTERNAL.'/plugins/test_only/web/css/ResourceIncluderConsolidationTests.css', DIRNAME_PRELOAD);
}

	public static function tearDownAfterClass() {
		exec('rm -Rf "'.MAIN_DIR.'/plugins/test_only/web/css"');
		// Reset overrides for next test class
		Settings::clearOverrides();
	}

	public function testConsolidatedIncludes() {
		$this->oIncluder->addResource(array('web', 'js', 'widget', 'ckeditor', 'skins', 'moono-lisa', 'editor.css'));
		$this->oIncluder->addResource('admin/admin-ui.css', null, null, null, ResourceIncluder::PRIORITY_FIRST, 'IE');
		$this->oIncluder->addResource('widget/ckeditor/ckeditor.js', null, null, array('ie_condition' => 'IE lt 6'));
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, true, true, null);
		$this->assertSame(<<<EOT
<!--[if IE]><link rel="stylesheet" media="all" href="/base/web/css/admin/admin-ui.css" /><![endif]-->
<link rel="stylesheet" media="all" href="/get_file/consolidated_resource/css/632a2e9ae0930e5979486adb7c7a64cc" />
<!--[if IE lt 6]><script type="text/javascript" src="/base/web/js/widget/ckeditor/ckeditor.js"></script><![endif]-->
<script type="text/javascript" src="/get_file/consolidated_resource/js/b60745877cf6f631c3f8f3d63b2546c1/6b71198caa246549b55c85ac758dbac8"></script>

EOT
, $this->oIncluder->getIncludes(true, true)->render());
	}

	public function testConsolidatedIncludesIE() {
		$this->oIncluder->addResource(array('web', 'js', 'widget', 'ckeditor', 'skins', 'moono-lisa', 'editor.css'));
		$this->oIncluder->addResource('admin/admin-ui.css', null, null, null, ResourceIncluder::PRIORITY_FIRST);
		$this->oIncluder->addResource('widget/ckeditor/ckeditor.js');
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, true, true, null);
		$this->assertSame(<<<EOT
<link rel="stylesheet" media="all" href="/get_file/consolidated_resource/css/7536fdcd091d2ac23c503e8f8f07a8b5/632a2e9ae0930e5979486adb7c7a64cc" />
<script type="text/javascript" src="/get_file/consolidated_resource/js/f274a1b41e54444d057311779e734818/b60745877cf6f631c3f8f3d63b2546c1/6b71198caa246549b55c85ac758dbac8"></script>

EOT
, $this->oIncluder->getIncludes(true, true)->render());
	}
	
	public function testOnlyInternalIncludesConsolidated() {
		$this->oIncluder->addResource('widget/ckeditor/ckeditor.js');
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, true, true, null);
		$this->oIncluder->addResource('widget/widget.js');
		$this->oIncluder->addResource('e-mail-defuscate.js');
		$this->assertSame(<<<EOT
<script type="text/javascript" src="/get_file/consolidated_resource/js/f274a1b41e54444d057311779e734818"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
<script type="text/javascript" src="/get_file/consolidated_resource/js/d8c0284358c7a699c5602b313fe0426e/1da20a95bb9208420c4b8679d262aa06"></script>

EOT
, $this->oIncluder->getIncludes(true, 'internal')->render());
	}
	
	public function testCSSRewrite() {
		$this->oIncluder->addResource('ResourceIncluderConsolidationTests.css');
		$sResult = $this->oIncluder->getIncludes(true, true)->render();
		$sConsolidatedName = self::$CACHED_INCLUDE->getFileName();
		$this->assertSame(<<<EOT
<link rel="stylesheet" media="all" href="/get_file/consolidated_resource/css/$sConsolidatedName" />

EOT
, $sResult);
		$sContents = self::$CACHED_INCLUDE->getContentsAsString();
		$this->assertSame(<<<EOT
@import url("/plugins/test_only/web/css/fineprint.css") print;
@import url("chrome://communicator/skin/");
@import url("//example.com/skin/");
@import "http://example.com/skin1/";
@import 'http://example.com/skin2/';
@import url('/plugins/test_only/web/landscape.css') screen and (orientation:landscape);

@font-face {
	font-family: "WebFont";
	src: local('test'), url("/plugins/test_only/web/fonts/WebFont.woff") format('woff')
	     url('/plugins/test_only/web/css/fonts:media/WebFont.eot');
}

html {
	background-image: url('/plugins/test_only/web/images/test.png');
}

EOT
, $sContents);
	}
	
	public function testCSSRewriteWhenLinkingAbsolutely() {
		Settings::addOverride('domain_holder', 'domain', '2.example.com');
		Settings::addOverride('linking', 'prefer_configured_domain', true);
		Settings::addOverride('linking', 'always_link_absolutely', true);
		Settings::addOverride('linking', 'ssl_in_absolute_links', null);

		$this->oIncluder->addResource('ResourceIncluderConsolidationTests.css');
		
		$oFile = ResourceFinder::create()->returnObjects()->addPath('web', 'css', 'ResourceIncluderConsolidationTests.css')->find();
		
		$this->oIncluder->getIncludes(true, true)->render();
		$sContents = self::$CACHED_INCLUDE->getContentsAsString();

		$this->assertSame(<<<EOT
@import url("//2.example.com/plugins/test_only/web/css/fineprint.css") print;
@import url("chrome://communicator/skin/");
@import url("//example.com/skin/");
@import "http://example.com/skin1/";
@import 'http://example.com/skin2/';
@import url('//2.example.com/plugins/test_only/web/landscape.css') screen and (orientation:landscape);

@font-face {
	font-family: "WebFont";
	src: local('test'), url("//2.example.com/plugins/test_only/web/fonts/WebFont.woff") format('woff')
	     url('//2.example.com/plugins/test_only/web/css/fonts:media/WebFont.eot');
}

html {
	background-image: url('//2.example.com/plugins/test_only/web/images/test.png');
}

EOT
, $sContents);
	}
	
	public function testCSSRewriteWhenUsingSSL() {
		Settings::addOverride('domain_holder', 'domain', '2.example.com');
		Settings::addOverride('linking', 'prefer_configured_domain', true);
		Settings::addOverride('linking', 'always_link_absolutely', false);
		Settings::addOverride('linking', 'ssl_in_absolute_links', true);

		$this->oIncluder->addResource('ResourceIncluderConsolidationTests.css');
		
		$oFile = ResourceFinder::create()->returnObjects()->addPath('web', 'css', 'ResourceIncluderConsolidationTests.css')->find();
		
		$this->oIncluder->getIncludes(true, true)->render();
		$sContents = self::$CACHED_INCLUDE->getContentsAsString();

		$this->assertSame(<<<EOT
@import url("https://2.example.com/plugins/test_only/web/css/fineprint.css") print;
@import url("chrome://communicator/skin/");
@import url("//example.com/skin/");
@import "http://example.com/skin1/";
@import 'http://example.com/skin2/';
@import url('https://2.example.com/plugins/test_only/web/landscape.css') screen and (orientation:landscape);

@font-face {
	font-family: "WebFont";
	src: local('test'), url("https://2.example.com/plugins/test_only/web/fonts/WebFont.woff") format('woff')
	     url('https://2.example.com/plugins/test_only/web/css/fonts:media/WebFont.eot');
}

html {
	background-image: url('https://2.example.com/plugins/test_only/web/images/test.png');
}

EOT
, $sContents);
	}
}
