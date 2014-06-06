<?php
class ErrorHandler {
	private static $ENVIRONMENT = null;
	
	public static function handleError($iErrorNumber, $sErrorString, $sErrorFile, $iErrorLine, $aContext = null, $aTrace = null, $bNeverPrint = false, $bIsUserError = false) {
		if(error_reporting() === 0 || $iErrorNumber === E_STRICT) {
			return false;
		}
		if($aTrace === null) {
			$aTrace = debug_backtrace();
			array_shift($aTrace); //Remove ErrorHandler::handleError call;
		}
		self::cleanTrace($aTrace);
		$aError = array("code" => $iErrorNumber,
										"message" => $sErrorString,
										"filename" => $sErrorFile,
										"line" => $iErrorLine,
										"trace" => $aTrace);
		self::handle($aError, $bNeverPrint, $bIsUserError);
		if($bNeverPrint || self::shouldContinue($iErrorNumber)) {
			return true;
		}
		self::displayErrorMessage($aError, $bIsUserError);
	}
	
	public static function handleException($oException, $bNeverPrint = false) {
		self::handleError($oException->getCode(), $oException->getMessage(), $oException->getFile(), $oException->getLine(), null, $oException->getTrace(), $bNeverPrint, $oException instanceof UserError);
	}
	
	/**
	* if possible, reads the file php_error.php in the site/lib directory and outputs it as an error message.
	* This is called from the handleError and handleException methods if the error was not output directly to screen (like in the test environment) and could not be recovered from. If the file does not exist, it will output the text "An Error occured, exiting"
	*/
	private static function displayErrorMessage($aError, $bMayPrintDetailedMessage = false) {
		while(ob_get_level() > 0) {
			ob_end_clean();
		}
		$sErrorFileName = SITE_DIR.'/'.DIRNAME_LIB.'/php_error.php';
		header('HTTP/1.0 500 Internal Server Error');
		if(!file_exists($sErrorFileName)) {
			header('Content-Type: text/plain;charset=utf-8');
			$sMessage = $aError['message'];
			if(!$bMayPrintDetailedMessage) {
				$sMessage = "An Error occured, exiting";
			}
			die($sMessage);
		}
		header('Content-Type: text/html;charset=utf-8');
		include($sErrorFileName);
		exit;
	}
	
	public static function getEnvironment() {
		if(self::$ENVIRONMENT === null) {
			self::$ENVIRONMENT = isset($_SERVER['RAPILA_ENVIRONMENT']) ? $_SERVER['RAPILA_ENVIRONMENT'] : (isset($_ENV['RAPILA_ENVIRONMENT']) ? $_ENV['RAPILA_ENVIRONMENT'] : 'auto');
			if(self::$ENVIRONMENT === 'developer') {
				self::$ENVIRONMENT = 'development';
			}
			if(self::$ENVIRONMENT === 'auto' || !self::$ENVIRONMENT) {
				if(php_sapi_name() === 'cli') {
					self::$ENVIRONMENT = 'development';
				} else if(strpos(@$_SERVER['HTTP_HOST'], '.') === false || StringUtil::endsWith(@$_SERVER['HTTP_HOST'], '.local') || StringUtil::endsWith(@$_SERVER['HTTP_HOST'], '.home') || StringUtil::endsWith(@$_SERVER['HTTP_HOST'], '.xip.io') || @$_SERVER['HTTP_HOST'] === $_SERVER['SERVER_ADDR']) {
					self::$ENVIRONMENT = ($_SERVER['SERVER_ADDR'] === '127.0.0.1' || $_SERVER['SERVER_ADDR'] === '::1' || $_SERVER['SERVER_ADDR'] === $_SERVER['REMOTE_ADDR']) ? 'development' : 'production';
				} else if(strpos(@$_SERVER['HTTP_HOST'], 'test.') === 0 || strpos(@$_SERVER['HTTP_HOST'], 'stage.') === 0) {
					self::$ENVIRONMENT = 'staging';
				} else {
					self::$ENVIRONMENT = 'production';
				}
			}
			define('RAPILA_ENVIRONMENT', self::$ENVIRONMENT);
		}
		return self::$ENVIRONMENT;
	}
	
	public static function shouldPrintErrors() {
		return Settings::getSetting('error_handling', 'print_errors', false);
	}
	
	public static function shouldLogErrors() {
		return Settings::getSetting('error_handling', 'log_errors', false);
	}
	
	public static function shouldMailErrors() {
		return Settings::getSetting('error_handling', 'mail_errors', false);
	}
	
	private static function shouldContinue($iErrorNumber) {
		if(Settings::getSetting('error_handling', 'should_stop_on_recoverable_errors', false)) {
			return false;
		}
		return $iErrorNumber == E_NOTICE || $iErrorNumber == E_USER_NOTICE || $iErrorNumber == E_STRICT || $iErrorNumber == E_DEPRECATED || $iErrorNumber == E_USER_DEPRECATED;
	}

	public static function log($mMessage) {
		if(func_num_args() > 1) {
			$mMessage = func_get_args();
		}
		error_log(self::readableDump($mMessage));
	}
	
	private static function readableDump($mToDump, $iMaxLevel = 5, $sVariableSeparationString = ', ', $iCurrentLevel = 1, &$aReferenceChain = array()) {
		if ($iCurrentLevel > $iMaxLevel) { 
			return "[...]";
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
		} else if($mToDump === null) {
			$sResult .= " NULL ";
		} else if(is_resource($mToDump)) {
			$sResult .= "resource of type (".get_resource_type($mToDump).")";
		} else {
			$sResult .= var_export($mToDump, true);
		}
		return $sResult;
	}
	
	private static function cleanTrace(&$aTrace) {
		foreach($aTrace as &$aTraceInfo) {
			$sFile = '';
			if(isset($aTraceInfo['file'])) {
				$sFile = ' in '.$aTraceInfo['file'].' ('.$aTraceInfo['line'].')';
			}
			$sFunction = $aTraceInfo['function'].'()'.$sFile;
			if(isset($aTraceInfo['class'])) {
				$sFunction = $aTraceInfo['class'].$aTraceInfo['type'].$sFunction;
			}
			$aTraceInfo = $sFunction;
		}
	}
	
	public static function trace($bClean = true, $aTrace = null) {
		if($aTrace === null) {
			$aTrace = debug_backtrace();
			array_shift($aTrace); //Remove ErrorHandler::trace call;
		}
		if($bClean) {
			self::cleanTrace($aTrace);
		}
		self::log($aTrace);
	}
	
	public static function setEnvironment($sEnvironment) {
		self::$ENVIRONMENT = $sEnvironment;
	}

	private static function handle($aError, $bNeverPrint = false, $bNeverNotifyDeveloper = false) {
		//Add additional information for logging/sending
		$aError['referrer'] = @$_SERVER['HTTP_REFERER'];
		$aError['host'] = @$_SERVER['HTTP_HOST'];
		$aError['path'] = @$_SERVER['REQUEST_URI'];
		$aError['request'] = @$_REQUEST;
		$aError['cookies'] = @$_COOKIE;
		
		FilterModule::getFilters()->handleAnyError(array(&$aError), $bNeverPrint, $bNeverNotifyDeveloper);
		if(!$bNeverNotifyDeveloper && self::shouldMailErrors()) {
			$sAddress = Settings::getSetting('developer', 'email', false);
			if(!$sAddress) {
				$sAddress = Settings::getSetting('domain_holder', 'email', false);
			}
			if($sAddress) {
				FilterModule::getFilters()->handleErrorEmailSend(array(&$sAddress, &$aError));
				mb_send_mail($sAddress, "Error in rapila on ".$aError['host'], $aError['path']."\n".print_r($aError, true));
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
		if(!$bNeverPrint && self::shouldPrintErrors() && !(isset($aError['code']) && self::shouldContinue($aError['code']))) {
			FilterModule::getFilters()->handleErrorPrint(array(&$aError));
			Util::dumpAll($aError);
		}
	}
}
