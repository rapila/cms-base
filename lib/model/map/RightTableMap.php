<?php


/**
 * This class defines the structure of the 'rights' table.
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
class RightTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.RightTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('rights');
		$this->setPhpName('Right');
		$this->setClassname('Right');
		$this->setPackage('model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('GROUP_ID', 'GroupId', 'INTEGER', 'groups', 'ID', true, null, null);
		$this->addForeignKey('PAGE_ID', 'PageId', 'INTEGER', 'pages', 'ID', true, null, null);
		$this->addColumn('IS_INHERITED', 'IsInherited', 'BOOLEAN', false, 1, true);
		$this->addColumn('MAY_EDIT_PAGE_DETAILS', 'MayEditPageDetails', 'BOOLEAN', false, 1, false);
		$this->addColumn('MAY_EDIT_PAGE_CONTENTS', 'MayEditPageContents', 'BOOLEAN', false, 1, false);
		$this->addColumn('MAY_DELETE', 'MayDelete', 'BOOLEAN', false, 1, false);
		$this->addColumn('MAY_CREATE_CHILDREN', 'MayCreateChildren', 'BOOLEAN', false, 1, false);
		$this->addColumn('MAY_VIEW_PAGE', 'MayViewPage', 'BOOLEAN', false, 1, false);
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
    $this->addRelation('Group', 'Group', RelationMap::MANY_TO_ONE, array('group_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('Page', 'Page', RelationMap::MANY_TO_ONE, array('page_id' => 'id', ), 'CASCADE', null);
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
			'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
			'attributable' => array('create_column' => 'created_by', 'update_column' => 'updated_by', ),
		);
	} // getBehaviors()

} // RightTableMap
