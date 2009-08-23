<?php
/**
 * @package test
 */
define("CONSTANT", "myTest is great");
define("MANAGER", "BackendManager");
class TemplateSpecialIdentifierTests extends PHPUnit_Framework_TestCase {
  public function testConstant() {
    $sTemplateText = <<<EOT
{{writeConstantValue=CONSTANT}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertSame("myTest is great", $oTemplate->render());
  }
  
  public function testConstantInSubTemplateWithDefaultValue() {
    $sTemplateText = <<<EOT
{{unfilledIdentifier;defaultValue=\{\{writeConstantValue=CONSTANT\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertSame("myTest is great", $oTemplate->render());
  }
  
  public function testConstantInSubTemplateWithConditional() {
    $sTemplateText = <<<EOT
{{if=e;1=\{\{writeConstantValue=CONSTANT\}\};2=myTest is great}}TEST{{endIf}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertSame("TEST", $oTemplate->render());
  }
  
  public function testConstantInTemplateIdentifierValue() {
    $sTemplateText = <<<EOT
{{writeManagerPrefix=\{\{writeConstantValue=MANAGER\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertSame("cms_manager", $oTemplate->render());
  }
  
  public function testQuoteWithInner() {
    Session::getSession()->setLanguage('en');
    $sTemplateText = <<<EOT
{{quoteString=test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertSame("“test”", $oTemplate->render());
  }
  
  public function testQuoteWithInnerDefault() {
    Session::getSession()->setLanguage('en');
    $sTemplateText = <<<EOT
{{quoteString=\{\{test\;defaultValue=default\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);    

    $this->assertSame("“default”", $oTemplate->render());
  }
  
  public function testQuoteWithInnerDefaultValue() {
    Session::getSession()->setLanguage('en');
    $sTemplateText = <<<EOT
{{quoteString=\{\{test\}\};defaultValue=default}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);    

    $this->assertSame("default", $oTemplate->render());
  }
  
  public function testWriteResourceIncludes() {
    $sTemplateText = <<<EOT
{{writeResourceIncludes}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oIncluder = ResourceIncluder::defaultIncluder();
    $oIncluder->clearIncludedResources();
    $oIncluder->addResource('admin/accept.png', null, null, array('template' => 'favicon'));
    $oIncluder->addResource(array('web', 'js', 'tiny_mce', 'themes', 'simple', 'skins', 'default', 'ui.css'));
    $oIncluder->addJavaScriptLibrary('jqueryui', 1);
    $oIncluder->addResource('admin.css');
    $oIncluder->addResource('tiny_mce/tiny_mce.js');
    $this->assertSame('<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/tiny_mce/themes/simple/skins/default/ui.css" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin.css" />'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/tiny_mce/tiny_mce.js"></script>'."\n".'<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $oTemplate->render());
  }
  
  public function testWriteNamedResourceIncludes() {
    $sTemplateText = <<<EOT
{{writeResourceIncludes;name=myIncluder}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oIncluder = ResourceIncluder::namedIncluder('myIncluder');
    $oIncluder->clearIncludedResources();
    $oIncluder->addResource('admin/accept.png', null, null, array('template' => 'favicon'));
    $oIncluder->addResource(array('web', 'js', 'tiny_mce', 'themes', 'simple', 'skins', 'default', 'ui.css'));
    $oIncluder->addJavaScriptLibrary('jqueryui', 1);
    $oIncluder->addResource('admin.css');
    $oIncluder->addResource('tiny_mce/tiny_mce.js');
    $this->assertSame('<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/tiny_mce/themes/simple/skins/default/ui.css" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin.css" />'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/tiny_mce/tiny_mce.js"></script>'."\n".'<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n", $oTemplate->render());
  }
}