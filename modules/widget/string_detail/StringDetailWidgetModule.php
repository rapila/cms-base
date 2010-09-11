<?php
/**
 * @package modules.widget
 */
class StringDetailWidgetModule extends PersistentWidgetModule {
	private $sStringId = null;
	
	public function setStringId($sStringId) {
		$this->sStringId = $sStringId;
	}
	
	public function getStringData() {
		$oCriteria = new Criteria();
		$oCriteria->addGroupByColumn(StringPeer::STRING_KEY);
		$oCriteria->add(StringPeer::STRING_KEY, $this->sStringId);
		$oString = StringPeer::doSelectOne($oCriteria);
		if($oString === null) {
			$oString = new String();
		}
		return $oString->toArray();
	}
	
	public function getTextFor($sLanguageId) {
		$oString = StringPeer::retrieveByPK($sLanguageId, $this->sStringId);
		if($oString === null) {
			return '';
		}
		return $oString->getText();
	}
	
	private function validate($aStringData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aStringData);
		$oFlash->checkForValue('string_key');
		if($this->sStringId !== null && $this->sStringId !== $aStringData['string_key']) {
			if(StringQuery::create()->filterByStringKey($aStringData['string_key'])->count() > 0) {
				$oFlash->addMessage('string.exists');
			}
		}
		$oFlash->finishReporting();
	}
	
	public function saveData($aStringData) {
		$this->validate($aStringData);
		if(!Flash::noErrors($aStringData)) {
			throw new ValidationException();
		}
		
		$oConnection = Propel::getConnection(StringPeer::DATABASE_NAME);
		
		foreach(LanguagePeer::getLanguages() as $oLanguage) {
			$oUpdateCriteria = new Criteria();
			$oUpdateCriteria->add(StringPeer::LANGUAGE_ID, $oLanguage->getId());
			$oUpdateCriteria->add(StringPeer::STRING_KEY, $this->sStringId);
			
			if(isset($aStringData['text_'.$oLanguage->getId()])) {
				$sText = trim($aStringData['text_'.$oLanguage->getId()]);
				$oString = StringPeer::retrieveByPK($oLanguage->getId(), $this->sStringId);
				
				if($sText === '') {
					if($oString !== null) {
						$oString->delete();
					}
					continue;
				}
				
				if($oString === null) {
					$oString = new String();
					$oString->setLanguageId($oLanguage->getId());
					$oString->setStringKey($aStringData['string_key']);
				} else if ($this->sStringId !== null && $this->sStringId !== $aStringData['string_key']) {
					$oString->setStringKey($aStringData['string_key']);
					BasePeer::doUpdate($oUpdateCriteria, $oString->buildCriteria(), $oConnection);
				}
				$oString->setText($sText);
				$oString->save();
			} else {
				$oString = StringPeer::retrieveByPK($oLanguage->getId(), $this->sStringId);
				if($oString === null) {
					continue;
				}
				if($this->sStringId !== null && $this->sStringId !== $aStringData['string_key']) {
					$oString->setStringKey($aStringData['string_key']);
					BasePeer::doUpdate($oUpdateCriteria, $oString->buildCriteria(), $oConnection);
				}
			}
		}
		$this->sStringId = $aStringData['string_key'];
		return array('string_key' => $this->sStringId);
	}
}