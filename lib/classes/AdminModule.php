<?php
class AdminModule extends Module {
	protected static $MODULE_TYPE = 'admin';
	
	private $aResourceParameters = null;
	
	public function __construct() {
		$this->aResourceParameters = array_fill_keys(TemplateResourceFileModule::$RESOURCE_TYPES, array());
	}
	
	public function usedWidgets() {
		return array();
	}
	
	public function mainContent() {
		return null;
	}
	
	public function sidebarContent() {
		return null;
	}
	
	protected function addResourceParameter($sResourceType, $sParameterName, $sParameterValue) {
		$this->aResourceParameters[$sResourceType][$sParameterName] = $sParameterValue;
	}
	
	public function includeCustomResources($oResourceIncluder) {
		TemplateResourceFileModule::includeAvailableResources($this, false, $oResourceIncluder, $this->aResourceParameters);
	}
	
	public static function getDocumentationIdentifier() {
		return self::getType().'.'.$this->getModuleName();
	}
	
	public static function getReferences($aReferences) {
		if(count($aReferences) === null) {
			return null;
		}
		$aResult = array();
		foreach($aReferences as $oReference) {
			if($oReference->getFromModelName() === 'LanguageObject') {
				$oReferencedFromObject = $oReference->getFrom();
				if($oReferencedFromObject) {
					$oContentObject = $oReferencedFromObject->getContentObject();
					$aResult[$oReferencedFromObject->getId()]['title'] = StringPeer::getString('reference.used_in_page');
					$aResult[$oReferencedFromObject->getId()]['page_name'] = $oContentObject->getPage()->getName();
					$aResult[$oReferencedFromObject->getId()]['container_name'] = $oContentObject->getContainerName();
					$aResult[$oReferencedFromObject->getId()]['edit_link'] = TagWriter::quickTag('a', array('href' => LinkUtil::link(array('content', $oContentObject->getPageId(), 'edit', $oContentObject->getId()), 'AdminManager')), 'edit')->render();
				} else {
					// delete reference if getFrom() === null
					$oReference->delete();
				}
			} else {
				$aResult[$oReference->getFromId()]['title'] = StringPeer::getString('reference.used_in_object');
				$aResult[$oReference->getFromId()]['object_class'] = $oReference->getFromModelName();
				$aResult[$oReference->getFromId()]['object_id'] = $oReference->getFromId();
			}
		}
		return $aResult;
	}

}