<?php

require_once 'propel/util/BasePeer.php';
// The object class -- needed for instanceof checks in this class.
// actual class may be a subclass -- as returned by LanguageObjectPeer::getOMClass()
include_once 'model/LanguageObject.php';

/**
 * Base static class for performing query and update operations on the 'language_objects' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseLanguageObjectPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'mini_cms';

	/** the table name for this class */
	const TABLE_NAME = 'language_objects';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'model.LanguageObject';

	/** The total number of columns. */
	const NUM_COLUMNS = 7;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;


	/** the column name for the OBJECT_ID field */
	const OBJECT_ID = 'language_objects.OBJECT_ID';

	/** the column name for the LANGUAGE_ID field */
	const LANGUAGE_ID = 'language_objects.LANGUAGE_ID';

	/** the column name for the DATA field */
	const DATA = 'language_objects.DATA';

	/** the column name for the CREATED_BY field */
	const CREATED_BY = 'language_objects.CREATED_BY';

	/** the column name for the UPDATED_BY field */
	const UPDATED_BY = 'language_objects.UPDATED_BY';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'language_objects.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'language_objects.UPDATED_AT';

	/** The PHP to DB Name Mapping */
	private static $phpNameMap = null;


	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('ObjectId', 'LanguageId', 'Data', 'CreatedBy', 'UpdatedBy', 'CreatedAt', 'UpdatedAt', ),
		BasePeer::TYPE_COLNAME => array (LanguageObjectPeer::OBJECT_ID, LanguageObjectPeer::LANGUAGE_ID, LanguageObjectPeer::DATA, LanguageObjectPeer::CREATED_BY, LanguageObjectPeer::UPDATED_BY, LanguageObjectPeer::CREATED_AT, LanguageObjectPeer::UPDATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('object_id', 'language_id', 'data', 'created_by', 'updated_by', 'created_at', 'updated_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('ObjectId' => 0, 'LanguageId' => 1, 'Data' => 2, 'CreatedBy' => 3, 'UpdatedBy' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
		BasePeer::TYPE_COLNAME => array (LanguageObjectPeer::OBJECT_ID => 0, LanguageObjectPeer::LANGUAGE_ID => 1, LanguageObjectPeer::DATA => 2, LanguageObjectPeer::CREATED_BY => 3, LanguageObjectPeer::UPDATED_BY => 4, LanguageObjectPeer::CREATED_AT => 5, LanguageObjectPeer::UPDATED_AT => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('object_id' => 0, 'language_id' => 1, 'data' => 2, 'created_by' => 3, 'updated_by' => 4, 'created_at' => 5, 'updated_at' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	/**
	 * @return     MapBuilder the map builder for this peer
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function getMapBuilder()
	{
		include_once 'model/map/LanguageObjectMapBuilder.php';
		return BasePeer::getMapBuilder('model.map.LanguageObjectMapBuilder');
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
			$map = LanguageObjectPeer::getTableMap();
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
	 * @param      string $column The column name for current table. (i.e. LanguageObjectPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(LanguageObjectPeer::TABLE_NAME.'.', $alias.'.', $column);
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

		$criteria->addSelectColumn(LanguageObjectPeer::OBJECT_ID);

		$criteria->addSelectColumn(LanguageObjectPeer::LANGUAGE_ID);

		$criteria->addSelectColumn(LanguageObjectPeer::DATA);

		$criteria->addSelectColumn(LanguageObjectPeer::CREATED_BY);

		$criteria->addSelectColumn(LanguageObjectPeer::UPDATED_BY);

		$criteria->addSelectColumn(LanguageObjectPeer::CREATED_AT);

		$criteria->addSelectColumn(LanguageObjectPeer::UPDATED_AT);

	}

	const COUNT = 'COUNT(language_objects.OBJECT_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT language_objects.OBJECT_ID)';

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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
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
	 * @return     LanguageObject
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = LanguageObjectPeer::doSelect($critcopy, $con);
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
		return LanguageObjectPeer::populateObjects(LanguageObjectPeer::doSelectRS($criteria, $con));
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
			LanguageObjectPeer::addSelectColumns($criteria);
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
		$cls = LanguageObjectPeer::getOMClass();
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
	 * Returns the number of rows matching criteria, joining the related ContentObject table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinContentObject(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their ContentObject objects.
	 *
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinContentObject(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($c);
		$startcol = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ContentObjectPeer::addSelectColumns($c);

		$c->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ContentObjectPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getContentObject(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					// e.g. $author->addBookRelatedByBookId()
					$temp_obj2->addLanguageObject($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their Language objects.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		LanguagePeer::addSelectColumns($c);

		$c->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

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
					$temp_obj2->addLanguageObject($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their User objects.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

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
					$temp_obj2->addLanguageObjectRelatedByCreatedBy($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initLanguageObjectsRelatedByCreatedBy();
				$obj2->addLanguageObjectRelatedByCreatedBy($obj1); //CHECKME
			}
			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their User objects.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		UserPeer::addSelectColumns($c);

		$c->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

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
					$temp_obj2->addLanguageObjectRelatedByUpdatedBy($obj1); //CHECKME
					break;
				}
			}
			if ($newObject) {
				$obj2->initLanguageObjectsRelatedByUpdatedBy();
				$obj2->addLanguageObjectRelatedByUpdatedBy($obj1); //CHECKME
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol2 = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ContentObjectPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_COLUMNS;

		LanguagePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + LanguagePeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol6 = $startcol5 + UserPeer::NUM_COLUMNS;

		$c->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$c->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


				// Add objects for joined ContentObject rows
	
			$omClass = ContentObjectPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getContentObject(); // CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLanguageObject($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1);
			}


				// Add objects for joined Language rows
	
			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getLanguage(); // CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addLanguageObject($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj3->initLanguageObjects();
				$obj3->addLanguageObject($obj1);
			}


				// Add objects for joined User rows
	
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getUserRelatedByCreatedBy(); // CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addLanguageObjectRelatedByCreatedBy($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj4->initLanguageObjectsRelatedByCreatedBy();
				$obj4->addLanguageObjectRelatedByCreatedBy($obj1);
			}


				// Add objects for joined User rows
	
			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj5 = new $cls();
			$obj5->hydrate($rs, $startcol5);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj5 = $temp_obj1->getUserRelatedByUpdatedBy(); // CHECKME
				if ($temp_obj5->getPrimaryKey() === $obj5->getPrimaryKey()) {
					$newObject = false;
					$temp_obj5->addLanguageObjectRelatedByUpdatedBy($obj1); // CHECKME
					break;
				}
			}

			if ($newObject) {
				$obj5->initLanguageObjectsRelatedByUpdatedBy();
				$obj5->addLanguageObjectRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ContentObject table
	 *
	 * @param      Criteria $c
	 * @param      boolean $distinct Whether to select only distinct columns (You can also set DISTINCT modifier in Criteria).
	 * @param      Connection $con
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptContentObject(Criteria $criteria, $distinct = false, $con = null)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// clear out anything that might confuse the ORDER BY clause
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
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
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(LanguageObjectPeer::COUNT);
		}

		// just in case we're grouping: add those columns to the select statement
		foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$rs = LanguageObjectPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
			// no rows returned; we infer that means 0 matches.
			return 0;
		}
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except ContentObject.
	 *
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptContentObject(Criteria $c, $con = null)
	{
		$c = clone $c;

		// Set the correct dbName if it has not been overridden
		// $c->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($c);
		$startcol2 = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		LanguagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + LanguagePeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + UserPeer::NUM_COLUMNS;

		$c->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);

		$c->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

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
					$temp_obj2->addLanguageObject($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUserRelatedByCreatedBy(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addLanguageObjectRelatedByCreatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initLanguageObjectsRelatedByCreatedBy();
				$obj3->addLanguageObjectRelatedByCreatedBy($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getUserRelatedByUpdatedBy(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addLanguageObjectRelatedByUpdatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initLanguageObjectsRelatedByUpdatedBy();
				$obj4->addLanguageObjectRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except Language.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol2 = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ContentObjectPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + UserPeer::NUM_COLUMNS;

		UserPeer::addSelectColumns($c);
		$startcol5 = $startcol4 + UserPeer::NUM_COLUMNS;

		$c->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$c->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID);

		$c->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ContentObjectPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getContentObject(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLanguageObject($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getUserRelatedByCreatedBy(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addLanguageObjectRelatedByCreatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initLanguageObjectsRelatedByCreatedBy();
				$obj3->addLanguageObjectRelatedByCreatedBy($obj1);
			}

			$omClass = UserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4  = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getUserRelatedByUpdatedBy(); //CHECKME
				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addLanguageObjectRelatedByUpdatedBy($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj4->initLanguageObjectsRelatedByUpdatedBy();
				$obj4->addLanguageObjectRelatedByUpdatedBy($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except UserRelatedByCreatedBy.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol2 = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ContentObjectPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_COLUMNS;

		LanguagePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + LanguagePeer::NUM_COLUMNS;

		$c->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$c->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ContentObjectPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getContentObject(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLanguageObject($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1);
			}

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addLanguageObject($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initLanguageObjects();
				$obj3->addLanguageObject($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except UserRelatedByUpdatedBy.
	 *
	 * @return     array Array of LanguageObject objects.
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

		LanguageObjectPeer::addSelectColumns($c);
		$startcol2 = (LanguageObjectPeer::NUM_COLUMNS - LanguageObjectPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ContentObjectPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_COLUMNS;

		LanguagePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + LanguagePeer::NUM_COLUMNS;

		$c->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID);

		$c->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = LanguageObjectPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ContentObjectPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getContentObject(); //CHECKME
				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addLanguageObject($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initLanguageObjects();
				$obj2->addLanguageObject($obj1);
			}

			$omClass = LanguagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getLanguage(); //CHECKME
				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addLanguageObject($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initLanguageObjects();
				$obj3->addLanguageObject($obj1);
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
		return LanguageObjectPeer::CLASS_DEFAULT;
	}

	/**
	 * Method perform an INSERT on the database, given a LanguageObject or Criteria object.
	 *
	 * @param      mixed $values Criteria or LanguageObject object containing data that is used to create the INSERT statement.
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
			$criteria = $values->buildCriteria(); // build Criteria from LanguageObject object
		}


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
	 * Method perform an UPDATE on the database, given a LanguageObject or Criteria object.
	 *
	 * @param      mixed $values Criteria or LanguageObject object containing data that is used to create the UPDATE statement.
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

			$comparison = $criteria->getComparison(LanguageObjectPeer::OBJECT_ID);
			$selectCriteria->add(LanguageObjectPeer::OBJECT_ID, $criteria->remove(LanguageObjectPeer::OBJECT_ID), $comparison);

			$comparison = $criteria->getComparison(LanguageObjectPeer::LANGUAGE_ID);
			$selectCriteria->add(LanguageObjectPeer::LANGUAGE_ID, $criteria->remove(LanguageObjectPeer::LANGUAGE_ID), $comparison);

		} else { // $values is LanguageObject object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Method to DELETE all rows from the language_objects table.
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
			$affectedRows += BasePeer::doDeleteAll(LanguageObjectPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Method perform a DELETE on the database, given a LanguageObject or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or LanguageObject object or primary key or array of primary keys
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
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} elseif ($values instanceof LanguageObject) {

			$criteria = $values->buildPkeyCriteria();
		} else {
			// it must be the primary key
			$criteria = new Criteria(self::DATABASE_NAME);
			// primary key is composite; we therefore, expect
			// the primary key passed to be an array of pkey
			// values
			if(count($values) == count($values, COUNT_RECURSIVE))
			{
				// array is not multi-dimensional
				$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
			}

			$criteria->add(LanguageObjectPeer::OBJECT_ID, $vals[0], Criteria::IN);
			$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $vals[1], Criteria::IN);
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
	 * Validates all modified columns of given LanguageObject object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      LanguageObject $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate(LanguageObject $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(LanguageObjectPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(LanguageObjectPeer::TABLE_NAME);

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

		return BasePeer::doValidate(LanguageObjectPeer::DATABASE_NAME, LanguageObjectPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve object using using composite pkey values.
	 * @param int $object_id
	 * @param string $language_id
	 * @param      Connection $con
	 * @return     LanguageObject
	 */
	public static function retrieveByPK( $object_id, $language_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(LanguageObjectPeer::OBJECT_ID, $object_id);
		$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $language_id);
		$v = LanguageObjectPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} // BaseLanguageObjectPeer

// static code to register the map builder for this Peer with the main Propel class
if (Propel::isInit()) {
	// the MapBuilder classes register themselves with Propel during initialization
	// so we need to load them here.
	try {
		BaseLanguageObjectPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
	// even if Propel is not yet initialized, the map builder class can be registered
	// now and then it will be loaded when Propel initializes.
	require_once 'model/map/LanguageObjectMapBuilder.php';
	Propel::registerMapBuilder('model.map.LanguageObjectMapBuilder');
}
