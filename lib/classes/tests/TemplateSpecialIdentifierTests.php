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
    
    $this->assertEquals("myTest is great", $oTemplate->render());
  }
  
  public function testConstantInSubTemplateWithDefaultValue() {
    $sTemplateText = <<<EOT
{{unfilledIdentifier;defaultValue=\{\{writeConstantValue=CONSTANT\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertEquals("myTest is great", $oTemplate->render());
  }
  
  public function testConstantInSubTemplateWithConditional() {
    $sTemplateText = <<<EOT
{{if=e;1=\{\{writeConstantValue=CONSTANT\}\};2=myTest is great}}TEST{{endIf}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertEquals("TEST", $oTemplate->render());
  }
  
  public function testConstantInTemplateIdentifierValue() {
    $sTemplateText = <<<EOT
{{writeManagerPrefix=\{\{writeConstantValue=MANAGER\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertEquals("cms_manager", $oTemplate->render());
  }
}