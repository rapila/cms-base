<?php
/**
 * @package test
 */
class StringPeerTests extends PHPUnit\Framework\TestCase {
	public function testSimpleString() {
		$this->assertSame("Deutsch", TranslationPeer::getString("language.de", "de"));
	}
	public function testTemplateString() {
		$this->assertSame("Schlagwörter (Tags)", TranslationPeer::getString("module.admin.tags", "de"));
	}
}