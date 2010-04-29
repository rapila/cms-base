<?php
/**
 */
abstract class BackendModule extends Module {
	protected static $MODULE_TYPE = DIRNAME_BACKEND;
	
	public abstract function getChooser();
	public abstract function getDetail();
	protected function save() {}
	protected function validateForm($oFlash) {}
	public function customCss() {return "";}
	public function customJs() {return "";}
	public function getNewEntryActionParams() {return null;}
	
	/**
	* Returns the class name of the main model that is being modified at the moment by the backend module
	* Used only to assign tags using the tag panel
	* Default is null
	*/
	public function getModelName() {return null;}
	
	/**
	* Returns the primary key value of the main model ({@link getModelName}) row that is being modified at the moment by the backend module
	* Used only to assign tags using the tag panel
	* Default is null
	*/
	public function getCurrentId() {return null;}
	
	/**
	* This method should return true if a search bar is to be included for this backend module
	*/
	public function hasSearch() {return false;}
	
	public function doSave() {
		$oFlash = Flash::getFlash();
		$this->validateForm($oFlash);
		$oFlash->finishReporting();
		$this->save();
	}
	
	protected function link($sPath="", $aParameters = array()) {
		return LinkUtil::link($this->getModuleName()."/".$sPath, null, $aParameters);
	}
	
	protected function getReferenceMessages($aReferences) {
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('references'), null, true);
		foreach($aReferences as $oReference) {
			$oRefTemplate = null;
			if($oReference->getFromModelName() === 'LanguageObject') {
				$oReferencedFromObject = $oReference->getFrom();
				if($oReferencedFromObject) {
					$oContentObject = $oReferencedFromObject->getContentObject();
					$oRefTemplate = $this->constructTemplate('reference_language_object', true);
					$oRefTemplate->replaceIdentifier('page_name', $oContentObject->getPage()->getName());
					$oRefTemplate->replaceIdentifier('container_name', $oContentObject->getContainerName());
					$oRefTemplate->replaceIdentifier('edit_link', TagWriter::quickTag('a', array('href' => LinkUtil::link(array('content', $oContentObject->getPageId(), 'edit', $oContentObject->getId()), 'BackendManager')), 'edit'));
				} else {
					// delete reference if getFrom() === null
					$oReference->delete();
					// throw new Exception('Error in BackendModule::getReferenceMessages(): check your reference cleanup');
				}
			} else {
				$oRefTemplate = $this->constructTemplate('reference_other', true);
				$oRefTemplate->replaceIdentifier('object_class', $oReference->getFromModelName());
				$oRefTemplate->replaceIdentifier('object_id', $oReference->getFromId());
			}
			$oTemplate->replaceIdentifierMultiple('references', $oRefTemplate);
		}
		return $oTemplate;
	}
	
	protected function parseTree($oTemplate, $aItems, $oCurrentObject = null, $aParameters = array()) {
		foreach($aItems as $oItem) {
			$oItemTemplate = $this->constructTemplate("tree_item", true);
			$oItemTemplate->replaceIdentifier("name", Util::nameForObject($oItem));
			$oItemTemplate->replacePstring('edit.item_title', array("title" => Util::nameForObject($oItem)));
			$sClassIsIncative = 'edit';
			if(Util::equals($oCurrentObject, $oItem)) {
				$oItemTemplate->replaceIdentifier("class_active", ' active');
			}
			if(is_object($oItem)) {
				if(method_exists($oItem, 'getIsActive') && !$oItem->getIsActive()) {
					$sClassIsIncative = 'edit_inactive';
				}
				if(method_exists($oItem, 'getIsInactive') && $oItem->getIsInactive()) {
					$sClassIsIncative = 'edit_inactive';
				}
			}
			$oItemTemplate->replaceIdentifier("class_is_inactive", $sClassIsIncative);
			$oItemTemplate->replaceIdentifier("link", $this->link(Util::idForObject($oItem), $aParameters));
			$oTemplate->replaceIdentifierMultiple("tree", $oItemTemplate);
		}
	}
		
	//Functions which should actually be in Module superclass but can't because they rely on MODULE_TYPE
	public static function getType() {
		return self::$MODULE_TYPE;
	}
	
	public static function listModules() {
		return self::listModulesByType(self::getType());
	}
	
	public static function getClassNameByName($sModuleName) {
		return StringUtil::camelize($sModuleName, true).get_class();
	}
	
	public static function getNameByClassName($sClassName) {
		if(strpos($sClassName, get_class()) === false) {
			return $sClassName;
		}
		return StringUtil::deCamelize(substr($sClassName, 0, 0-strlen(get_class())));
	}
	
	public static function getDisplayNameByName($sModuleName, $sLangugaeId = null) {
		return self::getDisplayNameByTypeAndName(self::getType(), $sModuleName, $sLangugaeId);
	}
	
	public static function getModuleInstance($sModuleName) {
		$aArgs = func_get_args();
		array_unshift($aArgs, self::getType());
		return call_user_func_array(array("Module", "getModuleInstanceByTypeAndName"), $aArgs);
	}
	
	public function getModuleName() {
		return self::getNameByClassName(get_class($this));
	}
	
	public static function isValidModuleClassName($sName) {
		return StringUtil::endsWith($sName, StringUtil::camelize(self::$MODULE_TYPE, true)."Module");
	}
}
