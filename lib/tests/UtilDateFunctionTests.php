<?php
/**
 * @package test
 */
class UtilDateFunctionTests extends PHPUnit_Framework_TestCase {
  public function testDateParserDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $iDate = 0;
    $this->assertEquals("01.01.1970", Util::localizeDate($iDate, "de"));
  }
  public function testDateParserLaterDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $iDate = 1202299952;
    $this->assertEquals("06.02.2008", Util::localizeDate($iDate, "de"));
  }
  public function testDateParserNegativeDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $iDate = -1202299952;
    $this->assertEquals("26.11.1931", Util::localizeDate($iDate, "de"));
  }
  public function testDateParserNegativeEN() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US";
    $iDate = -1202299952;
    $this->assertEquals("11/26/1931", Util::localizeDate($iDate, "en"));
  }
  public function testDateParserNegativeENGB() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-GB";
    $iDate = -1202299952;
    $this->assertEquals("26/11/1931", Util::localizeDate($iDate, "en"));
  }
  public function testGetLocaleIdEN() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT";
    $this->assertEquals("en_US", Util::getLocaleId("en"));
  }
  public function testGetLocaleIdDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-AT";
    $this->assertEquals("de_AT", Util::getLocaleId("de"));
  }
  public function testParseBack() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $sDate = "01.01.1970";
    $this->assertEquals(-3600, Util::parseLocalizedDate($sDate, "de"));
  }
  // public function testParseBackLongDate() {
  //   $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
  //   $sDate = "Mi 06 Feb 2008 14:21:00 CET";
  //   $this->assertEquals($sDate, Util::localizeDate(Util::parseLocalizedDate($sDate, "de", "c"), "de", "c"));
  // }
  public function testParseBackLongDateAsInGems() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-gb,en;q=0.8,de-de;q=0.5,de-ch;q=0.3";
    $sDate = "10.03.2008";
    $iTimestamp = Util::parseLocalizedDate($sDate, "de");
    $this->assertEquals(1205103600, $iTimestamp);
    $this->assertEquals($sDate, Util::localizeDate($iTimestamp, "de"));
  }
}