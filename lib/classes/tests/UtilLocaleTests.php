<?php
/**
 * @package test
 */
class UtilLocaleTests extends PHPUnit_Framework_TestCase {
  public function testGetPreferredLanguage() {
    Session::getSession()->resetAttribute("preferred_user_language");
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "de-ch,en-us;q=0.7,en;q=0.3";
    $this->assertEquals("de", Util::getPreferredUserLanguage());
  }
  
  public function testGetPreferredLanguageComplex() {
    Session::getSession()->resetAttribute("preferred_user_language");
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en,en-us;q=0.7,en-uk;q=0.3";
    $this->assertEquals("en", Util::getPreferredUserLanguage());
  }
  
  public function testGetLocaleId() {
    Session::getSession()->resetAttribute("preferred_user_language");
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en,en-us;q=0.7,en-uk;q=0.3";
    $this->assertEquals("en_US", Util::getLocaleId("en"));
  }
}