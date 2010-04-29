#Migration script
#Usage: add new changes to the bottom. always use "#svn rREV" as comment before the statement(s)

#svn r1000
DELETE FROM `languages` WHERE `id` = "";
ALTER TABLE `languages` ADD `sort` TINYINT(1)  NOT NULL AFTER `is_active`;

#svn r1045
ALTER TABLE `users` CHANGE `password` `password` VARCHAR(144) NULL DEFAULT NULL;

#svn r1115
ALTER TABLE `page_strings` ADD `keywords` VARCHAR(255)  NOT NULL AFTER `long_title`;
UPDATE `strings` SET `string_key` = "meta.description" WHERE `string_key` = "meta_description";
UPDATE `strings` SET `string_key` = "meta.keywords" WHERE `string_key` = "meta_keywords";

#svn r1169
ALTER TABLE `pages` ADD `page_type` VARCHAR(15) NOT NULL AFTER `is_hidden`;

#svn r1267
ALTER TABLE `objects` ADD `sort` TINYINT(3) NULL AFTER `object_type`;

#svn r1330
ALTER TABLE `documents` ADD `is_protected` TINYINT(1) NOT NULL default 0 AFTER `is_inactive`;

#svn r1389
ALTER TABLE `objects` ADD `condition_serialized` BLOB NULL DEFAULT NULL AFTER `object_type` ;

#svn r1557
DROP TABLE IF EXISTS `language_object_history`;
CREATE TABLE IF NOT EXISTS `language_object_history` (
  `object_id` int(10) unsigned NOT NULL,
  `language_id` varchar(3) collate utf8_unicode_ci NOT NULL,
  `data` longblob,
  `revision` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`object_id`,`language_id`,`revision`),
  KEY `language_object_history_FI_2` (`language_id`),
  KEY `language_object_history_FI_3` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#svn r1624
ALTER TABLE `rights` CHANGE `user_id` `group_id` INT( 11 ) NOT NULL ;

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80),
	`created_by` INTEGER  NOT NULL,
	`updated_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `groups_U_1` (`name`),
	INDEX `groups_FI_1` (`created_by`),
	CONSTRAINT `groups_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`),
	INDEX `groups_FI_2` (`updated_by`),
	CONSTRAINT `groups_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups`
(
	`user_id` INTEGER  NOT NULL,
	`group_id` INTEGER  NOT NULL,
	PRIMARY KEY (`user_id`,`group_id`),
	CONSTRAINT `users_groups_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `users_groups_FI_2` (`group_id`),
	CONSTRAINT `users_groups_FK_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`)
)Type=MyISAM;

#svn r1625
ALTER TABLE `rights` ADD `may_view_page` TINYINT( 1 ) NOT NULL ;
ALTER TABLE `users` ADD `is_backend_login_enabled` TINYINT( 1 ) NOT NULL DEFAULT '1' AFTER `is_admin` ;

#svn r1628
ALTER TABLE `pages` ADD `is_protected` TINYINT( 1 ) NOT NULL AFTER `is_hidden` ;

#svn r1679
ALTER TABLE `users` ADD `password_recover_hint` VARCHAR( 15 ) NULL DEFAULT NULL AFTER `is_inactive` ;

#svn r1708
DROP TABLE IF EXISTS `indirect_references`;
CREATE TABLE `indirect_references`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`from_id` VARCHAR(20)  NOT NULL,
	`from_model_name` VARCHAR(80)  NOT NULL,
	`to_id` VARCHAR(20)  NOT NULL,
	`to_model_name` VARCHAR(80)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `indirect_references_U_1` (`from_id`, `from_model_name`, `to_id`, `to_model_name`)
)Type=MyISAM;

#svn r1817
ALTER TABLE `documents` CHANGE `document_category_id` `document_category_id` INT( 11 ) NULL DEFAULT NULL;

#svn r1938
ALTER TABLE `document_categories` ADD `is_externally_managed` TINYINT( 1 ) UNSIGNED NOT NULL AFTER `max_width`;

#svn r2019
UPDATE `documents` SET `document_category_id` = NULL WHERE `document_category_id` = 0;

#svn r2079
ALTER TABLE `users` ADD `backend_settings` TEXT NULL DEFAULT NULL AFTER `password_recover_hint`;

#svn r2294
ALTER TABLE `users` ADD `digest_ha1` VARCHAR(32) NULL DEFAULT NULL AFTER `password_recover_hint`;

#svn r2335
ALTER TABLE `documents` CHANGE `created_by` `created_by` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `documents` CHANGE `updated_by` `updated_by` INT( 11 ) NULL DEFAULT NULL;

ALTER TABLE `document_categories` ADD `created_at` DATETIME;
ALTER TABLE `document_categories` ADD `updated_at` DATETIME;
ALTER TABLE `document_categories` ADD `created_by` INTEGER;
ALTER TABLE `document_categories` ADD `updated_by` INTEGER;

ALTER TABLE `document_types` ADD `created_at` DATETIME;
ALTER TABLE `document_types` ADD `updated_at` DATETIME;
ALTER TABLE `document_types` ADD `created_by` INTEGER;
ALTER TABLE `document_types` ADD `updated_by` INTEGER;

ALTER TABLE `groups` CHANGE `created_by` `created_by` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `groups` CHANGE `updated_by` `updated_by` INT( 11 ) NULL DEFAULT NULL;

ALTER TABLE `indirect_references` ADD `created_at` DATETIME;
ALTER TABLE `indirect_references` ADD `updated_at` DATETIME;
ALTER TABLE `indirect_references` ADD `created_by` INTEGER;
ALTER TABLE `indirect_references` ADD `updated_by` INTEGER;

ALTER TABLE `languages` ADD `created_at` DATETIME;
ALTER TABLE `languages` ADD `updated_at` DATETIME;
ALTER TABLE `languages` ADD `created_by` INTEGER;
ALTER TABLE `languages` ADD `updated_by` INTEGER;

ALTER TABLE `language_objects` CHANGE `created_by` `created_by` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `language_objects` CHANGE `updated_by` `updated_by` INT( 11 ) NULL DEFAULT NULL;

ALTER TABLE `language_object_history` CHANGE `created_by` `created_by` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `language_object_history` ADD `updated_at` DATETIME;
ALTER TABLE `language_object_history` ADD `updated_by` INTEGER;

ALTER TABLE `links` CHANGE `created_by` `created_by` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `links` CHANGE `updated_by` `updated_by` INT( 11 ) NULL DEFAULT NULL;

ALTER TABLE `objects` ADD `created_at` DATETIME;
ALTER TABLE `objects` ADD `updated_at` DATETIME;
ALTER TABLE `objects` ADD `created_by` INTEGER;
ALTER TABLE `objects` ADD `updated_by` INTEGER;

ALTER TABLE `pages` CHANGE `created_by` `created_by` INT( 11 ) NULL DEFAULT NULL;
ALTER TABLE `pages` CHANGE `updated_by` `updated_by` INT( 11 ) NULL DEFAULT NULL;

ALTER TABLE `page_properties` ADD `created_at` DATETIME;
ALTER TABLE `page_properties` ADD `updated_at` DATETIME;
ALTER TABLE `page_properties` ADD `created_by` INTEGER;
ALTER TABLE `page_properties` ADD `updated_by` INTEGER;

ALTER TABLE `page_strings` ADD `created_at` DATETIME;
ALTER TABLE `page_strings` ADD `updated_at` DATETIME;
ALTER TABLE `page_strings` ADD `created_by` INTEGER;
ALTER TABLE `page_strings` ADD `updated_by` INTEGER;

ALTER TABLE `rights` ADD `created_at` DATETIME;
ALTER TABLE `rights` ADD `updated_at` DATETIME;
ALTER TABLE `rights` ADD `created_by` INTEGER;
ALTER TABLE `rights` ADD `updated_by` INTEGER;

ALTER TABLE `strings` ADD `created_at` DATETIME;
ALTER TABLE `strings` ADD `updated_at` DATETIME;
ALTER TABLE `strings` ADD `created_by` INTEGER;
ALTER TABLE `strings` ADD `updated_by` INTEGER;

ALTER TABLE `tags` ADD `created_at` DATETIME;
ALTER TABLE `tags` ADD `updated_at` DATETIME;
ALTER TABLE `tags` ADD `created_by` INTEGER;
ALTER TABLE `tags` ADD `updated_by` INTEGER;

ALTER TABLE `tag_instances` ADD `created_at` DATETIME;
ALTER TABLE `tag_instances` ADD `updated_at` DATETIME;
ALTER TABLE `tag_instances` ADD `updated_by` INTEGER;

ALTER TABLE `users_groups` ADD `created_at` DATETIME;
ALTER TABLE `users_groups` ADD `updated_at` DATETIME;
ALTER TABLE `users_groups` ADD `created_by` INTEGER;
ALTER TABLE `users_groups` ADD `updated_by` INTEGER;
