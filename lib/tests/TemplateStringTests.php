<?php
/**
 * @package test
 */
class TemplateStringTests extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		StringPeer::setStaticStrings(array(
			'de' => array(
				'name' => 'Name',
				'key' => 'Schlüssel',
				'value' => '\'Wert(e)\' {{br}}',
				'quote' => '{{quoteString=\\{\\{quoted\\}\\};}}',
				'simple_quote' => '>{{quoted}}<'
			)
		));
	}
	
	public function testStringWithoutHTMLAsNormal() {
		$sString = StringPeer::getString('name', 'de');
		$this->assertSame("Name", $sString);
		$sString = StringPeer::getString('key', 'de');
		$this->assertSame("Schlüssel", $sString);
	}
	
	public function testStringWithoutHTMLAsTemplate() {
		$sString1 = StringPeer::getString('name', 'de');
		$sString2 = StringPeer::getString('key', 'de');
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifierMultiple('string', $sString1);
		$oTemplate->replaceIdentifierMultiple('string', $sString2);
		$this->assertSame("Name
Schlüssel
", $oTemplate->render());
	}
	
	public function testStringWithHTMLAsNormal() {
		$sString = StringPeer::getString('value', 'de');
		$this->assertSame("'Wert(e)' <br />", $sString);
	}
	
	public function testStringWithHTMLAsTemplate() {
		$sString = StringPeer::getString('value', 'de');
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("&#039;Wert(e)&#039; &lt;br /&gt;", $oTemplate->render());
		$sString = StringPeer::getString('value', 'de', null, null, true);
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("&#039;Wert(e)&#039; <br />", $oTemplate->render());
		$sString = StringPeer::getString('value', 'de', null, null, true);
		$this->assertSame("&#039;Wert(e)&#039; <br />", $sString->render());
	}
	
	public function testStringStrippingHTML() {
		$sString = StringPeer::getString('value', 'de', null, null, null);
		$this->assertSame("'Wert(e)' 
", $sString);
		$sString = StringPeer::getString('name', 'de', null, null, null);
		$this->assertSame("Name", $sString);
	}
	
	public function testPStringWithoutHTMLAsNormal() {
		$sString = StringPeer::getString('quote', 'de', null, array('quoted' => 'String'));
		$this->assertSame("„String“", $sString);
	}
	
	public function testPStringWithoutHTMLAsTemplate() {
		$sString = StringPeer::getString('quote', 'de', null, array('quoted' => 'String'));
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("„String“", $oTemplate->render());
	}
	
	public function testPStringWithHTMLAsNormal() {
		$sString = StringPeer::getString('simple_quote', 'de', null, array('quoted' => 'String'));
		$this->assertSame(">String<", $sString);
	}
	
	public function testPStringWithHTMLAsTemplate() {
		$sString = StringPeer::getString('simple_quote', 'de', null, array('quoted' => 'String'));
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('string'), null, true);
		$oTemplate->replaceIdentifier('string', $sString);
		$this->assertSame("&gt;String&lt;", $oTemplate->render());
	}
	
	public function testPStringStrippingHTML() {
		$sString = StringPeer::getString('simple_quote', 'de', null, array('quoted' => 'String'), null);
		$this->assertSame(">String<", $sString);
	}
	
}