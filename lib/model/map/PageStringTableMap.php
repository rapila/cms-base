<?php


/**
 * This class defines the structure of the 'page_strings' table.
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
class PageStringTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.PageStringTableMap';

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
		$this->setName('page_strings');
		$this->setPhpName('PageString');
		$this->setClassname('PageString');
		$this->setPackage('model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('PAGE_ID', 'PageId', 'INTEGER' , 'pages', 'ID', true, null, null);
		$this->addForeignPrimaryKey('LANGUAGE_ID', 'LanguageId', 'VARCHAR' , 'languages', 'ID', true, 3, null);
		$this->addColumn('IS_INACTIVE', 'IsInactive', 'BOOLEAN', false, 1, false);
		$this->addColumn('LINK_TEXT', 'LinkText', 'VARCHAR', false, 50, '');
		$this->addColumn('PAGE_TITLE', 'PageTitle', 'VARCHAR', true, 255, null);
		$this->addColumn('KEYWORDS', 'Keywords', 'VARCHAR', false, 255, null);
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
    $this->addRelation('Page', 'Page', RelationMap::MANY_TO_ONE, array('page_id' => 'id', ), 'CASCADE', null);
    $this->addRelation('Language', 'Language', RelationMap::MANY_TO_ONE, array('language_id' => 'id', ), null, null);
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
			'extended_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
			'attributable' => array('create_column' => 'created_by', 'update_column' => 'updated_by', ),
		);
	} // getBehaviors()

} // PageStringTableMap
