<?php
/**
 * @package test
 */
class StringPeerTests extends PHPUnit_Framework_TestCase {
	public function testSimpleString() {
		$this->assertSame("Deutsch", StringPeer::getString("language.de", "de"));
	}
	public function testTemplateString() {
		$this->assertSame("Schlagwörter (Tags)", StringPeer::getString("module.admin.tags", "de"));
	}
}