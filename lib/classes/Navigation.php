<?php
/**
 * classname:		Navigation
 */
class Navigation {
	private static $TEMPLATES = array();
	
	private $aConfig = null;
	private $iMaxLevel = 0;
	private $sLinkPrefix;
	private $sNavigationName = null;
	private static $BOOLEAN_PARSER_DEFAULT_VALUES = array(
						"has_children" => false,
						"is_current" => false,
						"is_active" => false,
						"is_hidden" => false,
						"is_disabled" => false,
						"is_inaccessible" => false,
						"is_sibling_of_current" => false,
						"is_sibling_of_active" => false,
						"is_child_of_current" => false,
						"is_folder" => false,
						"is_virtual" => false,
						"is_descendant_of_current" => false,
						//Please don't use those properties in frontend navigations
						"user_may_create" => false,
						"user_may_edit" => false);
	private $sTemplatesDir;
	private $bShowOnlyEnabledChildren;
	private $bShowOnlyVisibleChildren;
	private $bPrintNewline;
	private $sLanguageId;
	
	/**
	 * __constructor()
	 * @param string navigation name
	 * each navigation part needs configuration in section called 'navigation' in the site/config/config.yml
	 * @return void / exception on missing configuration
	 */
	public function __construct($mConfig, $sLinkPrefix=null, $sTemplatesDir = null) {
		if($sTemplatesDir === null) {
			$this->sTemplatesDir = array(DIRNAME_TEMPLATES, DIRNAME_NAVIGATION);
		} else {
			$this->sTemplatesDir = $sTemplatesDir;
		}
		if(is_string($mConfig)) {
			$this->aConfig = Settings::getSetting("navigations", $mConfig, null);
			$this->sNavigationName = $mConfig;
		} else if(is_array($mConfig)) {
			$this->aConfig = $mConfig;
		}
		if($this->aConfig === null) {
			throw new Exception("Navigation $mConfig not configured");
		}
		if($sLinkPrefix===null) {
			$sLinkPrefix = LinkUtil::link();
		}
		if(!StringUtil::endsWith($sLinkPrefix, "/")) {
			$sLinkPrefix .= "/";
		}
		$this->sLinkPrefix = $sLinkPrefix;
		$this->iMaxLevel = max(array_keys($this->aConfig));
		if(!is_numeric($this->iMaxLevel) || isset($this->aConfig['all'])) {
			$this->iMaxLevel = null;
		}
		$this->bShowOnlyEnabledChildren = isset($this->aConfig["show_inactive"]) ? ($this->aConfig["show_inactive"] !== true) : true;
		$this->bShowOnlyVisibleChildren = isset($this->aConfig["show_hidden"]) ? ($this->aConfig["show_hidden"] !== true) : true;
		$this->bPrintNewline = isset($this->aConfig["no_newline"]) ? ($this->aConfig["no_newline"] !== true) : true;
		$this->sLanguageId = isset($this->aConfig["language"]) ? $this->aConfig["language"] : Session::language();
	} // __construct()

	/**
	 * parse()
	 */	 
	public function parse(NavigationItem $oNavigationItem) {
		return $this->parseTree(array($oNavigationItem), 0);
	} // parse()
	
	/**
	 * parseTree()
	 * @param array of Page objects
	 * @param int level of navigation
	 * @return string parsed navigation
	 */
	private function parseTree($aNavigationItems, $iLevel) {
		if($this->iMaxLevel !== null && $iLevel > $this->iMaxLevel) {
			return null;
		}
		$sResult = new Template(TemplateIdentifier::constructIdentifier('content'), null, true);
		$bNoPagesDisplayed = true;
		foreach($aNavigationItems as $oNavigationItem) {
			$oBooleanParser = new BooleanParser(self::$BOOLEAN_PARSER_DEFAULT_VALUES);
			$bHasChildren = $oNavigationItem->hasChildren($this->sLanguageId, !$this->bShowOnlyEnabledChildren, !$this->bShowOnlyVisibleChildren);

			if($bHasChildren) {
				$oBooleanParser->has_children = true;
			}
			if($oNavigationItem->isCurrent()) {
				$oBooleanParser->is_current = true;
			}
			if($oNavigationItem->isActive()) {
				$oBooleanParser->is_active = true;
			}
			if(!$oNavigationItem->isEnabled()) {
				$oBooleanParser->is_disabled = true;
			}
			if(!$oNavigationItem->isVisible()) {
				$oBooleanParser->is_hidden = true;
			}
			if(!$oNavigationItem->isAccessible()) {
				$oBooleanParser->is_inaccessible = true;
			}
			if($oNavigationItem->isSiblingOfCurrent()) {
				$oBooleanParser->is_sibling_of_current = true;
			}
			if($oNavigationItem->isSiblingOfActive()) {
				$oBooleanParser->is_sibling_of_active = true;
			}
			if($oNavigationItem->isChildOfCurrent()) {
				$oBooleanParser->is_child_of_current = true;
			}
			if($oNavigationItem->isDescendantOfCurrent()) {
					$oBooleanParser->is_descendant_of_current = true;
			}
			if($oNavigationItem->isFolder()) {
					$oBooleanParser->is_folder = true;
			}
			if($oNavigationItem->isVirtual()) {
					$oBooleanParser->is_virtual = true;
			}
			
			$aConfig = $this->getConfigForPage($iLevel, $oBooleanParser, $oNavigationItem);
			
			//Don’t show page (and subpages) in navigation if show===false
			if(@$aConfig['show'] === false) {
				continue;
			}
			
			$sTemplateName = @$aConfig['template'];
			$sInlineTemplate = @$aConfig['template_inline'];
			
			if($sTemplateName === null && $sInlineTemplate === null && ($this->iMaxLevel !== null && $iLevel+1 > $this->iMaxLevel)) {
				continue;
			}
			
			$bNoPagesDisplayed = false;
			
			if(!$sTemplateName && $sInlineTemplate) {
				$oTemplate = new Template($sInlineTemplate, null, true);
			} else {
				$oTemplate = $this->getTemplate($sTemplateName);
			}
			
			$oTemplate->replaceIdentifier('name', $oNavigationItem->getName());
			$oTemplate->replaceIdentifier('page_title', $oNavigationItem->getTitle());
			$oTemplate->replaceIdentifier('title', $oNavigationItem->getLinkText());
			$oTemplate->replaceIdentifier('description', $oNavigationItem->getDescription());
			
			$oTemplate->replaceIdentifier('link_prefix', $this->sLinkPrefix);
			$oTemplate->replaceIdentifier('link_without_prefix', implode('/', $oNavigationItem->getLink()));
			
			$oTemplate->replaceIdentifier('link', $this->sLinkPrefix.implode('/', $oNavigationItem->getLink()));
			$oTemplate->replaceIdentifier('level', $iLevel);
			
			foreach($oBooleanParser->getItems() as $aNavigationAttributeName => $aNavigationAttributeValue) {
				$oTemplate->replaceIdentifier($aNavigationAttributeName, $aNavigationAttributeValue);
			}
			
			if($oBooleanParser->is_current) {
				$oTemplate->replaceIdentifier('status', "current");
			} else if($oBooleanParser->is_active) {
				$oTemplate->replaceIdentifier('status', "active");
			} else if($oBooleanParser->is_sibling_of_current) {
				$oTemplate->replaceIdentifier('status', "sibling_of_current");
			} else if($oBooleanParser->is_sibling_of_active) {
				$oTemplate->replaceIdentifier('status', "sibling_of_active");
			} else if($oBooleanParser->is_child_of_current) {
				$oTemplate->replaceIdentifier('status', 'child_of_current');
			} else if($oBooleanParser->is_descendant_of_current) {
				$oTemplate->replaceIdentifier('status', 'descendant_of_current');
			} else {
				$oTemplate->replaceIdentifier('status', "default");
			}
			
			if($oTemplate->hasIdentifier('children') && $bHasChildren && !($this->iMaxLevel !== null && $iLevel+1 > $this->iMaxLevel)) {
				$aChildren = $oNavigationItem->getChildren($this->sLanguageId, !$this->bShowOnlyEnabledChildren, !$this->bShowOnlyVisibleChildren);
				$oTemplate->replaceIdentifier('children', $this->parseTree($aChildren, $iLevel+1));
			}
			
			$sResult->replaceIdentifierMultiple("content", $oTemplate, null, ($this->bPrintNewline ? 0 : Template::NO_NEWLINE));
		}
		if($bNoPagesDisplayed) {
			return null;
		}
		return $sResult;
	} // parseTree()
	
	private function getTemplate($sTemplateName) {
		if(!isset(self::$TEMPLATES[$sTemplateName])) {
			if($sTemplateName === null) {
				self::$TEMPLATES[$sTemplateName] = new Template(TemplateIdentifier::constructIdentifier('children'), null, true);
			} else {
				self::$TEMPLATES[$sTemplateName] = new Template($sTemplateName, $this->sTemplatesDir);
			}
		}
		return clone self::$TEMPLATES[$sTemplateName];
	}
	
	/**
	 * getConfigForPage()
	 * @param string config var name
	 * @param int level of navigation
	 * @return string parsed navigation
	 */	 
	private function getConfigForPage($iLevel, $oBooleanParser, $oNavigationItem) {
		$aConfigToCheck = @$this->aConfig[$iLevel];
		if($aConfigToCheck === null) {
			if(!isset($this->aConfig['all'])) {
				return null;
			}
			$aConfigToCheck = $this->aConfig['all'];
		}
		foreach($aConfigToCheck as $aConfig) {
			if(isset($aConfig['page_name']) && $aConfig['page_name'] !== $oNavigationItem->getName()) {
				continue;
			}
			if(isset($aConfig['page_identifier']) && $aConfig['page_identifier'] !== $oNavigationItem->getIdentifier()) {
				continue;
			}
			if(!isset($aConfig['on']) || $oBooleanParser->parse($aConfig['on'])) {
				return $aConfig;
			}
		}
		return null;
	}
	
	/**
	 * getLanguageChooser()
	 * description: 
	 * - @see config.yml section language_chooser
	 * - use parameter replaced in method
	 * @return template object
	 */		
	public static function getLanguageChooser() {
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('languages'), null, true);
		$oLanguageTemplate = new Template(Settings::getSetting("language_chooser", 'template', 'language'), array(DIRNAME_TEMPLATES, DIRNAME_NAVIGATION));
		$sLinkSeparator = Settings::getSetting("language_chooser", 'link_separator', ' | ');
		$oLanguageActiveTemplate = $oLanguageTemplate;
		$bShowActiveLanguage = Settings::getSetting("language_chooser", 'show_active_language', false);
		
		if($bShowActiveLanguage && Settings::getSetting("language_chooser", 'template_active', false) !== false) {
			$oLanguageActiveTemplate = new Template(Settings::getSetting("language_chooser", 'template_active', 'language_active'), array(DIRNAME_TEMPLATES, DIRNAME_NAVIGATION));
		}
		
		//Find request variables
		$aParameters = array_diff_assoc($_REQUEST, $_COOKIE);
		unset($aParameters['path']);
		unset($aParameters['content_language']);
		
		// check whether manager needs language to be included
		$bCurrentPathIncludesLanguage = call_user_func(array(Manager::getManagerClassNormalized(null), 'shouldIncludeLanguageInLink'));
		$aRequestPath = explode("/", Manager::getRequestedPath());

		$aLanguages = LanguagePeer::getLanguages(true, true, !$bShowActiveLanguage);
		foreach($aLanguages as $i => $oLanguage) {
			$oLangTemplate = null;
			if($oLanguage->getId() === Session::language()) {
				$oLangTemplate = clone $oLanguageActiveTemplate;
				$oLangTemplate->replaceIdentifier('class', 'active');
			} else {
				$oLangTemplate = clone $oLanguageTemplate;
			}
			// if language is included, replace it by oLanguage->getId() and set include_language param to false
			if($bCurrentPathIncludesLanguage) {
				$aRequestPath[0] = $oLanguage->getPathPrefix();	 
				$oLangTemplate->replaceIdentifier('link', LinkUtil::link($aRequestPath, null, $aParameters, false));
			} else {
				$oLangTemplate->replaceIdentifier('link', LinkUtil::link($aRequestPath, null, array_merge($aParameters, array('content_language' => $oLanguage->getId()))));
			}
			$oLangTemplate->replaceIdentifier('id', $oLanguage->getId());
			$oLangTemplate->replaceIdentifier('name', $oLanguage->getLanguageName($oLanguage->getId()));
			$oLangTemplate->replaceIdentifier('name_in_current_lang', $oLanguage->getLanguageName());
			$oTemplate->replaceIdentifierMultiple('languages', $oLangTemplate, null, Template::NO_NEWLINE);
			if(($i+1) < count($aLanguages)) {
				$oTemplate->replaceIdentifierMultiple('languages', $sLinkSeparator, null, Template::NO_HTML_ESCAPE|Template::NO_NEWLINE);
			}
		}
		return $oTemplate;
	} // getLanguageChooser()
	
} // end class Navigation
