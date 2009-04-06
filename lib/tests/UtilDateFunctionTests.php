<?php
/**
 * @package test
 */
class UtilDateFunctionTests extends PHPUnit_Framework_TestCase {
  public function testDateParserDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $iDate = 0;
    $this->assertEquals("01.01.1970", LocaleUtil::localizeDate($iDate, "de"));
  }
  public function testDateParserLaterDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $iDate = 1202299952;
    $this->assertEquals("06.02.2008", LocaleUtil::localizeDate($iDate, "de"));
  }
  public function testDateParserNegativeDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $iDate = -1202299952;
    $this->assertEquals("26.11.1931", LocaleUtil::localizeDate($iDate, "de"));
  }
  public function testDateParserNegativeEN() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US";
    $iDate = -1202299952;
    $this->assertEquals("11/26/1931", LocaleUtil::localizeDate($iDate, "en"));
  }
  public function testDateParserNegativeENGB() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-GB";
    $iDate = -1202299952;
    $this->assertEquals("26/11/1931", LocaleUtil::localizeDate($iDate, "en"));
  }
  public function testGetLocaleIdEN() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT";
    $this->assertEquals("en_US", LocaleUtil::getLocaleId("en"));
  }
  public function testGetLocaleIdDE() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-AT";
    $this->assertEquals("de_AT", LocaleUtil::getLocaleId("de"));
  }
  public function testParseBack() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
    $sDate = "01.01.1970";
    $this->assertEquals(-3600, LocaleUtil::parseLocalizedDate($sDate, "de"));
  }
  // public function testParseBackLongDate() {
  //   $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
  //   $sDate = "Mi 06 Feb 2008 14:21:00 CET";
  //   $this->assertEquals($sDate, LocaleUtil::localizeDate(LocaleUtil::parseLocalizedDate($sDate, "de", "c"), "de", "c"));
  // }
  public function testParseBackLongDateAsInGems() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-gb,en;q=0.8,de-de;q=0.5,de-ch;q=0.3";
    $sDate = "10.03.2008";
    $iTimestamp = LocaleUtil::parseLocalizedDate($sDate, "de");
    $this->assertEquals(1205103600, $iTimestamp);
    $this->assertEquals($sDate, LocaleUtil::localizeDate($iTimestamp, "de"));
  }
  
  public function testMonthNameLocale() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT";
    $this->assertEquals('Januar', LocaleUtil::getMonthNameByMonthId(1, "de", true));
    $this->assertEquals('January', LocaleUtil::getMonthNameByMonthId(1, "en", true));
    $this->assertEquals('Feb', LocaleUtil::getMonthNameByMonthId(2, "de", false));
    $this->assertEquals('Feb', LocaleUtil::getMonthNameByMonthId(2, "en", false));
    $this->assertEquals('Mär', LocaleUtil::getMonthNameByMonthId(3, "de", false));
    $this->assertEquals('Mar', LocaleUtil::getMonthNameByMonthId(3, "en", false));
  }
  
  public function testWeekdayNameLocale() {
    $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT";
    $this->assertEquals('Montag', LocaleUtil::getDayNameByWeekday(1, "de", true));
    $this->assertEquals('Monday', LocaleUtil::getDayNameByWeekday(1, "en", true));
    $this->assertEquals('Di', LocaleUtil::getDayNameByWeekday(2, "de", false));
    $this->assertEquals('Tue', LocaleUtil::getDayNameByWeekday(2, "en", false));
    $this->assertEquals('Mi', LocaleUtil::getDayNameByWeekday(3, "de", false));
    $this->assertEquals('Wed', LocaleUtil::getDayNameByWeekday(3, "en", false));
  }
}