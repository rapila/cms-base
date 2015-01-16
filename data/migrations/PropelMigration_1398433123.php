<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1398433123.
 * Generated on 2014-04-25 15:38:43 by tg
 */
class PropelMigration_1398433123
{

	public function preUp($manager)
	{
		// add the pre-migration code here
	}

	public function postUp($manager)
	{
		// add the post-migration code here
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
	 *               the keys being the datasources
	 */
	public function getUpSQL()
	{
		return array ('rapila' => '
			# This is a fix for InnoDB in MySQL >= 4.1.x
			# It "suspends judgement" for fkey relationships until are tables are set.
			SET FOREIGN_KEY_CHECKS = 0;

			ALTER TABLE `documents` CHANGE `owner_id` `owner_id` INTEGER NULL DEFAULT NULL;

			# This restores the fkey checks, after having unset them earlier
			SET FOREIGN_KEY_CHECKS = 1;
			'
		);
	}


	/**
	 * Get the SQL statements for the Down migration
	 *
	 * @return array list of the SQL strings to execute for the Down migration
	 *               the keys being the datasources
	 */
	public function getDownSQL()
	{
		return array ('rapila' => 'ALTER TABLE `documents` CHANGE `owner_id` INTEGER NOT NULL;');
	}

}