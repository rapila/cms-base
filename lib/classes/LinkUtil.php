<?php
/**
 * @package utils
 */

class LinkUtil {

	private static $LAST_MODIFIED_SENT = false;
	private static $EXPIRES_SENT = false;

	const DATE_RFC2616 = 'D, d M Y H:i:s \G\M\T';

	public static function redirectToManager($mPath="", $mManager=null, $aParameters=array(), $bIncludeLanguage=null, $bPermanent=false) {
		self::redirect(LinkUtil::link($mPath, $mManager, $aParameters, $bIncludeLanguage), null, 'default', $bPermanent);
	}

	//redirectToLanguage can only be used if language attribute is still in REQUEST_PATH (if it ever was)
	public static function redirectToLanguage($sLanguageId = null) {
		if($sLanguageId == null) {
			$sLanguageId = Session::language();
		}
		$oLanguage = LanguageQuery::language($sLanguageId)->findOne();
		$sLanguageInPathId = null;
		if(Manager::hasNextPathItem()) {
			$oLanguageInPath = LanguageQuery::language(Manager::peekNextPathItem(), true)->findOne();
			if($oLanguageInPath && $oLanguageInPath->getIsActive()) {
				Manager::usePath();
				$sLanguageInPathId = $oLanguageInPath->getId();
			}
		}
		$sManager = Manager::getManagerClassNormalized(null);
		if($sManager::shouldIncludeLanguageInLink()) {
			if($sLanguageInPathId === $sLanguageId) {
				return;
			}
		} else if($sLanguageInPathId === null) {
			//Did not include language in link and should not
			return;
		}
		self::redirectToManager(Manager::getRequestPath(), $sManager, array(), $oLanguage);
	}

	/**
	* Redirects (locally by default).
	* Use with LinkUtil::link()ed URLs (because this redirect does not add the base path/context MAIN_DIR_FE).
	* Discards all buffered output and exits
	* Pass $sHost = false to mark $sLocation as absolute URL
	*/
	public static function redirect($sLocation, $sHost = null, $sProtocol = 'default', $bPermanent = true) {
		while(ob_get_level() > 0) {
			ob_end_clean();
		}
		if($bPermanent) {
			self::sendHTTPStatusCode(301, "Moved Permanently");
		} else {
			self::sendHTTPStatusCode(302, "Found");
		}
		if($sHost !== false) {
			$sLocation = self::absoluteLink($sLocation, $sHost, $sProtocol);
		}
		if(StringUtil::startsWith($sLocation, '//')) {
			$sLocation = (self::isSSL() ? 'https:' : 'http:').$sLocation;
		}
		$sRedirectString = "Location: $sLocation";
		header($sRedirectString);exit;
	}

	public static function sendHTTPStatusCode($iCode, $sName) {
		$sProtocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : 'HTTP/1.1';
		header("$sProtocol $iCode $sName", true, $iCode);
	}

	/**
	* Sends the cache control headers. Shortcut for calling sendLastModifiedAndCheckModifiedSince and sendExpires.
	* • Last-Modified and checks If-Modified-Since for a match (if so, terminates and sends a 304 Not Modified status code)
	* • Uses the given timestamp as base for calculation. If it is an object or a query, the updated-at field of the object (or the newest item that matches the query) is used.
	* • You can call this method twice if you created a new cache file and don’t have any other timestamp. It will only output the headers once.
	* @param $mLastModified The last-modified date to send. Can be one of the following:
	*                     • `null` to not send a last-modified (only applicable if the second argument is non-null)
	*                     • A UNIX timestamp as an integer
	*                     • A string to be parsed into a date using strtotime
	*                     • A DateTime object
	*                     • A Propel database object whose updated_at timestamp will be used
	*                     • A Propel query that will find the object most recently updated and use its updated_at timestamp
	* @param $mExpires The expires header to send. Can be one of the following:
	*                     • `null` to not send an expires header (only applicable if first argument is non-null)
	*                     • A DateInterval object
	*                     • A date interval spec in the form of Pxx (http://en.wikipedia.org/wiki/Iso8601#Durations) which will be added to today’s date
	*                     • A UNIX timestamp as an integer
	*                     • A string to be parsed into a date using strtotime
	*                     • A DateTime object
	*                     • A Cache object (which will be asked about the expiresTimestamp)
	*                     • `true` to expire in a year (the maxiumum permitted by RFC2616)
	*                     • `false` to mark as already expired (and to force re-evaluation)
	*/
	public static function sendCacheControlHeaders($mLastModified, $mExpires = null) {
		if($mExpires !== null) {
			self::sendExpires($mExpires);
		}
		if($mLastModified !== null) {
			self::sendLastModifiedAndCheckModifiedSince($mLastModified);
		}
	}

	/**
	* Version of sendCacheControlHeaders that uses a cache object to calculate the last-modified timestamp
	*/
	public static function sendCacheControlHeadersForCache($oCache) {
		self::sendExpires($oCache);
		if($oCache->entryExists(false) && $oCache->getStrategy()->supportsNotModified()) {
			$mLastModified = $oCache->getModificationDate();
			self::sendLastModifiedAndCheckModifiedSince($mLastModified);
		}
	}

	/**
	* Sends Last-Modified and checks If-Modified-Since for a match (if so, terminates and sends a 304 Not Modified status code). Uses the given timestamp as base for calculation. If it is an object or a query, the updated-at field of the object (or the newest item that matches the query) is used. You can call this method twice if you created a new cache file and don’t have any other timestamp. It will only output the headers once.
	* @param $mTimestamp The last-modified date to send. Can be one of the following:
	*                     • A UNIX timestamp as an integer
	*                     • A string to be parsed into a date using strtotime
	*                     • A DateTime object
	*                     • A Propel database object whose updated_at timestamp will be used
	*                     • A Propel query that will find the object most recently updated and use its updated_at timestamp
	*/
	public static function sendLastModifiedAndCheckModifiedSince($mTimestamp) {
		if(self::$LAST_MODIFIED_SENT) {
			return;
		}

		if($mTimestamp instanceof BaseObject) {
			$mTimestamp = $mTimestamp->getUpdatedAtTimestamp();
		}
		if($mTimestamp instanceof ModelCriteria) {
			$mTimestamp = $mTimestamp->findMostRecentUpdate();
		}
		if(is_string($mTimestamp)) {
			$mTimestamp = strtotime($mTimestamp);
		}
		if($mTimestamp === null) {
			return;
		}
		if($mTimestamp instanceof DateTime) {
			$mTimestamp = clone $mTimestamp;
			$mTimestamp->setTimezone(new DateTimeZone('UTC'));
		} else {
			$mTimestamp = new DateTime("@$mTimestamp");
		}

		header("Last-Modified: " . $mTimestamp->format(self::DATE_RFC2616));
		self::$LAST_MODIFIED_SENT = true;

		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			$oSinceDate = DateTime::createFromFormat(self::DATE_RFC2616, $_SERVER['HTTP_IF_MODIFIED_SINCE'], new DateTimeZone('UTC'));
			if($oSinceDate->getTimestamp() >= $mTimestamp->getTimestamp()) {
				self::sendHTTPStatusCode(304, 'Not Modified');
				header('Content-Length: 0');
				exit;
			}
		}
	}
	
	/**
	* Sends an expires header.
	* @param $mExpires The expires header to send. Can be one of the following:
	*                     • A DateInterval object
	*                     • A date interval spec in the form of Pxx (http://en.wikipedia.org/wiki/Iso8601#Durations) which will be added to today’s date
	*                     • A UNIX timestamp as an integer
	*                     • A string to be parsed into a date using strtotime
	*                     • A DateTime object
	*                     • A Cache object (which will be asked about the expiresTimestamp)
	*                     • `true` to expire in a year (the maxiumum permitted by RFC2616)
	*                     • `false` to mark as already expired (and to force re-evaluation)
	*/
	public static function sendExpires($mTimestamp) {
		if(self::$EXPIRES_SENT) {
			return;
		}
		if($mTimestamp instanceof Cache) {
			$mTimestamp = $mTimestamp->getStrategy()->expiresTimestamp($mTimestamp);
		}
		if($mTimestamp === true) {
			$mTimestamp = 'P1Y';
		}
		if(is_string($mTimestamp) && substr($mTimestamp, 0, 1) === 'P') {
			$mTimestamp = new DateInterval($mTimestamp);
		}
		if(is_string($mTimestamp)) {
			$mTimestamp = strtotime($mTimestamp);
		}
		if($mTimestamp === null) {
			return;
		}
		if($mTimestamp instanceof DateInterval) {
			$oDate = new DateTime('now', new DateTimeZone('UTC'));
			$mTimestamp = $oDate->add($mTimestamp);
		} else if($mTimestamp instanceof DateTime) {
			$mTimestamp = clone $mTimestamp;
			$mTimestamp->setTimezone(new DateTimeZone('UTC'));
		} else if(is_int($mTimestamp)) {
			$mTimestamp = new DateTime("@$mTimestamp");
		}
		// Format for output
		if($mTimestamp === false) {
			$mTimestamp = 0;
		} else {
			$mTimestamp = $mTimestamp->format(self::DATE_RFC2616);
		}
		header('Expires: '.$mTimestamp);
		self::$EXPIRES_SENT = true;
	}

	/**
	* Constructs an absolute link given a host-absolute location (starts with a slash)
	* @param string $sLocation the host-absolute location
	* @param string $sHost the host name to link to. will be inferred from the HTTP Host or the host name configured in domain_holder/domain. Precedence is given to the former unless the linking/prefer_configured_domain setting is true
	* @param string $sProtocol whether or not to link to the HTTPS version. 'default' reads the linking/ssl_in_absolute_links setting. 'auto' will use whatever is currently being used to access the site.
	*/
	public static function absoluteLink($sLocation, $sHost = null, $mProtocolSetting = 'default', $bAbsoluteLinkMayBeOmitted = false) {
		$sProtocol = self::getProtocol($mProtocolSetting);
		if($bAbsoluteLinkMayBeOmitted && Settings::getSetting('linking', 'always_link_absolutely', false) === false) {
			// If the current protocol differs from a clear preference given (explicit true or false), we still need to use an absolute link
			if($sProtocol === '//' || $mProtocolSetting === self::isSSL()) {
				return $sLocation;
			}
		}
		if($sHost === null) {
			$sHost = self::getHostName();
		}
		return "$sProtocol$sHost$sLocation";
	}
	
	public static function getProtocol(&$mProtocolSetting = 'default') {
		if($mProtocolSetting === 'default') {
			$mProtocolSetting = Settings::getSetting('linking', 'ssl_in_absolute_links', null);
		}
		if($mProtocolSetting === 'auto') {
			$mProtocolSetting = self::isSSL();
		}
		if($mProtocolSetting === null) {
			return '//';
		} else if($mProtocolSetting === true) {
			return 'https://';
		} else if($mProtocolSetting === false) {
			return 'http://';
		}
		return $mProtocolSetting;
	}

	public static function isSSL() {
		if(Settings::getSetting('general', 'trust_http_proxy_headers', false) === 'X-Forwarded') {
			if(!isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
				return false;
			}
			return strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https';
		} else {
			// http://stackoverflow.com/questions/7304182/detecting-ssl-with-php
			if(isset($_SERVER['HTTPS'])) {
				if('on' == strtolower($_SERVER['HTTPS'])) {
					return true;
				}
				if('1' == $_SERVER['HTTPS']) {
					return true;
				}
			} elseif (isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'])) {
				return true;
			}
			return false;
		}
	}

	public static function linkToSelf($mPath=null, $aParameters=null, $bIgnoreRequest = false) {
		$aRequestPath = Manager::getUsedPath();
		if($aParameters === null) {
			$aParameters = array();
		}
		if($mPath !== null) {
			if(!is_array($mPath)) {
				$mPath = explode("/", $mPath);
			}
			$aPath = array_merge($aRequestPath, $mPath);
		} else {
			$aPath = $aRequestPath;
		}
		if(!$bIgnoreRequest) {
			$aParameters = self::getRequestedParameters($aParameters);
		}
		return self::link($aPath, null, $aParameters, false);
	}

	public static function getRequestedParameters($aOverrideParameters = array()) {
		foreach(array_diff_assoc($_REQUEST, $_COOKIE) as $sName => $sValue) {
			if($sName === 'path') {
				continue;
			}
			if(!isset($aOverrideParameters[$sName])) {
				$aOverrideParameters[$sName] = $sValue;
			}
		}
		return $aOverrideParameters;
	}

	public static function link($mPath=false, $mManager=null, $aParameters=array(), $mLanguage=null, $bIncludeLanguage=null) {
		if($mPath === null) {
			// Respect null-links
			return null;
		}
		if(!$mPath) {
			$mPath = array();
		}
		if(!is_array($mPath)) {
			$mPath = explode("/", $mPath);
		}

		$mManager = Manager::getManagerClassNormalized($mManager);
		$sPrefix = Manager::getPrefixForManager($mManager);

		if($mLanguage === true || $mLanguage === false) {
			$bIncludeLanguage = $mLanguage;
			$mLanguage = null;
		}
		if($bIncludeLanguage === null) {
			$bIncludeLanguage = $mManager::shouldIncludeLanguageInLink();
		}
		if($bIncludeLanguage) {
			if($mLanguage === null) {
				$mLanguage = Session::language(true);
			}
			if($mLanguage instanceof Language) {
				array_unshift($mPath, $mLanguage->getPathPrefix());
			} else if(is_string($mLanguage)) {
				$mLanguage = LanguageQuery::create()->findPk($mLanguage)->getPathPrefix();
				array_unshift($mPath, $mLanguage);
			}
		}

		foreach($mPath as $iKey => $sValue) {
			if($sValue === null || $sValue === "") {
				unset($mPath[$iKey]);
			} else {
				$mPath[$iKey] = rawurlencode($sValue);
			}
		}

		if($sPrefix !== null && $sPrefix !== "") {
			$sPrefix .= "/";
		} else {
			$sPrefix = '';
		}

		return MAIN_DIR_FE_PHP.$sPrefix.implode('/', $mPath).self::prepareLinkParameters($aParameters);
	}

	/**
	* @todo: check use of http_build_query()
	*/
	public static function prepareLinkParameters($aParameters) {
		$sParameters = '';
		foreach($aParameters as $sKey => $sValue) {
			if(is_array($sValue)) {
				foreach($sValue as $sKeyKey => $sValueValue) {
					$sParameters .= "&".rawurlencode($sKey)."[".rawurlencode($sKeyKey)."]".($sValueValue ? "=".rawurlencode($sValueValue) : '');
				}
			} else {
				$sParameters .= "&".rawurlencode($sKey).($sValue ? "=".rawurlencode($sValue) : '');
			}
		}
		$sParameters = substr($sParameters, 1);
		if($sParameters !== false && $sParameters !== "") {
			$sParameters = "?".$sParameters;
		}
		return $sParameters;
	}

	public static function getHostName($sDefaultHost = null) {
		$sHost = null;
		if(isset($_SERVER['HTTP_HOST']) && !Settings::getSetting('linking', 'prefer_configured_domain', false)) {
			$sHost = $_SERVER['HTTP_HOST'];
		}
		if(!$sHost) {
			$sHost = Settings::getSetting('domain_holder', 'domain', $sDefaultHost);
		}
		return $sHost;
	}

	public static function getDomainHolderEmail($sDefaultSender = 'info') {
		return Settings::getSetting('domain_holder', 'email', $sDefaultSender.'@'.self::getHostName());
	}

	public static function getUrlWithProtocolIfNotSet($sUrl) {
		if($sUrl != '') {
			return self::getPrefixIfNotSet($sUrl);
		}
		return '';
	}

	/**
	* @todo find a better more appropriate solution
	*/
	public static function getPrefixIfNotSet($sString, $sDefaultPrefix = 'http://') {
		$sPattern = '/^\w+:/';
		if(preg_match($sPattern, $sString) === 1) {
			return $sString;
		}
		return $sDefaultPrefix.$sString;
	}

}
