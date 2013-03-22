<?php



/**
 * This class defines the structure of the 'roles' table.
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
class RoleTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'model.map.RoleTableMap';

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
        $this->setName('roles');
        $this->setPhpName('Role');
        $this->setClassname('Role');
        $this->setPackage('model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('ROLE_KEY', 'RoleKey', 'VARCHAR', true, 50, null);
        $this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addForeignKey('CREATED_BY', 'CreatedBy', 'INTEGER', 'users', 'ID', false, null, null);
        $this->addForeignKey('UPDATED_BY', 'UpdatedBy', 'INTEGER', 'users', 'ID', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserRelatedByCreatedBy', 'User', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('UserRelatedByUpdatedBy', 'User', RelationMap::MANY_TO_ONE, array('updated_by' => 'id', ), 'SET NULL', null);
        $this->addRelation('GroupRole', 'GroupRole', RelationMap::ONE_TO_MANY, array('role_key' => 'role_key', ), 'CASCADE', null, 'GroupRoles');
        $this->addRelation('UserRole', 'UserRole', RelationMap::ONE_TO_MANY, array('role_key' => 'role_key', ), 'CASCADE', null, 'UserRoles');
        $this->addRelation('Right', 'Right', RelationMap::ONE_TO_MANY, array('role_key' => 'role_key', ), 'CASCADE', null, 'Rights');
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
            'denyable' => array('mode' => '', 'role_key' => 'users', 'owner_allowed' => '', ),
            'extended_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_updated_at' => 'false', ),
            'attributable' => array('create_column' => 'created_by', 'update_column' => 'updated_by', ),
            'extended_keyable' => array('key_separator' => '_', ),
        );
    } // getBehaviors()

} // RoleTableMap
