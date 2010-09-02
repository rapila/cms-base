<?php
/**
 * @package utils
 */

class StringUtil {
	public static function encodeFromDatabase($sText) {
		return self::encodeForBrowser($sText, Settings::getSetting("encoding", "db", "utf-8"));
	}

	public static function encodeForBrowser($sText, $sEncoding="utf-8") {
		$sBrowserEncoding = Settings::getSetting("encoding", "browser", "utf-8");
		return self::encode($sText, $sEncoding, $sBrowserEncoding);
	}

	public static function encodeForDbFromFile($sText) {
		$sDbEncoding = Settings::getSetting("encoding", "db", "utf-8");
		return self::encode($sText, 'utf-8', $sDbEncoding);
	}

	public static function encode($sText, $sEncoding, $sDestinationEncoding) {
		if($sEncoding == $sDestinationEncoding) {
			return $sText;
		}
		return iconv($sEncoding, "$sDestinationEncoding//TRANSLIT", $sText);
	}

	public static function camelize($sString, $bUcFirst=false) {
		$aExploded = explode('_', $sString);
		$sResult = '';
		foreach($aExploded as $key => $value){
			if($bUcFirst || ($key > 0)) {
				$sResult.= ucfirst($value);
			} else {
				$sResult.= $value;
			}
		}
		return $sResult;
	}

	public static function deCamelize($sString) {
		$sResult = "";
		$iStrLen = strlen($sString);
		for($i=0;$i<$iStrLen;$i++) {
			$cPart = substr($sString, $i, 1);
			if(preg_match("/[A-Z]/", $cPart) && $i>0) {
				$sResult .= "_".strtolower($cPart);
			} else {
				$sResult .= strtolower($cPart);
			}
		}
		return $sResult;
	}

	public static function makeReadableName($sString, $sExplodeString='_') {
		$aSplit = explode($sExplodeString, $sString);
		foreach($aSplit as $i => $sChunks) {
			$aSplit[$i] = ucfirst($sChunks);
		}
		return implode(" ", $aSplit);
	}

	public static function endsWith($str, $end) {
		return substr($str, -strlen($end)) === $end;
	}

	public static function startsWith($str, $start) {
		return substr($str, 0, strlen($start)) === $start;
	}

	public static function truncate($sText, $iLength=20, $sPostfix="…", $iTolerance=3) {
		if(mb_strlen($sText) > $iLength+$iTolerance) {
			$sText = mb_substr($sText, 0, $iLength).$sPostfix;
		}
		return $sText;
	}

	// implement preg_replace with		 
	// $aUmlaut = array('/Ä/', '/ä/', '/Ö/', '/ö/', '/Ü/', '/ü/') 
	// $aReplace = array('ae', 'ae', 'oe', 'oe', 'ue', 'ue');
	public static function normalize($sInput, $sReplaceSpaceBy = '-') {
		if($sInput === null || $sInput === '') {
			return null;
		}
		$sInput = str_replace(array('ä', 'ö', 'ü'), array('ae', 'oe', 'ue'), mb_strtolower($sInput));
		$sInput = @iconv(Settings::getSetting('encoding', 'browser', 'utf-8'), 'US-ASCII//TRANSLIT', $sInput);
		$sInput = mb_ereg_replace('-|–|—', '-', $sInput);
		$sInput = mb_ereg_replace('\s+', $sReplaceSpaceBy, $sInput);
		$sNewName = strtolower(preg_replace("/([^\\w\\d\-_])/u", "", $sInput));
		if($sNewName !== "") {
			return $sNewName;
		} else {
			return null;
		}
	}

	public static function getWords($sString, $bFromHtml=false) {
		if($sString instanceof Template) {
			$sString = $sString->render();
		}

		if($bFromHtml) {
			$aReplaceByLinebreak = array('<br />', '<br/>', '<br>', '</p><p>', '</li><li>', '</div><div>');
			$sString = str_replace($aReplaceByLinebreak, "\n", $sString);
			$sString = html_entity_decode(strip_tags($sString), ENT_QUOTES, Settings::getSetting('encoding', 'browser', 'utf-8'));
		}

		$aWords = mb_split("[^\w\-–—]+", $sString);
		$aResult = array();
		foreach($aWords as $sWord) {
			$sWord = self::normalize($sWord);
			if($sWord !== null) {
				$aResult[] = $sWord;
			}
		}
		return $aResult;
	}
}