<?php
/**
 * @package test
 */
class UtilLocaleTests extends PHPUnit\Framework\TestCase {
	public function setUp() {
		LocaleUtil::$ACCEPT_LOCALE_LISTS = array();
	}

	public function testGetPreferredLanguage() {
		Session::getSession()->resetAttribute("preferred_user_language");
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "de-ch,en-us;q=0.7,en;q=0.3";
		$this->assertSame("de", LocaleUtil::getPreferredUserLanguage());
	}
	
	public function testGetPreferredLanguageComplex() {
		Session::getSession()->resetAttribute("preferred_user_language");
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en,en-us;q=0.7,en-uk;q=0.3";
		$this->assertSame("en", LocaleUtil::getPreferredUserLanguage());
	}
	
	public function testGetLocaleId() {
		Session::getSession()->resetAttribute("preferred_user_language");
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en,en-us;q=0.7,en-uk;q=0.3";
		$this->assertSame("en_EN", LocaleUtil::getLocaleId("en"));
	}
}