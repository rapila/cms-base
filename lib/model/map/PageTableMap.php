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
class PageTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.PageTableMap';

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
		$this->setName('pages');
		$this->setPhpName('Page');
		$this->setClassname('Page');
		$this->setPackage('model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addForeignKey('PARENT_ID', 'ParentId', 'INTEGER', 'pages', 'ID', false, null, null);
		$this->addColumn('SORT', 'Sort', 'INTEGER', false, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 50, null);
		$this->addColumn('PAGE_TYPE', 'PageType', 'VARCHAR', false, 15, null);
		$this->addColumn('TEMPLATE_NAME', 'TemplateName', 'VARCHAR', false, 50, null);
		$this->addColumn('IS_INACTIVE', 'IsInactive', 'BOOLEAN', false, 1, true);
		$this->addColumn('IS_FOLDER', 'IsFolder', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_HIDDEN', 'IsHidden', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_PROTECTED', 'IsProtected', 'BOOLEAN', false, 1, false);
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
    $this->addRelation('PageRelatedByParentId', 'Page', RelationMap::MANY_TO_ONE, array('parent_id' => 'id', ), 'RESTRICT', null);
    $this->addRelation('UserRelatedByCreatedBy', 'User', RelationMap::MANY_TO_ONE, array('created_by' => 'id', ), 'SET NULL', null);
    $this->addRelation('UserRelatedByUpdatedBy', 'User', RelationMap::MANY_TO_ONE, array('updated_by' => 'id', ), 'SET NULL', null);
    $this->addRelation('PageRelatedById', 'Page', RelationMap::ONE_TO_MANY, array('id' => 'parent_id', ), 'RESTRICT', null);
    $this->addRelation('PageProperty', 'PageProperty', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null);
    $this->addRelation('PageString', 'PageString', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null);
    $this->addRelation('ContentObject', 'ContentObject', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null);
    $this->addRelation('Right', 'Right', RelationMap::ONE_TO_MANY, array('id' => 'page_id', ), 'CASCADE', null);
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

} // PageTableMap
