<?php


/**
 * Base static class for performing query and update operations on the 'rights' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BaseRightPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'rapila';

	/** the table name for this class */
	const TABLE_NAME = 'rights';

	/** the related Propel class for this table */
	const OM_CLASS = 'Right';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'model.Right';

	/** the related TableMap class for this table */
	const TM_CLASS = 'RightTableMap';

	/** The total number of columns. */
	const NUM_COLUMNS = 13;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
	const NUM_HYDRATE_COLUMNS = 13;

	/** the column name for the ID field */
	const ID = 'rights.ID';

	/** the column name for the ROLE_KEY field */
	const ROLE_KEY = 'rights.ROLE_KEY';

	/** the column name for the PAGE_ID field */
	const PAGE_ID = 'rights.PAGE_ID';

	/** the column name for the IS_INHERITED field */
	const IS_INHERITED = 'rights.IS_INHERITED';

	/** the column name for the MAY_EDIT_PAGE_DETAILS field */
	const MAY_EDIT_PAGE_DETAILS = 'rights.MAY_EDIT_PAGE_DETAILS';

	/** the column name for the MAY_EDIT_PAGE_CONTENTS field */
	const MAY_EDIT_PAGE_CONTENTS = 'rights.MAY_EDIT_PAGE_CONTENTS';

	/** the column name for the MAY_DELETE field */
	const MAY_DELETE = 'rights.MAY_DELETE';

	/** the column name for the MAY_CREATE_CHILDREN field */
	const MAY_CREATE_CHILDREN = 'rights.MAY_CREATE_CHILDREN';

	/** the column name for the MAY_VIEW_PAGE field */
	const MAY_VIEW_PAGE = 'rights.MAY_VIEW_PAGE';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'rights.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'rights.UPDATED_AT';

	/** the column name for the CREATED_BY field */
	const CREATED_BY = 'rights.CREATED_BY';

	/** the column name for the UPDATED_BY field */
	const UPDATED_BY = 'rights.UPDATED_BY';

	/** The default string format for model objects of the related table **/
	const DEFAULT_STRING_FORMAT = 'YAML';

	/**
	 * An identiy map to hold any loaded instances of Right objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array Right[]
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
		BasePeer::TYPE_PHPNAME => array ('Id', 'RoleKey', 'PageId', 'IsInherited', 'MayEditPageDetails', 'MayEditPageContents', 'MayDelete', 'MayCreateChildren', 'MayViewPage', 'CreatedAt', 'UpdatedAt', 'CreatedBy', 'UpdatedBy', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'roleKey', 'pageId', 'isInherited', 'mayEditPageDetails', 'mayEditPageContents', 'mayDelete', 'mayCreateChildren', 'mayViewPage', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::ROLE_KEY, self::PAGE_ID, self::IS_INHERITED, self::MAY_EDIT_PAGE_DETAILS, self::MAY_EDIT_PAGE_CONTENTS, self::MAY_DELETE, self::MAY_CREATE_CHILDREN, self::MAY_VIEW_PAGE, self::CREATED_AT, self::UPDATED_AT, self::CREATED_BY, self::UPDATED_BY, ),
		BasePeer::TYPE_RAW_COLNAME => array ('ID', 'ROLE_KEY', 'PAGE_ID', 'IS_INHERITED', 'MAY_EDIT_PAGE_DETAILS', 'MAY_EDIT_PAGE_CONTENTS', 'MAY_DELETE', 'MAY_CREATE_CHILDREN', 'MAY_VIEW_PAGE', 'CREATED_AT', 'UPDATED_AT', 'CREATED_BY', 'UPDATED_BY', ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'role_key', 'page_id', 'is_inherited', 'may_edit_page_details', 'may_edit_page_contents', 'may_delete', 'may_create_children', 'may_view_page', 'created_at', 'updated_at', 'created_by', 'updated_by', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	protected static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'RoleKey' => 1, 'PageId' => 2, 'IsInherited' => 3, 'MayEditPageDetails' => 4, 'MayEditPageContents' => 5, 'MayDelete' => 6, 'MayCreateChildren' => 7, 'MayViewPage' => 8, 'CreatedAt' => 9, 'UpdatedAt' => 10, 'CreatedBy' => 11, 'UpdatedBy' => 12, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'roleKey' => 1, 'pageId' => 2, 'isInherited' => 3, 'mayEditPageDetails' => 4, 'mayEditPageContents' => 5, 'mayDelete' => 6, 'mayCreateChildren' => 7, 'mayViewPage' => 8, 'createdAt' => 9, 'updatedAt' => 10, 'createdBy' => 11, 'updatedBy' => 12, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::ROLE_KEY => 1, self::PAGE_ID => 2, self::IS_INHERITED => 3, self::MAY_EDIT_PAGE_DETAILS => 4, self::MAY_EDIT_PAGE_CONTENTS => 5, self::MAY_DELETE => 6, self::MAY_CREATE_CHILDREN => 7, self::MAY_VIEW_PAGE => 8, self::CREATED_AT => 9, self::UPDATED_AT => 10, self::CREATED_BY => 11, self::UPDATED_BY => 12, ),
		BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'ROLE_KEY' => 1, 'PAGE_ID' => 2, 'IS_INHERITED' => 3, 'MAY_EDIT_PAGE_DETAILS' => 4, 'MAY_EDIT_PAGE_CONTENTS' => 5, 'MAY_DELETE' => 6, 'MAY_CREATE_CHILDREN' => 7, 'MAY_VIEW_PAGE' => 8, 'CREATED_AT' => 9, 'UPDATED_AT' => 10, 'CREATED_BY' => 11, 'UPDATED_BY' => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'role_key' => 1, 'page_id' => 2, 'is_inherited' => 3, 'may_edit_page_details' => 4, 'may_edit_page_contents' => 5, 'may_delete' => 6, 'may_create_children' => 7, 'may_view_page' => 8, 'created_at' => 9, 'updated_at' => 10, 'created_by' => 11, 'updated_by' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
	 * @param      string $column The column name for current table. (i.e. RightPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(RightPeer::TABLE_NAME.'.', $alias.'.', $column);
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
			$criteria->addSelectColumn(RightPeer::ID);
			$criteria->addSelectColumn(RightPeer::ROLE_KEY);
			$criteria->addSelectColumn(RightPeer::PAGE_ID);
			$criteria->addSelectColumn(RightPeer::IS_INHERITED);
			$criteria->addSelectColumn(RightPeer::MAY_EDIT_PAGE_DETAILS);
			$criteria->addSelectColumn(RightPeer::MAY_EDIT_PAGE_CONTENTS);
			$criteria->addSelectColumn(RightPeer::MAY_DELETE);
			$criteria->addSelectColumn(RightPeer::MAY_CREATE_CHILDREN);
			$criteria->addSelectColumn(RightPeer::MAY_VIEW_PAGE);
			$criteria->addSelectColumn(RightPeer::CREATED_AT);
			$criteria->addSelectColumn(RightPeer::UPDATED_AT);
			$criteria->addSelectColumn(RightPeer::CREATED_BY);
			$criteria->addSelectColumn(RightPeer::UPDATED_BY);
		} else {
			$criteria->addSelectColumn($alias . '.ID');
			$criteria->addSelectColumn($alias . '.ROLE_KEY');
			$criteria->addSelectColumn($alias . '.PAGE_ID');
			$criteria->addSelectColumn($alias . '.IS_INHERITED');
			$criteria->addSelectColumn($alias . '.MAY_EDIT_PAGE_DETAILS');
			$criteria->addSelectColumn($alias . '.MAY_EDIT_PAGE_CONTENTS');
			$criteria->addSelectColumn($alias . '.MAY_DELETE');
			$criteria->addSelectColumn($alias . '.MAY_CREATE_CHILDREN');
			$criteria->addSelectColumn($alias . '.MAY_VIEW_PAGE');
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
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return     Right
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = RightPeer::doSelect($critcopy, $con);
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
		return RightPeer::populateObjects(RightPeer::doSelectStmt($criteria, $con));
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
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			RightPeer::addSelectColumns($criteria);
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
	 * @param      Right $value A Right object.
	 * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
	 */
	public static function addInstanceToPool($obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
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
	 * @param      mixed $value A Right object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof Right) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Right object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	 * @return     Right Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
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
	 * Method to invalidate the instance pool of all tables related to rights
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
		if ($row[$startcol] === null) {
			return null;
		}
		return (string) $row[$startcol];
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
		return (int) $row[$startcol];
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
		$cls = RightPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = RightPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				RightPeer::addInstanceToPool($obj, $key);
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
	 * @return     array (Right object, last column rank)
	 */
	public static function populateObject($row, $startcol = 0)
	{
		$key = RightPeer::getPrimaryKeyHashFromRow($row, $startcol);
		if (null !== ($obj = RightPeer::getInstanceFromPool($key))) {
			// We no longer rehydrate the object, since this can cause data loss.
			// See http://www.propelorm.org/ticket/509
			// $obj->hydrate($row, $startcol, true); // rehydrate
			$col = $startcol + RightPeer::NUM_HYDRATE_COLUMNS;
		} else {
			$cls = RightPeer::OM_CLASS;
			$obj = new $cls();
			$col = $obj->hydrate($row, $startcol);
			RightPeer::addInstanceToPool($obj, $key);
		}
		return array($obj, $col);
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Role table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinRole(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

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
	 * Returns the number of rows matching criteria, joining the related Page table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinPage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

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
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

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
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
	 * Selects a collection of Right objects pre-filled with their Role objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinRole(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		RightPeer::addSelectColumns($criteria);
		$startcol = RightPeer::NUM_HYDRATE_COLUMNS;
		RolePeer::addSelectColumns($criteria);

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = RolePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = RolePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = RolePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					RolePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (Right) to $obj2 (Role)
				$obj2->addRight($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of Right objects pre-filled with their Page objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinPage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		RightPeer::addSelectColumns($criteria);
		$startcol = RightPeer::NUM_HYDRATE_COLUMNS;
		PagePeer::addSelectColumns($criteria);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if $obj1 already loaded

			$key2 = PagePeer::getPrimaryKeyHashFromRow($row, $startcol);
			if ($key2 !== null) {
				$obj2 = PagePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = PagePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol);
					PagePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 already loaded

				// Add the $obj1 (Right) to $obj2 (Page)
				$obj2->addRight($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of Right objects pre-filled with their User objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
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

		RightPeer::addSelectColumns($criteria);
		$startcol = RightPeer::NUM_HYDRATE_COLUMNS;
		UserPeer::addSelectColumns($criteria);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
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

				// Add the $obj1 (Right) to $obj2 (User)
				$obj2->addRightRelatedByCreatedBy($obj1);

			} // if joined row was not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of Right objects pre-filled with their User objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
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

		RightPeer::addSelectColumns($criteria);
		$startcol = RightPeer::NUM_HYDRATE_COLUMNS;
		UserPeer::addSelectColumns($criteria);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
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

				// Add the $obj1 (Right) to $obj2 (User)
				$obj2->addRightRelatedByUpdatedBy($obj1);

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
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
	 * Selects a collection of Right objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
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

		RightPeer::addSelectColumns($criteria);
		$startcol2 = RightPeer::NUM_HYDRATE_COLUMNS;

		RolePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + RolePeer::NUM_HYDRATE_COLUMNS;

		PagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + PagePeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol6 = $startcol5 + UserPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

			// Add objects for joined Role rows

			$key2 = RolePeer::getPrimaryKeyHashFromRow($row, $startcol2);
			if ($key2 !== null) {
				$obj2 = RolePeer::getInstanceFromPool($key2);
				if (!$obj2) {

					$cls = RolePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					RolePeer::addInstanceToPool($obj2, $key2);
				} // if obj2 loaded

				// Add the $obj1 (Right) to the collection in $obj2 (Role)
				$obj2->addRight($obj1);
			} // if joined row not null

			// Add objects for joined Page rows

			$key3 = PagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
			if ($key3 !== null) {
				$obj3 = PagePeer::getInstanceFromPool($key3);
				if (!$obj3) {

					$cls = PagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PagePeer::addInstanceToPool($obj3, $key3);
				} // if obj3 loaded

				// Add the $obj1 (Right) to the collection in $obj3 (Page)
				$obj3->addRight($obj1);
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

				// Add the $obj1 (Right) to the collection in $obj4 (User)
				$obj4->addRightRelatedByCreatedBy($obj1);
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

				// Add the $obj1 (Right) to the collection in $obj5 (User)
				$obj5->addRightRelatedByUpdatedBy($obj1);
			} // if joined row not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Returns the number of rows matching criteria, joining the related Role table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptRole(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
	 * Returns the number of rows matching criteria, joining the related Page table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinAllExceptPage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

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
		$criteria->setPrimaryTableName(RightPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			RightPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY should not affect count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
	
		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

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
	 * Selects a collection of Right objects pre-filled with all related objects except Role.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptRole(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		RightPeer::addSelectColumns($criteria);
		$startcol2 = RightPeer::NUM_HYDRATE_COLUMNS;

		PagePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + PagePeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Page rows

				$key2 = PagePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = PagePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = PagePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					PagePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (Right) to the collection in $obj2 (Page)
				$obj2->addRight($obj1);

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

				// Add the $obj1 (Right) to the collection in $obj3 (User)
				$obj3->addRightRelatedByCreatedBy($obj1);

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

				// Add the $obj1 (Right) to the collection in $obj4 (User)
				$obj4->addRightRelatedByUpdatedBy($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of Right objects pre-filled with all related objects except Page.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinAllExceptPage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		// $criteria->getDbName() will return the same object if not set to another value
		// so == check is okay and faster
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		RightPeer::addSelectColumns($criteria);
		$startcol2 = RightPeer::NUM_HYDRATE_COLUMNS;

		RolePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + RolePeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

		UserPeer::addSelectColumns($criteria);
		$startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::CREATED_BY, UserPeer::ID, $join_behavior);

		$criteria->addJoin(RightPeer::UPDATED_BY, UserPeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Role rows

				$key2 = RolePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = RolePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = RolePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					RolePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (Right) to the collection in $obj2 (Role)
				$obj2->addRight($obj1);

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

				// Add the $obj1 (Right) to the collection in $obj3 (User)
				$obj3->addRightRelatedByCreatedBy($obj1);

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

				// Add the $obj1 (Right) to the collection in $obj4 (User)
				$obj4->addRightRelatedByUpdatedBy($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of Right objects pre-filled with all related objects except UserRelatedByCreatedBy.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
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

		RightPeer::addSelectColumns($criteria);
		$startcol2 = RightPeer::NUM_HYDRATE_COLUMNS;

		RolePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + RolePeer::NUM_HYDRATE_COLUMNS;

		PagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + PagePeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Role rows

				$key2 = RolePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = RolePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = RolePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					RolePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (Right) to the collection in $obj2 (Role)
				$obj2->addRight($obj1);

			} // if joined row is not null

				// Add objects for joined Page rows

				$key3 = PagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = PagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (Right) to the collection in $obj3 (Page)
				$obj3->addRight($obj1);

			} // if joined row is not null

			$results[] = $obj1;
		}
		$stmt->closeCursor();
		return $results;
	}


	/**
	 * Selects a collection of Right objects pre-filled with all related objects except UserRelatedByUpdatedBy.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of Right objects.
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

		RightPeer::addSelectColumns($criteria);
		$startcol2 = RightPeer::NUM_HYDRATE_COLUMNS;

		RolePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + RolePeer::NUM_HYDRATE_COLUMNS;

		PagePeer::addSelectColumns($criteria);
		$startcol4 = $startcol3 + PagePeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(RightPeer::ROLE_KEY, RolePeer::ROLE_KEY, $join_behavior);

		$criteria->addJoin(RightPeer::PAGE_ID, PagePeer::ID, $join_behavior);


		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = RightPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = RightPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = RightPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				RightPeer::addInstanceToPool($obj1, $key1);
			} // if obj1 already loaded

				// Add objects for joined Role rows

				$key2 = RolePeer::getPrimaryKeyHashFromRow($row, $startcol2);
				if ($key2 !== null) {
					$obj2 = RolePeer::getInstanceFromPool($key2);
					if (!$obj2) {
	
						$cls = RolePeer::getOMClass(false);

					$obj2 = new $cls();
					$obj2->hydrate($row, $startcol2);
					RolePeer::addInstanceToPool($obj2, $key2);
				} // if $obj2 already loaded

				// Add the $obj1 (Right) to the collection in $obj2 (Role)
				$obj2->addRight($obj1);

			} // if joined row is not null

				// Add objects for joined Page rows

				$key3 = PagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
				if ($key3 !== null) {
					$obj3 = PagePeer::getInstanceFromPool($key3);
					if (!$obj3) {
	
						$cls = PagePeer::getOMClass(false);

					$obj3 = new $cls();
					$obj3->hydrate($row, $startcol3);
					PagePeer::addInstanceToPool($obj3, $key3);
				} // if $obj3 already loaded

				// Add the $obj1 (Right) to the collection in $obj3 (Page)
				$obj3->addRight($obj1);

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
	  $dbMap = Propel::getDatabaseMap(BaseRightPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BaseRightPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new RightTableMap());
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
		return $withPrefix ? RightPeer::CLASS_DEFAULT : RightPeer::OM_CLASS;
	}

	/**
	 * Performs an INSERT on the database, given a Right or Criteria object.
	 *
	 * @param      mixed $values Criteria or Right object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from Right object
		}

		if ($criteria->containsKey(RightPeer::ID) && $criteria->keyContainsValue(RightPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.RightPeer::ID.')');
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
	 * Performs an UPDATE on the database, given a Right or Criteria object.
	 *
	 * @param      mixed $values Criteria or Right object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(RightPeer::ID);
			$value = $criteria->remove(RightPeer::ID);
			if ($value) {
				$selectCriteria->add(RightPeer::ID, $value, $comparison);
			} else {
				$selectCriteria->setPrimaryTableName(RightPeer::TABLE_NAME);
			}

		} else { // $values is Right object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Deletes all rows from the rights table.
	 *
	 * @param      PropelPDO $con the connection to use
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll(PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(RightPeer::TABLE_NAME, $con, RightPeer::DATABASE_NAME);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			RightPeer::clearInstancePool();
			RightPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs a DELETE on the database, given a Right or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or Right object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// invalidate the cache for all objects of this type, since we have no
			// way of knowing (without running a query) what objects should be invalidated
			// from the cache based on this Criteria.
			RightPeer::clearInstancePool();
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof Right) { // it's a model object
			// invalidate the cache for this single object
			RightPeer::removeInstanceFromPool($values);
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(RightPeer::ID, (array) $values, Criteria::IN);
			// invalidate the cache for this object(s)
			foreach ((array) $values as $singleval) {
				RightPeer::removeInstanceFromPool($singleval);
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
			RightPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Validates all modified columns of given Right object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      Right $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate($obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(RightPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(RightPeer::TABLE_NAME);

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

		return BasePeer::doValidate(RightPeer::DATABASE_NAME, RightPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     Right
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = RightPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(RightPeer::DATABASE_NAME);
		$criteria->add(RightPeer::ID, $pk);

		$v = RightPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	/**
	 * Retrieve multiple objects by pkey.
	 *
	 * @param      array $pks List of primary keys
	 * @param      PropelPDO $con the connection to use
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(RightPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(RightPeer::DATABASE_NAME);
			$criteria->add(RightPeer::ID, $pks, Criteria::IN);
			$objs = RightPeer::doSelect($criteria, $con);
		}
		return $objs;
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
		if($oUser->hasRole("users")) {
			return true;
		}
		if(!$oUser->hasRole("users-own")) {
			return false;
		}
		if($sOperation === "insert") {
			return true;
		}
		if($mObject instanceof User) {
			return $mObject->getId() === $oUser->getId();
		}
		return $mObject->getCreatedBy() === $oUser->getId();
	}

} // BaseRightPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseRightPeer::buildTableMap();

