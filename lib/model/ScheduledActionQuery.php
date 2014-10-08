<?php



/**
 * Skeleton subclass for performing query and update operations on the 'scheduled_actions' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.model
 */
class ScheduledActionQuery extends BaseScheduledActionQuery {
	/**
	* Includes all overdue actions in the query.
	*/
	public function filterByOverdue() {
		$oCurrentDate = new DateTime(null, new DateTimeZone('UTC'));
		$this->scheduled()->filterByScheduleDate(array('max' => $oCurrentDate))->orderByScheduleDate(Criteria::ASC);
		return $this;
	}
	
	public function scheduled() {
		return $this->filterByExecutionDate(null, Criteria::ISNULL);
	}
	
	public function done() {
		return $this->filterByExecutionDate(null, Criteria::ISNOTNULL);
	}
	
	/**
	* Lists all the actions a given model is capable of.
	* The result is a hash of action names as keys and values of the following form:
	* ->string, ->params[(->name, ->optional, ->default, ->type), …]
	*/
	public static function listActions($sModelName) {
		$aResult = array();
		foreach(get_class_methods($sModelName) as $sMethodName) {
			if(!StringUtil::startsWith($sMethodName, ScheduledAction::ACTION_METHOD_PREFIX)) {
				continue;
			}
			$oReflect = new ReflectionMethod($sModelName, $sMethodName);

			$sActionName = substr($sMethodName, strlen(ScheduledAction::ACTION_METHOD_PREFIX));
			$sActionName = StringUtil::deCamelize($sActionName);
			$sActionString = StringPeer::getString('wns.action.'.StringUtil::deCamelize($sModelName).'.'.$sActionName, null, $sActionName);

			$aParams = array();
			foreach($oReflect->getParameters() as $iCount => $oParameter) {
				if($iCount === 0) {
					// First param is always the action itself
					continue;
				}
				$sName = $oParameter->getName();
				$sPrefix = substr($sName, 0, 1);
				$sName = substr($sName, 1);
				$sName = StringPeer::getString('wns.action.'.StringUtil::deCamelize($sModelName).'.'.$sActionName.'.'.StringUtil::deCamelize($sName), null, $sName);
				$mDefault = null;
				$sType = null;
				$bIsOptional = false;
				if($oParameter->isDefaultValueAvailable()) {
					$mDefault = $oParameter->getDefaultValue();
					$bIsOptional = true;
					$sType = gettype($mDefault);
				} else {
					if($sPrefix === 'b') {
						$sType = 'boolean';
					}
					if($sPrefix === 'i') {
						$sType = 'integer';
					}
					if($sPrefix === 'f') {
						$sType = 'double';
					}
					if($sPrefix === 's') {
						$sType = 'string';
					}
				}
				$oParam = new stdClass();
				$oParam->name = $sName;
				$oParam->optional = $bIsOptional;
				$oParam->default = $mDefault;
				$oParam->type = $sType;
				$aParams[] = $oParam;
			}

			$oAction = new stdClass();
			$oAction->string = $sActionString;
			$oAction->params = $aParams;
			$aResult[$sActionName] = $oAction;
		}
		return $aResult;
	}
}
