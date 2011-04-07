
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
	`name` VARCHAR(50),
	`page_type` VARCHAR(15),
	`template_name` VARCHAR(50),
	`is_inactive` TINYINT(1) default 1,
	`is_folder` TINYINT(1) default 0,
	`is_hidden` TINYINT(1) default 0,
	`is_protected` TINYINT(1) default 0,
	`tree_left` INTEGER,
	`tree_right` INTEGER,
	`tree_level` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `pages_FI_1` (`created_by`),
	CONSTRAINT `pages_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `pages_FI_2` (`updated_by`),
	CONSTRAINT `pages_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

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
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `page_properties_U_1` (`name`, `page_id`),
	INDEX `page_properties_FI_1` (`page_id`),
	CONSTRAINT `page_properties_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE,
	INDEX `page_properties_FI_2` (`created_by`),
	CONSTRAINT `page_properties_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `page_properties_FI_3` (`updated_by`),
	CONSTRAINT `page_properties_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- page_strings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `page_strings`;


CREATE TABLE `page_strings`
(
	`page_id` INTEGER  NOT NULL,
	`language_id` VARCHAR(3)  NOT NULL,
	`is_inactive` TINYINT(1) default 1,
	`link_text` VARCHAR(50) default '',
	`page_title` VARCHAR(255)  NOT NULL,
	`meta_keywords` VARCHAR(255),
	`meta_description` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`page_id`,`language_id`),
	CONSTRAINT `page_strings_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE,
	INDEX `page_strings_FI_2` (`language_id`),
	CONSTRAINT `page_strings_FK_2`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `page_strings_FI_3` (`created_by`),
	CONSTRAINT `page_strings_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `page_strings_FI_4` (`updated_by`),
	CONSTRAINT `page_strings_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

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
	`sort` TINYINT(3),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `objects_FI_1` (`page_id`),
	CONSTRAINT `objects_FK_1`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE,
	INDEX `objects_FI_2` (`created_by`),
	CONSTRAINT `objects_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `objects_FI_3` (`updated_by`),
	CONSTRAINT `objects_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- language_objects
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `language_objects`;


CREATE TABLE `language_objects`
(
	`object_id` INTEGER  NOT NULL,
	`language_id` VARCHAR(3)  NOT NULL,
	`data` LONGBLOB,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
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
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `language_objects_FI_4` (`updated_by`),
	CONSTRAINT `language_objects_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

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
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
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
		ON DELETE SET NULL,
	INDEX `language_object_history_FI_4` (`updated_by`),
	CONSTRAINT `language_object_history_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- languages
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;


CREATE TABLE `languages`
(
	`id` VARCHAR(3)  NOT NULL,
	`is_active` TINYINT(1),
	`sort` TINYINT(2),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `languages_FI_1` (`created_by`),
	CONSTRAINT `languages_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `languages_FI_2` (`updated_by`),
	CONSTRAINT `languages_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- strings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `strings`;


CREATE TABLE `strings`
(
	`language_id` VARCHAR(3)  NOT NULL,
	`string_key` VARCHAR(80)  NOT NULL,
	`text` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`language_id`,`string_key`),
	CONSTRAINT `strings_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `strings_FI_2` (`created_by`),
	CONSTRAINT `strings_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `strings_FI_3` (`updated_by`),
	CONSTRAINT `strings_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- users
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;


CREATE TABLE `users`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(40)  NOT NULL,
	`password` VARCHAR(144),
	`digest_ha1` VARCHAR(32),
	`first_name` VARCHAR(40),
	`last_name` VARCHAR(60),
	`email` VARCHAR(80),
	`language_id` VARCHAR(3),
	`is_admin` TINYINT(1) default 0,
	`is_backend_login_enabled` TINYINT(1) default 1,
	`is_inactive` TINYINT(1) default 0,
	`password_recover_hint` VARCHAR(10),
	`backend_settings` LONGBLOB,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `users_U_1` (`username`),
	INDEX `users_FI_1` (`language_id`),
	CONSTRAINT `users_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`)
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- users_groups
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;


CREATE TABLE `users_groups`
(
	`user_id` INTEGER  NOT NULL,
	`group_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`user_id`,`group_id`),
	CONSTRAINT `users_groups_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `users_groups_FI_2` (`group_id`),
	CONSTRAINT `users_groups_FK_2`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`)
		ON DELETE CASCADE,
	INDEX `users_groups_FI_3` (`created_by`),
	CONSTRAINT `users_groups_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `users_groups_FI_4` (`updated_by`),
	CONSTRAINT `users_groups_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- groups
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;


CREATE TABLE `groups`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `groups_U_1` (`name`),
	INDEX `groups_FI_1` (`created_by`),
	CONSTRAINT `groups_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `groups_FI_2` (`updated_by`),
	CONSTRAINT `groups_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- group_roles
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `group_roles`;


CREATE TABLE `group_roles`
(
	`group_id` INTEGER  NOT NULL,
	`role_key` VARCHAR(50)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`group_id`,`role_key`),
	CONSTRAINT `group_roles_FK_1`
		FOREIGN KEY (`group_id`)
		REFERENCES `groups` (`id`)
		ON DELETE CASCADE,
	INDEX `group_roles_FI_2` (`role_key`),
	CONSTRAINT `group_roles_FK_2`
		FOREIGN KEY (`role_key`)
		REFERENCES `roles` (`role_key`)
		ON DELETE CASCADE,
	INDEX `group_roles_FI_3` (`created_by`),
	CONSTRAINT `group_roles_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `group_roles_FI_4` (`updated_by`),
	CONSTRAINT `group_roles_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- roles
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;


CREATE TABLE `roles`
(
	`role_key` VARCHAR(50)  NOT NULL,
	`description` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`role_key`),
	INDEX `roles_FI_1` (`created_by`),
	CONSTRAINT `roles_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `roles_FI_2` (`updated_by`),
	CONSTRAINT `roles_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- user_roles
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user_roles`;


CREATE TABLE `user_roles`
(
	`user_id` INTEGER  NOT NULL,
	`role_key` VARCHAR(50)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`user_id`,`role_key`),
	CONSTRAINT `user_roles_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `user_roles_FI_2` (`role_key`),
	CONSTRAINT `user_roles_FK_2`
		FOREIGN KEY (`role_key`)
		REFERENCES `roles` (`role_key`)
		ON DELETE CASCADE,
	INDEX `user_roles_FI_3` (`created_by`),
	CONSTRAINT `user_roles_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `user_roles_FI_4` (`updated_by`),
	CONSTRAINT `user_roles_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- rights
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `rights`;


CREATE TABLE `rights`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`role_key` VARCHAR(50)  NOT NULL,
	`page_id` INTEGER  NOT NULL,
	`is_inherited` TINYINT(1) default 1,
	`may_edit_page_details` TINYINT(1) default 0,
	`may_edit_page_contents` TINYINT(1) default 0,
	`may_delete` TINYINT(1) default 0,
	`may_create_children` TINYINT(1) default 0,
	`may_view_page` TINYINT(1) default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `rights_U_1` (`role_key`, `page_id`, `is_inherited`),
	CONSTRAINT `rights_FK_1`
		FOREIGN KEY (`role_key`)
		REFERENCES `roles` (`role_key`)
		ON DELETE CASCADE,
	INDEX `rights_FI_2` (`page_id`),
	CONSTRAINT `rights_FK_2`
		FOREIGN KEY (`page_id`)
		REFERENCES `pages` (`id`)
		ON DELETE CASCADE,
	INDEX `rights_FI_3` (`created_by`),
	CONSTRAINT `rights_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `rights_FI_4` (`updated_by`),
	CONSTRAINT `rights_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- documents
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `documents`;


CREATE TABLE `documents`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`original_name` VARCHAR(100),
	`description` VARCHAR(255),
	`language_id` VARCHAR(3),
	`owner_id` INTEGER  NOT NULL,
	`document_type_id` INTEGER  NOT NULL,
	`document_category_id` INTEGER,
	`is_private` TINYINT(1) default 0,
	`is_inactive` TINYINT(1) default 0,
	`is_protected` TINYINT(1) default 0,
	`sort` INTEGER,
	`data` LONGBLOB,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
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
		REFERENCES `document_types` (`id`)
		ON DELETE CASCADE,
	INDEX `documents_FI_4` (`document_category_id`),
	CONSTRAINT `documents_FK_4`
		FOREIGN KEY (`document_category_id`)
		REFERENCES `document_categories` (`id`)
		ON DELETE SET NULL,
	INDEX `documents_FI_5` (`created_by`),
	CONSTRAINT `documents_FK_5`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `documents_FI_6` (`updated_by`),
	CONSTRAINT `documents_FK_6`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- document_types
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `document_types`;


CREATE TABLE `document_types`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`extension` VARCHAR(6)  NOT NULL,
	`mimetype` VARCHAR(80)  NOT NULL,
	`is_office_doc` TINYINT(1) default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `document_types_U_1` (`extension`, `mimetype`),
	INDEX `document_types_FI_1` (`created_by`),
	CONSTRAINT `document_types_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `document_types_FI_2` (`updated_by`),
	CONSTRAINT `document_types_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

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
	`is_externally_managed` TINYINT(1) default 0,
	`is_inactive` TINYINT(1) default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `document_categories_FI_1` (`created_by`),
	CONSTRAINT `document_categories_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `document_categories_FI_2` (`updated_by`),
	CONSTRAINT `document_categories_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- tags
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;


CREATE TABLE `tags`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `tags_U_1` (`name`),
	INDEX `tags_FI_1` (`created_by`),
	CONSTRAINT `tags_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `tags_FI_2` (`updated_by`),
	CONSTRAINT `tags_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- tag_instances
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tag_instances`;


CREATE TABLE `tag_instances`
(
	`tag_id` INTEGER  NOT NULL,
	`tagged_item_id` INTEGER  NOT NULL,
	`model_name` VARCHAR(80)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`tag_id`,`tagged_item_id`,`model_name`),
	CONSTRAINT `tag_instances_FK_1`
		FOREIGN KEY (`tag_id`)
		REFERENCES `tags` (`id`)
		ON DELETE CASCADE,
	INDEX `tag_instances_FI_2` (`created_by`),
	CONSTRAINT `tag_instances_FK_2`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `tag_instances_FI_3` (`updated_by`),
	CONSTRAINT `tag_instances_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

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
	`link_category_id` INTEGER,
	`sort` INTEGER,
	`is_private` TINYINT(1) default 0,
	`is_inactive` TINYINT(1) default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `links_FI_1` (`language_id`),
	CONSTRAINT `links_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `links_FI_2` (`owner_id`),
	CONSTRAINT `links_FK_2`
		FOREIGN KEY (`owner_id`)
		REFERENCES `users` (`id`),
	INDEX `links_FI_3` (`link_category_id`),
	CONSTRAINT `links_FK_3`
		FOREIGN KEY (`link_category_id`)
		REFERENCES `link_categories` (`id`)
		ON DELETE SET NULL,
	INDEX `links_FI_4` (`created_by`),
	CONSTRAINT `links_FK_4`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `links_FI_5` (`updated_by`),
	CONSTRAINT `links_FK_5`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- link_categories
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `link_categories`;


CREATE TABLE `link_categories`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80)  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `link_categories_FI_1` (`created_by`),
	CONSTRAINT `link_categories_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `link_categories_FI_2` (`updated_by`),
	CONSTRAINT `link_categories_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

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
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `indirect_references_U_1` (`from_id`, `from_model_name`, `to_id`, `to_model_name`),
	INDEX `indirect_references_FI_1` (`created_by`),
	CONSTRAINT `indirect_references_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `indirect_references_FI_2` (`updated_by`),
	CONSTRAINT `indirect_references_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- newsletters
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `newsletters`;


CREATE TABLE `newsletters`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subject` VARCHAR(255)  NOT NULL,
	`newsletter_body` LONGBLOB,
	`language_id` VARCHAR(3)  NOT NULL,
	`is_approved` TINYINT default 0 NOT NULL,
	`is_html` TINYINT default 1 NOT NULL,
	`template_name` VARCHAR(60),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `newsletters_FI_1` (`created_by`),
	CONSTRAINT `newsletters_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `newsletters_FI_2` (`updated_by`),
	CONSTRAINT `newsletters_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- newsletter_mailings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `newsletter_mailings`;


CREATE TABLE `newsletter_mailings`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`date_sent` DATETIME  NOT NULL,
	`subscriber_group_id` INTEGER,
	`external_mail_group_id` VARCHAR(255),
	`newsletter_id` INTEGER  NOT NULL,
	`created_by` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `newsletter_mailings_FI_1` (`subscriber_group_id`),
	CONSTRAINT `newsletter_mailings_FK_1`
		FOREIGN KEY (`subscriber_group_id`)
		REFERENCES `subscriber_groups` (`id`),
	INDEX `newsletter_mailings_FI_2` (`newsletter_id`),
	CONSTRAINT `newsletter_mailings_FK_2`
		FOREIGN KEY (`newsletter_id`)
		REFERENCES `newsletters` (`id`)
		ON DELETE CASCADE,
	INDEX `newsletter_mailings_FI_3` (`updated_by`),
	CONSTRAINT `newsletter_mailings_FK_3`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- subscribers
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscribers`;


CREATE TABLE `subscribers`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80)  NOT NULL,
	`preferred_language_id` VARCHAR(3)  NOT NULL,
	`email` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `subscribers_U_1` (`email`),
	INDEX `subscribers_FI_1` (`created_by`),
	CONSTRAINT `subscribers_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `subscribers_FI_2` (`updated_by`),
	CONSTRAINT `subscribers_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- subscriber_group_memberships
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscriber_group_memberships`;


CREATE TABLE `subscriber_group_memberships`
(
	`subscriber_id` INTEGER  NOT NULL,
	`subscriber_group_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`subscriber_id`,`subscriber_group_id`),
	CONSTRAINT `subscriber_group_memberships_FK_1`
		FOREIGN KEY (`subscriber_id`)
		REFERENCES `subscribers` (`id`)
		ON DELETE CASCADE,
	INDEX `subscriber_group_memberships_FI_2` (`subscriber_group_id`),
	CONSTRAINT `subscriber_group_memberships_FK_2`
		FOREIGN KEY (`subscriber_group_id`)
		REFERENCES `subscriber_groups` (`id`)
		ON DELETE CASCADE,
	INDEX `subscriber_group_memberships_FI_3` (`created_by`),
	CONSTRAINT `subscriber_group_memberships_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `subscriber_group_memberships_FI_4` (`updated_by`),
	CONSTRAINT `subscriber_group_memberships_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- subscriber_groups
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subscriber_groups`;


CREATE TABLE `subscriber_groups`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(80)  NOT NULL,
	`is_default` TINYINT default 0 NOT NULL,
	`description` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `subscriber_groups_FI_1` (`created_by`),
	CONSTRAINT `subscriber_groups_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `subscriber_groups_FI_2` (`updated_by`),
	CONSTRAINT `subscriber_groups_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- tip_strings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tip_strings`;


CREATE TABLE `tip_strings`
(
	`tip_id` INTEGER  NOT NULL,
	`language_id` CHAR(3)  NOT NULL,
	`title` VARCHAR(255),
	`text` LONGBLOB,
	`is_tip_of_the_day` TINYINT default 0 NOT NULL,
	`is_active` TINYINT default 0 NOT NULL,
	`day_displayed_last` DATE,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`tip_id`,`language_id`),
	INDEX `I_referenced_comments_FK_2_1` (`language_id`,`tip_id`),
	CONSTRAINT `tip_strings_FK_1`
		FOREIGN KEY (`tip_id`)
		REFERENCES `tips` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `tip_strings_FK_2`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `tip_strings_FI_3` (`created_by`),
	CONSTRAINT `tip_strings_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `tip_strings_FI_4` (`updated_by`),
	CONSTRAINT `tip_strings_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- tips
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tips`;


CREATE TABLE `tips`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tip_category_id` TINYINT(1),
	`rating` FLOAT default 0.0 NOT NULL,
	`rating_count` INTEGER default 0 NOT NULL,
	`frontend_user_id` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `tips_FI_1` (`tip_category_id`),
	CONSTRAINT `tips_FK_1`
		FOREIGN KEY (`tip_category_id`)
		REFERENCES `tip_categories` (`id`),
	INDEX `tips_FI_2` (`frontend_user_id`),
	CONSTRAINT `tips_FK_2`
		FOREIGN KEY (`frontend_user_id`)
		REFERENCES `frontend_users` (`user_id`),
	INDEX `tips_FI_3` (`created_by`),
	CONSTRAINT `tips_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `tips_FI_4` (`updated_by`),
	CONSTRAINT `tips_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- tip_categories
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tip_categories`;


CREATE TABLE `tip_categories`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `tip_categories_FI_1` (`created_by`),
	CONSTRAINT `tip_categories_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `tip_categories_FI_2` (`updated_by`),
	CONSTRAINT `tip_categories_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- frontend_users
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `frontend_users`;


CREATE TABLE `frontend_users`
(
	`user_id` INTEGER  NOT NULL,
	`gender` CHAR(1),
	`year_of_birth` INTEGER(4),
	`in_lottery` TINYINT default 1 NOT NULL,
	`age_group_id` TINYINT(1)   COMMENT 'persistent value',
	`preferred_language_id` CHAR(3),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`user_id`),
	CONSTRAINT `frontend_users_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`id`)
		ON DELETE CASCADE,
	INDEX `frontend_users_FI_2` (`age_group_id`),
	CONSTRAINT `frontend_users_FK_2`
		FOREIGN KEY (`age_group_id`)
		REFERENCES `games` (`id`),
	INDEX `frontend_users_FI_3` (`preferred_language_id`),
	CONSTRAINT `frontend_users_FK_3`
		FOREIGN KEY (`preferred_language_id`)
		REFERENCES `languages` (`id`),
	INDEX `frontend_users_FI_4` (`created_by`),
	CONSTRAINT `frontend_users_FK_4`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `frontend_users_FI_5` (`updated_by`),
	CONSTRAINT `frontend_users_FK_5`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- scores
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `scores`;


CREATE TABLE `scores`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`value` INTEGER  NOT NULL,
	`frontend_user_id` INTEGER  NOT NULL,
	`episode_id` INTEGER  NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `scores_FI_1` (`frontend_user_id`),
	CONSTRAINT `scores_FK_1`
		FOREIGN KEY (`frontend_user_id`)
		REFERENCES `frontend_users` (`user_id`)
		ON DELETE CASCADE,
	INDEX `scores_FI_2` (`episode_id`),
	CONSTRAINT `scores_FK_2`
		FOREIGN KEY (`episode_id`)
		REFERENCES `episodes` (`id`)
		ON DELETE CASCADE,
	INDEX `scores_FI_3` (`created_by`),
	CONSTRAINT `scores_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `scores_FI_4` (`updated_by`),
	CONSTRAINT `scores_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- games
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `games`;


CREATE TABLE `games`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`age_start` TINYINT,
	`age_end` TINYINT,
	`is_in_lottery` TINYINT default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `games_FI_1` (`created_by`),
	CONSTRAINT `games_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `games_FI_2` (`updated_by`),
	CONSTRAINT `games_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- episodes
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `episodes`;


CREATE TABLE `episodes`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`episode_number` TINYINT  NOT NULL,
	`episode_type_id` TINYINT  NOT NULL,
	`name` VARCHAR(255)   COMMENT 'file_name',
	`game_id` INTEGER  NOT NULL,
	`is_active` TINYINT default 1 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	UNIQUE KEY `episodes_U_1` (`episode_number`, `game_id`),
	INDEX `episodes_FI_1` (`episode_type_id`),
	CONSTRAINT `episodes_FK_1`
		FOREIGN KEY (`episode_type_id`)
		REFERENCES `episode_types` (`id`),
	INDEX `episodes_FI_2` (`game_id`),
	CONSTRAINT `episodes_FK_2`
		FOREIGN KEY (`game_id`)
		REFERENCES `games` (`id`)
		ON DELETE CASCADE,
	INDEX `episodes_FI_3` (`created_by`),
	CONSTRAINT `episodes_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `episodes_FI_4` (`updated_by`),
	CONSTRAINT `episodes_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- episode_types
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `episode_types`;


CREATE TABLE `episode_types`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(40)  NOT NULL,
	`has_score_list` TINYINT default 1 NOT NULL,
	`is_pro_forma` TINYINT default 0 NOT NULL,
	`is_text` TINYINT default 0 NOT NULL,
	`per_language_files` TINYINT default 0 NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `episode_types_FI_1` (`created_by`),
	CONSTRAINT `episode_types_FK_1`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `episode_types_FI_2` (`updated_by`),
	CONSTRAINT `episode_types_FK_2`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

#-----------------------------------------------------------------------------
#-- comments
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;


CREATE TABLE `comments`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`text` TEXT,
	`language_id` CHAR(3)  NOT NULL,
	`tip_id` INTEGER,
	`page_id` INTEGER,
	`is_approved` TINYINT default 0 NOT NULL,
	`approval_hint` VARCHAR(10),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`created_by` INTEGER,
	`updated_by` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `comments_FI_1` (`language_id`),
	CONSTRAINT `comments_FK_1`
		FOREIGN KEY (`language_id`)
		REFERENCES `languages` (`id`),
	INDEX `comments_FI_2` (`language_id`,`tip_id`),
	CONSTRAINT `comments_FK_2`
		FOREIGN KEY (`language_id`,`tip_id`)
		REFERENCES `tip_strings` (`language_id`,`tip_id`),
	INDEX `comments_FI_3` (`created_by`),
	CONSTRAINT `comments_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL,
	INDEX `comments_FI_4` (`updated_by`),
	CONSTRAINT `comments_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `users` (`id`)
		ON DELETE SET NULL
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
