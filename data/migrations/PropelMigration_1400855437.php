<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1400855437.
 * Generated on 2014-05-23 16:30:37 by tg
 */
class PropelMigration_1400855437
{

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
        require_once $_SERVER['PWD'].'/base/lib/inc.php';

        $oConnection = Propel::getConnection(DocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);

        Propel::disableInstancePooling();
        $stmt = DocumentPeer::doSelectStmt(DocumentQuery::create()->clearSelectColumns()->addSelectColumn('documents.id')->addSelectColumn('documents.hash'));
        foreach($stmt->fetchAll(PDO::FETCH_NUM) as $row) {
            $iId = $row[0];
            $sHash = $row[1];
            $oConnection->exec('INSERT IGNORE INTO `document_data` (`hash`, `data`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES ("'.$sHash.'", (SELECT `data` FROM `documents` WHERE `id` = '.$iId.'), (SELECT `created_at` FROM `documents` WHERE `id` = '.$iId.'), (SELECT `updated_at` FROM `documents` WHERE `id` = '.$iId.'), (SELECT `created_by` FROM `documents` WHERE `id` = '.$iId.'), (SELECT `updated_by` FROM `documents` WHERE `id` = '.$iId.'))');
        }
        $stmt->closeCursor();
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

DROP INDEX `documents_FI_5` ON `documents`;

DROP INDEX `documents_FI_6` ON `documents`;

ALTER TABLE `documents`
    ADD `hash` VARCHAR(40) AFTER `data`;

UPDATE `documents` SET `hash` = SHA1(`data`) WHERE 1;

CREATE INDEX `documents_FI_5` ON `documents` (`hash`);

CREATE INDEX `documents_FI_6` ON `documents` (`created_by`);

CREATE INDEX `documents_FI_7` ON `documents` (`updated_by`);

CREATE TABLE `document_data`
(
    `hash` VARCHAR(40) NOT NULL,
    `data` LONGBLOB,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`hash`),
    INDEX `document_data_FI_1` (`created_by`),
    INDEX `document_data_FI_2` (`updated_by`)
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

DROP TABLE IF EXISTS `document_data`;

DROP INDEX `documents_FI_7` ON `documents`;

DROP INDEX `documents_FI_5` ON `documents`;

DROP INDEX `documents_FI_6` ON `documents`;

ALTER TABLE `documents` DROP `hash`;

CREATE INDEX `documents_FI_5` ON `documents` (`created_by`);

CREATE INDEX `documents_FI_6` ON `documents` (`updated_by`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}