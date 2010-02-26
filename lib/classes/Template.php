<?php
define("TEMPLATE_IDENTIFIER_START_SINGLE", "{");
define("TEMPLATE_IDENTIFIER_END_SINGLE", "}");

define("TEMPLATE_IDENTIFIER_START", TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_START_SINGLE);
define("TEMPLATE_IDENTIFIER_END", TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE);

define("TEMPLATE_KEY_VALUE_SEPARATOR", "=");
define("TEMPLATE_PARAMETER_SEPARATOR", ";");

define("TEMPLATE_IDENTIFIER_MATCHER", "/".preg_quote(TEMPLATE_IDENTIFIER_START, "/")."([^".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_KEY_VALUE_SEPARATOR.TEMPLATE_PARAMETER_SEPARATOR, "/")."]+?)(".preg_quote(TEMPLATE_KEY_VALUE_SEPARATOR, "/")."(((\\\\[".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_PARAMETER_SEPARATOR, "/")."])|[^".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_PARAMETER_SEPARATOR, "/")."])+)?)?(".preg_quote(TEMPLATE_PARAMETER_SEPARATOR, "/")."(((\\\\[".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE, "/")."])|[^".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE, "/")."])*))?".preg_quote(TEMPLATE_IDENTIFIER_END, "/")."/sm");

// Util::dumpAll(TEMPLATE_IDENTIFIER_MATCHER);

/**
 * class Template
 * is used to manage building a tree with static template texts and dynamic identifiers that have the form of <code>{{identifier=value;param=value}}</code>. Those can have special meaning ({@link SpecialTemplateIdentifierActions}) and be replaced by the Template class or can be replaced by the user of the template using {@link replaceIdentifier()} or {@link replaceIdentifierMultiple()}.
 */
class Template {
	// template suffix
	public static $SUFFIX = '.tmpl';
	
	public static $ANY_VALUE = -1;
	
	private static $NEWLINE_VALUE = "\n";
	
	private static $HTML_ENTITY_FUNCTION = null;
	
	const NO_HTML_ESCAPE = 1;
	const ESCAPE = 2;
	const JAVASCRIPT_CONVERT = 4;
	/**
	 * (NO_HTML_ESCAPE|ESCAPE|JAVASCRIPT_CONVERT)
	 */
	const JAVASCRIPT_ESCAPE = 7;
	const LEAVE_IDENTIFIERS = 8;
	const FORCE_HTML_ESCAPE = 16;
	const NO_NEWLINE = 32;
	const NO_NEW_CONTEXT = 64;
	const NO_IDENTIFIER_VALUE_REPLACEMENT = 128;
	const NO_RECODE = 256;
	const STRIP_TAGS = 512;
	const CONVERT_NEWLINES_TO_BR = 1024;
	const URL_ENCODE = 2048;
	
	//Holds all of the template's contents as either strings or TemplateIdentifier objects
	private $aTemplateContents;
	
	//If set to false, identifiers will be inserted into the final output
	public $bKillIdentifiersBeforeRender = true;
	
	//If set to true, the output will be rendered on the fly
	private $bDirectOutput = false;
	
	//Contains all sent output if bDirectOutput is set to true (used for caching)
	private $sSentOutput = "";
	
	//holds the template's name. If this is a subtemplate, it will hold the root template's name
	private $sTemplateName = null;
	
	private $mPath = null;
	
	public $iDefaultFlags = 0;
	
	//The template’s internal encoding
	private $sEncoding = "utf-8";
	
	//Instance to the SpecialTemplateIdentifierActions for better resource management
	private $oSpecialTemplateIdentifierActions;
	
	/**
	 * __construct()
	 * @param string template name
	 * @param string|array template dir path
	 * @param boolean template is text only (name will be used as content, path can be used to decide origin [null=filesystem, "db"=database, "browser"=request])
	 * @param boolean template will output directly to stream? only one the main template should have set this to true
	 * @param string target encoding. usually the browser encoding. text will be converted from the source encoding (default is utf-8, at the moment only changed when using text-only templates) into the target encoding
	 * @param string root template name, used internally when including subtemplates, default=null
	 * @param int default flags, will be ORed to the flags you provide when calling {@link replaceIdentifier()} and {@link replaceIdentifierMultiple()}
	 */
	public function __construct($sTemplateName, $mPath=null, $bTemplateIsTextOnly=false, $bDirectOutput=false, $sTargetEncoding=null, $sRootTemplateName=null, $iDefaultFlags = 0) {
		if($sTargetEncoding === null) {
			$sTargetEncoding = Settings::getSetting("encoding", "browser", "utf-8");
		}
		
		if($mPath === "db") {
			$this->sEncoding = Settings::getSetting("encoding", "db", "utf-8");
		} else if($mPath === "browser") {
			$this->sEncoding = Settings::getSetting("encoding", "browser", "utf-8");
		}
		
		if($mPath === null || $mPath === "db" || $mPath === "browser") {
			$mPath = DIRNAME_TEMPLATES;
		}
		
		if($sRootTemplateName === null && !$bTemplateIsTextOnly) {
			$sRootTemplateName = $sTemplateName;
		}
		$this->sTemplateName = $sRootTemplateName;
		
		$sTemplateText = "";
		$this->aTemplateContents = array();
		
		$oCache = null;
		$bCacheIsCurrent = false;
		
		if($bTemplateIsTextOnly) {
			$sTemplateText = $sTemplateName;
		} else {
			$aPath = ResourceFinder::parsePathArguments(null, $mPath, $sTemplateName.self::$SUFFIX);
			$oPath = ResourceFinder::findResourceObject($aPath);
			if($oPath === null) {
				throw new Exception("Error in Template construct: Template file ".implode("/", $aPath+array($sTemplateName.self::$SUFFIX))." does not exist");
			}
			
			if(Settings::getSetting('general', 'template_caching', false)) {
				$oCache = new Cache($oPath->getRelativePath()."_".Session::language()."_".$sTargetEncoding."_".$this->sTemplateName, DIRNAME_TEMPLATES);
				$bCacheIsCurrent = $oCache->cacheFileExists() && !$oCache->isOutdated($oPath->getFullPath());
			}
			
			if(!$bCacheIsCurrent) {
				$sTemplateText = file_get_contents($oPath->getFullPath());
			}
			
			$mPath = $aPath;
			array_pop($mPath);
			
			if(StringUtil::startsWith($sTemplateName, 'e_mail_')) {
				$iDefaultFlags |= self::NO_HTML_ESCAPE;
			} else if(StringUtil::endsWith($sTemplateName, '.js') || StringUtil::endsWith($sTemplateName, '.css')) {
				$iDefaultFlags |= self::NO_HTML_ESCAPE&self::ESCAPE;
			}
		}
		
		$this->mPath = $mPath;
		$this->oSpecialTemplateIdentifierActions = new SpecialTemplateIdentifierActions($this);
		
		$this->iDefaultFlags = $iDefaultFlags;
		
		if($bCacheIsCurrent) {
			$this->aTemplateContents = $oCache->getContentsAsVariable();
		} else {
			if(is_array($sTemplateText)) {
				$this->aTemplateContents = $sTemplateText;
			} else {
				$sTemplateText = StringUtil::encode($sTemplateText, $this->sEncoding, $sTargetEncoding);
				$this->aTemplateContents = self::templateContentsFromText($sTemplateText, $this);
				$this->renderDirectOutput();
				$this->replaceConditionals(true);
			}
			$this->replaceSpecialIdentifiersOnStart();
			
			if($oCache !== null) {
				$oCache->setContents($this->aTemplateContents);
			}
		}
		
		$this->sEncoding = $sTargetEncoding;
		$this->bDirectOutput = $bDirectOutput;
		$this->renderDirectOutput();
		$this->replaceConditionals(true);
	}
	
	private static function templateContentsFromText($sTemplateText, $oTemplate=null) {
		$aTemplateContents = array();
		preg_match_all(TEMPLATE_IDENTIFIER_MATCHER, $sTemplateText, $aMatches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
		$iLastMatchEndPos = 0;
		foreach($aMatches as $aValue) {
			$sMatchText = $aValue[0][0];
			$iMatchPosition = $aValue[0][1];
			$iMatchLength = strlen($sMatchText);
			
			$sText = substr($sTemplateText, $iLastMatchEndPos, ($iMatchPosition-$iLastMatchEndPos));
			if(is_string($sText) && strlen($sText) > 0) {
				$aTemplateContents[] = $sText;
			}
			$iLastMatchEndPos = $iMatchPosition+$iMatchLength;
			
			$sMatchName = @$aValue[1][0];
			$sMatchValue = @$aValue[3][0];
			$sMatchParameters = @$aValue[7][0];
			$aTemplateContents[] = new TemplateIdentifier($sMatchName, $sMatchValue, $sMatchParameters, $oTemplate);
		}
		$sRestText = substr($sTemplateText, $iLastMatchEndPos, (strlen($sTemplateText)-$iLastMatchEndPos));
		if(is_string($sRestText) && strlen($sRestText) > 0) {
			$aTemplateContents[] = $sRestText;
		}
		return $aTemplateContents;
	}
	
	public function derivativeTemplate($sTemplateName, $mPath = false, $bTemplateIsTextOnly = false) {
		if($mPath === false) {
			$mPath = $this->mPath;
		}
		return new Template($sTemplateName, $mPath, $bTemplateIsTextOnly, false, $this->sEncoding, $this->getTemplateName(), $this->iDefaultFlags);
	}

	public function hasIdentifier($sName, $sValue=null) {
		return $this->identifiersMatching($sName, $sValue, null, true) !== null;
	}
	
	/**
	 * listValuesByIdentifier()
	 * @return array[string]
	 */ 
	public function listValuesByIdentifier($sType) {
		$aIdentifiers = $this->identifiersMatching($sType, self::$ANY_VALUE);
		$aResult = array();
		foreach($aIdentifiers as $oIdentifier) {
			$aResult[] = $oIdentifier->getValue();
		}
		return $aResult;		
	}
	
	private function replaceAt($iIndex, $mReplacement = null, $iLength = 1) {
		if(!is_int($iIndex)) {
			$iIndex = $this->identifierPosition($iIndex);
		}
		if(!is_int($iLength)) {
			$iLength = $this->identifierPosition($iLength) - $iIndex;
		}
		if($mReplacement === null) {
			array_splice($this->aTemplateContents, $iIndex, $iLength);
		} else {
			array_splice($this->aTemplateContents, $iIndex, $iLength, $mReplacement);
		}
	}
	
	private function allIdentifiers() {
		$aResult = array();
		foreach($this->aTemplateContents as $mContent) {
			if($mContent instanceof TemplateIdentifier) {
				$aResult[] = $mContent;
			}
		}
		return $aResult;
	}
	
	private function insertAt($iIndex, $mReplacement) {
		$this->replaceAt($iIndex, $mReplacement, 0);
	}
	
	public function identifiersMatching($sName = null, $sValue = null, $aParameters = null, $bFindFirst = false, $iStartPosition = 0) {
		$aResult = array();
		for($iKey = $iStartPosition; $iKey < count($this->aTemplateContents) ; $iKey++) {
			$mValue = $this->aTemplateContents[$iKey];
			if(!($mValue instanceof TemplateIdentifier)) {
				continue;
			}
			if($sName === null || ($mValue->getName() === $sName && ($sValue === self::$ANY_VALUE || $mValue->getValue() === $sValue))) {
				if($aParameters === null || count($aParameters) === 0) {
					if($bFindFirst) {
						return $mValue;
					} else {
						$aResult[] = $mValue;
						continue;
					}
				}
				$bMatches = true;
				foreach($aParameters as $sParameterName => $sParameterValue) {
					if(is_string($sParameterValue) && StringUtil::startsWith($sParameterValue, "!")) {
						//search for non-matching values
						$sParameterValue = substr($sParameterValue, 1);
						if($mValue->hasParameter($sParameterName) && $mValue->getParameter($sParameterName) === $sParameterValue) {
							$bMatches = false;
							break;
						}
					} else {
						if((!$mValue->hasParameter($sParameterName)) || ($sParameterValue !== self::$ANY_VALUE && $mValue->getParameter($sParameterName) !== $sParameterValue)) {
							$bMatches = false;
							break;
						}
					}
				}
				if($bMatches === true) {
					if($bFindFirst) {
						return $mValue;
					} else {
						$aResult[] = $mValue;
					}
				}
			}
		}
		if($bFindFirst) {
			return null;
		}
		return $aResult;
	}
	
	private function identifierPosition($oIdentifier, $aArray = null) {
		return array_search($oIdentifier, $this->aTemplateContents, true);
	}
	
	private function partBetween($oStartIdentifier, $oEndIdentifier) {
		$iStartIdentifierPosition = $this->identifierPosition($oStartIdentifier) + 1;
		$iEndIdentifierPosition = $this->identifierPosition($oEndIdentifier);
		$iLength = $iEndIdentifierPosition - $iStartIdentifierPosition;
		if($iLength < 1) {
			return array();
		}
		return array_slice($this->aTemplateContents, $iStartIdentifierPosition, $iLength);
	}
	
	private function findIdentifierContext($oTemplateIdentifier) {
		$aParams = array("name" => $oTemplateIdentifier->getName());
		if($oTemplateIdentifier->getValue() !== TemplateIdentifier::$PARAMETER_EMPTY_VALUE) {
			$aParams['value'] = $oTemplateIdentifier->getValue();
		}
		$aIdentifiers = $this->identifiersMatching("identifierContext", self::$ANY_VALUE, $aParams);
		if(count($aIdentifiers) === 0) {
			return null;
		}
		$iTemplateIdentifierPosition = $this->identifierPosition($oTemplateIdentifier);
		$aResult = array ("start" => null, "end" => null);
		$iLowerOffset = 0; $iUpperOffset = 0;
		foreach($aIdentifiers as $iKey => $oIdentifier) {
			$iIdentifierPosition = $this->identifierPosition($oIdentifier);
			switch ($oIdentifier->getValue())
			{
				case 'start':
					if($iIdentifierPosition > $iTemplateIdentifierPosition) {
						continue;
					}
					$iNewOffset = $iTemplateIdentifierPosition - $iIdentifierPosition;
					if($aResult["start"] === null || $iLowerOffset > $iNewOffset) {
						$iLowerOffset = $iNewOffset;
						$aResult["start"] = $oIdentifier;
					}
				break;
				case 'end':
					if($iIdentifierPosition < $iTemplateIdentifierPosition) {
						continue;
					}
					$iNewOffset = $iIdentifierPosition - $iTemplateIdentifierPosition;
					if($aResult["end"] === null || $iUpperOffset > $iNewOffset) {
						$iUpperOffset = $iNewOffset;
						$aResult["end"] = $oIdentifier;
					}
				break;
				default:
					throw new Exception("Invalid identifierContext found, value ".$oIdentifier->getValue());
				break;
			}
		}
		if($aResult["start"] === null || $aResult["end"] === null) {
			return null;
		}
		return $aResult;
	}
	
	public function findEndIfForIf($oIf) {
		$iIfCount = 0;
		$iCount = count($this->aTemplateContents);
		for($i=($this->identifierPosition($oIf)+1);$i<$iCount;$i++) {
			$mCurrent = $this->aTemplateContents[$i];
			if(!($mCurrent instanceof TemplateIdentifier)) {
				continue;
			}
			if($mCurrent->getName() === "if") {
				$iIfCount++;
				continue;
			}
			if($mCurrent->getName() === "endIf") {
				if($iIfCount === 0) {
					return $mCurrent;
				} else {
					$iIfCount--;
				}
			}
		}
		throw new Exception("Template $this->sTemplateName not well-formed: no matching close tag found for ".$oIf->__toString());
	}
	
	public function setDefaultFlags($iDefaultFlags) {
			$this->iDefaultFlags = $iDefaultFlags;
	}
	
	private function getTextForReplaceIdentifier($mText, $iFlags=0) {
		$iFlags = $iFlags | $this->iDefaultFlags;
		$aText = array();
		
		if($mText instanceof Template) {
			$mText = clone $mText;
			if(($iFlags&self::LEAVE_IDENTIFIERS) !== self::LEAVE_IDENTIFIERS) {
				$mText->bKillIdentifiersBeforeRender = true;
				$mText->prepareForRender();
			}
			$aText = $mText->aTemplateContents;
		} else if(is_string($mText)) {
			$aText[] = $mText;
		} else if (is_array($mText)) {
			$aText = $mText;
		} else if(is_float($mText)) {
			$aText[] = sprintf('%f', $mText);
		} else if(is_numeric($mText)) {
			$aText[] = sprintf('%d', $mText);
		} else if(is_object($mText)) {
			$aText[] = Util::descriptionForObject($mText);
		} else if (is_bool($mText)) {
			$aText[] = $mText ? "true" : "false";
		}
		foreach($aText as $iKey => $sText) {			
			if($aText[$iKey] instanceof TemplateIdentifier) {
				continue;
			}
			
			if(!($mText instanceof Template) && (($iFlags&self::NO_RECODE) !== self::NO_RECODE)) {
				$aText[$iKey] = StringUtil::encode($aText[$iKey], Settings::getSetting('encoding', 'db', 'utf-8'), $this->sEncoding);
			}
			
			if(($iFlags&self::ESCAPE)===self::ESCAPE) {
				$aText[$iKey] = str_replace("\n", "\\n", addslashes($aText[$iKey]));
			}
			
			if(($iFlags&self::URL_ENCODE)===self::URL_ENCODE) {
				$aText[$iKey] = urlencode($aText[$iKey]);
			}

			if(($iFlags&self::JAVASCRIPT_CONVERT)===self::JAVASCRIPT_CONVERT) {
				$aText[$iKey] = preg_replace("/\"/", "'", $aText[$iKey]);
			}
			
			if(($iFlags&self::FORCE_HTML_ESCAPE)===self::FORCE_HTML_ESCAPE || (($iFlags&self::NO_HTML_ESCAPE) !== self::NO_HTML_ESCAPE && !($mText instanceof Template))) {
				$aText[$iKey] = self::htmlEncode($aText[$iKey]);
			}

			if(($iFlags&self::CONVERT_NEWLINES_TO_BR)===self::CONVERT_NEWLINES_TO_BR) {
				$aText[$iKey] = nl2br($aText[$iKey]);
			}
			
			if(($iFlags&self::LEAVE_IDENTIFIERS)===self::LEAVE_IDENTIFIERS && !($mText instanceof Template)) {
				$aText = self::templateContentsFromText($aText[$iKey], $this);
				//only allowed once
				break;
			}
		}

		if(($iFlags&self::STRIP_TAGS)===self::STRIP_TAGS) {
			$aText = array(strip_tags(implode('', $aText)));
		}
		
		return $aText;
	}
	
	/**
	 * replaceIdentifier()
	 * @return void
	 */
	public function replaceIdentifier($sIdentifier, $mOriginalText, $sValue=null, $iFlags=0, $mFunction=null) {
		$iFlags = $iFlags | $this->iDefaultFlags;
		$aText = null;
		if($mFunction === null) {
			if($mOriginalText === null) {
				return;
			}
			$aText = $this->getTextForReplaceIdentifier($mOriginalText, $iFlags);
		}
		$aIdentifiersToBeReplaced = $this->identifiersMatching($sIdentifier, $sValue);
		foreach($aIdentifiersToBeReplaced as $oIdentifier) {
			$iIdentifierFlags = $oIdentifier->iFlags | $iFlags;
			$aOldText = null;
			if($mFunction !== null) {
				$mText = call_user_func_array($mFunction, array($oIdentifier, &$iIdentifierFlags));
				if($mText === null) {
					continue;
				}
				$aText = $this->getTextForReplaceIdentifier($mText, $iIdentifierFlags);
			} else if($iIdentifierFlags !== $iFlags) {
				$aOldText = &$aText;
				$aText = $this->getTextForReplaceIdentifier($mOriginalText, $iIdentifierFlags);
			}
			$this->replaceAt($oIdentifier, $aText);
			if($aOldText !== null) {
				$aText = &$aOldText;
			}
		}
		$bHasDoneIdentifierValueReplacement = false;
		if($mFunction === null && ($iFlags&self::NO_IDENTIFIER_VALUE_REPLACEMENT) === 0) {
			$aIdentifiers = $this->allIdentifiers();
			foreach($aIdentifiers as $oIdentifier) {
				//Identifier replacement in value
				if(strpos($oIdentifier->getValue(), TEMPLATE_IDENTIFIER_START) !== false) {
					$oValueTemplate = $this->derivativeTemplate($oIdentifier->getValue(), false, true);
					$oValueTemplate->replaceIdentifier($sIdentifier, $mOriginalText, $sValue, $iFlags, $mFunction);
					$oValueTemplate->bKillIdentifiersBeforeRender = false;
					$oIdentifier->setValue($oValueTemplate->render());
					$bHasDoneIdentifierValueReplacement = true;
				}
				//Identifier replacement in parameter values
				foreach($oIdentifier->getParameters() as $sKey => $sIdentifierValue) {
					if(strpos($sIdentifierValue, TEMPLATE_IDENTIFIER_START) !== false) {
						$oValueTemplate = $this->derivativeTemplate($sIdentifierValue, false, true);
						$oValueTemplate->replaceIdentifier($sIdentifier, $mOriginalText, $sValue, $iFlags, $mFunction);
						$oValueTemplate->bKillIdentifiersBeforeRender = false;
						$oIdentifier->setParameter($sKey, $oValueTemplate->render());
						$bHasDoneIdentifierValueReplacement = true;
					}
				}
			}
		}
		$this->renderDirectOutput();
		if($bHasDoneIdentifierValueReplacement) {
			$this->replaceConditionals(true);
		}
	}

	/**
	 * replaceIdentifierMultiple()
	 * @return void
	 */
	public function replaceIdentifierMultiple($sIdentifier, $mOriginalText=null, $sValue=null, $iFlags=0, $mFunction=null) {
		$iFlags = $iFlags | $this->iDefaultFlags;
		$aText = null;
		if($mFunction === null) {
			if($mOriginalText === null) {
				return;
			}
			$aText = $this->getTextForReplaceIdentifier($mOriginalText, $iFlags);
		}
		$aIdentifiersToBeReplaced = $this->identifiersMatching($sIdentifier, $sValue);
		foreach($aIdentifiersToBeReplaced as $oIdentifier) {
			$iIdentifierFlags = $oIdentifier->iFlags | $iFlags;
			$aOldText = null;
			if($mFunction !== null) {
				$mText = call_user_func_array($mFunction, array($oIdentifier, &$iIdentifierFlags));
				if($mText === null) {
					continue;
				}
				$aText = $this->getTextForReplaceIdentifier($mText, $iIdentifierFlags);
			} else if($iIdentifierFlags !== $iFlags) {
				$aOldText = &$aText;
				$aText = $this->getTextForReplaceIdentifier($mOriginalText, $iIdentifierFlags);
			}
			$aIdentifierContext = $this->findIdentifierContext($oIdentifier);
			$mReplaceValues = $aText;
			if($aIdentifierContext !== null) {
				if(($iIdentifierFlags&self::NO_NEW_CONTEXT)!==self::NO_NEW_CONTEXT) {
					$aContextPart = $this->partBetween($aIdentifierContext["start"], $aIdentifierContext["end"]);
					$iIdentifierPosition = array_search($oIdentifier, $aContextPart, true);
					foreach($aContextPart as $iContextPartKey => $mContextPartItem) {
						if($mContextPartItem instanceof TemplateIdentifier) {
							$aContextPart[$iContextPartKey] = clone $mContextPartItem;
						}
					}
					array_splice($aContextPart, $iIdentifierPosition, 1, $mReplaceValues);
					$oIdentifier = $aIdentifierContext["start"];
					$mReplaceValues = $aContextPart;
				} else {
					$this->replaceAt($aIdentifierContext["end"]);
					$this->replaceAt($aIdentifierContext["start"]);
				}
			}
			$this->insertAt($oIdentifier, $mReplaceValues);
			if(($iIdentifierFlags&self::NO_NEWLINE) !== self::NO_NEWLINE) {
				$this->insertAt($oIdentifier, self::$NEWLINE_VALUE);
			}
			if($aOldText !== null) {
				$aText = &$aOldText;
			}
		}
		$this->renderDirectOutput();
	}
	
	/**
	 * replaceIdentifierMultipleCallback()
	 * @return void
	 */
	public function replaceIdentifierMultipleCallback($sIdentifier, $mCallbackObject, $sCallbackMethod="getTextForReplaceIdentifier", $iFlags) {
		$mFunction = $mCallbackObject === null ? $sCallbackMethod : array($mCallbackObject, $sCallbackMethod);
		$this->replaceIdentifierMultiple($sIdentifier, null, self::$ANY_VALUE, $iFlags, $mFunction);
	}
	
	/**
	 * replaceIdentifierCallback()
	 * @return void
	 */
	public function replaceIdentifierCallback($sIdentifier, $mCallbackObject, $sCallbackMethod="getTextForReplaceIdentifier", $iFlags=0) {
		$mFunction = $mCallbackObject === null ? $sCallbackMethod : array($mCallbackObject, $sCallbackMethod);
		$this->replaceIdentifier($sIdentifier, null, self::$ANY_VALUE, $iFlags, $mFunction);
	}
	
	public function replacePstring($sPstringName, $aParameters, $sStringKey=null) {
		if($sStringKey === null) {
			$sStringKey = $sPstringName;
		}
		$sString = StringPeer::getString($sStringKey, null, null, $aParameters, true, $this->iDefaultFlags);
		$this->replaceIdentifier('writeParameterizedString', $sString, $sPstringName);
	}

	/**
	 * render()
	 * @return string
	 */		
	public function render($bIsForSubtemplate = false) {
		$this->prepareForRender($bIsForSubtemplate);
		$sResult = $this->__toString();
		if($this->bDirectOutput) {
			print $sResult;
			$this->sSentOutput .= $sResult;
		}
		return $sResult;
	}
	
	private function prepareForRender($bIsForSubtemplate = false) {
		if($this->bKillIdentifiersBeforeRender) {
			$this->killIdentifiersInIdentifiers();
		}
		if(!$bIsForSubtemplate) {
			$this->replaceSpecialIdentifiersOnEnd();
		}
		$this->replaceConditionals();
		
		if($this->bKillIdentifiersBeforeRender) {
			$this->killIdentifiers();
		}
	}
	
	private function killIdentifiers() {
		foreach($this->aTemplateContents as $iKey => $mValue) {
			if(!$mValue instanceof TemplateIdentifier || $mValue->getName() === "identifierContext") {
				continue;
			}
			$aIdentifierContext = $this->findIdentifierContext($mValue);
			if($aIdentifierContext !== null) {
				$this->replaceAt($aIdentifierContext["start"], null, $aIdentifierContext["end"]);
			}
		}
		foreach($this->aTemplateContents as $iKey => $mValue) {
			if(!$mValue instanceof TemplateIdentifier) {
				continue;
			}
			$sReplacement = null;
			if($mValue->getParameter("defaultValue") !== TemplateIdentifier::$PARAMETER_EMPTY_VALUE) {
				$sReplacement = $mValue->getParameter("defaultValue");
			}
			$this->replaceAt($mValue, $sReplacement);
		}
	}
	
	/**
	 * killIdentifiersInIdentifiers()
	 * replaces subidentifiers stored in identifiers with their default values 
	 */
	private function killIdentifiersInIdentifiers() {
		$aIdentifiers = $this->allIdentifiers();
		foreach($aIdentifiers as $oIdentifier) {
			//Identifier replacement in value
			if(strpos($oIdentifier->getValue(), TEMPLATE_IDENTIFIER_START) !== false) {
				$oValueTemplate = $this->derivativeTemplate($oIdentifier->getValue(), false, true);
				$oValueTemplate->iDefaultFlags = self::NO_HTML_ESCAPE;
				$oValueTemplate->bKillIdentifiersBeforeRender = true;
				$oIdentifier->setValue($oValueTemplate->render());
			}
			//Identifier replacement in parameter values
			foreach($oIdentifier->getParameters() as $sKey => $sIdentifierValue) {
				if(strpos($sIdentifierValue, TEMPLATE_IDENTIFIER_START) !== false) {
					$oValueTemplate = $this->derivativeTemplate($sIdentifierValue, false, true);
					$oValueTemplate->iDefaultFlags = self::NO_HTML_ESCAPE;
					$oValueTemplate->bKillIdentifiersBeforeRender = true;
					$oIdentifier->setParameter($sKey, $oValueTemplate->render());
				}
			}
		}
	}
	
	private function replaceConditionals($bFinalOnly = false) {
		$iStartPosition = 0;
		$oIf = $this->identifiersMatching("if", self::$ANY_VALUE, null, true, $iStartPosition);
		while($oIf !== null) {
			if($bFinalOnly && !$oIf->isFinal()) {
				$iStartPosition = $this->identifierPosition($oIf)+1;
				$oIf = $this->identifiersMatching("if", self::$ANY_VALUE, null, true, $iStartPosition);
				continue;
			}
			$oEndIf = $this->findEndIfForIf($oIf);
			$sComparison = $oIf->getValue() !== null ? $oIf->getValue() : "=";
			$sFirst = $oIf->getParameter('1');
			$sSecond = $oIf->hasParameter('2') && $oIf->getParameter('2') !== null ? $oIf->getParameter('2') : "";
			
			$sCompareMode = ($oIf->hasParameter('strict') && $oIf->getParameter('strict') === 'true') ? "strict" : "normal";
			
			$sComparisonString = '==';
			$mUnexpectedResult = false;
			$aFuncArgs = array($sFirst, $sSecond);
			
			switch($sComparison) {
				case 'ne':
				case 'notEqual':
				case 'not_eqal':
				case '!=':
				case '!==':
				case '<>':
					$sComparisonString = "!=";
				break;
				
				case 'gt':
				case 'greaterThan':
				case 'greater_than':
				case '>':
					$sComparisonString = ">";
					$sCompareMode = "normal";
				break;
				
				case 'lt':
				case 'lessThan':
				case 'less_than':
				case '<':
					$sComparisonString = "<";
					$sCompareMode = "normal";
				break;
				
				case 'gte':
				case 'greaterThanEqual':
				case 'greater_than_equal':
				case '>=':
					$sComparisonString = ">=";
					$sCompareMode = "normal";
				break;
				
				case 'lte':
				case 'lessThanEqual':
				case 'less_than_equal':
				case '<=':
					$sComparisonString = "<=";
					$sCompareMode = "normal";
				break;
				
				case '~':
					$sComparisonString = "preg_match";
					$sCompareMode = "function";
					$mUnexpectedResult = 0;
				break;
				
				case 'contains':
					$sComparisonString = "stripos";
					if($sCompareMode === "strict") {
						$sComparisonString = "strpos";
					}
					$sCompareMode = "function";
				break;
				
				case 'file_exists':
					$sComparisonString = "file_exists";
					$sFirst = MAIN_DIR.$sFirst;
					$mUnexpectedResult = !BooleanParser::booleanForString($sSecond);
					$aFuncArgs = array($sFirst);
					$sCompareMode = "function";
				break;
			}
			
			if($sCompareMode === "function") {
				$bResult = (call_user_func_array($sComparisonString, $aFuncArgs) !== $mUnexpectedResult);
			} else {
				if($sCompareMode === "strict") {
					$sComparisonString .= "=";
				}
				$bResult = (eval('return $sFirst '.$sComparisonString.' $sSecond;') !== $mUnexpectedResult);
			}
			
			if(!$bResult) {
				$this->replaceAt($oIf, null, ($this->identifierPosition($oEndIf) - $this->identifierPosition($oIf)));
			} else {
				$this->replaceAt($oIf);
				$this->replaceAt($oEndIf);
			}
			
			$oIf = $this->identifiersMatching("if", self::$ANY_VALUE, null, true, $iStartPosition);
		}
	}
	
	/**
	 * Calls $this->replaceSpecialIdentifiers(false);
	 * @return void
	 */	 
	private function replaceSpecialIdentifiersOnStart() {
		$this->replaceSpecialIdentifiers(false);
	}
	
	/**
	 * Calls $this->replaceSpecialIdentifiers(true);
	 * @return void
	 */	 
	private function replaceSpecialIdentifiersOnEnd() {
		$this->replaceSpecialIdentifiers(true);
	}
	
	/**
	* Replaces all special identifiers that are supposed to be replaced on either start or end of a page's lifecycle depending on the value of the parameter bIsLast.
	* Special identifiers that are replaced on start usually have their values cached with the template caching mechanisms where as the other template identifiers are left alone. The default is for special template identifiers to be rendered on start. Exceptions are writeParameterizedString and writeFlashValue and are stored in the array returned by {@link SpecialTemplateIdentifierActions::getAlwaysLastNames()}. You can force an identifier to be rendered on end by appending the parameter <code>;position=last</code>. Note, however, that you cannot use <code>;position=first</code> to override the behaviour of the special template identifiers that are always rendered on end.
	*/
	private function replaceSpecialIdentifiers($bIsLast) {
		$sPosition = $bIsLast ? "!first" : "!last";
		$aIdentifierNames = SpecialTemplateIdentifierActions::getSpecialIdentifierNames();
		foreach($aIdentifierNames as $sIdentifierName) {
			if(!$bIsLast && in_array($sIdentifierName, SpecialTemplateIdentifierActions::getAlwaysLastNames())) {
				continue;
			}
			$aIdentifiers = $this->identifiersMatching($sIdentifierName, self::$ANY_VALUE, array('position' => $sPosition));
			foreach($aIdentifiers as $oIdentifier) {
				if($oIdentifier->hasParameter('position')) {
					$oIdentifier->unsetParameter('position');
				}
				$iFlags = $oIdentifier->iFlags;
				$mReplacement = $this->oSpecialTemplateIdentifierActions->$sIdentifierName($oIdentifier, $iFlags);
				if($mReplacement !== null) {
					$this->replaceAt($oIdentifier, $this->getTextForReplaceIdentifier($mReplacement, $iFlags));
				}
			}
		}
	}
	
	/**
	* Searches for all not-yet replaced includeTemplate special identifiers (usually only the ones that have position=last on them since all the other ones are already included on template render). This is useful when using a template identifier in the include name.
	*/
	public function doIncludes() {
		$aIdentifiers = $this->identifiersMatching('includeTemplate', self::$ANY_VALUE);
		foreach($aIdentifiers as $oIdentifier) {
			if($oIdentifier->hasParameter('position')) {
				$oIdentifier->unsetParameter('position');
			}
			$iFlags = 0;
			$mReplacement = $this->oSpecialTemplateIdentifierActions->includeTemplate($oIdentifier, $iFlags);
			if($mReplacement !== null) {
				$this->replaceAt($oIdentifier, $this->getTextForReplaceIdentifier($mReplacement, $iFlags));
			}
		}
	}
	
	private function renderDirectOutput() {
		if(!$this->bDirectOutput) {
			return;
		}
		while(isset($this->aTemplateContents[0]) && !$this->aTemplateContents[0] instanceof TemplateIdentifier) {
			print $this->aTemplateContents[0];
			$this->sSentOutput .= $this->aTemplateContents[0];
			$this->replaceAt(0);
		}
	}

	public function getSentOutput()
	{
			return $this->sSentOutput;
	}
	
	public function __toString() {
		$sResult = "";
		foreach($this->aTemplateContents as $mTemplateContent) {
			if($mTemplateContent instanceof TemplateIdentifier) {
				$sResult .= $mTemplateContent->__toString();
			} else {
				$sResult .= $mTemplateContent;
			}
		}
		return $sResult;
	}
	
	public function __clone() {
		foreach($this->aTemplateContents as $iKey => $mTemplateContent) {
			if($mTemplateContent instanceof TemplateIdentifier) {
				$this->aTemplateContents[$iKey] = clone $mTemplateContent;
			}
		}
	}
	
	public function closeIdentifier($sName, $sValue = null) {
		$this->replaceIdentifier($sName, "", $sValue);
	}
	
	//Attribute accessor methods
	public function getTemplateName() {
		return $this->sTemplateName;
	}
	
	public function getTemplatePath() {
		return $this->mPath;
	}
	
	public function getCharset() {
		return $this->sEncoding;
	}
	
	public static function htmlEncode($sString) {
		if(self::$HTML_ENTITY_FUNCTION === null) {
			self::$HTML_ENTITY_FUNCTION = Settings::getSetting('encoding', 'entities', 'full') === 'xml_only' ? "htmlspecialchars" : "htmlentities";
		}
		return call_user_func(self::$HTML_ENTITY_FUNCTION, $sString, ENT_QUOTES, Settings::getSetting("encoding", "browser", "utf-8"));
	}
	
	public static function listTemplates($mDirName = DIRNAME_TEMPLATES, $bListSubdirs = false) {
		$aResult = array();
		if(!is_array($mDirName)) {
			$mDirName = explode("/", $mDirName);
		}
		$aDirectories = ResourceFinder::findResource($mDirName, null, false, true);
		foreach($aDirectories as $sDirectory) {
			if($iTemplatesDir = opendir($sDirectory)) {
				while (false !== ($sFileName = readdir($iTemplatesDir))) {
					if(strpos($sFileName, ".tmpl") === (strlen($sFileName)-strlen(".tmpl")) && is_file("$sDirectory/$sFileName"))
					{
						$aResult[]=substr($sFileName, 0, (strlen($sFileName)-strlen(".tmpl")));
					} else if(is_dir($sDirectory."/".$sFileName) && strpos($sFileName, ".") !== 0 && $bListSubdirs) {
							$aDirName = $mDirName;
							$aDirName[] = $sFileName;
							$aSubItems = self::listTemplates($aDirName, true);
							foreach($aSubItems as $sSubItem) {
								$aResult[] = "$sFileName/$sSubItem";
							}
					}
				}
				closedir($iTemplatesDir);
			}
		}
		return array_unique($aResult);
	}
}