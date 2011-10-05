<?php


/**
 * Base static class for performing query and update operations on the 'language_objects' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BaseLanguageObjectPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'rapila';

	/** the table name for this class */
	const TABLE_NAME = 'language_objects';

	/** the related Propel class for this table */
	const OM_CLASS = 'LanguageObject';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'model.LanguageObject';

	/** the related TableMap class for this table */
	const TM_CLASS = 'LanguageObjectTableMap';

	/** The total number of columns. */
	const NUM_COLUMNS = 7;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
	const NUM_HYDRATE_COLUMNS = 7;

	/** the column name for the OBJECT_ID field */
	const OBJECT_ID = 'language_objects.OBJECT_ID';

	/** the column name for the LANGUAGE_ID field */
	const LANGUAGE_ID = 'language_objects.LANGUAGE_ID';

	/** the column name for the DATA field */
	const DATA = 'language_objects.DATA';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'language_objects.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'language_objects.UPDATED_AT';

	/** the column name for the CREATED_BY field */
	const CREATED_BY = 'language_objects.CREATED_BY';

	/** the column name for the UPDATED_BY field */
	const UPDATED_BY = 'language_objects.UPDATED_BY';

	/** The default string format for model objects of the related table **/
	const DEFAULT_STRING_FORMAT = 'YAML';

	/**
	 * An identiy map to hold any loaded instances of LanguageObject objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array LanguageObject[]
	 */
	public static $instances = array();


	// denyable behavior
	private static $IGNORE_RIGHTS = false;
	/**
	 * holds an array of fieldnames
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
	 */
	protected static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('ObjectId', 'LanguageId', 'Data', 'CreatedAt', 'UpdatedAt', 'CreatedBy', 'UpdatedBy', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('objectId', 'languageId', 'data', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', ),
		BasePeer::TYPE_COLNAME => array (self::OBJECT_ID, self::LANGUAGE_ID, self::DATA, self::CREATED_AT, self::UPDATED_AT, self::CREATED_BY, self::UPDATED_BY, ),
		BasePeer::TYPE_RAW_COLNAME => array ('OBJECT_ID', 'LANGUAGE_ID', 'DATA', 'CREATED_AT', 'UPDATED_AT', 'CREATED_BY', 'UPDATED_BY', ),
		BasePeer::TYPE_FIELDNAME => array ('object_id', 'language_id', 'data', 'created_at', 'updated_at', 'created_by', 'updated_by', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	protected static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('ObjectId' => 0, 'LanguageId' => 1, 'Data' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, 'CreatedBy' => 5, 'UpdatedBy' => 6, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('objectId' => 0, 'languageId' => 1, 'data' => 2, 'createdAt' => 3, 'updatedAt' => 4, 'createdBy' => 5, 'updatedBy' => 6, ),
		BasePeer::TYPE_COLNAME => array (self::OBJECT_ID => 0, self::LANGUAGE_ID => 1, self::DATA => 2, self::CREATED_AT => 3, self::UPDATED_AT => 4, self::CREATED_BY => 5, self::UPDATED_BY => 6, ),
		BasePeer::TYPE_RAW_COLNAME => array ('OBJECT_ID' => 0, 'LANGUAGE_ID' => 1, 'DATA' => 2, 'CREATED_AT' => 3, 'UPDATED_AT' => 4, 'CREATED_BY' => 5, 'UPDATED_BY' => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('object_id' => 0, 'language_id' => 1, 'data' => 2, 'created_at' => 3, 'updated_at' => 4, 'created_by' => 5, 'updated_by' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	/**
	 * Translates a fieldname to another type
	 *
	 * @param      string $name field name
	 * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @param      string $toType   One of the class type constants
	 * @return     string translated name of the field.
	 * @throws     PropelException - if the specified name could not be found in the fieldname mappings.
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
	 * Returns an array of field names.
	 *
	 * @param      string $type The type of fieldnames to return:
	 *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     array A list of field names
	 */

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
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
	 * @param      Criteria $criteria object containing the columns to add.
	 * @param      string   $alias    optional table alias
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function addSelectColumns(Criteria $criteria, $alias = null)
	{
		if (null === $alias) {
			$criteria->addSelectColumn(LanguageObjectPeer::OBJECT_ID);
			$criteria->addSelectColumn(LanguageObjectPeer::LANGUAGE_ID);
			$criteria->addSelectColumn(LanguageObjectPeer::DATA);
			$criteria->addSelectColumn(LanguageObjectPeer::CREATED_AT);
			$criteria->addSelectColumn(LanguageObjectPeer::UPDATED_AT);
			$criteria->addSelectColumn(LanguageObjectPeer::CREATED_BY);
			$criteria->addSelectColumn(LanguageObjectPeer::UPDATED_BY);
		} else {
			$criteria->addSelectColumn($alias . '.OBJECT_ID');
			$criteria->addSelectColumn($alias . '.LANGUAGE_ID');
			$criteria->addSelectColumn($alias . '.DATA');
			$criteria->addSelectColumn($alias . '.CREATED_AT');
			$criteria->addSelectColumn($alias . '.UPDATED_AT');
			$criteria->addSelectColumn($alias . '.CREATED_BY');
			$criteria->addSelectColumn($alias . '.UPDATED_BY');
		}
	}

	/**
	 * Returns the number of rows matching criteria.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @return     int Number of matching rows.
	 */
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
		// we may modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		// BasePeer returns a PDOStatement
		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}
	/**
	 * Selects one object from the DB.
	 *
	 * @param      Criteria $criteria object used to create the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     LanguageObject
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
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
	 * Selects several row from the DB.
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con
	 * @return     array Array of selected Objects
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return LanguageObjectPeer::populateObjects(LanguageObjectPeer::doSelectStmt($criteria, $con));
	}
	/**
	 * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
	 *
	 * Use this method directly if you want to work with an executed statement durirectly (for example
	 * to perform your own object hydration).
	 *
	 * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
	 * @param      PropelPDO $con The connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     PDOStatement The executed PDOStatement object.
	 * @see        BasePeer::doSelect()
	 */
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		// BasePeer returns a PDOStatement
		return BasePeer::doSelect($criteria, $con);
	}
	/**
	 * Adds an object to the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doSelect*()
	 * methods in your stub classes -- you may need to explicitly add objects
	 * to the cache in order to ensure that the same objects are always returned by doSelect*()
	 * and retrieveByPK*() calls.
	 *
	 * @param      LanguageObject $value A LanguageObject object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool($obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = serialize(array((string) $obj->getObjectId(), (string) $obj->getLanguageId()));
			} // if key === null
			self::$instances[$key] = $obj;
		}
	}

	/**
	 * Removes an object from the instance pool.
	 *
	 * Propel keeps cached copies of objects in an instance pool when they are retrieved
	 * from the database.  In some cases -- especially when you override doDelete
	 * methods in your stub classes -- you may need to explicitly remove objects
	 * from the cache in order to prevent returning objects that no longer exist.
	 *
	 * @param      mixed $value A LanguageObject object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof LanguageObject) {
				$key = serialize(array((string) $value->getObjectId(), (string) $value->getLanguageId()));
			} elseif (is_array($value) && count($value) === 2) {
				// assume we've been passed a primary key
				$key = serialize(array((string) $value[0], (string) $value[1]));
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or LanguageObject object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} // removeInstanceFromPool()

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
	 * @return     LanguageObject Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
	 * @see        getPrimaryKeyHash()
	 */
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; // just to be explicit
	}
	
	/**
	 * Clear the instance pool.
	 *
	 * @return     void
	 */
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	/**
	 * Method to invalidate the instance pool of all tables related to language_objects
	 * by a foreign key with ON DELETE CASCADE
	 */
	public static function clearRelatedInstancePool()
	{
	}

	/**
	 * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
	 *
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, a serialize()d version of the primary key will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     string A string version of PK or NULL if the components of primary key in result array are all null.
	 */
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
		// If the PK cannot be derived from the row, return NULL.
		if ($row[$startcol] === null && $row[$startcol + 1] === null) {
			return null;
		}
		return serialize(array((string) $row[$startcol], (string) $row[$startcol + 1]));
	}

	/**
	 * Retrieves the primary key from the DB resultset row
	 * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
	 * a multi-column primary key, an array of the primary key columns will be returned.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @return     mixed The primary key of the row
	 */
	public static function getPrimaryKeyFromRow($row, $startcol = 0)
	{
		return array((int) $row[$startcol], (string) $row[$startcol + 1]);
	}
	
	/**
	 * The returned array will contain objects of the default type or
	 * objects that inherit from the default.
	 *
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
		// set the class once to avoid overhead in the loop
		$cls = LanguageObjectPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = LanguageObjectPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				LanguageObjectPeer::addInstanceToPool($obj, $key);
			} // if key exists
		}
		$stmt->closeCursor();
		return $results;
	}
	/**
	 * Populates an object of the default type or an object that inherit from the default.
	 *
	 * @param      array $row PropelPDO resultset row.
	 * @param      int $startcol The 0-based offset for reading from the resultset row.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 * @return     array (LanguageObject object, last column rank)
	 */
	public static function populateObject($row, $startcol = 0)
	{
		$key = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, $startcol);
		if (null !== ($obj = LanguageObjectPeer::getInstanceFromPool($key))) {
			// We no longer rehydrate the object, since this can cause data loss.
			// See http://www.propelorm.org/ticket/509
			// $obj->hydrate($row, $startcol, true); // rehydrate
			$col = $startcol + LanguageObjectPeer::NUM_HYDRATE_COLUMNS;
		} else {
			$cls = LanguageObjectPeer::OM_CLASS;
			$obj = new $cls();
			$col = $obj->hydrate($row, $startcol);
			LanguageObjectPeer::addInstanceToPool($obj, $key);
		}
		return array($obj, $col);
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ContentObject table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinContentObject(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Language table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinLanguage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByCreatedBy table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinUserRelatedByCreatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByUpdatedBy table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinUserRelatedByUpdatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their ContentObject objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinContentObject(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;
		ContentObjectPeer::addSelectColumns($criteria);

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = ContentObjectPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = ContentObjectPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					ContentObjectPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (LanguageObject) to $obj2 (ContentObject)
				$obj2->addLanguageObject($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their Language objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinLanguage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;
		LanguagePeer::addSelectColumns($criteria);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = LanguagePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = LanguagePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					LanguagePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (LanguageObject) to $obj2 (Language)
				$obj2->addLanguageObject($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their User objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinUserRelatedByCreatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;
		UserPeer::addSelectColumns($criteria);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = UserPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = UserPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					UserPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (LanguageObject) to $obj2 (User)
				$obj2->addLanguageObjectRelatedByCreatedBy($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with their User objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinUserRelatedByUpdatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;
		UserPeer::addSelectColumns($criteria);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = UserPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = UserPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					UserPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (LanguageObject) to $obj2 (User)
				$obj2->addLanguageObjectRelatedByUpdatedBy($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining all related tables
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}

	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol2 = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;

		ContentObjectPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

		LanguagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + LanguagePeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + UserPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			// Add objects for joined ContentObject rows

			$key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = ContentObjectPeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = ContentObjectPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					ContentObjectPeer::addInstanceToPool($obj2, $key2);
				} // if obj2 loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj2 (ContentObject)
				$obj2->addLanguageObject($obj1);
			} // if joined row not null

			// Add objects for joined Language rows

			$key3 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = LanguagePeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$cls = LanguagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					LanguagePeer::addInstanceToPool($obj3, $key3);
				} // if obj3 loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj3 (Language)
				$obj3->addLanguageObject($obj1);
			} // if joined row not null

			// Add objects for joined User rows

			$key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
			if ($key4 !== null) {
				$obj4 = UserPeer::getInstanceFromPool($key4);
				if (!$obj4) {

					$cls = UserPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					UserPeer::addInstanceToPool($obj4, $key4);
				} // if obj4 loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj4 (User)
				$obj4->addLanguageObjectRelatedByCreatedBy($obj1);
			} // if joined row not null

			// Add objects for joined User rows

			$key5 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol5);
			if ($key5 !== null) {
				$obj5 = UserPeer::getInstanceFromPool($key5);
				if (!$obj5) {

					$cls = UserPeer::getOMClass(false);

					$obj5 = new $cls();
					$obj5->hydrate($row, $startcol5);
					UserPeer::addInstanceToPool($obj5, $key5);
				} // if obj5 loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj5 (User)
				$obj5->addLanguageObjectRelatedByUpdatedBy($obj1);
			} // if joined row not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related ContentObject table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptContentObject(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Language table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptLanguage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByCreatedBy table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptUserRelatedByCreatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related UserRelatedByUpdatedBy table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptUserRelatedByUpdatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			LanguageObjectPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; // no rows returned; we infer that means 0 matches.
		}
		$stmt->closeCursor();
		return $count;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except ContentObject.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptContentObject(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol2 = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;

		LanguagePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + LanguagePeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Language rows

				$key2 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = LanguagePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = LanguagePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					LanguagePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj2 (Language)
				$obj2->addLanguageObject($obj1);

			} // if joined row is not null

				// Add objects for joined User rows

				$key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = UserPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = UserPeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					UserPeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj3 (User)
				$obj3->addLanguageObjectRelatedByCreatedBy($obj1);

			} // if joined row is not null

				// Add objects for joined User rows

				$key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = UserPeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = UserPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					UserPeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj4 (User)
				$obj4->addLanguageObjectRelatedByUpdatedBy($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except Language.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptLanguage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol2 = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;

		ContentObjectPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::UPDATED_BY, UserPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined ContentObject rows

				$key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = ContentObjectPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = ContentObjectPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					ContentObjectPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj2 (ContentObject)
				$obj2->addLanguageObject($obj1);

			} // if joined row is not null

				// Add objects for joined User rows

				$key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = UserPeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = UserPeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					UserPeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj3 (User)
				$obj3->addLanguageObjectRelatedByCreatedBy($obj1);

			} // if joined row is not null

				// Add objects for joined User rows

				$key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
				if ($key4 !== null) {
					$obj4 = UserPeer::getInstanceFromPool($key4);
					if (!$obj4) {
	
						$cls = UserPeer::getOMClass(false);

					$obj4 = new $cls();
					$obj4->hydrate($row, $startcol4);
					UserPeer::addInstanceToPool($obj4, $key4);
				} // if $obj4 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj4 (User)
				$obj4->addLanguageObjectRelatedByUpdatedBy($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except UserRelatedByCreatedBy.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptUserRelatedByCreatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol2 = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;

		ContentObjectPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

		LanguagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + LanguagePeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined ContentObject rows

				$key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = ContentObjectPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = ContentObjectPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					ContentObjectPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj2 (ContentObject)
				$obj2->addLanguageObject($obj1);

			} // if joined row is not null

				// Add objects for joined Language rows

				$key3 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = LanguagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = LanguagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					LanguagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj3 (Language)
				$obj3->addLanguageObject($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of LanguageObject objects pre-filled with all related objects except UserRelatedByUpdatedBy.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of LanguageObject objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptUserRelatedByUpdatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		LanguageObjectPeer::addSelectColumns($criteria);
		$startcol2 = LanguageObjectPeer::NUM_HYDRATE_COLUMNS;

		ContentObjectPeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

		LanguagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + LanguagePeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(LanguageObjectPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

		$criteria->addJoin(LanguageObjectPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = LanguageObjectPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = LanguageObjectPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = LanguageObjectPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				LanguageObjectPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined ContentObject rows

				$key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = ContentObjectPeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = ContentObjectPeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					ContentObjectPeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj2 (ContentObject)
				$obj2->addLanguageObject($obj1);

			} // if joined row is not null

				// Add objects for joined Language rows

				$key3 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = LanguagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = LanguagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					LanguagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (LanguageObject) to the collection in $obj3 (Language)
				$obj3->addLanguageObject($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
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
	 * Add a TableMap instance to the database for this peer class.
	 */
	public static function buildTableMap()
	{
	  $dbMap = Propel::getDatabaseMap(BaseLanguageObjectPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BaseLanguageObjectPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new LanguageObjectTableMap());
	  }
	}

	/**
	 * The class that the Peer will make instances of.
	 *
	 * If $withPrefix is true, the returned path
	 * uses a dot-path notation which is tranalted into a path
	 * relative to a location on the PHP include_path.
	 * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
	 *
	 * @param      boolean $withPrefix Whether or not to return the path with the class name
	 * @return     string path.to.ClassName
	 */
	public static function getOMClass($withPrefix = true)
	{
		return $withPrefix ? LanguageObjectPeer::CLASS_DEFAULT : LanguageObjectPeer::OM_CLASS;
	}

	/**
	 * Performs an INSERT on the database, given a LanguageObject or Criteria object.
	 *
	 * @param      mixed $values Criteria or LanguageObject object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
			$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollBack();
			throw $e;
		}

		return $pk;
	}

	/**
	 * Performs an UPDATE on the database, given a LanguageObject or Criteria object.
	 *
	 * @param      mixed $values Criteria or LanguageObject object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(LanguageObjectPeer::OBJECT_ID);
			$value = $criteria->remove(LanguageObjectPeer::OBJECT_ID);
			if ($value) {
				$selectCriteria->add(LanguageObjectPeer::OBJECT_ID, $value, $comparison);
			} else {
				$selectCriteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);
			}

			$comparison = $criteria->getComparison(LanguageObjectPeer::LANGUAGE_ID);
			$value = $criteria->remove(LanguageObjectPeer::LANGUAGE_ID);
			if ($value) {
				$selectCriteria->add(LanguageObjectPeer::LANGUAGE_ID, $value, $comparison);
			} else {
				$selectCriteria->setPrimaryTableName(LanguageObjectPeer::TABLE_NAME);
			}

		} else { // $values is LanguageObject object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Deletes all rows from the language_objects table.
	 *
	 * @param      PropelPDO $con the connection to use
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll(PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(LanguageObjectPeer::TABLE_NAME, $con, LanguageObjectPeer::DATABASE_NAME);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			LanguageObjectPeer::clearInstancePool();
			LanguageObjectPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs a DELETE on the database, given a LanguageObject or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or LanguageObject object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 private static function doDeleteBeforeReferencing($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			LanguageObjectPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof LanguageObject) { // it's a model object
			// invalidate the cache for this single object
			LanguageObjectPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			// primary key is composite; we therefore, expect
			// the primary key passed to be an array of pkey values
			if (count($values) == count($values, COUNT_RECURSIVE)) {
				// array is not multi-dimensional
				$values = array($values);
			}
			foreach ($values as $value) {
				$criterion = $criteria->getNewCriterion(LanguageObjectPeer::OBJECT_ID, $value[0]);
				$criterion->addAnd($criteria->getNewCriterion(LanguageObjectPeer::LANGUAGE_ID, $value[1]));
				$criteria->addOr($criterion);
				// we can invalidate the cache for this single PK
				LanguageObjectPeer::removeInstanceFromPool($value);
			}
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			LanguageObjectPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
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
	public static function doValidate($obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(LanguageObjectPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(LanguageObjectPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
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
	 * @param      int $object_id
	 * @param      string $language_id
	 * @param      PropelPDO $con
	 * @return     LanguageObject
	 */
	public static function retrieveByPK($object_id, $language_id, PropelPDO $con = null) {
		$_instancePoolKey = serialize(array((string) $object_id, (string) $language_id));
 		if (null !== ($obj = LanguageObjectPeer::getInstanceFromPool($_instancePoolKey))) {
 			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$criteria = new Criteria(LanguageObjectPeer::DATABASE_NAME);
		$criteria->add(LanguageObjectPeer::OBJECT_ID, $object_id);
		$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $language_id);
		$v = LanguageObjectPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
	// referencing behavior
	public static function doDelete($values, PropelPDO $con = null) {
			if ($con === null) {
				$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
			}
	
			if($values instanceof Criteria) {
				// rename for clarity
				$criteria = clone $values;
			} elseif ($values instanceof LanguageObject) { // it's a model object
				// create criteria based on pk values
				$criteria = $values->buildPkeyCriteria();
			} else { // it's a primary key, or an array of pks
				$criteria = new Criteria(self::DATABASE_NAME);
				$criteria->add(PagePeer::ID, (array) $values, Criteria::IN);
			}
			
			foreach(LanguageObjectPeer::doSelect(clone $criteria, $con) as $object) {
				ReferencePeer::removeReferences($object);
			}
	
			return self::doDeleteBeforeReferencing($criteria, $con);
	}
	// denyable behavior
	public static function ignoreRights($bIgnore = true) {
		self::$IGNORE_RIGHTS = $bIgnore;
	}
	public static function isIgnoringRights() {
		return self::$IGNORE_RIGHTS;
	}
	public static function mayOperateOn($oUser, $mObject, $sOperation) {
		if($oUser === null) {
			return false;
		}
		if($oUser->getIsAdmin()) {
			return true;
		}
		return $oUser->getIsBackendLoginEnabled();
	}

} // BaseLanguageObjectPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseLanguageObjectPeer::buildTableMap();

