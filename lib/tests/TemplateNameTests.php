<?php
/**
 * @package test
 */
class TemplateNameTests extends PHPUnit_Framework_TestCase {
  public function testSubTemplate() {
    $sTemplateText = <<<EOT
{{writeTemplateName}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, 'name');
    
    $this->assertSame("name", $oTemplate->render());
  }
  
  public function testSubTemplateWithDefaultValue() {
    $sTemplateText = <<<EOT
{{unfilledIdentifier;defaultValue=\{\{writeTemplateName\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, 'name2');
    
    $this->assertSame("name2", $oTemplate->render());
  }
}