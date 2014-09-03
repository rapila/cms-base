<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1409746497.
 * Generated on 2014-09-03 14:14:57 by jmg
 */
class PropelMigration_1409746497
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
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `document_categories` DROP `is_inactive`;

ALTER TABLE `documents` DROP `is_inactive`;

ALTER TABLE `links` DROP `is_inactive`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
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
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `document_categories`
    ADD `is_inactive` TINYINT(1) DEFAULT 0 AFTER `is_externally_managed`;

ALTER TABLE `documents`
    ADD `is_inactive` TINYINT(1) DEFAULT 0 AFTER `is_private`;

ALTER TABLE `links`
    ADD `is_inactive` TINYINT(1) DEFAULT 0 AFTER `is_private`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}