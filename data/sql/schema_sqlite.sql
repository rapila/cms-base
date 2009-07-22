
-----------------------------------------------------------------------------
-- pages
-----------------------------------------------------------------------------

DROP TABLE [pages];


CREATE TABLE [pages]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[parent_id] INTEGER,
	[sort] INTEGER,
	[name] VARCHAR(50),
	[page_type] VARCHAR(15),
	[template_name] VARCHAR(50),
	[is_inactive] INTEGER(1) default 1,
	[is_folder] INTEGER(1) default 0,
	[is_hidden] INTEGER(1) default 0,
	[is_protected] INTEGER(1) default 0,
	[created_by] INTEGER  NOT NULL,
	[updated_by] INTEGER  NOT NULL,
	[created_at] TIMESTAMP,
	[updated_at] TIMESTAMP,
	UNIQUE ([parent_id],[name])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([parent_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- page_properties
-----------------------------------------------------------------------------

DROP TABLE [page_properties];


CREATE TABLE [page_properties]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[page_id] INTEGER  NOT NULL,
	[name] VARCHAR(50)  NOT NULL,
	[value] VARCHAR(255)  NOT NULL,
	UNIQUE ([name],[page_id])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-----------------------------------------------------------------------------
-- page_strings
-----------------------------------------------------------------------------

DROP TABLE [page_strings];


CREATE TABLE [page_strings]
(
	[page_id] INTEGER  NOT NULL,
	[language_id] VARCHAR(3)  NOT NULL,
	[title] VARCHAR(50) default '',
	[long_title] VARCHAR(255)  NOT NULL,
	[keywords] VARCHAR(255)
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-----------------------------------------------------------------------------
-- objects
-----------------------------------------------------------------------------

DROP TABLE [objects];


CREATE TABLE [objects]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[page_id] INTEGER  NOT NULL,
	[container_name] VARCHAR(50),
	[object_type] VARCHAR(50),
	[condition_serialized] LONGBLOB,
	[sort] TINYINT(2)
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-----------------------------------------------------------------------------
-- language_objects
-----------------------------------------------------------------------------

DROP TABLE [language_objects];


CREATE TABLE [language_objects]
(
	[object_id] INTEGER  NOT NULL,
	[language_id] VARCHAR(3)  NOT NULL,
	[data] LONGBLOB,
	[created_by] INTEGER  NOT NULL,
	[updated_by] INTEGER  NOT NULL,
	[created_at] TIMESTAMP,
	[updated_at] TIMESTAMP
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([object_id]) REFERENCES objects ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- language_object_history
-----------------------------------------------------------------------------

DROP TABLE [language_object_history];


CREATE TABLE [language_object_history]
(
	[object_id] INTEGER  NOT NULL,
	[language_id] VARCHAR(3)  NOT NULL,
	[data] LONGBLOB,
	[revision] INTEGER  NOT NULL,
	[created_by] INTEGER  NOT NULL,
	[created_at] TIMESTAMP
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([object_id]) REFERENCES objects ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- languages
-----------------------------------------------------------------------------

DROP TABLE [languages];


CREATE TABLE [languages]
(
	[id] VARCHAR(3)  NOT NULL,
	[is_active] INTEGER(1),
	[sort] TINYINT(2)
);

-----------------------------------------------------------------------------
-- strings
-----------------------------------------------------------------------------

DROP TABLE [strings];


CREATE TABLE [strings]
(
	[language_id] VARCHAR(3)  NOT NULL,
	[string_key] VARCHAR(80)  NOT NULL,
	[text] MEDIUMTEXT
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-----------------------------------------------------------------------------
-- users
-----------------------------------------------------------------------------

DROP TABLE [users];


CREATE TABLE [users]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[username] VARCHAR(40)  NOT NULL,
	[password] VARCHAR(144),
	[first_name] VARCHAR(40),
	[last_name] VARCHAR(60),
	[email] VARCHAR(80),
	[language_id] VARCHAR(3),
	[is_admin] INTEGER(1) default 0,
	[is_backend_login_enabled] INTEGER(1) default 1,
	[is_inactive] INTEGER(1) default 0,
	[password_recover_hint] VARCHAR(10),
	[backend_settings] MEDIUMTEXT,
	[created_by] INTEGER,
	[updated_by] INTEGER,
	[created_at] TIMESTAMP,
	[updated_at] TIMESTAMP,
	UNIQUE ([username])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- groups
-----------------------------------------------------------------------------

DROP TABLE [groups];


CREATE TABLE [groups]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(80),
	[created_by] INTEGER  NOT NULL,
	[updated_by] INTEGER  NOT NULL,
	[created_at] TIMESTAMP,
	[updated_at] TIMESTAMP,
	UNIQUE ([name])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- users_groups
-----------------------------------------------------------------------------

DROP TABLE [users_groups];


CREATE TABLE [users_groups]
(
	[user_id] INTEGER  NOT NULL,
	[group_id] INTEGER  NOT NULL
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([user_id]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([group_id]) REFERENCES groups ([id])

-----------------------------------------------------------------------------
-- rights
-----------------------------------------------------------------------------

DROP TABLE [rights];


CREATE TABLE [rights]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[group_id] INTEGER  NOT NULL,
	[page_id] INTEGER  NOT NULL,
	[is_inherited] INTEGER(1) default 1,
	[may_edit_page_details] INTEGER(1) default 0,
	[may_edit_page_contents] INTEGER(1) default 0,
	[may_delete] INTEGER(1) default 0,
	[may_create_children] INTEGER(1) default 0,
	[may_view_page] INTEGER(1) default 0,
	UNIQUE ([group_id],[page_id],[is_inherited])
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([group_id]) REFERENCES groups ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([page_id]) REFERENCES pages ([id])

-----------------------------------------------------------------------------
-- documents
-----------------------------------------------------------------------------

DROP TABLE [documents];


CREATE TABLE [documents]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(100),
	[description] VARCHAR(255),
	[language_id] VARCHAR(3),
	[owner_id] INTEGER  NOT NULL,
	[document_type_id] INTEGER  NOT NULL,
	[document_category_id] INTEGER default null,
	[is_private] INTEGER(1) default 0,
	[is_inactive] INTEGER(1) default 0,
	[is_protected] INTEGER(1) default 0,
	[data] LONGBLOB,
	[created_by] INTEGER  NOT NULL,
	[updated_by] INTEGER  NOT NULL,
	[created_at] TIMESTAMP,
	[updated_at] TIMESTAMP
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
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- document_types
-----------------------------------------------------------------------------

DROP TABLE [document_types];


CREATE TABLE [document_types]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[extension] VARCHAR(6)  NOT NULL,
	[mimetype] VARCHAR(80)  NOT NULL,
	[is_office_doc] INTEGER(1) default 0
);

-----------------------------------------------------------------------------
-- document_categories
-----------------------------------------------------------------------------

DROP TABLE [document_categories];


CREATE TABLE [document_categories]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(80)  NOT NULL,
	[sort] INTEGER,
	[max_width] INTEGER,
	[is_externally_managed] INTEGER(1) default 0,
	[is_inactive] INTEGER(1) default 0
);

-----------------------------------------------------------------------------
-- tags
-----------------------------------------------------------------------------

DROP TABLE [tags];


CREATE TABLE [tags]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(80)  NOT NULL,
	UNIQUE ([name])
);

-----------------------------------------------------------------------------
-- tag_instances
-----------------------------------------------------------------------------

DROP TABLE [tag_instances];


CREATE TABLE [tag_instances]
(
	[tag_id] INTEGER  NOT NULL,
	[tagged_item_id] INTEGER  NOT NULL,
	[model_name] VARCHAR(80)  NOT NULL,
	[created_by] INTEGER default null
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([tag_id]) REFERENCES tags ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- links
-----------------------------------------------------------------------------

DROP TABLE [links];


CREATE TABLE [links]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[name] VARCHAR(100),
	[url] VARCHAR(255),
	[description] VARCHAR(255),
	[language_id] VARCHAR(3),
	[owner_id] INTEGER  NOT NULL,
	[document_category_id] INTEGER  NOT NULL,
	[is_private] INTEGER(1) default 0,
	[is_inactive] INTEGER(1) default 0,
	[created_by] INTEGER  NOT NULL,
	[created_at] TIMESTAMP,
	[updated_by] INTEGER  NOT NULL,
	[updated_at] TIMESTAMP
);

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([language_id]) REFERENCES languages ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([owner_id]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([document_category_id]) REFERENCES document_categories ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([created_by]) REFERENCES users ([id])

-- SQLite does not support foreign keys; this is just for reference
-- FOREIGN KEY ([updated_by]) REFERENCES users ([id])

-----------------------------------------------------------------------------
-- indirect_references
-----------------------------------------------------------------------------

DROP TABLE [indirect_references];


CREATE TABLE [indirect_references]
(
	[id] INTEGER  NOT NULL PRIMARY KEY,
	[from_id] VARCHAR(20)  NOT NULL,
	[from_model_name] VARCHAR(80)  NOT NULL,
	[to_id] VARCHAR(20)  NOT NULL,
	[to_model_name] VARCHAR(80)  NOT NULL,
	UNIQUE ([from_id],[from_model_name],[to_id],[to_model_name])
);
