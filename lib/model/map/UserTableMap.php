<?php



/**
 * This class defines the structure of the 'users' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.model.map
 */
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'model.map.UserTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('users');
        $this->setPhpName('User');
        $this->setClassname('User');
        $this->setPackage('model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 40, null);
        $this->addColumn('password', 'Password', 'VARCHAR', false, 144, null);
        $this->addColumn('digest_ha1', 'DigestHA1', 'VARCHAR', false, 32, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', false, 40, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', false, 60, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 80, null);
        $this->addForeignKey('language_id', 'LanguageId', 'VARCHAR', 'languages', 'id', false, 3, null);
        $this->addColumn('timezone', 'Timezone', 'VARCHAR', false, 32, null);
        $this->addColumn('is_admin', 'IsAdmin', 'BOOLEAN', false, 1, false);
        $this->addColumn('is_backend_login_enabled', 'IsBackendLoginEnabled', 'BOOLEAN', false, 1, true);
        $this->addColumn('is_admin_login_enabled', 'IsAdminLoginEnabled', 'BOOLEAN', false, 1, true);
        $this->addColumn('is_inactive', 'IsInactive', 'BOOLEAN', false, 1, false);
        $this->addColumn('password_recover_hint', 'PasswordRecoverHint', 'VARCHAR', false, 10, null);
        $this->addColumn('backend_settings', 'BackendSettings', 'BLOB', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('created_by', 'CreatedBy', 'INTEGER', false, null, null);
        $this->addColumn('updated_by', 'UpdatedBy', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('LanguageRelatedByLanguageId', 'Language', RelationMap::MANY_TO_ONE, array('language_id' => 'id', ), null, null);
        $this->addRelation('UserGroupRelatedByUserId', 'UserGroup', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'CASCADE', null, 'UserGroupsRelatedByUserId');
        $this->addRelation('UserRoleRelatedByUserId', 'UserRole', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'CASCADE', null, 'UserRolesRelatedByUserId');
        $this->addRelation('DocumentRelatedByOwnerId', 'Document', RelationMap::ONE_TO_MANY, array('id' => 'owner_id', ), null, null, 'DocumentsRelatedByOwnerId');
        $this->addRelation('LinkRelatedByOwnerId', 'Link', RelationMap::ONE_TO_MANY, array('id' => 'owner_id', ), null, null, 'LinksRelatedByOwnerId');
        $this->addRelation('PageRelatedByCreatedBy', 'Page', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'PagesRelatedByCreatedBy');
        $this->addRelation('PageRelatedByUpdatedBy', 'Page', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'PagesRelatedByUpdatedBy');
        $this->addRelation('PagePropertyRelatedByCreatedBy', 'PageProperty', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'PagePropertysRelatedByCreatedBy');
        $this->addRelation('PagePropertyRelatedByUpdatedBy', 'PageProperty', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'PagePropertysRelatedByUpdatedBy');
        $this->addRelation('PageStringRelatedByCreatedBy', 'PageString', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'PageStringsRelatedByCreatedBy');
        $this->addRelation('PageStringRelatedByUpdatedBy', 'PageString', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'PageStringsRelatedByUpdatedBy');
        $this->addRelation('ContentObjectRelatedByCreatedBy', 'ContentObject', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'ContentObjectsRelatedByCreatedBy');
        $this->addRelation('ContentObjectRelatedByUpdatedBy', 'ContentObject', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'ContentObjectsRelatedByUpdatedBy');
        $this->addRelation('LanguageObjectRelatedByCreatedBy', 'LanguageObject', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'LanguageObjectsRelatedByCreatedBy');
        $this->addRelation('LanguageObjectRelatedByUpdatedBy', 'LanguageObject', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'LanguageObjectsRelatedByUpdatedBy');
        $this->addRelation('LanguageObjectHistoryRelatedByCreatedBy', 'LanguageObjectHistory', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'LanguageObjectHistorysRelatedByCreatedBy');
        $this->addRelation('LanguageObjectHistoryRelatedByUpdatedBy', 'LanguageObjectHistory', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'LanguageObjectHistorysRelatedByUpdatedBy');
        $this->addRelation('LanguageRelatedByCreatedBy', 'Language', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'LanguagesRelatedByCreatedBy');
        $this->addRelation('LanguageRelatedByUpdatedBy', 'Language', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'LanguagesRelatedByUpdatedBy');
        $this->addRelation('TranslationRelatedByCreatedBy', 'Translation', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'TranslationsRelatedByCreatedBy');
        $this->addRelation('TranslationRelatedByUpdatedBy', 'Translation', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'TranslationsRelatedByUpdatedBy');
        $this->addRelation('UserGroupRelatedByCreatedBy', 'UserGroup', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'UserGroupsRelatedByCreatedBy');
        $this->addRelation('UserGroupRelatedByUpdatedBy', 'UserGroup', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'UserGroupsRelatedByUpdatedBy');
        $this->addRelation('GroupRelatedByCreatedBy', 'Group', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'GroupsRelatedByCreatedBy');
        $this->addRelation('GroupRelatedByUpdatedBy', 'Group', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'GroupsRelatedByUpdatedBy');
        $this->addRelation('GroupRoleRelatedByCreatedBy', 'GroupRole', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'GroupRolesRelatedByCreatedBy');
        $this->addRelation('GroupRoleRelatedByUpdatedBy', 'GroupRole', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'GroupRolesRelatedByUpdatedBy');
        $this->addRelation('RoleRelatedByCreatedBy', 'Role', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'RolesRelatedByCreatedBy');
        $this->addRelation('RoleRelatedByUpdatedBy', 'Role', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'RolesRelatedByUpdatedBy');
        $this->addRelation('UserRoleRelatedByCreatedBy', 'UserRole', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'UserRolesRelatedByCreatedBy');
        $this->addRelation('UserRoleRelatedByUpdatedBy', 'UserRole', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'UserRolesRelatedByUpdatedBy');
        $this->addRelation('RightRelatedByCreatedBy', 'Right', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'RightsRelatedByCreatedBy');
        $this->addRelation('RightRelatedByUpdatedBy', 'Right', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'RightsRelatedByUpdatedBy');
        $this->addRelation('DocumentRelatedByCreatedBy', 'Document', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'DocumentsRelatedByCreatedBy');
        $this->addRelation('DocumentRelatedByUpdatedBy', 'Document', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'DocumentsRelatedByUpdatedBy');
        $this->addRelation('DocumentDataRelatedByCreatedBy', 'DocumentData', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'DocumentDatasRelatedByCreatedBy');
        $this->addRelation('DocumentDataRelatedByUpdatedBy', 'DocumentData', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'DocumentDatasRelatedByUpdatedBy');
        $this->addRelation('DocumentTypeRelatedByCreatedBy', 'DocumentType', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'DocumentTypesRelatedByCreatedBy');
        $this->addRelation('DocumentTypeRelatedByUpdatedBy', 'DocumentType', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'DocumentTypesRelatedByUpdatedBy');
        $this->addRelation('DocumentCategoryRelatedByCreatedBy', 'DocumentCategory', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'DocumentCategorysRelatedByCreatedBy');
        $this->addRelation('DocumentCategoryRelatedByUpdatedBy', 'DocumentCategory', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'DocumentCategorysRelatedByUpdatedBy');
        $this->addRelation('TagRelatedByCreatedBy', 'Tag', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'TagsRelatedByCreatedBy');
        $this->addRelation('TagRelatedByUpdatedBy', 'Tag', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'TagsRelatedByUpdatedBy');
        $this->addRelation('TagInstanceRelatedByCreatedBy', 'TagInstance', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'TagInstancesRelatedByCreatedBy');
        $this->addRelation('TagInstanceRelatedByUpdatedBy', 'TagInstance', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'TagInstancesRelatedByUpdatedBy');
        $this->addRelation('LinkRelatedByCreatedBy', 'Link', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'LinksRelatedByCreatedBy');
        $this->addRelation('LinkRelatedByUpdatedBy', 'Link', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'LinksRelatedByUpdatedBy');
        $this->addRelation('LinkCategoryRelatedByCreatedBy', 'LinkCategory', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'LinkCategorysRelatedByCreatedBy');
        $this->addRelation('LinkCategoryRelatedByUpdatedBy', 'LinkCategory', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'LinkCategorysRelatedByUpdatedBy');
        $this->addRelation('ReferenceRelatedByCreatedBy', 'Reference', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'ReferencesRelatedByCreatedBy');
        $this->addRelation('ReferenceRelatedByUpdatedBy', 'Reference', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'ReferencesRelatedByUpdatedBy');
        $this->addRelation('ScheduledActionRelatedByCreatedBy', 'ScheduledAction', RelationMap::ONE_TO_MANY, array('id' => 'created_by', ), 'SET NULL', null, 'ScheduledActionsRelatedByCreatedBy');
        $this->addRelation('ScheduledActionRelatedByUpdatedBy', 'ScheduledAction', RelationMap::ONE_TO_MANY, array('id' => 'updated_by', ), 'SET NULL', null, 'ScheduledActionsRelatedByUpdatedBy');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'taggable' =>  array (
  'tag_model' => 'Tag',
  'tag_instance_model' => '',
),
            'denyable' =>  array (
  'mode' => '',
  'role_key' => 'users',
  'owner_allowed' => 'false',
),
            'extended_timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
            'attributable' =>  array (
  'create_column' => 'created_by',
  'update_column' => 'updated_by',
),
            'extended_keyable' =>  array (
  'key_separator' => '_',
),
        );
    } // getBehaviors()

} // UserTableMap
