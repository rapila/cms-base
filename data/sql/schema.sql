
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- pages
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;


CREATE TABLE `pages`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`parent_id` INTEGER,
	`sort` INTEGER,
	`name` VARCHAR(50),
	`page_type` VARCHAR(15),
	`template_name` VARCHAR(50),
	`is_inactive` INTEGER(1) default 1,
	`is_folder` INTEGER(1) default 0,
	`is_hidden` INTEGER(1) default 0,
	`is_protected` INTEGER(1) default 0,
	`created_by` INTEGER  NOT NULL,
	`updated_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pages_U_1` (`parent_id`, `name`),
	CONSTRAINT `pages_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `pages` (`id`)
		ON DELETE RESTRICT,
	INDEX `pages_FI_2` (`created_by`),
	CONSTRAINT `pages_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`),
	INDEX `pages_FI_3` (`updated_by`),
	CONSTRAINT `pages_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- page_properties
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `page_properties`;


CREATE TABLE `page_properties`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`page_id` INTEGER  NOT NULL,
	`name` VARCHAR(50)  NOT NULL,
	`value` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `page_properties_U_1` (`name`, `page_id`),
	INDEX `page_properties_FI_1` (`page_id`),
	CONSTRAINT `page_properties_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- page_strings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `page_strings`;


CREATE TABLE `page_strings`
(
	`page_id` INTEGER  NOT NULL,
	`language_id` VARCHAR(3)  NOT NULL,
	`title` VARCHAR(50) default '',
	`long_title` VARCHAR(255)  NOT NULL,
	`keywords` VARCHAR(255),
	PRIMARY KEY (`page_id`,`language_id`),
	CONSTRAINT `page_strings_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE,
	INDEX `page_strings_FI_2` (`language_id`),
	CONSTRAINT `page_strings_FK_2`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- objects
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `objects`;


CREATE TABLE `objects`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`page_id` INTEGER  NOT NULL,
	`container_name` VARCHAR(50),
	`object_type` VARCHAR(50),
	`condition_serialized` LONGBLOB,
	`sort` TINYINT(2),
	PRIMARY KEY (`id`),
	INDEX `objects_FI_1` (`page_id`),
	CONSTRAINT `objects_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- language_objects
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `language_objects`;


CREATE TABLE `language_objects`
(
	`object_id` INTEGER  NOT NULL,
	`language_id` VARCHAR(3)  NOT NULL,
	`data` LONGBLOB,
	`created_by` INTEGER  NOT NULL,
	`updated_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`object_id`,`language_id`),
	CONSTRAINT `language_objects_FK_1`
		FOREIGN KEY (`object_id`)
		REFERENCES `objects` (`id`)
		ON DELETE CASCADE,
	INDEX `language_objects_FI_2` (`language_id`),
	CONSTRAINT `language_objects_FK_2`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `language_objects_FI_3` (`created_by`),
	CONSTRAINT `language_objects_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`),
	INDEX `language_objects_FI_4` (`updated_by`),
	CONSTRAINT `language_objects_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- language_object_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `language_object_history`;


CREATE TABLE `language_object_history`
(
	`object_id` INTEGER  NOT NULL,
	`language_id` VARCHAR(3)  NOT NULL,
	`data` LONGBLOB,
	`revision` INTEGER  NOT NULL,
	`created_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	PRIMARY KEY (`object_id`,`language_id`,`revision`),
	CONSTRAINT `language_object_history_FK_1`
		FOREIGN KEY (`object_id`)
		REFERENCES `objects` (`id`)
		ON DELETE CASCADE,
	INDEX `language_object_history_FI_2` (`language_id`),
	CONSTRAINT `language_object_history_FK_2`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `language_object_history_FI_3` (`created_by`),
	CONSTRAINT `language_object_history_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- languages
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;


CREATE TABLE `languages`
(
	`id` VARCHAR(3)  NOT NULL,
	`is_active` INTEGER(1),
	`sort` TINYINT(2),
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- strings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `strings`;


CREATE TABLE `strings`
(
	`language_id` VARCHAR(3)  NOT NULL,
	`string_key` VARCHAR(80)  NOT NULL,
	`text` TEXT,
	PRIMARY KEY (`language_id`,`string_key`),
	CONSTRAINT `strings_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- users
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;


CREATE TABLE `users`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(40)  NOT NULL,
	`password` VARCHAR(144),
	`first_name` VARCHAR(40),
	`last_name` VARCHAR(60),
	`email` VARCHAR(80),
	`language_id` VARCHAR(3),
	`is_admin` INTEGER(1) default 0,
	`is_backend_login_enabled` INTEGER(1) default 1,
	`is_inactive` INTEGER(1) default 0,
	`password_recover_hint` VARCHAR(10),
	`created_by` INTEGER,
	`updated_by` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	UNIQUE KEY `users_U_1` (`username`),
	INDEX `users_FI_1` (`language_id`),
	CONSTRAINT `users_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `users_FI_2` (`created_by`),
	CONSTRAINT `users_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`),
	INDEX `users_FI_3` (`updated_by`),
	CONSTRAINT `users_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- groups
#-----------------------------------------------------------------------------

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

#-----------------------------------------------------------------------------
#-- users_groups
#-----------------------------------------------------------------------------

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
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- rights
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `rights`;


CREATE TABLE `rights`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`group_id` INTEGER  NOT NULL,
	`page_id` INTEGER  NOT NULL,
	`is_inherited` INTEGER(1) default 1,
	`may_edit_page_details` INTEGER(1) default 0,
	`may_edit_page_contents` INTEGER(1) default 0,
	`may_delete` INTEGER(1) default 0,
	`may_create_children` INTEGER(1) default 0,
	`may_view_page` INTEGER(1) default 0,
	PRIMARY KEY (`id`),
	UNIQUE KEY `rights_U_1` (`group_id`, `page_id`, `is_inherited`),
	CONSTRAINT `rights_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`)
		ON DELETE CASCADE,
	INDEX `rights_FI_2` (`page_id`),
	CONSTRAINT `rights_FK_2`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- documents
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `documents`;


CREATE TABLE `documents`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`description` VARCHAR(255),
	`language_id` VARCHAR(3),
	`owner_id` INTEGER  NOT NULL,
	`document_type_id` INTEGER  NOT NULL,
	`document_category_id` INTEGER default null,
	`is_private` INTEGER(1) default 0,
	`is_inactive` INTEGER(1) default 0,
	`is_protected` INTEGER(1) default 0,
	`data` LONGBLOB,
	`created_by` INTEGER  NOT NULL,
	`updated_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `documents_FI_1` (`language_id`),
	CONSTRAINT `documents_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `documents_FI_2` (`owner_id`),
	CONSTRAINT `documents_FK_2`
		FOREIGN KEY (`owner_id`)
		REFERENCES `users` (`id`),
	INDEX `documents_FI_3` (`document_type_id`),
	CONSTRAINT `documents_FK_3`
		FOREIGN KEY (`document_type_id`)
		REFERENCES `document_types` (`id`),
	INDEX `documents_FI_4` (`document_category_id`),
	CONSTRAINT `documents_FK_4`
		FOREIGN KEY (`document_category_id`)
		REFERENCES `document_categories` (`id`),
	INDEX `documents_FI_5` (`created_by`),
	CONSTRAINT `documents_FK_5`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`),
	INDEX `documents_FI_6` (`updated_by`),
	CONSTRAINT `documents_FK_6`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- document_types
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `document_types`;


CREATE TABLE `document_types`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`extension` VARCHAR(6)  NOT NULL,
	`mimetype` VARCHAR(80)  NOT NULL,
	`is_office_doc` INTEGER(1) default 0,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- document_categories
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `document_categories`;


CREATE TABLE `document_categories`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80)  NOT NULL,
	`sort` INTEGER,
	`max_width` INTEGER,
	`is_externally_managed` INTEGER(1) default 0,
	`is_inactive` INTEGER(1) default 0,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- tags
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;


CREATE TABLE `tags`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80)  NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `tags_U_1` (`name`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- tag_instances
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tag_instances`;


CREATE TABLE `tag_instances`
(
	`tag_id` INTEGER  NOT NULL,
	`tagged_item_id` INTEGER  NOT NULL,
	`model_name` VARCHAR(80)  NOT NULL,
	`created_by` INTEGER default null,
	PRIMARY KEY (`tag_id`,`tagged_item_id`,`model_name`),
	CONSTRAINT `tag_instances_FK_1`
		FOREIGN KEY (`tag_id`)
		REFERENCES `tags` (`id`)
		ON DELETE CASCADE,
	INDEX `tag_instances_FI_2` (`created_by`),
	CONSTRAINT `tag_instances_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- links
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `links`;


CREATE TABLE `links`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`url` VARCHAR(255),
	`description` VARCHAR(255),
	`language_id` VARCHAR(3),
	`owner_id` INTEGER  NOT NULL,
	`document_category_id` INTEGER  NOT NULL,
	`is_private` INTEGER(1) default 0,
	`is_inactive` INTEGER(1) default 0,
	`created_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_by` INTEGER  NOT NULL,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `links_FI_1` (`language_id`),
	CONSTRAINT `links_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `links_FI_2` (`owner_id`),
	CONSTRAINT `links_FK_2`
		FOREIGN KEY (`owner_id`)
		REFERENCES `users` (`id`),
	INDEX `links_FI_3` (`document_category_id`),
	CONSTRAINT `links_FK_3`
		FOREIGN KEY (`document_category_id`)
		REFERENCES `document_categories` (`id`),
	INDEX `links_FI_4` (`created_by`),
	CONSTRAINT `links_FK_4`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`),
	INDEX `links_FI_5` (`updated_by`),
	CONSTRAINT `links_FK_5`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- indirect_references
#-----------------------------------------------------------------------------

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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
