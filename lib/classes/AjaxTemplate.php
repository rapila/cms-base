<?php
///Helper class for Ajax-Requests to FrontendManager

/**
* AjaxTemplate is used by FrontendManager to simulate a real template when, in fact, only a few template identifiers need to be filled and they need to be returned in a nice JSON object.
*/

class AjaxTemplate extends Template {
	private $aResult;
	private $aRequested;

	///If set to true, the output will be rendered on the fly
	private $bDirectOutput = false;

	///Contains all sent output if bDirectOutput is set to true (used for caching)
	private $sSentOutput = "";

	public function __construct($aRequested, $bDirectOutput = false) {
		$this->aRequested = $aRequested;
		$this->aResult = array();
		$this->bDirectOutput = $bDirectOutput;
	}

	public function render($bIsForSubtemplate = false) {
		$sResult = json_encode($this->aResult, JSON_FORCE_OBJECT);
		if($this->bDirectOutput) {
			print($sResult);
			$this->sSentOutput = $sResult;
		} else {
			return $sResult;
		}
	}

	public function getSentOutput() {
		return $this->sSentOutput;
	}

	/**
	* Adapted version of Template’s identifiersMatching.
	* @param string $sName The virtual identifier’s name to look up
	* @param string|null|self::$ANY_VALUE $sValue The virtual identifier’s value to look up
	* @param $aParameters [ignored]
	* @param $bFindFirst whether to return just the item [true] or a (one-item) array [false]
	* @param $iStartPosition [ignored]
	*/
	public function identifiersMatching($sName = null, $sValue = null, $aParameters = null, $bFindFirst = false, $iStartPosition = 0) {
		$aIdentifiers = array();
		if(isset($this->aRequested[$sName])) {
			if(!is_array($this->aRequested[$sName])) {
				if($sValue === null || $sValue === self::$ANY_VALUE) {
					$aIdentifiers[] = new TemplateIdentifier($sName, null);
				}
			} else {
				if($sValue === self::$ANY_VALUE) {
					foreach($this->aRequested[$sName] as $sRequestedValue) {
						$aIdentifiers[] = new TemplateIdentifier($sName, $sRequestedValue);
					}
				} else if(in_array($sValue, $this->aRequested[$sName])) {
					$aIdentifiers[] = new TemplateIdentifier($sName, $sValue);
				}
			}
		}
		if($bFindFirst) {
			return count($aIdentifiers) > 0 ? $aIdentifiers[0] : null;
		}
		return $aIdentifiers;
	}

	public function replaceIdentifier($mIdentifier, $mOriginalText, $sValue=null, $iFlags=0, $mFunction=null) {
		$this->internalReplaceIdentifier($mIdentifier, $mOriginalText, $sValue, $iFlags, $mFunction);
	}

	public function replaceIdentifierMultiple($mIdentifier, $mOriginalText=null, $sValue=null, $iFlags=0, $mFunction=null) {
		$this->internalReplaceIdentifier($mIdentifier, $mOriginalText, $sValue, $iFlags, $mFunction, true);
	}

	private function internalReplaceIdentifier($mIdentifier, $mText, $sValue, $iFlags, $mFunction, $bMultiple = false) {
		if($mText === null && $mFunction === null) {
			return;
		}
		if($mIdentifier instanceof TemplateIdentifier) {
			$sValue = $mIdentifier->getValue();
			$mIdentifier = $mIdentifier->getName();
		}

		foreach($this->identifiersMatching($mIdentifier, $sValue) as $oIdentifier) {
			if($mFunction !== null) {
				$mText = call_user_func_array($mFunction, array($oIdentifier, &$iFlags));
			}

			$sText = $this->textForReplaceIdentifier($iFlags, $mText);
			if($sText === null) {
				continue;
			}
			if($oIdentifier->getValue() === null) {
				if(!$bMultiple) {
					$this->aResult[$mIdentifier] = '';
				}
				$this->aResult[$mIdentifier] .= $sText;
			} else {
				if(!isset($this->aResult[$mIdentifier])) {
					$this->aResult[$mIdentifier] = array();
				}
				if(!$bMultiple || !isset($this->aResult[$mIdentifier][$oIdentifier->getValue()])) {
					$this->aResult[$mIdentifier][$oIdentifier->getValue()]	= '';
				}
				$this->aResult[$mIdentifier][$oIdentifier->getValue()] .= $sText;
			}
		}
	}

	private function textForReplaceIdentifier(&$iFlags, $mText) {
		$sResult = null;
		if($mText instanceof Template) {
			$mText = clone $mText;
			$sResult = $mText->render();
		} else if(is_string($mText)) {
			$sResult = $mText;
		} else if (is_array($mText)) {
			$sResult = implode('', $mText);
		} else if(is_float($mText)) {
			$sResult = sprintf('%f', $mText);
		} else if(is_numeric($mText)) {
			$sResult = sprintf('%d', $mText);
		} else if(is_object($mText)) {
			$sResult = Util::descriptionForObject($mText);
		} else if (is_bool($mText)) {
			$sResult = $mText ? "true" : "false";
		}

		return $sResult;
	}
}
