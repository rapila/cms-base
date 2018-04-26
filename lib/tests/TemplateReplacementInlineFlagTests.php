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
	
	public function testSimpleInlineFlagEscapeNoHTML() {
		$sTemplateText = <<<EOT
{{test;templateFlag=ESCAPE}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifier('test', '<a>&"nb\'sp;</a>', null, Template::NO_HTML_ESCAPE);
		
		$this->assertSame('<a>&\\"nb\\\'sp;</a>', $oTemplate->render());
	}
	
	public function testSimpleInlineFlagJavascriptConvert() {
		$sTemplateText = <<<EOT
{{test;templateFlag=JAVASCRIPT_CONVERT}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifier('test', new Template('a" "/a', null, true));
		
		$this->assertSame('"a" "/a"', $oTemplate->render());
	}
	
	public function testSimpleInlineFlagJavascriptEscape() {
		$sTemplateText = <<<EOT
{{test;templateFlag=JAVASCRIPT_ESCAPE}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifier('test', new Template('a" "/a', null, true));
		
		$this->assertSame('"a\\" \\"/a"', $oTemplate->render());
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
		
		$this->assertSame('"a" "/a"', $oTemplate->render());
	}
	
	public function testSimpleInlineFlagMultipleJavascriptEscape() {
		$sTemplateText = <<<EOT
{{test;templateFlag=JAVASCRIPT_ESCAPE}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
		$oTemplate->replaceIdentifierMultiple('test', new Template('a" "/a', null, true));
		
		$this->assertSame('"a\\" \\"/a"', $oTemplate->render());
	}
	
	public function testSimpleInlineFlagMultipleNoNewline() {
		$sTemplateText = <<<EOT
{{test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("1\n2\n", $oTemplate->render());

		$sTemplateText = <<<EOT
{{test;templateFlag=NO_NEWLINE}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("12", $oTemplate->render());
	}
	
	public function testContextInlineFlagMultipleNoNewline() {
		$sTemplateText = <<<EOT
{{identifierContext=start;name=test}}a{{test}}a{{identifierContext=end;name=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("a1a\na2a\n", $oTemplate->render());

		$sTemplateText = <<<EOT
{{identifierContext=start;name=test;templateFlag=NO_NEWLINE}}a{{test}}a{{identifierContext=end;name=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("a1aa2a", $oTemplate->render());

		$sTemplateText = <<<EOT
{{identifierContext=start;name=test}}a{{test;templateFlag=NO_NEWLINE}}a{{identifierContext=end;name=test}}
{{identifierContext=start;name=test}}a{{test}}a{{identifierContext=end;name=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("a1aa2a\na1a\na2a\n", $oTemplate->render());

		$sTemplateText = <<<EOT
{{identifierContext=start;name=test}}a{{test}}a{{identifierContext=end;name=test;templateFlag=NO_NEWLINE}}
{{test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("a1aa2a\n1\n2\n", $oTemplate->render());
	}
	
	public function testContextInlineFlagMultipleNoNewContext() {
		$sTemplateText = <<<EOT
{{identifierContext=start;name=test}}a{{test}}a{{identifierContext=end;name=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true), null, Template::NO_NEW_CONTEXT);
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true), null, Template::NO_NEW_CONTEXT);
		$this->assertSame("a1\n2\na", $oTemplate->render());

		$sTemplateText = <<<EOT
{{identifierContext=start;name=test;templateFlag=NO_NEW_CONTEXT}}a{{test}}a{{identifierContext=end;name=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("a1\n2\na", $oTemplate->render());

		$sTemplateText = <<<EOT
{{identifierContext=start;name=test;templateFlag=NO_NEW_CONTEXT}}a{{test;templateFlag=NO_NEW_CONTEXT}}a{{identifierContext=end;name=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oTemplate->replaceIdentifierMultiple('test', new Template('1', null, true));
		$oTemplate->replaceIdentifierMultiple('test', new Template('2', null, true));
		$this->assertSame("a1\n2\na", $oTemplate->render());
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
	
	public function testCombinedInlineFlags() {
		$sTemplateText = <<<EOT
{{test;templateFlag=LEAVE_IDENTIFIERS|ESCAPE}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true, false, null, null, Template::NO_NEWLINE);
		$oTemplate->replaceIdentifierMultiple('test', new Template('"{{test2}}"', null, true));
		$oTemplate->replaceIdentifierMultiple('test2', 1);
		
		$this->assertSame('\\"1\\"', $oTemplate->render());
	}
}