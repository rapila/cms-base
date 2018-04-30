<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1525074231.
 * Generated on 2014-10-02 23:42:08 by rafi
 */
class PropelMigration_1525074231
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

CREATE TABLE `scheduled_actions`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `model_id` VARCHAR(20) NOT NULL,
    `model_name` VARCHAR(80) NOT NULL,
    `schedule_date` DATETIME NOT NULL,
    `execution_date` DATETIME,
    `action` VARCHAR(80) NOT NULL,
    `params` LONGBLOB,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `scheduled_actions_FI_1` (`created_by`),
    INDEX `scheduled_actions_FI_2` (`updated_by`)
) ENGINE=MyISAM;

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

DROP TABLE IF EXISTS `scheduled_actions`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}