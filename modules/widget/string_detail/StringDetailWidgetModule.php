<?php
/**
 * @package modules.widget
 */
class StringDetailWidgetModule extends PersistentWidgetModule {
	private $sStringId = null;
	const SIDEBAR_CHANGED = 'namespaces_changed';
	
	public function setStringId($sStringId) {
		$this->sStringId = $sStringId;
	}
	
	public function stringData() {
		$oCriteria = new Criteria();
		$oCriteria->addGroupByColumn(TranslationPeer::STRING_KEY);
		$oCriteria->add(TranslationPeer::STRING_KEY, $this->sStringId);
		$oString = TranslationPeer::doSelectOne($oCriteria);
		if($oString === null) {
			$oString = new Translation();
		}
		$aResult = $oString->toArray();
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oString);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oString);
		return $aResult;
	}
	
	public function getActiveLanguages() {
		if($this->sStringId === null) {
			return null;
		}
		$aResult = array();
		foreach(TranslationPeer::getStringsByStringKey($this->sStringId) as $oString) {
			$aResult[] = $oString->getLanguageId();
		}
		return $aResult;
	}
	
	public function getTextFor($sLanguageId) {
		$oString = TranslationQuery::create()->findPk(array($sLanguageId, $this->sStringId));
		if($oString === null) {
			return '';
		}
		return $oString->getText();
	}
	
	private function validate($aStringData) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aStringData);
		$oFlash->checkForValue('string_key', 'string.key_required');

		// if string is new, or string_key has changed, then the existence of the string_key has to be checked
		if($this->sStringId === null || $this->sStringId !== $aStringData['string_key']) {
			if(TranslationQuery::create()->filterByStringKey($aStringData['string_key'])->count() > 0) {
				$oFlash->addMessage('string.key_exists');
			}
		}
		$oFlash->finishReporting();
	}
	
	public function saveData($aStringData) {
		$this->validate($aStringData);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oConnection = Propel::getConnection();
		
		foreach(LanguageQuery::create()->orderById()->find() as $oLanguage) {
			$oUpdateCriteria = new Criteria();
			$oUpdateCriteria->add(TranslationPeer::LANGUAGE_ID, $oLanguage->getId());
			$oUpdateCriteria->add(TranslationPeer::STRING_KEY, $this->sStringId);
			
			if(isset($aStringData['text_'.$oLanguage->getId()])) {
				$sText = trim($aStringData['text_'.$oLanguage->getId()]);
				$oString = TranslationQuery::create()->findPk(array($oLanguage->getId(), $this->sStringId));
				
				if($sText === '') {
					if($oString !== null) {
						$oString->delete();
					}
					continue;
				}
				
				if($oString === null) {
					$oString = new Translation();
					$oString->setLanguageId($oLanguage->getId());
					$oString->setStringKey($aStringData['string_key']);
				} else if ($this->sStringId !== null && $this->sStringId !== $aStringData['string_key']) {
					$oString->setStringKey($aStringData['string_key']);
					BasePeer::doUpdate($oUpdateCriteria, $oString->buildCriteria(), $oConnection);
				}
				$oString->setText($sText);
				$oString->save();
			} else {
				$oString = TranslationQuery::create()->findPk(array($oLanguage->getId(), $this->sStringId));
				if($oString === null) {
					continue;
				}
				if($this->sStringId !== null && $this->sStringId !== $aStringData['string_key']) {
					$oString->setStringKey($aStringData['string_key']);
					BasePeer::doUpdate($oUpdateCriteria, $oString->buildCriteria(), $oConnection);
				}
			}
		}
		// check sidebar reload criteria
		$sNameSpaceOld = TranslationPeer::getNameSpaceFromStringKey($this->sStringId);
		$sNameSpaceNew = TranslationPeer::getNameSpaceFromStringKey($aStringData['string_key']);
		
		// if both are the same the sidebar is not effected
		$bSidebarHasChanged = false;
		if($sNameSpaceOld !== $sNameSpaceNew) {
			// if there was an old name space then we have to check whether it was the last string with this namespace
			if($sNameSpaceOld !== null && !TranslationPeer::nameSpaceExists($sNameSpaceOld)) {
				$bSidebarHasChanged = true;
			}
			// if the new exits only once it has been created and the sidebar needs to be relaoded
			if($sNameSpaceNew !== null && TranslationPeer::countNameSpaceByName($sNameSpaceNew) === 1) {
				$bSidebarHasChanged = true;
			}
		}
		$this->sStringId = $aStringData['string_key'];
		return array('id' => $this->sStringId, self::SIDEBAR_CHANGED => $bSidebarHasChanged);
	}
}