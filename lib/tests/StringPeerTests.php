<?php
/**
 * @package test
 */
class StringPeerTests extends PHPUnit_Framework_TestCase {
  public function testSimpleString() {
    $this->assertSame("Deutsch", StringPeer::getString("language.de", "de"));
  }
  public function testTemplateString() {
    $this->assertSame("Tags", StringPeer::getString("module.admin.tags", "de"));
  }
  public function testReplacedTemplateString() {
    $this->assertSame("[vor] TEst", StringPeer::getString("page.sort_before", "de", null, array("name" => "TEst")));
  }
}