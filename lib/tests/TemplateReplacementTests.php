<?php
/**
 * @package test
 */
class TemplateReplacementTests extends PHPUnit_Framework_TestCase {
  public function testSimpleReplacement() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', 'name');
    
    $this->assertEquals("name", $oTemplate->render());
  }
  
  public function testSimpleReplacementWithValueFalse() {
    $sTemplateText = <<<EOT
{{test=1}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', 'name');
    
    $this->assertEquals("", $oTemplate->render());
  }
  
  public function testSimpleReplacementWithValueTrue() {
    $sTemplateText = <<<EOT
{{test=1}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', 'name', "1");
    
    $this->assertEquals("name", $oTemplate->render());
  }
  
  public function testSimpleReplacementOfDifferentTypes() {
    $sTemplateText = <<<EOT
{{test1}}|{{test2}}|{{test3}}|{{test4}}|{{test5}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test1', 'string');
    $oTemplate->replaceIdentifier('test2', 1);
    $oTemplate->replaceIdentifier('test3', true);
    $oTemplate->replaceIdentifier('test4', 0x10);
    $oTemplate->replaceIdentifier('test5', array("list", "item"));
    
    $this->assertEquals("string|1|true|16|listitem", $oTemplate->render());
  }
  
  public function testReplaceIdentifierValueReplacement() {
    $sTemplateText = <<<EOT
{{test=\{\{text1\}\};param=\{\{text2\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('text1', "test1");
    $oTemplate->replaceIdentifier('text2', "test2");
    
    $oTemplate->bKillIdentifiersBeforeRender = false;
    
    $this->assertEquals("{{test=test1;param=test2}}", $oTemplate->render());
  }
  
  public function testReplaceIdentifierSubtemplate() {
    $sTemplateText = <<<EOT
{{test}}<html>&so
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oSubTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', $oSubTemplate);
    
    $this->assertEquals("<html>&so<html>&so", $oTemplate->render());
  }
  
  public function testReplaceIdentifierSubtemplateDirectOutput() {
    $sTemplateText = <<<EOT
{{test=1}}<html>&so
EOT;
    ob_start();
    $oTemplate = new Template($sTemplateText, null, true, true);
    $oSubTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', $oSubTemplate, '1');
    $oTemplate->render();
    $this->assertEquals("<html>&so<html>&so", ob_get_contents());
    ob_end_clean();
  }
  
  public function testReplaceIdentifierNull() {
    $sTemplateText = <<<EOT
ga {{test}} ga
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', null);
    $oTemplate->replaceIdentifier('test', 'test');
    
    $this->assertEquals("ga test ga", $oTemplate->render());
  }
  
  public function testReplaceIdentifierMultiple() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifierMultiple('test', 'string');
    $oTemplate->replaceIdentifierMultiple('test', 1);
    $oTemplate->replaceIdentifierMultiple('test', true);
    $oTemplate->replaceIdentifierMultiple('test', 0x10);
    $oTemplate->replaceIdentifierMultiple('test', array("list", "item"));
    
    $this->assertEquals("string\n1\ntrue\n16\nlistitem\n", $oTemplate->render());
  }
  
  public function testReplaceIdentifierMultipleNoNewline() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->setDefaultFlags(Template::NO_NEWLINE);
    
    $oTemplate->replaceIdentifierMultiple('test', 'string');
    $oTemplate->replaceIdentifierMultiple('test', 1);
    $oTemplate->replaceIdentifierMultiple('test', true);
    $oTemplate->replaceIdentifierMultiple('test', 0xff);
    $oTemplate->replaceIdentifierMultiple('test', array("list", "item"));
    
    $this->assertEquals("string1true255listitem", $oTemplate->render());
  }
  
  public function testReplaceIdentifierHtmlEscape() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', '&<>;"\'');
    
    $this->assertEquals("&amp;&lt;&gt;;&quot;&#039;", $oTemplate->render());
  }
  
  public function testReplaceIdentifierFlagNoHtmlEscape() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', '&<>;"\'', null, Template::NO_HTML_ESCAPE);
    
    $this->assertEquals('&<>;"\'', $oTemplate->render());
  }
  
  public function testReplaceIdentifierFlagEscape() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', '&<>;"\'', null, Template::ESCAPE);
    
    $this->assertEquals('&amp;&lt;&gt;;\\&quot;\\&#039;', $oTemplate->render());
  }
  
  public function testReplaceIdentifierFlagJavaScriptEscape() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', '&<>;"\'', null, Template::JAVASCRIPT_ESCAPE);
    
    $this->assertEquals('&<>;\\\'\\\'', $oTemplate->render());
  }
  
  public function testReplaceIdentifierFlagLeaveIdentifiers() {
    $sTemplateText = <<<EOT
{{test}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', $sTemplateText, null, Template::LEAVE_IDENTIFIERS);
    $oTemplate->replaceIdentifier('test', $sTemplateText);
    
    $this->assertEquals($sTemplateText, $oTemplate->render());
  }
  
  public function testReplaceIdentifierFlagForceHtmlEscape() {
    $sTemplateText = <<<EOT
{{test}}<html>&so
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oSubTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('test', $oSubTemplate, null, Template::FORCE_HTML_ESCAPE);
    
    $this->assertEquals("&lt;html&gt;&amp;so<html>&so", $oTemplate->render());
  }
  
  public function testReplaceIdentifierFlagNoIdentifierValueReplacement() {
    $sTemplateText = <<<EOT
{{test=\{\{text1\}\};param=\{\{text2\}\}}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('text1', "test1", null, Template::NO_IDENTIFIER_VALUE_REPLACEMENT);
    $oTemplate->replaceIdentifier('text2', "test2", null, Template::NO_IDENTIFIER_VALUE_REPLACEMENT);
    
    $oTemplate->bKillIdentifiersBeforeRender = false;
    
    $this->assertEquals("{{test=\{\{text1\}\};param=\{\{text2\}\}}}", $oTemplate->render());
  }
  
}