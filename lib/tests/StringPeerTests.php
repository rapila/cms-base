<?php
/**
 * @package test
 */
class StringPeerTests extends PHPUnit_Framework_TestCase {
	public function testSimpleString() {
		$this->assertSame("Deutsch", TranslationPeer::getString("language.de", "de"));
	}
	public function testTemplateString() {
		$this->assertSame("Schlagwörter (Tags)", TranslationPeer::getString("module.admin.tags", "de"));
	}
}