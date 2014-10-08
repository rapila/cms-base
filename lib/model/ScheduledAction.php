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
	const ACTION_METHOD_PREFIX = 'executeScheduled';
	
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

		$aParams = $this->getParams();
		if($aParams !== null) {
			$aParams = json_decode($aParams);
		}
		if(!is_array($aParams)) {
			$aParams = array();
		}

		array_unshift($aParams, $this);

		$oUser = $this->getExecutionUser();

		$sPeerClass = "{$sModel}Peer";

		$sPeerClass::setRightsUser($oUser);
		call_user_func_array(array($oObject, $sMethodName), $aParams);
		$sPeerClass::setRightsUser();
	}
	
	/**
	* Processes this action. Checks for prior execution (but not if the date matches).
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
			$this->delete();
			$aResult = false;
		}
		ScheduledActionPeer::setRightsUser(null);
		return $aResult;
	}
}
