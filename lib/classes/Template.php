<?php
define("TEMPLATE_IDENTIFIER_START_SINGLE", "{");
define("TEMPLATE_IDENTIFIER_END_SINGLE", "}");

define("TEMPLATE_IDENTIFIER_START", TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_START_SINGLE);
define("TEMPLATE_IDENTIFIER_END", TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE);

define("TEMPLATE_KEY_VALUE_SEPARATOR", "=");
define("TEMPLATE_PARAMETER_SEPARATOR", ";");

define("TEMPLATE_IDENTIFIER_MATCHER", "/".preg_quote(TEMPLATE_IDENTIFIER_START, "/")."([^".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_KEY_VALUE_SEPARATOR.TEMPLATE_PARAMETER_SEPARATOR, "/")."]+?)(".preg_quote(TEMPLATE_KEY_VALUE_SEPARATOR, "/")."(((\\\\[".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_PARAMETER_SEPARATOR, "/")."])|[^".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE.TEMPLATE_PARAMETER_SEPARATOR, "/")."])+)?)?(".preg_quote(TEMPLATE_PARAMETER_SEPARATOR, "/")."(((\\\\[".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE, "/")."])|[^".preg_quote(TEMPLATE_IDENTIFIER_START_SINGLE.TEMPLATE_IDENTIFIER_END_SINGLE, "/")."])*))?".preg_quote(TEMPLATE_IDENTIFIER_END, "/")."/sm");

/**
* The Template class is used to manage building a tree with static template texts and dynamic identifiers that have the form of <code>{{identifier=value;param=value}}</code>. Those can have special meaning ({@link SpecialTemplateIdentifierActions}) and be replaced by the Template class or can be replaced by the user of the template using {@link replaceIdentifier()} or {@link replaceIdentifierMultiple()}.
* All replaceIdentifier… methods take a flag parameter. The possible flags can be bitwise ORed together. The flags are described in the constants section. You can also provide a new template with some default flags. All Templates whose file name start with “e_mail_” will automatically get the NO_HTML_ESCAPE flag while those ending in .css.tmpl or .js.tmpl will automatically get NO_HTML_ESCAPE|ESCAPE.
*/

/// Manages a rapila Template (*.tmpl)
class Template {
	/// template suffix
	public static $SUFFIX = '.tmpl';

	public static $ANY_VALUE = -1;

	private static $NEWLINE_VALUE = "\n";

	private static $HTML_ENTITY_FUNCTION = null;

	/**
	 * Prevents any HTML escaping from taking place (usually any replacement values except templates are being html-escaped).
	*/
	const NO_HTML_ESCAPE = 1;

	/**
	 * Escapes (quotes) all Javascript-unsafe characters
	*/
	const ESCAPE = 2;

	/**
	 * Puts double-quotes around the string. Only used in conjunction with ESCAPE
	*/
	const JAVASCRIPT_CONVERT = 4;

	/**
	 * Is equivalent to (NO_HTML_ESCAPE|ESCAPE|JAVASCRIPT_CONVERT)
	*/
	const JAVASCRIPT_ESCAPE = 7;

	/**
	 * Re-use existing identifiers (if the replacing value is a template) or re-parse identifier-like strings (if the replacement is a string)
	*/
	const LEAVE_IDENTIFIERS = 8;

	/**
	 * Forces html-escaping of replacement values (even if the replacement is a template)
	*/
	const FORCE_HTML_ESCAPE = 16;

	/**
	 * Suppresses the printing of a newline character between multiple replacements of the same identifier
	*/
	const NO_NEWLINE = 32;

	/**
	 * Does not duplicate the context when doing multiple replacements on the same identifier. This means that the {{identifierContext}} can be used to mark an area to be deleted if no replacements occur but still keep the area only once if multiple replacements happen.
	*/
	const NO_NEW_CONTEXT = 64;

	/**
	 * A replaceIdentifier… operation with this flag set will not look inside template identifier values or parameters for inner identifiers to be replaced. Use this e.g. to to a quicker replacement when you’re sure you don’t have any relevant inner identifiers.
	*/
	const NO_IDENTIFIER_VALUE_REPLACEMENT = 128;

	/**
	 * This will not do any charset-conversions. This only affects operation where the replacement is another template.
	*/
	const NO_RECODE = 256;

	/**
	 * This will run strip_tags() on the replacement.
	*/
	const STRIP_TAGS = 512;

	/**
	 * This will run nl2br() on the replacement.
	*/
	const CONVERT_NEWLINES_TO_BR = 1024;

	/**
	 * This will run urlencode() on the replacement.
	*/
	const URL_ENCODE = 2048;

	///Holds all of the template's contents as either strings or TemplateIdentifier objects
	private $aTemplateContents;

	///If set to false, identifiers will be inserted into the final output
	public $bKillIdentifiersBeforeRender = true;

	///If set to true, the output will be rendered on the fly
	private $bDirectOutput = false;

	///Contains all sent output if bDirectOutput is set to true (used for caching)
	private $sSentOutput = "";

	///Holds the template's name. If this is a subtemplate, it will hold the root template's name
	private $sTemplateName = null;

	///Holds the path relative to the CONTEXT_DIR from which this template was created. This is used to resolve includes which may originate from the same relative path with each posible CONTEXT_DIR.
	private $mPath = null;

	///Default flags are ORed against given flags in all operations. Default flags are also inherited to included templates.
	public $iDefaultFlags = 0;

	///The template’s internal encoding
	private $sEncoding = "utf-8";

	///Instance to the SpecialTemplateIdentifierActions for better resource management
	private $oSpecialTemplateIdentifierActions;

	/**
	* @param string $sTemplateName template name
	* @param string|array $mPath template dir path
	* @param boolean $bTemplateIsTextOnly template is text only (name will be used as content, path can be used to decide origin [null=filesystem, "db"=database, "browser"=request])
	* @param boolean $bDirectOutput template will output directly to stream? only one the main template should have set this to true
	* @param string $sTargetEncoding target encoding. usually the browser encoding. text will be converted from the source encoding (default is utf-8, at the moment only changed when using text-only templates) into the target encoding
	* @param string $sRootTemplateName root template name, used internally when including subtemplates, default=null
	* @param int $iDefaultFlags default flags, will be ORed to the flags you provide when calling {@link replaceIdentifier()} and {@link replaceIdentifierMultiple()}
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

		$sTemplateText = "";
		$this->aTemplateContents = array();

		$oCache = null;
		$bCacheIsCurrent = false;

		if($bTemplateIsTextOnly) {
			$sTemplateText = $sTemplateName;
			$sTemplateName = $sRootTemplateName;
		} else {
			if($sTemplateName instanceof FileResource) {
				$oPath = $sTemplateName;
				$aPath = explode('/', $oPath->getRelativePath());
				$sTemplateName = $oPath->getFileName(self::$SUFFIX);
			} else {
				$aPath = ResourceFinder::parsePathArguments(null, $mPath, $sTemplateName.self::$SUFFIX);
				$oPath = ResourceFinder::findResourceObject($aPath);
			}
			if($oPath === null) {
				throw new Exception("Error in Template construct: Template file ".implode("/", $aPath+array($sTemplateName.self::$SUFFIX))." does not exist");
			}

			if(Settings::getSetting('general', 'template_caching', false)) {
				$oCache = new Cache($oPath->getFullPath()."_".LocaleUtil::getLocaleId()."_".$sTargetEncoding."_".$sRootTemplateName, DIRNAME_TEMPLATES);
				$bCacheIsCurrent = $oCache->entryExists() && !$oCache->isOutdated($oPath->getFullPath());
			}

			if(!$bCacheIsCurrent) {
				$sTemplateText = file_get_contents($oPath->getFullPath());
			}

			$mPath = $aPath;
			array_pop($mPath);

		}
		if($sRootTemplateName === null && !$bTemplateIsTextOnly) {
			$sRootTemplateName = $sTemplateName;
		}
		if($sRootTemplateName === null) {
			$sRootTemplateName = '';
		}
		$this->sTemplateName = $sRootTemplateName;
		if(StringUtil::startsWith($sTemplateName, 'e_mail_') || StringUtil::startsWith($sTemplateName, 'email_')) {
			$iDefaultFlags |= self::NO_HTML_ESCAPE;
		} else if(StringUtil::endsWith($sTemplateName, '.js') || StringUtil::endsWith($sTemplateName, '.css')) {
			$iDefaultFlags |= (self::NO_HTML_ESCAPE|self::ESCAPE);
		} else if(StringUtil::endsWith($this->sTemplateName, '.js') || StringUtil::endsWith($this->sTemplateName, '.css')) {
			//I’m not a js template but my parent is
			$iDefaultFlags &= ~(self::NO_HTML_ESCAPE|self::ESCAPE);
		}

		$this->mPath = $mPath;
		$this->oSpecialTemplateIdentifierActions = new SpecialTemplateIdentifierActions($this);

		$this->iDefaultFlags = $iDefaultFlags;

		if($bCacheIsCurrent) {
			$this->aTemplateContents = $oCache->getContentsAsVariable();
			foreach($this->aTemplateContents as &$mContent) {
				if($mContent instanceof TemplatePart) {
					$mContent->setTemplate($this);
				}
			}
		} else {
			if(is_array($sTemplateText)) {
				$this->aTemplateContents = $sTemplateText;
			} else {
				$sTemplateText = StringUtil::encode($sTemplateText, $this->sEncoding, $sTargetEncoding);
				$this->aTemplateContents = self::templateContentsFromText($sTemplateText, $this);
				$this->replaceConditionals(true);
				$this->renderDirectOutput();
			}
			$this->replaceSpecialIdentifiersOnStart();

			if($oCache !== null) {
				$oCache->setContents($this->aTemplateContents);
			}
		}

		$this->sEncoding = $sTargetEncoding;
		$this->bDirectOutput = $bDirectOutput;
		$this->replaceConditionals(true);
		$this->renderDirectOutput();
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

	public function hasIdentifier($sName, $sValue=TemplateIdentifier::PARAMETER_EMPTY_VALUE) {
		return $this->identifiersMatching($sName, $sValue, null, true) !== null;
	}

	/**
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

	public function replaceAt($iIndex, $mReplacement = null, $iLength = 1) {
		if(!is_int($iIndex)) {
			$iIndex = $this->identifierPosition($iIndex);
			if($iIndex === false) {
				return;
			}
		}
		if(!is_int($iLength)) {
			$iLength = $this->identifierPosition($iLength);
			if($iLength === false) {
				return;
			}
			$iLength = $iLength - $iIndex + 1;
		}
		if($mReplacement === null) {
			array_splice($this->aTemplateContents, $iIndex, $iLength);
		} else {
			array_splice($this->aTemplateContents, $iIndex, $iLength, $mReplacement);
		}
		$this->invalidateIdentifierList();
	}

	private function insertAt($iIndex, $mReplacement) {
		$this->replaceAt($iIndex, $mReplacement, 0);
	}

	private $aAllIdentifiers = null;

	private function allIdentifiers() {
		if(!$this->aAllIdentifiers) {
			$this->aAllIdentifiers = array();
			foreach($this->aTemplateContents as $iKey => $mContent) {
				if($mContent instanceof TemplateIdentifier) {
					$this->aAllIdentifiers[$iKey] = $mContent;
				}
			}
		}
		return $this->aAllIdentifiers;
	}

	private function invalidateIdentifierList() {
		$this->aAllIdentifiers = null;
	}

	public function identifiersMatching($sName = null, $sValue = null, $aParameters = null, $bFindFirst = false, $iStartPosition = 0) {
		$aResult = array();
		$aIdentifiers = $this->allIdentifiers();
		if($iStartPosition) {
			$aIdentifiers = array_slice($aIdentifiers, $iStartPosition, null, true);
		}
		foreach($aIdentifiers as $iKey => $mValue) {
			if($sName === null || ($mValue->getName() === $sName && ($sValue === self::$ANY_VALUE || $mValue->getValue() === $sValue))) {
				if($aParameters === null || count($aParameters) === 0) {
					if($bFindFirst) {
						return $mValue;
					} else {
						$aResult[$iKey] = $mValue;
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
						$aResult[$iKey] = $mValue;
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

	private function partBetween($oStartIdentifier, $oEndIdentifier, $bIncludeSurroundings=false) {
		$iStartIdentifierPosition = $this->identifierPosition($oStartIdentifier) + 1;
		$iEndIdentifierPosition = $this->identifierPosition($oEndIdentifier);
		if($bIncludeSurroundings) {
			$iStartIdentifierPosition--;
			$iEndIdentifierPosition++;
		}
		$iLength = $iEndIdentifierPosition - $iStartIdentifierPosition;
		if($iLength < 1) {
			return array();
		}
		return array_slice($this->aTemplateContents, $iStartIdentifierPosition, $iLength);
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
			foreach($aText as $mTextItem) {
				if($mTextItem instanceof TemplatePart) {
					$mTextItem->setTemplate($this);
				}
			}
		} else if(is_string($mText)) {
			$aText[] = $mText;
		} else if (is_array($mText)) {
			$aText = $mText;
		} else if(is_float($mText)) {
			$aText[] = sprintf('%f', $mText);
		} else if(is_numeric($mText)) {
			$aText[] = sprintf('%d', $mText);
		} else if (is_callable($mText)) {
			$aText = $this->getTextForReplaceIdentifier($mText(), $iFlags);
		} else if(is_object($mText)) {
			$sObjectDescription = Util::descriptionForObject($mText);
			if(!$sObjectDescription) {
				$sObjectDescription = (string)$mText;
			}
			$aText[] = $sObjectDescription;
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

			if(($iFlags&self::ESCAPE)===self::ESCAPE && (!($mText instanceof Template) || ($mText->iDefaultFlags&self::ESCAPE)!==self::ESCAPE)) {
				$aText[$iKey] = str_replace("\n", "\\n", addslashes($aText[$iKey]));
			}

			if(($iFlags&self::URL_ENCODE)===self::URL_ENCODE && (!($mText instanceof Template) || ($mText->iDefaultFlags&self::URL_ENCODE)!==self::URL_ENCODE)) {
				$aText[$iKey] = urlencode($aText[$iKey]);
			}

			if(($iFlags&self::JAVASCRIPT_CONVERT)===self::JAVASCRIPT_CONVERT && (!($mText instanceof Template) || ($mText->iDefaultFlags&self::JAVASCRIPT_CONVERT)!==self::JAVASCRIPT_CONVERT)) {
				$aText[$iKey] = '"'.$aText[$iKey].'"';
			}

			if(($iFlags&self::FORCE_HTML_ESCAPE)===self::FORCE_HTML_ESCAPE || (($iFlags&self::NO_HTML_ESCAPE) !== self::NO_HTML_ESCAPE && !($mText instanceof Template))) {
				$aText[$iKey] = self::htmlEncode($aText[$iKey]);
			}

			if(($iFlags&self::CONVERT_NEWLINES_TO_BR)===self::CONVERT_NEWLINES_TO_BR && (!($mText instanceof Template) || ($mText->iDefaultFlags&self::CONVERT_NEWLINES_TO_BR)!==self::CONVERT_NEWLINES_TO_BR)) {
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
	* Replaces one or more identifiers in the template with the specified value (or the value from the specified callback) if the name and the value of the identifier matches the arguments.
	*/
	public function replaceIdentifier($mIdentifier, $mText, $sValue=TemplateIdentifier::PARAMETER_EMPTY_VALUE, $iFlags=0, $mFunction=null) {
		if($mFunction === null && $mText === null) {
			return;
		}
		$iFlags = $iFlags | $this->iDefaultFlags;
		$aMarkers = $this->convertIdentifierAndContextToMarkers($mIdentifier, $sValue, $iFlags|self::NO_NEW_CONTEXT);

		$this->replaceIdentifierImpl($mIdentifier, $mText, $sValue, $iFlags, $mFunction);

		foreach($aMarkers as $oTemplateMarker) {
			$oTemplateMarker->destroy();
		}
		$this->renderDirectOutput();
	}

	private function replaceIdentifierImpl($mIdentifier, $mText, $sValue, $iFlags, $mFunction, $bMultiple=false) {
		$aText = null;
		if($this->replaceIdentifierRecursive($mIdentifier, $mText, $sValue, $iFlags, $mFunction)) {
			return;
		}

		$aIdentifiersToBeReplaced = null;
		if($mIdentifier instanceof TemplateIdentifier) {
			$aIdentifiersToBeReplaced = array($mIdentifier);
		} else {
			$aIdentifiersToBeReplaced = $this->identifiersMatching($mIdentifier, $sValue);
		}

		foreach($aIdentifiersToBeReplaced as $oIdentifier) {
			$this->replaceOneIdentifier($oIdentifier, $mText, $iFlags, $mFunction);
		}

		$bHasDoneIdentifierValueReplacement = $this->doIdentifierValueReplacement($mIdentifier, $sValue, $mText, $iFlags, $mFunction, $bMultiple);
		if($bHasDoneIdentifierValueReplacement) {
			$this->replaceConditionals(true);
		}
	}

	private function replaceIdentifierRecursive($sIdentifier, $oContent, $sIdentifierValue, $iFlags, $mFunction) {
		if($sIdentifier instanceof TemplateIdentifier) {
			return false;
		}
		if(is_array($oContent)) {
			if(isset($oContent[0])) {
				return false;
			}
		} else if(!($oContent instanceof stdClass)) {
			return false;
		}
		foreach($oContent as $sKey => $mValue) {
			$this->replaceIdentifier("$sIdentifier.$sKey", $mValue, $sIdentifierValue, $iFlags, $mFunction);
		}
		return true;
	}

	private function replaceOneIdentifier(TemplateIdentifier $oIdentifier, $mText, $iFlags, $mFunction) {
		$iIdentifierFlags = $oIdentifier->iFlags | $iFlags;
		$aText = array();
		if($mFunction !== null) {
			$mText = call_user_func_array($mFunction, array($oIdentifier, &$iIdentifierFlags));
			if($mText === null) {
				return;
			}
		}
		$aText = $this->getTextForReplaceIdentifier($mText, $iIdentifierFlags);
		$this->replaceAt($oIdentifier, $aText);
	}

	private function doIdentifierValueReplacement($mIdentifier, $sIdentifierValue, $mText, $iFlags, $mFunction, $bMultiple=false) {
		if(($iFlags&self::NO_IDENTIFIER_VALUE_REPLACEMENT) === self::NO_IDENTIFIER_VALUE_REPLACEMENT) {
			return false;
		}
		if($mIdentifier instanceof TemplateIdentifier) {
			return false;
		}
		$bHasDoneIdentifierValueReplacement = false;
		$aIdentifiers = $this->allIdentifiers();
		foreach($aIdentifiers as $oIdentifier) {
			if(strpos($oIdentifier->getValue(), TEMPLATE_IDENTIFIER_START) !== false) {
				//Identifier replacement in value
				$oValueTemplate = $this->derivativeTemplate($oIdentifier->getValue(), false, true);
				if($bMultiple) {
					$oValueTemplate->replaceIdentifierMultiple($mIdentifier, $mText, $sIdentifierValue, $iFlags, $mFunction);
				} else {
					$oValueTemplate->replaceIdentifier($mIdentifier, $mText, $sIdentifierValue, $iFlags, $mFunction);
				}
				$oValueTemplate->bKillIdentifiersBeforeRender = false;
				$oIdentifier->setValue($oValueTemplate->render());
				$bHasDoneIdentifierValueReplacement = true;
			}
			foreach($oIdentifier->getParameters() as $sKey => $sValue) {
				if(strpos($sValue, TEMPLATE_IDENTIFIER_START) !== false) {
					//Identifier replacement in parameter values
					$oValueTemplate = $this->derivativeTemplate($sValue, false, true);
					if($bMultiple) {
						$oValueTemplate->replaceIdentifierMultiple($mIdentifier, $mText, $sIdentifierValue, $iFlags, $mFunction);
					} else {
						$oValueTemplate->replaceIdentifier($mIdentifier, $mText, $sIdentifierValue, $iFlags, $mFunction);
					}
					$oValueTemplate->bKillIdentifiersBeforeRender = false;
					$oIdentifier->setParameter($sKey, $oValueTemplate->render());
					$bHasDoneIdentifierValueReplacement = true;
				}
			}
		}
		return $bHasDoneIdentifierValueReplacement;
	}

	/**
	* Replaces one or more identifiers in the template with the specified value (or the value from the specified callback) if the name and the value of the identifier matches the arguments.
	* In contrast to a simple replaceIdentifier call, calling this will preserve the identifiers at their locations for future replacement (after the current replacement).
	*/
	public function replaceIdentifierMultiple($mIdentifier, $mText=null, $sValue=TemplateIdentifier::PARAMETER_EMPTY_VALUE, $iFlags=0, $mFunction=null) {
		if($mFunction === null && $mText === null) {
			return;
		}
		$iFlags = $iFlags | $this->iDefaultFlags;
		$aMarkers = $this->convertIdentifierAndContextToMarkers($mIdentifier, $sValue, $iFlags);

		// Replace identifier as I usually would
		$this->replaceIdentifierImpl($mIdentifier, $mText, $sValue, $iFlags, $mFunction, true);

		foreach($aMarkers as $oTemplateMarker) {
			$oTemplateMarker->replace();
		}

		$this->renderDirectOutput();
	}

	private function convertIdentifierAndContextToMarkers($mIdentifier, $sValue=TemplateIdentifier::PARAMETER_EMPTY_VALUE, $iFlags=0) {
		$aMarkers = array();
		$bSaveContexts = ($iFlags&self::NO_NEW_CONTEXT) !== self::NO_NEW_CONTEXT;

		$sIdentifier = $mIdentifier;
		if($mIdentifier instanceof TemplateIdentifier) {
			$sIdentifier = $mIdentifier->getName();
			$sValue = $mIdentifier->getValue();
			$aIdentifiers = array();
			$aIdentifiers[$this->identifierPosition($mIdentifier)] = $mIdentifier;
		} else {
			// Plain identifer markers + Context markers
			$aIdentifiers = $this->identifiersMatching($sIdentifier, $sValue);
			ksort($aIdentifiers);
		}

		$aParams = array("name" => $sIdentifier);
		if($sValue !== TemplateIdentifier::PARAMETER_EMPTY_VALUE) {
			$aParams['value'] = $sValue;
		}
		$aIdentifiers = $aIdentifiers + $this->identifiersMatching("identifierContext", self::$ANY_VALUE, $aParams);
		ksort($aIdentifiers);

		$iIdentifierFlags = $iFlags;

		$oContextStart = null;
		foreach($aIdentifiers as $oIdentifier) {
			// Add all the flags from the current identifier to the running flags.
			// $iIdentifierFlags should pick up all flags from all identifiers belonging to this identifier and its context identifiers
			$iIdentifierFlags = $iIdentifierFlags | $oIdentifier->iFlags;
			// FIXME: Ins’t the key already the position?
			$iPosition = $this->identifierPosition($oIdentifier);
			$oMarker = null;
			if($oIdentifier->getName() === 'identifierContext') {
				if($oIdentifier->getValue() === 'start') {
					// Reset flags when a new context starts
					$iIdentifierFlags = $iFlags | $oIdentifier->iFlags;
					$bSaveContexts = ($iIdentifierFlags&self::NO_NEW_CONTEXT) !== self::NO_NEW_CONTEXT;
					$oContextStart = $oIdentifier;
				} else {
					if($bSaveContexts) {
						// Generate a marker for the whole context
						$oMarker = new TemplateMarker($this, $this->partBetween($oContextStart, $oIdentifier, true), true);
					}
					$this->replaceAt($oContextStart);
					$this->replaceAt($oIdentifier);
					$iPosition -= 2;
					$oContextStart = null;
				}
			} else {
				if(!($bSaveContexts && $oContextStart)) {
					// Generate a marker for the identifier alone
					$oMarker = new TemplateMarker($this, array($oIdentifier));
				}
				if(!$oContextStart) {
					// Reset flag because there is no context
					$iIdentifierFlags = $iFlags | $oIdentifier->iFlags;
					$bSaveContexts = ($iIdentifierFlags&self::NO_NEW_CONTEXT) !== self::NO_NEW_CONTEXT;
				}
			}
			if($oMarker) {
				if(($iIdentifierFlags&self::NO_NEWLINE) !== self::NO_NEWLINE) {
					array_unshift($oMarker->aContents, self::$NEWLINE_VALUE);
				}
				$this->insertAt($iPosition+1, array($oMarker));
				$aMarkers[] = $oMarker;
			}
		}

		return $aMarkers;
	}

	/**
	* @return void
	*/
	public function replaceIdentifierMultipleCallback($sIdentifier, $mCallbackObject, $sCallbackMethod="getTextForReplaceIdentifier", $iFlags) {
		$mFunction = $mCallbackObject === null ? $sCallbackMethod : array($mCallbackObject, $sCallbackMethod);
		$this->replaceIdentifierMultiple($sIdentifier, null, self::$ANY_VALUE, $iFlags, $mFunction);
	}

	/**
	* @return void
	*/
	public function replaceIdentifierCallback($sIdentifier, $mCallbackObject, $sCallbackMethod=null, $iFlags=0) {
		$mFunction = $sCallbackMethod === null ? $mCallbackObject : array($mCallbackObject, $sCallbackMethod);
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
		$aContexts = $this->identifiersMatching("identifierContext", self::$ANY_VALUE);
		krsort($aContexts);

		$oContextEndPosition = null;
		foreach($aContexts as $iPosition => $oIdentifier) {
			if($oIdentifier->getValue() === 'end') {
				$oContextEndPosition = $iPosition;
			} else {
				$this->replaceAt($iPosition, null, $oContextEndPosition - $iPosition + 1);
			}
		}
		$aIdentifiers = $this->allIdentifiers();
		krsort($aIdentifiers);
		foreach($aIdentifiers as $iKey => $mValue) {
			if(!$mValue instanceof TemplateIdentifier) {
				continue;
			}
			$sReplacement = null;
			if($mValue->getParameter("defaultValue") !== TemplateIdentifier::PARAMETER_EMPTY_VALUE) {
				$sReplacement = $mValue->getParameter("defaultValue");
			}
			$this->replaceAt($iKey, $sReplacement);
		}
	}

	/**
	* Replaces subidentifiers stored in identifiers with their default values
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
		$oIf = null;
		while(true) {
			$oIf = $this->identifiersMatching("if", self::$ANY_VALUE, null, true, $iStartPosition);
			if(!$oIf) {
				break;
			}
			if($bFinalOnly && !$oIf->isFinal()) {
				$iStartPosition = $this->identifierPosition($oIf)+1;
				continue;
			}
			$oEndIf = $this->findEndIfForIf($oIf);
			if(!$oEndIf) {
				$oIf->destroy();
				continue;
			}
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

				case '|=':
				$sComparisonString = "in_array";
				$aFuncArgs = array($sFirst, explode('|', $sSecond));
				$sCompareMode = "function";
				break;

				case '~=':
				$sComparisonString = "in_array";
				$aFuncArgs = array($sFirst, preg_split('/\\s+/', $sSecond, -1, PREG_SPLIT_NO_EMPTY));
				$sCompareMode = "function";
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
				$this->replaceAt($oIf, null, $oEndIf);
			} else {
				$oIf->destroy();
				$oEndIf->destroy();
			}
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
		$sNotPosition = $bIsLast ? "first" : "last";
		$aIdentifierNames = array_fill_keys(SpecialTemplateIdentifierActions::getSpecialIdentifierNames(), 1);
		$aAlwaysLastNames = array_fill_keys(SpecialTemplateIdentifierActions::getAlwaysLastNames(), 1);
		foreach($this->allIdentifiers() as $oIdentifier) {
			$sIdentifierName = $oIdentifier->getName();
			if((!$bIsLast && isset($aAlwaysLastNames[$sIdentifierName])) || $oIdentifier->getParameter('position') === $sNotPosition) {
				continue;
			}
			if(!isset($aIdentifierNames[$sIdentifierName])) {
				continue;
			}
			if($oIdentifier->hasParameter('position')) {
				$oIdentifier->unsetParameter('position');
			}
			if($aIdentifierNames[$sIdentifierName] === 1) {
				$aIdentifierNames[$sIdentifierName] = array();
			}
			$aIdentifierNames[$sIdentifierName][] = $oIdentifier;
		}
		// We need to iterate identifiers in the order they appear in $aIdentifierNames due to dependencies
		foreach($aIdentifierNames as $sIdentifierName => $aIdentifiers) {
			if(!is_array($aIdentifiers)) {
				continue;
			}
			foreach($aIdentifiers as $oIdentifier) {
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
		while(isset($this->aTemplateContents[0]) && !$this->aTemplateContents[0] instanceof TemplateIdentifier && !$this->aTemplateContents[0] instanceof TemplateMarker) {
			print $this->aTemplateContents[0];
			$this->sSentOutput .= $this->aTemplateContents[0];
			$this->replaceAt(0);
		}
	}

	public function getSentOutput() {
		return $this->sSentOutput;
	}

	public function __toString() {
		return implode("", $this->aTemplateContents);
	}

	public function __clone() {
		foreach($this->aTemplateContents as $iKey => $mTemplateContent) {
			if($mTemplateContent instanceof TemplatePart) {
				$this->aTemplateContents[$iKey] = clone $mTemplateContent;
				$this->aTemplateContents[$iKey]->setTemplate($this);
			}
		}
		$this->invalidateIdentifierList();
	}

	public function __wakeup() {
		foreach($this->aTemplateContents as $iKey => $mTemplateContent) {
			if($mTemplateContent instanceof TemplatePart) {
				$mTemplateContent->setTemplate($this);
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

	public static function listTemplates($mDirName = DIRNAME_TEMPLATES, $bListSubdirs = false, $bFlag=null) {
		$aResult = array();
		if(!is_array($mDirName)) {
			$mDirName = explode("/", $mDirName);
		}
		$aDirectories = ResourceFinder::findResource($mDirName, $bFlag, false, true);
		foreach($aDirectories as $sDirectory) {
			if($iTemplatesDir = opendir($sDirectory)) {
				while (false !== ($sFileName = readdir($iTemplatesDir))) {
					if(strpos($sFileName, ".tmpl") === (strlen($sFileName)-strlen(".tmpl")) && is_file("$sDirectory/$sFileName")) {
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
