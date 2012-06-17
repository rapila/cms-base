<?php
class LanguageObjectControlWidgetModule extends PersistentWidgetModule {
	private $oCurrentLanguageObject;
	private $oModuleInstance;
	
	public function __construct($sSessionKey, $oCurrentLanguageObject, $oModuleInstance) {
		parent::__construct($sSessionKey);
		$this->oCurrentLanguageObject = $oCurrentLanguageObject;
		$this->oModuleInstance = $oModuleInstance;
	}

	public function editor() {
		$oWidget = $this->oModuleInstance->getWidget();
		if($oWidget instanceof WidgetModule) {
			if(method_exists($oWidget, 'setObjectId')) {
				$oWidget->setObjectId($this->oCurrentLanguageObject->getObjectId());
			}
			return array($oWidget->getModuleName(), $oWidget->getSessionKey());
		}
		return array($oWidget, null);
	}

	public function save($aData, $bSaveDraft = false) {
		$mSaveData = $this->oModuleInstance->getSaveData($aData);
		$oSaveInto = $this->oCurrentLanguageObject;
		if($bSaveDraft) {
			if($this->oCurrentLanguageObject->getHasDraft()) {
				$oSaveInto = $this->oCurrentLanguageObject->getDraft();
			} else {
				$oSaveInto = $this->oCurrentLanguageObject->newHistory(true);
				if(!$this->oCurrentLanguageObject->isNew()) {
					$this->oCurrentLanguageObject->save();
				}
			}
		} else {
			if($this->oCurrentLanguageObject->getHasDraft()) {
				$oDraft = $this->oCurrentLanguageObject->getDraft();
				$this->oCurrentLanguageObject->setHasDraft(false);
				if($this->oCurrentLanguageObject->isNew()) {
					$oDraft->delete();
				} else {
					$oDraft->setData($this->oCurrentLanguageObject->getData());
					$oDraft->save();
				}
			}
		}
		$oSaveInto->setData($mSaveData);
		return array('saved' => $oSaveInto->save(), 'language_object_exists' => !$this->oCurrentLanguageObject->isNew());
	}
	
	public function __sleep() {
		if($this->oCurrentLanguageObject !== null) {
			$this->oCurrentLanguageObject = $this->oCurrentLanguageObject->getId();
		}
		return array_keys(get_object_vars($this));
	}
	
	public function __wakeup() {
		if($this->oCurrentLanguageObject !== null) {
			$sId = explode('_', $this->oCurrentLanguageObject);
			$sClass = 'LanguageObject';
			$this->oCurrentLanguageObject = call_user_func_array(array("{$sClass}Peer", 'retrieveByPK'), $sId);
			if($this->oCurrentLanguageObject === null) {
				$this->oCurrentLanguageObject = new $sClass();
				$this->oCurrentLanguageObject->setObjectId($sId[0]);
				$this->oCurrentLanguageObject->setLanguageId($sId[1]);
			}
		}
	}
}
