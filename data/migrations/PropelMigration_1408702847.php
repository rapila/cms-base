<?php

/**
* Data object containing the SQL and PHP code to migrate the database
* up to version 1408702847.
* Generated on 2014-08-22 12:20:47 by jmg
*/


class PropelMigration_1408702847
{

	public function preUp($manager)
	{
		require_once $_SERVER['PWD'].'/base/lib/inc.php';
		$iSort = 0;
		$sPrevContainer = null;
		$iPrevPageId = null;
		foreach(ContentObjectQuery::create()->orderByPageId()->orderByContainerName()->orderBySort()->find() as $oContentObject) {
			if($oContentObject->getContainerName() !== $sPrevContainer || $oContentObject->getPageId() !== $iPrevPageId) {
				$iSort = 0;
			}
			$oContentObject->setSort($iSort++);
			$oContentObject->save();
			$sPrevContainer = $oContentObject->getContainerName();
			$iPrevPageId = $oContentObject->getPageId();
		}
	}

	public function postUp($manager)
	{
	}

	public function preDown($manager)
	{
			// add the pre-migration code here
	}

	public function postDown($manager)
	{
			// add the post-migration code here
	}

	/**
	 * Get the SQL statements for the Up migration
	 *
	 * @return array list of the SQL strings to execute for the Up migration
	 *							 the keys being the datasources
	 */
	public function getUpSQL()
	{
			return array (
'rapila' => '
	SET FOREIGN_KEY_CHECKS = 0;
	SET FOREIGN_KEY_CHECKS = 1;
',
);
	}

	/**
	 * Get the SQL statements for the Down migration
	 *
	 * @return array list of the SQL strings to execute for the Down migration
	 *							 the keys being the datasources
	 */
	public function getDownSQL()
	{
			return array (
'rapila' => '
	SET FOREIGN_KEY_CHECKS = 0;
	SET FOREIGN_KEY_CHECKS = 1;
',
);
	}

}