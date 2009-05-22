<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/UserPeer.php';

/**
 * Base class that represents a row from the 'users' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseUser extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        UserPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the username field.
	 * @var        string
	 */
	protected $username;


	/**
	 * The value for the password field.
	 * @var        string
	 */
	protected $password;


	/**
	 * The value for the first_name field.
	 * @var        string
	 */
	protected $first_name;


	/**
	 * The value for the last_name field.
	 * @var        string
	 */
	protected $last_name;


	/**
	 * The value for the email field.
	 * @var        string
	 */
	protected $email;


	/**
	 * The value for the language_id field.
	 * @var        string
	 */
	protected $language_id;


	/**
	 * The value for the is_admin field.
	 * @var        boolean
	 */
	protected $is_admin = false;


	/**
	 * The value for the is_backend_login_enabled field.
	 * @var        boolean
	 */
	protected $is_backend_login_enabled = true;


	/**
	 * The value for the is_inactive field.
	 * @var        boolean
	 */
	protected $is_inactive = false;


	/**
	 * The value for the password_recover_hint field.
	 * @var        string
	 */
	protected $password_recover_hint;


	/**
	 * The value for the backend_settings field.
	 * @var        string
	 */
	protected $backend_settings;


	/**
	 * The value for the created_by field.
	 * @var        int
	 */
	protected $created_by;


	/**
	 * The value for the updated_by field.
	 * @var        int
	 */
	protected $updated_by;


	/**
	 * The value for the created_at field.
	 * @var        int
	 */
	protected $created_at;


	/**
	 * The value for the updated_at field.
	 * @var        int
	 */
	protected $updated_at;

	/**
	 * @var        Language
	 */
	protected $aLanguage;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByCreatedBy;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByUpdatedBy;

	/**
	 * Collection to store aggregation of collPagesRelatedByCreatedBy.
	 * @var        array
	 */
	protected $collPagesRelatedByCreatedBy;

	/**
	 * The criteria used to select the current contents of collPagesRelatedByCreatedBy.
	 * @var        Criteria
	 */
	protected $lastPageRelatedByCreatedByCriteria = null;

	/**
	 * Collection to store aggregation of collPagesRelatedByUpdatedBy.
	 * @var        array
	 */
	protected $collPagesRelatedByUpdatedBy;

	/**
	 * The criteria used to select the current contents of collPagesRelatedByUpdatedBy.
	 * @var        Criteria
	 */
	protected $lastPageRelatedByUpdatedByCriteria = null;

	/**
	 * Collection to store aggregation of collLanguageObjectsRelatedByCreatedBy.
	 * @var        array
	 */
	protected $collLanguageObjectsRelatedByCreatedBy;

	/**
	 * The criteria used to select the current contents of collLanguageObjectsRelatedByCreatedBy.
	 * @var        Criteria
	 */
	protected $lastLanguageObjectRelatedByCreatedByCriteria = null;

	/**
	 * Collection to store aggregation of collLanguageObjectsRelatedByUpdatedBy.
	 * @var        array
	 */
	protected $collLanguageObjectsRelatedByUpdatedBy;

	/**
	 * The criteria used to select the current contents of collLanguageObjectsRelatedByUpdatedBy.
	 * @var        Criteria
	 */
	protected $lastLanguageObjectRelatedByUpdatedByCriteria = null;

	/**
	 * Collection to store aggregation of collLanguageObjectHistorys.
	 * @var        array
	 */
	protected $collLanguageObjectHistorys;

	/**
	 * The criteria used to select the current contents of collLanguageObjectHistorys.
	 * @var        Criteria
	 */
	protected $lastLanguageObjectHistoryCriteria = null;

	/**
	 * Collection to store aggregation of collUsersRelatedByCreatedBy.
	 * @var        array
	 */
	protected $collUsersRelatedByCreatedBy;

	/**
	 * The criteria used to select the current contents of collUsersRelatedByCreatedBy.
	 * @var        Criteria
	 */
	protected $lastUserRelatedByCreatedByCriteria = null;

	/**
	 * Collection to store aggregation of collUsersRelatedByUpdatedBy.
	 * @var        array
	 */
	protected $collUsersRelatedByUpdatedBy;

	/**
	 * The criteria used to select the current contents of collUsersRelatedByUpdatedBy.
	 * @var        Criteria
	 */
	protected $lastUserRelatedByUpdatedByCriteria = null;

	/**
	 * Collection to store aggregation of collGroupsRelatedByCreatedBy.
	 * @var        array
	 */
	protected $collGroupsRelatedByCreatedBy;

	/**
	 * The criteria used to select the current contents of collGroupsRelatedByCreatedBy.
	 * @var        Criteria
	 */
	protected $lastGroupRelatedByCreatedByCriteria = null;

	/**
	 * Collection to store aggregation of collGroupsRelatedByUpdatedBy.
	 * @var        array
	 */
	protected $collGroupsRelatedByUpdatedBy;

	/**
	 * The criteria used to select the current contents of collGroupsRelatedByUpdatedBy.
	 * @var        Criteria
	 */
	protected $lastGroupRelatedByUpdatedByCriteria = null;

	/**
	 * Collection to store aggregation of collUserGroups.
	 * @var        array
	 */
	protected $collUserGroups;

	/**
	 * The criteria used to select the current contents of collUserGroups.
	 * @var        Criteria
	 */
	protected $lastUserGroupCriteria = null;

	/**
	 * Collection to store aggregation of collDocumentsRelatedByOwnerId.
	 * @var        array
	 */
	protected $collDocumentsRelatedByOwnerId;

	/**
	 * The criteria used to select the current contents of collDocumentsRelatedByOwnerId.
	 * @var        Criteria
	 */
	protected $lastDocumentRelatedByOwnerIdCriteria = null;

	/**
	 * Collection to store aggregation of collDocumentsRelatedByCreatedBy.
	 * @var        array
	 */
	protected $collDocumentsRelatedByCreatedBy;

	/**
	 * The criteria used to select the current contents of collDocumentsRelatedByCreatedBy.
	 * @var        Criteria
	 */
	protected $lastDocumentRelatedByCreatedByCriteria = null;

	/**
	 * Collection to store aggregation of collDocumentsRelatedByUpdatedBy.
	 * @var        array
	 */
	protected $collDocumentsRelatedByUpdatedBy;

	/**
	 * The criteria used to select the current contents of collDocumentsRelatedByUpdatedBy.
	 * @var        Criteria
	 */
	protected $lastDocumentRelatedByUpdatedByCriteria = null;

	/**
	 * Collection to store aggregation of collTagInstances.
	 * @var        array
	 */
	protected $collTagInstances;

	/**
	 * The criteria used to select the current contents of collTagInstances.
	 * @var        Criteria
	 */
	protected $lastTagInstanceCriteria = null;

	/**
	 * Collection to store aggregation of collLinksRelatedByOwnerId.
	 * @var        array
	 */
	protected $collLinksRelatedByOwnerId;

	/**
	 * The criteria used to select the current contents of collLinksRelatedByOwnerId.
	 * @var        Criteria
	 */
	protected $lastLinkRelatedByOwnerIdCriteria = null;

	/**
	 * Collection to store aggregation of collLinksRelatedByCreatedBy.
	 * @var        array
	 */
	protected $collLinksRelatedByCreatedBy;

	/**
	 * The criteria used to select the current contents of collLinksRelatedByCreatedBy.
	 * @var        Criteria
	 */
	protected $lastLinkRelatedByCreatedByCriteria = null;

	/**
	 * Collection to store aggregation of collLinksRelatedByUpdatedBy.
	 * @var        array
	 */
	protected $collLinksRelatedByUpdatedBy;

	/**
	 * The criteria used to select the current contents of collLinksRelatedByUpdatedBy.
	 * @var        Criteria
	 */
	protected $lastLinkRelatedByUpdatedByCriteria = null;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{

		return $this->id;
	}

	/**
	 * Get the [username] column value.
	 * 
	 * @return     string
	 */
	public function getUsername()
	{

		return $this->username;
	}

	/**
	 * Get the [password] column value.
	 * 
	 * @return     string
	 */
	public function getPassword()
	{

		return $this->password;
	}

	/**
	 * Get the [first_name] column value.
	 * 
	 * @return     string
	 */
	public function getFirstName()
	{

		return $this->first_name;
	}

	/**
	 * Get the [last_name] column value.
	 * 
	 * @return     string
	 */
	public function getLastName()
	{

		return $this->last_name;
	}

	/**
	 * Get the [email] column value.
	 * 
	 * @return     string
	 */
	public function getEmail()
	{

		return $this->email;
	}

	/**
	 * Get the [language_id] column value.
	 * 
	 * @return     string
	 */
	public function getLanguageId()
	{

		return $this->language_id;
	}

	/**
	 * Get the [is_admin] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsAdmin()
	{

		return $this->is_admin;
	}

	/**
	 * Get the [is_backend_login_enabled] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsBackendLoginEnabled()
	{

		return $this->is_backend_login_enabled;
	}

	/**
	 * Get the [is_inactive] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsInactive()
	{

		return $this->is_inactive;
	}

	/**
	 * Get the [password_recover_hint] column value.
	 * 
	 * @return     string
	 */
	public function getPasswordRecoverHint()
	{

		return $this->password_recover_hint;
	}

	/**
	 * Get the [backend_settings] column value.
	 * 
	 * @return     string
	 */
	public function getBackendSettings()
	{

		return $this->backend_settings;
	}

	/**
	 * Get the [created_by] column value.
	 * 
	 * @return     int
	 */
	public function getCreatedBy()
	{

		return $this->created_by;
	}

	/**
	 * Get the [updated_by] column value.
	 * 
	 * @return     int
	 */
	public function getUpdatedBy()
	{

		return $this->updated_by;
	}

	/**
	 * Get the [optionally formatted] [created_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	/**
	 * Get the [optionally formatted] [updated_at] column value.
	 * 
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the integer unix timestamp will be returned.
	 * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
	 * @throws     PropelException - if unable to convert the date/time to timestamp.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
			// a non-timestamp value was set externally, so we convert it
			$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = UserPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUsername($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = UserPeer::USERNAME;
		}

	} // setUsername()

	/**
	 * Set the value of [password] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPassword($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD;
		}

	} // setPassword()

	/**
	 * Set the value of [first_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setFirstName($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->first_name !== $v) {
			$this->first_name = $v;
			$this->modifiedColumns[] = UserPeer::FIRST_NAME;
		}

	} // setFirstName()

	/**
	 * Set the value of [last_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLastName($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->last_name !== $v) {
			$this->last_name = $v;
			$this->modifiedColumns[] = UserPeer::LAST_NAME;
		}

	} // setLastName()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setEmail($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL;
		}

	} // setEmail()

	/**
	 * Set the value of [language_id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLanguageId($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->language_id !== $v) {
			$this->language_id = $v;
			$this->modifiedColumns[] = UserPeer::LANGUAGE_ID;
		}

		if ($this->aLanguage !== null && $this->aLanguage->getId() !== $v) {
			$this->aLanguage = null;
		}

	} // setLanguageId()

	/**
	 * Set the value of [is_admin] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsAdmin($v)
	{

		if ($this->is_admin !== $v || $v === false) {
			$this->is_admin = $v;
			$this->modifiedColumns[] = UserPeer::IS_ADMIN;
		}

	} // setIsAdmin()

	/**
	 * Set the value of [is_backend_login_enabled] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsBackendLoginEnabled($v)
	{

		if ($this->is_backend_login_enabled !== $v || $v === true) {
			$this->is_backend_login_enabled = $v;
			$this->modifiedColumns[] = UserPeer::IS_BACKEND_LOGIN_ENABLED;
		}

	} // setIsBackendLoginEnabled()

	/**
	 * Set the value of [is_inactive] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsInactive($v)
	{

		if ($this->is_inactive !== $v || $v === false) {
			$this->is_inactive = $v;
			$this->modifiedColumns[] = UserPeer::IS_INACTIVE;
		}

	} // setIsInactive()

	/**
	 * Set the value of [password_recover_hint] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPasswordRecoverHint($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->password_recover_hint !== $v) {
			$this->password_recover_hint = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD_RECOVER_HINT;
		}

	} // setPasswordRecoverHint()

	/**
	 * Set the value of [backend_settings] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setBackendSettings($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->backend_settings !== $v) {
			$this->backend_settings = $v;
			$this->modifiedColumns[] = UserPeer::BACKEND_SETTINGS;
		}

	} // setBackendSettings()

	/**
	 * Set the value of [created_by] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCreatedBy($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = UserPeer::CREATED_BY;
		}

		if ($this->aUserRelatedByCreatedBy !== null && $this->aUserRelatedByCreatedBy->getId() !== $v) {
			$this->aUserRelatedByCreatedBy = null;
		}

	} // setCreatedBy()

	/**
	 * Set the value of [updated_by] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUpdatedBy($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = UserPeer::UPDATED_BY;
		}

		if ($this->aUserRelatedByUpdatedBy !== null && $this->aUserRelatedByUpdatedBy->getId() !== $v) {
			$this->aUserRelatedByUpdatedBy = null;
		}

	} // setUpdatedBy()

	/**
	 * Set the value of [created_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = UserPeer::CREATED_AT;
		}

	} // setCreatedAt()

	/**
	 * Set the value of [updated_at] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { // in PHP 5.1 return value changes to FALSE
				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = UserPeer::UPDATED_AT;
		}

	} // setUpdatedAt()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (1-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      ResultSet $rs The ResultSet class with cursor advanced to desired record pos.
	 * @param      int $startcol 1-based offset column which indicates which restultset column to start with.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->username = $rs->getString($startcol + 1);

			$this->password = $rs->getString($startcol + 2);

			$this->first_name = $rs->getString($startcol + 3);

			$this->last_name = $rs->getString($startcol + 4);

			$this->email = $rs->getString($startcol + 5);

			$this->language_id = $rs->getString($startcol + 6);

			$this->is_admin = $rs->getBoolean($startcol + 7);

			$this->is_backend_login_enabled = $rs->getBoolean($startcol + 8);

			$this->is_inactive = $rs->getBoolean($startcol + 9);

			$this->password_recover_hint = $rs->getString($startcol + 10);

			$this->backend_settings = $rs->getString($startcol + 11);

			$this->created_by = $rs->getInt($startcol + 12);

			$this->updated_by = $rs->getInt($startcol + 13);

			$this->created_at = $rs->getTimestamp($startcol + 14, null);

			$this->updated_at = $rs->getTimestamp($startcol + 15, null);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 16; // 16 = UserPeer::NUM_COLUMNS - UserPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
		}
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      Connection $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			UserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.  If the object is new,
	 * it inserts it; otherwise an update is performed.  This method
	 * wraps the doSave() worker method in a transaction.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	/**
	 * Stores the object in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      Connection $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave($con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLanguage !== null) {
				if ($this->aLanguage->isModified()) {
					$affectedRows += $this->aLanguage->save($con);
				}
				$this->setLanguage($this->aLanguage);
			}

			if ($this->aUserRelatedByCreatedBy !== null) {
				if ($this->aUserRelatedByCreatedBy->isModified()) {
					$affectedRows += $this->aUserRelatedByCreatedBy->save($con);
				}
				$this->setUserRelatedByCreatedBy($this->aUserRelatedByCreatedBy);
			}

			if ($this->aUserRelatedByUpdatedBy !== null) {
				if ($this->aUserRelatedByUpdatedBy->isModified()) {
					$affectedRows += $this->aUserRelatedByUpdatedBy->save($con);
				}
				$this->setUserRelatedByUpdatedBy($this->aUserRelatedByUpdatedBy);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = UserPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPagesRelatedByCreatedBy !== null) {
				foreach($this->collPagesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPagesRelatedByUpdatedBy !== null) {
				foreach($this->collPagesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectsRelatedByCreatedBy !== null) {
				foreach($this->collLanguageObjectsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectsRelatedByUpdatedBy !== null) {
				foreach($this->collLanguageObjectsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectHistorys !== null) {
				foreach($this->collLanguageObjectHistorys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUsersRelatedByCreatedBy !== null) {
				foreach($this->collUsersRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUsersRelatedByUpdatedBy !== null) {
				foreach($this->collUsersRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupsRelatedByCreatedBy !== null) {
				foreach($this->collGroupsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupsRelatedByUpdatedBy !== null) {
				foreach($this->collGroupsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserGroups !== null) {
				foreach($this->collUserGroups as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentsRelatedByOwnerId !== null) {
				foreach($this->collDocumentsRelatedByOwnerId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentsRelatedByCreatedBy !== null) {
				foreach($this->collDocumentsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentsRelatedByUpdatedBy !== null) {
				foreach($this->collDocumentsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTagInstances !== null) {
				foreach($this->collTagInstances as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinksRelatedByOwnerId !== null) {
				foreach($this->collLinksRelatedByOwnerId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinksRelatedByCreatedBy !== null) {
				foreach($this->collLinksRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinksRelatedByUpdatedBy !== null) {
				foreach($this->collLinksRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLanguage !== null) {
				if (!$this->aLanguage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aLanguage->getValidationFailures());
				}
			}

			if ($this->aUserRelatedByCreatedBy !== null) {
				if (!$this->aUserRelatedByCreatedBy->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByCreatedBy->getValidationFailures());
				}
			}

			if ($this->aUserRelatedByUpdatedBy !== null) {
				if (!$this->aUserRelatedByUpdatedBy->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByUpdatedBy->getValidationFailures());
				}
			}


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPagesRelatedByCreatedBy !== null) {
					foreach($this->collPagesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPagesRelatedByUpdatedBy !== null) {
					foreach($this->collPagesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectsRelatedByCreatedBy !== null) {
					foreach($this->collLanguageObjectsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectsRelatedByUpdatedBy !== null) {
					foreach($this->collLanguageObjectsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectHistorys !== null) {
					foreach($this->collLanguageObjectHistorys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupsRelatedByCreatedBy !== null) {
					foreach($this->collGroupsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupsRelatedByUpdatedBy !== null) {
					foreach($this->collGroupsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserGroups !== null) {
					foreach($this->collUserGroups as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentsRelatedByOwnerId !== null) {
					foreach($this->collDocumentsRelatedByOwnerId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentsRelatedByCreatedBy !== null) {
					foreach($this->collDocumentsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentsRelatedByUpdatedBy !== null) {
					foreach($this->collDocumentsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTagInstances !== null) {
					foreach($this->collTagInstances as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinksRelatedByOwnerId !== null) {
					foreach($this->collLinksRelatedByOwnerId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinksRelatedByCreatedBy !== null) {
					foreach($this->collLinksRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinksRelatedByUpdatedBy !== null) {
					foreach($this->collLinksRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUsername();
				break;
			case 2:
				return $this->getPassword();
				break;
			case 3:
				return $this->getFirstName();
				break;
			case 4:
				return $this->getLastName();
				break;
			case 5:
				return $this->getEmail();
				break;
			case 6:
				return $this->getLanguageId();
				break;
			case 7:
				return $this->getIsAdmin();
				break;
			case 8:
				return $this->getIsBackendLoginEnabled();
				break;
			case 9:
				return $this->getIsInactive();
				break;
			case 10:
				return $this->getPasswordRecoverHint();
				break;
			case 11:
				return $this->getBackendSettings();
				break;
			case 12:
				return $this->getCreatedBy();
				break;
			case 13:
				return $this->getUpdatedBy();
				break;
			case 14:
				return $this->getCreatedAt();
				break;
			case 15:
				return $this->getUpdatedAt();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType One of the class type constants TYPE_PHPNAME,
	 *                        TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getPassword(),
			$keys[3] => $this->getFirstName(),
			$keys[4] => $this->getLastName(),
			$keys[5] => $this->getEmail(),
			$keys[6] => $this->getLanguageId(),
			$keys[7] => $this->getIsAdmin(),
			$keys[8] => $this->getIsBackendLoginEnabled(),
			$keys[9] => $this->getIsInactive(),
			$keys[10] => $this->getPasswordRecoverHint(),
			$keys[11] => $this->getBackendSettings(),
			$keys[12] => $this->getCreatedBy(),
			$keys[13] => $this->getUpdatedBy(),
			$keys[14] => $this->getCreatedAt(),
			$keys[15] => $this->getUpdatedAt(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUsername($value);
				break;
			case 2:
				$this->setPassword($value);
				break;
			case 3:
				$this->setFirstName($value);
				break;
			case 4:
				$this->setLastName($value);
				break;
			case 5:
				$this->setEmail($value);
				break;
			case 6:
				$this->setLanguageId($value);
				break;
			case 7:
				$this->setIsAdmin($value);
				break;
			case 8:
				$this->setIsBackendLoginEnabled($value);
				break;
			case 9:
				$this->setIsInactive($value);
				break;
			case 10:
				$this->setPasswordRecoverHint($value);
				break;
			case 11:
				$this->setBackendSettings($value);
				break;
			case 12:
				$this->setCreatedBy($value);
				break;
			case 13:
				$this->setUpdatedBy($value);
				break;
			case 14:
				$this->setCreatedAt($value);
				break;
			case 15:
				$this->setUpdatedAt($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME,
	 * TYPE_NUM. The default key type is the column's phpname (e.g. 'authorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUsername($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPassword($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFirstName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLastName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLanguageId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsAdmin($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsBackendLoginEnabled($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsInactive($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPasswordRecoverHint($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setBackendSettings($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCreatedBy($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setUpdatedBy($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCreatedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUpdatedAt($arr[$keys[15]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::USERNAME)) $criteria->add(UserPeer::USERNAME, $this->username);
		if ($this->isColumnModified(UserPeer::PASSWORD)) $criteria->add(UserPeer::PASSWORD, $this->password);
		if ($this->isColumnModified(UserPeer::FIRST_NAME)) $criteria->add(UserPeer::FIRST_NAME, $this->first_name);
		if ($this->isColumnModified(UserPeer::LAST_NAME)) $criteria->add(UserPeer::LAST_NAME, $this->last_name);
		if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(UserPeer::LANGUAGE_ID)) $criteria->add(UserPeer::LANGUAGE_ID, $this->language_id);
		if ($this->isColumnModified(UserPeer::IS_ADMIN)) $criteria->add(UserPeer::IS_ADMIN, $this->is_admin);
		if ($this->isColumnModified(UserPeer::IS_BACKEND_LOGIN_ENABLED)) $criteria->add(UserPeer::IS_BACKEND_LOGIN_ENABLED, $this->is_backend_login_enabled);
		if ($this->isColumnModified(UserPeer::IS_INACTIVE)) $criteria->add(UserPeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(UserPeer::PASSWORD_RECOVER_HINT)) $criteria->add(UserPeer::PASSWORD_RECOVER_HINT, $this->password_recover_hint);
		if ($this->isColumnModified(UserPeer::BACKEND_SETTINGS)) $criteria->add(UserPeer::BACKEND_SETTINGS, $this->backend_settings);
		if ($this->isColumnModified(UserPeer::CREATED_BY)) $criteria->add(UserPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(UserPeer::UPDATED_BY)) $criteria->add(UserPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserPeer::UPDATED_AT)) $criteria->add(UserPeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of User (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setUsername($this->username);

		$copyObj->setPassword($this->password);

		$copyObj->setFirstName($this->first_name);

		$copyObj->setLastName($this->last_name);

		$copyObj->setEmail($this->email);

		$copyObj->setLanguageId($this->language_id);

		$copyObj->setIsAdmin($this->is_admin);

		$copyObj->setIsBackendLoginEnabled($this->is_backend_login_enabled);

		$copyObj->setIsInactive($this->is_inactive);

		$copyObj->setPasswordRecoverHint($this->password_recover_hint);

		$copyObj->setBackendSettings($this->backend_settings);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPagesRelatedByCreatedBy() as $relObj) {
				$copyObj->addPageRelatedByCreatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getPagesRelatedByUpdatedBy() as $relObj) {
				$copyObj->addPageRelatedByUpdatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageObjectsRelatedByCreatedBy() as $relObj) {
				$copyObj->addLanguageObjectRelatedByCreatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageObjectsRelatedByUpdatedBy() as $relObj) {
				$copyObj->addLanguageObjectRelatedByUpdatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageObjectHistorys() as $relObj) {
				$copyObj->addLanguageObjectHistory($relObj->copy($deepCopy));
			}

			foreach($this->getUsersRelatedByCreatedBy() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addUserRelatedByCreatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getUsersRelatedByUpdatedBy() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addUserRelatedByUpdatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getGroupsRelatedByCreatedBy() as $relObj) {
				$copyObj->addGroupRelatedByCreatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getGroupsRelatedByUpdatedBy() as $relObj) {
				$copyObj->addGroupRelatedByUpdatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getUserGroups() as $relObj) {
				$copyObj->addUserGroup($relObj->copy($deepCopy));
			}

			foreach($this->getDocumentsRelatedByOwnerId() as $relObj) {
				$copyObj->addDocumentRelatedByOwnerId($relObj->copy($deepCopy));
			}

			foreach($this->getDocumentsRelatedByCreatedBy() as $relObj) {
				$copyObj->addDocumentRelatedByCreatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getDocumentsRelatedByUpdatedBy() as $relObj) {
				$copyObj->addDocumentRelatedByUpdatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getTagInstances() as $relObj) {
				$copyObj->addTagInstance($relObj->copy($deepCopy));
			}

			foreach($this->getLinksRelatedByOwnerId() as $relObj) {
				$copyObj->addLinkRelatedByOwnerId($relObj->copy($deepCopy));
			}

			foreach($this->getLinksRelatedByCreatedBy() as $relObj) {
				$copyObj->addLinkRelatedByCreatedBy($relObj->copy($deepCopy));
			}

			foreach($this->getLinksRelatedByUpdatedBy() as $relObj) {
				$copyObj->addLinkRelatedByUpdatedBy($relObj->copy($deepCopy));
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a pkey column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     User Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     UserPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new UserPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Language object.
	 *
	 * @param      Language $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setLanguage($v)
	{


		if ($v === null) {
			$this->setLanguageId(NULL);
		} else {
			$this->setLanguageId($v->getId());
		}


		$this->aLanguage = $v;
	}


	/**
	 * Get the associated Language object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Language The associated Language object.
	 * @throws     PropelException
	 */
	public function getLanguage($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BaseLanguagePeer.php';

		if ($this->aLanguage === null && (($this->language_id !== "" && $this->language_id !== null))) {

			$this->aLanguage = LanguagePeer::retrieveByPK($this->language_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = LanguagePeer::retrieveByPK($this->language_id, $con);
			   $obj->addLanguages($this);
			 */
		}
		return $this->aLanguage;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setUserRelatedByCreatedBy($v)
	{


		if ($v === null) {
			$this->setCreatedBy(NULL);
		} else {
			$this->setCreatedBy($v->getId());
		}


		$this->aUserRelatedByCreatedBy = $v;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByCreatedBy($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BaseUserPeer.php';

		if ($this->aUserRelatedByCreatedBy === null && ($this->created_by !== null)) {

			$this->aUserRelatedByCreatedBy = UserPeer::retrieveByPK($this->created_by, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = UserPeer::retrieveByPK($this->created_by, $con);
			   $obj->addUsersRelatedByCreatedBy($this);
			 */
		}
		return $this->aUserRelatedByCreatedBy;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setUserRelatedByUpdatedBy($v)
	{


		if ($v === null) {
			$this->setUpdatedBy(NULL);
		} else {
			$this->setUpdatedBy($v->getId());
		}


		$this->aUserRelatedByUpdatedBy = $v;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByUpdatedBy($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BaseUserPeer.php';

		if ($this->aUserRelatedByUpdatedBy === null && ($this->updated_by !== null)) {

			$this->aUserRelatedByUpdatedBy = UserPeer::retrieveByPK($this->updated_by, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = UserPeer::retrieveByPK($this->updated_by, $con);
			   $obj->addUsersRelatedByUpdatedBy($this);
			 */
		}
		return $this->aUserRelatedByUpdatedBy;
	}

	/**
	 * Temporary storage of collPagesRelatedByCreatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPagesRelatedByCreatedBy()
	{
		if ($this->collPagesRelatedByCreatedBy === null) {
			$this->collPagesRelatedByCreatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related PagesRelatedByCreatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPagesRelatedByCreatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPagesRelatedByCreatedBy === null) {
			if ($this->isNew()) {
			   $this->collPagesRelatedByCreatedBy = array();
			} else {

				$criteria->add(PagePeer::CREATED_BY, $this->getId());

				PagePeer::addSelectColumns($criteria);
				$this->collPagesRelatedByCreatedBy = PagePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PagePeer::CREATED_BY, $this->getId());

				PagePeer::addSelectColumns($criteria);
				if (!isset($this->lastPageRelatedByCreatedByCriteria) || !$this->lastPageRelatedByCreatedByCriteria->equals($criteria)) {
					$this->collPagesRelatedByCreatedBy = PagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPageRelatedByCreatedByCriteria = $criteria;
		return $this->collPagesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related PagesRelatedByCreatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPagesRelatedByCreatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PagePeer::CREATED_BY, $this->getId());

		return PagePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Page object to this object
	 * through the Page foreign key attribute
	 *
	 * @param      Page $l Page
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPageRelatedByCreatedBy(Page $l)
	{
		$this->collPagesRelatedByCreatedBy[] = $l;
		$l->setUserRelatedByCreatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PagesRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getPagesRelatedByCreatedByJoinPageRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPagesRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collPagesRelatedByCreatedBy = array();
			} else {

				$criteria->add(PagePeer::CREATED_BY, $this->getId());

				$this->collPagesRelatedByCreatedBy = PagePeer::doSelectJoinPageRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PagePeer::CREATED_BY, $this->getId());

			if (!isset($this->lastPageRelatedByCreatedByCriteria) || !$this->lastPageRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collPagesRelatedByCreatedBy = PagePeer::doSelectJoinPageRelatedByParentId($criteria, $con);
			}
		}
		$this->lastPageRelatedByCreatedByCriteria = $criteria;

		return $this->collPagesRelatedByCreatedBy;
	}

	/**
	 * Temporary storage of collPagesRelatedByUpdatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPagesRelatedByUpdatedBy()
	{
		if ($this->collPagesRelatedByUpdatedBy === null) {
			$this->collPagesRelatedByUpdatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related PagesRelatedByUpdatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPagesRelatedByUpdatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPagesRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
			   $this->collPagesRelatedByUpdatedBy = array();
			} else {

				$criteria->add(PagePeer::UPDATED_BY, $this->getId());

				PagePeer::addSelectColumns($criteria);
				$this->collPagesRelatedByUpdatedBy = PagePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PagePeer::UPDATED_BY, $this->getId());

				PagePeer::addSelectColumns($criteria);
				if (!isset($this->lastPageRelatedByUpdatedByCriteria) || !$this->lastPageRelatedByUpdatedByCriteria->equals($criteria)) {
					$this->collPagesRelatedByUpdatedBy = PagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPageRelatedByUpdatedByCriteria = $criteria;
		return $this->collPagesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related PagesRelatedByUpdatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPagesRelatedByUpdatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PagePeer::UPDATED_BY, $this->getId());

		return PagePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Page object to this object
	 * through the Page foreign key attribute
	 *
	 * @param      Page $l Page
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPageRelatedByUpdatedBy(Page $l)
	{
		$this->collPagesRelatedByUpdatedBy[] = $l;
		$l->setUserRelatedByUpdatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PagesRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getPagesRelatedByUpdatedByJoinPageRelatedByParentId($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPagesRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collPagesRelatedByUpdatedBy = array();
			} else {

				$criteria->add(PagePeer::UPDATED_BY, $this->getId());

				$this->collPagesRelatedByUpdatedBy = PagePeer::doSelectJoinPageRelatedByParentId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PagePeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastPageRelatedByUpdatedByCriteria) || !$this->lastPageRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collPagesRelatedByUpdatedBy = PagePeer::doSelectJoinPageRelatedByParentId($criteria, $con);
			}
		}
		$this->lastPageRelatedByUpdatedByCriteria = $criteria;

		return $this->collPagesRelatedByUpdatedBy;
	}

	/**
	 * Temporary storage of collLanguageObjectsRelatedByCreatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguageObjectsRelatedByCreatedBy()
	{
		if ($this->collLanguageObjectsRelatedByCreatedBy === null) {
			$this->collLanguageObjectsRelatedByCreatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related LanguageObjectsRelatedByCreatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguageObjectsRelatedByCreatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
			   $this->collLanguageObjectsRelatedByCreatedBy = array();
			} else {

				$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

				LanguageObjectPeer::addSelectColumns($criteria);
				$this->collLanguageObjectsRelatedByCreatedBy = LanguageObjectPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

				LanguageObjectPeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageObjectRelatedByCreatedByCriteria) || !$this->lastLanguageObjectRelatedByCreatedByCriteria->equals($criteria)) {
					$this->collLanguageObjectsRelatedByCreatedBy = LanguageObjectPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageObjectRelatedByCreatedByCriteria = $criteria;
		return $this->collLanguageObjectsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related LanguageObjectsRelatedByCreatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguageObjectsRelatedByCreatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

		return LanguageObjectPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a LanguageObject object to this object
	 * through the LanguageObject foreign key attribute
	 *
	 * @param      LanguageObject $l LanguageObject
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLanguageObjectRelatedByCreatedBy(LanguageObject $l)
	{
		$this->collLanguageObjectsRelatedByCreatedBy[] = $l;
		$l->setUserRelatedByCreatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLanguageObjectsRelatedByCreatedByJoinContentObject($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collLanguageObjectsRelatedByCreatedBy = array();
			} else {

				$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

				$this->collLanguageObjectsRelatedByCreatedBy = LanguageObjectPeer::doSelectJoinContentObject($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastLanguageObjectRelatedByCreatedByCriteria) || !$this->lastLanguageObjectRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collLanguageObjectsRelatedByCreatedBy = LanguageObjectPeer::doSelectJoinContentObject($criteria, $con);
			}
		}
		$this->lastLanguageObjectRelatedByCreatedByCriteria = $criteria;

		return $this->collLanguageObjectsRelatedByCreatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLanguageObjectsRelatedByCreatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collLanguageObjectsRelatedByCreatedBy = array();
			} else {

				$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

				$this->collLanguageObjectsRelatedByCreatedBy = LanguageObjectPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastLanguageObjectRelatedByCreatedByCriteria) || !$this->lastLanguageObjectRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collLanguageObjectsRelatedByCreatedBy = LanguageObjectPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastLanguageObjectRelatedByCreatedByCriteria = $criteria;

		return $this->collLanguageObjectsRelatedByCreatedBy;
	}

	/**
	 * Temporary storage of collLanguageObjectsRelatedByUpdatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguageObjectsRelatedByUpdatedBy()
	{
		if ($this->collLanguageObjectsRelatedByUpdatedBy === null) {
			$this->collLanguageObjectsRelatedByUpdatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related LanguageObjectsRelatedByUpdatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguageObjectsRelatedByUpdatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
			   $this->collLanguageObjectsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

				LanguageObjectPeer::addSelectColumns($criteria);
				$this->collLanguageObjectsRelatedByUpdatedBy = LanguageObjectPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

				LanguageObjectPeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageObjectRelatedByUpdatedByCriteria) || !$this->lastLanguageObjectRelatedByUpdatedByCriteria->equals($criteria)) {
					$this->collLanguageObjectsRelatedByUpdatedBy = LanguageObjectPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageObjectRelatedByUpdatedByCriteria = $criteria;
		return $this->collLanguageObjectsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related LanguageObjectsRelatedByUpdatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguageObjectsRelatedByUpdatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

		return LanguageObjectPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a LanguageObject object to this object
	 * through the LanguageObject foreign key attribute
	 *
	 * @param      LanguageObject $l LanguageObject
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLanguageObjectRelatedByUpdatedBy(LanguageObject $l)
	{
		$this->collLanguageObjectsRelatedByUpdatedBy[] = $l;
		$l->setUserRelatedByUpdatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLanguageObjectsRelatedByUpdatedByJoinContentObject($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collLanguageObjectsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

				$this->collLanguageObjectsRelatedByUpdatedBy = LanguageObjectPeer::doSelectJoinContentObject($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastLanguageObjectRelatedByUpdatedByCriteria) || !$this->lastLanguageObjectRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collLanguageObjectsRelatedByUpdatedBy = LanguageObjectPeer::doSelectJoinContentObject($criteria, $con);
			}
		}
		$this->lastLanguageObjectRelatedByUpdatedByCriteria = $criteria;

		return $this->collLanguageObjectsRelatedByUpdatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLanguageObjectsRelatedByUpdatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collLanguageObjectsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

				$this->collLanguageObjectsRelatedByUpdatedBy = LanguageObjectPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastLanguageObjectRelatedByUpdatedByCriteria) || !$this->lastLanguageObjectRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collLanguageObjectsRelatedByUpdatedBy = LanguageObjectPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastLanguageObjectRelatedByUpdatedByCriteria = $criteria;

		return $this->collLanguageObjectsRelatedByUpdatedBy;
	}

	/**
	 * Temporary storage of collLanguageObjectHistorys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguageObjectHistorys()
	{
		if ($this->collLanguageObjectHistorys === null) {
			$this->collLanguageObjectHistorys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorys from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguageObjectHistorys($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectHistorys === null) {
			if ($this->isNew()) {
			   $this->collLanguageObjectHistorys = array();
			} else {

				$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

				LanguageObjectHistoryPeer::addSelectColumns($criteria);
				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

				LanguageObjectHistoryPeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageObjectHistoryCriteria) || !$this->lastLanguageObjectHistoryCriteria->equals($criteria)) {
					$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageObjectHistoryCriteria = $criteria;
		return $this->collLanguageObjectHistorys;
	}

	/**
	 * Returns the number of related LanguageObjectHistorys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguageObjectHistorys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

		return LanguageObjectHistoryPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a LanguageObjectHistory object to this object
	 * through the LanguageObjectHistory foreign key attribute
	 *
	 * @param      LanguageObjectHistory $l LanguageObjectHistory
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLanguageObjectHistory(LanguageObjectHistory $l)
	{
		$this->collLanguageObjectHistorys[] = $l;
		$l->setUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLanguageObjectHistorysJoinContentObject($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectHistorys === null) {
			if ($this->isNew()) {
				$this->collLanguageObjectHistorys = array();
			} else {

				$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinContentObject($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastLanguageObjectHistoryCriteria) || !$this->lastLanguageObjectHistoryCriteria->equals($criteria)) {
				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinContentObject($criteria, $con);
			}
		}
		$this->lastLanguageObjectHistoryCriteria = $criteria;

		return $this->collLanguageObjectHistorys;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLanguageObjectHistorysJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLanguageObjectHistoryPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLanguageObjectHistorys === null) {
			if ($this->isNew()) {
				$this->collLanguageObjectHistorys = array();
			} else {

				$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectHistoryPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastLanguageObjectHistoryCriteria) || !$this->lastLanguageObjectHistoryCriteria->equals($criteria)) {
				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastLanguageObjectHistoryCriteria = $criteria;

		return $this->collLanguageObjectHistorys;
	}

	/**
	 * Temporary storage of collUsersRelatedByCreatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUsersRelatedByCreatedBy()
	{
		if ($this->collUsersRelatedByCreatedBy === null) {
			$this->collUsersRelatedByCreatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related UsersRelatedByCreatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUsersRelatedByCreatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsersRelatedByCreatedBy === null) {
			if ($this->isNew()) {
			   $this->collUsersRelatedByCreatedBy = array();
			} else {

				$criteria->add(UserPeer::CREATED_BY, $this->getId());

				UserPeer::addSelectColumns($criteria);
				$this->collUsersRelatedByCreatedBy = UserPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserPeer::CREATED_BY, $this->getId());

				UserPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserRelatedByCreatedByCriteria) || !$this->lastUserRelatedByCreatedByCriteria->equals($criteria)) {
					$this->collUsersRelatedByCreatedBy = UserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserRelatedByCreatedByCriteria = $criteria;
		return $this->collUsersRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related UsersRelatedByCreatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUsersRelatedByCreatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserPeer::CREATED_BY, $this->getId());

		return UserPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a User object to this object
	 * through the User foreign key attribute
	 *
	 * @param      User $l User
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserRelatedByCreatedBy(User $l)
	{
		$this->collUsersRelatedByCreatedBy[] = $l;
		$l->setUserRelatedByCreatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UsersRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUsersRelatedByCreatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsersRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collUsersRelatedByCreatedBy = array();
			} else {

				$criteria->add(UserPeer::CREATED_BY, $this->getId());

				$this->collUsersRelatedByCreatedBy = UserPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastUserRelatedByCreatedByCriteria) || !$this->lastUserRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collUsersRelatedByCreatedBy = UserPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastUserRelatedByCreatedByCriteria = $criteria;

		return $this->collUsersRelatedByCreatedBy;
	}

	/**
	 * Temporary storage of collUsersRelatedByUpdatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUsersRelatedByUpdatedBy()
	{
		if ($this->collUsersRelatedByUpdatedBy === null) {
			$this->collUsersRelatedByUpdatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related UsersRelatedByUpdatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUsersRelatedByUpdatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsersRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
			   $this->collUsersRelatedByUpdatedBy = array();
			} else {

				$criteria->add(UserPeer::UPDATED_BY, $this->getId());

				UserPeer::addSelectColumns($criteria);
				$this->collUsersRelatedByUpdatedBy = UserPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserPeer::UPDATED_BY, $this->getId());

				UserPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserRelatedByUpdatedByCriteria) || !$this->lastUserRelatedByUpdatedByCriteria->equals($criteria)) {
					$this->collUsersRelatedByUpdatedBy = UserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserRelatedByUpdatedByCriteria = $criteria;
		return $this->collUsersRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related UsersRelatedByUpdatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUsersRelatedByUpdatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserPeer::UPDATED_BY, $this->getId());

		return UserPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a User object to this object
	 * through the User foreign key attribute
	 *
	 * @param      User $l User
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserRelatedByUpdatedBy(User $l)
	{
		$this->collUsersRelatedByUpdatedBy[] = $l;
		$l->setUserRelatedByUpdatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UsersRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUsersRelatedByUpdatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUsersRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collUsersRelatedByUpdatedBy = array();
			} else {

				$criteria->add(UserPeer::UPDATED_BY, $this->getId());

				$this->collUsersRelatedByUpdatedBy = UserPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastUserRelatedByUpdatedByCriteria) || !$this->lastUserRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collUsersRelatedByUpdatedBy = UserPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastUserRelatedByUpdatedByCriteria = $criteria;

		return $this->collUsersRelatedByUpdatedBy;
	}

	/**
	 * Temporary storage of collGroupsRelatedByCreatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGroupsRelatedByCreatedBy()
	{
		if ($this->collGroupsRelatedByCreatedBy === null) {
			$this->collGroupsRelatedByCreatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related GroupsRelatedByCreatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGroupsRelatedByCreatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
			   $this->collGroupsRelatedByCreatedBy = array();
			} else {

				$criteria->add(GroupPeer::CREATED_BY, $this->getId());

				GroupPeer::addSelectColumns($criteria);
				$this->collGroupsRelatedByCreatedBy = GroupPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GroupPeer::CREATED_BY, $this->getId());

				GroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastGroupRelatedByCreatedByCriteria) || !$this->lastGroupRelatedByCreatedByCriteria->equals($criteria)) {
					$this->collGroupsRelatedByCreatedBy = GroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGroupRelatedByCreatedByCriteria = $criteria;
		return $this->collGroupsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related GroupsRelatedByCreatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGroupsRelatedByCreatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GroupPeer::CREATED_BY, $this->getId());

		return GroupPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Group object to this object
	 * through the Group foreign key attribute
	 *
	 * @param      Group $l Group
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGroupRelatedByCreatedBy(Group $l)
	{
		$this->collGroupsRelatedByCreatedBy[] = $l;
		$l->setUserRelatedByCreatedBy($this);
	}

	/**
	 * Temporary storage of collGroupsRelatedByUpdatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initGroupsRelatedByUpdatedBy()
	{
		if ($this->collGroupsRelatedByUpdatedBy === null) {
			$this->collGroupsRelatedByUpdatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related GroupsRelatedByUpdatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getGroupsRelatedByUpdatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collGroupsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
			   $this->collGroupsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(GroupPeer::UPDATED_BY, $this->getId());

				GroupPeer::addSelectColumns($criteria);
				$this->collGroupsRelatedByUpdatedBy = GroupPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(GroupPeer::UPDATED_BY, $this->getId());

				GroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastGroupRelatedByUpdatedByCriteria) || !$this->lastGroupRelatedByUpdatedByCriteria->equals($criteria)) {
					$this->collGroupsRelatedByUpdatedBy = GroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastGroupRelatedByUpdatedByCriteria = $criteria;
		return $this->collGroupsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related GroupsRelatedByUpdatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countGroupsRelatedByUpdatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(GroupPeer::UPDATED_BY, $this->getId());

		return GroupPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Group object to this object
	 * through the Group foreign key attribute
	 *
	 * @param      Group $l Group
	 * @return     void
	 * @throws     PropelException
	 */
	public function addGroupRelatedByUpdatedBy(Group $l)
	{
		$this->collGroupsRelatedByUpdatedBy[] = $l;
		$l->setUserRelatedByUpdatedBy($this);
	}

	/**
	 * Temporary storage of collUserGroups to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUserGroups()
	{
		if ($this->collUserGroups === null) {
			$this->collUserGroups = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related UserGroups from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUserGroups($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserGroups === null) {
			if ($this->isNew()) {
			   $this->collUserGroups = array();
			} else {

				$criteria->add(UserGroupPeer::USER_ID, $this->getId());

				UserGroupPeer::addSelectColumns($criteria);
				$this->collUserGroups = UserGroupPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserGroupPeer::USER_ID, $this->getId());

				UserGroupPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserGroupCriteria) || !$this->lastUserGroupCriteria->equals($criteria)) {
					$this->collUserGroups = UserGroupPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserGroupCriteria = $criteria;
		return $this->collUserGroups;
	}

	/**
	 * Returns the number of related UserGroups.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUserGroups($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(UserGroupPeer::USER_ID, $this->getId());

		return UserGroupPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a UserGroup object to this object
	 * through the UserGroup foreign key attribute
	 *
	 * @param      UserGroup $l UserGroup
	 * @return     void
	 * @throws     PropelException
	 */
	public function addUserGroup(UserGroup $l)
	{
		$this->collUserGroups[] = $l;
		$l->setUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserGroups from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getUserGroupsJoinGroup($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseUserGroupPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collUserGroups === null) {
			if ($this->isNew()) {
				$this->collUserGroups = array();
			} else {

				$criteria->add(UserGroupPeer::USER_ID, $this->getId());

				$this->collUserGroups = UserGroupPeer::doSelectJoinGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserGroupPeer::USER_ID, $this->getId());

			if (!isset($this->lastUserGroupCriteria) || !$this->lastUserGroupCriteria->equals($criteria)) {
				$this->collUserGroups = UserGroupPeer::doSelectJoinGroup($criteria, $con);
			}
		}
		$this->lastUserGroupCriteria = $criteria;

		return $this->collUserGroups;
	}

	/**
	 * Temporary storage of collDocumentsRelatedByOwnerId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDocumentsRelatedByOwnerId()
	{
		if ($this->collDocumentsRelatedByOwnerId === null) {
			$this->collDocumentsRelatedByOwnerId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByOwnerId from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDocumentsRelatedByOwnerId($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByOwnerId === null) {
			if ($this->isNew()) {
			   $this->collDocumentsRelatedByOwnerId = array();
			} else {

				$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				if (!isset($this->lastDocumentRelatedByOwnerIdCriteria) || !$this->lastDocumentRelatedByOwnerIdCriteria->equals($criteria)) {
					$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDocumentRelatedByOwnerIdCriteria = $criteria;
		return $this->collDocumentsRelatedByOwnerId;
	}

	/**
	 * Returns the number of related DocumentsRelatedByOwnerId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDocumentsRelatedByOwnerId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

		return DocumentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Document object to this object
	 * through the Document foreign key attribute
	 *
	 * @param      Document $l Document
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDocumentRelatedByOwnerId(Document $l)
	{
		$this->collDocumentsRelatedByOwnerId[] = $l;
		$l->setUserRelatedByOwnerId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByOwnerId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByOwnerIdJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByOwnerId === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByOwnerId = array();
			} else {

				$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

			if (!isset($this->lastDocumentRelatedByOwnerIdCriteria) || !$this->lastDocumentRelatedByOwnerIdCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByOwnerIdCriteria = $criteria;

		return $this->collDocumentsRelatedByOwnerId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByOwnerId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByOwnerIdJoinDocumentType($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByOwnerId === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByOwnerId = array();
			} else {

				$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

			if (!isset($this->lastDocumentRelatedByOwnerIdCriteria) || !$this->lastDocumentRelatedByOwnerIdCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByOwnerIdCriteria = $criteria;

		return $this->collDocumentsRelatedByOwnerId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByOwnerId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByOwnerIdJoinDocumentCategory($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByOwnerId === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByOwnerId = array();
			} else {

				$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::OWNER_ID, $this->getId());

			if (!isset($this->lastDocumentRelatedByOwnerIdCriteria) || !$this->lastDocumentRelatedByOwnerIdCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByOwnerId = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByOwnerIdCriteria = $criteria;

		return $this->collDocumentsRelatedByOwnerId;
	}

	/**
	 * Temporary storage of collDocumentsRelatedByCreatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDocumentsRelatedByCreatedBy()
	{
		if ($this->collDocumentsRelatedByCreatedBy === null) {
			$this->collDocumentsRelatedByCreatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByCreatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDocumentsRelatedByCreatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
			   $this->collDocumentsRelatedByCreatedBy = array();
			} else {

				$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				if (!isset($this->lastDocumentRelatedByCreatedByCriteria) || !$this->lastDocumentRelatedByCreatedByCriteria->equals($criteria)) {
					$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDocumentRelatedByCreatedByCriteria = $criteria;
		return $this->collDocumentsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related DocumentsRelatedByCreatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDocumentsRelatedByCreatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

		return DocumentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Document object to this object
	 * through the Document foreign key attribute
	 *
	 * @param      Document $l Document
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDocumentRelatedByCreatedBy(Document $l)
	{
		$this->collDocumentsRelatedByCreatedBy[] = $l;
		$l->setUserRelatedByCreatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByCreatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByCreatedBy = array();
			} else {

				$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastDocumentRelatedByCreatedByCriteria) || !$this->lastDocumentRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByCreatedByCriteria = $criteria;

		return $this->collDocumentsRelatedByCreatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByCreatedByJoinDocumentType($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByCreatedBy = array();
			} else {

				$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastDocumentRelatedByCreatedByCriteria) || !$this->lastDocumentRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByCreatedByCriteria = $criteria;

		return $this->collDocumentsRelatedByCreatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByCreatedByJoinDocumentCategory($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByCreatedBy = array();
			} else {

				$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastDocumentRelatedByCreatedByCriteria) || !$this->lastDocumentRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByCreatedBy = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByCreatedByCriteria = $criteria;

		return $this->collDocumentsRelatedByCreatedBy;
	}

	/**
	 * Temporary storage of collDocumentsRelatedByUpdatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDocumentsRelatedByUpdatedBy()
	{
		if ($this->collDocumentsRelatedByUpdatedBy === null) {
			$this->collDocumentsRelatedByUpdatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByUpdatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDocumentsRelatedByUpdatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
			   $this->collDocumentsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				if (!isset($this->lastDocumentRelatedByUpdatedByCriteria) || !$this->lastDocumentRelatedByUpdatedByCriteria->equals($criteria)) {
					$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDocumentRelatedByUpdatedByCriteria = $criteria;
		return $this->collDocumentsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related DocumentsRelatedByUpdatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDocumentsRelatedByUpdatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

		return DocumentPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Document object to this object
	 * through the Document foreign key attribute
	 *
	 * @param      Document $l Document
	 * @return     void
	 * @throws     PropelException
	 */
	public function addDocumentRelatedByUpdatedBy(Document $l)
	{
		$this->collDocumentsRelatedByUpdatedBy[] = $l;
		$l->setUserRelatedByUpdatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByUpdatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastDocumentRelatedByUpdatedByCriteria) || !$this->lastDocumentRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByUpdatedByCriteria = $criteria;

		return $this->collDocumentsRelatedByUpdatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByUpdatedByJoinDocumentType($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastDocumentRelatedByUpdatedByCriteria) || !$this->lastDocumentRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByUpdatedByCriteria = $criteria;

		return $this->collDocumentsRelatedByUpdatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related DocumentsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getDocumentsRelatedByUpdatedByJoinDocumentCategory($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseDocumentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collDocumentsRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collDocumentsRelatedByUpdatedBy = array();
			} else {

				$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastDocumentRelatedByUpdatedByCriteria) || !$this->lastDocumentRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collDocumentsRelatedByUpdatedBy = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastDocumentRelatedByUpdatedByCriteria = $criteria;

		return $this->collDocumentsRelatedByUpdatedBy;
	}

	/**
	 * Temporary storage of collTagInstances to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initTagInstances()
	{
		if ($this->collTagInstances === null) {
			$this->collTagInstances = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related TagInstances from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getTagInstances($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseTagInstancePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTagInstances === null) {
			if ($this->isNew()) {
			   $this->collTagInstances = array();
			} else {

				$criteria->add(TagInstancePeer::CREATED_BY, $this->getId());

				TagInstancePeer::addSelectColumns($criteria);
				$this->collTagInstances = TagInstancePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(TagInstancePeer::CREATED_BY, $this->getId());

				TagInstancePeer::addSelectColumns($criteria);
				if (!isset($this->lastTagInstanceCriteria) || !$this->lastTagInstanceCriteria->equals($criteria)) {
					$this->collTagInstances = TagInstancePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTagInstanceCriteria = $criteria;
		return $this->collTagInstances;
	}

	/**
	 * Returns the number of related TagInstances.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countTagInstances($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseTagInstancePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TagInstancePeer::CREATED_BY, $this->getId());

		return TagInstancePeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a TagInstance object to this object
	 * through the TagInstance foreign key attribute
	 *
	 * @param      TagInstance $l TagInstance
	 * @return     void
	 * @throws     PropelException
	 */
	public function addTagInstance(TagInstance $l)
	{
		$this->collTagInstances[] = $l;
		$l->setUser($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related TagInstances from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getTagInstancesJoinTag($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseTagInstancePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTagInstances === null) {
			if ($this->isNew()) {
				$this->collTagInstances = array();
			} else {

				$criteria->add(TagInstancePeer::CREATED_BY, $this->getId());

				$this->collTagInstances = TagInstancePeer::doSelectJoinTag($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(TagInstancePeer::CREATED_BY, $this->getId());

			if (!isset($this->lastTagInstanceCriteria) || !$this->lastTagInstanceCriteria->equals($criteria)) {
				$this->collTagInstances = TagInstancePeer::doSelectJoinTag($criteria, $con);
			}
		}
		$this->lastTagInstanceCriteria = $criteria;

		return $this->collTagInstances;
	}

	/**
	 * Temporary storage of collLinksRelatedByOwnerId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLinksRelatedByOwnerId()
	{
		if ($this->collLinksRelatedByOwnerId === null) {
			$this->collLinksRelatedByOwnerId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related LinksRelatedByOwnerId from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLinksRelatedByOwnerId($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByOwnerId === null) {
			if ($this->isNew()) {
			   $this->collLinksRelatedByOwnerId = array();
			} else {

				$criteria->add(LinkPeer::OWNER_ID, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				$this->collLinksRelatedByOwnerId = LinkPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LinkPeer::OWNER_ID, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				if (!isset($this->lastLinkRelatedByOwnerIdCriteria) || !$this->lastLinkRelatedByOwnerIdCriteria->equals($criteria)) {
					$this->collLinksRelatedByOwnerId = LinkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLinkRelatedByOwnerIdCriteria = $criteria;
		return $this->collLinksRelatedByOwnerId;
	}

	/**
	 * Returns the number of related LinksRelatedByOwnerId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLinksRelatedByOwnerId($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LinkPeer::OWNER_ID, $this->getId());

		return LinkPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Link object to this object
	 * through the Link foreign key attribute
	 *
	 * @param      Link $l Link
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLinkRelatedByOwnerId(Link $l)
	{
		$this->collLinksRelatedByOwnerId[] = $l;
		$l->setUserRelatedByOwnerId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LinksRelatedByOwnerId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLinksRelatedByOwnerIdJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByOwnerId === null) {
			if ($this->isNew()) {
				$this->collLinksRelatedByOwnerId = array();
			} else {

				$criteria->add(LinkPeer::OWNER_ID, $this->getId());

				$this->collLinksRelatedByOwnerId = LinkPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::OWNER_ID, $this->getId());

			if (!isset($this->lastLinkRelatedByOwnerIdCriteria) || !$this->lastLinkRelatedByOwnerIdCriteria->equals($criteria)) {
				$this->collLinksRelatedByOwnerId = LinkPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastLinkRelatedByOwnerIdCriteria = $criteria;

		return $this->collLinksRelatedByOwnerId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LinksRelatedByOwnerId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLinksRelatedByOwnerIdJoinDocumentCategory($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByOwnerId === null) {
			if ($this->isNew()) {
				$this->collLinksRelatedByOwnerId = array();
			} else {

				$criteria->add(LinkPeer::OWNER_ID, $this->getId());

				$this->collLinksRelatedByOwnerId = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::OWNER_ID, $this->getId());

			if (!isset($this->lastLinkRelatedByOwnerIdCriteria) || !$this->lastLinkRelatedByOwnerIdCriteria->equals($criteria)) {
				$this->collLinksRelatedByOwnerId = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastLinkRelatedByOwnerIdCriteria = $criteria;

		return $this->collLinksRelatedByOwnerId;
	}

	/**
	 * Temporary storage of collLinksRelatedByCreatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLinksRelatedByCreatedBy()
	{
		if ($this->collLinksRelatedByCreatedBy === null) {
			$this->collLinksRelatedByCreatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related LinksRelatedByCreatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLinksRelatedByCreatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByCreatedBy === null) {
			if ($this->isNew()) {
			   $this->collLinksRelatedByCreatedBy = array();
			} else {

				$criteria->add(LinkPeer::CREATED_BY, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				$this->collLinksRelatedByCreatedBy = LinkPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LinkPeer::CREATED_BY, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				if (!isset($this->lastLinkRelatedByCreatedByCriteria) || !$this->lastLinkRelatedByCreatedByCriteria->equals($criteria)) {
					$this->collLinksRelatedByCreatedBy = LinkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLinkRelatedByCreatedByCriteria = $criteria;
		return $this->collLinksRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related LinksRelatedByCreatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLinksRelatedByCreatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LinkPeer::CREATED_BY, $this->getId());

		return LinkPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Link object to this object
	 * through the Link foreign key attribute
	 *
	 * @param      Link $l Link
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLinkRelatedByCreatedBy(Link $l)
	{
		$this->collLinksRelatedByCreatedBy[] = $l;
		$l->setUserRelatedByCreatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LinksRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLinksRelatedByCreatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collLinksRelatedByCreatedBy = array();
			} else {

				$criteria->add(LinkPeer::CREATED_BY, $this->getId());

				$this->collLinksRelatedByCreatedBy = LinkPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastLinkRelatedByCreatedByCriteria) || !$this->lastLinkRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collLinksRelatedByCreatedBy = LinkPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastLinkRelatedByCreatedByCriteria = $criteria;

		return $this->collLinksRelatedByCreatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LinksRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLinksRelatedByCreatedByJoinDocumentCategory($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByCreatedBy === null) {
			if ($this->isNew()) {
				$this->collLinksRelatedByCreatedBy = array();
			} else {

				$criteria->add(LinkPeer::CREATED_BY, $this->getId());

				$this->collLinksRelatedByCreatedBy = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::CREATED_BY, $this->getId());

			if (!isset($this->lastLinkRelatedByCreatedByCriteria) || !$this->lastLinkRelatedByCreatedByCriteria->equals($criteria)) {
				$this->collLinksRelatedByCreatedBy = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastLinkRelatedByCreatedByCriteria = $criteria;

		return $this->collLinksRelatedByCreatedBy;
	}

	/**
	 * Temporary storage of collLinksRelatedByUpdatedBy to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLinksRelatedByUpdatedBy()
	{
		if ($this->collLinksRelatedByUpdatedBy === null) {
			$this->collLinksRelatedByUpdatedBy = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User has previously
	 * been saved, it will retrieve related LinksRelatedByUpdatedBy from storage.
	 * If this User is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLinksRelatedByUpdatedBy($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
			   $this->collLinksRelatedByUpdatedBy = array();
			} else {

				$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				$this->collLinksRelatedByUpdatedBy = LinkPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				if (!isset($this->lastLinkRelatedByUpdatedByCriteria) || !$this->lastLinkRelatedByUpdatedByCriteria->equals($criteria)) {
					$this->collLinksRelatedByUpdatedBy = LinkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLinkRelatedByUpdatedByCriteria = $criteria;
		return $this->collLinksRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related LinksRelatedByUpdatedBy.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLinksRelatedByUpdatedBy($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

		return LinkPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Link object to this object
	 * through the Link foreign key attribute
	 *
	 * @param      Link $l Link
	 * @return     void
	 * @throws     PropelException
	 */
	public function addLinkRelatedByUpdatedBy(Link $l)
	{
		$this->collLinksRelatedByUpdatedBy[] = $l;
		$l->setUserRelatedByUpdatedBy($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LinksRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLinksRelatedByUpdatedByJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collLinksRelatedByUpdatedBy = array();
			} else {

				$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

				$this->collLinksRelatedByUpdatedBy = LinkPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastLinkRelatedByUpdatedByCriteria) || !$this->lastLinkRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collLinksRelatedByUpdatedBy = LinkPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastLinkRelatedByUpdatedByCriteria = $criteria;

		return $this->collLinksRelatedByUpdatedBy;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LinksRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 */
	public function getLinksRelatedByUpdatedByJoinDocumentCategory($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseLinkPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collLinksRelatedByUpdatedBy === null) {
			if ($this->isNew()) {
				$this->collLinksRelatedByUpdatedBy = array();
			} else {

				$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

				$this->collLinksRelatedByUpdatedBy = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::UPDATED_BY, $this->getId());

			if (!isset($this->lastLinkRelatedByUpdatedByCriteria) || !$this->lastLinkRelatedByUpdatedByCriteria->equals($criteria)) {
				$this->collLinksRelatedByUpdatedBy = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastLinkRelatedByUpdatedByCriteria = $criteria;

		return $this->collLinksRelatedByUpdatedBy;
	}

} // BaseUser
