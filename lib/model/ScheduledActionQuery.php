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
		$oCurrentDate = new DateTime(null);
		$this->scheduled()->filterByScheduleDate(array('max' => $oCurrentDate->format('U')))->orderByScheduleDate(Criteria::ASC);
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
			$sActionName = substr($sMethodName, strlen(ScheduledAction::ACTION_METHOD_PREFIX));
			$sActionName = StringUtil::deCamelize($sActionName);

			$oActionDescription = ActionDescription::fromAction($sModelName, $sActionName);

			$aResult[$sActionName] = $oActionDescription->toJson();
		}
		return $aResult;
	}
}
