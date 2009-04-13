<?php
/**
* @package test
*/
class TemplateReplacementTypeTests extends PHPUnit_Framework_TestCase {
  
  public function testStringReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 'SAMPLE');
    $this->assertSame("SAMPLE", $oTestTemplate->render());
  }
  
  public function testIntReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 1);
    $this->assertSame("1", $oTestTemplate->render());
  }
  
  public function testHighIntReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 999999999999999999);
    $this->assertSame("999999999999999999", $oTestTemplate->render());
  }
  
  public function testBooleanTrueReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', true);
    $this->assertSame("true", $oTestTemplate->render());
  }
  
  public function testBooleanFalseReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', false);
    $this->assertSame("false", $oTestTemplate->render());
  }
  
  public function testFloatReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 3.141597);
    $this->assertSame("3.141597", $oTestTemplate->render());
  }
  
  public function testObjectReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', new TagWriter('a'));
    $this->assertSame("&lt;a&gt;&lt;/a&gt;", $oTestTemplate->render());
  }
  
  public function testTemplateObjectReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTagWriter = new TagWriter('a');
    $oTestTemplate->replaceIdentifier('test', $oTagWriter->parse());
    $this->assertSame("<a></a>", $oTestTemplate->render());
  }
  
  public function testArrayAssocReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', array('test' => 'test'));
    $this->assertSame("test", $oTestTemplate->render());
  }
  
  public function testArrayReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', array('test', 'test'));
    $this->assertSame("testtest", $oTestTemplate->render());
  }
  
  public function testTypesInArrayReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', array('SAMPLE', 1, 9999999999, 3.1415972, new TagWriter('a')));
    $this->assertSame("SAMPLE199999999993.1415972&lt;a&gt;&lt;/a&gt;", $oTestTemplate->render());
  }
}