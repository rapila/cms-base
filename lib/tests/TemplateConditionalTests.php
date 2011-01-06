<?php
/**
 * @package test
 */

class TemplateTest extends PHPUnit_Framework_TestCase {
  public function testConditionalNestingError() {
    $sText = <<<EOT
{{if==;1=1;2=1}}test
EOT;
    try {
      $oTemplate = new Template($sText, null, true);
      $oTemplate->render();
    } catch (Exception $e) {
      return;
    }
    $this->fail("No Exception thrown, should have notified of incorrect nesting");
  }
  
  public function testSimpleExpressionEqual() {
    $sText = <<<EOT
{{if==;1=1;2=1}}true{{endIf}}{{if==;1=1;2=2}}false{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("true", $oTemplate->render());
  }
  
  public function testSimpleExpressionAbbreviated() {
    $sText = <<<EOT
{{if;1=}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("test", $oTemplate->render());
  }
  
  public function testExpressionAbbreviated() {
    $sText = <<<EOT
{{if;1=\{\{test\}\}}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("test", $oTemplate->render());
  }
  
  public function testExpressionAbbreviatedWithValue() {
    $sText = <<<EOT
{{if;1=\{\{test\}\}}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("test", "see");
    $this->assertSame("", $oTemplate->render());
  }
  
  public function testSimpleExpressionNotEqual() {
    $sText = <<<EOT
{{if=!=;1=1;2=2}}true{{endIf}}{{if=!=;1=1;2=1}}false{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("true", $oTemplate->render());
  }
  
  public function testSimpleExpressionGreaterThan() {
    $sText = <<<EOT
{{if=>;1=12;2=2}}true{{endIf}}{{if=>;1=22;2=232}}false{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("true", $oTemplate->render());
  }
  
  public function testSimpleExpressionLessThan() {
    $oTemplate = new Template("{{if=<;1=22;2=232}}true{{endIf}}{{if=<;1=232;2=22}}false{{endIf}}", null, true);
    $this->assertSame("true", $oTemplate->render());
  }
  
  public function testSimpleExpressionLessThanEqual() {
    $oTemplate = new Template("{{if=<=;1=22;2=22}}true{{endIf}} {{if=<=;1=2;2=22}}true{{endIf}}{{if=<=;1=233;2=22}}false{{endIf}}", null, true);
    $this->assertSame("true true", $oTemplate->render());
  }
  
  public function testSimpleExpressionGreaterThanEqual() {
    $oTemplate = new Template("{{if=>=;1=22;2=22}}true{{endIf}} {{if=>=;1=2;2=22}}false{{endIf}} {{if=>=;1=233;2=22}}true{{endIf}}", null, true);
    $this->assertSame("true  true", $oTemplate->render());
  }
  
  public function testConditionalsVariableNotEqualFalse() {
    $sText = <<<EOT
{{if=ne;1=\{\{test\}\};2=see}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("test", "see");
    $this->assertSame("", $oTemplate->render());
  }
  
  public function testConditionalsVariableNotEqualTrue() {
    $sText = <<<EOT
{{if=ne;1=\{\{test\}\};2=see}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("test", "seen");
    $this->assertSame("test", $oTemplate->render());
  }
  
  public function testConditionalsVariableNotEqualEmptyTrue() {
    $sText = <<<EOT
{{if=ne;1=\{\{test\}\};2=}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("test", "seen");
    $this->assertSame("test", $oTemplate->render());
  }
  
  public function testConditionalsVariableNotEqualEmptyFalse() {
    $sText = <<<EOT
{{if=ne;1=\{\{test\}\};2=}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("", $oTemplate->render());
  }
  
  public function testFunctionConditionalsExpression() {
    $sText = <<<EOT
{{if=~;1=/st/;2=string}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("test END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsExpressionNegative() {
    $sText = <<<EOT
{{if=~;1=/sta/;2=string}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame(" END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsVariableExpression() {
    $sText = <<<EOT
{{if=~;1=/st/;2=\{\{standard\}\}}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("standard", "intring");
    $this->assertSame(" END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsVariableExpressionNegative() {
    $sText = <<<EOT
{{if=~;1=/st/;2=\{\{standard\}\}}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("standard", "instring");
    $this->assertSame("test END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsContains() {
    $sText = <<<EOT
{{if=contains;2=/st/;1=/st/ring}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("test END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsContainsNegative() {
    $sText = <<<EOT
{{if=contains;2=/sta/;1=string}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame(" END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsVariableContains() {
    $sText = <<<EOT
{{if=contains;2=/st/;1=\{\{standard\}\}}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("standard", "in/tr/ing");
    $this->assertSame(" END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsVariableContainsNegative() {
    $sText = <<<EOT
{{if=contains;2=/st/;1=\{\{standard\}\}}}test{{endIf}} END
EOT;
    $oTemplate = new Template($sText, null, true);
    $oTemplate->replaceIdentifier("standard", "in/st/ring");
    $this->assertSame("test END", $oTemplate->render());
  }
  
  public function testFunctionConditionalsFileExists() {
    $sText = <<<EOT
{{if=file_exists;1=/base/config;2=true}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("test", $oTemplate->render());
  }
  
  public function testFunctionConditionalsFileExistsFalse() {
    $sText = <<<EOT
{{if=file_exists;1=/base/config;2=false}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("", $oTemplate->render());
  }
  
  public function testFunctionConditionalsFileNotExists() {
    $sText = <<<EOT
{{if=file_exists;1=/configs;2=true}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("", $oTemplate->render());
  }
  
  public function testFunctionConditionalsFileNotExistsFalse() {
    $sText = <<<EOT
{{if=file_exists;1=/configs;2=false}}test{{endIf}}
EOT;
    $oTemplate = new Template($sText, null, true);
    $this->assertSame("test", $oTemplate->render());
  }
}