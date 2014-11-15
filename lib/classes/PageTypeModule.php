<?php
/**
 */
abstract class PageTypeModule extends Module {
	protected static $MODULE_TYPE = 'page_type';

	protected $oPage;
	protected $oNavigationItem;

	public function __construct(Page $oPage = null, NavigationItem $oNavigationItem = null) {
		$this->oPage = $oPage;
		$this->oNavigationItem = $oNavigationItem;
	}

	public abstract function display(Template $oTemplate, $bIsPreview = false);

	public function getWords() {
		$oUsedTemplate = new Template($this->oPage->getTemplateNameUsed());
		$sTemplateContents = '';
		foreach($oUsedTemplate->identifiersMatching('container', Template::$ANY_VALUE) as $oTemplateIdentifier) {
			if($oTemplateIdentifier->hasParameter('declaration_only')) {
				// Container exists only to appear in admin area, not be rendered in frontend (at least not directly)
				continue;
			}
			$sTemplateContents .= $oTemplateIdentifier->__toString();
		}
		foreach($oUsedTemplate->identifiersMatching('autofill', Template::$ANY_VALUE) as $oTemplateIdentifier) {
			$sTemplateContents .= $oTemplateIdentifier->__toString();
		}
		$sTemplate = new Template($sTemplateContents, null, true);
		$this->display($sTemplate, false);
		return StringUtil::getWords($sTemplate, true);
	}

	public function acceptedRequestParams($aModulesToCheck = null) {
		if(method_exists($this, 'setIsDynamicAndAllowedParameterPointers')) {
			$aResult = array();
			$bIsDynamic = false;
			$this->setIsDynamicAndAllowedParameterPointers($bIsDynamic, $aResult, $aModulesToCheck);
			return $aResult;
		}
		return array();
	}

	//Warning: different than normal
	public static function getModuleInstance($sModuleName = null) {
		$aArgs = func_get_args();
		if(!$sModuleName) {
			$aArgs[0] = "default";
		}
		array_unshift($aArgs, self::getType());
		return call_user_func_array(array('Module', 'getModuleInstanceByTypeAndName'), $aArgs);
	}
}
