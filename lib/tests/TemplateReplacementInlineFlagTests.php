<?php
/**
 * @package test
 */
class TemplateReplacementInlineFlagTests extends PHPUnit_Framework_TestCase {
  public function testSimpleInlineFlagNoHtmlEscape() {
    $sTemplateText = <<<EOT
{{test;templateFlag=NO_HTML_ESCAPE}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', '<a>&nbsp;</a>');
    
    $this->assertSame('<a>&nbsp;</a>', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagEscape() {
    $sTemplateText = <<<EOT
{{test;templateFlag=ESCAPE}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', '<a>&"nb\'sp;</a>');
    
    $this->assertSame('&lt;a&gt;&amp;\\&quot;nb\\&#039;sp;&lt;/a&gt;', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagJavascriptConvert() {
    $sTemplateText = <<<EOT
{{test;templateFlag=JAVASCRIPT_CONVERT}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', new Template('a" "/a', null, true));
    
    $this->assertSame('a\' \'/a', $oTemplate->render());
  }

  public function testSimpleInlineFlagLeaveIdentifiers1() {
    $sTemplateText = <<<EOT
{{test;templateFlag=LEAVE_IDENTIFIERS}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', '{{test;defaultValue=1}}');
    
    $this->assertSame('1', $oTemplate->render());
  }

  public function testSimpleInlineFlagLeaveIdentifiers2() {
    $sTemplateText = <<<EOT
{{test;templateFlag=LEAVE_IDENTIFIERS}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', new Template('{{test2}}', null, true));
    $oTemplate->replaceIdentifier('test2', 1);
    
    $this->assertSame('1', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagForceHtmlEscape() {
    $sTemplateText = <<<EOT
{{test;templateFlag=FORCE_HTML_ESCAPE}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('test', new Template('<a>&nbsp;</a>', null, true));
    
    $this->assertSame('&lt;a&gt;&amp;nbsp;&lt;/a&gt;', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagMultipleNoHtmlEscape() {
    $sTemplateText = <<<EOT
{{test;templateFlag=NO_HTML_ESCAPE}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
    $oTemplate->replaceIdentifierMultiple('test', '<a>&nbsp;</a>');
    
    $this->assertSame('<a>&nbsp;</a>', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagMultipleEscape() {
    $sTemplateText = <<<EOT
{{test;templateFlag=ESCAPE}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
    $oTemplate->replaceIdentifierMultiple('test', '<a>&"nb\'sp;</a>');
    
    $this->assertSame('&lt;a&gt;&amp;\\&quot;nb\\&#039;sp;&lt;/a&gt;', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagMultipleJavascriptConvert() {
    $sTemplateText = <<<EOT
{{test;templateFlag=JAVASCRIPT_CONVERT}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
    $oTemplate->replaceIdentifierMultiple('test', new Template('a" "/a', null, true));
    
    $this->assertSame('a\' \'/a', $oTemplate->render());
  }

  public function testSimpleInlineFlagMultipleLeaveIdentifiers1() {
    $sTemplateText = <<<EOT
{{test;templateFlag=LEAVE_IDENTIFIERS}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
    $oTemplate->replaceIdentifierMultiple('test', '{{test;defaultValue=1}}');
    
    $this->assertSame('1', $oTemplate->render());
  }

  public function testSimpleInlineFlagMultipleLeaveIdentifiers2() {
    $sTemplateText = <<<EOT
{{test;templateFlag=LEAVE_IDENTIFIERS}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
    $oTemplate->replaceIdentifierMultiple('test', new Template('{{test2}}', null, true));
    $oTemplate->replaceIdentifierMultiple('test2', 1);
    
    $this->assertSame('1', $oTemplate->render());
  }
  
  public function testSimpleInlineFlagMultipleForceHtmlEscape() {
    $sTemplateText = <<<EOT
{{test;templateFlag=FORCE_HTML_ESCAPE}}
EOT;
    $oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
    $oTemplate->replaceIdentifierMultiple('test', new Template('<a>&nbsp;</a>', null, true));
    
    $this->assertSame('&lt;a&gt;&amp;nbsp;&lt;/a&gt;', $oTemplate->render());
  }
}