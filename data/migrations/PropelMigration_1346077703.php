<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1346077703.
 * Generated on 2012-08-27 16:28:23 by jmg
 */
class PropelMigration_1346077703
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
		return array (
  'rapila' => '
ALTER TABLE `pages` ADD
(
	`canonical_id` INTEGER
);
',
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
		return array (
  'rapila' => '

ALTER TABLE `pages` DROP `canonical_id`;
',
);
	}

}