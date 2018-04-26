<?php
/**
 * @package test
 */
class TemplateStringTests extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		TranslationPeer::setStaticStrings(array(
			'de' => array(
				'name' => 'Name',
				'key' => 'Schlüssel',
				'value' => '\'Wert(e)\' {{br}}',
				'quote' => '{{quoteString=\\{\\{quoted\\}\\};}}',
				'simple_quote' => '>{{quoted}}<'
			)
		));
		Session::getSession()->setLanguage('de');
	}
	
	public function testStringWithoutHTMLAsNormal() {
		$sString = TranslationPeer::getString('name', 'de');
		$this->assertSame("Name", $sString);
		$sString = TranslationPeer::getString('key', 'de');
		$this->assertSame("Schlüssel", $sString);
	}
	
	public function testStringWithoutHTMLAsTemplate() {
		$sString1 = TranslationPeer::getString('name', 'de');
		$sString2 = TranslationPeer::getString('key', 'de');
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifierMultiple('string', $sString1);
		$oTemplate->replaceIdentifierMultiple('string', $sString2);
		$this->assertSame("Name
Schlüssel
", $oTemplate->render());
	}
	
	public function testStringWithHTMLAsNormal() {
		$sString = TranslationPeer::getString('value', 'de');
		$this->assertSame("'Wert(e)' <br />", $sString);
	}
	
	public function testStringWithHTMLAsTemplate() {
		$sString = TranslationPeer::getString('value', 'de');
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("&#039;Wert(e)&#039; &lt;br /&gt;", $oTemplate->render());
		$sString = TranslationPeer::getString('value', 'de', null, null, true);
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("&#039;Wert(e)&#039; <br />", $oTemplate->render());
		$sString = TranslationPeer::getString('value', 'de', null, null, true);
		$this->assertSame("&#039;Wert(e)&#039; <br />", $sString->render());
	}
	
	public function testStringStrippingHTML() {
		$sString = TranslationPeer::getString('value', 'de', null, null, null);
		$this->assertSame("'Wert(e)' 
", $sString);
		$sString = TranslationPeer::getString('name', 'de', null, null, null);
		$this->assertSame("Name", $sString);
	}
	
	public function testPStringWithoutHTMLAsNormal() {
		$sString = TranslationPeer::getString('quote', 'de', null, array('quoted' => 'String'));
		$this->assertSame("„String“", $sString);
	}
	
	public function testPStringWithoutHTMLAsTemplate() {
		$sString = TranslationPeer::getString('quote', 'de', null, array('quoted' => 'String'));
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("„String“", $oTemplate->render());
	}
	
	public function testPStringWithHTMLAsNormal() {
		$sString = TranslationPeer::getString('simple_quote', 'de', null, array('quoted' => 'String'));
		$this->assertSame(">String<", $sString);
	}
	
	public function testPStringWithHTMLAsTemplate() {
		$sString = TranslationPeer::getString('simple_quote', 'de', null, array('quoted' => 'String'));
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("&gt;String&lt;", $oTemplate->render());
	}
	
	public function testPStringStrippingHTML() {
		$sString = TranslationPeer::getString('simple_quote', 'de', null, array('quoted' => 'String'), null);
		$this->assertSame(">String<", $sString);
	}
	
}
