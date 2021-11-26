<?php
/**
 * @package test
 */
class UtilDateFunctionTests extends PHPUnit\Framework\TestCase {
	public function setUp(): void {
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
		$this->assertSame("Nov 26, 1931", LocaleUtil::localizeDate($iDate, "en"));
	}
	public function testDateParserNegativeENGB() {
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = "en-GB";
		$iDate = -1202299952;
		$this->assertSame("26 Nov 1931", LocaleUtil::localizeDate($iDate, "en"));
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

	public function testStrftimeReplacement_simple() {
		$oDateInTimezone = new DateTimeImmutable('2020-04-05T23:30', new DateTimeZone('+300'));
		$this->assertSame('', LocaleUtil::strftime('%j', $oDateInTimezone, 'en-US'), 'Ignore Unsupported %j');
		$sFormat = '%d, %e, %u, %w, %V, %m, %g, %G, %y, %Y, %H, %k, %I, %l, %M, %p, %P, %r, %R, %S, %z, %Z, %D, %F, %s, %n, %t, %%';
		$this->assertSame(
			"05, 5, 7, 0, 14, 04, 20, 2020, 20, 2020, 23, 23, 11, 11, 30, PM, pm, 11:30:00 PM, 23:30, 00, +0300, GMT+0300, 04/05/20, 2020-04-05, 1586118600, \n, \t, %",
			LocaleUtil::strftime(
				$sFormat,
				$oDateInTimezone,
				'en-US'
			),
		);
		$this->assertSame(
			"05, 5, 7, 0, 14, 04, 20, 2020, 20, 2020, 23, 23, 11, 11, 30, PM, pm, 11:30:00 PM, 23:30, 00, +0300, GMT+0300, 04/05/20, 2020-04-05, 1586118600, \n, \t, %",
			LocaleUtil::strftime(
				$sFormat,
				$oDateInTimezone,
				'de-CH'
			),
		);
	}

	public function testStrftimeReplacement_localeDependent() {
		$oDateInTimezone = new DateTimeImmutable('2020-04-05T23:30', new DateTimeZone('+300'));
		$sFormat = '%x, %X, %c, %a, %A, %U, %b, %B, %h, %T';
		$this->assertSame(
			"5 Apr 2020, 20:30, 5 Apr 2020, 20:30:00, Sun, Sunday, 14, Apr, April, Apr, 20:30:00",
			LocaleUtil::strftime(
				$sFormat,
				$oDateInTimezone,
				'en-GB'
			),
		);
		$this->assertSame(
			"Apr 5, 2020, 8:30 PM, Apr 5, 2020, 8:30:00 PM, Sun, Sunday, 15, Apr, April, Apr, 8:30:00 PM",
			LocaleUtil::strftime(
				$sFormat,
				$oDateInTimezone,
				'en-US'
			),
		);
		$this->assertSame(
			"05.04.2020, 20:30, 05.04.2020, 20:30:00, So, Sonntag, 14, Apr, April, Apr., 20:30:00",
			LocaleUtil::strftime(
				$sFormat,
				$oDateInTimezone,
				'de-CH'
			),
		);
		$this->assertSame(
			"5/04/2020, 20:30, 5/04/2020 20:30:00, dom., domingo, 15, abr., abril, abr., 20:30:00",
			LocaleUtil::strftime(
				$sFormat,
				$oDateInTimezone,
				'es-GT'
			),
		);
	}
}
