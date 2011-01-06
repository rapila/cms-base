<?php
/**
 * @package test
 */
class StaticModuleTests extends PHPUnit_Framework_TestCase {
  public function testModuleTypeList() {
    $this->assertGreaterThanOrEqual(array('backend', 'file', 'frontend', 'page_type'), Module::listModuleTypes());
  }
  
  public function testAllModulesList() {
    Template::NO_HTML_ESCAPE; //use template
    $this->assertGreaterThan(5, count(Module::listAllModules()));
  }
}