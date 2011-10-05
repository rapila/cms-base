<?php



/**
 * This class defines the structure of the 'documents' table.
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
class DocumentTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'model.map.DocumentTableMap';

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
		$this->setName('documents');
		$this->setPhpName('Document');
		$this->setClassname('Document');
		$this->setPackage('model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('NAME', 'Name', 'VARCHAR', false, 100, null);
		$this->addColumn('ORIGINAL_NAME', 'OriginalName', 'VARCHAR', false, 100, null);
		$this->addColumn('DESCRIPTION', 'Description', 'VARCHAR', false, 255, null);
		$this->addColumn('CONTENT_CREATED_AT', 'ContentCreatedAt', 'DATE', false, null, null);
		$this->addColumn('LICENSE', 'License', 'VARCHAR', false, 30, null);
		$this->addColumn('AUTHOR', 'Author', 'VARCHAR', false, 150, null);
		$this->addForeignKey('LANGUAGE_ID', 'LanguageId', 'VARCHAR', 'languages', 'ID', false, 3, null);
		$this->addForeignKey('OWNER_ID', 'OwnerId', 'INTEGER', 'users', 'ID', true, null, null);
		$this->addForeignKey('DOCUMENT_TYPE_ID', 'DocumentTypeId', 'INTEGER', 'document_types', 'ID', true, null, null);
		$this->addForeignKey('DOCUMENT_CATEGORY_ID', 'DocumentCategoryId', 'INTEGER', 'document_categories', 'ID', false, null, null);
		$this->addColumn('IS_PRIVATE', 'IsPrivate', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_INACTIVE', 'IsInactive', 'BOOLEAN', false, 1, false);
		$this->addColumn('IS_PROTECTED', 'IsProtected', 'BOOLEAN', false, 1, false);
		$this->addColumn('SORT', 'Sort', 'INTEGER', false, null, null);
		$this->addColumn('DATA', 'Data', 'BLOB', false, null, null);
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
		$this->addRelation('Language', 'Language', RelationMap::MANY_TO_ONE, array('language_id' => 'id', ), null, null);
		$this->addRelation('UserRelatedByOwnerId', 'User', RelationMap::MANY_TO_ONE, array('owner_id' => 'id', ), null, null);
		$this->addRelation('DocumentType', 'DocumentType', RelationMap::MANY_TO_ONE, array('document_type_id' => 'id', ), 'CASCADE', null);
		$this->addRelation('DocumentCategory', 'DocumentCategory', RelationMap::MANY_TO_ONE, array('document_category_id' => 'id', ), 'SET NULL', null);
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
			'referenceable' => array(),
			'taggable' => array(),
			'extended_timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
			'denyable' => array('mode' => 'allow', 'role_key' => '', ),
			'attributable' => array('create_column' => 'created_by', 'update_column' => 'updated_by', ),
		);
	} // getBehaviors()

} // DocumentTableMap
