<?php
/**
* @package test
*/

class ResourceIncluderTests extends PHPUnit\Framework\TestCase {
	private $oIncluder;

	protected function setUp() {
		$this->oIncluder = new ResourceIncluder();
	}

	public function testSimpleIncludeImage() {
		$this->oIncluder->addResource('admin/accept.png');
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testSimpleIncludeImage404() {
		try {
			$this->oIncluder->addResource('admin/accepts_not.png');
		} catch(Exception $e) {
			$this->assertSame('Error in ResourceIncluder->addResource(): Specified internal file admin/accepts_not.png could not be found.', $e->getMessage());
			return;
		}
		$this->fail('Exception has not been raised for non-existant file admin/accepts_not.png');
	}
	
	public function testArrayIncludeImage() {
		$this->oIncluder->addResource(array('web', 'images', 'admin', 'accept.png'));
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testArrayIncludeImage404() {
		try {
			$this->oIncluder->addResource(array('web', 'images', 'admin', 'accepts_not.png'));
		} catch(Exception $e) {
			$this->assertSame('Error in ResourceIncluder->addResource(): Specified internal file web/images/admin/accepts_not.png could not be found.', $e->getMessage());
			return;
		}
		$this->fail('Exception has not been raised for non-existant file admin/accepts_not.png');
	}
	
	public function testAbsoluteHttpIncludeImage() {
		$this->oIncluder->addResource('http://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg#60724927@N00');
		$this->assertSame(array('http://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg#60724927@N00'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testAbsoluteHttpsIncludeImage() {
		$this->oIncluder->addResource('https://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#60724927@N00');
		$this->assertSame(array('https://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#60724927@N00'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testAbsoluteFtpIncludeImage() {
		$this->oIncluder->addResource('ftp://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#?60724927@N00');
		$this->assertSame(array('ftp://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#?60724927@N00'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testAbsoluteInternalIncludeImage() {
		$this->oIncluder->addResource('/2399/buddyicons/60724927@N00.jpg?1216948732');
		$this->assertSame(array('/2399/buddyicons/60724927@N00.jpg?1216948732'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testFileResourceIncludeImage() {
		$this->oIncluder->addResource(new FileResource(MAIN_DIR.'/base/web/images/admin/accept.png'));
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
		$this->assertSame('<img src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $this->oIncluder->getIncludes()->render());
	}
	
	public function testSimpleIncludeCss() {
		$this->oIncluder->addResource('admin/admin-ui.css');
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin/admin-ui.css'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
		
	public function testSimpleIncludeJs() {
		$this->oIncluder->addResource('admin/admin.js');
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/js/admin/admin.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testNullInclude() {
		try {
			$this->oIncluder->addResource(null);
		} catch(Exception $e) {
			$this->assertSame('Eror in ResourceIncluder->addResource(): given location  is in unknown format', $e->getMessage());
			return;
		}
		$this->fail('Exception has not been raised for null location');
	}
	
	public function testSimpleIncludeImages() {
		$this->oIncluder->addResource('admin/accept.png');
		$this->oIncluder->addResource('admin/add.png');
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png', MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/add.png'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testSimpleIncludeImagesOrder() {
		$this->oIncluder->addResource('admin/accept.png');
		$this->oIncluder->addResource('admin/add.png');
		$this->oIncluder->addResource('admin/accept.png');
		$this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/add.png', MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludejQuery() {
		$this->oIncluder->addJavaScriptLibrary('jquery', 1);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculous() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', '//ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousAndPrototype() {
		$this->oIncluder->addJavaScriptLibrary('prototype', 1.6);
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', '//ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousSsl() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, true, true);
		$this->assertSame(array('https://ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousNoSsl() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, true, false);
		$this->assertSame(array('http://ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', 'http://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousSslNodeps() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, false, true);
		$this->assertSame(array('https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousNodeps() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, false);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousNoSslNodeps() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, false, false);
		$this->assertSame(array('http://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousSslNodepsUncomp() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1, false, false, true);
		$this->assertSame(array('https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludeScriptaculousRequires() {
		$this->oIncluder->addJavaScriptLibrary('scriptaculous', 1);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', '//ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludejQueryUISslNodepsUncomp() {
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, false, false, true);
		$this->assertSame(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludejQueryUISslUncomp() {
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, false, true, true);
		$this->assertSame(array('https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludejQueryUIUncompNoSsl() {
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, false, true, false);
		$this->assertSame(array('http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludejQueryUIUncomp() {
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, false, true, null);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.js', '//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function testLibraryIncludejQueryUISsl() {
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1, true, true, true);
		$this->assertSame(array('https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
	}
	
	public function IUyreuQjedulcnIyrarbiLtset() {
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1);
		$this->assertSame(array('//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', '//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'), $this->oIncluder->getLocationsForIncludedResourcesOfPriority(ResourceIncluder::PRIORITY_NORMAL));
		$this->assertSame('<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n", $this->oIncluder->getIncludes()->render());
	}
	
	public function testMultipleIncludes() {
		$this->oIncluder->addResource(array('web', 'js', 'widget', 'ckeditor', 'skins', 'moono', 'editor.css'));
		$this->oIncluder->addResource('admin/admin-ui.css');
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1);
		$this->oIncluder->addResource('widget/ckeditor/ckeditor.js');
		$this->oIncluder->addResource('admin/accept.png', null, null, array('template' => 'icons'));
		$this->assertSame('<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/skins/moono/editor.css" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin/admin-ui.css" />'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/ckeditor.js"></script>'."\n".'<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $this->oIncluder->getIncludes(true, false)->render());
	}
	
	public function testPrioritizedMultipleIncludes() {
		$this->oIncluder->addResource('admin/accept.png', null, null, array('template' => 'icons'), ResourceIncluder::PRIORITY_LAST);
		$this->oIncluder->addResource('admin/admin-ui.css');
		$this->oIncluder->addJavaScriptLibrary('jqueryui', 1);
		$this->oIncluder->addResource('widget/ckeditor/ckeditor.js');
		$this->oIncluder->addResource(array('web', 'js', 'widget', 'ckeditor', 'skins', 'moono', 'editor.css'), null, null, array(), ResourceIncluder::PRIORITY_FIRST);
		$this->assertSame('<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/skins/moono/editor.css" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin/admin-ui.css" />'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/ckeditor.js"></script>'."\n".'<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $this->oIncluder->getIncludes(true, false)->render());
	}
	
	public function testInlineJs() {
		$sOuterTemplate = <<<EOT
<script type="text/javascript">
<!--//--><![CDATA[//><!--
	{{content}}
//--><!]]>
</script>

EOT;

		$oTemplate = new Template('settings.admin.js', array(DIRNAME_MODULES, 'admin', 'settings', 'templates'));
		$this->oIncluder->addCustomJs($oTemplate);
		$this->assertSame(str_replace('{{content}}', $oTemplate->render(), $sOuterTemplate), $this->oIncluder->getIncludes(true, false)->render());
	}
	
	public function testInlineCss() {
		$sOuterTemplate = <<<EOT
<style type="text/css">
<!--/*--><![CDATA[/*><!--*/
	{{content}}
/*]]>*/-->
</style>

EOT;
		$oTemplate = new Template('settings.admin.css', array(DIRNAME_MODULES, 'admin', 'settings', 'templates'));
		$this->oIncluder->addCustomCss($oTemplate);
		$this->assertSame(str_replace('{{content}}', $oTemplate->render(), $sOuterTemplate), $this->oIncluder->getIncludes(true, false)->render());
	}
}
