<?php
/**
* @package test
*/
class TemplateReplacementTypeTests extends PHPUnit_Framework_TestCase {
  
  public function testStringReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 'SAMPLE');
    $this->assertEquals("SAMPLE", $oTestTemplate->render());
  }
  
  public function testIntReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 1);
    $this->assertEquals("1", $oTestTemplate->render());
  }
  
  public function testHighIntReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 999999999999999999999999999999999999);
    $this->assertEquals("999999999999999999999999999999999999", $oTestTemplate->render());
  }
  
  public function testBooleanTrueReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', true);
    $this->assertEquals("true", $oTestTemplate->render());
  }
  
  public function testBooleanFalseReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', false);
    $this->assertEquals("false", $oTestTemplate->render());
  }
  
  public function testFloatReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', 3.1415972);
    $this->assertEquals("3.1415972", $oTestTemplate->render());
  }
  
  public function testObjectReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', new TagWriter('a'));
    $this->assertEquals("&lt;a&gt;&lt;/a&gt;", $oTestTemplate->render());
  }
  
  public function testTemplateObjectReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTagWriter = new TagWriter('a');
    $oTestTemplate->replaceIdentifier('test', $oTagWriter->parse());
    $this->assertEquals("<a></a>", $oTestTemplate->render());
  }
  
  public function testArrayAssocReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', array('test' => 'test'));
    $this->assertEquals("test", $oTestTemplate->render());
  }
  
  public function testArrayReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', array('test', 'test'));
    $this->assertEquals("testtest", $oTestTemplate->render());
  }
  
  public function testTypesInArrayReplace() {
    $oTestTemplate = new Template('{{test}}', null, true);
    $oTestTemplate->replaceIdentifier('test', array('SAMPLE', 1, 9999999999, 3.1415972, new TagWriter('a')));
    $this->assertEquals("SAMPLE199999999993.1415972&lt;a&gt;&lt;/a&gt;", $oTestTemplate->render());
  }
}