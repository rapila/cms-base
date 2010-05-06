<?php
/**
 * @package modules.widget
 */
class StringDetailWidgetModule extends PersistentWidgetModule {
	private $iStringId = null;
	// handle language_id differently (content edit Language)
	private $sLanguageId = 'de';
	
	public function setStringId($iStringId) {
		$this->iStringId = $iStringId;
	}
	
	public function getStringData() {
		return StringPeer::retrieveByPK($this->sLanguageId, $this->iStringId)->toArray();
	}
	
	public function saveData($aStringData) {
		if($this->iStringId === null) {
			$oString = new String();
		} else {
			if($aStringData['string_key_old'] !== $aStringData['string_key']) {
				StringPeer::doDelete(array($this->sLanguageId,  $aStringData['string_key_old']));
				$oString = new String();
			} else {
				$oString = StringPeer::retrieveByPK($this->sLanguageId,  $this->iStringId);
			}
		}
		$oString->setLanguageId($this->sLanguageId);
		$oString->setStringKey($aStringData['string_key']);
		$oString->setText($aStringData['text']);
		return array('saved' => $oString->save(), 'string_key' => $oString->getStringKey());
	}
}