<?php

require_once 'propel/util/BasePeer.php';
// The object class -- needed for instanceof checks in this class.
// actual class may be a subclass -- as returned by DocumentPeer::getOMClass()
include_once 'model/Document.php';

/**
 * Base static class for performing query and update operations on the 'documents' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseDocumentPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'mini_cms';

	/** the table name for this class */
	const TABLE_NAME = 'documents';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'model.Document';

	/** The total number of columns. */
	const NUM_COLUMNS = 15;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 1;


	/** the column name for the ID field */
	const ID = 'documents.ID';

	/** the column name for the NAME field */
	const NAME = 'documents.NAME';

	/** the column name for the DESCRIPTION field */
	const DESCRIPTION = 'documents.DESCRIPTION';

	/** the column name for the LANGUAGE_ID field */
	const LANGUAGE_ID = 'documents.LANGUAGE_ID';

	/** the column name for the OWNER_ID field */
	const OWNER_ID = 'documents.OWNER_ID';

	/** the column name for the DOCUMENT_TYPE_ID field */
	const DOCUMENT_TYPE_ID = 'documents.DOCUMENT_TYPE_ID';

	/** the column name for the DOCUMENT_CATEGORY_ID field */
	const DOCUMENT_CATEGORY_ID = 'documents.DOCUMENT_CATEGORY_ID';

	/** the column name for the IS_PRIVATE field */
	const IS_PRIVATE = 'documents.IS_PRIVATE';

	/** the column name for the IS_INACTIVE field */
	const IS_INACTIVE = 'documents.IS_INACTIVE';

	/** the column name for the IS_PROTECTED field */
	const IS_PROTECTED = 'documents.IS_PROTECTED';

	/** the column name for the DATA field */
	const DATA = 'documents.DATA';

	/** the column name for the CREATED_BY field */
	const CREATED_BY = 'documents.CREATED_BY';

	/** the column name for the UPDATED_BY field */
	const UPDATED_BY = 'documents.UPDATED_BY';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'documents.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'documents.UPDATED_AT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'Description', 'LanguageId', 'OwnerId', 'DocumentTypeId', 'DocumentCategoryId', 'IsPrivate', 'IsInactive', 'IsProtected', 'Data', 'CreatedBy', 'UpdatedBy', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (DocumentPeer::ID, DocumentPeer::NAME, DocumentPeer::DESCRIPTION, DocumentPeer::LANGUAGE_ID, DocumentPeer::OWNER_ID, DocumentPeer::DOCUMENT_TYPE_ID, DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentPeer::IS_PRIVATE, DocumentPeer::IS_INACTIVE, DocumentPeer::IS_PROTECTED, DocumentPeer::DATA, DocumentPeer::CREATED_BY, DocumentPeer::UPDATED_BY, DocumentPeer::CREATED_AT, DocumentPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'description', 'language_id', 'owner_id', 'document_type_id', 'document_category_id', 'is_private', 'is_inactive', 'is_protected', 'data', 'created_by', 'updated_by', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'Description' => 2, 'LanguageId' => 3, 'OwnerId' => 4, 'DocumentTypeId' => 5, 'DocumentCategoryId' => 6, 'IsPrivate' => 7, 'IsInactive' => 8, 'IsProtected' => 9, 'Data' => 10, 'CreatedBy' => 11, 'UpdatedBy' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, ),
		BasePeer::TYPE_COLNAME => array (DocumentPeer::ID => 0, DocumentPeer::NAME => 1, DocumentPeer::DESCRIPTION => 2, DocumentPeer::LANGUAGE_ID => 3, DocumentPeer::OWNER_ID => 4, DocumentPeer::DOCUMENT_TYPE_ID => 5, DocumentPeer::DOCUMENT_CATEGORY_ID => 6, DocumentPeer::IS_PRIVATE => 7, DocumentPeer::IS_INACTIVE => 8, DocumentPeer::IS_PROTECTED => 9, DocumentPeer::DATA => 10, DocumentPeer::CREATED_BY => 11, DocumentPeer::UPDATED_BY => 12, DocumentPeer::CREATED_AT => 13, DocumentPeer::UPDATED_AT => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'description' => 2, 'language_id' => 3, 'owner_id' => 4, 'document_type_id' => 5, 'document_category_id' => 6, 'is_private' => 7, 'is_inactive' => 8, 'is_protected' => 9, 'data' => 10, 'created_by' => 11, 'updated_by' => 12, 'created_at' => 13, 'updated_at' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	/**
	 * @return     MapBuilder the map builder for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getMapBuilder()
	{
		include_once 'model/map/DocumentMapBuilder.php';
		return BasePeer::getMapBuilder('model.map.DocumentMapBuilder');
	}
	/**
	 * Gets a map (hash) of PHP names to DB column names.
	 *
	 * @return     array The PHP to DB name map for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @deprecated Use the getFieldNames() and translateFieldName() methods instead of this.
	 */
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = DocumentPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants TYPE_PHPNAME,
	 *                         TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 */
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	/**
	 * Returns an array of of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants TYPE_PHPNAME,
	 *                      TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	/**
	 * Convenience method which changes table.column to alias.column.
	 *
	 * Using this method you can maintain SQL abstraction while using column aliases.
	 * <code>
	 *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
	 *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
	 * </code>
	 * @param      string $alias The alias for the current table.
	 * @param      string $column The column name for current table. (i.e. DocumentPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(DocumentPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	/**
	 * Add all the columns needed to create a new object.
	 *
	 * Note: any columns that were marked with lazyLoad="true" in the
	 * XML schema will not be added to the select list and only loaded
	 * on demand.
	 *
	 * @param      criteria object containing the columns to add.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(DocumentPeer::ID);

		$criteria->addSelectColumn(DocumentPeer::NAME);

		$criteria->addSelectColumn(DocumentPeer::DESCRIPTION);

		$criteria->addSelectColumn(DocumentPeer::LANGUAGE_ID);

		$criteria->addSelectColumn(DocumentPeer::OWNER_ID);

		$criteria->addSelectColumn(DocumentPeer::DOCUMENT_TYPE_ID);

		$criteria->addSelectColumn(DocumentPeer::DOCUMENT_CATEGORY_ID);

		$criteria->addSelectColumn(DocumentPeer::IS_PRIVATE);

		$criteria->addSelectColumn(DocumentPeer::IS_INACTIVE);

		$criteria->addSelectColumn(DocumentPeer::IS_PROTECTED);

		$criteria->addSelectColumn(DocumentPeer::CREATED_BY);

		$criteria->addSelectColumn(DocumentPeer::UPDATED_BY);

		$criteria->addSelectColumn(DocumentPeer::CREATED_AT);

		$criteria->addSelectColumn(DocumentPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(documents.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT documents.ID)';

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}
	/**
	 * Method to select one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      Connection $con
	 * @return     Document
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = DocumentPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	/**
	 * Method to do selects.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return DocumentPeer::populateObjects(DocumentPeer::doSelectRS($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect()
	 * method to get a ResultSet.
	 *
	 * Use this method directly if you want to just get the resultset
	 * (instead of an array of objects).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      Connection $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     ResultSet The resultset object with numerically-indexed fields.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			DocumentPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a Creole ResultSet, set to return
		// rows indexed numerically.
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = DocumentPeer::getOMClass();
		$cls = Propel::import($cls);
		// populate the object(s)
		while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	/**
	 * Returns the number of rows matching criteria, joining the related Language table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinLanguage(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByOwnerId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinUserRelatedByOwnerId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DocumentType table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDocumentType(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DocumentCategory table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinDocumentCategory(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByCreatedBy table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinUserRelatedByCreatedBy(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByUpdatedBy table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinUserRelatedByUpdatedBy(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Document objects pre-filled with their Language objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinLanguage(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		LanguagePeer::addSelectColumns($c);

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = LanguagePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addDocument($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with their User objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinUserRelatedByOwnerId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getUserRelatedByOwnerId(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addDocumentRelatedByOwnerId($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initDocumentsRelatedByOwnerId();
				$obj2->addDocumentRelatedByOwnerId($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with their DocumentType objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDocumentType(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DocumentTypePeer::addSelectColumns($c);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DocumentTypePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDocumentType(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addDocument($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with their DocumentCategory objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinDocumentCategory(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		DocumentCategoryPeer::addSelectColumns($c);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = DocumentCategoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getDocumentCategory(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addDocument($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with their User objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinUserRelatedByCreatedBy(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getUserRelatedByCreatedBy(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addDocumentRelatedByCreatedBy($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initDocumentsRelatedByCreatedBy();
				$obj2->addDocumentRelatedByCreatedBy($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with their User objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinUserRelatedByUpdatedBy(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getUserRelatedByUpdatedBy(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addDocumentRelatedByUpdatedBy($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initDocumentsRelatedByUpdatedBy();
				$obj2->addDocumentRelatedByUpdatedBy($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$criteria->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		DocumentTypePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentTypePeer::NUM_COLUMNS;

		DocumentCategoryPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + DocumentCategoryPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol8 = $startcol7 + UserPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$c->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined Language rows
	
			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getLanguage(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocument($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1);
			}


				// Add objects for joined User rows
	
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUserRelatedByOwnerId(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocumentRelatedByOwnerId($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocumentsRelatedByOwnerId();
				$obj3->addDocumentRelatedByOwnerId($obj1);
			}


				// Add objects for joined DocumentType rows
	
			$omClass = DocumentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentType(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}


				// Add objects for joined DocumentCategory rows
	
			$omClass = DocumentCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getDocumentCategory(); // CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addDocument($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj5->initDocuments();
				$obj5->addDocument($obj1);
			}


				// Add objects for joined User rows
	
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6 = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getUserRelatedByCreatedBy(); // CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addDocumentRelatedByCreatedBy($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj6->initDocumentsRelatedByCreatedBy();
				$obj6->addDocumentRelatedByCreatedBy($obj1);
			}


				// Add objects for joined User rows
	
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj7 = new $cls();
			$obj7->hydrate($rs, $startcol7);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj7 = $temp_obj1->getUserRelatedByUpdatedBy(); // CHECKME
				if ($temp_obj7->getPrimaryKey() === $obj7->getPrimaryKey()) {
					$newObject = false;
					$temp_obj7->addDocumentRelatedByUpdatedBy($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj7->initDocumentsRelatedByUpdatedBy();
				$obj7->addDocumentRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Language table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptLanguage(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$criteria->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByOwnerId table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptUserRelatedByOwnerId(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DocumentType table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDocumentType(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$criteria->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related DocumentCategory table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptDocumentCategory(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$criteria->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByCreatedBy table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptUserRelatedByCreatedBy(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByUpdatedBy table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptUserRelatedByUpdatedBy(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(DocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(DocumentPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$criteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$rs = DocumentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects except Language.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptLanguage(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		UserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + UserPeer::NUM_COLUMNS;

		DocumentTypePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DocumentTypePeer::NUM_COLUMNS;

		DocumentCategoryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentCategoryPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + UserPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$c->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getUserRelatedByOwnerId(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocumentRelatedByOwnerId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocumentsRelatedByOwnerId();
				$obj2->addDocumentRelatedByOwnerId($obj1);
			}

			$omClass = DocumentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDocumentType(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocuments();
				$obj3->addDocument($obj1);
			}

			$omClass = DocumentCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentCategory(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getUserRelatedByCreatedBy(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addDocumentRelatedByCreatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initDocumentsRelatedByCreatedBy();
				$obj5->addDocumentRelatedByCreatedBy($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getUserRelatedByUpdatedBy(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addDocumentRelatedByUpdatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initDocumentsRelatedByUpdatedBy();
				$obj6->addDocumentRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects except UserRelatedByOwnerId.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptUserRelatedByOwnerId(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		DocumentTypePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DocumentTypePeer::NUM_COLUMNS;

		DocumentCategoryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentCategoryPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1);
			}

			$omClass = DocumentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDocumentType(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocuments();
				$obj3->addDocument($obj1);
			}

			$omClass = DocumentCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentCategory(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects except DocumentType.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDocumentType(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		DocumentCategoryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentCategoryPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + UserPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);

		$c->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUserRelatedByOwnerId(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocumentRelatedByOwnerId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocumentsRelatedByOwnerId();
				$obj3->addDocumentRelatedByOwnerId($obj1);
			}

			$omClass = DocumentCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentCategory(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getUserRelatedByCreatedBy(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addDocumentRelatedByCreatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initDocumentsRelatedByCreatedBy();
				$obj5->addDocumentRelatedByCreatedBy($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getUserRelatedByUpdatedBy(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addDocumentRelatedByUpdatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initDocumentsRelatedByUpdatedBy();
				$obj6->addDocumentRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects except DocumentCategory.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptDocumentCategory(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		DocumentTypePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentTypePeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol7 = $startcol6 + UserPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(DocumentPeer::OWNER_ID, UserPeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$c->addJoin(DocumentPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(DocumentPeer::UPDATED_BY, UserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUserRelatedByOwnerId(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocumentRelatedByOwnerId($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocumentsRelatedByOwnerId();
				$obj3->addDocumentRelatedByOwnerId($obj1);
			}

			$omClass = DocumentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentType(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5  = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getUserRelatedByCreatedBy(); //CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addDocumentRelatedByCreatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj5->initDocumentsRelatedByCreatedBy();
				$obj5->addDocumentRelatedByCreatedBy($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj6  = new $cls();
			$obj6->hydrate($rs, $startcol6);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj6 = $temp_obj1->getUserRelatedByUpdatedBy(); //CHECKME
				if ($temp_obj6->getPrimaryKey() === $obj6->getPrimaryKey()) {
					$newObject = false;
					$temp_obj6->addDocumentRelatedByUpdatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj6->initDocumentsRelatedByUpdatedBy();
				$obj6->addDocumentRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects except UserRelatedByCreatedBy.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptUserRelatedByCreatedBy(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		DocumentTypePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DocumentTypePeer::NUM_COLUMNS;

		DocumentCategoryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentCategoryPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1);
			}

			$omClass = DocumentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDocumentType(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocuments();
				$obj3->addDocument($obj1);
			}

			$omClass = DocumentCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentCategory(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of Document objects pre-filled with all related objects except UserRelatedByUpdatedBy.
	 *
	 * @return     array Array of Document objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptUserRelatedByUpdatedBy(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		DocumentPeer::addSelectColumns($c);
		$startcol2 = (DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		DocumentTypePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + DocumentTypePeer::NUM_COLUMNS;

		DocumentCategoryPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + DocumentCategoryPeer::NUM_COLUMNS;

		$c->addJoin(DocumentPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);

		$c->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = DocumentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initDocuments();
				$obj2->addDocument($obj1);
			}

			$omClass = DocumentTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getDocumentType(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initDocuments();
				$obj3->addDocument($obj1);
			}

			$omClass = DocumentCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getDocumentCategory(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addDocument($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initDocuments();
				$obj4->addDocument($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	/**
	 * Returns the TableMap related to this peer.
	 * This method is not needed for general use but a specific application could have a need.
	 * @return     TableMap
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * This uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass()
	{
		return DocumentPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a Document or Criteria object.
	 *
	 * @param      mixed $values Criteria or Document object containing data that is used to create the INSERT statement.
	 * @param      Connection $con the connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from Document object
		}

		$criteria->remove(DocumentPeer::ID); // remove pkey col since this table uses auto-increment


		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		try {
			// use transaction because $criteria could contain info
			// for more than one table (I guess, conceivably)
			$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	/**
	 * Method perform an UPDATE on the database, given a Document or Criteria object.
	 *
	 * @param      mixed $values Criteria or Document object containing data that is used to create the UPDATE statement.
	 * @param      Connection $con The connection to use (specify Connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(DocumentPeer::ID);
			$selectCriteria->add(DocumentPeer::ID, $criteria->remove(DocumentPeer::ID), $comparison);

		} else { // $values is Document object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Method to DELETE all rows from the documents table.
	 *
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			$affectedRows += BasePeer::doDeleteAll(DocumentPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a Document or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Document object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      Connection $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(DocumentPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof Document) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(DocumentPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given Document object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Document $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(Document $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(DocumentPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(DocumentPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		return BasePeer::doValidate(DocumentPeer::DATABASE_NAME, DocumentPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      mixed $pk the primary key.
	 * @param      Connection $con the connection to use
	 * @return     Document
	 */
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(DocumentPeer::DATABASE_NAME);

		$criteria->add(DocumentPeer::ID, $pk);


		$v = DocumentPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      Connection $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(DocumentPeer::ID, $pks, Criteria::IN);
			$objs = DocumentPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} // BaseDocumentPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseDocumentPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	require_once 'model/map/DocumentMapBuilder.php';
	Propel::registerMapBuilder('model.map.DocumentMapBuilder');
}
