<?php
/**
 * @package modules.widget
 */
class ContentDisplayConditionWidgetModule extends PersistentWidgetModule {
	private $iContentObjectId;
	
	public function setContentObjectId($iContentObjectId) {
		$this->iContentObjectId = $iContentObjectId;
	}

	public function getContentObjectId() {
		return $this->iContentObjectId;
	}
	
	public function retrieveCondition() {
		$oContentObject = ContentObjectPeer::retrieveByPK($this->iContentObjectId);
		$rCondition = $oContentObject->getConditionSerialized();
		if($rCondition === null) {
			return null;
		}
		$oConditionTemplate = unserialize(stream_get_contents($rCondition));
		$aResult = array();
		$oIf = $oConditionTemplate->identifiersMatching('if', Template::$ANY_VALUE);
		$oIf = $oIf[0];
		$aResult['condition_left'] = $oIf->getParameter('1');
		$aResult['condition_right'] = $oIf->getParameter('2');
		$aResult['comparison'] = $oIf->getValue();
		return $aResult;
	}
	
	public function saveData($aCondition) {
		$oContentObject = ContentObjectPeer::retrieveByPK($this->iContentObjectId);
		$bHasCondition = false;
		if(trim($aCondition['condition_left']) === '') {
			$oContentObject->setConditionSerialized(null);
		} else {
			$oConditionTemplate = new Template('', null, true);
			$aTemplateContents = array();
			$oIf = new TemplateIdentifier('if', $aCondition['comparison'], array(), $oConditionTemplate);
			$oIf->setParameter('1', $aCondition['condition_left']);
			$oIf->setParameter('2', $aCondition['condition_right']);
			$aTemplateContents[] = $oIf;
			$aTemplateContents[] = 'visible';
			$aTemplateContents[] = new TemplateIdentifier('endIf', null, array(), $oConditionTemplate);
			$oConditionTemplate = new Template($aTemplateContents, null, true);
			$oContentObject->setConditionSerialized(serialize($oConditionTemplate));
			$bHasCondition = true;
		}
		$oContentObject->save();
		return $bHasCondition;
	}
}
