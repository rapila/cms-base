<?php
/**
* @package test
*/

class ResourceIncluderTests extends PHPUnit_Framework_TestCase {
  public function setUp() {
    ResourceIncluder::defaultIncluder()->clearIncludedResources();
  }
  
  public function testSimpleIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin/accept.png');
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testSimpleIncludeImage404() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    try {
      $oIncluder->addResource('admin/accepts_not.png');
    } catch(Exception $e) {
      $this->assertSame('Error in ResourceIncluder->addResource(): Specified internal file admin/accepts_not.png could not be found.', $e->getMessage());
      return;
    }
    $this->fail('Exception has not been raised for non-existant file admin/accepts_not.png');
  }
  
  public function testArrayIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource(array('web', 'images', 'admin', 'accept.png'));
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testArrayIncludeImage404() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    try {
      $oIncluder->addResource(array('web', 'images', 'admin', 'accepts_not.png'));
    } catch(Exception $e) {
      $this->assertSame('Error in ResourceIncluder->addResource(): Specified internal file Array could not be found.', $e->getMessage());
      return;
    }
    $this->fail('Exception has not been raised for non-existant file admin/accepts_not.png');
  }
  
  public function testAbsoluteHttpIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('http://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg#60724927@N00');
    $this->assertSame(array('http://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg#60724927@N00'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testAbsoluteHttpsIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('https://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#60724927@N00');
    $this->assertSame(array('https://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#60724927@N00'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testAbsoluteFtpIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('ftp://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#?60724927@N00');
    $this->assertSame(array('ftp://farm3.static.flickr.com/2399/buddyicons/60724927@N00.jpg?1216948732#?60724927@N00'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testAbsoluteInternalIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('/2399/buddyicons/60724927@N00.jpg?1216948732');
    $this->assertSame(array('/2399/buddyicons/60724927@N00.jpg?1216948732'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testFileResourceIncludeImage() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource(new FileResource(MAIN_DIR.'/base/web/images/admin/accept.png'));
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
    $this->assertSame('<img src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $oIncluder->getIncludes()->render());
  }
  
  public function testSimpleIncludeCss() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin.css');
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin.css'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_CSS));
  }
  
  public function testSimpleIncludeCssNoExtension() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin', ResourceIncluder::RESOURCE_TYPE_CSS);
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin.css'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_CSS));
    $this->assertSame('<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin.css" />'."\n", $oIncluder->getIncludes()->render());
  }
  
  public function testSimpleIncludeJs() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin.js');
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/js/admin.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testSimpleIncludeJsNoExtension() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin', ResourceIncluder::RESOURCE_TYPE_JS);
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/js/admin.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testNullInclude() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    try {
      $oIncluder->addResource(null);
    } catch(Exception $e) {
      $this->assertSame('Eror in ResourceIncluder->addResource(): given location  is in unknown format', $e->getMessage());
      return;
    }
    $this->fail('Exception has not been raised for null location');
  }
  
  public function testSimpleIncludeImages() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin/accept.png');
    $oIncluder->addResource('admin/add.png');
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png', MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/add.png'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testSimpleIncludeImagesOrder() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin/accept.png');
    $oIncluder->addResource('admin/add.png');
    $oIncluder->addResource('admin/accept.png');
    $this->assertSame(array(MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/add.png', MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_IMAGE));
  }
  
  public function testLibraryIncludejQuery() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('jquery', 1);
    $this->assertSame(array('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludeScriptaculous() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('scriptaculous', 1);
    $this->assertSame(array('http://ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', 'http://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludeScriptaculousSsl() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, true, true);
    $this->assertSame(array('https://ajax.googleapis.com/ajax/libs/prototype/1.6/prototype.js', 'https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludeScriptaculousSslNodeps() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('scriptaculous', 1, true, false, true);
    $this->assertSame(array('https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludeScriptaculousSslNodepsUncomp() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('scriptaculous', 1, false, false, true);
    $this->assertSame(array('https://ajax.googleapis.com/ajax/libs/scriptaculous/1/scriptaculous.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludejQueryUISslNodepsUncomp() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('jqueryui', 1, false, false, true);
    $this->assertSame(array('https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludejQueryUISslUncomp() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('jqueryui', 1, false, true, true);
    $this->assertSame(array('https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludejQueryUIUncomp() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('jqueryui', 1, false, true, false);
    $this->assertSame(array('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.js', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludejQueryUISsl() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('jqueryui', 1, true, true, true);
    $this->assertSame(array('https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
  }
  
  public function testLibraryIncludejQueryUI() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addJavaScriptLibrary('jqueryui', 1);
    $this->assertSame(array('http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'), $oIncluder->getLocationsForIncludedResourcesOfType(ResourceIncluder::RESOURCE_TYPE_JS));
    $this->assertSame('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n", $oIncluder->getIncludes()->render());
  }
  
  public function testMultipleIncludes() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->addResource('admin/accept.png', null, null, array('template' => 'favicon'));
    $oIncluder->addResource(array('web', 'js', 'tiny_mce', 'themes', 'simple', 'skins', 'default', 'ui.css'));
    $oIncluder->addJavaScriptLibrary('jqueryui', 1);
    $oIncluder->addResource('admin.css');
    $oIncluder->addResource('tiny_mce/tiny_mce.js');
    $this->assertSame('<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/tiny_mce/themes/simple/skins/default/ui.css" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin.css" />'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/tiny_mce/tiny_mce.js"></script>'."\n".'<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $oIncluder->getIncludes()->render());
  }
  
  public function testInlineJs() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $sOuterTemplate = <<<EOT
<script type="text/javascript">
<!--//--><![CDATA[//><!--
  {{content}}
//--><!]]>
</script>

EOT;

    $oTemplate = new Template('settings.js', array(DIRNAME_MODULES, 'backend', 'settings', 'templates'));
    $oIncluder->addCustomJs($oTemplate);
    $this->assertSame(str_replace('{{content}}', $oTemplate->render(), $sOuterTemplate), $oIncluder->getIncludes()->render());
  }
  
  public function testInlineCss() {
    $oIncluder = ResourceIncluder::defaultIncluder();
    $sOuterTemplate = <<<EOT
<style type="text/css">
<!--/*--><![CDATA[/*><!--*/
	  {{content}}
/*]]>*/-->
</style>

EOT;

    $oTemplate = new Template('settings.css', array(DIRNAME_MODULES, 'backend', 'settings', 'templates'));
    $oIncluder->addCustomCss($oTemplate);
    $this->assertSame(str_replace('{{content}}', $oTemplate->render(), $sOuterTemplate), $oIncluder->getIncludes()->render());
  }
}