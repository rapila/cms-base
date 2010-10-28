<?php
class Flash {
	const FLASH_KEY = "flash_session_key";
	
	private static $INSTANCE = null;
	
	private $aMessages;
	private $bErrorReportingFinished = false;
	
	private $aArrayToCheck;
	private $bArrayIsManual = false;
	
	public function __construct($aArrayToCheck = null) {
		$this->aMessages = array();
		$this->setArrayToCheck($aArrayToCheck);
	}
	
	public function setArrayToCheck($aArrayToCheck = null) {
		if(is_array($aArrayToCheck)) {
			$this->aArrayToCheck = $aArrayToCheck;
			$this->bArrayIsManual = true;
		} else {
			$this->aArrayToCheck = $_POST;
		}
	}
	
	public function addMessage($sName, $mParameters = true) {
		if($this->bErrorReportingFinished) {
			throw new Exception("Error in Flash->addMessage(), tried to add message after cleanup, probably due to wrong usage of Flash");
		}
		$this->aMessages[$sName] = $mParameters;
	}
	
	public function removeMessage($sName) {
		unset($this->aMessages[$sName]);
	}
		
	public function hasMessages() {
		return !empty($this->aMessages);
	}
		
	public function hasMessage($sMessageName) {
		$aMessages = $this->getMessages();
		return in_array($sMessageName, $aMessages);
	}
		
	public function hasMessagesLeft() {
		foreach($this->aMessages as $bMessageStatus) {
			if($bMessageStatus !== false) {
				return true;
			}
		}
		return false;
	}
	
	public function getMessages() {
		return array_keys($this->aMessages);
	}
	
	public function checkForNumber($sName, $sFlashName = null) {
		return $this->checkForPattern($sName, "/^(\d+(\.\d*)?)|(\.\d+)$/", $sFlashName);
	}

	public function checkForInteger($sName, $sFlashName = null) {
		return $this->checkForPattern($sName, "/^(\d+)$/", $sFlashName);
	}
	
	public function checkForLength($sName, $iMin, $iMax=null, $sFlashName = null) {
		$sMax = $iMax === null ? "" : "$iMax";
		return $this->checkForPattern($sName, "/^.{{$iMin},{$sMax}}$/", $sFlashName);
	}
	
	/**
	* @todo: IDN-Support
	*/
	public function checkForEmail($sName, $sFlashName = null) {
		return $this->checkForPattern($sName, "/^[\w._\-%]+@[\w-]+(\.[\w-]+)*(\.\w+)$/", $sFlashName);
	}
	
	public function checkForValue($sName, $sFlashName = null) {
		return $this->checkForExactNotMatch($sName, "", $sFlashName);
	}
	
	public function checkForPattern($sName, $sPattern, $sFlashName = null) {
		if($sFlashName === null) {
			$sFlashName = $sName;
		}
		$sValue = isset($this->aArrayToCheck[$sName]) ? $this->aArrayToCheck[$sName] : "";
		if(preg_match($sPattern, $sValue) === 0) {
			$this->addMessage($sFlashName);
			return false;
		}
		return true;
	}
	
	public function checkForExactNotMatch($sName, $sString, $sFlashName = null) {
		if($sFlashName === null) {
			$sFlashName = $sName;
		}
		$sValue = isset($this->aArrayToCheck[$sName]) ? $this->aArrayToCheck[$sName] : "";
		if($sValue === $sString) {
			$this->addMessage($sFlashName);
			return false;
		}
		return true;
	}
	
	public function checkForExactMatch($sName, $sString, $sFlashName = null) {
		if($sFlashName === null) {
			$sFlashName = $sName;
		}
		$sValue = isset($this->aArrayToCheck[$sName]) ? $this->aArrayToCheck[$sName] : "";
		if($sValue !== $sString) {
			$this->addMessage($sFlashName);
			return false;
		}
		return true;
	}
	
	/**
	* adds the following flash messages if 
	*/
	public function checkForFileUpload($sName, $aAllowedMimeTypes = null, $bAllowEmpty = false) {
		if(!isset($_FILES[$sName])) {
			if(!$bAllowEmpty) {
				$this->addMessage('no_upload');
			}
			return false;
		}
		if($_FILES[$sName]["error"] !== UPLOAD_ERR_OK) {
			switch($_FILES[$sName]["error"]) {
				case UPLOAD_ERR_INI_SIZE:
					$this->addMessage('upload_error_php_max_size', array('max_size' => ini_get('upload_max_filesize')));
					return false;
				case UPLOAD_ERR_NO_FILE:
					if(!$bAllowEmpty) {
						$this->addMessage('no_upload');
					}
					return false;
				default:
					$this->addMessage('upload_error');
					return false;
			}
		}
		if($aAllowedMimeTypes === 'DocumentType') {
			if(DocumentTypePeer::getDocumentTypeForUpload($sName) === null) {
				$this->addMessage('document_type');
				return false;
			}
		} else if(is_array($aAllowedMimeTypes) && !in_array($_FILES[$sName]['type'], $aAllowedMimeTypes)) {
				$this->addMessage('upload_type');
				return false;
		}
		
		return true;
	}
	
	public function getMessage($sName) {
		if(!isset($this->aMessages[$sName])) {
			return null;
		}
		$aParameters = array();
		if(is_array($this->aMessages[$sName])) {
			$aParameters = $this->aMessages[$sName];
		}
		$this->aMessages[$sName] = false;
		$oTag = new TagWriter('span', array('class' => 'error_display'), StringPeer::getString("flash.$sName", null, null, $aParameters));
		return $oTag->parse();
	}
	
	public function finishReporting() {
		$this->bErrorReportingFinished = true;
	}
	
	public function unfinishReporting() {
		$this->bErrorReportingFinished = false;
		$this->aMessages = array();
	}
	
	public static function noErrors() {
		$oFlash = self::getFlash();
		if(!$oFlash->bErrorReportingFinished) {
			throw new Exception("Error in Flash::noErrors(), tried to look for Errors before Error reporting finished, probably due to wrong usage of Flash");
		}
		return !$oFlash->hasMessages();
	}
	
	public function stick() {
		Session::getSession()->setAttribute(self::FLASH_KEY, $this);
	}
	
	public function __sleep() {
		$this->finishReporting();
		return array_keys(get_object_vars($this));
	}
	
	public function __wakeup() {
		if(!$this->bArrayIsManual) {
			$this->aArrayToCheck = $_POST;
		}
	}
	
	public static function getFlash() {
		$oSession = Session::getSession();
		if(self::$INSTANCE === null) {
			if($oSession->hasAttribute(self::FLASH_KEY)) {
				self::$INSTANCE = $oSession->getAttribute(self::FLASH_KEY);
				$oSession->resetAttribute(self::FLASH_KEY);
			} else {
				self::$INSTANCE = new Flash();
			}
		}
		return self::$INSTANCE;
	}
}