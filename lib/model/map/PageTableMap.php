<?php



/**
 * This class defines the structure of the 'pages' table.
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
class PageTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'model.map.PageTableMap';

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
        $this->setName('pages');
        $this->setPhpName('Page');
        $this->setClassname('Page');
        $this->setPackage('model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        $this->addColumn('identifier', 'Identifier', 'VARCHAR', false, 50, null);
        $this->addColumn('page_type', 'PageType', 'VARCHAR', false, 50, null);
        $this->addColumn('template_name', 'TemplateName', 'VARCHAR', false, 50, null);
        $this->addColumn('is_inactive', 'IsInactive', 'BOOLEAN', false, 1, true);
        $this->addColumn('is_folder', 'IsFolder', 'BOOLEAN', false, 1, false);
        $this->addColumn('is_hidden', 'IsHidden', 'BOOLEAN', false, 1, false);
        $this->addColumn('is_protected', 'IsProtected', 'BOOLEAN', false, 1, false);
        $this->addForeignKey('canonical_id', 'CanonicalId', 'INTEGER', 'pages', 'id', false, null, null);
        $this->addColumn('tree_left', 'TreeLeft', 'INTEGER', false, null, null);
        $this->addColumn('tree_right', 'TreeRight', 'INTEGER', false, null, null);
        $this->addColumn('tree_level', 'TreeLevel', 'INTEGER', false, null, null);
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
        $this->addRelation('PageRelatedByCanonicalId', 'Page', RelationMap::MANY_TO_ONE, array('canonical_id' => 'id', ), 'SET NULL', null);
        $this->addRelation('UserRelatedByCreatedBy', 'User', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('UserRelatedByUpdatedBy', 'User', RelationMap::MANY_TO_ONE, array('updated_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('PageRelatedById', 'Page', RelationMap::ONE_TO_MANY, array('id' => 'canonical_id', ), 'SET NULL', null, 'PagesRelatedById');
        $this->addRelation('PageProperty', 'PageProperty', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null, 'PagePropertys');
        $this->addRelation('PageString', 'PageString', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null, 'PageStrings');
        $this->addRelation('ContentObject', 'ContentObject', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null, 'ContentObjects');
        $this->addRelation('Right', 'Right', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null, 'Rights');
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
  'mode' => 'allow',
  'role_key' => '',
  'owner_allowed' => '',
),
            'nested_set' =>  array (
  'left_column' => 'tree_left',
  'right_column' => 'tree_right',
  'level_column' => 'tree_level',
  'use_scope' => 'false',
  'scope_column' => 'tree_scope',
  'method_proxies' => 'false',
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

} // PageTableMap
