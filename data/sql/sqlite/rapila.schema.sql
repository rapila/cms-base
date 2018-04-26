
-----------------------------------------------------------------------
-- pages
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [pages];

CREATE TABLE [pages]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(50) NOT NULL,
    [identifier] VARCHAR(50),
    [page_type] VARCHAR(50),
    [template_name] VARCHAR(50),
    [is_inactive] INTEGER(1) DEFAULT 1,
    [is_folder] INTEGER(1) DEFAULT 0,
    [is_hidden] INTEGER(1) DEFAULT 0,
    [is_protected] INTEGER(1) DEFAULT 0,
    [canonical_id] INTEGER,
    [tree_left] INTEGER,
    [tree_right] INTEGER,
    [tree_level] INTEGER,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([identifier])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([canonical_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- page_properties
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [page_properties];

CREATE TABLE [page_properties]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [page_id] INTEGER NOT NULL,
    [name] VARCHAR(50) NOT NULL,
    [value] VARCHAR(255) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([name],[page_id])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- page_strings
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [page_strings];

CREATE TABLE [page_strings]
(
    [page_id] INTEGER NOT NULL,
    [language_id] VARCHAR(3) NOT NULL,
    [is_inactive] INTEGER(1) DEFAULT 1,
    [link_text] VARCHAR(50) DEFAULT '',
    [page_title] VARCHAR(255) NOT NULL,
    [meta_keywords] VARCHAR(255),
    [meta_description] VARCHAR(255),
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([page_id],[language_id])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- objects
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [objects];

CREATE TABLE [objects]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [page_id] INTEGER NOT NULL,
    [container_name] VARCHAR(50),
    [object_type] VARCHAR(50),
    [condition_serialized] LONGBLOB,
    [sort] TINYINT(3),
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- language_objects
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [language_objects];

CREATE TABLE [language_objects]
(
    [object_id] INTEGER NOT NULL,
    [language_id] VARCHAR(3) NOT NULL,
    [data] LONGBLOB,
    [has_draft] INTEGER(1) DEFAULT 0,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([object_id],[language_id])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([object_id]) REFERENCES objects ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- language_object_history
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [language_object_history];

CREATE TABLE [language_object_history]
(
    [object_id] INTEGER NOT NULL,
    [language_id] VARCHAR(3) NOT NULL,
    [data] LONGBLOB,
    [revision] INTEGER NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([object_id],[language_id],[revision])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([object_id]) REFERENCES objects ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- languages
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [languages];

CREATE TABLE [languages]
(
    [id] VARCHAR(5) NOT NULL,
    [path_prefix] VARCHAR(20) NOT NULL,
    [is_active] INTEGER(1),
    [sort] TINYINT(2),
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([id]),
    UNIQUE ([path_prefix])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- strings
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [strings];

CREATE TABLE [strings]
(
    [language_id] VARCHAR(3) NOT NULL,
    [string_key] VARCHAR(80) NOT NULL,
    [text] MEDIUMTEXT,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([language_id],[string_key])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- users
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [users];

CREATE TABLE [users]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [username] VARCHAR(40) NOT NULL,
    [password] VARCHAR(144),
    [digest_ha1] VARCHAR(32),
    [first_name] VARCHAR(40),
    [last_name] VARCHAR(60),
    [email] VARCHAR(80),
    [language_id] VARCHAR(3),
    [timezone] VARCHAR(32),
    [is_admin] INTEGER(1) DEFAULT 0,
    [is_backend_login_enabled] INTEGER(1) DEFAULT 1,
    [is_admin_login_enabled] INTEGER(1) DEFAULT 1,
    [is_inactive] INTEGER(1) DEFAULT 0,
    [password_recover_hint] VARCHAR(10),
    [backend_settings] LONGBLOB,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([username])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-----------------------------------------------------------------------
-- users_groups
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [users_groups];

CREATE TABLE [users_groups]
(
    [user_id] INTEGER NOT NULL,
    [group_id] INTEGER NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([user_id],[group_id])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([user_id]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([group_id]) REFERENCES groups ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- groups
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [groups];

CREATE TABLE [groups]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(80),
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([name])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- group_roles
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [group_roles];

CREATE TABLE [group_roles]
(
    [group_id] INTEGER NOT NULL,
    [role_key] VARCHAR(50) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([group_id],[role_key])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([group_id]) REFERENCES groups ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([role_key]) REFERENCES roles ([role_key])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- roles
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [roles];

CREATE TABLE [roles]
(
    [role_key] VARCHAR(50) NOT NULL,
    [description] VARCHAR(255),
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([role_key])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- user_roles
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [user_roles];

CREATE TABLE [user_roles]
(
    [user_id] INTEGER NOT NULL,
    [role_key] VARCHAR(50) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([user_id],[role_key])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([user_id]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([role_key]) REFERENCES roles ([role_key])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- rights
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [rights];

CREATE TABLE [rights]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [role_key] VARCHAR(50) NOT NULL,
    [page_id] INTEGER NOT NULL,
    [is_inherited] INTEGER(1) DEFAULT 1,
    [may_edit_page_details] INTEGER(1) DEFAULT 0,
    [may_edit_page_contents] INTEGER(1) DEFAULT 0,
    [may_delete] INTEGER(1) DEFAULT 0,
    [may_create_children] INTEGER(1) DEFAULT 0,
    [may_view_page] INTEGER(1) DEFAULT 0,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([role_key],[page_id],[is_inherited])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([role_key]) REFERENCES roles ([role_key])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- documents
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [documents];

CREATE TABLE [documents]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(100),
    [original_name] VARCHAR(100),
    [description] VARCHAR(255),
    [content_created_at] DATETIME,
    [license] VARCHAR(30),
    [author] VARCHAR(150),
    [language_id] VARCHAR(3),
    [owner_id] INTEGER,
    [document_type_id] INTEGER NOT NULL,
    [document_category_id] INTEGER,
    [is_private] INTEGER(1) DEFAULT 0,
    [is_protected] INTEGER(1) DEFAULT 0,
    [sort] INTEGER,
    [hash] VARCHAR(40) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([owner_id]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([document_type_id]) REFERENCES document_types ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([document_category_id]) REFERENCES document_categories ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([hash]) REFERENCES document_data ([hash])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- document_data
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [document_data];

CREATE TABLE [document_data]
(
    [hash] VARCHAR(40) NOT NULL,
    [data] LONGBLOB,
    [data_size] INTEGER,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([hash])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- document_types
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [document_types];

CREATE TABLE [document_types]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [extension] VARCHAR(6) NOT NULL,
    [mimetype] VARCHAR(80) NOT NULL,
    [is_office_doc] INTEGER(1) DEFAULT 0,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([extension],[mimetype])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- document_categories
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [document_categories];

CREATE TABLE [document_categories]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(80) NOT NULL,
    [sort] INTEGER,
    [max_width] INTEGER,
    [is_externally_managed] INTEGER(1) DEFAULT 0,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- tags
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [tags];

CREATE TABLE [tags]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(80) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([name])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- tag_instances
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [tag_instances];

CREATE TABLE [tag_instances]
(
    [tag_id] INTEGER NOT NULL,
    [tagged_item_id] INTEGER NOT NULL,
    [model_name] VARCHAR(80) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    PRIMARY KEY ([tag_id],[tagged_item_id],[model_name])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([tag_id]) REFERENCES tags ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- links
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [links];

CREATE TABLE [links]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(100),
    [url] VARCHAR(255),
    [description] VARCHAR(255),
    [language_id] VARCHAR(3),
    [owner_id] INTEGER NOT NULL,
    [link_category_id] INTEGER,
    [sort] INTEGER,
    [is_private] INTEGER(1) DEFAULT 0,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([owner_id]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([link_category_id]) REFERENCES link_categories ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- link_categories
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [link_categories];

CREATE TABLE [link_categories]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [name] VARCHAR(80) NOT NULL,
    [is_externally_managed] INTEGER(1) DEFAULT 0,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------
-- indirect_references
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [indirect_references];

CREATE TABLE [indirect_references]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [from_id] VARCHAR(20) NOT NULL,
    [from_model_name] VARCHAR(80) NOT NULL,
    [to_id] VARCHAR(20) NOT NULL,
    [to_model_name] VARCHAR(80) NOT NULL,
    [created_at] TIMESTAMP,
    [updated_at] TIMESTAMP,
    [created_by] INTEGER,
    [updated_by] INTEGER,
    UNIQUE ([from_id],[from_model_name],[to_id],[to_model_name])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])
