<?php



/**
 * Skeleton subclass for representing a row from the 'scheduled_actions' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.model
 */
class ScheduledAction extends BaseScheduledAction {
	const ACTION_METHOD_PREFIX = 'executeAction';
	
	/**
	* Returns the object affected by the action
	*/
	public function getObject() {
		$sModel = $this->getModelName();
		$sId = $this->getModelId();
		$sQueryClass = "{$sModel}Query";
		$sPKString = $this->getModelId();
		return $sQueryClass::create()->filterByPKString($sId)->findOne();
	}
	
	/**
	* Returns the user instance whose permissions should be used when executing this action.
	* Currently this is the same as the user who created the action.
	*/
	public function getExecutionUser() {
		return $this->getUserRelatedByCreatedBy();
	}
	
	public function getExecutionDateFormatted($sLanguageId = null, $sFormatString = '%x %H:%M') {
		return LocaleUtil::localizeDate($this->getExecutionDate(null), $sLanguageId, $sFormatString);
	}
	
	public function getScheduleDateFormatted($sLanguageId = null, $sFormatString = '%x %H:%M') {
		return LocaleUtil::localizeDate($this->getScheduleDate(null), $sLanguageId, $sFormatString);
	}

	public function getActionDescriptor() {
		return ActionDescriptor::fromAction($this->getModelName(), $this->getAction());
	}

	public function getActionName() {
		return $this->getActionDescriptor()->getName();
	}
	
	public function getCreatedUserName() {
		return $this->getUserRelatedByCreatedBy()->getFullName();
	}

	public function getParameters() {
		$aParams = $this->getParams();
		if($aParams !== null) {
			if(is_resource($aParams)) {
				$aParams = stream_get_contents($aParams);
			}
			$aParams = json_decode($aParams);
		}
		if(!is_array($aParams)) {
			$aParams = array();
		}

		return $aParams;
	}

	public function getParameterCount() {
		return count($this->getParameters());
	}
	
	/**
	* Tries to execute the specified action.
	* Throws exceptions for invalid actions.
	* Does not check schedule_date nor execution_date, and updates neither of the two.
	*/
	public function execute() {
		$sModel = $this->getModelName();
		$oObject = $this->getObject();

		if($oObject === null) {
			throw new Exception("No valid object for action");
		}

		$sAction = StringUtil::camelize($this->getAction(), true);

		$sMethodName = self::ACTION_METHOD_PREFIX.$sAction;
		if(!method_exists($oObject, $sMethodName)) {
			throw new Exception("Action $sAction is not valid for $sModel");
		}

		$aParams = $this->getParameters();
		array_unshift($aParams, $this);

		$oUser = $this->getExecutionUser();

		$sPeerClass = "{$sModel}Peer";

		$sPeerClass::setRightsUser($oUser);
		$oObject->$sMethodName(...$aParams);
		$sPeerClass::setRightsUser();
	}
	
	/**
	* Processes this action. Always assumes the due date is reached, but checks for prior execution.
	* Does not throw exceptions but prints them.
	* Executes it, then either marks the execution as successful by adding a timestamp or deletes the action if it’s redundant (or points to an invalid object).
	*/
	public function process() {
		if($this->getExecutionDate() !== null) {
			// Do nothing
			return;
		}
		ScheduledActionPeer::setRightsUser($this->getExecutionUser());
		$aResult = true;
		try {
			$this->execute();
			$oCurrentDate = new DateTime(null, new DateTimeZone('UTC'));
			$this->setExecutionDate($oCurrentDate);
			$this->save();
		} catch(Exception $ex) {
			ErrorHandler::handleException($ex, true);
			// FIXME: Maybe we should add the exception to a field in the DB and not delete the action.
			$this->delete();
			$aResult = false;
		}
		ScheduledActionPeer::setRightsUser(null);
		return $aResult;
	}
}
