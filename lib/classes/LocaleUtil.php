<?php
/**
 * @package utils
 */

class LocaleUtil {

	private const SIMPLE_FORMATS = [
		'd' => 'd',
		'e' => 'j',
		'u' => 'N',
		'w' => 'w',
		'V' => 'W',
		'm' => 'm',
		'g' => 'y',
		'G' => 'Y',
		'y' => 'y',
		'Y' => 'Y',
		'H' => 'H',
		'k' => 'G',
		'I' => 'h',
		'l' => 'g',
		'M' => 'i',
		'p' => 'A',
		'P' => 'a',
		'r' => 'h:i:s A',
		'R' => 'H:i',
		'S' => 's',
		'z' => 'O',
		'Z' => 'T',
		'D' => 'm/d/y',
		'F' => 'Y-m-d',
		's' => 'U',
		'n' => "\n",
		't' => "\t",
		'%' => '%',
	];


	/// @VisibleForTesting
	public static $ACCEPT_LOCALE_LISTS = array();

	//Gets the user's locale for the current language
	public static function getLocaleId($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$aAccepts = self::acceptLocales($sLanguageId);
		if(count($aAccepts) > 0) {
			return $aAccepts[0]->language_id."_".$aAccepts[0]->country_code;
		}
		return $sLanguageId."_".strtoupper($sLanguageId);
	}

	public static function acceptLocales($sLanguageId = false) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		if(isset(self::$ACCEPT_LOCALE_LISTS[$sLanguageId])) {
			return self::$ACCEPT_LOCALE_LISTS[$sLanguageId];
		}
		$fQSlantAmount = 0.0001;
		$aResult = array();
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$sAcceptLanguage = trim($_SERVER['HTTP_ACCEPT_LANGUAGE']);
			if($sAcceptLanguage) {
				$aAcceptLanguages = explode(',' , $sAcceptLanguage);
				$fQSlant = $fQSlantAmount * count($aAcceptLanguages);
				foreach($aAcceptLanguages as $sLocaleIdWithQ) {
					$aLocaleIdWithQ = explode(';', $sLocaleIdWithQ);
					$aLocaleId = explode('-', $aLocaleIdWithQ[0]);
					$aQ = isset($aLocaleIdWithQ[1]) ? explode('=', $aLocaleIdWithQ[1]) : null;
					$oResult = new StdClass();
					$oResult->q = $aQ && isset($aQ[1]) ? (float) $aQ[1] : 1.0;
					$oResult->q_slanted = $oResult->q + $fQSlant;
					$fQSlant -= $fQSlantAmount;
					$oResult->language_id = strtolower($aLocaleId[0]);
					if($sLanguageId && $oResult->language_id !== $sLanguageId) {
						continue;
					}
					$oResult->country_code = strtoupper(isset($aLocaleId[1]) ? $aLocaleId[1] : $aLocaleId[0]);
					$aResult[] = $oResult;
				}
				// FIXME: This sort algorithm isn’t stable so we’re using $fQSlant to give higher priority to languages that come first
				usort($aResult, function($a, $b) {
					if($a->q_slanted > $b->q_slanted) { return -1; }
					if($a->q_slanted == $b->q_slanted) { return 0; }
					return 1;
				});
			}
		}
		self::$ACCEPT_LOCALE_LISTS[$sLanguageId] = $aResult;
		return $aResult;
	}

	/**
	* Searches the User-Agent’s Accept header for the best locale to use for the given language ID.
	*
	* If the passed argument is already a locale, it will be returned as-is.
	*/
	private static function getLocaleFromLanguageId(string $sLanguageId): string {
		$sLanguageId = str_replace('-', '_', $sLanguageId);
		if(strpos($sLanguageId, "_") === false) {
			$sLanguageId = self::getLocaleId($sLanguageId);
		}
		return $sLanguageId;
	}

	public static function strftime(string $sFormat, DateTimeInterface $oDate, string $sLocale) {
		$aLocaleDependentReplacements = [
			'x' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE); },
			'X' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::SHORT); },
			'c' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::MEDIUM, IntlDateFormatter::MEDIUM); },
			'a' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'ccc'); },
			'A' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'cccc'); },
			'U' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'ww'); },
			'b' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'LLL'); },
			'B' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'LLLL'); },
			'h' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, null, null, 'MMM'); },
			'T' => function(string $sLocale) { return new IntlDateFormatter($sLocale, IntlDateFormatter::NONE, IntlDateFormatter::MEDIUM); },
		];
		$sFormat = preg_replace_callback('/(?<!%)%(\w|%)/', function(array $aMatches) use($oDate, $aLocaleDependentReplacements, $sLocale) {
			$sFormatSpecifier = $aMatches[1];
			if(isset(self::SIMPLE_FORMATS[$sFormatSpecifier])) {
				return $oDate->format(self::SIMPLE_FORMATS[$sFormatSpecifier]);
			}
			if(isset($aLocaleDependentReplacements[$sFormatSpecifier])) {
				$oFormatter = $aLocaleDependentReplacements[$sFormatSpecifier]($sLocale);
				return $oFormatter->format($oDate);
			}
			return '';
		}, $sFormat);

		return $sFormat;
	}

	public static function localizeDate(
		$oTimestamp = false,
		$sLanguageId = null,
		string $sFormat = "%x",
		$oTimeZone = null
	) {
		if($oTimestamp === null) {
			return null;
		}

		// Figure out time zone
		if($oTimeZone === null) {
			if($oTimestamp instanceof DateTimeInterface && $oTimestamp->getTimezone() !== false) {
				$oTimeZone = $oTimestamp->getTimezone();
			} else {
				$oTimeZone = date_default_timezone_get();
			}
		}
		if(is_string($oTimeZone)) {
			$oTimeZone = new DateTimeZone($oTimeZone);
		}

		// Convert time to DateTimeInterface with attached time zone
		if($oTimestamp === false) {
			$iTimestamp = new DateTimeImmutable();
		}

		if($oTimestamp instanceof DateTime) {
			$oTimestamp = clone $oTimestamp;
			$oTimestamp->setTimezone($oTimeZone);
		} else if($oTimestamp instanceof DateTimeImmutable) {
			$oTimestamp = DateTime::createFromImmutable($oTimestamp);
			$oTimestamp->setTimezone($oTimeZone);
		} else if(is_numeric($oTimestamp)) {
			$oTimestamp = new DateTimeImmutable("@$oTimestamp", $oTimeZone);
		} else {
			$oTimestamp = new DateTimeImmutable($oTimestamp, $oTimeZone);
		}


		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}

		$sLocale = self::getLocaleFromLanguageId($sLanguageId);

		if($sLanguageId === '_') {
			// Special case: Use the date function instead of strftime (it offers more formats for locale-independent stuff)
			$sResult =  $oTimestamp->format($sFormat);
		} else {
			// add % only if not already set, double % are displayed differently on different server environment
			$sPrefix = '';
			if(strlen($sFormat) === 1) {
				$sPrefix = '%';
			}
			$sResult = self::strftime("$sPrefix$sFormat", $oTimestamp, $sLocale);
		}
		return $sResult;
	}

	public static function getMonthNameByMonthId($iMonthId, $sLanguageId=null, $bIsLong=true) {
		$iTimestamp = mktime(0, 0, 0, $iMonthId, 02, 1973);
		return self::localizeDate($iTimestamp, $sLanguageId, $bIsLong ? '%B' : '%b');
	}

	public static function getDayNameByWeekday($iWeekday, $sLanguageId=null, $bIsLong=true) {
		//1973 started with a monday
		$iTimestamp = mktime(0, 0, 0, 01, $iWeekday, 1973);
		return self::localizeDate($iTimestamp, $sLanguageId, $bIsLong ? '%A' : '%a');
	}

	public static function getPreferredUserLanguage() {
		if(Session::getSession()->hasAttribute("preferred_user_language")) {
			return Session::getSession()->getAttribute("preferred_user_language");
		}
		if(!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			return Session::language();
		}
		$sAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$aAcceptLanguages = explode(',' , $sAcceptLanguage);
		if(count($aAcceptLanguages) === 0) {
			return Session::language();
		}
		$aResult = array();
		foreach($aAcceptLanguages as $sLocaleIdWithQ) {
			$aLocaleIdWithQ = explode(';', $sLocaleIdWithQ);
			$sAcceptLang = $aLocaleIdWithQ[0];
			$sAcceptLang = explode('-' , $sAcceptLang);
			$sAcceptLang = $sAcceptLang[0];
			$iQ = 1.0;
			if(isset($aLocaleIdWithQ[1])) {
				$aLocaleIdWithQ = explode("=", $aLocaleIdWithQ[1]);
				if(isset($aLocaleIdWithQ[1])) {
					$iQ = (float)$aLocaleIdWithQ[1];
				}
			}
			if(!isset($aResult[$sAcceptLang]) || $aResult[$sAcceptLang] < $iQ) {
				$aResult[$sAcceptLang] = $iQ;
			}
		}
		arsort($aResult, SORT_NUMERIC);
		$aResult = array_keys($aResult);
		Session::getSession()->setAttribute("preferred_user_language", $aResult[0]);
		return $aResult[0];
	}
}
