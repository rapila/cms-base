<?php
class ErrorHandler {
	private static $ENVIRONMENT = null;
	
	public static function handleError($iErrorNumber, $sErrorString, $sErrorFile, $iErrorLine, $aErrorContext) {
		if(error_reporting() === 0 || $iErrorNumber === E_STRICT) {
			return false;
		}
		self::handle(array("number" => $iErrorNumber,
											 "message" => $sErrorString,
											 "filename" => $sErrorFile,
											 "line" => $iErrorLine,
											 "context" => $aErrorContext));
		if(self::shouldContinue($iErrorNumber)) {
			return true;
		}
		self::displayErrorMessage($iErrorNumber);
	}
	
	public static function handleException($oException) {
		self::handle(array('exception' => $oException, 'message' => $oException->getMessage()));
		self::displayErrorMessage(E_NOTICE);
	}
	
	/**
	* if possible, reads the file php_error.php in the site/lib directory and outputs it as an error message.
	* This is called from the handleError and handleException methods if the error was not output directly to screen (like in the test environment) and could not be recovered from. If the file does not exist, it will output the text "An Error occured, exiting"
	*/
	private static function displayErrorMessage($iErrorNumber) {
		ob_clean();
		$sErrorFileName = SITE_DIR.'/'.DIRNAME_LIB.'/php_error.php';
		if($iErrorNumber == E_ERROR || !file_exists($sErrorFileName)) {
			die("An Error occured, exiting");
		}
		header('Content-Type: text/html;charset=utf-8');
		header('HTTP/1.0 500 Internal Server Error');
		include($sErrorFileName);
		exit;
	}
	
	public static function getEnvironment() {
		if(self::$ENVIRONMENT === null) {
			self::$ENVIRONMENT = Settings::getSetting('general', 'environment', null);
			if(self::$ENVIRONMENT === 'developer') {
				self::$ENVIRONMENT = 'development';
			}
			if(self::$ENVIRONMENT === 'auto' || self::$ENVIRONMENT === null) {
				if(strpos($_SERVER['HTTP_HOST'], '.') === false || StringUtil::endsWith($_SERVER['HTTP_HOST'], '.local')) {
					self::$ENVIRONMENT = ($_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '::1' || $_SERVER['SERVER_ADDR'] === $_SERVER['REMOTE_ADDR']) ? 'development' : 'production';
				} else {
					self::$ENVIRONMENT = 'production';
				}
			}
		}
		return self::$ENVIRONMENT;
	}
	
	public static function shouldPrintErrors() {
		return self::getEnvironment() === "development" || self::getEnvironment() === "test";
	}
	
	public static function shouldLogErrors() {
		return self::getEnvironment() === "test" || self::getEnvironment() === "development" || self::getEnvironment() === "production";
	}
	
	public static function shouldMailErrors() {
		return self::getEnvironment() === "production";
	}
	
	private static function shouldContinue($iErrorNumber) {
		return $iErrorNumber == E_NOTICE || $iErrorNumber == E_USER_NOTICE || $iErrorNumber == E_STRICT/* || $iErrorNumber == E_DEPRECATED || $iErrorNumber == E_USER_DEPRECATED*/;
	}

	public static function log($mMessage) {
		error_log(self::readableDump($mMessage));
	}
	
	private static function readableDump($mToDump, $iMaxLevel = 5, $sVariableSeparationString = ', ', $iCurrentLevel = 1, &$aReferenceChain = array()) {
		if ($iCurrentLevel > $iMaxLevel) { 
			return "[…]";
		}
		$sResult = '';
		if (is_object($mToDump)) {
			foreach ($aReferenceChain as $refVal) {
				if ($aReferenceChain === $mToDump) {
					return "[#]";
				}
			}
			array_push($aReferenceChain, $mToDump);
			$sResult .= get_class($mToDump) . " Object: (";
			$mToDump = (array) $mToDump;
			$bHasLooped = false;
			foreach ($mToDump as $key => $val) {
				$bHasLooped = true;
				$sResult .= '[';
				if ($key{0} == "\0") {
					$keyParts = explode("\0", $key);
					$sResult .= $keyParts[2];
				} else {
					$sResult .= $key;
				}
				$sResult .= '] => ';
				$sResult .= self::readableDump($val, $iMaxLevel, $sVariableSeparationString, $iCurrentLevel + 1, $aReferenceChain).$sVariableSeparationString;
			}
			if($bHasLooped)
				$sResult = substr($sResult, 0, -strlen($sVariableSeparationString)).")";
			array_pop($aReferenceChain);
		} elseif (is_array($mToDump)) {
			$sResult .= '(';
			$bHasLooped = false;
			foreach ($mToDump as $key => $val) {
				$bHasLooped = true;
				$sResult .= '[' . $key . '] => ';
				$sResult .= self::readableDump($val, $iMaxLevel, $sVariableSeparationString, $iCurrentLevel + 1, $aReferenceChain);
				$sResult .= $sVariableSeparationString;
			}
			if($bHasLooped)
				$sResult = substr($sResult, 0, -strlen($sVariableSeparationString));
			$sResult .= ")";
		} else {
			$sResult .= var_export($mToDump, true);
		}
		return $sResult;
	}

	private static function handle($aError) {
		//Add additional information for logging/sending
		$aError['referrer'] = @$_SERVER['HTTP_REFERER'];
		$aError['host'] = @$_SERVER['HTTP_HOST'];
		$aError['path'] = @$_REQUEST['path'];
		
		FilterModule::getFilters()->handleAnyError(array(&$aError));
		if(self::shouldMailErrors()) {
			$sAddress = Settings::getSetting('developer', 'email', false);
			if(!$sAddress) {
				$sAddress = Settings::getSetting('domain_holder', 'email', false);
			}
			if($sAddress) {
				FilterModule::getFilters()->handleErrorEmailSend(array(&$sAddress, &$aError));
				mb_send_mail($sAddress, "Error in Mini-CMS on ".$aError['host'], MAIN_DIR_FE.$aError['path'].print_r($aError, true));
			}
		}
		if(self::shouldLogErrors()) {
			$sLogFilePath = MAIN_DIR.'/'.DIRNAME_GENERATED.'/error.log';
			$sErrorMessage = self::readableDump($aError);
			$iMode = 0;
			$sDestination = null;
			FilterModule::getFilters()->handleErrorLog(array(&$sLogFilePath, &$aError, &$sErrorMessage, &$iMode, &$sDestination));
			error_log($sErrorMessage, $iMode, $sDestination);
		}
		if(self::shouldPrintErrors()) {
			FilterModule::getFilters()->handleErrorPrint(array(&$aError));
			Util::dumpAll($aError);
		}
	}
}