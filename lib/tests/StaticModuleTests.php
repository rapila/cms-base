<?php
/**
 * @package test
 */
class StaticModuleTests extends PHPUnit_Framework_TestCase {
  public function testModuleTypeList() {
    $this->assertEquals(array('backend', 'file', 'frontend', 'page_type', 'filter'), Module::listModuleTypes());
  }
  
  public function testAllModulesList() {
    Template::NO_HTML_ESCAPE; //use template
    $this->assertGreaterThan(1, count(Module::listAllModules()));
  }
}