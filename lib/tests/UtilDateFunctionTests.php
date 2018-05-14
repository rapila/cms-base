<?php
/**
 * @package test
 */
class UtilDateFunctionTests extends PHPUnit\Framework\TestCase {
	public function setUp() {
		LocaleUtil::$ACCEPT_LOCALE_LISTS = array();
	}

	public function testDateParserDE() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
		$iDate = 0;
		$this->assertSame("01.01.1970", LocaleUtil::localizeDate($iDate, "de"));
	}
	public function testDateParserLaterDE() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
		$iDate = 1202299952;
		$this->assertSame("06.02.2008", LocaleUtil::localizeDate($iDate, "de"));
	}
	public function testDateParserNegativeDE() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
		$iDate = -1202299952;
		$this->assertSame("26.11.1931", LocaleUtil::localizeDate($iDate, "de"));
	}
	public function testDateParserNegativeEN() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US";
		$iDate = -1202299952;
		$this->assertSame("11/26/1931", LocaleUtil::localizeDate($iDate, "en"));
	}
	public function testDateParserNegativeENGB() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-GB";
		$iDate = -1202299952;
		$this->assertContains("26/11/", LocaleUtil::localizeDate($iDate, "en"));
		$this->assertContains("31", LocaleUtil::localizeDate($iDate, "en"));
	}
	public function testGetLocaleIdEN() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT,en_GB";
		$this->assertSame("en_US", LocaleUtil::getLocaleId("en"));
	}
	public function testGetLocaleIdENq() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "de-DE ; q = 0.3,en-US;q=0.8,de-AT";
		$this->assertSame("de_AT", LocaleUtil::getLocaleId("de"));
	}
	public function testGetLocaleIdENqSearchEngine() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "de-CH;,de-DE;q = 0.3,en-US;q=0.8,de-AT;,de-DE;0.4";
		$this->assertSame("de_CH", LocaleUtil::getLocaleId("de"));
	}
	public function testGetLocaleIdDE() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-AT";
		$this->assertSame("de_AT", LocaleUtil::getLocaleId("de"));
	}
	public function testParseBack() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
		$sDate = "01.01.1970";
		$this->assertSame(0, LocaleUtil::parseLocalizedDate($sDate, "de"));
	}
	// public function testParseBackLongDate() {
	//	 $_SERVER['HTTP_ACCEPT_LANGUAGE'] = "";
	//	 $sDate = "Mi 06 Feb 2008 14:21:00 CET";
	//	 $this->assertSame($sDate, LocaleUtil::localizeDate(LocaleUtil::parseLocalizedDate($sDate, "de", "c"), "de", "c"));
	// }
	public function testParseBackLongDateAsInGems() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-gb,en;q=0.8,de-de;q=0.5,de-ch;q=0.3";
		$sDate = "10.03.2008";
		$iTimestamp = LocaleUtil::parseLocalizedDate($sDate, "de");
		$this->assertSame(1205107200, $iTimestamp);
		$this->assertSame($sDate, LocaleUtil::localizeDate($iTimestamp, "de"));
	}
	
	public function testMonthNameLocale() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT";
		$this->assertSame('Januar', LocaleUtil::getMonthNameByMonthId(1, "de", true));
		$this->assertSame('January', LocaleUtil::getMonthNameByMonthId(1, "en", true));
		$this->assertSame('Feb', LocaleUtil::getMonthNameByMonthId(2, "de", false));
		$this->assertSame('Feb', LocaleUtil::getMonthNameByMonthId(2, "en", false));
		$this->assertSame('Mär', LocaleUtil::getMonthNameByMonthId(3, "de", false));
		$this->assertSame('Mar', LocaleUtil::getMonthNameByMonthId(3, "en", false));
	}
	
	public function testWeekdayNameLocale() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-US,de-DE,de-AT";
		$this->assertSame('Montag', LocaleUtil::getDayNameByWeekday(1, "de", true));
		$this->assertSame('Monday', LocaleUtil::getDayNameByWeekday(1, "en", true));
		$this->assertSame('Di', LocaleUtil::getDayNameByWeekday(2, "de", false));
		$this->assertSame('Tue', LocaleUtil::getDayNameByWeekday(2, "en", false));
		$this->assertSame('Mi', LocaleUtil::getDayNameByWeekday(3, "de", false));
		$this->assertSame('Wed', LocaleUtil::getDayNameByWeekday(3, "en", false));
	}
}