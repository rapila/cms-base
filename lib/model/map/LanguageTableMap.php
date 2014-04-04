<?php



/**
 * This class defines the structure of the 'languages' table.
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
class LanguageTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'model.map.LanguageTableMap';

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
        $this->setName('languages');
        $this->setPhpName('Language');
        $this->setClassname('Language');
        $this->setPackage('model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'VARCHAR', true, 5, null);
        $this->addColumn('path_prefix', 'PathPrefix', 'VARCHAR', true, 20, null);
        $this->addColumn('is_active', 'IsActive', 'BOOLEAN', false, 1, null);
        $this->addColumn('sort', 'Sort', 'TINYINT', false, 2, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('created_by', 'CreatedBy', 'INTEGER', 'users', 'id', false, null, null);
        $this->addForeignKey('updated_by', 'UpdatedBy', 'INTEGER', 'users', 'id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRelatedByCreatedBy', 'User', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('UserRelatedByUpdatedBy', 'User', RelationMap::MANY_TO_ONE, array('updated_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('PageString', 'PageString', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), 'CASCADE', null, 'PageStrings');
        $this->addRelation('LanguageObject', 'LanguageObject', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), 'CASCADE', null, 'LanguageObjects');
        $this->addRelation('LanguageObjectHistory', 'LanguageObjectHistory', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), null, null, 'LanguageObjectHistorys');
        $this->addRelation('String', 'String', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), null, null, 'Strings');
        $this->addRelation('UserRelatedByLanguageId', 'User', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), null, null, 'UsersRelatedByLanguageId');
        $this->addRelation('Document', 'Document', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), null, null, 'Documents');
        $this->addRelation('Link', 'Link', RelationMap::ONE_TO_MANY, array('id' => 'language_id', ), null, null, 'Links');
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
            'denyable' =>  array (
  'mode' => 'by_role',
  'role_key' => '',
  'owner_allowed' => '',
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

} // LanguageTableMap
