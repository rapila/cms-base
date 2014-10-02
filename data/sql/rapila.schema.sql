
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- pages
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `identifier` VARCHAR(50),
    `page_type` VARCHAR(15),
    `template_name` VARCHAR(50),
    `is_inactive` TINYINT(1) DEFAULT 1,
    `is_folder` TINYINT(1) DEFAULT 0,
    `is_hidden` TINYINT(1) DEFAULT 0,
    `is_protected` TINYINT(1) DEFAULT 0,
    `canonical_id` INTEGER,
    `tree_left` INTEGER,
    `tree_right` INTEGER,
    `tree_level` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `pages_U_1` (`identifier`),
    INDEX `pages_FI_1` (`canonical_id`),
    INDEX `pages_FI_2` (`created_by`),
    INDEX `pages_FI_3` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- page_properties
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `page_properties`;

CREATE TABLE `page_properties`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `page_id` INTEGER NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `page_properties_U_1` (`name`, `page_id`),
    INDEX `page_properties_FI_1` (`page_id`),
    INDEX `page_properties_FI_2` (`created_by`),
    INDEX `page_properties_FI_3` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- page_strings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `page_strings`;

CREATE TABLE `page_strings`
(
    `page_id` INTEGER NOT NULL,
    `language_id` VARCHAR(3) NOT NULL,
    `is_inactive` TINYINT(1) DEFAULT 1,
    `link_text` VARCHAR(50) DEFAULT '',
    `page_title` VARCHAR(255) NOT NULL,
    `meta_keywords` VARCHAR(255),
    `meta_description` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`page_id`,`language_id`),
    INDEX `page_strings_FI_2` (`language_id`),
    INDEX `page_strings_FI_3` (`created_by`),
    INDEX `page_strings_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- objects
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `objects`;

CREATE TABLE `objects`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `page_id` INTEGER NOT NULL,
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
    INDEX `objects_FI_2` (`created_by`),
    INDEX `objects_FI_3` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- language_objects
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `language_objects`;

CREATE TABLE `language_objects`
(
    `object_id` INTEGER NOT NULL,
    `language_id` VARCHAR(3) NOT NULL,
    `data` LONGBLOB,
    `has_draft` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`object_id`,`language_id`),
    INDEX `language_objects_FI_2` (`language_id`),
    INDEX `language_objects_FI_3` (`created_by`),
    INDEX `language_objects_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- language_object_history
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `language_object_history`;

CREATE TABLE `language_object_history`
(
    `object_id` INTEGER NOT NULL,
    `language_id` VARCHAR(3) NOT NULL,
    `data` LONGBLOB,
    `revision` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`object_id`,`language_id`,`revision`),
    INDEX `language_object_history_FI_2` (`language_id`),
    INDEX `language_object_history_FI_3` (`created_by`),
    INDEX `language_object_history_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- languages
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages`
(
    `id` VARCHAR(5) NOT NULL,
    `path_prefix` VARCHAR(20) NOT NULL,
    `is_active` TINYINT(1),
    `sort` TINYINT(2),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `languages_U_1` (`path_prefix`),
    INDEX `languages_FI_1` (`created_by`),
    INDEX `languages_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- strings
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `strings`;

CREATE TABLE `strings`
(
    `language_id` VARCHAR(3) NOT NULL,
    `string_key` VARCHAR(80) NOT NULL,
    `text` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`language_id`,`string_key`),
    INDEX `strings_FI_2` (`created_by`),
    INDEX `strings_FI_3` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(40) NOT NULL,
    `password` VARCHAR(144),
    `digest_ha1` VARCHAR(32),
    `first_name` VARCHAR(40),
    `last_name` VARCHAR(60),
    `email` VARCHAR(80),
    `language_id` VARCHAR(3),
    `timezone` VARCHAR(32),
    `is_admin` TINYINT(1) DEFAULT 0,
    `is_backend_login_enabled` TINYINT(1) DEFAULT 1,
    `is_admin_login_enabled` TINYINT(1) DEFAULT 1,
    `is_inactive` TINYINT(1) DEFAULT 0,
    `password_recover_hint` VARCHAR(10),
    `backend_settings` LONGBLOB,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `users_U_1` (`username`),
    INDEX `users_FI_1` (`language_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- users_groups
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups`
(
    `user_id` INTEGER NOT NULL,
    `group_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`user_id`,`group_id`),
    INDEX `users_groups_FI_2` (`group_id`),
    INDEX `users_groups_FI_3` (`created_by`),
    INDEX `users_groups_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- groups
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `groups_U_1` (`name`),
    INDEX `groups_FI_1` (`created_by`),
    INDEX `groups_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- group_roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `group_roles`;

CREATE TABLE `group_roles`
(
    `group_id` INTEGER NOT NULL,
    `role_key` VARCHAR(50) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`group_id`,`role_key`),
    INDEX `group_roles_FI_2` (`role_key`),
    INDEX `group_roles_FI_3` (`created_by`),
    INDEX `group_roles_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles`
(
    `role_key` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`role_key`),
    INDEX `roles_FI_1` (`created_by`),
    INDEX `roles_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_roles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles`
(
    `user_id` INTEGER NOT NULL,
    `role_key` VARCHAR(50) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`user_id`,`role_key`),
    INDEX `user_roles_FI_2` (`role_key`),
    INDEX `user_roles_FI_3` (`created_by`),
    INDEX `user_roles_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- rights
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `rights`;

CREATE TABLE `rights`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `role_key` VARCHAR(50) NOT NULL,
    `page_id` INTEGER NOT NULL,
    `is_inherited` TINYINT(1) DEFAULT 1,
    `may_edit_page_details` TINYINT(1) DEFAULT 0,
    `may_edit_page_contents` TINYINT(1) DEFAULT 0,
    `may_delete` TINYINT(1) DEFAULT 0,
    `may_create_children` TINYINT(1) DEFAULT 0,
    `may_view_page` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `rights_U_1` (`role_key`, `page_id`, `is_inherited`),
    INDEX `rights_FI_2` (`page_id`),
    INDEX `rights_FI_3` (`created_by`),
    INDEX `rights_FI_4` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- documents
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100),
    `original_name` VARCHAR(100),
    `description` VARCHAR(255),
    `content_created_at` DATE,
    `license` VARCHAR(30),
    `author` VARCHAR(150),
    `language_id` VARCHAR(3),
    `owner_id` INTEGER,
    `document_type_id` INTEGER NOT NULL,
    `document_category_id` INTEGER,
    `is_private` TINYINT(1) DEFAULT 0,
    `is_protected` TINYINT(1) DEFAULT 0,
    `sort` INTEGER,
    `hash` VARCHAR(40) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `documents_FI_1` (`language_id`),
    INDEX `documents_FI_2` (`owner_id`),
    INDEX `documents_FI_3` (`document_type_id`),
    INDEX `documents_FI_4` (`document_category_id`),
    INDEX `documents_FI_5` (`hash`),
    INDEX `documents_FI_6` (`created_by`),
    INDEX `documents_FI_7` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- document_data
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `document_data`;

CREATE TABLE `document_data`
(
    `hash` VARCHAR(40) NOT NULL,
    `data` LONGBLOB,
    `data_size` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`hash`),
    INDEX `document_data_FI_1` (`created_by`),
    INDEX `document_data_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- document_types
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `document_types`;

CREATE TABLE `document_types`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `extension` VARCHAR(6) NOT NULL,
    `mimetype` VARCHAR(80) NOT NULL,
    `is_office_doc` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `document_types_U_1` (`extension`, `mimetype`),
    INDEX `document_types_FI_1` (`created_by`),
    INDEX `document_types_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- document_categories
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `document_categories`;

CREATE TABLE `document_categories`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) NOT NULL,
    `sort` INTEGER,
    `max_width` INTEGER,
    `is_externally_managed` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `document_categories_FI_1` (`created_by`),
    INDEX `document_categories_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- tags
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `tags_U_1` (`name`),
    INDEX `tags_FI_1` (`created_by`),
    INDEX `tags_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- tag_instances
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tag_instances`;

CREATE TABLE `tag_instances`
(
    `tag_id` INTEGER NOT NULL,
    `tagged_item_id` INTEGER NOT NULL,
    `model_name` VARCHAR(80) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`tag_id`,`tagged_item_id`,`model_name`),
    INDEX `tag_instances_FI_2` (`created_by`),
    INDEX `tag_instances_FI_3` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- links
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100),
    `url` VARCHAR(255),
    `description` VARCHAR(255),
    `language_id` VARCHAR(3),
    `owner_id` INTEGER NOT NULL,
    `link_category_id` INTEGER,
    `sort` INTEGER,
    `is_private` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `links_FI_1` (`language_id`),
    INDEX `links_FI_2` (`owner_id`),
    INDEX `links_FI_3` (`link_category_id`),
    INDEX `links_FI_4` (`created_by`),
    INDEX `links_FI_5` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- link_categories
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `link_categories`;

CREATE TABLE `link_categories`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(80) NOT NULL,
    `is_externally_managed` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `link_categories_FI_1` (`created_by`),
    INDEX `link_categories_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- indirect_references
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `indirect_references`;

CREATE TABLE `indirect_references`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `from_id` VARCHAR(20) NOT NULL,
    `from_model_name` VARCHAR(80) NOT NULL,
    `to_id` VARCHAR(20) NOT NULL,
    `to_model_name` VARCHAR(80) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `created_by` INTEGER,
    `updated_by` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `indirect_references_U_1` (`from_id`, `from_model_name`, `to_id`, `to_model_name`),
    INDEX `indirect_references_FI_1` (`created_by`),
    INDEX `indirect_references_FI_2` (`updated_by`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- scheduled_actions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `scheduled_actions`;

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
