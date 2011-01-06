<?php
/**
 * @package utils
 */
 
class LocaleUtil {

	//Gets the user's locale for the current language
	public static function getLocaleId($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$sAcceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
			$aAcceptLanguages = explode(',' , $sAcceptLanguage);
			foreach($aAcceptLanguages as $sLocaleIdWithQ) {
				$aLocaleIdWithQ = explode(';', $sLocaleIdWithQ);
				$sLocaleId = $aLocaleIdWithQ[0];
				$aLocaleIds = explode('-' , $sLocaleId);
				$sAcceptLang = $aLocaleIds[0];
				if($sAcceptLang == $sLanguageId && isset($aLocaleIds[1])) {
					return $sAcceptLang."_".strtoupper($aLocaleIds[1]);
				}
			}
		}
		return $sLanguageId."_".strtoupper($sLanguageId);
	}

	/**
	* Sets the locale settings of a given locale category to the passed locale. If a language is passed instead of a locale, the locale is searched using {@link LocaleUtil::getLocaleId()}. This function tries to set the locale using the current browser output encoding. If this fails, it tries to set the locale with the default encoding.
	*/
	public static function setLocaleToLanguageId($sLanguageId, $iCategory = LC_ALL) {
		if(strpos($sLanguageId, "_") === false) {
			$sLanguageId = self::getLocaleId($sLanguageId);
		}
		$sEncoding = strtoupper(Settings::getSetting("encoding", "browser", "utf-8"));
		setlocale($iCategory, "$sLanguageId.$sEncoding");
		if(setlocale($iCategory, "0") !== "$sLanguageId.$sEncoding") {
			setlocale($iCategory, $sLanguageId);
			if(setlocale($iCategory, "0") !== $sLanguageId) {
				$sLanguageId = substr($sLanguageId, 0, strpos($sLanguageId, "_"));
				setlocale($iCategory, $sLanguageId);
			}
		}
	}

	public static function localizeDate($iTimestamp = null, $sLanguageId = null, $sFormat="x") {
		if($iTimestamp === null) {
			$iTimestamp = time();
		}
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		self::setLocaleToLanguageId($sLanguageId, LC_TIME);

		if(is_string($iTimestamp)) {
			$iTimestamp = strtotime($iTimestamp);
		}
		return strftime("%$sFormat", $iTimestamp);
	}

	public static function parseLocalizedDate($sDate, $sLanguageId, $sFormat="x") {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		self::setLocaleToLanguageId($sLanguageId, LC_TIME);

		$aResult = strptime($sDate, "%$sFormat");
		if($aResult === false) {
			return null;
		}

		//Some variations of strptime seem to return invalid values for hour, minute and second
		if($aResult['tm_hour'] < 0 || $aResult['tm_hour'] > 23) {
			$aResult['tm_hour'] = 0;
		}
		if($aResult['tm_min'] < 0 || $aResult['tm_min'] > 59) {
			$aResult['tm_min'] = 0;
		}
		if($aResult['tm_sec'] < 0 || $aResult['tm_sec'] > 61) {
			$aResult['tm_sec'] = 0;
		}

		return mktime($aResult['tm_hour'], $aResult['tm_min'], $aResult['tm_sec'], $aResult['tm_mon']+1, $aResult['tm_mday'], $aResult['tm_year']+1900);
	}

	public static function localizeTimestamp($iTimestamp, $sLanguageId = null, $bShowTimeShort = false) {
		if ($bShowTimeShort) {
			return substr(self::localizeDate($iTimestamp, $sLanguageId, "X"), 0, 5);
		}
		return self::localizeDate($iTimestamp, $sLanguageId, "X");
	}

	public static function normalizeDate($sDate, $sSeparator = '-') {
		return preg_replace("/[^\d]/", $sSeparator, $sDate);
	}

	public static function localizeTime($iTime, $sSeparator = '.') {
		$sTime = substr($iTime, 0, 5);
		return str_replace (':', $sSeparator, $sTime);
	}
																			
	public static function getMonthNameByMonthId($iMonthId, $sLanguageId=null, $bIsLong=true) {
		$iTimestamp = mktime(0, 0, 0, $iMonthId, 02, 1973);
		return self::localizeDate($iTimestamp, $sLanguageId, $bIsLong ? 'B' : 'b');
	}
																
	public static function getDayNameByWeekday($iWeekday, $sLanguageId=null, $bIsLong=true) {
		//1973 started with a monday
		$iTimestamp = mktime(0, 0, 0, 01, $iWeekday, 1973);
		return self::localizeDate($iTimestamp, $sLanguageId, $bIsLong ? 'A' : 'a');
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