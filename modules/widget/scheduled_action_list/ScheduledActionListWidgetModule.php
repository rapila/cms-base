<?php
class ScheduledActionListWidgetModule extends SpecializedListWidgetModule {
	private $oCriteriaListWidgetDelegate;

	private $sModelName;
	private $sModelId;

	protected function createListWidget() {
		$oListWidget = new ListWidgetModule();
		$this->oCriteriaListWidgetDelegate = new CriteriaListWidgetDelegate($this, 'ScheduledAction');
		$oListWidget->setDelegate($this->oCriteriaListWidgetDelegate);
		return $oListWidget;
	}

	public function getColumnIdentifiers() {
		return array('id', 'action', 'parameters', 'schedule_date', 'execution_date', 'created_by', 'delete');
	}

	public function getCriteria() {
		$oQuery = ScheduledActionQuery::create()->orderByScheduleDate(Criteria::DESC);
		if($this->sModelName) {
			$oQuery->filterByModelName($this->sModelName);
		}
		if($this->sModelId) {
			$oQuery->filterByModelId($this->sModelId);
		}
		return $oQuery;
	}

	public function setModelName($sModelName) {
		$this->sModelName = $sModelName;
	}

	public function setModelId($sModelId) {
		$this->sModelId = $sModelId;
	}

	public function deleteRow($aRowData, $oCriteria) {
		$oScheduledAction = ScheduledActionQuery::create()->findPk($aRowData['id']);
		if($oScheduledAction) return $oScheduledAction->delete();
	}

	public function getDatabaseColumnForColumn($sColumnIdentifier) {
	}

	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case "action":
				$aResult['field_name'] = 'action_name';
				break;
			case "parameters":
				$aResult['field_name'] = 'parameter_count';
				break;
			case "schedule_date":
				$aResult['field_name'] = 'schedule_date_formatted';
				break;
			case "execution_date":
				$aResult['field_name'] = 'execution_date_formatted';
				break;
			case "created_by":
				$aResult['field_name'] = 'created_user_name';
				break;
			case "delete":
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_ICON;
				$aResult['field_name'] = 'trash';
				break;
		}
		return $aResult;
	}
}