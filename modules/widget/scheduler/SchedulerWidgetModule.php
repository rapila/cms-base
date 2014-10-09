<?php
class SchedulerWidgetModule extends PersistentWidgetModule {
	
	private $oList;
	
	private $sModelName;
	private $sModelId;
	
	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$this->oList = new ScheduledActionListWidgetModule();
		$this->setSetting('list_widget_session', $this->oList->getSessionKey());
	}

	public function getElementType() {
		$oTag = new TagWriter('div', array(), 'scheduler');
		$oTag->addToParameter('class', 'rapila-icon');
		$oTag->addToParameter('class', 'ui-badge');
		return $oTag;
	}
	
	public function setModelName($sModelName) {
		$this->sModelName = $sModelName;
		$this->oList->setModelName($sModelName);
	}

	public function setModelId($sModelId) {
		$this->sModelId = $sModelId;
		$this->oList->setModelId($sModelId);
	}
	
	public function availableActions() {
		return ScheduledActionQuery::listActions($this->sModelName);
	}
	
	public function countScheduled() {
		return ScheduledActionQuery::create()->scheduled()->filterByModelName($this->sModelName)->filterByModelId($this->sModelId)->count();
	}
	
	public function addSchedule($aData) {
		$oSchedule = new ScheduledAction();
		$oDate = DateTime::createFromFormat('Y-m-d H:i:s', $aData['date'].' '.$aData['time'], new DateTimeZone($aData['timezone']));
		$oDate->setTimezone(new DateTimeZone('UTC'));
		$oSchedule->setScheduleDate($oDate);
		$oSchedule->setAction($aData['action']);
		$oSchedule->setModelName($this->sModelName);
		$oSchedule->setModelId($this->sModelId);
		$oSchedule->save();
	}
	
	public function recalcDate($aDates, $sOldTZ) {
		$oDate = DateTime::createFromFormat('Y-m-d H:i:s', $aDates['date'].' '.$aDates['time'], new DateTimeZone($sOldTZ));
		$oDate->setTimezone(new DateTimeZone($aDates['timezone']));
		$oResult = new stdClass();
		$oResult->date = $oDate->format('Y-m-d');
		$oResult->time = $oDate->format('H:i:s');
		return $oResult;
	}

	public function initDate($sTZ) {
		$oDate = new DateTime('now', new DateTimeZone($sTZ));
		$oResult = new stdClass();
		$oResult->date = $oDate->format('Y-m-d');
		$oResult->time = $oDate->format('H:i:s');
		return $oResult;
	}

	public function timeZone() {
		return Session::getSession()->getUser()->getTimezone();
	}

	public function updateTimeZone($sTZ) {
		Session::getSession()->getUser()->setTimezone($sTZ);
		Session::getSession()->getUser()->save();
	}
}