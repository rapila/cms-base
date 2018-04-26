<?php


/**
 * @package    propel.generator.model
 */
class GroupQuery extends BaseGroupQuery {
	public function createOrFindByName($sGroupName) {
		$oGroup = $this->filterByName($sGroupName)->findOne();
		if($oGroup === null) {
			$oGroup = new Group();
			$oGroup->setName($sGroupName);
			$oGroup->save();
		}
		return $oGroup;
	}
}
