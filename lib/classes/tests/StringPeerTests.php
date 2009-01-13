<?php
/**
 * @package test
 */
class StringPeerTests extends PHPUnit_Framework_TestCase {
  public function testSimpleString() {
    $this->assertEquals("Deutsch", StringPeer::getString("language.de", "de"));
  }
  public function testTemplateString() {
    $this->assertEquals("Marken", StringPeer::getString("module.backend.tags", "de"));
  }
  public function testReplacedTemplateString() {
    $this->assertEquals("[vor] TEst", StringPeer::getString("sort_before", "de", null, array("name" => "TEst")));
  }
}