<?php


/**
 * Base static class for performing query and update operations on the 'pages' table.
 *
 *
 *
 * @package propel.generator.model.om
 */
abstract class BasePagePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'rapila';

    /** the table name for this class */
    const TABLE_NAME = 'pages';

    /** the related Propel class for this table */
    const OM_CLASS = 'Page';

    /** the related TableMap class for this table */
    const TM_CLASS = 'PageTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 17;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 17;

    /** the column name for the id field */
    const ID = 'pages.id';

    /** the column name for the name field */
    const NAME = 'pages.name';

    /** the column name for the identifier field */
    const IDENTIFIER = 'pages.identifier';

    /** the column name for the page_type field */
    const PAGE_TYPE = 'pages.page_type';

    /** the column name for the template_name field */
    const TEMPLATE_NAME = 'pages.template_name';

    /** the column name for the is_inactive field */
    const IS_INACTIVE = 'pages.is_inactive';

    /** the column name for the is_folder field */
    const IS_FOLDER = 'pages.is_folder';

    /** the column name for the is_hidden field */
    const IS_HIDDEN = 'pages.is_hidden';

    /** the column name for the is_protected field */
    const IS_PROTECTED = 'pages.is_protected';

    /** the column name for the canonical_id field */
    const CANONICAL_ID = 'pages.canonical_id';

    /** the column name for the tree_left field */
    const TREE_LEFT = 'pages.tree_left';

    /** the column name for the tree_right field */
    const TREE_RIGHT = 'pages.tree_right';

    /** the column name for the tree_level field */
    const TREE_LEVEL = 'pages.tree_level';

    /** the column name for the created_at field */
    const CREATED_AT = 'pages.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'pages.updated_at';

    /** the column name for the created_by field */
    const CREATED_BY = 'pages.created_by';

    /** the column name for the updated_by field */
    const UPDATED_BY = 'pages.updated_by';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Page objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Page[]
     */
    public static $instances = array();


    // denyable behavior
    private static $IGNORE_RIGHTS = false;
    private static $RIGHTS_USER = false;

    // nested_set behavior

    /**
     * Left column for the set
     */
    const LEFT_COL = 'pages.tree_left';

    /**
     * Right column for the set
     */
    const RIGHT_COL = 'pages.tree_right';

    /**
     * Level column for the set
     */
    const LEVEL_COL = 'pages.tree_level';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. PagePeer::$fieldNames[PagePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'Identifier', 'PageType', 'TemplateName', 'IsInactive', 'IsFolder', 'IsHidden', 'IsProtected', 'CanonicalId', 'TreeLeft', 'TreeRight', 'TreeLevel', 'CreatedAt', 'UpdatedAt', 'CreatedBy', 'UpdatedBy', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'name', 'identifier', 'pageType', 'templateName', 'isInactive', 'isFolder', 'isHidden', 'isProtected', 'canonicalId', 'treeLeft', 'treeRight', 'treeLevel', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', ),
        BasePeer::TYPE_COLNAME => array (PagePeer::ID, PagePeer::NAME, PagePeer::IDENTIFIER, PagePeer::PAGE_TYPE, PagePeer::TEMPLATE_NAME, PagePeer::IS_INACTIVE, PagePeer::IS_FOLDER, PagePeer::IS_HIDDEN, PagePeer::IS_PROTECTED, PagePeer::CANONICAL_ID, PagePeer::TREE_LEFT, PagePeer::TREE_RIGHT, PagePeer::TREE_LEVEL, PagePeer::CREATED_AT, PagePeer::UPDATED_AT, PagePeer::CREATED_BY, PagePeer::UPDATED_BY, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'NAME', 'IDENTIFIER', 'PAGE_TYPE', 'TEMPLATE_NAME', 'IS_INACTIVE', 'IS_FOLDER', 'IS_HIDDEN', 'IS_PROTECTED', 'CANONICAL_ID', 'TREE_LEFT', 'TREE_RIGHT', 'TREE_LEVEL', 'CREATED_AT', 'UPDATED_AT', 'CREATED_BY', 'UPDATED_BY', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'identifier', 'page_type', 'template_name', 'is_inactive', 'is_folder', 'is_hidden', 'is_protected', 'canonical_id', 'tree_left', 'tree_right', 'tree_level', 'created_at', 'updated_at', 'created_by', 'updated_by', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. PagePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'Identifier' => 2, 'PageType' => 3, 'TemplateName' => 4, 'IsInactive' => 5, 'IsFolder' => 6, 'IsHidden' => 7, 'IsProtected' => 8, 'CanonicalId' => 9, 'TreeLeft' => 10, 'TreeRight' => 11, 'TreeLevel' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, 'CreatedBy' => 15, 'UpdatedBy' => 16, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'name' => 1, 'identifier' => 2, 'pageType' => 3, 'templateName' => 4, 'isInactive' => 5, 'isFolder' => 6, 'isHidden' => 7, 'isProtected' => 8, 'canonicalId' => 9, 'treeLeft' => 10, 'treeRight' => 11, 'treeLevel' => 12, 'createdAt' => 13, 'updatedAt' => 14, 'createdBy' => 15, 'updatedBy' => 16, ),
        BasePeer::TYPE_COLNAME => array (PagePeer::ID => 0, PagePeer::NAME => 1, PagePeer::IDENTIFIER => 2, PagePeer::PAGE_TYPE => 3, PagePeer::TEMPLATE_NAME => 4, PagePeer::IS_INACTIVE => 5, PagePeer::IS_FOLDER => 6, PagePeer::IS_HIDDEN => 7, PagePeer::IS_PROTECTED => 8, PagePeer::CANONICAL_ID => 9, PagePeer::TREE_LEFT => 10, PagePeer::TREE_RIGHT => 11, PagePeer::TREE_LEVEL => 12, PagePeer::CREATED_AT => 13, PagePeer::UPDATED_AT => 14, PagePeer::CREATED_BY => 15, PagePeer::UPDATED_BY => 16, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'NAME' => 1, 'IDENTIFIER' => 2, 'PAGE_TYPE' => 3, 'TEMPLATE_NAME' => 4, 'IS_INACTIVE' => 5, 'IS_FOLDER' => 6, 'IS_HIDDEN' => 7, 'IS_PROTECTED' => 8, 'CANONICAL_ID' => 9, 'TREE_LEFT' => 10, 'TREE_RIGHT' => 11, 'TREE_LEVEL' => 12, 'CREATED_AT' => 13, 'UPDATED_AT' => 14, 'CREATED_BY' => 15, 'UPDATED_BY' => 16, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'identifier' => 2, 'page_type' => 3, 'template_name' => 4, 'is_inactive' => 5, 'is_folder' => 6, 'is_hidden' => 7, 'is_protected' => 8, 'canonical_id' => 9, 'tree_left' => 10, 'tree_right' => 11, 'tree_level' => 12, 'created_at' => 13, 'updated_at' => 14, 'created_by' => 15, 'updated_by' => 16, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
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
        $toNames = PagePeer::getFieldNames($toType);
        $key = isset(PagePeer::$fieldKeys[$fromType][$name]) ? PagePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(PagePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, PagePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return PagePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. PagePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(PagePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(PagePeer::ID);
            $criteria->addSelectColumn(PagePeer::NAME);
            $criteria->addSelectColumn(PagePeer::IDENTIFIER);
            $criteria->addSelectColumn(PagePeer::PAGE_TYPE);
            $criteria->addSelectColumn(PagePeer::TEMPLATE_NAME);
            $criteria->addSelectColumn(PagePeer::IS_INACTIVE);
            $criteria->addSelectColumn(PagePeer::IS_FOLDER);
            $criteria->addSelectColumn(PagePeer::IS_HIDDEN);
            $criteria->addSelectColumn(PagePeer::IS_PROTECTED);
            $criteria->addSelectColumn(PagePeer::CANONICAL_ID);
            $criteria->addSelectColumn(PagePeer::TREE_LEFT);
            $criteria->addSelectColumn(PagePeer::TREE_RIGHT);
            $criteria->addSelectColumn(PagePeer::TREE_LEVEL);
            $criteria->addSelectColumn(PagePeer::CREATED_AT);
            $criteria->addSelectColumn(PagePeer::UPDATED_AT);
            $criteria->addSelectColumn(PagePeer::CREATED_BY);
            $criteria->addSelectColumn(PagePeer::UPDATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.identifier');
            $criteria->addSelectColumn($alias . '.page_type');
            $criteria->addSelectColumn($alias . '.template_name');
            $criteria->addSelectColumn($alias . '.is_inactive');
            $criteria->addSelectColumn($alias . '.is_folder');
            $criteria->addSelectColumn($alias . '.is_hidden');
            $criteria->addSelectColumn($alias . '.is_protected');
            $criteria->addSelectColumn($alias . '.canonical_id');
            $criteria->addSelectColumn($alias . '.tree_left');
            $criteria->addSelectColumn($alias . '.tree_right');
            $criteria->addSelectColumn($alias . '.tree_level');
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
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(PagePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Page
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = PagePeer::doSelect($critcopy, $con);
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
        return PagePeer::populateObjects(PagePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            PagePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

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
     * @param Page $obj A Page object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            PagePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Page object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Page) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Page object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(PagePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Page Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(PagePeer::$instances[$key])) {
                return PagePeer::$instances[$key];
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
        foreach (PagePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        PagePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to pages
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in PagePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PagePeer::clearInstancePool();
        // Invalidate objects in PagePropertyPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PagePropertyPeer::clearInstancePool();
        // Invalidate objects in PageStringPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PageStringPeer::clearInstancePool();
        // Invalidate objects in ContentObjectPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ContentObjectPeer::clearInstancePool();
        // Invalidate objects in RightPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RightPeer::clearInstancePool();
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
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
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
        $cls = PagePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = PagePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PagePeer::addInstanceToPool($obj, $key);
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
     * @return array (Page object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = PagePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = PagePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + PagePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PagePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            PagePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PagePeer::CREATED_BY, UserPeer::ID, $join_behavior);

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
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PagePeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
     * Selects a collection of Page objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Page objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUserRelatedByCreatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PagePeer::DATABASE_NAME);
        }

        PagePeer::addSelectColumns($criteria);
        $startcol = PagePeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(PagePeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PagePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PagePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PagePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Page) to $obj2 (User)
                $obj2->addPageRelatedByCreatedBy($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Page objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Page objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUserRelatedByUpdatedBy(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PagePeer::DATABASE_NAME);
        }

        PagePeer::addSelectColumns($criteria);
        $startcol = PagePeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(PagePeer::UPDATED_BY, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PagePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = PagePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PagePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Page) to $obj2 (User)
                $obj2->addPageRelatedByUpdatedBy($obj1);

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
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PagePeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(PagePeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
     * Selects a collection of Page objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Page objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PagePeer::DATABASE_NAME);
        }

        PagePeer::addSelectColumns($criteria);
        $startcol2 = PagePeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + UserPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PagePeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(PagePeer::UPDATED_BY, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PagePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PagePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PagePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined User rows

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Page) to the collection in $obj2 (User)
                $obj2->addPageRelatedByCreatedBy($obj1);
            } // if joined row not null

            // Add objects for joined User rows

            $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = UserPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Page) to the collection in $obj3 (User)
                $obj3->addPageRelatedByUpdatedBy($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related PageRelatedByCanonicalId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptPageRelatedByCanonicalId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(PagePeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(PagePeer::UPDATED_BY, UserPeer::ID, $join_behavior);

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
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

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
        $criteria->setPrimaryTableName(PagePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            PagePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

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
     * Selects a collection of Page objects pre-filled with all related objects except PageRelatedByCanonicalId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Page objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptPageRelatedByCanonicalId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(PagePeer::DATABASE_NAME);
        }

        PagePeer::addSelectColumns($criteria);
        $startcol2 = PagePeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + UserPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(PagePeer::CREATED_BY, UserPeer::ID, $join_behavior);

        $criteria->addJoin(PagePeer::UPDATED_BY, UserPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PagePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PagePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PagePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined User rows

                $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = UserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Page) to the collection in $obj2 (User)
                $obj2->addPageRelatedByCreatedBy($obj1);

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

                // Add the $obj1 (Page) to the collection in $obj3 (User)
                $obj3->addPageRelatedByUpdatedBy($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Page objects pre-filled with all related objects except UserRelatedByCreatedBy.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Page objects.
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
            $criteria->setDbName(PagePeer::DATABASE_NAME);
        }

        PagePeer::addSelectColumns($criteria);
        $startcol2 = PagePeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PagePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PagePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PagePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Page objects pre-filled with all related objects except UserRelatedByUpdatedBy.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Page objects.
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
            $criteria->setDbName(PagePeer::DATABASE_NAME);
        }

        PagePeer::addSelectColumns($criteria);
        $startcol2 = PagePeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = PagePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = PagePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                PagePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

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
        return Propel::getDatabaseMap(PagePeer::DATABASE_NAME)->getTable(PagePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BasePagePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BasePagePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \PageTableMap());
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
        return PagePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Page or Criteria object.
     *
     * @param      mixed $values Criteria or Page object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Page object
        }

        if ($criteria->containsKey(PagePeer::ID) && $criteria->keyContainsValue(PagePeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PagePeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Page or Criteria object.
     *
     * @param      mixed $values Criteria or Page object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(PagePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(PagePeer::ID);
            $value = $criteria->remove(PagePeer::ID);
            if ($value) {
                $selectCriteria->add(PagePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(PagePeer::TABLE_NAME);
            }

        } else { // $values is Page object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the pages table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += PagePeer::doOnDeleteCascade(new Criteria(PagePeer::DATABASE_NAME), $con);
            PagePeer::doOnDeleteSetNull(new Criteria(PagePeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(PagePeer::TABLE_NAME, $con, PagePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PagePeer::clearInstancePool();
            PagePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Page or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Page object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     private static function doDeleteBeforeTaggable($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Page) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PagePeer::DATABASE_NAME);
            $criteria->add(PagePeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(PagePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += PagePeer::doOnDeleteCascade($c, $con);

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            PagePeer::doOnDeleteSetNull($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                PagePeer::clearInstancePool();
            } elseif ($values instanceof Page) { // it's a model object
                PagePeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    PagePeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            PagePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Peer classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
    {
        // initialize var to track total num of affected rows
        $affectedRows = 0;

        // first find the objects that are implicated by the $criteria
        $objects = PagePeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related PageProperty objects
            $criteria = new Criteria(PagePropertyPeer::DATABASE_NAME);

            $criteria->add(PagePropertyPeer::PAGE_ID, $obj->getId());
            $affectedRows += PagePropertyPeer::doDelete($criteria, $con);

            // delete related PageString objects
            $criteria = new Criteria(PageStringPeer::DATABASE_NAME);

            $criteria->add(PageStringPeer::PAGE_ID, $obj->getId());
            $affectedRows += PageStringPeer::doDelete($criteria, $con);

            // delete related ContentObject objects
            $criteria = new Criteria(ContentObjectPeer::DATABASE_NAME);

            $criteria->add(ContentObjectPeer::PAGE_ID, $obj->getId());
            $affectedRows += ContentObjectPeer::doDelete($criteria, $con);

            // delete related Right objects
            $criteria = new Criteria(RightPeer::DATABASE_NAME);

            $criteria->add(RightPeer::PAGE_ID, $obj->getId());
            $affectedRows += RightPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * This is a method for emulating ON DELETE SET NULL DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Peer classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return void
     */
    protected static function doOnDeleteSetNull(Criteria $criteria, PropelPDO $con)
    {

        // first find the objects that are implicated by the $criteria
        $objects = PagePeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {

            // set fkey col in related Page rows to null
            $selectCriteria = new Criteria(PagePeer::DATABASE_NAME);
            $updateValues = new Criteria(PagePeer::DATABASE_NAME);
            $selectCriteria->add(PagePeer::CANONICAL_ID, $obj->getId());
            $updateValues->add(PagePeer::CANONICAL_ID, null);

            BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

        }
    }

    /**
     * Validates all modified columns of given Page object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Page $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(PagePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(PagePeer::TABLE_NAME);

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

        return BasePeer::doValidate(PagePeer::DATABASE_NAME, PagePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Page
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = PagePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(PagePeer::DATABASE_NAME);
        $criteria->add(PagePeer::ID, $pk);

        $v = PagePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Page[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(PagePeer::DATABASE_NAME);
            $criteria->add(PagePeer::ID, $pks, Criteria::IN);
            $objs = PagePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

    // taggable behavior
    public static function doDelete($values, PropelPDO $con = null) {
            if ($con === null) {
                $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
            }

            if($values instanceof Criteria) {
                // rename for clarity
                $criteria = clone $values;
            } elseif ($values instanceof Page) { // it's a model object
                // create criteria based on pk values
                $criteria = $values->buildPkeyCriteria();
            } else { // it's a primary key, or an array of pks
                $criteria = new Criteria(self::DATABASE_NAME);
                $criteria->add(PagePeer::ID, (array) $values, Criteria::IN);
            }

            foreach(PagePeer::doSelect(clone $criteria, $con) as $object) {
                TagPeer::deleteTagsForObject($object);
            }

            return self::doDeleteBeforeTaggable($criteria, $con);
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
        return true;
    }
    public static function mayOperateOnOwn($oUser, $mObject, $sOperation) {
        return false;
    }

    // nested_set behavior

    /**
     * Returns the root node for a given scope
     *
     * @param      PropelPDO $con	Connection to use.
     * @return     Page			Propel object for root node
     */
    public static function retrieveRoot(PropelPDO $con = null)
    {
        $c = new Criteria(PagePeer::DATABASE_NAME);
        $c->add(PagePeer::LEFT_COL, 1, Criteria::EQUAL);

        return PagePeer::doSelectOne($c, $con);
    }

    /**
     * Returns the whole tree node for a given scope
     *
     * @param      Criteria $criteria	Optional Criteria to filter the query
     * @param      PropelPDO $con	Connection to use.
     * @return     Page			Propel object for root node
     */
    public static function retrieveTree(Criteria $criteria = null, PropelPDO $con = null)
    {
        if ($criteria === null) {
            $criteria = new Criteria(PagePeer::DATABASE_NAME);
        }
        $criteria->addAscendingOrderByColumn(PagePeer::LEFT_COL);

        return PagePeer::doSelect($criteria, $con);
    }

    /**
     * Tests if node is valid
     *
     * @param      Page $node	Propel object for src node
     * @return     bool
     */
    public static function isValid(Page $node = null)
    {
        if (is_object($node) && $node->getRightValue() > $node->getLeftValue()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete an entire tree
     *
     * @param      PropelPDO $con	Connection to use.
     *
     * @return     int  The number of deleted nodes
     */
    public static function deleteTree(PropelPDO $con = null)
    {

        return PagePeer::doDeleteAll($con);
    }

    /**
     * Adds $delta to all L and R values that are >= $first and <= $last.
     * '$delta' can also be negative.
     *
     * @param      int $delta		Value to be shifted by, can be negative
     * @param      int $first		First node to be shifted
     * @param      int $last			Last node to be shifted (optional)
     * @param      PropelPDO $con		Connection to use.
     */
    public static function shiftRLValues($delta, $first, $last = null, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        // Shift left column values
        $whereCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $criterion = $whereCriteria->getNewCriterion(PagePeer::LEFT_COL, $first, Criteria::GREATER_EQUAL);
        if (null !== $last) {
            $criterion->addAnd($whereCriteria->getNewCriterion(PagePeer::LEFT_COL, $last, Criteria::LESS_EQUAL));
        }
        $whereCriteria->add($criterion);

        $valuesCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $valuesCriteria->add(PagePeer::LEFT_COL, array('raw' => PagePeer::LEFT_COL . ' + ?', 'value' => $delta), Criteria::CUSTOM_EQUAL);

        BasePeer::doUpdate($whereCriteria, $valuesCriteria, $con);

        // Shift right column values
        $whereCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $criterion = $whereCriteria->getNewCriterion(PagePeer::RIGHT_COL, $first, Criteria::GREATER_EQUAL);
        if (null !== $last) {
            $criterion->addAnd($whereCriteria->getNewCriterion(PagePeer::RIGHT_COL, $last, Criteria::LESS_EQUAL));
        }
        $whereCriteria->add($criterion);

        $valuesCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $valuesCriteria->add(PagePeer::RIGHT_COL, array('raw' => PagePeer::RIGHT_COL . ' + ?', 'value' => $delta), Criteria::CUSTOM_EQUAL);

        BasePeer::doUpdate($whereCriteria, $valuesCriteria, $con);
    }

    /**
     * Adds $delta to level for nodes having left value >= $first and right value <= $last.
     * '$delta' can also be negative.
     *
     * @param      int $delta		Value to be shifted by, can be negative
     * @param      int $first		First node to be shifted
     * @param      int $last			Last node to be shifted
     * @param      PropelPDO $con		Connection to use.
     */
    public static function shiftLevel($delta, $first, $last, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $whereCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $whereCriteria->add(PagePeer::LEFT_COL, $first, Criteria::GREATER_EQUAL);
        $whereCriteria->add(PagePeer::RIGHT_COL, $last, Criteria::LESS_EQUAL);

        $valuesCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $valuesCriteria->add(PagePeer::LEVEL_COL, array('raw' => PagePeer::LEVEL_COL . ' + ?', 'value' => $delta), Criteria::CUSTOM_EQUAL);

        BasePeer::doUpdate($whereCriteria, $valuesCriteria, $con);
    }

    /**
     * Reload all already loaded nodes to sync them with updated db
     *
     * @param      Page $prune		Object to prune from the update
     * @param      PropelPDO $con		Connection to use.
     */
    public static function updateLoadedNodes($prune = null, PropelPDO $con = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            $keys = array();
            foreach (PagePeer::$instances as $obj) {
                if (!$prune || !$prune->equals($obj)) {
                    $keys[] = $obj->getPrimaryKey();
                }
            }

            if (!empty($keys)) {
                // We don't need to alter the object instance pool; we're just modifying these ones
                // already in the pool.
                $criteria = new Criteria(PagePeer::DATABASE_NAME);
                $criteria->add(PagePeer::ID, $keys, Criteria::IN);
                $stmt = PagePeer::doSelectStmt($criteria, $con);
                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    $key = PagePeer::getPrimaryKeyHashFromRow($row, 0);
                    if (null !== ($object = PagePeer::getInstanceFromPool($key))) {
                        $object->setLeftValue($row[10]);
                        $object->setRightValue($row[11]);
                        $object->setLevel($row[12]);
                        $object->clearNestedSetChildren();
                    }
                }
                $stmt->closeCursor();
            }
        }
    }

    /**
     * Update the tree to allow insertion of a leaf at the specified position
     *
     * @param      int $left	left column value
     * @param      mixed $prune	Object to prune from the shift
     * @param      PropelPDO $con	Connection to use.
     */
    public static function makeRoomForLeaf($left, $prune = null, PropelPDO $con = null)
    {
        // Update database nodes
        PagePeer::shiftRLValues(2, $left, null, $con);

        // Update all loaded nodes
        PagePeer::updateLoadedNodes($prune, $con);
    }

    /**
     * Update the tree to allow insertion of a leaf at the specified position
     *
     * @param      PropelPDO $con	Connection to use.
     */
    public static function fixLevels(PropelPDO $con = null)
    {
        $c = new Criteria();
        $c->addAscendingOrderByColumn(PagePeer::LEFT_COL);
        $stmt = PagePeer::doSelectStmt($c, $con);

        // set the class once to avoid overhead in the loop
        $cls = PagePeer::getOMClass(false);
        $level = null;
        // iterate over the statement
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {

            // hydrate object
            $key = PagePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null === ($obj = PagePeer::getInstanceFromPool($key))) {
                $obj = new $cls();
                $obj->hydrate($row);
                PagePeer::addInstanceToPool($obj, $key);
            }

            // compute level
            // Algorithm shamelessly stolen from sfPropelActAsNestedSetBehaviorPlugin
            // Probably authored by Tristan Rivoallan
            if ($level === null) {
                $level = 0;
                $i = 0;
                $prev = array($obj->getRightValue());
            } else {
                while ($obj->getRightValue() > $prev[$i]) {
                    $i--;
                }
                $level = ++$i;
                $prev[$i] = $obj->getRightValue();
            }

            // update level in node if necessary
            if ($obj->getLevel() !== $level) {
                $obj->setLevel($level);
                $obj->save($con);
            }
        }
        $stmt->closeCursor();
    }

    /**
     * Updates all scope values for items that has negative left (<=0) values.
     *
     * @param      mixed     $scope
     * @param      PropelPDO $con	Connection to use.
     */
    public static function setNegativeScope($scope, PropelPDO $con = null)
    {
        //adjust scope value to $scope
        $whereCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $whereCriteria->add(PagePeer::LEFT_COL, 0, Criteria::LESS_EQUAL);

        $valuesCriteria = new Criteria(PagePeer::DATABASE_NAME);
        $valuesCriteria->add(PagePeer::SCOPE_COL, $scope, Criteria::EQUAL);

        BasePeer::doUpdate($whereCriteria, $valuesCriteria, $con);
    }

} // BasePagePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BasePagePeer::buildTableMap();

