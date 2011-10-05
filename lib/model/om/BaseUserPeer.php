<?php


/**
 * Base static class for performing query and update operations on the 'users' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BaseUserPeer {

	/** the default database name for this class */
	const DATABASE_NAME = 'rapila';

	/** the table name for this class */
	const TABLE_NAME = 'users';

	/** the related Propel class for this table */
	const OM_CLASS = 'User';

	/** A class that can be returned by this peer. */
	const CLASS_DEFAULT = 'model.User';

	/** the related TableMap class for this table */
	const TM_CLASS = 'UserTableMap';

	/** The total number of columns. */
	const NUM_COLUMNS = 18;

	/** The number of lazy-loaded columns. */
	const NUM_LAZY_LOAD_COLUMNS = 0;

	/** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
	const NUM_HYDRATE_COLUMNS = 18;

	/** the column name for the ID field */
	const ID = 'users.ID';

	/** the column name for the USERNAME field */
	const USERNAME = 'users.USERNAME';

	/** the column name for the PASSWORD field */
	const PASSWORD = 'users.PASSWORD';

	/** the column name for the DIGEST_HA1 field */
	const DIGEST_HA1 = 'users.DIGEST_HA1';

	/** the column name for the FIRST_NAME field */
	const FIRST_NAME = 'users.FIRST_NAME';

	/** the column name for the LAST_NAME field */
	const LAST_NAME = 'users.LAST_NAME';

	/** the column name for the EMAIL field */
	const EMAIL = 'users.EMAIL';

	/** the column name for the LANGUAGE_ID field */
	const LANGUAGE_ID = 'users.LANGUAGE_ID';

	/** the column name for the IS_ADMIN field */
	const IS_ADMIN = 'users.IS_ADMIN';

	/** the column name for the IS_BACKEND_LOGIN_ENABLED field */
	const IS_BACKEND_LOGIN_ENABLED = 'users.IS_BACKEND_LOGIN_ENABLED';

	/** the column name for the IS_ADMIN_LOGIN_ENABLED field */
	const IS_ADMIN_LOGIN_ENABLED = 'users.IS_ADMIN_LOGIN_ENABLED';

	/** the column name for the IS_INACTIVE field */
	const IS_INACTIVE = 'users.IS_INACTIVE';

	/** the column name for the PASSWORD_RECOVER_HINT field */
	const PASSWORD_RECOVER_HINT = 'users.PASSWORD_RECOVER_HINT';

	/** the column name for the BACKEND_SETTINGS field */
	const BACKEND_SETTINGS = 'users.BACKEND_SETTINGS';

	/** the column name for the CREATED_AT field */
	const CREATED_AT = 'users.CREATED_AT';

	/** the column name for the UPDATED_AT field */
	const UPDATED_AT = 'users.UPDATED_AT';

	/** the column name for the CREATED_BY field */
	const CREATED_BY = 'users.CREATED_BY';

	/** the column name for the UPDATED_BY field */
	const UPDATED_BY = 'users.UPDATED_BY';

	/** The default string format for model objects of the related table **/
	const DEFAULT_STRING_FORMAT = 'YAML';

	/**
	 * An identiy map to hold any loaded instances of User objects.
	 * This must be public so that other peer classes can access this when hydrating from JOIN
	 * queries.
	 * @var        array User[]
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
		BasePeer::TYPE_PHPNAME => array ('Id', 'Username', 'Password', 'DigestHA1', 'FirstName', 'LastName', 'Email', 'LanguageId', 'IsAdmin', 'IsBackendLoginEnabled', 'IsAdminLoginEnabled', 'IsInactive', 'PasswordRecoverHint', 'BackendSettings', 'CreatedAt', 'UpdatedAt', 'CreatedBy', 'UpdatedBy', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'username', 'password', 'digestHA1', 'firstName', 'lastName', 'email', 'languageId', 'isAdmin', 'isBackendLoginEnabled', 'isAdminLoginEnabled', 'isInactive', 'passwordRecoverHint', 'backendSettings', 'createdAt', 'updatedAt', 'createdBy', 'updatedBy', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::USERNAME, self::PASSWORD, self::DIGEST_HA1, self::FIRST_NAME, self::LAST_NAME, self::EMAIL, self::LANGUAGE_ID, self::IS_ADMIN, self::IS_BACKEND_LOGIN_ENABLED, self::IS_ADMIN_LOGIN_ENABLED, self::IS_INACTIVE, self::PASSWORD_RECOVER_HINT, self::BACKEND_SETTINGS, self::CREATED_AT, self::UPDATED_AT, self::CREATED_BY, self::UPDATED_BY, ),
		BasePeer::TYPE_RAW_COLNAME => array ('ID', 'USERNAME', 'PASSWORD', 'DIGEST_HA1', 'FIRST_NAME', 'LAST_NAME', 'EMAIL', 'LANGUAGE_ID', 'IS_ADMIN', 'IS_BACKEND_LOGIN_ENABLED', 'IS_ADMIN_LOGIN_ENABLED', 'IS_INACTIVE', 'PASSWORD_RECOVER_HINT', 'BACKEND_SETTINGS', 'CREATED_AT', 'UPDATED_AT', 'CREATED_BY', 'UPDATED_BY', ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'username', 'password', 'digest_ha1', 'first_name', 'last_name', 'email', 'language_id', 'is_admin', 'is_backend_login_enabled', 'is_admin_login_enabled', 'is_inactive', 'password_recover_hint', 'backend_settings', 'created_at', 'updated_at', 'created_by', 'updated_by', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
	);

	/**
	 * holds an array of keys for quick access to the fieldnames array
	 *
	 * first dimension keys are the type constants
	 * e.g. self::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
	 */
	protected static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Username' => 1, 'Password' => 2, 'DigestHA1' => 3, 'FirstName' => 4, 'LastName' => 5, 'Email' => 6, 'LanguageId' => 7, 'IsAdmin' => 8, 'IsBackendLoginEnabled' => 9, 'IsAdminLoginEnabled' => 10, 'IsInactive' => 11, 'PasswordRecoverHint' => 12, 'BackendSettings' => 13, 'CreatedAt' => 14, 'UpdatedAt' => 15, 'CreatedBy' => 16, 'UpdatedBy' => 17, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'username' => 1, 'password' => 2, 'digestHA1' => 3, 'firstName' => 4, 'lastName' => 5, 'email' => 6, 'languageId' => 7, 'isAdmin' => 8, 'isBackendLoginEnabled' => 9, 'isAdminLoginEnabled' => 10, 'isInactive' => 11, 'passwordRecoverHint' => 12, 'backendSettings' => 13, 'createdAt' => 14, 'updatedAt' => 15, 'createdBy' => 16, 'updatedBy' => 17, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::USERNAME => 1, self::PASSWORD => 2, self::DIGEST_HA1 => 3, self::FIRST_NAME => 4, self::LAST_NAME => 5, self::EMAIL => 6, self::LANGUAGE_ID => 7, self::IS_ADMIN => 8, self::IS_BACKEND_LOGIN_ENABLED => 9, self::IS_ADMIN_LOGIN_ENABLED => 10, self::IS_INACTIVE => 11, self::PASSWORD_RECOVER_HINT => 12, self::BACKEND_SETTINGS => 13, self::CREATED_AT => 14, self::UPDATED_AT => 15, self::CREATED_BY => 16, self::UPDATED_BY => 17, ),
		BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'USERNAME' => 1, 'PASSWORD' => 2, 'DIGEST_HA1' => 3, 'FIRST_NAME' => 4, 'LAST_NAME' => 5, 'EMAIL' => 6, 'LANGUAGE_ID' => 7, 'IS_ADMIN' => 8, 'IS_BACKEND_LOGIN_ENABLED' => 9, 'IS_ADMIN_LOGIN_ENABLED' => 10, 'IS_INACTIVE' => 11, 'PASSWORD_RECOVER_HINT' => 12, 'BACKEND_SETTINGS' => 13, 'CREATED_AT' => 14, 'UPDATED_AT' => 15, 'CREATED_BY' => 16, 'UPDATED_BY' => 17, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'username' => 1, 'password' => 2, 'digest_ha1' => 3, 'first_name' => 4, 'last_name' => 5, 'email' => 6, 'language_id' => 7, 'is_admin' => 8, 'is_backend_login_enabled' => 9, 'is_admin_login_enabled' => 10, 'is_inactive' => 11, 'password_recover_hint' => 12, 'backend_settings' => 13, 'created_at' => 14, 'updated_at' => 15, 'created_by' => 16, 'updated_by' => 17, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
	 * @param      string $column The column name for current table. (i.e. UserPeer::COLUMN_NAME).
	 * @return     string
	 */
	public static function alias($alias, $column)
	{
		return str_replace(UserPeer::TABLE_NAME.'.', $alias.'.', $column);
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
			$criteria->addSelectColumn(UserPeer::ID);
			$criteria->addSelectColumn(UserPeer::USERNAME);
			$criteria->addSelectColumn(UserPeer::PASSWORD);
			$criteria->addSelectColumn(UserPeer::DIGEST_HA1);
			$criteria->addSelectColumn(UserPeer::FIRST_NAME);
			$criteria->addSelectColumn(UserPeer::LAST_NAME);
			$criteria->addSelectColumn(UserPeer::EMAIL);
			$criteria->addSelectColumn(UserPeer::LANGUAGE_ID);
			$criteria->addSelectColumn(UserPeer::IS_ADMIN);
			$criteria->addSelectColumn(UserPeer::IS_BACKEND_LOGIN_ENABLED);
			$criteria->addSelectColumn(UserPeer::IS_ADMIN_LOGIN_ENABLED);
			$criteria->addSelectColumn(UserPeer::IS_INACTIVE);
			$criteria->addSelectColumn(UserPeer::PASSWORD_RECOVER_HINT);
			$criteria->addSelectColumn(UserPeer::BACKEND_SETTINGS);
			$criteria->addSelectColumn(UserPeer::CREATED_AT);
			$criteria->addSelectColumn(UserPeer::UPDATED_AT);
			$criteria->addSelectColumn(UserPeer::CREATED_BY);
			$criteria->addSelectColumn(UserPeer::UPDATED_BY);
		} else {
			$criteria->addSelectColumn($alias . '.ID');
			$criteria->addSelectColumn($alias . '.USERNAME');
			$criteria->addSelectColumn($alias . '.PASSWORD');
			$criteria->addSelectColumn($alias . '.DIGEST_HA1');
			$criteria->addSelectColumn($alias . '.FIRST_NAME');
			$criteria->addSelectColumn($alias . '.LAST_NAME');
			$criteria->addSelectColumn($alias . '.EMAIL');
			$criteria->addSelectColumn($alias . '.LANGUAGE_ID');
			$criteria->addSelectColumn($alias . '.IS_ADMIN');
			$criteria->addSelectColumn($alias . '.IS_BACKEND_LOGIN_ENABLED');
			$criteria->addSelectColumn($alias . '.IS_ADMIN_LOGIN_ENABLED');
			$criteria->addSelectColumn($alias . '.IS_INACTIVE');
			$criteria->addSelectColumn($alias . '.PASSWORD_RECOVER_HINT');
			$criteria->addSelectColumn($alias . '.BACKEND_SETTINGS');
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
		$criteria->setPrimaryTableName(UserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			UserPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
		$criteria->setDbName(self::DATABASE_NAME); // Set the correct dbName

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return     User
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = UserPeer::doSelect($critcopy, $con);
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
		return UserPeer::populateObjects(UserPeer::doSelectStmt($criteria, $con));
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->hasSelectClause()) {
			$criteria = clone $criteria;
			UserPeer::addSelectColumns($criteria);
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
	 * @param      User $value A User object.
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
	 * @param      mixed $value A User object or a primary key value.
	 */
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof User) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
				// assume we've been passed a primary key
				$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or User object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
	 * @return     User Found object or NULL if 1) no instance exists for specified key or 2) instance pooling has been disabled.
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
	 * Method to invalidate the instance pool of all tables related to users
	 * by a foreign key with ON DELETE CASCADE
	 */
	public static function clearRelatedInstancePool()
	{
		// Invalidate objects in UserGroupPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		UserGroupPeer::clearInstancePool();
		// Invalidate objects in UserRolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		UserRolePeer::clearInstancePool();
		// Invalidate objects in PagePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		PagePeer::clearInstancePool();
		// Invalidate objects in PagePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		PagePeer::clearInstancePool();
		// Invalidate objects in PagePropertyPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		PagePropertyPeer::clearInstancePool();
		// Invalidate objects in PagePropertyPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		PagePropertyPeer::clearInstancePool();
		// Invalidate objects in PageStringPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		PageStringPeer::clearInstancePool();
		// Invalidate objects in PageStringPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		PageStringPeer::clearInstancePool();
		// Invalidate objects in ContentObjectPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		ContentObjectPeer::clearInstancePool();
		// Invalidate objects in ContentObjectPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		ContentObjectPeer::clearInstancePool();
		// Invalidate objects in LanguageObjectPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LanguageObjectPeer::clearInstancePool();
		// Invalidate objects in LanguageObjectPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LanguageObjectPeer::clearInstancePool();
		// Invalidate objects in LanguageObjectHistoryPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LanguageObjectHistoryPeer::clearInstancePool();
		// Invalidate objects in LanguageObjectHistoryPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LanguageObjectHistoryPeer::clearInstancePool();
		// Invalidate objects in LanguagePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LanguagePeer::clearInstancePool();
		// Invalidate objects in LanguagePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LanguagePeer::clearInstancePool();
		// Invalidate objects in StringPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		StringPeer::clearInstancePool();
		// Invalidate objects in StringPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		StringPeer::clearInstancePool();
		// Invalidate objects in UserGroupPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		UserGroupPeer::clearInstancePool();
		// Invalidate objects in UserGroupPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		UserGroupPeer::clearInstancePool();
		// Invalidate objects in GroupPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		GroupPeer::clearInstancePool();
		// Invalidate objects in GroupPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		GroupPeer::clearInstancePool();
		// Invalidate objects in GroupRolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		GroupRolePeer::clearInstancePool();
		// Invalidate objects in GroupRolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		GroupRolePeer::clearInstancePool();
		// Invalidate objects in RolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		RolePeer::clearInstancePool();
		// Invalidate objects in RolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		RolePeer::clearInstancePool();
		// Invalidate objects in UserRolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		UserRolePeer::clearInstancePool();
		// Invalidate objects in UserRolePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		UserRolePeer::clearInstancePool();
		// Invalidate objects in RightPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		RightPeer::clearInstancePool();
		// Invalidate objects in RightPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		RightPeer::clearInstancePool();
		// Invalidate objects in DocumentPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		DocumentPeer::clearInstancePool();
		// Invalidate objects in DocumentPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		DocumentPeer::clearInstancePool();
		// Invalidate objects in DocumentTypePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		DocumentTypePeer::clearInstancePool();
		// Invalidate objects in DocumentTypePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		DocumentTypePeer::clearInstancePool();
		// Invalidate objects in DocumentCategoryPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		DocumentCategoryPeer::clearInstancePool();
		// Invalidate objects in DocumentCategoryPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		DocumentCategoryPeer::clearInstancePool();
		// Invalidate objects in TagPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		TagPeer::clearInstancePool();
		// Invalidate objects in TagPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		TagPeer::clearInstancePool();
		// Invalidate objects in TagInstancePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		TagInstancePeer::clearInstancePool();
		// Invalidate objects in TagInstancePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		TagInstancePeer::clearInstancePool();
		// Invalidate objects in LinkPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LinkPeer::clearInstancePool();
		// Invalidate objects in LinkPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LinkPeer::clearInstancePool();
		// Invalidate objects in LinkCategoryPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LinkCategoryPeer::clearInstancePool();
		// Invalidate objects in LinkCategoryPeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		LinkCategoryPeer::clearInstancePool();
		// Invalidate objects in ReferencePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		ReferencePeer::clearInstancePool();
		// Invalidate objects in ReferencePeer instance pool,
		// since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
		ReferencePeer::clearInstancePool();
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
		$cls = UserPeer::getOMClass(false);
		// populate the object(s)
		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = UserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = UserPeer::getInstanceFromPool($key))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj->hydrate($row, 0, true); // rehydrate
				$results[] = $obj;
			} else {
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				UserPeer::addInstanceToPool($obj, $key);
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
	 * @return     array (User object, last column rank)
	 */
	public static function populateObject($row, $startcol = 0)
	{
		$key = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
		if (null !== ($obj = UserPeer::getInstanceFromPool($key))) {
			// We no longer rehydrate the object, since this can cause data loss.
			// See http://www.propelorm.org/ticket/509
			// $obj->hydrate($row, $startcol, true); // rehydrate
			$col = $startcol + UserPeer::NUM_HYDRATE_COLUMNS;
		} else {
			$cls = UserPeer::OM_CLASS;
			$obj = new $cls();
			$col = $obj->hydrate($row, $startcol);
			UserPeer::addInstanceToPool($obj, $key);
		}
		return array($obj, $col);
	}


	/**
	 * Returns the number of rows matching criteria, joining the related LanguageRelatedByLanguageId table
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     int Number of matching rows.
	 */
	public static function doCountJoinLanguageRelatedByLanguageId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		// we're going to modify criteria, so copy it first
		$criteria = clone $criteria;

		// We need to set the primary table name, since in the case that there are no WHERE columns
		// it will be impossible for the BasePeer::createSelectSql() method to determine which
		// tables go into the FROM clause.
		$criteria->setPrimaryTableName(UserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			UserPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(UserPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

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
	 * Selects a collection of User objects pre-filled with their Language objects.
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of User objects.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doSelectJoinLanguageRelatedByLanguageId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$criteria = clone $criteria;

		// Set the correct dbName if it has not been overridden
		if ($criteria->getDbName() == Propel::getDefaultDB()) {
			$criteria->setDbName(self::DATABASE_NAME);
		}

		UserPeer::addSelectColumns($criteria);
		$startcol = UserPeer::NUM_HYDRATE_COLUMNS;
		LanguagePeer::addSelectColumns($criteria);

		$criteria->addJoin(UserPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = UserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = UserPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {

				$cls = UserPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				UserPeer::addInstanceToPool($obj1, $key1);
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

				// Add the $obj1 (User) to $obj2 (Language)
				$obj2->addUserRelatedByLanguageId($obj1);

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
		$criteria->setPrimaryTableName(UserPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->hasSelectClause()) {
			UserPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria->addJoin(UserPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

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
	 * Selects a collection of User objects pre-filled with all related objects.
	 *
	 * @param      Criteria  $criteria
	 * @param      PropelPDO $con
	 * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
	 * @return     array Array of User objects.
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

		UserPeer::addSelectColumns($criteria);
		$startcol2 = UserPeer::NUM_HYDRATE_COLUMNS;

		LanguagePeer::addSelectColumns($criteria);
		$startcol3 = $startcol2 + LanguagePeer::NUM_HYDRATE_COLUMNS;

		$criteria->addJoin(UserPeer::LANGUAGE_ID, LanguagePeer::ID, $join_behavior);

		$stmt = BasePeer::doSelect($criteria, $con);
		$results = array();

		while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key1 = UserPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj1 = UserPeer::getInstanceFromPool($key1))) {
				// We no longer rehydrate the object, since this can cause data loss.
				// See http://www.propelorm.org/ticket/509
				// $obj1->hydrate($row, 0, true); // rehydrate
			} else {
				$cls = UserPeer::getOMClass(false);

				$obj1 = new $cls();
				$obj1->hydrate($row);
				UserPeer::addInstanceToPool($obj1, $key1);
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
				} // if obj2 loaded

				// Add the $obj1 (User) to the collection in $obj2 (Language)
				$obj2->addUserRelatedByLanguageId($obj1);
			} // if joined row not null

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
	  $dbMap = Propel::getDatabaseMap(BaseUserPeer::DATABASE_NAME);
	  if (!$dbMap->hasTable(BaseUserPeer::TABLE_NAME))
	  {
	    $dbMap->addTableObject(new UserTableMap());
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
		return $withPrefix ? UserPeer::CLASS_DEFAULT : UserPeer::OM_CLASS;
	}

	/**
	 * Performs an INSERT on the database, given a User or Criteria object.
	 *
	 * @param      mixed $values Criteria or User object containing data that is used to create the INSERT statement.
	 * @param      PropelPDO $con the PropelPDO connection to use
	 * @return     mixed The new primary key.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doInsert($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity
		} else {
			$criteria = $values->buildCriteria(); // build Criteria from User object
		}

		if ($criteria->containsKey(UserPeer::ID) && $criteria->keyContainsValue(UserPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserPeer::ID.')');
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
	 * Performs an UPDATE on the database, given a User or Criteria object.
	 *
	 * @param      mixed $values Criteria or User object containing data that is used to create the UPDATE statement.
	 * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	public static function doUpdate($values, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; // rename for clarity

			$comparison = $criteria->getComparison(UserPeer::ID);
			$value = $criteria->remove(UserPeer::ID);
			if ($value) {
				$selectCriteria->add(UserPeer::ID, $value, $comparison);
			} else {
				$selectCriteria->setPrimaryTableName(UserPeer::TABLE_NAME);
			}

		} else { // $values is User object
			$criteria = $values->buildCriteria(); // gets full criteria
			$selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
		}

		// set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	/**
	 * Deletes all rows from the users table.
	 *
	 * @param      PropelPDO $con the connection to use
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	public static function doDeleteAll(PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; // initialize var to track total num of affected rows
		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			$affectedRows += UserPeer::doOnDeleteCascade(new Criteria(UserPeer::DATABASE_NAME), $con);
			UserPeer::doOnDeleteSetNull(new Criteria(UserPeer::DATABASE_NAME), $con);
			$affectedRows += BasePeer::doDeleteAll(UserPeer::TABLE_NAME, $con, UserPeer::DATABASE_NAME);
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			UserPeer::clearInstancePool();
			UserPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
	 *
	 * @param      mixed $values Criteria or User object or primary key or array of primary keys
	 *              which is used to create the DELETE statement
	 * @param      PropelPDO $con the connection to use
	 * @return     int 	The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
	 *				if supported by native driver or if emulated using Propel.
	 * @throws     PropelException Any exceptions caught during processing will be
	 *		 rethrown wrapped into a PropelException.
	 */
	 private static function doDeleteBeforeTaggable($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			// rename for clarity
			$criteria = clone $values;
		} elseif ($values instanceof User) { // it's a model object
			// create criteria based on pk values
			$criteria = $values->buildPkeyCriteria();
		} else { // it's a primary key, or an array of pks
			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(UserPeer::ID, (array) $values, Criteria::IN);
		}

		// Set the correct dbName
		$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; // initialize var to track total num of affected rows

		try {
			// use transaction because $criteria could contain info
			// for more than one table or we could emulating ON DELETE CASCADE, etc.
			$con->beginTransaction();
			
			// cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
			$c = clone $criteria;
			$affectedRows += UserPeer::doOnDeleteCascade($c, $con);
			
			// cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
			$c = clone $criteria;
			UserPeer::doOnDeleteSetNull($c, $con);
			
			// Because this db requires some delete cascade/set null emulation, we have to
			// clear the cached instance *after* the emulation has happened (since
			// instances get re-added by the select statement contained therein).
			if ($values instanceof Criteria) {
				UserPeer::clearInstancePool();
			} elseif ($values instanceof User) { // it's a model object
				UserPeer::removeInstanceFromPool($values);
			} else { // it's a primary key, or an array of pks
				foreach ((array) $values as $singleval) {
					UserPeer::removeInstanceFromPool($singleval);
				}
			}
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			UserPeer::clearRelatedInstancePool();
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
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
	 * @return     int The number of affected rows (if supported by underlying database driver).
	 */
	protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
	{
		// initialize var to track total num of affected rows
		$affectedRows = 0;

		// first find the objects that are implicated by the $criteria
		$objects = UserPeer::doSelect($criteria, $con);
		foreach ($objects as $obj) {


			// delete related UserGroup objects
			$criteria = new Criteria(UserGroupPeer::DATABASE_NAME);
			
			$criteria->add(UserGroupPeer::USER_ID, $obj->getId());
			$affectedRows += UserGroupPeer::doDelete($criteria, $con);

			// delete related UserRole objects
			$criteria = new Criteria(UserRolePeer::DATABASE_NAME);
			
			$criteria->add(UserRolePeer::USER_ID, $obj->getId());
			$affectedRows += UserRolePeer::doDelete($criteria, $con);
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
	 * @return     void
	 */
	protected static function doOnDeleteSetNull(Criteria $criteria, PropelPDO $con)
	{

		// first find the objects that are implicated by the $criteria
		$objects = UserPeer::doSelect($criteria, $con);
		foreach ($objects as $obj) {

			// set fkey col in related Page rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(PagePeer::CREATED_BY, $obj->getId());
			$updateValues->add(PagePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Page rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(PagePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(PagePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related PageProperty rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(PagePropertyPeer::CREATED_BY, $obj->getId());
			$updateValues->add(PagePropertyPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related PageProperty rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(PagePropertyPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(PagePropertyPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related PageString rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(PageStringPeer::CREATED_BY, $obj->getId());
			$updateValues->add(PageStringPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related PageString rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(PageStringPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(PageStringPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related ContentObject rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(ContentObjectPeer::CREATED_BY, $obj->getId());
			$updateValues->add(ContentObjectPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related ContentObject rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(ContentObjectPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(ContentObjectPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related LanguageObject rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LanguageObjectPeer::CREATED_BY, $obj->getId());
			$updateValues->add(LanguageObjectPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related LanguageObject rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LanguageObjectPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(LanguageObjectPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related LanguageObjectHistory rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LanguageObjectHistoryPeer::CREATED_BY, $obj->getId());
			$updateValues->add(LanguageObjectHistoryPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related LanguageObjectHistory rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LanguageObjectHistoryPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(LanguageObjectHistoryPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Language rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LanguagePeer::CREATED_BY, $obj->getId());
			$updateValues->add(LanguagePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Language rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LanguagePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(LanguagePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related String rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(StringPeer::CREATED_BY, $obj->getId());
			$updateValues->add(StringPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related String rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(StringPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(StringPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related UserGroup rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(UserGroupPeer::CREATED_BY, $obj->getId());
			$updateValues->add(UserGroupPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related UserGroup rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(UserGroupPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(UserGroupPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Group rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(GroupPeer::CREATED_BY, $obj->getId());
			$updateValues->add(GroupPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Group rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(GroupPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(GroupPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related GroupRole rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(GroupRolePeer::CREATED_BY, $obj->getId());
			$updateValues->add(GroupRolePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related GroupRole rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(GroupRolePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(GroupRolePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Role rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(RolePeer::CREATED_BY, $obj->getId());
			$updateValues->add(RolePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Role rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(RolePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(RolePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related UserRole rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(UserRolePeer::CREATED_BY, $obj->getId());
			$updateValues->add(UserRolePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related UserRole rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(UserRolePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(UserRolePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Right rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(RightPeer::CREATED_BY, $obj->getId());
			$updateValues->add(RightPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Right rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(RightPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(RightPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Document rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(DocumentPeer::CREATED_BY, $obj->getId());
			$updateValues->add(DocumentPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Document rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(DocumentPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(DocumentPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related DocumentType rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(DocumentTypePeer::CREATED_BY, $obj->getId());
			$updateValues->add(DocumentTypePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related DocumentType rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(DocumentTypePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(DocumentTypePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related DocumentCategory rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(DocumentCategoryPeer::CREATED_BY, $obj->getId());
			$updateValues->add(DocumentCategoryPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related DocumentCategory rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(DocumentCategoryPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(DocumentCategoryPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Tag rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(TagPeer::CREATED_BY, $obj->getId());
			$updateValues->add(TagPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Tag rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(TagPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(TagPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related TagInstance rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(TagInstancePeer::CREATED_BY, $obj->getId());
			$updateValues->add(TagInstancePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related TagInstance rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(TagInstancePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(TagInstancePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Link rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LinkPeer::CREATED_BY, $obj->getId());
			$updateValues->add(LinkPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Link rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LinkPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(LinkPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related LinkCategory rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LinkCategoryPeer::CREATED_BY, $obj->getId());
			$updateValues->add(LinkCategoryPeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related LinkCategory rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(LinkCategoryPeer::UPDATED_BY, $obj->getId());
			$updateValues->add(LinkCategoryPeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Reference rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(ReferencePeer::CREATED_BY, $obj->getId());
			$updateValues->add(ReferencePeer::CREATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

			// set fkey col in related Reference rows to NULL
			$selectCriteria = new Criteria(UserPeer::DATABASE_NAME);
			$updateValues = new Criteria(UserPeer::DATABASE_NAME);
			$selectCriteria->add(ReferencePeer::UPDATED_BY, $obj->getId());
			$updateValues->add(ReferencePeer::UPDATED_BY, null);

			BasePeer::doUpdate($selectCriteria, $updateValues, $con); // use BasePeer because generated Peer doUpdate() methods only update using pkey

		}
	}

	/**
	 * Validates all modified columns of given User object.
	 * If parameter $columns is either a single column name or an array of column names
	 * than only those columns are validated.
	 *
	 * NOTICE: This does not apply to primary or foreign keys for now.
	 *
	 * @param      User $obj The object to validate.
	 * @param      mixed $cols Column name or array of column names.
	 *
	 * @return     mixed TRUE if all columns are valid or the error message of the first invalid column.
	 */
	public static function doValidate($obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(UserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(UserPeer::TABLE_NAME);

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

		return BasePeer::doValidate(UserPeer::DATABASE_NAME, UserPeer::TABLE_NAME, $columns);
	}

	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      int $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     User
	 */
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = UserPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(UserPeer::DATABASE_NAME);
		$criteria->add(UserPeer::ID, $pk);

		$v = UserPeer::doSelect($criteria, $con);

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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(UserPeer::DATABASE_NAME);
			$criteria->add(UserPeer::ID, $pks, Criteria::IN);
			$objs = UserPeer::doSelect($criteria, $con);
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
			} elseif ($values instanceof User) { // it's a model object
				// create criteria based on pk values
				$criteria = $values->buildPkeyCriteria();
			} else { // it's a primary key, or an array of pks
				$criteria = new Criteria(self::DATABASE_NAME);
				$criteria->add(PagePeer::ID, (array) $values, Criteria::IN);
			}
			
			foreach(UserPeer::doSelect(clone $criteria, $con) as $object) {
				TagPeer::deleteTagsForObject($object);
			}
	
			return self::doDeleteBeforeTaggable($criteria, $con);
	}
	// denyable behavior
	public static function ignoreRights($bIgnore = true) {
		self::$IGNORE_RIGHTS = $bIgnore;
	}
	public static function isIgnoringRights() {
		return self::$IGNORE_RIGHTS;
	}
	public static function mayOperateOn($oUser, $mObject, $sOperation) {
		return true;
	}

} // BaseUserPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseUserPeer::buildTableMap();

