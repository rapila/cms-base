<?php
/**
 * @package test
 */
class TemplateIdentifierContextTests extends PHPUnit_Framework_TestCase {
	public function testSimpleContext() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier}} s{{identifier}}{{identifierContext=end;name=identifier}}
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('identifier', 'identifier');
    
    $this->assertEquals(" sidentifier", $oTemplate->render());
  }
  
	public function testSimpleContextNegative() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier}} s{{identifier}}{{identifierContext=end;name=identifier}}
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertEquals("", $oTemplate->render());
  }
	public function testSimpleContextWithValue() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier;value=so}} s{{identifier=so}}{{identifierContext=end;name=identifier;value=so}}
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifier('identifier', 'identifier', "so");
    
    $this->assertEquals(" sidentifier", $oTemplate->render());
  }
  
	public function testSimpleContextNegativeWithValue() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier;value=so}} s{{identifier=so}}{{identifierContext=end;name=identifier;value=so}}
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertEquals("", $oTemplate->render());
  }
  
	public function testContextWithNestedIf1() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier}}{{if;1=\{\{main_navigation_name\}\};2=hello}} s{{endIf}}{{identifier}}{{identifierContext=end;name=identifier}} T E S T
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    $oTemplate->replaceIdentifierMultiple('identifier', 'test');
    
    $this->assertEquals("test\n T E S T", $oTemplate->render());
  }
  
 public function testContextWithNestedIf2() {
    $sTemplateText = <<<EOT
BEFORE
{{identifierContext=start;name=identifier}}
CONTEXT_START
{{if;1=\{\{main_navigation_name\}\};2=hello}}CONDITIONAL{{endIf}}
{{identifier}}
CONTEXT_END
{{identifierContext=end;name=identifier}}
AFTER{{hello}}
T E{{hello}} S {{hello}}T
EOT;
    $sTemplateTextAfterFirstReplacement = <<<EOT
BEFORE

CONTEXT_START
{{if;1=\{\{main_navigation_name\}\};2=hello}}CONDITIONAL{{endIf}}

CONTEXT_END

{{identifierContext=start;name=identifier}}
CONTEXT_START
{{if;1=\{\{main_navigation_name\}\};2=hello}}CONDITIONAL{{endIf}}
{{identifier}}
CONTEXT_END
{{identifierContext=end;name=identifier}}
AFTER{{hello}}
T E{{hello}} S {{hello}}T
EOT;
    $sTemplateTexOnEnd = <<<EOT
BEFORE

CONTEXT_START


CONTEXT_END


AFTER
T E S T
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    
    $this->assertEquals($oTemplate->__toString(), $sTemplateText);

    $oTemplate->replaceIdentifierMultiple('identifier', '');
    
    $this->assertEquals($oTemplate->__toString(), $sTemplateTextAfterFirstReplacement);
    
    $this->assertEquals($sTemplateTexOnEnd, $oTemplate->render());
  }
  
	public function testContextWithNestedTrueIf1() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier}}BEFORE{{if;1=\{\{main_navigation_name\}\};2=hello}} s{{endIf}}{{identifier}}{{identifierContext=end;name=identifier}} T {{hello}}E{{hello}} S {{hello}}T
EOT;
    
    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifier('main_navigation_name', 'hello');
    $oTemplate->replaceIdentifierMultiple('identifier', '');
    
    $this->assertEquals("BEFORE s\n T E S T", $oTemplate->render());
  }
  
 public function testContextWithNestedTrueIf2() {
    $sTemplateText = <<<EOT
{{identifierContext=start;name=identifier}}BEFORE{{if;1=\{\{main_navigation_name\}\};2=hello}} s{{endIf}}{{identifier}}{{identifierContext=end;name=identifier}} T {{hello}}E{{hello}} S {{hello}}T
EOT;

    $oTemplate = new Template($sTemplateText, null, true);
    
    $oTemplate->replaceIdentifierMultiple('identifier', '');
    $oTemplate->replaceIdentifier('main_navigation_name', 'hello');
    
    $this->assertEquals("BEFORE s\n T E S T", $oTemplate->render());
  }
}
