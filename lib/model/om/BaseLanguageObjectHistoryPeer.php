<?php


/**
 * Base static class for performing query and update operations on the 'language_object_history' table.
 *
 *
 *
 * @package propel.generator.model.om
 */
abstract class BaseLanguageObjectHistoryPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'rapila';

    /** the table name for this class */
    const TABLE_NAME = 'language_object_history';

    /** the related Propel class for this table */
    const OM_CLASS = 'LanguageObjectHistory';

    /** the related TableMap class for this table */
    const TM_CLASS = 'LanguageObjectHistoryTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 8;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    /** the column name for the object_id field */
    const OBJECT_ID = 'language_object_history.object_id';

    /** the column name for the language_id field */
    const LANGUAGE_ID = 'language_object_history.language_id';

    /** the column name for the data field */
    const DATA = 'language_object_history.data';

    /** the column name for the revision field */
    const REVISION = 'language_object_history.revision';

    /** the column name for the created_at field */
    const CREATED_AT = 'language_object_history.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'language_object_history.updated_at';

    /** the column name for the created_by field */
    const CREATED_BY = 'language_object_history.created_by';

    /** the column name for the updated_by field */
    const UPDATED_BY = 'language_object_history.updated_by';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of LanguageObjectHistory objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array LanguageObjectHistory[]
     */
    public static $instances = array();


    // denyable behavior
    private static $IGNORE_RIGHTS = false;
    private static $RIGHTS_USER = false;

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. LanguageObjectHistoryPeer::$fieldNames[LanguageObjectHistoryPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('ObjectId', 'LanguageId', 'Data', 'Revision', 'CreatedAt', 'UpdatedAt', 'CreatedBy', 'UpdatedBy', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('objectId', 'languageId', 'data', 'revision', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', ),
        BasePeer::TYPE_COLNAME => array (LanguageObjectHistoryPeer::OBJECT_ID, LanguageObjectHistoryPeer::LANGUAGE_ID, LanguageObjectHistoryPeer::DATA, LanguageObjectHistoryPeer::REVISION, LanguageObjectHistoryPeer::CREATED_AT, LanguageObjectHistoryPeer::UPDATED_AT, LanguageObjectHistoryPeer::CREATED_BY, LanguageObjectHistoryPeer::UPDATED_BY, ),
        BasePeer::TYPE_RAW_COLNAME => array ('OBJECT_ID', 'LANGUAGE_ID', 'DATA', 'REVISION', 'CREATED_AT', 'UPDATED_AT', 'CREATED_BY', 'UPDATED_BY', ),
        BasePeer::TYPE_FIELDNAME => array ('object_id', 'language_id', 'data', 'revision', 'created_at', 'updated_at', 'created_by', 'updated_by', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. LanguageObjectHistoryPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('ObjectId' => 0, 'LanguageId' => 1, 'Data' => 2, 'Revision' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, 'CreatedBy' => 6, 'UpdatedBy' => 7, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('objectId' => 0, 'languageId' => 1, 'data' => 2, 'revision' => 3, 'createdAt' => 4, 'updatedAt' => 5, 'createdBy' => 6, 'updatedBy' => 7, ),
        BasePeer::TYPE_COLNAME => array (LanguageObjectHistoryPeer::OBJECT_ID => 0, LanguageObjectHistoryPeer::LANGUAGE_ID => 1, LanguageObjectHistoryPeer::DATA => 2, LanguageObjectHistoryPeer::REVISION => 3, LanguageObjectHistoryPeer::CREATED_AT => 4, LanguageObjectHistoryPeer::UPDATED_AT => 5, LanguageObjectHistoryPeer::CREATED_BY => 6, LanguageObjectHistoryPeer::UPDATED_BY => 7, ),
        BasePeer::TYPE_RAW_COLNAME => array ('OBJECT_ID' => 0, 'LANGUAGE_ID' => 1, 'DATA' => 2, 'REVISION' => 3, 'CREATED_AT' => 4, 'UPDATED_AT' => 5, 'CREATED_BY' => 6, 'UPDATED_BY' => 7, ),
        BasePeer::TYPE_FIELDNAME => array ('object_id' => 0, 'language_id' => 1, 'data' => 2, 'revision' => 3, 'created_at' => 4, 'updated_at' => 5, 'created_by' => 6, 'updated_by' => 7, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = LanguageObjectHistoryPeer::getFieldNames($toType);
        $key = isset(LanguageObjectHistoryPeer::$fieldKeys[$fromType][$name]) ? LanguageObjectHistoryPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(LanguageObjectHistoryPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, LanguageObjectHistoryPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return LanguageObjectHistoryPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. LanguageObjectHistoryPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(LanguageObjectHistoryPeer::TABLE_NAME.'.', $alias.'.', $column);
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
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::OBJECT_ID);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::LANGUAGE_ID);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::DATA);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::REVISION);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::CREATED_AT);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::UPDATED_AT);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::CREATED_BY);
            $criteria->addSelectColumn(LanguageObjectHistoryPeer::UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.object_id');
            $criteria->addSelectColumn($alias . '.language_id');
            $criteria->addSelectColumn($alias . '.data');
            $criteria->addSelectColumn($alias . '.revision');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
            $criteria->addSelectColumn($alias . '.created_by');
            $criteria->addSelectColumn($alias . '.updated_by');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return LanguageObjectHistory
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = LanguageObjectHistoryPeer::doSelect($critcopy, $con);
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
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return LanguageObjectHistoryPeer::populateObjects(LanguageObjectHistoryPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

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
     * @param LanguageObjectHistory $obj A LanguageObjectHistory object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = serialize(array((string) $obj->getObjectId(), (string) $obj->getLanguageId(), (string) $obj->getRevision()));
            } // if key === null
            LanguageObjectHistoryPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A LanguageObjectHistory object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof LanguageObjectHistory) {
                $key = serialize(array((string) $value->getObjectId(), (string) $value->getLanguageId(), (string) $value->getRevision()));
            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key
                $key = serialize(array((string) $value[0], (string) $value[1], (string) $value[2]));
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or LanguageObjectHistory object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(LanguageObjectHistoryPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return LanguageObjectHistory Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(LanguageObjectHistoryPeer::$instances[$key])) {
                return LanguageObjectHistoryPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (LanguageObjectHistoryPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        LanguageObjectHistoryPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to language_object_history
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
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null && $row[$startcol + 1] === null && $row[$startcol + 3] === null) {
            return null;
        }

        return serialize(array((string) $row[$startcol], (string) $row[$startcol + 1], (string) $row[$startcol + 3]));
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return array((int) $row[$startcol], (string) $row[$startcol + 1], (int) $row[$startcol + 3]);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = LanguageObjectHistoryPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = LanguageObjectHistoryPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                LanguageObjectHistoryPeer::addInstanceToPool($obj, $key);
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
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (LanguageObjectHistory object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = LanguageObjectHistoryPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = LanguageObjectHistoryPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            LanguageObjectHistoryPeer::addInstanceToPool($obj, $key);
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
     * @return int Number of matching rows.
     */
    public static function doCountJoinContentObject(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinLanguage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinUserRelatedByCreatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinUserRelatedByUpdatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
     * Selects a collection of LanguageObjectHistory objects pre-filled with their ContentObject objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinContentObject(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;
        ContentObjectPeer::addSelectColumns($criteria);

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ContentObjectPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ContentObjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ContentObjectPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to $obj2 (ContentObject)
                $obj2->addLanguageObjectHistory($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of LanguageObjectHistory objects pre-filled with their Language objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinLanguage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;
        LanguagePeer::addSelectColumns($criteria);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = LanguagePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = LanguagePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    LanguagePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to $obj2 (Language)
                $obj2->addLanguageObjectHistory($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of LanguageObjectHistory objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUserRelatedByCreatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to $obj2 (User)
                $obj2->addLanguageObjectHistoryRelatedByCreatedBy($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of LanguageObjectHistory objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUserRelatedByUpdatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to $obj2 (User)
                $obj2->addLanguageObjectHistoryRelatedByUpdatedBy($obj1);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
     * Selects a collection of LanguageObjectHistory objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol2 = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;

        ContentObjectPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

        LanguagePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + LanguagePeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + UserPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined ContentObject rows

            $key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = ContentObjectPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ContentObjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ContentObjectPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj2 (ContentObject)
                $obj2->addLanguageObjectHistory($obj1);
            } // if joined row not null

            // Add objects for joined Language rows

            $key3 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = LanguagePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = LanguagePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    LanguagePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj3 (Language)
                $obj3->addLanguageObjectHistory($obj1);
            } // if joined row not null

            // Add objects for joined User rows

            $key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = UserPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = UserPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    UserPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj4 (User)
                $obj4->addLanguageObjectHistoryRelatedByCreatedBy($obj1);
            } // if joined row not null

            // Add objects for joined User rows

            $key5 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = UserPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = UserPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    UserPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj5 (User)
                $obj5->addLanguageObjectHistoryRelatedByUpdatedBy($obj1);
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
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptContentObject(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptLanguage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptUserRelatedByCreatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

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
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptUserRelatedByUpdatedBy(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            LanguageObjectHistoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

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
     * Selects a collection of LanguageObjectHistory objects pre-filled with all related objects except ContentObject.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptContentObject(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol2 = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;

        LanguagePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + LanguagePeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Language rows

                $key2 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = LanguagePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = LanguagePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    LanguagePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj2 (Language)
                $obj2->addLanguageObjectHistory($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = UserPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj3 (User)
                $obj3->addLanguageObjectHistoryRelatedByCreatedBy($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = UserPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = UserPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    UserPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj4 (User)
                $obj4->addLanguageObjectHistoryRelatedByUpdatedBy($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of LanguageObjectHistory objects pre-filled with all related objects except Language.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptLanguage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol2 = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;

        ContentObjectPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::UPDATED_BY, UserPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined ContentObject rows

                $key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = ContentObjectPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = ContentObjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ContentObjectPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj2 (ContentObject)
                $obj2->addLanguageObjectHistory($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = UserPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj3 (User)
                $obj3->addLanguageObjectHistoryRelatedByCreatedBy($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = UserPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = UserPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    UserPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj4 (User)
                $obj4->addLanguageObjectHistoryRelatedByUpdatedBy($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of LanguageObjectHistory objects pre-filled with all related objects except UserRelatedByCreatedBy.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptUserRelatedByCreatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol2 = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;

        ContentObjectPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

        LanguagePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + LanguagePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined ContentObject rows

                $key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = ContentObjectPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = ContentObjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ContentObjectPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj2 (ContentObject)
                $obj2->addLanguageObjectHistory($obj1);

            } // if joined row is not null

                // Add objects for joined Language rows

                $key3 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = LanguagePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = LanguagePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    LanguagePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj3 (Language)
                $obj3->addLanguageObjectHistory($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of LanguageObjectHistory objects pre-filled with all related objects except UserRelatedByUpdatedBy.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of LanguageObjectHistory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptUserRelatedByUpdatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);
        }

        LanguageObjectHistoryPeer::addSelectColumns($criteria);
        $startcol2 = LanguageObjectHistoryPeer::NUM_HYDRATE_COLUMNS;

        ContentObjectPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContentObjectPeer::NUM_HYDRATE_COLUMNS;

        LanguagePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + LanguagePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(LanguageObjectHistoryPeer::OBJECT_ID, ContentObjectPeer::ID, $join_behavior);

        $criteria->addJoin(LanguageObjectHistoryPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = LanguageObjectHistoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = LanguageObjectHistoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = LanguageObjectHistoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                LanguageObjectHistoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined ContentObject rows

                $key2 = ContentObjectPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = ContentObjectPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = ContentObjectPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ContentObjectPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj2 (ContentObject)
                $obj2->addLanguageObjectHistory($obj1);

            } // if joined row is not null

                // Add objects for joined Language rows

                $key3 = LanguagePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = LanguagePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = LanguagePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    LanguagePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (LanguageObjectHistory) to the collection in $obj3 (Language)
                $obj3->addLanguageObjectHistory($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(LanguageObjectHistoryPeer::DATABASE_NAME)->getTable(LanguageObjectHistoryPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseLanguageObjectHistoryPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseLanguageObjectHistoryPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \LanguageObjectHistoryTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return LanguageObjectHistoryPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a LanguageObjectHistory or Criteria object.
     *
     * @param      mixed $values Criteria or LanguageObjectHistory object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from LanguageObjectHistory object
        }


        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a LanguageObjectHistory or Criteria object.
     *
     * @param      mixed $values Criteria or LanguageObjectHistory object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(LanguageObjectHistoryPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(LanguageObjectHistoryPeer::OBJECT_ID);
            $value = $criteria->remove(LanguageObjectHistoryPeer::OBJECT_ID);
            if ($value) {
                $selectCriteria->add(LanguageObjectHistoryPeer::OBJECT_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);
            }

            $comparison = $criteria->getComparison(LanguageObjectHistoryPeer::LANGUAGE_ID);
            $value = $criteria->remove(LanguageObjectHistoryPeer::LANGUAGE_ID);
            if ($value) {
                $selectCriteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);
            }

            $comparison = $criteria->getComparison(LanguageObjectHistoryPeer::REVISION);
            $value = $criteria->remove(LanguageObjectHistoryPeer::REVISION);
            if ($value) {
                $selectCriteria->add(LanguageObjectHistoryPeer::REVISION, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(LanguageObjectHistoryPeer::TABLE_NAME);
            }

        } else { // $values is LanguageObjectHistory object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the language_object_history table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(LanguageObjectHistoryPeer::TABLE_NAME, $con, LanguageObjectHistoryPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LanguageObjectHistoryPeer::clearInstancePool();
            LanguageObjectHistoryPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a LanguageObjectHistory or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or LanguageObjectHistory object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            LanguageObjectHistoryPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof LanguageObjectHistory) { // it's a model object
            // invalidate the cache for this single object
            LanguageObjectHistoryPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(LanguageObjectHistoryPeer::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(LanguageObjectHistoryPeer::OBJECT_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(LanguageObjectHistoryPeer::LANGUAGE_ID, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(LanguageObjectHistoryPeer::REVISION, $value[2]));
                $criteria->addOr($criterion);
                // we can invalidate the cache for this single PK
                LanguageObjectHistoryPeer::removeInstanceFromPool($value);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(LanguageObjectHistoryPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            LanguageObjectHistoryPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given LanguageObjectHistory object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param LanguageObjectHistory $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(LanguageObjectHistoryPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(LanguageObjectHistoryPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(LanguageObjectHistoryPeer::DATABASE_NAME, LanguageObjectHistoryPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve object using using composite pkey values.
     * @param   int $object_id
     * @param   string $language_id
     * @param   int $revision
     * @param      PropelPDO $con
     * @return LanguageObjectHistory
     */
    public static function retrieveByPK($object_id, $language_id, $revision, PropelPDO $con = null) {
        $_instancePoolKey = serialize(array((string) $object_id, (string) $language_id, (string) $revision));
         if (null !== ($obj = LanguageObjectHistoryPeer::getInstanceFromPool($_instancePoolKey))) {
             return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(LanguageObjectHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $criteria = new Criteria(LanguageObjectHistoryPeer::DATABASE_NAME);
        $criteria->add(LanguageObjectHistoryPeer::OBJECT_ID, $object_id);
        $criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $language_id);
        $criteria->add(LanguageObjectHistoryPeer::REVISION, $revision);
        $v = LanguageObjectHistoryPeer::doSelect($criteria, $con);

        return !empty($v) ? $v[0] : null;
    }
    // denyable behavior
    public static function ignoreRights($bIgnore = true) {
        self::$IGNORE_RIGHTS = $bIgnore;
    }
    public static function isIgnoringRights() {
        return self::$IGNORE_RIGHTS || PHP_SAPI === "cli";
    }
    public static function setRightsUser($oUser = false) {
        self::$RIGHTS_USER = $oUser;
    }
    public static function getRightsUser($oUser = false) {
        if($oUser === false) {
            $oUser = self::$RIGHTS_USER;
        }
        if($oUser === false) {
            $oUser = Session::getSession()->getUser();
        }
        return $oUser;
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
    public static function mayOperateOnOwn($oUser, $mObject, $sOperation) {
        return false;
    }

} // BaseLanguageObjectHistoryPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseLanguageObjectHistoryPeer::buildTableMap();

