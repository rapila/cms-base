<?php
class SpecialTemplateIdentifierActions {
	private $oTemplate;

	public function __construct($oTemplate) {
		$this->oTemplate = $oTemplate;
	}

	public function writeSessionAttribute($oTemplateIdentifier) {
		$sValue = Session::getSession()->getAttribute($oTemplateIdentifier->getValue());
		if($oTemplateIdentifier->hasParameter('reset')) {
			Session::getSession()->resetAttribute($oTemplateIdentifier->getValue());
		}
		return $sValue;
	}

	public function writeString($oTemplateIdentifier) {
		$sDefaultValue = null;
		if($oTemplateIdentifier->hasParameter('defaultValue')) {
			$sDefaultValue = $oTemplateIdentifier->getParameter('defaultValue');
		}
		return StringPeer::getString($oTemplateIdentifier->getValue(), $oTemplateIdentifier->getParameter('languageId'), $sDefaultValue, null, true, $this->oTemplate->iDefaultFlags);
	}

	public function writeParameterizedString($oTemplateIdentifier) {
		return StringPeer::getString($oTemplateIdentifier->getValue(), null, null, $oTemplateIdentifier->getParameters(), true, $this->oTemplate->iDefaultFlags);
	}

	public function writeFlashValue($oTemplateIdentifier) {
		return Flash::getFlash()->getMessage($oTemplateIdentifier->getValue());
	}

	public function normalize($oTemplateIdentifier, &$iFlags) {
		$iFlags |= Template::NO_HTML_ESCAPE;
		return StringUtil::normalize($oTemplateIdentifier->getValue());
	}

	public function br($oTemplateIdentifier, &$iFlags) {
		$iFlags |= Template::NO_HTML_ESCAPE;
		return '<br />';
	}

	/**
	* @deprecated
	*/
	public function doCalculation($oTemplateIdentifier, &$iFlags) {
		//FIXME: We’re allowing this because templates are controlled by privileged users… But we should find a better solution to do calculations without eval.
		$cFunc = create_function("", "return ({$oTemplateIdentifier->getValue()});" );
		return $cFunc();
	}

	public function truncate($oTemplateIdentifier, &$iFlags) {
		$iFlags |= Template::NO_HTML_ESCAPE;
		$iLength=20;
		if($oTemplateIdentifier->hasParameter('length')) {
			$iLength = $oTemplateIdentifier->getParameter('length');
		}

		$sPostfix = "…";
		if($oTemplateIdentifier->hasParameter('postfix')) {
			$sPostfix = $oTemplateIdentifier->getParameter('postfix');
		}

		$iTolerance = 3;
		if($oTemplateIdentifier->hasParameter('tolerance')) {
			$iTolerance = $oTemplateIdentifier->getParameter('tolerance');
		}
		return StringUtil::truncate($oTemplateIdentifier->getValue(), $iLength, $sPostfix, $iTolerance);
	}

	public function quoteString($oTemplateIdentifier, &$iFlags) {
		$iFlags |= Template::NO_HTML_ESCAPE;
		if(!$oTemplateIdentifier->getValue()) {
			return $oTemplateIdentifier->hasParameter('defaultValue') ? $oTemplateIdentifier->getParameter('defaultValue') : null;
		}
		$sLocale = LocaleUtil::getLocaleId();
		$sStyle = 'double';
		if($oTemplateIdentifier->hasParameter('style')) {
			$sStyle = $oTemplateIdentifier->getParameter('style');
		}
		$bAlternate = $oTemplateIdentifier->hasParameter('alternate') && $oTemplateIdentifier->getParameter('alternate') === 'true';
		if(StringUtil::startsWith($sLocale, 'en_')) {
			if($sStyle === 'single') {
				return "‘{$oTemplateIdentifier->getValue()}’";
			}
			return "“{$oTemplateIdentifier->getValue()}”";
		}
		if(StringUtil::startsWith($sLocale, 'fr_') || $sLocale === 'de_CH') {
			if($sStyle === 'single') {
				return "‹{$oTemplateIdentifier->getValue()}›";
			}
			return "«{$oTemplateIdentifier->getValue()}»";
		}
		if(StringUtil::startsWith($sLocale, 'de_') || StringUtil::startsWith($sLocale, 'nl_')) {
			if($bAlternate) {
				if($sStyle === 'single') {
					return "›{$oTemplateIdentifier->getValue()}‹";
				}
				return "»{$oTemplateIdentifier->getValue()}«";
			}
			if($sStyle === 'single') {
				return "‚{$oTemplateIdentifier->getValue()}‘";
			}
			return "„{$oTemplateIdentifier->getValue()}“";
		}
		if($sStyle === 'single') {
			return "'{$oTemplateIdentifier->getValue()}'";
		}
		return '"'.$oTemplateIdentifier->getValue().'"';
	}

	/**
	* Create internal links.
	* The identifier value signifies the destination. It can be either a path or one of the following special values: “to_self”, “host_only”, “base_href”.
	* The following additional parameters are allowed: “is_absolute”, “page”, “ignore_request”, “manager”
	* Implicitly, the value of is_absolute determines the type of absolute link generated.
	* A value of “false” will not generate absolute links.
	* Using “auto” will determine server-side whether to use http or https for protocol.
	* Setting is_absolute to “http” or “https” will set the protocol accordingly.
	* Any other value (including “true”) will generate a protocol-relative URL (starting with //), meaning the reference is determined on the client-side.
	* Creating a “base_href” link will always make it absolute and not explicitly setting “is_absolute” will default to “auto” (instead of “true” as is the case with all other link types).
	*/
	public function writeLink($oTemplateIdentifier) {
		$sDestination = $oTemplateIdentifier->getValue();
		$aParameters = $oTemplateIdentifier->getParameters();
		$bIsAbsolute = false;
		$bAbsoluteType = $oTemplateIdentifier->getParameter('is_absolute');
		if($bAbsoluteType === 'http' || $bAbsoluteType === 'false') {
			$bAbsoluteType = false;
		} else if($bAbsoluteType === 'https' || $bAbsoluteType === 'true') {
			$bAbsoluteType = true;
		} else if($bAbsoluteType === 'auto') {
			$bAbsoluteType = LinkUtil::isSSL();
		} else if($oTemplateIdentifier->hasParameter('is_absolute')) {
			$bAbsoluteType = null;
		} else {
			$bAbsoluteType = 'default';
		}
		unset($aParameters['is_absolute']);
		if($sDestination === "to_self") {
			$bIgnoreRequest = $oTemplateIdentifier->getParameter('ignore_request') === 'true';
			unset($aParameters['ignore_request']);
			$sDestination = LinkUtil::linkToSelf(null, $aParameters, $bIgnoreRequest);
		} else if($sDestination === "host_only") {
			return LinkUtil::absoluteLink('');
		} else if($sDestination === "base_href") {
			$sDestination = MAIN_DIR_FE_PHP;
			$bIsAbsolute = true;
			if(!$oTemplateIdentifier->hasParameter('is_absolute')) {
				$bAbsoluteType = LinkUtil::isSSL();
			}
		} elseif($sPage = $oTemplateIdentifier->getParameter('page')) {
			$oPage = PageQuery::create()->findOneByIdentifier($sPage);
			if($oPage === null) {
				$oPage = PageQuery::create()->findOneByName($sPage);
			}
			$sManager = 'FrontendManager';
			if($oTemplateIdentifier->hasParameter('manager')) {
				$sManager = $oTemplateIdentifier->getParameter('manager');
			}
			if($oPage) {
				$sDestination = LinkUtil::link($oPage->getLink(), $sManager);
			}
		} else {
			$sManager = null;
			if($oTemplateIdentifier->hasParameter('manager')) {
				unset($aParameters['manager']);
				$sManager = $oTemplateIdentifier->getParameter('manager');
			}
			$sDestination = LinkUtil::link($sDestination, $sManager, $aParameters);
		}
		return LinkUtil::absoluteLink($sDestination, null, $bAbsoluteType, !$bIsAbsolute);
	}

	public function includeTemplate($oTemplateIdentifier, &$iFlags) {
		$oTemplatePath = $this->oTemplate->getTemplatePath();
		if($oTemplateIdentifier->hasParameter('fromBase')) {
			$oTemplatePath = null;
		}
		$oTemplate = $this->oTemplate->derivativeTemplate($oTemplateIdentifier->getValue(), $oTemplatePath, false);
		$iFlags |= Template::LEAVE_IDENTIFIERS|Template::NO_RECODE;
		if($oTemplateIdentifier->hasParameter('omitIdentifiers')) {
			$iFlags &= ~Template::LEAVE_IDENTIFIERS;
		}
		return $oTemplate;
	}

	public function writeDate($oTemplateIdentifier) {
		$iTimestamp = false;
		if($oTemplateIdentifier->hasParameter('timestamp')) {
			$iTimestamp = (int)$oTemplateIdentifier->getParameter('timestamp');
		} else if($oTemplateIdentifier->hasParameter('format')) {
			$iTimestamp = DateTime::createFromFormat($oTemplateIdentifier->getParameter('format'), $oTemplateIdentifier->getParameter('date'));
		}
		$sLocaleId = null;
		if($oTemplateIdentifier->hasParameter('locale')) {
			$sLocaleId = $oTemplateIdentifier->getParameter('locale');
		}
		return LocaleUtil::localizeDate($iTimestamp, $sLocaleId, $oTemplateIdentifier->getValue());
	}

	public function writeRequestValue($oTemplateIdentifier) {
		if(isset($_REQUEST[$oTemplateIdentifier->getValue()])) {
			return $_REQUEST[$oTemplateIdentifier->getValue()];
		}
		return null;
	}

	public function writeServerVariable($oTemplateIdentifier) {
		if(isset($_SERVER[$oTemplateIdentifier->getValue()])) {
			return $_SERVER[$oTemplateIdentifier->getValue()];
		}
		return null;
	}

	public function writeSettingValue($oTemplateIdentifier) {
		if(!$oTemplateIdentifier->hasParameter('section')) {
			return null;
		}
		return Settings::getSetting($oTemplateIdentifier->getParameter('section'), $oTemplateIdentifier->getValue(), null);
	}

	public function writeManagerPrefix($oTemplateIdentifier) {
		return Manager::getPrefixForManager($oTemplateIdentifier->getValue());
	}

	/**
	* Outputs the value of constants. Can be used with multiple constants as follows: {{writeConstantValue=DIRNAME_SITE/DIRNAME_WEB/DIRNAME_IMAGES}}.
	* FIXME: Allow a null-delimiter
	*/
	public function writeConstantValue($oTemplateIdentifier) {
		$aResult = array();
		foreach(explode('/', $oTemplateIdentifier->getValue()) as $sConstantName) {
			if(defined($sConstantName)) {
				$aResult[] = constant($sConstantName);
			}
		}
		return implode('/', $aResult);
	}

	public function writeTemplateName($oTemplateIdentifier) {
		return $this->oTemplate->getTemplateName();
	}

	public function addResourceInclude($oIdentifier) {
		$oResourceIncluder = $oIdentifier->hasParameter('name') ? ResourceIncluder::namedIncluder($oIdentifier->getParameter('name')) : ResourceIncluder::defaultIncluder();
		$oResourceIncluder->addResourceFromTemplateIdentifier($oIdentifier);
		return null;
	}

	public function writeDirectInclude($oIdentifier) {
		$oResourceIncluder = new ResourceIncluder();
		$oResourceIncluder->addResourceFromTemplateIdentifier($oIdentifier);
		return $oResourceIncluder->getIncludes(false);
	}

	public function writeResourceIncludes($oTemplateIdentifier) {
		$oResourceIncluder = null;
		if($oTemplateIdentifier->getValue() !== null) {
			$oResourceIncluder = ResourceIncluder::namedIncluder($oTemplateIdentifier->getValue());
		} else if($oTemplateIdentifier->hasParameter('name')) {
			// Fall back to 'name' param for backwards compatiblity
			$oResourceIncluder = ResourceIncluder::namedIncluder($oTemplateIdentifier->getParameter('name'));
		} else {
			$oResourceIncluder = ResourceIncluder::defaultIncluder();
		}
		$bConsolidate = null;
		if($oTemplateIdentifier->hasParameter('consolidate')) {
			$bConsolidate = $oTemplateIdentifier->getParameter('consolidate');
			if($bConsolidate === 'false') {
				$bConsolidate = false;
			} else if($bConsolidate !== 'internal') {
				$bConsolidate = true;
			}
		}
		return $oResourceIncluder->getIncludes(!$oTemplateIdentifier->hasParameter('noNewlines'), $bConsolidate);
	}

	public function replaceIn($oIdentifier) {
		$sText = $oIdentifier->getValue();
		$sReplacement = $oIdentifier->getParameter('with');
		if($oIdentifier->hasParameter('matching')) {
			$sPattern = $oIdentifier->getParameter('matching');
			if(!StringUtil::startsWith($sPattern, '/')) {
				$sPattern = '/'.$sPattern.'/';
			}
			return preg_replace($sPattern, $sReplacement, $sText);
		} else {
			$sSearch = $oIdentifier->getParameter('string');
			return str_replace($sSearch, $sReplacement, $sText);
		}
	}

	public static function getSpecialIdentifierNames() {
		return array_diff(get_class_methods('SpecialTemplateIdentifierActions'), array('getSpecialIdentifierNames', 'getAlwaysLastNames', '__construct'));
	}

	public static function getAlwaysLastNames() {
		return array('writeParameterizedString', 'writeFlashValue', 'doCalculation', 'writeRequestValue', 'truncate', 'quoteString', 'addResourceInclude', 'writeResourceIncludes', 'writeSessionAttribute', 'replaceIn');
	}
}
