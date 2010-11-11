<?php
class TagEditWidgetModule extends PersistentWidgetModule {
	private $oFrontendModule;
	private $sDisplayMode;
	
	public function __construct($sSessionKey, $oFrontendModule) {
		parent::__construct($sSessionKey);
		$this->oFrontendModule = $oFrontendModule;
		$this->sDisplayMode = $this->oFrontendModule->widgetData();
	}
	
	public function getConfiguredMode() {
		return $this->sDisplayMode;
	}
	
	public function allTagedItems() {
	}
	
	public function getConfigurationModes() {
		$aResult = array();
		$aResult['templates'] = AdminManager::getSiteTemplatesForListOutput();
		$aResult['tags'] = array();
		foreach(TagPeer::doSelect(new Criteria()) as $oTag) {
			$aResult['tags'][] = array('name' => $oTag->getName(), 'count' => $oTag->countTagInstances(), 'id' => $oTag->getId());
		}
		$aResult['types'] = self::getTaggedModels();
		return $aResult;
	}
	
 /** getTaggedModels()
	* to be used in TagsAdminModule
	*/
	public static function getTaggedModels($bCount=false) {
		$oCriteria = new Criteria();
		$oCriteria->clearSelectColumns()->addSelectColumn(TagInstancePeer::MODEL_NAME);
		$oCriteria->setDistinct();
		if($bCount) {
			return TagInstancePeer::doCount($oCriteria);
		}
		$oCriteria->addAscendingOrderByColumn(TagInstancePeer::MODEL_NAME);
		$aResult = array();
		foreach(TagInstancePeer::doSelectStmt($oCriteria)->fetchAll(PDO::FETCH_ASSOC) as $aTag) {
			$sTableName = constant($aTag['MODEL_NAME'].'Peer::TABLE_NAME');
			$sName = StringPeer::getString('module.backend.'.$sTableName);
			$aResult[$aTag['MODEL_NAME']] = $sName;
		}
		return $aResult;
	}
	
	public function saveData($mData) {
		return $this->oFrontendModule->widgetSave($mData);
	}
	
	public function getElementType() {
		return 'form';
	}
}