<?php



/**
 * This class defines the structure of the 'links' table.
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
class LinkTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'model.map.LinkTableMap';

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
        $this->setName('links');
        $this->setPhpName('Link');
        $this->setClassname('Link');
        $this->setPackage('model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 100, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addForeignKey('language_id', 'LanguageId', 'VARCHAR', 'languages', 'id', false, 3, null);
        $this->addForeignKey('owner_id', 'OwnerId', 'INTEGER', 'users', 'id', true, null, null);
        $this->addForeignKey('link_category_id', 'LinkCategoryId', 'INTEGER', 'link_categories', 'id', false, null, null);
        $this->addColumn('sort', 'Sort', 'INTEGER', false, null, null);
        $this->addColumn('is_private', 'IsPrivate', 'BOOLEAN', false, 1, false);
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
        $this->addRelation('Language', 'Language', RelationMap::MANY_TO_ONE, array('language_id' => 'id', ), null, null);
        $this->addRelation('UserRelatedByOwnerId', 'User', RelationMap::MANY_TO_ONE, array('owner_id' => 'id', ), null, null);
        $this->addRelation('LinkCategory', 'LinkCategory', RelationMap::MANY_TO_ONE, array('link_category_id' => 'id', ), 'SET NULL', null);
        $this->addRelation('UserRelatedByCreatedBy', 'User', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('UserRelatedByUpdatedBy', 'User', RelationMap::MANY_TO_ONE, array('updated_by' => 'id', ), 'SET NULL', null);
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
            'referenceable' =>  array (
),
            'taggable' =>  array (
  'tag_model' => 'Tag',
  'tag_instance_model' => '',
),
            'denyable' =>  array (
  'mode' => 'by_role',
  'role_key' => '',
  'owner_allowed' => 'true',
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

} // LinkTableMap
