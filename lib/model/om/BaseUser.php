<?php


/**
 * Base class that represents a row from the 'users' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BaseUser extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'UserPeer';

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
	 * The value for the digest_ha1 field.
	 * @var        string
	 */
	protected $digest_ha1;

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
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_admin;

	/**
	 * The value for the is_backend_login_enabled field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $is_backend_login_enabled;

	/**
	 * The value for the is_admin_login_enabled field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $is_admin_login_enabled;

	/**
	 * The value for the is_inactive field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_inactive;

	/**
	 * The value for the password_recover_hint field.
	 * @var        string
	 */
	protected $password_recover_hint;

	/**
	 * The value for the backend_settings field.
	 * @var        resource
	 */
	protected $backend_settings;

	/**
	 * The value for the created_at field.
	 * @var        string
	 */
	protected $created_at;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

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
	 * @var        Language
	 */
	protected $aLanguageRelatedByLanguageId;

	/**
	 * @var        array UserGroup[] Collection to store aggregation of UserGroup objects.
	 */
	protected $collUserGroupsRelatedByUserId;

	/**
	 * @var        array UserRole[] Collection to store aggregation of UserRole objects.
	 */
	protected $collUserRolesRelatedByUserId;

	/**
	 * @var        array Document[] Collection to store aggregation of Document objects.
	 */
	protected $collDocumentsRelatedByOwnerId;

	/**
	 * @var        array Link[] Collection to store aggregation of Link objects.
	 */
	protected $collLinksRelatedByOwnerId;

	/**
	 * @var        array Page[] Collection to store aggregation of Page objects.
	 */
	protected $collPagesRelatedByCreatedBy;

	/**
	 * @var        array Page[] Collection to store aggregation of Page objects.
	 */
	protected $collPagesRelatedByUpdatedBy;

	/**
	 * @var        array PageProperty[] Collection to store aggregation of PageProperty objects.
	 */
	protected $collPagePropertysRelatedByCreatedBy;

	/**
	 * @var        array PageProperty[] Collection to store aggregation of PageProperty objects.
	 */
	protected $collPagePropertysRelatedByUpdatedBy;

	/**
	 * @var        array PageString[] Collection to store aggregation of PageString objects.
	 */
	protected $collPageStringsRelatedByCreatedBy;

	/**
	 * @var        array PageString[] Collection to store aggregation of PageString objects.
	 */
	protected $collPageStringsRelatedByUpdatedBy;

	/**
	 * @var        array ContentObject[] Collection to store aggregation of ContentObject objects.
	 */
	protected $collContentObjectsRelatedByCreatedBy;

	/**
	 * @var        array ContentObject[] Collection to store aggregation of ContentObject objects.
	 */
	protected $collContentObjectsRelatedByUpdatedBy;

	/**
	 * @var        array LanguageObject[] Collection to store aggregation of LanguageObject objects.
	 */
	protected $collLanguageObjectsRelatedByCreatedBy;

	/**
	 * @var        array LanguageObject[] Collection to store aggregation of LanguageObject objects.
	 */
	protected $collLanguageObjectsRelatedByUpdatedBy;

	/**
	 * @var        array LanguageObjectHistory[] Collection to store aggregation of LanguageObjectHistory objects.
	 */
	protected $collLanguageObjectHistorysRelatedByCreatedBy;

	/**
	 * @var        array LanguageObjectHistory[] Collection to store aggregation of LanguageObjectHistory objects.
	 */
	protected $collLanguageObjectHistorysRelatedByUpdatedBy;

	/**
	 * @var        array Language[] Collection to store aggregation of Language objects.
	 */
	protected $collLanguagesRelatedByCreatedBy;

	/**
	 * @var        array Language[] Collection to store aggregation of Language objects.
	 */
	protected $collLanguagesRelatedByUpdatedBy;

	/**
	 * @var        array String[] Collection to store aggregation of String objects.
	 */
	protected $collStringsRelatedByCreatedBy;

	/**
	 * @var        array String[] Collection to store aggregation of String objects.
	 */
	protected $collStringsRelatedByUpdatedBy;

	/**
	 * @var        array UserGroup[] Collection to store aggregation of UserGroup objects.
	 */
	protected $collUserGroupsRelatedByCreatedBy;

	/**
	 * @var        array UserGroup[] Collection to store aggregation of UserGroup objects.
	 */
	protected $collUserGroupsRelatedByUpdatedBy;

	/**
	 * @var        array Group[] Collection to store aggregation of Group objects.
	 */
	protected $collGroupsRelatedByCreatedBy;

	/**
	 * @var        array Group[] Collection to store aggregation of Group objects.
	 */
	protected $collGroupsRelatedByUpdatedBy;

	/**
	 * @var        array GroupRole[] Collection to store aggregation of GroupRole objects.
	 */
	protected $collGroupRolesRelatedByCreatedBy;

	/**
	 * @var        array GroupRole[] Collection to store aggregation of GroupRole objects.
	 */
	protected $collGroupRolesRelatedByUpdatedBy;

	/**
	 * @var        array Role[] Collection to store aggregation of Role objects.
	 */
	protected $collRolesRelatedByCreatedBy;

	/**
	 * @var        array Role[] Collection to store aggregation of Role objects.
	 */
	protected $collRolesRelatedByUpdatedBy;

	/**
	 * @var        array UserRole[] Collection to store aggregation of UserRole objects.
	 */
	protected $collUserRolesRelatedByCreatedBy;

	/**
	 * @var        array UserRole[] Collection to store aggregation of UserRole objects.
	 */
	protected $collUserRolesRelatedByUpdatedBy;

	/**
	 * @var        array Right[] Collection to store aggregation of Right objects.
	 */
	protected $collRightsRelatedByCreatedBy;

	/**
	 * @var        array Right[] Collection to store aggregation of Right objects.
	 */
	protected $collRightsRelatedByUpdatedBy;

	/**
	 * @var        array Document[] Collection to store aggregation of Document objects.
	 */
	protected $collDocumentsRelatedByCreatedBy;

	/**
	 * @var        array Document[] Collection to store aggregation of Document objects.
	 */
	protected $collDocumentsRelatedByUpdatedBy;

	/**
	 * @var        array DocumentType[] Collection to store aggregation of DocumentType objects.
	 */
	protected $collDocumentTypesRelatedByCreatedBy;

	/**
	 * @var        array DocumentType[] Collection to store aggregation of DocumentType objects.
	 */
	protected $collDocumentTypesRelatedByUpdatedBy;

	/**
	 * @var        array DocumentCategory[] Collection to store aggregation of DocumentCategory objects.
	 */
	protected $collDocumentCategorysRelatedByCreatedBy;

	/**
	 * @var        array DocumentCategory[] Collection to store aggregation of DocumentCategory objects.
	 */
	protected $collDocumentCategorysRelatedByUpdatedBy;

	/**
	 * @var        array Tag[] Collection to store aggregation of Tag objects.
	 */
	protected $collTagsRelatedByCreatedBy;

	/**
	 * @var        array Tag[] Collection to store aggregation of Tag objects.
	 */
	protected $collTagsRelatedByUpdatedBy;

	/**
	 * @var        array TagInstance[] Collection to store aggregation of TagInstance objects.
	 */
	protected $collTagInstancesRelatedByCreatedBy;

	/**
	 * @var        array TagInstance[] Collection to store aggregation of TagInstance objects.
	 */
	protected $collTagInstancesRelatedByUpdatedBy;

	/**
	 * @var        array Link[] Collection to store aggregation of Link objects.
	 */
	protected $collLinksRelatedByCreatedBy;

	/**
	 * @var        array Link[] Collection to store aggregation of Link objects.
	 */
	protected $collLinksRelatedByUpdatedBy;

	/**
	 * @var        array LinkCategory[] Collection to store aggregation of LinkCategory objects.
	 */
	protected $collLinkCategorysRelatedByCreatedBy;

	/**
	 * @var        array LinkCategory[] Collection to store aggregation of LinkCategory objects.
	 */
	protected $collLinkCategorysRelatedByUpdatedBy;

	/**
	 * @var        array Reference[] Collection to store aggregation of Reference objects.
	 */
	protected $collReferencesRelatedByCreatedBy;

	/**
	 * @var        array Reference[] Collection to store aggregation of Reference objects.
	 */
	protected $collReferencesRelatedByUpdatedBy;

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
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_admin = false;
		$this->is_backend_login_enabled = true;
		$this->is_admin_login_enabled = true;
		$this->is_inactive = false;
	}

	/**
	 * Initializes internal state of BaseUser object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

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
	 * Get the [digest_ha1] column value.
	 * 
	 * @return     string
	 */
	public function getDigestHA1()
	{
		return $this->digest_ha1;
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
	 * Get the [is_admin_login_enabled] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsAdminLoginEnabled()
	{
		return $this->is_admin_login_enabled;
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
	 * @return     resource
	 */
	public function getBackendSettings()
	{
		return $this->backend_settings;
	}

	/**
	 * Get the [optionally formatted] temporal [created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->created_at === null) {
			return null;
		}


		if ($this->created_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
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
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = UserPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [username] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setUsername($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = UserPeer::USERNAME;
		}

		return $this;
	} // setUsername()

	/**
	 * Set the value of [password] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setPassword($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->password !== $v) {
			$this->password = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD;
		}

		return $this;
	} // setPassword()

	/**
	 * Set the value of [digest_ha1] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setDigestHA1($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->digest_ha1 !== $v) {
			$this->digest_ha1 = $v;
			$this->modifiedColumns[] = UserPeer::DIGEST_HA1;
		}

		return $this;
	} // setDigestHA1()

	/**
	 * Set the value of [first_name] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setFirstName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->first_name !== $v) {
			$this->first_name = $v;
			$this->modifiedColumns[] = UserPeer::FIRST_NAME;
		}

		return $this;
	} // setFirstName()

	/**
	 * Set the value of [last_name] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setLastName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->last_name !== $v) {
			$this->last_name = $v;
			$this->modifiedColumns[] = UserPeer::LAST_NAME;
		}

		return $this;
	} // setLastName()

	/**
	 * Set the value of [email] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setEmail($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL;
		}

		return $this;
	} // setEmail()

	/**
	 * Set the value of [language_id] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setLanguageId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->language_id !== $v) {
			$this->language_id = $v;
			$this->modifiedColumns[] = UserPeer::LANGUAGE_ID;
		}

		if ($this->aLanguageRelatedByLanguageId !== null && $this->aLanguageRelatedByLanguageId->getId() !== $v) {
			$this->aLanguageRelatedByLanguageId = null;
		}

		return $this;
	} // setLanguageId()

	/**
	 * Sets the value of the [is_admin] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setIsAdmin($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_admin !== $v) {
			$this->is_admin = $v;
			$this->modifiedColumns[] = UserPeer::IS_ADMIN;
		}

		return $this;
	} // setIsAdmin()

	/**
	 * Sets the value of the [is_backend_login_enabled] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setIsBackendLoginEnabled($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_backend_login_enabled !== $v) {
			$this->is_backend_login_enabled = $v;
			$this->modifiedColumns[] = UserPeer::IS_BACKEND_LOGIN_ENABLED;
		}

		return $this;
	} // setIsBackendLoginEnabled()

	/**
	 * Sets the value of the [is_admin_login_enabled] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setIsAdminLoginEnabled($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_admin_login_enabled !== $v) {
			$this->is_admin_login_enabled = $v;
			$this->modifiedColumns[] = UserPeer::IS_ADMIN_LOGIN_ENABLED;
		}

		return $this;
	} // setIsAdminLoginEnabled()

	/**
	 * Sets the value of the [is_inactive] column.
	 * Non-boolean arguments are converted using the following rules:
	 *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * 
	 * @param      boolean|integer|string $v The new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setIsInactive($v)
	{
		if ($v !== null) {
			if (is_string($v)) {
				$v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
			} else {
				$v = (boolean) $v;
			}
		}

		if ($this->is_inactive !== $v) {
			$this->is_inactive = $v;
			$this->modifiedColumns[] = UserPeer::IS_INACTIVE;
		}

		return $this;
	} // setIsInactive()

	/**
	 * Set the value of [password_recover_hint] column.
	 * 
	 * @param      string $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setPasswordRecoverHint($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->password_recover_hint !== $v) {
			$this->password_recover_hint = $v;
			$this->modifiedColumns[] = UserPeer::PASSWORD_RECOVER_HINT;
		}

		return $this;
	} // setPasswordRecoverHint()

	/**
	 * Set the value of [backend_settings] column.
	 * 
	 * @param      resource $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setBackendSettings($v)
	{
		// Because BLOB columns are streams in PDO we have to assume that they are
		// always modified when a new value is passed in.  For example, the contents
		// of the stream itself may have changed externally.
		if (!is_resource($v) && $v !== null) {
			$this->backend_settings = fopen('php://memory', 'r+');
			fwrite($this->backend_settings, $v);
			rewind($this->backend_settings);
		} else { // it's already a stream
			$this->backend_settings = $v;
		}
		$this->modifiedColumns[] = UserPeer::BACKEND_SETTINGS;

		return $this;
	} // setBackendSettings()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     User The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->created_at !== null || $dt !== null) {
			$currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->created_at = $newDateAsString;
				$this->modifiedColumns[] = UserPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.
	 *               Empty strings are treated as NULL.
	 * @return     User The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		$dt = PropelDateTime::newInstance($v, null, 'DateTime');
		if ($this->updated_at !== null || $dt !== null) {
			$currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
			if ($currentDateAsString !== $newDateAsString) {
				$this->updated_at = $newDateAsString;
				$this->modifiedColumns[] = UserPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [created_by] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setCreatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = UserPeer::CREATED_BY;
		}

		return $this;
	} // setCreatedBy()

	/**
	 * Set the value of [updated_by] column.
	 * 
	 * @param      int $v new value
	 * @return     User The current object (for fluent API support)
	 */
	public function setUpdatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = UserPeer::UPDATED_BY;
		}

		return $this;
	} // setUpdatedBy()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->is_admin !== false) {
				return false;
			}

			if ($this->is_backend_login_enabled !== true) {
				return false;
			}

			if ($this->is_admin_login_enabled !== true) {
				return false;
			}

			if ($this->is_inactive !== false) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->username = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->password = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->digest_ha1 = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->first_name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->last_name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->email = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->language_id = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->is_admin = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
			$this->is_backend_login_enabled = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
			$this->is_admin_login_enabled = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
			$this->is_inactive = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
			$this->password_recover_hint = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			if ($row[$startcol + 13] !== null) {
				$this->backend_settings = fopen('php://memory', 'r+');
				fwrite($this->backend_settings, $row[$startcol + 13]);
				rewind($this->backend_settings);
			} else {
				$this->backend_settings = null;
			}
			$this->created_at = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
			$this->updated_at = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->created_by = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
			$this->updated_by = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 18; // 18 = UserPeer::NUM_HYDRATE_COLUMNS.

		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aLanguageRelatedByLanguageId !== null && $this->language_id !== $this->aLanguageRelatedByLanguageId->getId()) {
			$this->aLanguageRelatedByLanguageId = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = UserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aLanguageRelatedByLanguageId = null;
			$this->collUserGroupsRelatedByUserId = null;

			$this->collUserRolesRelatedByUserId = null;

			$this->collDocumentsRelatedByOwnerId = null;

			$this->collLinksRelatedByOwnerId = null;

			$this->collPagesRelatedByCreatedBy = null;

			$this->collPagesRelatedByUpdatedBy = null;

			$this->collPagePropertysRelatedByCreatedBy = null;

			$this->collPagePropertysRelatedByUpdatedBy = null;

			$this->collPageStringsRelatedByCreatedBy = null;

			$this->collPageStringsRelatedByUpdatedBy = null;

			$this->collContentObjectsRelatedByCreatedBy = null;

			$this->collContentObjectsRelatedByUpdatedBy = null;

			$this->collLanguageObjectsRelatedByCreatedBy = null;

			$this->collLanguageObjectsRelatedByUpdatedBy = null;

			$this->collLanguageObjectHistorysRelatedByCreatedBy = null;

			$this->collLanguageObjectHistorysRelatedByUpdatedBy = null;

			$this->collLanguagesRelatedByCreatedBy = null;

			$this->collLanguagesRelatedByUpdatedBy = null;

			$this->collStringsRelatedByCreatedBy = null;

			$this->collStringsRelatedByUpdatedBy = null;

			$this->collUserGroupsRelatedByCreatedBy = null;

			$this->collUserGroupsRelatedByUpdatedBy = null;

			$this->collGroupsRelatedByCreatedBy = null;

			$this->collGroupsRelatedByUpdatedBy = null;

			$this->collGroupRolesRelatedByCreatedBy = null;

			$this->collGroupRolesRelatedByUpdatedBy = null;

			$this->collRolesRelatedByCreatedBy = null;

			$this->collRolesRelatedByUpdatedBy = null;

			$this->collUserRolesRelatedByCreatedBy = null;

			$this->collUserRolesRelatedByUpdatedBy = null;

			$this->collRightsRelatedByCreatedBy = null;

			$this->collRightsRelatedByUpdatedBy = null;

			$this->collDocumentsRelatedByCreatedBy = null;

			$this->collDocumentsRelatedByUpdatedBy = null;

			$this->collDocumentTypesRelatedByCreatedBy = null;

			$this->collDocumentTypesRelatedByUpdatedBy = null;

			$this->collDocumentCategorysRelatedByCreatedBy = null;

			$this->collDocumentCategorysRelatedByUpdatedBy = null;

			$this->collTagsRelatedByCreatedBy = null;

			$this->collTagsRelatedByUpdatedBy = null;

			$this->collTagInstancesRelatedByCreatedBy = null;

			$this->collTagInstancesRelatedByUpdatedBy = null;

			$this->collLinksRelatedByCreatedBy = null;

			$this->collLinksRelatedByUpdatedBy = null;

			$this->collLinkCategorysRelatedByCreatedBy = null;

			$this->collLinkCategorysRelatedByUpdatedBy = null;

			$this->collReferencesRelatedByCreatedBy = null;

			$this->collReferencesRelatedByUpdatedBy = null;

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$deleteQuery = UserQuery::create()
				->filterByPrimaryKey($this->getPrimaryKey());
			$ret = $this->preDelete($con);
			// denyable behavior
			$oUser = Session::getSession()->getUser();
			if(!(UserPeer::isIgnoringRights() || ($oUser !== null && $this->getCreatedBy() === $oUser->getId() && UserPeer::mayOperateOnOwn($oUser, $this, "delete")) || UserPeer::mayOperateOn($oUser, $this, "delete"))) {
				throw new NotPermittedException("delete.by_role", array("role_key" => "users"));
			}

			if ($ret) {
				$deleteQuery->delete($con);
				$this->postDelete($con);
				$con->commit();
				$this->setDeleted(true);
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// denyable behavior
				$oUser = Session::getSession()->getUser();
				if(!(UserPeer::isIgnoringRights() || ($oUser !== null && UserPeer::mayOperateOnOwn($oUser, $this, "insert")) || UserPeer::mayOperateOn($oUser, $this, "insert"))) {
					throw new NotPermittedException("insert.by_role", array("role_key" => "users"));
				}

				// extended_timestampable behavior
				if (!$this->isColumnModified(UserPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(UserPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if (!$this->isColumnModified(UserPeer::CREATED_BY)) {
						$this->setCreatedBy(Session::getSession()->getUser()->getId());
					}
					if (!$this->isColumnModified(UserPeer::UPDATED_BY)) {
						$this->setUpdatedBy(Session::getSession()->getUser()->getId());
					}
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
				// denyable behavior
				$oUser = Session::getSession()->getUser();
				if(!(UserPeer::isIgnoringRights() || ($oUser !== null && $this->getCreatedBy() === $oUser->getId() && UserPeer::mayOperateOnOwn($oUser, $this, "update")) || UserPeer::mayOperateOn($oUser, $this, "update"))) {
					throw new NotPermittedException("update.by_role", array("role_key" => "users"));
				}

				// extended_timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(UserPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if ($this->isModified() && !$this->isColumnModified(UserPeer::UPDATED_BY)) {
						$this->setUpdatedBy(Session::getSession()->getUser()->getId());
					}
				}
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				UserPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLanguageRelatedByLanguageId !== null) {
				if ($this->aLanguageRelatedByLanguageId->isModified() || $this->aLanguageRelatedByLanguageId->isNew()) {
					$affectedRows += $this->aLanguageRelatedByLanguageId->save($con);
				}
				$this->setLanguageRelatedByLanguageId($this->aLanguageRelatedByLanguageId);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = UserPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					if ($criteria->keyContainsValue(UserPeer::ID) ) {
						throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserPeer::ID.')');
					}

					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setId($pk);  //[IMV] update autoincrement primary key
					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
				}

				// Rewind the backend_settings LOB column, since PDO does not rewind after inserting value.
				if ($this->backend_settings !== null && is_resource($this->backend_settings)) {
					rewind($this->backend_settings);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collUserGroupsRelatedByUserId !== null) {
				foreach ($this->collUserGroupsRelatedByUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserRolesRelatedByUserId !== null) {
				foreach ($this->collUserRolesRelatedByUserId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentsRelatedByOwnerId !== null) {
				foreach ($this->collDocumentsRelatedByOwnerId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinksRelatedByOwnerId !== null) {
				foreach ($this->collLinksRelatedByOwnerId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPagesRelatedByCreatedBy !== null) {
				foreach ($this->collPagesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPagesRelatedByUpdatedBy !== null) {
				foreach ($this->collPagesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPagePropertysRelatedByCreatedBy !== null) {
				foreach ($this->collPagePropertysRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPagePropertysRelatedByUpdatedBy !== null) {
				foreach ($this->collPagePropertysRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPageStringsRelatedByCreatedBy !== null) {
				foreach ($this->collPageStringsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPageStringsRelatedByUpdatedBy !== null) {
				foreach ($this->collPageStringsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collContentObjectsRelatedByCreatedBy !== null) {
				foreach ($this->collContentObjectsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collContentObjectsRelatedByUpdatedBy !== null) {
				foreach ($this->collContentObjectsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectsRelatedByCreatedBy !== null) {
				foreach ($this->collLanguageObjectsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectsRelatedByUpdatedBy !== null) {
				foreach ($this->collLanguageObjectsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectHistorysRelatedByCreatedBy !== null) {
				foreach ($this->collLanguageObjectHistorysRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjectHistorysRelatedByUpdatedBy !== null) {
				foreach ($this->collLanguageObjectHistorysRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguagesRelatedByCreatedBy !== null) {
				foreach ($this->collLanguagesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguagesRelatedByUpdatedBy !== null) {
				foreach ($this->collLanguagesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collStringsRelatedByCreatedBy !== null) {
				foreach ($this->collStringsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collStringsRelatedByUpdatedBy !== null) {
				foreach ($this->collStringsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserGroupsRelatedByCreatedBy !== null) {
				foreach ($this->collUserGroupsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserGroupsRelatedByUpdatedBy !== null) {
				foreach ($this->collUserGroupsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupsRelatedByCreatedBy !== null) {
				foreach ($this->collGroupsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupsRelatedByUpdatedBy !== null) {
				foreach ($this->collGroupsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupRolesRelatedByCreatedBy !== null) {
				foreach ($this->collGroupRolesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collGroupRolesRelatedByUpdatedBy !== null) {
				foreach ($this->collGroupRolesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRolesRelatedByCreatedBy !== null) {
				foreach ($this->collRolesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRolesRelatedByUpdatedBy !== null) {
				foreach ($this->collRolesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserRolesRelatedByCreatedBy !== null) {
				foreach ($this->collUserRolesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUserRolesRelatedByUpdatedBy !== null) {
				foreach ($this->collUserRolesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRightsRelatedByCreatedBy !== null) {
				foreach ($this->collRightsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRightsRelatedByUpdatedBy !== null) {
				foreach ($this->collRightsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentsRelatedByCreatedBy !== null) {
				foreach ($this->collDocumentsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentsRelatedByUpdatedBy !== null) {
				foreach ($this->collDocumentsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentTypesRelatedByCreatedBy !== null) {
				foreach ($this->collDocumentTypesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentTypesRelatedByUpdatedBy !== null) {
				foreach ($this->collDocumentTypesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentCategorysRelatedByCreatedBy !== null) {
				foreach ($this->collDocumentCategorysRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocumentCategorysRelatedByUpdatedBy !== null) {
				foreach ($this->collDocumentCategorysRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTagsRelatedByCreatedBy !== null) {
				foreach ($this->collTagsRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTagsRelatedByUpdatedBy !== null) {
				foreach ($this->collTagsRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTagInstancesRelatedByCreatedBy !== null) {
				foreach ($this->collTagInstancesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collTagInstancesRelatedByUpdatedBy !== null) {
				foreach ($this->collTagInstancesRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinksRelatedByCreatedBy !== null) {
				foreach ($this->collLinksRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinksRelatedByUpdatedBy !== null) {
				foreach ($this->collLinksRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinkCategorysRelatedByCreatedBy !== null) {
				foreach ($this->collLinkCategorysRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinkCategorysRelatedByUpdatedBy !== null) {
				foreach ($this->collLinkCategorysRelatedByUpdatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReferencesRelatedByCreatedBy !== null) {
				foreach ($this->collReferencesRelatedByCreatedBy as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collReferencesRelatedByUpdatedBy !== null) {
				foreach ($this->collReferencesRelatedByUpdatedBy as $referrerFK) {
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

			if ($this->aLanguageRelatedByLanguageId !== null) {
				if (!$this->aLanguageRelatedByLanguageId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aLanguageRelatedByLanguageId->getValidationFailures());
				}
			}


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collUserGroupsRelatedByUserId !== null) {
					foreach ($this->collUserGroupsRelatedByUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserRolesRelatedByUserId !== null) {
					foreach ($this->collUserRolesRelatedByUserId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentsRelatedByOwnerId !== null) {
					foreach ($this->collDocumentsRelatedByOwnerId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinksRelatedByOwnerId !== null) {
					foreach ($this->collLinksRelatedByOwnerId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPagesRelatedByCreatedBy !== null) {
					foreach ($this->collPagesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPagesRelatedByUpdatedBy !== null) {
					foreach ($this->collPagesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPagePropertysRelatedByCreatedBy !== null) {
					foreach ($this->collPagePropertysRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPagePropertysRelatedByUpdatedBy !== null) {
					foreach ($this->collPagePropertysRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPageStringsRelatedByCreatedBy !== null) {
					foreach ($this->collPageStringsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPageStringsRelatedByUpdatedBy !== null) {
					foreach ($this->collPageStringsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collContentObjectsRelatedByCreatedBy !== null) {
					foreach ($this->collContentObjectsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collContentObjectsRelatedByUpdatedBy !== null) {
					foreach ($this->collContentObjectsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectsRelatedByCreatedBy !== null) {
					foreach ($this->collLanguageObjectsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectsRelatedByUpdatedBy !== null) {
					foreach ($this->collLanguageObjectsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectHistorysRelatedByCreatedBy !== null) {
					foreach ($this->collLanguageObjectHistorysRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjectHistorysRelatedByUpdatedBy !== null) {
					foreach ($this->collLanguageObjectHistorysRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguagesRelatedByCreatedBy !== null) {
					foreach ($this->collLanguagesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguagesRelatedByUpdatedBy !== null) {
					foreach ($this->collLanguagesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collStringsRelatedByCreatedBy !== null) {
					foreach ($this->collStringsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collStringsRelatedByUpdatedBy !== null) {
					foreach ($this->collStringsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserGroupsRelatedByCreatedBy !== null) {
					foreach ($this->collUserGroupsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserGroupsRelatedByUpdatedBy !== null) {
					foreach ($this->collUserGroupsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupsRelatedByCreatedBy !== null) {
					foreach ($this->collGroupsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupsRelatedByUpdatedBy !== null) {
					foreach ($this->collGroupsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupRolesRelatedByCreatedBy !== null) {
					foreach ($this->collGroupRolesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collGroupRolesRelatedByUpdatedBy !== null) {
					foreach ($this->collGroupRolesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRolesRelatedByCreatedBy !== null) {
					foreach ($this->collRolesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRolesRelatedByUpdatedBy !== null) {
					foreach ($this->collRolesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserRolesRelatedByCreatedBy !== null) {
					foreach ($this->collUserRolesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUserRolesRelatedByUpdatedBy !== null) {
					foreach ($this->collUserRolesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRightsRelatedByCreatedBy !== null) {
					foreach ($this->collRightsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRightsRelatedByUpdatedBy !== null) {
					foreach ($this->collRightsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentsRelatedByCreatedBy !== null) {
					foreach ($this->collDocumentsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentsRelatedByUpdatedBy !== null) {
					foreach ($this->collDocumentsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentTypesRelatedByCreatedBy !== null) {
					foreach ($this->collDocumentTypesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentTypesRelatedByUpdatedBy !== null) {
					foreach ($this->collDocumentTypesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentCategorysRelatedByCreatedBy !== null) {
					foreach ($this->collDocumentCategorysRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocumentCategorysRelatedByUpdatedBy !== null) {
					foreach ($this->collDocumentCategorysRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTagsRelatedByCreatedBy !== null) {
					foreach ($this->collTagsRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTagsRelatedByUpdatedBy !== null) {
					foreach ($this->collTagsRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTagInstancesRelatedByCreatedBy !== null) {
					foreach ($this->collTagInstancesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collTagInstancesRelatedByUpdatedBy !== null) {
					foreach ($this->collTagInstancesRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinksRelatedByCreatedBy !== null) {
					foreach ($this->collLinksRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinksRelatedByUpdatedBy !== null) {
					foreach ($this->collLinksRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinkCategorysRelatedByCreatedBy !== null) {
					foreach ($this->collLinkCategorysRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinkCategorysRelatedByUpdatedBy !== null) {
					foreach ($this->collLinkCategorysRelatedByUpdatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReferencesRelatedByCreatedBy !== null) {
					foreach ($this->collReferencesRelatedByCreatedBy as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collReferencesRelatedByUpdatedBy !== null) {
					foreach ($this->collReferencesRelatedByUpdatedBy as $referrerFK) {
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
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
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
				return $this->getDigestHA1();
				break;
			case 4:
				return $this->getFirstName();
				break;
			case 5:
				return $this->getLastName();
				break;
			case 6:
				return $this->getEmail();
				break;
			case 7:
				return $this->getLanguageId();
				break;
			case 8:
				return $this->getIsAdmin();
				break;
			case 9:
				return $this->getIsBackendLoginEnabled();
				break;
			case 10:
				return $this->getIsAdminLoginEnabled();
				break;
			case 11:
				return $this->getIsInactive();
				break;
			case 12:
				return $this->getPasswordRecoverHint();
				break;
			case 13:
				return $this->getBackendSettings();
				break;
			case 14:
				return $this->getCreatedAt();
				break;
			case 15:
				return $this->getUpdatedAt();
				break;
			case 16:
				return $this->getCreatedBy();
				break;
			case 17:
				return $this->getUpdatedBy();
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
	 * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 *                    Defaults to BasePeer::TYPE_PHPNAME.
	 * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
	 * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
	{
		if (isset($alreadyDumpedObjects['User'][$this->getPrimaryKey()])) {
			return '*RECURSION*';
		}
		$alreadyDumpedObjects['User'][$this->getPrimaryKey()] = true;
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUsername(),
			$keys[2] => $this->getPassword(),
			$keys[3] => $this->getDigestHA1(),
			$keys[4] => $this->getFirstName(),
			$keys[5] => $this->getLastName(),
			$keys[6] => $this->getEmail(),
			$keys[7] => $this->getLanguageId(),
			$keys[8] => $this->getIsAdmin(),
			$keys[9] => $this->getIsBackendLoginEnabled(),
			$keys[10] => $this->getIsAdminLoginEnabled(),
			$keys[11] => $this->getIsInactive(),
			$keys[12] => $this->getPasswordRecoverHint(),
			$keys[13] => $this->getBackendSettings(),
			$keys[14] => $this->getCreatedAt(),
			$keys[15] => $this->getUpdatedAt(),
			$keys[16] => $this->getCreatedBy(),
			$keys[17] => $this->getUpdatedBy(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aLanguageRelatedByLanguageId) {
				$result['LanguageRelatedByLanguageId'] = $this->aLanguageRelatedByLanguageId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
			}
			if (null !== $this->collUserGroupsRelatedByUserId) {
				$result['UserGroupsRelatedByUserId'] = $this->collUserGroupsRelatedByUserId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collUserRolesRelatedByUserId) {
				$result['UserRolesRelatedByUserId'] = $this->collUserRolesRelatedByUserId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentsRelatedByOwnerId) {
				$result['DocumentsRelatedByOwnerId'] = $this->collDocumentsRelatedByOwnerId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLinksRelatedByOwnerId) {
				$result['LinksRelatedByOwnerId'] = $this->collLinksRelatedByOwnerId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPagesRelatedByCreatedBy) {
				$result['PagesRelatedByCreatedBy'] = $this->collPagesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPagesRelatedByUpdatedBy) {
				$result['PagesRelatedByUpdatedBy'] = $this->collPagesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPagePropertysRelatedByCreatedBy) {
				$result['PagePropertysRelatedByCreatedBy'] = $this->collPagePropertysRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPagePropertysRelatedByUpdatedBy) {
				$result['PagePropertysRelatedByUpdatedBy'] = $this->collPagePropertysRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPageStringsRelatedByCreatedBy) {
				$result['PageStringsRelatedByCreatedBy'] = $this->collPageStringsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collPageStringsRelatedByUpdatedBy) {
				$result['PageStringsRelatedByUpdatedBy'] = $this->collPageStringsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collContentObjectsRelatedByCreatedBy) {
				$result['ContentObjectsRelatedByCreatedBy'] = $this->collContentObjectsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collContentObjectsRelatedByUpdatedBy) {
				$result['ContentObjectsRelatedByUpdatedBy'] = $this->collContentObjectsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLanguageObjectsRelatedByCreatedBy) {
				$result['LanguageObjectsRelatedByCreatedBy'] = $this->collLanguageObjectsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLanguageObjectsRelatedByUpdatedBy) {
				$result['LanguageObjectsRelatedByUpdatedBy'] = $this->collLanguageObjectsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLanguageObjectHistorysRelatedByCreatedBy) {
				$result['LanguageObjectHistorysRelatedByCreatedBy'] = $this->collLanguageObjectHistorysRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLanguageObjectHistorysRelatedByUpdatedBy) {
				$result['LanguageObjectHistorysRelatedByUpdatedBy'] = $this->collLanguageObjectHistorysRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLanguagesRelatedByCreatedBy) {
				$result['LanguagesRelatedByCreatedBy'] = $this->collLanguagesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLanguagesRelatedByUpdatedBy) {
				$result['LanguagesRelatedByUpdatedBy'] = $this->collLanguagesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collStringsRelatedByCreatedBy) {
				$result['StringsRelatedByCreatedBy'] = $this->collStringsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collStringsRelatedByUpdatedBy) {
				$result['StringsRelatedByUpdatedBy'] = $this->collStringsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collUserGroupsRelatedByCreatedBy) {
				$result['UserGroupsRelatedByCreatedBy'] = $this->collUserGroupsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collUserGroupsRelatedByUpdatedBy) {
				$result['UserGroupsRelatedByUpdatedBy'] = $this->collUserGroupsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collGroupsRelatedByCreatedBy) {
				$result['GroupsRelatedByCreatedBy'] = $this->collGroupsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collGroupsRelatedByUpdatedBy) {
				$result['GroupsRelatedByUpdatedBy'] = $this->collGroupsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collGroupRolesRelatedByCreatedBy) {
				$result['GroupRolesRelatedByCreatedBy'] = $this->collGroupRolesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collGroupRolesRelatedByUpdatedBy) {
				$result['GroupRolesRelatedByUpdatedBy'] = $this->collGroupRolesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collRolesRelatedByCreatedBy) {
				$result['RolesRelatedByCreatedBy'] = $this->collRolesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collRolesRelatedByUpdatedBy) {
				$result['RolesRelatedByUpdatedBy'] = $this->collRolesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collUserRolesRelatedByCreatedBy) {
				$result['UserRolesRelatedByCreatedBy'] = $this->collUserRolesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collUserRolesRelatedByUpdatedBy) {
				$result['UserRolesRelatedByUpdatedBy'] = $this->collUserRolesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collRightsRelatedByCreatedBy) {
				$result['RightsRelatedByCreatedBy'] = $this->collRightsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collRightsRelatedByUpdatedBy) {
				$result['RightsRelatedByUpdatedBy'] = $this->collRightsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentsRelatedByCreatedBy) {
				$result['DocumentsRelatedByCreatedBy'] = $this->collDocumentsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentsRelatedByUpdatedBy) {
				$result['DocumentsRelatedByUpdatedBy'] = $this->collDocumentsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentTypesRelatedByCreatedBy) {
				$result['DocumentTypesRelatedByCreatedBy'] = $this->collDocumentTypesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentTypesRelatedByUpdatedBy) {
				$result['DocumentTypesRelatedByUpdatedBy'] = $this->collDocumentTypesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentCategorysRelatedByCreatedBy) {
				$result['DocumentCategorysRelatedByCreatedBy'] = $this->collDocumentCategorysRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collDocumentCategorysRelatedByUpdatedBy) {
				$result['DocumentCategorysRelatedByUpdatedBy'] = $this->collDocumentCategorysRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collTagsRelatedByCreatedBy) {
				$result['TagsRelatedByCreatedBy'] = $this->collTagsRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collTagsRelatedByUpdatedBy) {
				$result['TagsRelatedByUpdatedBy'] = $this->collTagsRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collTagInstancesRelatedByCreatedBy) {
				$result['TagInstancesRelatedByCreatedBy'] = $this->collTagInstancesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collTagInstancesRelatedByUpdatedBy) {
				$result['TagInstancesRelatedByUpdatedBy'] = $this->collTagInstancesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLinksRelatedByCreatedBy) {
				$result['LinksRelatedByCreatedBy'] = $this->collLinksRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLinksRelatedByUpdatedBy) {
				$result['LinksRelatedByUpdatedBy'] = $this->collLinksRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLinkCategorysRelatedByCreatedBy) {
				$result['LinkCategorysRelatedByCreatedBy'] = $this->collLinkCategorysRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collLinkCategorysRelatedByUpdatedBy) {
				$result['LinkCategorysRelatedByUpdatedBy'] = $this->collLinkCategorysRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collReferencesRelatedByCreatedBy) {
				$result['ReferencesRelatedByCreatedBy'] = $this->collReferencesRelatedByCreatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
			if (null !== $this->collReferencesRelatedByUpdatedBy) {
				$result['ReferencesRelatedByUpdatedBy'] = $this->collReferencesRelatedByUpdatedBy->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
			}
		}
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
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
				$this->setDigestHA1($value);
				break;
			case 4:
				$this->setFirstName($value);
				break;
			case 5:
				$this->setLastName($value);
				break;
			case 6:
				$this->setEmail($value);
				break;
			case 7:
				$this->setLanguageId($value);
				break;
			case 8:
				$this->setIsAdmin($value);
				break;
			case 9:
				$this->setIsBackendLoginEnabled($value);
				break;
			case 10:
				$this->setIsAdminLoginEnabled($value);
				break;
			case 11:
				$this->setIsInactive($value);
				break;
			case 12:
				$this->setPasswordRecoverHint($value);
				break;
			case 13:
				$this->setBackendSettings($value);
				break;
			case 14:
				$this->setCreatedAt($value);
				break;
			case 15:
				$this->setUpdatedAt($value);
				break;
			case 16:
				$this->setCreatedBy($value);
				break;
			case 17:
				$this->setUpdatedBy($value);
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
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
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
		if (array_key_exists($keys[3], $arr)) $this->setDigestHA1($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFirstName($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLastName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setEmail($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLanguageId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsAdmin($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsBackendLoginEnabled($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setIsAdminLoginEnabled($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setIsInactive($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPasswordRecoverHint($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setBackendSettings($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCreatedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUpdatedAt($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setCreatedBy($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setUpdatedBy($arr[$keys[17]]);
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
		if ($this->isColumnModified(UserPeer::DIGEST_HA1)) $criteria->add(UserPeer::DIGEST_HA1, $this->digest_ha1);
		if ($this->isColumnModified(UserPeer::FIRST_NAME)) $criteria->add(UserPeer::FIRST_NAME, $this->first_name);
		if ($this->isColumnModified(UserPeer::LAST_NAME)) $criteria->add(UserPeer::LAST_NAME, $this->last_name);
		if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(UserPeer::LANGUAGE_ID)) $criteria->add(UserPeer::LANGUAGE_ID, $this->language_id);
		if ($this->isColumnModified(UserPeer::IS_ADMIN)) $criteria->add(UserPeer::IS_ADMIN, $this->is_admin);
		if ($this->isColumnModified(UserPeer::IS_BACKEND_LOGIN_ENABLED)) $criteria->add(UserPeer::IS_BACKEND_LOGIN_ENABLED, $this->is_backend_login_enabled);
		if ($this->isColumnModified(UserPeer::IS_ADMIN_LOGIN_ENABLED)) $criteria->add(UserPeer::IS_ADMIN_LOGIN_ENABLED, $this->is_admin_login_enabled);
		if ($this->isColumnModified(UserPeer::IS_INACTIVE)) $criteria->add(UserPeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(UserPeer::PASSWORD_RECOVER_HINT)) $criteria->add(UserPeer::PASSWORD_RECOVER_HINT, $this->password_recover_hint);
		if ($this->isColumnModified(UserPeer::BACKEND_SETTINGS)) $criteria->add(UserPeer::BACKEND_SETTINGS, $this->backend_settings);
		if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserPeer::UPDATED_AT)) $criteria->add(UserPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(UserPeer::CREATED_BY)) $criteria->add(UserPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(UserPeer::UPDATED_BY)) $criteria->add(UserPeer::UPDATED_BY, $this->updated_by);

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
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return null === $this->getId();
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of User (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
	{
		$copyObj->setUsername($this->getUsername());
		$copyObj->setPassword($this->getPassword());
		$copyObj->setDigestHA1($this->getDigestHA1());
		$copyObj->setFirstName($this->getFirstName());
		$copyObj->setLastName($this->getLastName());
		$copyObj->setEmail($this->getEmail());
		$copyObj->setLanguageId($this->getLanguageId());
		$copyObj->setIsAdmin($this->getIsAdmin());
		$copyObj->setIsBackendLoginEnabled($this->getIsBackendLoginEnabled());
		$copyObj->setIsAdminLoginEnabled($this->getIsAdminLoginEnabled());
		$copyObj->setIsInactive($this->getIsInactive());
		$copyObj->setPasswordRecoverHint($this->getPasswordRecoverHint());
		$copyObj->setBackendSettings($this->getBackendSettings());
		$copyObj->setCreatedAt($this->getCreatedAt());
		$copyObj->setUpdatedAt($this->getUpdatedAt());
		$copyObj->setCreatedBy($this->getCreatedBy());
		$copyObj->setUpdatedBy($this->getUpdatedBy());

		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getUserGroupsRelatedByUserId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserGroupRelatedByUserId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserRolesRelatedByUserId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserRoleRelatedByUserId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentsRelatedByOwnerId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentRelatedByOwnerId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLinksRelatedByOwnerId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLinkRelatedByOwnerId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPagesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPageRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPagesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPageRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPagePropertysRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPagePropertyRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPagePropertysRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPagePropertyRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPageStringsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPageStringRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPageStringsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPageStringRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getContentObjectsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addContentObjectRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getContentObjectsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addContentObjectRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLanguageObjectsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLanguageObjectRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLanguageObjectsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLanguageObjectRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLanguageObjectHistorysRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLanguageObjectHistoryRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLanguageObjectHistorysRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLanguageObjectHistoryRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLanguagesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLanguageRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLanguagesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLanguageRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getStringsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addStringRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getStringsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addStringRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserGroupsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserGroupRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserGroupsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserGroupRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGroupsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGroupRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGroupsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGroupRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGroupRolesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGroupRoleRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getGroupRolesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addGroupRoleRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRolesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRoleRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRolesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRoleRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserRolesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserRoleRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getUserRolesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addUserRoleRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRightsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRightRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRightsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRightRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentTypesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentTypeRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentTypesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentTypeRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentCategorysRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentCategoryRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getDocumentCategorysRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addDocumentCategoryRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getTagsRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addTagRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getTagsRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addTagRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getTagInstancesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addTagInstanceRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getTagInstancesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addTagInstanceRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLinksRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLinkRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLinksRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLinkRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLinkCategorysRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLinkCategoryRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getLinkCategorysRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addLinkCategoryRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getReferencesRelatedByCreatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addReferenceRelatedByCreatedBy($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getReferencesRelatedByUpdatedBy() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addReferenceRelatedByUpdatedBy($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)

		if ($makeNew) {
			$copyObj->setNew(true);
			$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
		}
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
	 * @return     User The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setLanguageRelatedByLanguageId(Language $v = null)
	{
		if ($v === null) {
			$this->setLanguageId(NULL);
		} else {
			$this->setLanguageId($v->getId());
		}

		$this->aLanguageRelatedByLanguageId = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Language object, it will not be re-added.
		if ($v !== null) {
			$v->addUserRelatedByLanguageId($this);
		}

		return $this;
	}


	/**
	 * Get the associated Language object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Language The associated Language object.
	 * @throws     PropelException
	 */
	public function getLanguageRelatedByLanguageId(PropelPDO $con = null)
	{
		if ($this->aLanguageRelatedByLanguageId === null && (($this->language_id !== "" && $this->language_id !== null))) {
			$this->aLanguageRelatedByLanguageId = LanguageQuery::create()->findPk($this->language_id, $con);
			/* The following can be used additionally to
				guarantee the related object contains a reference
				to this object.  This level of coupling may, however, be
				undesirable since it could result in an only partially populated collection
				in the referenced object.
				$this->aLanguageRelatedByLanguageId->addUsersRelatedByLanguageId($this);
			 */
		}
		return $this->aLanguageRelatedByLanguageId;
	}


	/**
	 * Initializes a collection based on the name of a relation.
	 * Avoids crafting an 'init[$relationName]s' method name
	 * that wouldn't work when StandardEnglishPluralizer is used.
	 *
	 * @param      string $relationName The name of the relation to initialize
	 * @return     void
	 */
	public function initRelation($relationName)
	{
		if ('UserGroupRelatedByUserId' == $relationName) {
			return $this->initUserGroupsRelatedByUserId();
		}
		if ('UserRoleRelatedByUserId' == $relationName) {
			return $this->initUserRolesRelatedByUserId();
		}
		if ('DocumentRelatedByOwnerId' == $relationName) {
			return $this->initDocumentsRelatedByOwnerId();
		}
		if ('LinkRelatedByOwnerId' == $relationName) {
			return $this->initLinksRelatedByOwnerId();
		}
		if ('PageRelatedByCreatedBy' == $relationName) {
			return $this->initPagesRelatedByCreatedBy();
		}
		if ('PageRelatedByUpdatedBy' == $relationName) {
			return $this->initPagesRelatedByUpdatedBy();
		}
		if ('PagePropertyRelatedByCreatedBy' == $relationName) {
			return $this->initPagePropertysRelatedByCreatedBy();
		}
		if ('PagePropertyRelatedByUpdatedBy' == $relationName) {
			return $this->initPagePropertysRelatedByUpdatedBy();
		}
		if ('PageStringRelatedByCreatedBy' == $relationName) {
			return $this->initPageStringsRelatedByCreatedBy();
		}
		if ('PageStringRelatedByUpdatedBy' == $relationName) {
			return $this->initPageStringsRelatedByUpdatedBy();
		}
		if ('ContentObjectRelatedByCreatedBy' == $relationName) {
			return $this->initContentObjectsRelatedByCreatedBy();
		}
		if ('ContentObjectRelatedByUpdatedBy' == $relationName) {
			return $this->initContentObjectsRelatedByUpdatedBy();
		}
		if ('LanguageObjectRelatedByCreatedBy' == $relationName) {
			return $this->initLanguageObjectsRelatedByCreatedBy();
		}
		if ('LanguageObjectRelatedByUpdatedBy' == $relationName) {
			return $this->initLanguageObjectsRelatedByUpdatedBy();
		}
		if ('LanguageObjectHistoryRelatedByCreatedBy' == $relationName) {
			return $this->initLanguageObjectHistorysRelatedByCreatedBy();
		}
		if ('LanguageObjectHistoryRelatedByUpdatedBy' == $relationName) {
			return $this->initLanguageObjectHistorysRelatedByUpdatedBy();
		}
		if ('LanguageRelatedByCreatedBy' == $relationName) {
			return $this->initLanguagesRelatedByCreatedBy();
		}
		if ('LanguageRelatedByUpdatedBy' == $relationName) {
			return $this->initLanguagesRelatedByUpdatedBy();
		}
		if ('StringRelatedByCreatedBy' == $relationName) {
			return $this->initStringsRelatedByCreatedBy();
		}
		if ('StringRelatedByUpdatedBy' == $relationName) {
			return $this->initStringsRelatedByUpdatedBy();
		}
		if ('UserGroupRelatedByCreatedBy' == $relationName) {
			return $this->initUserGroupsRelatedByCreatedBy();
		}
		if ('UserGroupRelatedByUpdatedBy' == $relationName) {
			return $this->initUserGroupsRelatedByUpdatedBy();
		}
		if ('GroupRelatedByCreatedBy' == $relationName) {
			return $this->initGroupsRelatedByCreatedBy();
		}
		if ('GroupRelatedByUpdatedBy' == $relationName) {
			return $this->initGroupsRelatedByUpdatedBy();
		}
		if ('GroupRoleRelatedByCreatedBy' == $relationName) {
			return $this->initGroupRolesRelatedByCreatedBy();
		}
		if ('GroupRoleRelatedByUpdatedBy' == $relationName) {
			return $this->initGroupRolesRelatedByUpdatedBy();
		}
		if ('RoleRelatedByCreatedBy' == $relationName) {
			return $this->initRolesRelatedByCreatedBy();
		}
		if ('RoleRelatedByUpdatedBy' == $relationName) {
			return $this->initRolesRelatedByUpdatedBy();
		}
		if ('UserRoleRelatedByCreatedBy' == $relationName) {
			return $this->initUserRolesRelatedByCreatedBy();
		}
		if ('UserRoleRelatedByUpdatedBy' == $relationName) {
			return $this->initUserRolesRelatedByUpdatedBy();
		}
		if ('RightRelatedByCreatedBy' == $relationName) {
			return $this->initRightsRelatedByCreatedBy();
		}
		if ('RightRelatedByUpdatedBy' == $relationName) {
			return $this->initRightsRelatedByUpdatedBy();
		}
		if ('DocumentRelatedByCreatedBy' == $relationName) {
			return $this->initDocumentsRelatedByCreatedBy();
		}
		if ('DocumentRelatedByUpdatedBy' == $relationName) {
			return $this->initDocumentsRelatedByUpdatedBy();
		}
		if ('DocumentTypeRelatedByCreatedBy' == $relationName) {
			return $this->initDocumentTypesRelatedByCreatedBy();
		}
		if ('DocumentTypeRelatedByUpdatedBy' == $relationName) {
			return $this->initDocumentTypesRelatedByUpdatedBy();
		}
		if ('DocumentCategoryRelatedByCreatedBy' == $relationName) {
			return $this->initDocumentCategorysRelatedByCreatedBy();
		}
		if ('DocumentCategoryRelatedByUpdatedBy' == $relationName) {
			return $this->initDocumentCategorysRelatedByUpdatedBy();
		}
		if ('TagRelatedByCreatedBy' == $relationName) {
			return $this->initTagsRelatedByCreatedBy();
		}
		if ('TagRelatedByUpdatedBy' == $relationName) {
			return $this->initTagsRelatedByUpdatedBy();
		}
		if ('TagInstanceRelatedByCreatedBy' == $relationName) {
			return $this->initTagInstancesRelatedByCreatedBy();
		}
		if ('TagInstanceRelatedByUpdatedBy' == $relationName) {
			return $this->initTagInstancesRelatedByUpdatedBy();
		}
		if ('LinkRelatedByCreatedBy' == $relationName) {
			return $this->initLinksRelatedByCreatedBy();
		}
		if ('LinkRelatedByUpdatedBy' == $relationName) {
			return $this->initLinksRelatedByUpdatedBy();
		}
		if ('LinkCategoryRelatedByCreatedBy' == $relationName) {
			return $this->initLinkCategorysRelatedByCreatedBy();
		}
		if ('LinkCategoryRelatedByUpdatedBy' == $relationName) {
			return $this->initLinkCategorysRelatedByUpdatedBy();
		}
		if ('ReferenceRelatedByCreatedBy' == $relationName) {
			return $this->initReferencesRelatedByCreatedBy();
		}
		if ('ReferenceRelatedByUpdatedBy' == $relationName) {
			return $this->initReferencesRelatedByUpdatedBy();
		}
	}

	/**
	 * Clears out the collUserGroupsRelatedByUserId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserGroupsRelatedByUserId()
	 */
	public function clearUserGroupsRelatedByUserId()
	{
		$this->collUserGroupsRelatedByUserId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserGroupsRelatedByUserId collection.
	 *
	 * By default this just sets the collUserGroupsRelatedByUserId collection to an empty array (like clearcollUserGroupsRelatedByUserId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUserGroupsRelatedByUserId($overrideExisting = true)
	{
		if (null !== $this->collUserGroupsRelatedByUserId && !$overrideExisting) {
			return;
		}
		$this->collUserGroupsRelatedByUserId = new PropelObjectCollection();
		$this->collUserGroupsRelatedByUserId->setModel('UserGroup');
	}

	/**
	 * Gets an array of UserGroup objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array UserGroup[] List of UserGroup objects
	 * @throws     PropelException
	 */
	public function getUserGroupsRelatedByUserId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUserGroupsRelatedByUserId || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserGroupsRelatedByUserId) {
				// return empty collection
				$this->initUserGroupsRelatedByUserId();
			} else {
				$collUserGroupsRelatedByUserId = UserGroupQuery::create(null, $criteria)
					->filterByUserRelatedByUserId($this)
					->find($con);
				if (null !== $criteria) {
					return $collUserGroupsRelatedByUserId;
				}
				$this->collUserGroupsRelatedByUserId = $collUserGroupsRelatedByUserId;
			}
		}
		return $this->collUserGroupsRelatedByUserId;
	}

	/**
	 * Returns the number of related UserGroup objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserGroup objects.
	 * @throws     PropelException
	 */
	public function countUserGroupsRelatedByUserId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUserGroupsRelatedByUserId || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserGroupsRelatedByUserId) {
				return 0;
			} else {
				$query = UserGroupQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUserId($this)
					->count($con);
			}
		} else {
			return count($this->collUserGroupsRelatedByUserId);
		}
	}

	/**
	 * Method called to associate a UserGroup object to this object
	 * through the UserGroup foreign key attribute.
	 *
	 * @param      UserGroup $l UserGroup
	 * @return     User The current object (for fluent API support)
	 */
	public function addUserGroupRelatedByUserId(UserGroup $l)
	{
		if ($this->collUserGroupsRelatedByUserId === null) {
			$this->initUserGroupsRelatedByUserId();
		}
		if (!$this->collUserGroupsRelatedByUserId->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUserGroupsRelatedByUserId[]= $l;
			$l->setUserRelatedByUserId($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserGroupsRelatedByUserId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array UserGroup[] List of UserGroup objects
	 */
	public function getUserGroupsRelatedByUserIdJoinGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserGroupQuery::create(null, $criteria);
		$query->joinWith('Group', $join_behavior);

		return $this->getUserGroupsRelatedByUserId($query, $con);
	}

	/**
	 * Clears out the collUserRolesRelatedByUserId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserRolesRelatedByUserId()
	 */
	public function clearUserRolesRelatedByUserId()
	{
		$this->collUserRolesRelatedByUserId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserRolesRelatedByUserId collection.
	 *
	 * By default this just sets the collUserRolesRelatedByUserId collection to an empty array (like clearcollUserRolesRelatedByUserId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUserRolesRelatedByUserId($overrideExisting = true)
	{
		if (null !== $this->collUserRolesRelatedByUserId && !$overrideExisting) {
			return;
		}
		$this->collUserRolesRelatedByUserId = new PropelObjectCollection();
		$this->collUserRolesRelatedByUserId->setModel('UserRole');
	}

	/**
	 * Gets an array of UserRole objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array UserRole[] List of UserRole objects
	 * @throws     PropelException
	 */
	public function getUserRolesRelatedByUserId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUserRolesRelatedByUserId || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserRolesRelatedByUserId) {
				// return empty collection
				$this->initUserRolesRelatedByUserId();
			} else {
				$collUserRolesRelatedByUserId = UserRoleQuery::create(null, $criteria)
					->filterByUserRelatedByUserId($this)
					->find($con);
				if (null !== $criteria) {
					return $collUserRolesRelatedByUserId;
				}
				$this->collUserRolesRelatedByUserId = $collUserRolesRelatedByUserId;
			}
		}
		return $this->collUserRolesRelatedByUserId;
	}

	/**
	 * Returns the number of related UserRole objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserRole objects.
	 * @throws     PropelException
	 */
	public function countUserRolesRelatedByUserId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUserRolesRelatedByUserId || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserRolesRelatedByUserId) {
				return 0;
			} else {
				$query = UserRoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUserId($this)
					->count($con);
			}
		} else {
			return count($this->collUserRolesRelatedByUserId);
		}
	}

	/**
	 * Method called to associate a UserRole object to this object
	 * through the UserRole foreign key attribute.
	 *
	 * @param      UserRole $l UserRole
	 * @return     User The current object (for fluent API support)
	 */
	public function addUserRoleRelatedByUserId(UserRole $l)
	{
		if ($this->collUserRolesRelatedByUserId === null) {
			$this->initUserRolesRelatedByUserId();
		}
		if (!$this->collUserRolesRelatedByUserId->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUserRolesRelatedByUserId[]= $l;
			$l->setUserRelatedByUserId($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserRolesRelatedByUserId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array UserRole[] List of UserRole objects
	 */
	public function getUserRolesRelatedByUserIdJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserRoleQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getUserRolesRelatedByUserId($query, $con);
	}

	/**
	 * Clears out the collDocumentsRelatedByOwnerId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentsRelatedByOwnerId()
	 */
	public function clearDocumentsRelatedByOwnerId()
	{
		$this->collDocumentsRelatedByOwnerId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentsRelatedByOwnerId collection.
	 *
	 * By default this just sets the collDocumentsRelatedByOwnerId collection to an empty array (like clearcollDocumentsRelatedByOwnerId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentsRelatedByOwnerId($overrideExisting = true)
	{
		if (null !== $this->collDocumentsRelatedByOwnerId && !$overrideExisting) {
			return;
		}
		$this->collDocumentsRelatedByOwnerId = new PropelObjectCollection();
		$this->collDocumentsRelatedByOwnerId->setModel('Document');
	}

	/**
	 * Gets an array of Document objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Document[] List of Document objects
	 * @throws     PropelException
	 */
	public function getDocumentsRelatedByOwnerId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentsRelatedByOwnerId || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentsRelatedByOwnerId) {
				// return empty collection
				$this->initDocumentsRelatedByOwnerId();
			} else {
				$collDocumentsRelatedByOwnerId = DocumentQuery::create(null, $criteria)
					->filterByUserRelatedByOwnerId($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentsRelatedByOwnerId;
				}
				$this->collDocumentsRelatedByOwnerId = $collDocumentsRelatedByOwnerId;
			}
		}
		return $this->collDocumentsRelatedByOwnerId;
	}

	/**
	 * Returns the number of related Document objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Document objects.
	 * @throws     PropelException
	 */
	public function countDocumentsRelatedByOwnerId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentsRelatedByOwnerId || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentsRelatedByOwnerId) {
				return 0;
			} else {
				$query = DocumentQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByOwnerId($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentsRelatedByOwnerId);
		}
	}

	/**
	 * Method called to associate a Document object to this object
	 * through the Document foreign key attribute.
	 *
	 * @param      Document $l Document
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentRelatedByOwnerId(Document $l)
	{
		if ($this->collDocumentsRelatedByOwnerId === null) {
			$this->initDocumentsRelatedByOwnerId();
		}
		if (!$this->collDocumentsRelatedByOwnerId->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentsRelatedByOwnerId[]= $l;
			$l->setUserRelatedByOwnerId($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByOwnerIdJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getDocumentsRelatedByOwnerId($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByOwnerIdJoinDocumentType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('DocumentType', $join_behavior);

		return $this->getDocumentsRelatedByOwnerId($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByOwnerIdJoinDocumentCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('DocumentCategory', $join_behavior);

		return $this->getDocumentsRelatedByOwnerId($query, $con);
	}

	/**
	 * Clears out the collLinksRelatedByOwnerId collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLinksRelatedByOwnerId()
	 */
	public function clearLinksRelatedByOwnerId()
	{
		$this->collLinksRelatedByOwnerId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLinksRelatedByOwnerId collection.
	 *
	 * By default this just sets the collLinksRelatedByOwnerId collection to an empty array (like clearcollLinksRelatedByOwnerId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLinksRelatedByOwnerId($overrideExisting = true)
	{
		if (null !== $this->collLinksRelatedByOwnerId && !$overrideExisting) {
			return;
		}
		$this->collLinksRelatedByOwnerId = new PropelObjectCollection();
		$this->collLinksRelatedByOwnerId->setModel('Link');
	}

	/**
	 * Gets an array of Link objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Link[] List of Link objects
	 * @throws     PropelException
	 */
	public function getLinksRelatedByOwnerId($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLinksRelatedByOwnerId || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinksRelatedByOwnerId) {
				// return empty collection
				$this->initLinksRelatedByOwnerId();
			} else {
				$collLinksRelatedByOwnerId = LinkQuery::create(null, $criteria)
					->filterByUserRelatedByOwnerId($this)
					->find($con);
				if (null !== $criteria) {
					return $collLinksRelatedByOwnerId;
				}
				$this->collLinksRelatedByOwnerId = $collLinksRelatedByOwnerId;
			}
		}
		return $this->collLinksRelatedByOwnerId;
	}

	/**
	 * Returns the number of related Link objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Link objects.
	 * @throws     PropelException
	 */
	public function countLinksRelatedByOwnerId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLinksRelatedByOwnerId || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinksRelatedByOwnerId) {
				return 0;
			} else {
				$query = LinkQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByOwnerId($this)
					->count($con);
			}
		} else {
			return count($this->collLinksRelatedByOwnerId);
		}
	}

	/**
	 * Method called to associate a Link object to this object
	 * through the Link foreign key attribute.
	 *
	 * @param      Link $l Link
	 * @return     User The current object (for fluent API support)
	 */
	public function addLinkRelatedByOwnerId(Link $l)
	{
		if ($this->collLinksRelatedByOwnerId === null) {
			$this->initLinksRelatedByOwnerId();
		}
		if (!$this->collLinksRelatedByOwnerId->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLinksRelatedByOwnerId[]= $l;
			$l->setUserRelatedByOwnerId($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Link[] List of Link objects
	 */
	public function getLinksRelatedByOwnerIdJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LinkQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLinksRelatedByOwnerId($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Link[] List of Link objects
	 */
	public function getLinksRelatedByOwnerIdJoinLinkCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LinkQuery::create(null, $criteria);
		$query->joinWith('LinkCategory', $join_behavior);

		return $this->getLinksRelatedByOwnerId($query, $con);
	}

	/**
	 * Clears out the collPagesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPagesRelatedByCreatedBy()
	 */
	public function clearPagesRelatedByCreatedBy()
	{
		$this->collPagesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPagesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collPagesRelatedByCreatedBy collection to an empty array (like clearcollPagesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPagesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collPagesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collPagesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collPagesRelatedByCreatedBy->setModel('Page');
	}

	/**
	 * Gets an array of Page objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Page[] List of Page objects
	 * @throws     PropelException
	 */
	public function getPagesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPagesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagesRelatedByCreatedBy) {
				// return empty collection
				$this->initPagesRelatedByCreatedBy();
			} else {
				$collPagesRelatedByCreatedBy = PageQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPagesRelatedByCreatedBy;
				}
				$this->collPagesRelatedByCreatedBy = $collPagesRelatedByCreatedBy;
			}
		}
		return $this->collPagesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Page objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Page objects.
	 * @throws     PropelException
	 */
	public function countPagesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPagesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = PageQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPagesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Page object to this object
	 * through the Page foreign key attribute.
	 *
	 * @param      Page $l Page
	 * @return     User The current object (for fluent API support)
	 */
	public function addPageRelatedByCreatedBy(Page $l)
	{
		if ($this->collPagesRelatedByCreatedBy === null) {
			$this->initPagesRelatedByCreatedBy();
		}
		if (!$this->collPagesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPagesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collPagesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPagesRelatedByUpdatedBy()
	 */
	public function clearPagesRelatedByUpdatedBy()
	{
		$this->collPagesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPagesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collPagesRelatedByUpdatedBy collection to an empty array (like clearcollPagesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPagesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collPagesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collPagesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collPagesRelatedByUpdatedBy->setModel('Page');
	}

	/**
	 * Gets an array of Page objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Page[] List of Page objects
	 * @throws     PropelException
	 */
	public function getPagesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPagesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagesRelatedByUpdatedBy) {
				// return empty collection
				$this->initPagesRelatedByUpdatedBy();
			} else {
				$collPagesRelatedByUpdatedBy = PageQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPagesRelatedByUpdatedBy;
				}
				$this->collPagesRelatedByUpdatedBy = $collPagesRelatedByUpdatedBy;
			}
		}
		return $this->collPagesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Page objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Page objects.
	 * @throws     PropelException
	 */
	public function countPagesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPagesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = PageQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPagesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Page object to this object
	 * through the Page foreign key attribute.
	 *
	 * @param      Page $l Page
	 * @return     User The current object (for fluent API support)
	 */
	public function addPageRelatedByUpdatedBy(Page $l)
	{
		if ($this->collPagesRelatedByUpdatedBy === null) {
			$this->initPagesRelatedByUpdatedBy();
		}
		if (!$this->collPagesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPagesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collPagePropertysRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPagePropertysRelatedByCreatedBy()
	 */
	public function clearPagePropertysRelatedByCreatedBy()
	{
		$this->collPagePropertysRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPagePropertysRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collPagePropertysRelatedByCreatedBy collection to an empty array (like clearcollPagePropertysRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPagePropertysRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collPagePropertysRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collPagePropertysRelatedByCreatedBy = new PropelObjectCollection();
		$this->collPagePropertysRelatedByCreatedBy->setModel('PageProperty');
	}

	/**
	 * Gets an array of PageProperty objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 * @throws     PropelException
	 */
	public function getPagePropertysRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPagePropertysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagePropertysRelatedByCreatedBy) {
				// return empty collection
				$this->initPagePropertysRelatedByCreatedBy();
			} else {
				$collPagePropertysRelatedByCreatedBy = PagePropertyQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPagePropertysRelatedByCreatedBy;
				}
				$this->collPagePropertysRelatedByCreatedBy = $collPagePropertysRelatedByCreatedBy;
			}
		}
		return $this->collPagePropertysRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related PageProperty objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PageProperty objects.
	 * @throws     PropelException
	 */
	public function countPagePropertysRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPagePropertysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagePropertysRelatedByCreatedBy) {
				return 0;
			} else {
				$query = PagePropertyQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPagePropertysRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a PageProperty object to this object
	 * through the PageProperty foreign key attribute.
	 *
	 * @param      PageProperty $l PageProperty
	 * @return     User The current object (for fluent API support)
	 */
	public function addPagePropertyRelatedByCreatedBy(PageProperty $l)
	{
		if ($this->collPagePropertysRelatedByCreatedBy === null) {
			$this->initPagePropertysRelatedByCreatedBy();
		}
		if (!$this->collPagePropertysRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPagePropertysRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PagePropertysRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 */
	public function getPagePropertysRelatedByCreatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PagePropertyQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getPagePropertysRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collPagePropertysRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPagePropertysRelatedByUpdatedBy()
	 */
	public function clearPagePropertysRelatedByUpdatedBy()
	{
		$this->collPagePropertysRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPagePropertysRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collPagePropertysRelatedByUpdatedBy collection to an empty array (like clearcollPagePropertysRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPagePropertysRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collPagePropertysRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collPagePropertysRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collPagePropertysRelatedByUpdatedBy->setModel('PageProperty');
	}

	/**
	 * Gets an array of PageProperty objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 * @throws     PropelException
	 */
	public function getPagePropertysRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPagePropertysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagePropertysRelatedByUpdatedBy) {
				// return empty collection
				$this->initPagePropertysRelatedByUpdatedBy();
			} else {
				$collPagePropertysRelatedByUpdatedBy = PagePropertyQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPagePropertysRelatedByUpdatedBy;
				}
				$this->collPagePropertysRelatedByUpdatedBy = $collPagePropertysRelatedByUpdatedBy;
			}
		}
		return $this->collPagePropertysRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related PageProperty objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PageProperty objects.
	 * @throws     PropelException
	 */
	public function countPagePropertysRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPagePropertysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagePropertysRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = PagePropertyQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPagePropertysRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a PageProperty object to this object
	 * through the PageProperty foreign key attribute.
	 *
	 * @param      PageProperty $l PageProperty
	 * @return     User The current object (for fluent API support)
	 */
	public function addPagePropertyRelatedByUpdatedBy(PageProperty $l)
	{
		if ($this->collPagePropertysRelatedByUpdatedBy === null) {
			$this->initPagePropertysRelatedByUpdatedBy();
		}
		if (!$this->collPagePropertysRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPagePropertysRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PagePropertysRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 */
	public function getPagePropertysRelatedByUpdatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PagePropertyQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getPagePropertysRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collPageStringsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPageStringsRelatedByCreatedBy()
	 */
	public function clearPageStringsRelatedByCreatedBy()
	{
		$this->collPageStringsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPageStringsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collPageStringsRelatedByCreatedBy collection to an empty array (like clearcollPageStringsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPageStringsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collPageStringsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collPageStringsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collPageStringsRelatedByCreatedBy->setModel('PageString');
	}

	/**
	 * Gets an array of PageString objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 * @throws     PropelException
	 */
	public function getPageStringsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPageStringsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPageStringsRelatedByCreatedBy) {
				// return empty collection
				$this->initPageStringsRelatedByCreatedBy();
			} else {
				$collPageStringsRelatedByCreatedBy = PageStringQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPageStringsRelatedByCreatedBy;
				}
				$this->collPageStringsRelatedByCreatedBy = $collPageStringsRelatedByCreatedBy;
			}
		}
		return $this->collPageStringsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related PageString objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PageString objects.
	 * @throws     PropelException
	 */
	public function countPageStringsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPageStringsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPageStringsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = PageStringQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPageStringsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a PageString object to this object
	 * through the PageString foreign key attribute.
	 *
	 * @param      PageString $l PageString
	 * @return     User The current object (for fluent API support)
	 */
	public function addPageStringRelatedByCreatedBy(PageString $l)
	{
		if ($this->collPageStringsRelatedByCreatedBy === null) {
			$this->initPageStringsRelatedByCreatedBy();
		}
		if (!$this->collPageStringsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPageStringsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PageStringsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsRelatedByCreatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getPageStringsRelatedByCreatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PageStringsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsRelatedByCreatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getPageStringsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collPageStringsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPageStringsRelatedByUpdatedBy()
	 */
	public function clearPageStringsRelatedByUpdatedBy()
	{
		$this->collPageStringsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPageStringsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collPageStringsRelatedByUpdatedBy collection to an empty array (like clearcollPageStringsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initPageStringsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collPageStringsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collPageStringsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collPageStringsRelatedByUpdatedBy->setModel('PageString');
	}

	/**
	 * Gets an array of PageString objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 * @throws     PropelException
	 */
	public function getPageStringsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPageStringsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPageStringsRelatedByUpdatedBy) {
				// return empty collection
				$this->initPageStringsRelatedByUpdatedBy();
			} else {
				$collPageStringsRelatedByUpdatedBy = PageStringQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collPageStringsRelatedByUpdatedBy;
				}
				$this->collPageStringsRelatedByUpdatedBy = $collPageStringsRelatedByUpdatedBy;
			}
		}
		return $this->collPageStringsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related PageString objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related PageString objects.
	 * @throws     PropelException
	 */
	public function countPageStringsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPageStringsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collPageStringsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = PageStringQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collPageStringsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a PageString object to this object
	 * through the PageString foreign key attribute.
	 *
	 * @param      PageString $l PageString
	 * @return     User The current object (for fluent API support)
	 */
	public function addPageStringRelatedByUpdatedBy(PageString $l)
	{
		if ($this->collPageStringsRelatedByUpdatedBy === null) {
			$this->initPageStringsRelatedByUpdatedBy();
		}
		if (!$this->collPageStringsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPageStringsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PageStringsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsRelatedByUpdatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getPageStringsRelatedByUpdatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related PageStringsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsRelatedByUpdatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getPageStringsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collContentObjectsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addContentObjectsRelatedByCreatedBy()
	 */
	public function clearContentObjectsRelatedByCreatedBy()
	{
		$this->collContentObjectsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collContentObjectsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collContentObjectsRelatedByCreatedBy collection to an empty array (like clearcollContentObjectsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initContentObjectsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collContentObjectsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collContentObjectsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collContentObjectsRelatedByCreatedBy->setModel('ContentObject');
	}

	/**
	 * Gets an array of ContentObject objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 * @throws     PropelException
	 */
	public function getContentObjectsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collContentObjectsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collContentObjectsRelatedByCreatedBy) {
				// return empty collection
				$this->initContentObjectsRelatedByCreatedBy();
			} else {
				$collContentObjectsRelatedByCreatedBy = ContentObjectQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collContentObjectsRelatedByCreatedBy;
				}
				$this->collContentObjectsRelatedByCreatedBy = $collContentObjectsRelatedByCreatedBy;
			}
		}
		return $this->collContentObjectsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related ContentObject objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related ContentObject objects.
	 * @throws     PropelException
	 */
	public function countContentObjectsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collContentObjectsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collContentObjectsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = ContentObjectQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collContentObjectsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a ContentObject object to this object
	 * through the ContentObject foreign key attribute.
	 *
	 * @param      ContentObject $l ContentObject
	 * @return     User The current object (for fluent API support)
	 */
	public function addContentObjectRelatedByCreatedBy(ContentObject $l)
	{
		if ($this->collContentObjectsRelatedByCreatedBy === null) {
			$this->initContentObjectsRelatedByCreatedBy();
		}
		if (!$this->collContentObjectsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collContentObjectsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related ContentObjectsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 */
	public function getContentObjectsRelatedByCreatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = ContentObjectQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getContentObjectsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collContentObjectsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addContentObjectsRelatedByUpdatedBy()
	 */
	public function clearContentObjectsRelatedByUpdatedBy()
	{
		$this->collContentObjectsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collContentObjectsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collContentObjectsRelatedByUpdatedBy collection to an empty array (like clearcollContentObjectsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initContentObjectsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collContentObjectsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collContentObjectsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collContentObjectsRelatedByUpdatedBy->setModel('ContentObject');
	}

	/**
	 * Gets an array of ContentObject objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 * @throws     PropelException
	 */
	public function getContentObjectsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collContentObjectsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collContentObjectsRelatedByUpdatedBy) {
				// return empty collection
				$this->initContentObjectsRelatedByUpdatedBy();
			} else {
				$collContentObjectsRelatedByUpdatedBy = ContentObjectQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collContentObjectsRelatedByUpdatedBy;
				}
				$this->collContentObjectsRelatedByUpdatedBy = $collContentObjectsRelatedByUpdatedBy;
			}
		}
		return $this->collContentObjectsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related ContentObject objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related ContentObject objects.
	 * @throws     PropelException
	 */
	public function countContentObjectsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collContentObjectsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collContentObjectsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = ContentObjectQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collContentObjectsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a ContentObject object to this object
	 * through the ContentObject foreign key attribute.
	 *
	 * @param      ContentObject $l ContentObject
	 * @return     User The current object (for fluent API support)
	 */
	public function addContentObjectRelatedByUpdatedBy(ContentObject $l)
	{
		if ($this->collContentObjectsRelatedByUpdatedBy === null) {
			$this->initContentObjectsRelatedByUpdatedBy();
		}
		if (!$this->collContentObjectsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collContentObjectsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related ContentObjectsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 */
	public function getContentObjectsRelatedByUpdatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = ContentObjectQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getContentObjectsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collLanguageObjectsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLanguageObjectsRelatedByCreatedBy()
	 */
	public function clearLanguageObjectsRelatedByCreatedBy()
	{
		$this->collLanguageObjectsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLanguageObjectsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collLanguageObjectsRelatedByCreatedBy collection to an empty array (like clearcollLanguageObjectsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLanguageObjectsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collLanguageObjectsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collLanguageObjectsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collLanguageObjectsRelatedByCreatedBy->setModel('LanguageObject');
	}

	/**
	 * Gets an array of LanguageObject objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array LanguageObject[] List of LanguageObject objects
	 * @throws     PropelException
	 */
	public function getLanguageObjectsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectsRelatedByCreatedBy) {
				// return empty collection
				$this->initLanguageObjectsRelatedByCreatedBy();
			} else {
				$collLanguageObjectsRelatedByCreatedBy = LanguageObjectQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLanguageObjectsRelatedByCreatedBy;
				}
				$this->collLanguageObjectsRelatedByCreatedBy = $collLanguageObjectsRelatedByCreatedBy;
			}
		}
		return $this->collLanguageObjectsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related LanguageObject objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related LanguageObject objects.
	 * @throws     PropelException
	 */
	public function countLanguageObjectsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = LanguageObjectQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLanguageObjectsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a LanguageObject object to this object
	 * through the LanguageObject foreign key attribute.
	 *
	 * @param      LanguageObject $l LanguageObject
	 * @return     User The current object (for fluent API support)
	 */
	public function addLanguageObjectRelatedByCreatedBy(LanguageObject $l)
	{
		if ($this->collLanguageObjectsRelatedByCreatedBy === null) {
			$this->initLanguageObjectsRelatedByCreatedBy();
		}
		if (!$this->collLanguageObjectsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLanguageObjectsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObject[] List of LanguageObject objects
	 */
	public function getLanguageObjectsRelatedByCreatedByJoinContentObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectQuery::create(null, $criteria);
		$query->joinWith('ContentObject', $join_behavior);

		return $this->getLanguageObjectsRelatedByCreatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObject[] List of LanguageObject objects
	 */
	public function getLanguageObjectsRelatedByCreatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLanguageObjectsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collLanguageObjectsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLanguageObjectsRelatedByUpdatedBy()
	 */
	public function clearLanguageObjectsRelatedByUpdatedBy()
	{
		$this->collLanguageObjectsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLanguageObjectsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collLanguageObjectsRelatedByUpdatedBy collection to an empty array (like clearcollLanguageObjectsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLanguageObjectsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collLanguageObjectsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collLanguageObjectsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collLanguageObjectsRelatedByUpdatedBy->setModel('LanguageObject');
	}

	/**
	 * Gets an array of LanguageObject objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array LanguageObject[] List of LanguageObject objects
	 * @throws     PropelException
	 */
	public function getLanguageObjectsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectsRelatedByUpdatedBy) {
				// return empty collection
				$this->initLanguageObjectsRelatedByUpdatedBy();
			} else {
				$collLanguageObjectsRelatedByUpdatedBy = LanguageObjectQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLanguageObjectsRelatedByUpdatedBy;
				}
				$this->collLanguageObjectsRelatedByUpdatedBy = $collLanguageObjectsRelatedByUpdatedBy;
			}
		}
		return $this->collLanguageObjectsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related LanguageObject objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related LanguageObject objects.
	 * @throws     PropelException
	 */
	public function countLanguageObjectsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = LanguageObjectQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLanguageObjectsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a LanguageObject object to this object
	 * through the LanguageObject foreign key attribute.
	 *
	 * @param      LanguageObject $l LanguageObject
	 * @return     User The current object (for fluent API support)
	 */
	public function addLanguageObjectRelatedByUpdatedBy(LanguageObject $l)
	{
		if ($this->collLanguageObjectsRelatedByUpdatedBy === null) {
			$this->initLanguageObjectsRelatedByUpdatedBy();
		}
		if (!$this->collLanguageObjectsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLanguageObjectsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObject[] List of LanguageObject objects
	 */
	public function getLanguageObjectsRelatedByUpdatedByJoinContentObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectQuery::create(null, $criteria);
		$query->joinWith('ContentObject', $join_behavior);

		return $this->getLanguageObjectsRelatedByUpdatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObject[] List of LanguageObject objects
	 */
	public function getLanguageObjectsRelatedByUpdatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLanguageObjectsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collLanguageObjectHistorysRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLanguageObjectHistorysRelatedByCreatedBy()
	 */
	public function clearLanguageObjectHistorysRelatedByCreatedBy()
	{
		$this->collLanguageObjectHistorysRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLanguageObjectHistorysRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collLanguageObjectHistorysRelatedByCreatedBy collection to an empty array (like clearcollLanguageObjectHistorysRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLanguageObjectHistorysRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collLanguageObjectHistorysRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collLanguageObjectHistorysRelatedByCreatedBy = new PropelObjectCollection();
		$this->collLanguageObjectHistorysRelatedByCreatedBy->setModel('LanguageObjectHistory');
	}

	/**
	 * Gets an array of LanguageObjectHistory objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array LanguageObjectHistory[] List of LanguageObjectHistory objects
	 * @throws     PropelException
	 */
	public function getLanguageObjectHistorysRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectHistorysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectHistorysRelatedByCreatedBy) {
				// return empty collection
				$this->initLanguageObjectHistorysRelatedByCreatedBy();
			} else {
				$collLanguageObjectHistorysRelatedByCreatedBy = LanguageObjectHistoryQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLanguageObjectHistorysRelatedByCreatedBy;
				}
				$this->collLanguageObjectHistorysRelatedByCreatedBy = $collLanguageObjectHistorysRelatedByCreatedBy;
			}
		}
		return $this->collLanguageObjectHistorysRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related LanguageObjectHistory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related LanguageObjectHistory objects.
	 * @throws     PropelException
	 */
	public function countLanguageObjectHistorysRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectHistorysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectHistorysRelatedByCreatedBy) {
				return 0;
			} else {
				$query = LanguageObjectHistoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLanguageObjectHistorysRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a LanguageObjectHistory object to this object
	 * through the LanguageObjectHistory foreign key attribute.
	 *
	 * @param      LanguageObjectHistory $l LanguageObjectHistory
	 * @return     User The current object (for fluent API support)
	 */
	public function addLanguageObjectHistoryRelatedByCreatedBy(LanguageObjectHistory $l)
	{
		if ($this->collLanguageObjectHistorysRelatedByCreatedBy === null) {
			$this->initLanguageObjectHistorysRelatedByCreatedBy();
		}
		if (!$this->collLanguageObjectHistorysRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLanguageObjectHistorysRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorysRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObjectHistory[] List of LanguageObjectHistory objects
	 */
	public function getLanguageObjectHistorysRelatedByCreatedByJoinContentObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectHistoryQuery::create(null, $criteria);
		$query->joinWith('ContentObject', $join_behavior);

		return $this->getLanguageObjectHistorysRelatedByCreatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorysRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObjectHistory[] List of LanguageObjectHistory objects
	 */
	public function getLanguageObjectHistorysRelatedByCreatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectHistoryQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLanguageObjectHistorysRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collLanguageObjectHistorysRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLanguageObjectHistorysRelatedByUpdatedBy()
	 */
	public function clearLanguageObjectHistorysRelatedByUpdatedBy()
	{
		$this->collLanguageObjectHistorysRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLanguageObjectHistorysRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collLanguageObjectHistorysRelatedByUpdatedBy collection to an empty array (like clearcollLanguageObjectHistorysRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLanguageObjectHistorysRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collLanguageObjectHistorysRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collLanguageObjectHistorysRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collLanguageObjectHistorysRelatedByUpdatedBy->setModel('LanguageObjectHistory');
	}

	/**
	 * Gets an array of LanguageObjectHistory objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array LanguageObjectHistory[] List of LanguageObjectHistory objects
	 * @throws     PropelException
	 */
	public function getLanguageObjectHistorysRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectHistorysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectHistorysRelatedByUpdatedBy) {
				// return empty collection
				$this->initLanguageObjectHistorysRelatedByUpdatedBy();
			} else {
				$collLanguageObjectHistorysRelatedByUpdatedBy = LanguageObjectHistoryQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLanguageObjectHistorysRelatedByUpdatedBy;
				}
				$this->collLanguageObjectHistorysRelatedByUpdatedBy = $collLanguageObjectHistorysRelatedByUpdatedBy;
			}
		}
		return $this->collLanguageObjectHistorysRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related LanguageObjectHistory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related LanguageObjectHistory objects.
	 * @throws     PropelException
	 */
	public function countLanguageObjectHistorysRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLanguageObjectHistorysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguageObjectHistorysRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = LanguageObjectHistoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLanguageObjectHistorysRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a LanguageObjectHistory object to this object
	 * through the LanguageObjectHistory foreign key attribute.
	 *
	 * @param      LanguageObjectHistory $l LanguageObjectHistory
	 * @return     User The current object (for fluent API support)
	 */
	public function addLanguageObjectHistoryRelatedByUpdatedBy(LanguageObjectHistory $l)
	{
		if ($this->collLanguageObjectHistorysRelatedByUpdatedBy === null) {
			$this->initLanguageObjectHistorysRelatedByUpdatedBy();
		}
		if (!$this->collLanguageObjectHistorysRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLanguageObjectHistorysRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorysRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObjectHistory[] List of LanguageObjectHistory objects
	 */
	public function getLanguageObjectHistorysRelatedByUpdatedByJoinContentObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectHistoryQuery::create(null, $criteria);
		$query->joinWith('ContentObject', $join_behavior);

		return $this->getLanguageObjectHistorysRelatedByUpdatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related LanguageObjectHistorysRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array LanguageObjectHistory[] List of LanguageObjectHistory objects
	 */
	public function getLanguageObjectHistorysRelatedByUpdatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LanguageObjectHistoryQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLanguageObjectHistorysRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collLanguagesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLanguagesRelatedByCreatedBy()
	 */
	public function clearLanguagesRelatedByCreatedBy()
	{
		$this->collLanguagesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLanguagesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collLanguagesRelatedByCreatedBy collection to an empty array (like clearcollLanguagesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLanguagesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collLanguagesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collLanguagesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collLanguagesRelatedByCreatedBy->setModel('Language');
	}

	/**
	 * Gets an array of Language objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Language[] List of Language objects
	 * @throws     PropelException
	 */
	public function getLanguagesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLanguagesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguagesRelatedByCreatedBy) {
				// return empty collection
				$this->initLanguagesRelatedByCreatedBy();
			} else {
				$collLanguagesRelatedByCreatedBy = LanguageQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLanguagesRelatedByCreatedBy;
				}
				$this->collLanguagesRelatedByCreatedBy = $collLanguagesRelatedByCreatedBy;
			}
		}
		return $this->collLanguagesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Language objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Language objects.
	 * @throws     PropelException
	 */
	public function countLanguagesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLanguagesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguagesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = LanguageQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLanguagesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Language object to this object
	 * through the Language foreign key attribute.
	 *
	 * @param      Language $l Language
	 * @return     User The current object (for fluent API support)
	 */
	public function addLanguageRelatedByCreatedBy(Language $l)
	{
		if ($this->collLanguagesRelatedByCreatedBy === null) {
			$this->initLanguagesRelatedByCreatedBy();
		}
		if (!$this->collLanguagesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLanguagesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collLanguagesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLanguagesRelatedByUpdatedBy()
	 */
	public function clearLanguagesRelatedByUpdatedBy()
	{
		$this->collLanguagesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLanguagesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collLanguagesRelatedByUpdatedBy collection to an empty array (like clearcollLanguagesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLanguagesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collLanguagesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collLanguagesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collLanguagesRelatedByUpdatedBy->setModel('Language');
	}

	/**
	 * Gets an array of Language objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Language[] List of Language objects
	 * @throws     PropelException
	 */
	public function getLanguagesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLanguagesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguagesRelatedByUpdatedBy) {
				// return empty collection
				$this->initLanguagesRelatedByUpdatedBy();
			} else {
				$collLanguagesRelatedByUpdatedBy = LanguageQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLanguagesRelatedByUpdatedBy;
				}
				$this->collLanguagesRelatedByUpdatedBy = $collLanguagesRelatedByUpdatedBy;
			}
		}
		return $this->collLanguagesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Language objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Language objects.
	 * @throws     PropelException
	 */
	public function countLanguagesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLanguagesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLanguagesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = LanguageQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLanguagesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Language object to this object
	 * through the Language foreign key attribute.
	 *
	 * @param      Language $l Language
	 * @return     User The current object (for fluent API support)
	 */
	public function addLanguageRelatedByUpdatedBy(Language $l)
	{
		if ($this->collLanguagesRelatedByUpdatedBy === null) {
			$this->initLanguagesRelatedByUpdatedBy();
		}
		if (!$this->collLanguagesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLanguagesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collStringsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addStringsRelatedByCreatedBy()
	 */
	public function clearStringsRelatedByCreatedBy()
	{
		$this->collStringsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collStringsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collStringsRelatedByCreatedBy collection to an empty array (like clearcollStringsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initStringsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collStringsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collStringsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collStringsRelatedByCreatedBy->setModel('String');
	}

	/**
	 * Gets an array of String objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array String[] List of String objects
	 * @throws     PropelException
	 */
	public function getStringsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collStringsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collStringsRelatedByCreatedBy) {
				// return empty collection
				$this->initStringsRelatedByCreatedBy();
			} else {
				$collStringsRelatedByCreatedBy = StringQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collStringsRelatedByCreatedBy;
				}
				$this->collStringsRelatedByCreatedBy = $collStringsRelatedByCreatedBy;
			}
		}
		return $this->collStringsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related String objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related String objects.
	 * @throws     PropelException
	 */
	public function countStringsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collStringsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collStringsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = StringQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collStringsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a String object to this object
	 * through the String foreign key attribute.
	 *
	 * @param      String $l String
	 * @return     User The current object (for fluent API support)
	 */
	public function addStringRelatedByCreatedBy(String $l)
	{
		if ($this->collStringsRelatedByCreatedBy === null) {
			$this->initStringsRelatedByCreatedBy();
		}
		if (!$this->collStringsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collStringsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related StringsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array String[] List of String objects
	 */
	public function getStringsRelatedByCreatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = StringQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getStringsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collStringsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addStringsRelatedByUpdatedBy()
	 */
	public function clearStringsRelatedByUpdatedBy()
	{
		$this->collStringsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collStringsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collStringsRelatedByUpdatedBy collection to an empty array (like clearcollStringsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initStringsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collStringsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collStringsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collStringsRelatedByUpdatedBy->setModel('String');
	}

	/**
	 * Gets an array of String objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array String[] List of String objects
	 * @throws     PropelException
	 */
	public function getStringsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collStringsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collStringsRelatedByUpdatedBy) {
				// return empty collection
				$this->initStringsRelatedByUpdatedBy();
			} else {
				$collStringsRelatedByUpdatedBy = StringQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collStringsRelatedByUpdatedBy;
				}
				$this->collStringsRelatedByUpdatedBy = $collStringsRelatedByUpdatedBy;
			}
		}
		return $this->collStringsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related String objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related String objects.
	 * @throws     PropelException
	 */
	public function countStringsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collStringsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collStringsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = StringQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collStringsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a String object to this object
	 * through the String foreign key attribute.
	 *
	 * @param      String $l String
	 * @return     User The current object (for fluent API support)
	 */
	public function addStringRelatedByUpdatedBy(String $l)
	{
		if ($this->collStringsRelatedByUpdatedBy === null) {
			$this->initStringsRelatedByUpdatedBy();
		}
		if (!$this->collStringsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collStringsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related StringsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array String[] List of String objects
	 */
	public function getStringsRelatedByUpdatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = StringQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getStringsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collUserGroupsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserGroupsRelatedByCreatedBy()
	 */
	public function clearUserGroupsRelatedByCreatedBy()
	{
		$this->collUserGroupsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserGroupsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collUserGroupsRelatedByCreatedBy collection to an empty array (like clearcollUserGroupsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUserGroupsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collUserGroupsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collUserGroupsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collUserGroupsRelatedByCreatedBy->setModel('UserGroup');
	}

	/**
	 * Gets an array of UserGroup objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array UserGroup[] List of UserGroup objects
	 * @throws     PropelException
	 */
	public function getUserGroupsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUserGroupsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserGroupsRelatedByCreatedBy) {
				// return empty collection
				$this->initUserGroupsRelatedByCreatedBy();
			} else {
				$collUserGroupsRelatedByCreatedBy = UserGroupQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collUserGroupsRelatedByCreatedBy;
				}
				$this->collUserGroupsRelatedByCreatedBy = $collUserGroupsRelatedByCreatedBy;
			}
		}
		return $this->collUserGroupsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related UserGroup objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserGroup objects.
	 * @throws     PropelException
	 */
	public function countUserGroupsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUserGroupsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserGroupsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = UserGroupQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collUserGroupsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a UserGroup object to this object
	 * through the UserGroup foreign key attribute.
	 *
	 * @param      UserGroup $l UserGroup
	 * @return     User The current object (for fluent API support)
	 */
	public function addUserGroupRelatedByCreatedBy(UserGroup $l)
	{
		if ($this->collUserGroupsRelatedByCreatedBy === null) {
			$this->initUserGroupsRelatedByCreatedBy();
		}
		if (!$this->collUserGroupsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUserGroupsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserGroupsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array UserGroup[] List of UserGroup objects
	 */
	public function getUserGroupsRelatedByCreatedByJoinGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserGroupQuery::create(null, $criteria);
		$query->joinWith('Group', $join_behavior);

		return $this->getUserGroupsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collUserGroupsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserGroupsRelatedByUpdatedBy()
	 */
	public function clearUserGroupsRelatedByUpdatedBy()
	{
		$this->collUserGroupsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserGroupsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collUserGroupsRelatedByUpdatedBy collection to an empty array (like clearcollUserGroupsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUserGroupsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collUserGroupsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collUserGroupsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collUserGroupsRelatedByUpdatedBy->setModel('UserGroup');
	}

	/**
	 * Gets an array of UserGroup objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array UserGroup[] List of UserGroup objects
	 * @throws     PropelException
	 */
	public function getUserGroupsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUserGroupsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserGroupsRelatedByUpdatedBy) {
				// return empty collection
				$this->initUserGroupsRelatedByUpdatedBy();
			} else {
				$collUserGroupsRelatedByUpdatedBy = UserGroupQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collUserGroupsRelatedByUpdatedBy;
				}
				$this->collUserGroupsRelatedByUpdatedBy = $collUserGroupsRelatedByUpdatedBy;
			}
		}
		return $this->collUserGroupsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related UserGroup objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserGroup objects.
	 * @throws     PropelException
	 */
	public function countUserGroupsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUserGroupsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserGroupsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = UserGroupQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collUserGroupsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a UserGroup object to this object
	 * through the UserGroup foreign key attribute.
	 *
	 * @param      UserGroup $l UserGroup
	 * @return     User The current object (for fluent API support)
	 */
	public function addUserGroupRelatedByUpdatedBy(UserGroup $l)
	{
		if ($this->collUserGroupsRelatedByUpdatedBy === null) {
			$this->initUserGroupsRelatedByUpdatedBy();
		}
		if (!$this->collUserGroupsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUserGroupsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserGroupsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array UserGroup[] List of UserGroup objects
	 */
	public function getUserGroupsRelatedByUpdatedByJoinGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserGroupQuery::create(null, $criteria);
		$query->joinWith('Group', $join_behavior);

		return $this->getUserGroupsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collGroupsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGroupsRelatedByCreatedBy()
	 */
	public function clearGroupsRelatedByCreatedBy()
	{
		$this->collGroupsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGroupsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collGroupsRelatedByCreatedBy collection to an empty array (like clearcollGroupsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initGroupsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collGroupsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collGroupsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collGroupsRelatedByCreatedBy->setModel('Group');
	}

	/**
	 * Gets an array of Group objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Group[] List of Group objects
	 * @throws     PropelException
	 */
	public function getGroupsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collGroupsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupsRelatedByCreatedBy) {
				// return empty collection
				$this->initGroupsRelatedByCreatedBy();
			} else {
				$collGroupsRelatedByCreatedBy = GroupQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collGroupsRelatedByCreatedBy;
				}
				$this->collGroupsRelatedByCreatedBy = $collGroupsRelatedByCreatedBy;
			}
		}
		return $this->collGroupsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Group objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Group objects.
	 * @throws     PropelException
	 */
	public function countGroupsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collGroupsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = GroupQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collGroupsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Group object to this object
	 * through the Group foreign key attribute.
	 *
	 * @param      Group $l Group
	 * @return     User The current object (for fluent API support)
	 */
	public function addGroupRelatedByCreatedBy(Group $l)
	{
		if ($this->collGroupsRelatedByCreatedBy === null) {
			$this->initGroupsRelatedByCreatedBy();
		}
		if (!$this->collGroupsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collGroupsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collGroupsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGroupsRelatedByUpdatedBy()
	 */
	public function clearGroupsRelatedByUpdatedBy()
	{
		$this->collGroupsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGroupsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collGroupsRelatedByUpdatedBy collection to an empty array (like clearcollGroupsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initGroupsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collGroupsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collGroupsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collGroupsRelatedByUpdatedBy->setModel('Group');
	}

	/**
	 * Gets an array of Group objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Group[] List of Group objects
	 * @throws     PropelException
	 */
	public function getGroupsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collGroupsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupsRelatedByUpdatedBy) {
				// return empty collection
				$this->initGroupsRelatedByUpdatedBy();
			} else {
				$collGroupsRelatedByUpdatedBy = GroupQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collGroupsRelatedByUpdatedBy;
				}
				$this->collGroupsRelatedByUpdatedBy = $collGroupsRelatedByUpdatedBy;
			}
		}
		return $this->collGroupsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Group objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Group objects.
	 * @throws     PropelException
	 */
	public function countGroupsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collGroupsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = GroupQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collGroupsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Group object to this object
	 * through the Group foreign key attribute.
	 *
	 * @param      Group $l Group
	 * @return     User The current object (for fluent API support)
	 */
	public function addGroupRelatedByUpdatedBy(Group $l)
	{
		if ($this->collGroupsRelatedByUpdatedBy === null) {
			$this->initGroupsRelatedByUpdatedBy();
		}
		if (!$this->collGroupsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collGroupsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collGroupRolesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGroupRolesRelatedByCreatedBy()
	 */
	public function clearGroupRolesRelatedByCreatedBy()
	{
		$this->collGroupRolesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGroupRolesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collGroupRolesRelatedByCreatedBy collection to an empty array (like clearcollGroupRolesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initGroupRolesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collGroupRolesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collGroupRolesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collGroupRolesRelatedByCreatedBy->setModel('GroupRole');
	}

	/**
	 * Gets an array of GroupRole objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array GroupRole[] List of GroupRole objects
	 * @throws     PropelException
	 */
	public function getGroupRolesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collGroupRolesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupRolesRelatedByCreatedBy) {
				// return empty collection
				$this->initGroupRolesRelatedByCreatedBy();
			} else {
				$collGroupRolesRelatedByCreatedBy = GroupRoleQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collGroupRolesRelatedByCreatedBy;
				}
				$this->collGroupRolesRelatedByCreatedBy = $collGroupRolesRelatedByCreatedBy;
			}
		}
		return $this->collGroupRolesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related GroupRole objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GroupRole objects.
	 * @throws     PropelException
	 */
	public function countGroupRolesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collGroupRolesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupRolesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = GroupRoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collGroupRolesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a GroupRole object to this object
	 * through the GroupRole foreign key attribute.
	 *
	 * @param      GroupRole $l GroupRole
	 * @return     User The current object (for fluent API support)
	 */
	public function addGroupRoleRelatedByCreatedBy(GroupRole $l)
	{
		if ($this->collGroupRolesRelatedByCreatedBy === null) {
			$this->initGroupRolesRelatedByCreatedBy();
		}
		if (!$this->collGroupRolesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collGroupRolesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GroupRolesRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array GroupRole[] List of GroupRole objects
	 */
	public function getGroupRolesRelatedByCreatedByJoinGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = GroupRoleQuery::create(null, $criteria);
		$query->joinWith('Group', $join_behavior);

		return $this->getGroupRolesRelatedByCreatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GroupRolesRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array GroupRole[] List of GroupRole objects
	 */
	public function getGroupRolesRelatedByCreatedByJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = GroupRoleQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getGroupRolesRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collGroupRolesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addGroupRolesRelatedByUpdatedBy()
	 */
	public function clearGroupRolesRelatedByUpdatedBy()
	{
		$this->collGroupRolesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collGroupRolesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collGroupRolesRelatedByUpdatedBy collection to an empty array (like clearcollGroupRolesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initGroupRolesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collGroupRolesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collGroupRolesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collGroupRolesRelatedByUpdatedBy->setModel('GroupRole');
	}

	/**
	 * Gets an array of GroupRole objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array GroupRole[] List of GroupRole objects
	 * @throws     PropelException
	 */
	public function getGroupRolesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collGroupRolesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupRolesRelatedByUpdatedBy) {
				// return empty collection
				$this->initGroupRolesRelatedByUpdatedBy();
			} else {
				$collGroupRolesRelatedByUpdatedBy = GroupRoleQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collGroupRolesRelatedByUpdatedBy;
				}
				$this->collGroupRolesRelatedByUpdatedBy = $collGroupRolesRelatedByUpdatedBy;
			}
		}
		return $this->collGroupRolesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related GroupRole objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related GroupRole objects.
	 * @throws     PropelException
	 */
	public function countGroupRolesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collGroupRolesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collGroupRolesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = GroupRoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collGroupRolesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a GroupRole object to this object
	 * through the GroupRole foreign key attribute.
	 *
	 * @param      GroupRole $l GroupRole
	 * @return     User The current object (for fluent API support)
	 */
	public function addGroupRoleRelatedByUpdatedBy(GroupRole $l)
	{
		if ($this->collGroupRolesRelatedByUpdatedBy === null) {
			$this->initGroupRolesRelatedByUpdatedBy();
		}
		if (!$this->collGroupRolesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collGroupRolesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GroupRolesRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array GroupRole[] List of GroupRole objects
	 */
	public function getGroupRolesRelatedByUpdatedByJoinGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = GroupRoleQuery::create(null, $criteria);
		$query->joinWith('Group', $join_behavior);

		return $this->getGroupRolesRelatedByUpdatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related GroupRolesRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array GroupRole[] List of GroupRole objects
	 */
	public function getGroupRolesRelatedByUpdatedByJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = GroupRoleQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getGroupRolesRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collRolesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRolesRelatedByCreatedBy()
	 */
	public function clearRolesRelatedByCreatedBy()
	{
		$this->collRolesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRolesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collRolesRelatedByCreatedBy collection to an empty array (like clearcollRolesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRolesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collRolesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collRolesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collRolesRelatedByCreatedBy->setModel('Role');
	}

	/**
	 * Gets an array of Role objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Role[] List of Role objects
	 * @throws     PropelException
	 */
	public function getRolesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRolesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRolesRelatedByCreatedBy) {
				// return empty collection
				$this->initRolesRelatedByCreatedBy();
			} else {
				$collRolesRelatedByCreatedBy = RoleQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collRolesRelatedByCreatedBy;
				}
				$this->collRolesRelatedByCreatedBy = $collRolesRelatedByCreatedBy;
			}
		}
		return $this->collRolesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Role objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Role objects.
	 * @throws     PropelException
	 */
	public function countRolesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRolesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRolesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = RoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collRolesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Role object to this object
	 * through the Role foreign key attribute.
	 *
	 * @param      Role $l Role
	 * @return     User The current object (for fluent API support)
	 */
	public function addRoleRelatedByCreatedBy(Role $l)
	{
		if ($this->collRolesRelatedByCreatedBy === null) {
			$this->initRolesRelatedByCreatedBy();
		}
		if (!$this->collRolesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collRolesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collRolesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRolesRelatedByUpdatedBy()
	 */
	public function clearRolesRelatedByUpdatedBy()
	{
		$this->collRolesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRolesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collRolesRelatedByUpdatedBy collection to an empty array (like clearcollRolesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRolesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collRolesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collRolesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collRolesRelatedByUpdatedBy->setModel('Role');
	}

	/**
	 * Gets an array of Role objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Role[] List of Role objects
	 * @throws     PropelException
	 */
	public function getRolesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRolesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRolesRelatedByUpdatedBy) {
				// return empty collection
				$this->initRolesRelatedByUpdatedBy();
			} else {
				$collRolesRelatedByUpdatedBy = RoleQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collRolesRelatedByUpdatedBy;
				}
				$this->collRolesRelatedByUpdatedBy = $collRolesRelatedByUpdatedBy;
			}
		}
		return $this->collRolesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Role objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Role objects.
	 * @throws     PropelException
	 */
	public function countRolesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRolesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRolesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = RoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collRolesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Role object to this object
	 * through the Role foreign key attribute.
	 *
	 * @param      Role $l Role
	 * @return     User The current object (for fluent API support)
	 */
	public function addRoleRelatedByUpdatedBy(Role $l)
	{
		if ($this->collRolesRelatedByUpdatedBy === null) {
			$this->initRolesRelatedByUpdatedBy();
		}
		if (!$this->collRolesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collRolesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collUserRolesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserRolesRelatedByCreatedBy()
	 */
	public function clearUserRolesRelatedByCreatedBy()
	{
		$this->collUserRolesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserRolesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collUserRolesRelatedByCreatedBy collection to an empty array (like clearcollUserRolesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUserRolesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collUserRolesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collUserRolesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collUserRolesRelatedByCreatedBy->setModel('UserRole');
	}

	/**
	 * Gets an array of UserRole objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array UserRole[] List of UserRole objects
	 * @throws     PropelException
	 */
	public function getUserRolesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUserRolesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserRolesRelatedByCreatedBy) {
				// return empty collection
				$this->initUserRolesRelatedByCreatedBy();
			} else {
				$collUserRolesRelatedByCreatedBy = UserRoleQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collUserRolesRelatedByCreatedBy;
				}
				$this->collUserRolesRelatedByCreatedBy = $collUserRolesRelatedByCreatedBy;
			}
		}
		return $this->collUserRolesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related UserRole objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserRole objects.
	 * @throws     PropelException
	 */
	public function countUserRolesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUserRolesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserRolesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = UserRoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collUserRolesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a UserRole object to this object
	 * through the UserRole foreign key attribute.
	 *
	 * @param      UserRole $l UserRole
	 * @return     User The current object (for fluent API support)
	 */
	public function addUserRoleRelatedByCreatedBy(UserRole $l)
	{
		if ($this->collUserRolesRelatedByCreatedBy === null) {
			$this->initUserRolesRelatedByCreatedBy();
		}
		if (!$this->collUserRolesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUserRolesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserRolesRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array UserRole[] List of UserRole objects
	 */
	public function getUserRolesRelatedByCreatedByJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserRoleQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getUserRolesRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collUserRolesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addUserRolesRelatedByUpdatedBy()
	 */
	public function clearUserRolesRelatedByUpdatedBy()
	{
		$this->collUserRolesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collUserRolesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collUserRolesRelatedByUpdatedBy collection to an empty array (like clearcollUserRolesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initUserRolesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collUserRolesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collUserRolesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collUserRolesRelatedByUpdatedBy->setModel('UserRole');
	}

	/**
	 * Gets an array of UserRole objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array UserRole[] List of UserRole objects
	 * @throws     PropelException
	 */
	public function getUserRolesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collUserRolesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserRolesRelatedByUpdatedBy) {
				// return empty collection
				$this->initUserRolesRelatedByUpdatedBy();
			} else {
				$collUserRolesRelatedByUpdatedBy = UserRoleQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collUserRolesRelatedByUpdatedBy;
				}
				$this->collUserRolesRelatedByUpdatedBy = $collUserRolesRelatedByUpdatedBy;
			}
		}
		return $this->collUserRolesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related UserRole objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related UserRole objects.
	 * @throws     PropelException
	 */
	public function countUserRolesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collUserRolesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collUserRolesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = UserRoleQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collUserRolesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a UserRole object to this object
	 * through the UserRole foreign key attribute.
	 *
	 * @param      UserRole $l UserRole
	 * @return     User The current object (for fluent API support)
	 */
	public function addUserRoleRelatedByUpdatedBy(UserRole $l)
	{
		if ($this->collUserRolesRelatedByUpdatedBy === null) {
			$this->initUserRolesRelatedByUpdatedBy();
		}
		if (!$this->collUserRolesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collUserRolesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related UserRolesRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array UserRole[] List of UserRole objects
	 */
	public function getUserRolesRelatedByUpdatedByJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = UserRoleQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getUserRolesRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collRightsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRightsRelatedByCreatedBy()
	 */
	public function clearRightsRelatedByCreatedBy()
	{
		$this->collRightsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRightsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collRightsRelatedByCreatedBy collection to an empty array (like clearcollRightsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRightsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collRightsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collRightsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collRightsRelatedByCreatedBy->setModel('Right');
	}

	/**
	 * Gets an array of Right objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Right[] List of Right objects
	 * @throws     PropelException
	 */
	public function getRightsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRightsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRightsRelatedByCreatedBy) {
				// return empty collection
				$this->initRightsRelatedByCreatedBy();
			} else {
				$collRightsRelatedByCreatedBy = RightQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collRightsRelatedByCreatedBy;
				}
				$this->collRightsRelatedByCreatedBy = $collRightsRelatedByCreatedBy;
			}
		}
		return $this->collRightsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Right objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Right objects.
	 * @throws     PropelException
	 */
	public function countRightsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRightsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRightsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = RightQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collRightsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Right object to this object
	 * through the Right foreign key attribute.
	 *
	 * @param      Right $l Right
	 * @return     User The current object (for fluent API support)
	 */
	public function addRightRelatedByCreatedBy(Right $l)
	{
		if ($this->collRightsRelatedByCreatedBy === null) {
			$this->initRightsRelatedByCreatedBy();
		}
		if (!$this->collRightsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collRightsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related RightsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsRelatedByCreatedByJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getRightsRelatedByCreatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related RightsRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsRelatedByCreatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getRightsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collRightsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRightsRelatedByUpdatedBy()
	 */
	public function clearRightsRelatedByUpdatedBy()
	{
		$this->collRightsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRightsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collRightsRelatedByUpdatedBy collection to an empty array (like clearcollRightsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initRightsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collRightsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collRightsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collRightsRelatedByUpdatedBy->setModel('Right');
	}

	/**
	 * Gets an array of Right objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Right[] List of Right objects
	 * @throws     PropelException
	 */
	public function getRightsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRightsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRightsRelatedByUpdatedBy) {
				// return empty collection
				$this->initRightsRelatedByUpdatedBy();
			} else {
				$collRightsRelatedByUpdatedBy = RightQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collRightsRelatedByUpdatedBy;
				}
				$this->collRightsRelatedByUpdatedBy = $collRightsRelatedByUpdatedBy;
			}
		}
		return $this->collRightsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Right objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Right objects.
	 * @throws     PropelException
	 */
	public function countRightsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRightsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collRightsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = RightQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collRightsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Right object to this object
	 * through the Right foreign key attribute.
	 *
	 * @param      Right $l Right
	 * @return     User The current object (for fluent API support)
	 */
	public function addRightRelatedByUpdatedBy(Right $l)
	{
		if ($this->collRightsRelatedByUpdatedBy === null) {
			$this->initRightsRelatedByUpdatedBy();
		}
		if (!$this->collRightsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collRightsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related RightsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsRelatedByUpdatedByJoinRole($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('Role', $join_behavior);

		return $this->getRightsRelatedByUpdatedBy($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related RightsRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsRelatedByUpdatedByJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('Page', $join_behavior);

		return $this->getRightsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collDocumentsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentsRelatedByCreatedBy()
	 */
	public function clearDocumentsRelatedByCreatedBy()
	{
		$this->collDocumentsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collDocumentsRelatedByCreatedBy collection to an empty array (like clearcollDocumentsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collDocumentsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collDocumentsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collDocumentsRelatedByCreatedBy->setModel('Document');
	}

	/**
	 * Gets an array of Document objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Document[] List of Document objects
	 * @throws     PropelException
	 */
	public function getDocumentsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentsRelatedByCreatedBy) {
				// return empty collection
				$this->initDocumentsRelatedByCreatedBy();
			} else {
				$collDocumentsRelatedByCreatedBy = DocumentQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentsRelatedByCreatedBy;
				}
				$this->collDocumentsRelatedByCreatedBy = $collDocumentsRelatedByCreatedBy;
			}
		}
		return $this->collDocumentsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Document objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Document objects.
	 * @throws     PropelException
	 */
	public function countDocumentsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = DocumentQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Document object to this object
	 * through the Document foreign key attribute.
	 *
	 * @param      Document $l Document
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentRelatedByCreatedBy(Document $l)
	{
		if ($this->collDocumentsRelatedByCreatedBy === null) {
			$this->initDocumentsRelatedByCreatedBy();
		}
		if (!$this->collDocumentsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByCreatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getDocumentsRelatedByCreatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByCreatedByJoinDocumentType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('DocumentType', $join_behavior);

		return $this->getDocumentsRelatedByCreatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByCreatedByJoinDocumentCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('DocumentCategory', $join_behavior);

		return $this->getDocumentsRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collDocumentsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentsRelatedByUpdatedBy()
	 */
	public function clearDocumentsRelatedByUpdatedBy()
	{
		$this->collDocumentsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collDocumentsRelatedByUpdatedBy collection to an empty array (like clearcollDocumentsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collDocumentsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collDocumentsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collDocumentsRelatedByUpdatedBy->setModel('Document');
	}

	/**
	 * Gets an array of Document objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Document[] List of Document objects
	 * @throws     PropelException
	 */
	public function getDocumentsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentsRelatedByUpdatedBy) {
				// return empty collection
				$this->initDocumentsRelatedByUpdatedBy();
			} else {
				$collDocumentsRelatedByUpdatedBy = DocumentQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentsRelatedByUpdatedBy;
				}
				$this->collDocumentsRelatedByUpdatedBy = $collDocumentsRelatedByUpdatedBy;
			}
		}
		return $this->collDocumentsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Document objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Document objects.
	 * @throws     PropelException
	 */
	public function countDocumentsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = DocumentQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Document object to this object
	 * through the Document foreign key attribute.
	 *
	 * @param      Document $l Document
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentRelatedByUpdatedBy(Document $l)
	{
		if ($this->collDocumentsRelatedByUpdatedBy === null) {
			$this->initDocumentsRelatedByUpdatedBy();
		}
		if (!$this->collDocumentsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByUpdatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getDocumentsRelatedByUpdatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByUpdatedByJoinDocumentType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('DocumentType', $join_behavior);

		return $this->getDocumentsRelatedByUpdatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Document[] List of Document objects
	 */
	public function getDocumentsRelatedByUpdatedByJoinDocumentCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = DocumentQuery::create(null, $criteria);
		$query->joinWith('DocumentCategory', $join_behavior);

		return $this->getDocumentsRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collDocumentTypesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentTypesRelatedByCreatedBy()
	 */
	public function clearDocumentTypesRelatedByCreatedBy()
	{
		$this->collDocumentTypesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentTypesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collDocumentTypesRelatedByCreatedBy collection to an empty array (like clearcollDocumentTypesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentTypesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collDocumentTypesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collDocumentTypesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collDocumentTypesRelatedByCreatedBy->setModel('DocumentType');
	}

	/**
	 * Gets an array of DocumentType objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array DocumentType[] List of DocumentType objects
	 * @throws     PropelException
	 */
	public function getDocumentTypesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentTypesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentTypesRelatedByCreatedBy) {
				// return empty collection
				$this->initDocumentTypesRelatedByCreatedBy();
			} else {
				$collDocumentTypesRelatedByCreatedBy = DocumentTypeQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentTypesRelatedByCreatedBy;
				}
				$this->collDocumentTypesRelatedByCreatedBy = $collDocumentTypesRelatedByCreatedBy;
			}
		}
		return $this->collDocumentTypesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related DocumentType objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related DocumentType objects.
	 * @throws     PropelException
	 */
	public function countDocumentTypesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentTypesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentTypesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = DocumentTypeQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentTypesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a DocumentType object to this object
	 * through the DocumentType foreign key attribute.
	 *
	 * @param      DocumentType $l DocumentType
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentTypeRelatedByCreatedBy(DocumentType $l)
	{
		if ($this->collDocumentTypesRelatedByCreatedBy === null) {
			$this->initDocumentTypesRelatedByCreatedBy();
		}
		if (!$this->collDocumentTypesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentTypesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collDocumentTypesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentTypesRelatedByUpdatedBy()
	 */
	public function clearDocumentTypesRelatedByUpdatedBy()
	{
		$this->collDocumentTypesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentTypesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collDocumentTypesRelatedByUpdatedBy collection to an empty array (like clearcollDocumentTypesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentTypesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collDocumentTypesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collDocumentTypesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collDocumentTypesRelatedByUpdatedBy->setModel('DocumentType');
	}

	/**
	 * Gets an array of DocumentType objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array DocumentType[] List of DocumentType objects
	 * @throws     PropelException
	 */
	public function getDocumentTypesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentTypesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentTypesRelatedByUpdatedBy) {
				// return empty collection
				$this->initDocumentTypesRelatedByUpdatedBy();
			} else {
				$collDocumentTypesRelatedByUpdatedBy = DocumentTypeQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentTypesRelatedByUpdatedBy;
				}
				$this->collDocumentTypesRelatedByUpdatedBy = $collDocumentTypesRelatedByUpdatedBy;
			}
		}
		return $this->collDocumentTypesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related DocumentType objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related DocumentType objects.
	 * @throws     PropelException
	 */
	public function countDocumentTypesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentTypesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentTypesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = DocumentTypeQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentTypesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a DocumentType object to this object
	 * through the DocumentType foreign key attribute.
	 *
	 * @param      DocumentType $l DocumentType
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentTypeRelatedByUpdatedBy(DocumentType $l)
	{
		if ($this->collDocumentTypesRelatedByUpdatedBy === null) {
			$this->initDocumentTypesRelatedByUpdatedBy();
		}
		if (!$this->collDocumentTypesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentTypesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collDocumentCategorysRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentCategorysRelatedByCreatedBy()
	 */
	public function clearDocumentCategorysRelatedByCreatedBy()
	{
		$this->collDocumentCategorysRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentCategorysRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collDocumentCategorysRelatedByCreatedBy collection to an empty array (like clearcollDocumentCategorysRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentCategorysRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collDocumentCategorysRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collDocumentCategorysRelatedByCreatedBy = new PropelObjectCollection();
		$this->collDocumentCategorysRelatedByCreatedBy->setModel('DocumentCategory');
	}

	/**
	 * Gets an array of DocumentCategory objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array DocumentCategory[] List of DocumentCategory objects
	 * @throws     PropelException
	 */
	public function getDocumentCategorysRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentCategorysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentCategorysRelatedByCreatedBy) {
				// return empty collection
				$this->initDocumentCategorysRelatedByCreatedBy();
			} else {
				$collDocumentCategorysRelatedByCreatedBy = DocumentCategoryQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentCategorysRelatedByCreatedBy;
				}
				$this->collDocumentCategorysRelatedByCreatedBy = $collDocumentCategorysRelatedByCreatedBy;
			}
		}
		return $this->collDocumentCategorysRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related DocumentCategory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related DocumentCategory objects.
	 * @throws     PropelException
	 */
	public function countDocumentCategorysRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentCategorysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentCategorysRelatedByCreatedBy) {
				return 0;
			} else {
				$query = DocumentCategoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentCategorysRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a DocumentCategory object to this object
	 * through the DocumentCategory foreign key attribute.
	 *
	 * @param      DocumentCategory $l DocumentCategory
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentCategoryRelatedByCreatedBy(DocumentCategory $l)
	{
		if ($this->collDocumentCategorysRelatedByCreatedBy === null) {
			$this->initDocumentCategorysRelatedByCreatedBy();
		}
		if (!$this->collDocumentCategorysRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentCategorysRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collDocumentCategorysRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addDocumentCategorysRelatedByUpdatedBy()
	 */
	public function clearDocumentCategorysRelatedByUpdatedBy()
	{
		$this->collDocumentCategorysRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collDocumentCategorysRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collDocumentCategorysRelatedByUpdatedBy collection to an empty array (like clearcollDocumentCategorysRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initDocumentCategorysRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collDocumentCategorysRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collDocumentCategorysRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collDocumentCategorysRelatedByUpdatedBy->setModel('DocumentCategory');
	}

	/**
	 * Gets an array of DocumentCategory objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array DocumentCategory[] List of DocumentCategory objects
	 * @throws     PropelException
	 */
	public function getDocumentCategorysRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collDocumentCategorysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentCategorysRelatedByUpdatedBy) {
				// return empty collection
				$this->initDocumentCategorysRelatedByUpdatedBy();
			} else {
				$collDocumentCategorysRelatedByUpdatedBy = DocumentCategoryQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collDocumentCategorysRelatedByUpdatedBy;
				}
				$this->collDocumentCategorysRelatedByUpdatedBy = $collDocumentCategorysRelatedByUpdatedBy;
			}
		}
		return $this->collDocumentCategorysRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related DocumentCategory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related DocumentCategory objects.
	 * @throws     PropelException
	 */
	public function countDocumentCategorysRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collDocumentCategorysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collDocumentCategorysRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = DocumentCategoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collDocumentCategorysRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a DocumentCategory object to this object
	 * through the DocumentCategory foreign key attribute.
	 *
	 * @param      DocumentCategory $l DocumentCategory
	 * @return     User The current object (for fluent API support)
	 */
	public function addDocumentCategoryRelatedByUpdatedBy(DocumentCategory $l)
	{
		if ($this->collDocumentCategorysRelatedByUpdatedBy === null) {
			$this->initDocumentCategorysRelatedByUpdatedBy();
		}
		if (!$this->collDocumentCategorysRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collDocumentCategorysRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collTagsRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addTagsRelatedByCreatedBy()
	 */
	public function clearTagsRelatedByCreatedBy()
	{
		$this->collTagsRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collTagsRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collTagsRelatedByCreatedBy collection to an empty array (like clearcollTagsRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initTagsRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collTagsRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collTagsRelatedByCreatedBy = new PropelObjectCollection();
		$this->collTagsRelatedByCreatedBy->setModel('Tag');
	}

	/**
	 * Gets an array of Tag objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Tag[] List of Tag objects
	 * @throws     PropelException
	 */
	public function getTagsRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collTagsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagsRelatedByCreatedBy) {
				// return empty collection
				$this->initTagsRelatedByCreatedBy();
			} else {
				$collTagsRelatedByCreatedBy = TagQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collTagsRelatedByCreatedBy;
				}
				$this->collTagsRelatedByCreatedBy = $collTagsRelatedByCreatedBy;
			}
		}
		return $this->collTagsRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Tag objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Tag objects.
	 * @throws     PropelException
	 */
	public function countTagsRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collTagsRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagsRelatedByCreatedBy) {
				return 0;
			} else {
				$query = TagQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collTagsRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Tag object to this object
	 * through the Tag foreign key attribute.
	 *
	 * @param      Tag $l Tag
	 * @return     User The current object (for fluent API support)
	 */
	public function addTagRelatedByCreatedBy(Tag $l)
	{
		if ($this->collTagsRelatedByCreatedBy === null) {
			$this->initTagsRelatedByCreatedBy();
		}
		if (!$this->collTagsRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collTagsRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collTagsRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addTagsRelatedByUpdatedBy()
	 */
	public function clearTagsRelatedByUpdatedBy()
	{
		$this->collTagsRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collTagsRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collTagsRelatedByUpdatedBy collection to an empty array (like clearcollTagsRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initTagsRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collTagsRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collTagsRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collTagsRelatedByUpdatedBy->setModel('Tag');
	}

	/**
	 * Gets an array of Tag objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Tag[] List of Tag objects
	 * @throws     PropelException
	 */
	public function getTagsRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collTagsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagsRelatedByUpdatedBy) {
				// return empty collection
				$this->initTagsRelatedByUpdatedBy();
			} else {
				$collTagsRelatedByUpdatedBy = TagQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collTagsRelatedByUpdatedBy;
				}
				$this->collTagsRelatedByUpdatedBy = $collTagsRelatedByUpdatedBy;
			}
		}
		return $this->collTagsRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Tag objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Tag objects.
	 * @throws     PropelException
	 */
	public function countTagsRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collTagsRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagsRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = TagQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collTagsRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Tag object to this object
	 * through the Tag foreign key attribute.
	 *
	 * @param      Tag $l Tag
	 * @return     User The current object (for fluent API support)
	 */
	public function addTagRelatedByUpdatedBy(Tag $l)
	{
		if ($this->collTagsRelatedByUpdatedBy === null) {
			$this->initTagsRelatedByUpdatedBy();
		}
		if (!$this->collTagsRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collTagsRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collTagInstancesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addTagInstancesRelatedByCreatedBy()
	 */
	public function clearTagInstancesRelatedByCreatedBy()
	{
		$this->collTagInstancesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collTagInstancesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collTagInstancesRelatedByCreatedBy collection to an empty array (like clearcollTagInstancesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initTagInstancesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collTagInstancesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collTagInstancesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collTagInstancesRelatedByCreatedBy->setModel('TagInstance');
	}

	/**
	 * Gets an array of TagInstance objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array TagInstance[] List of TagInstance objects
	 * @throws     PropelException
	 */
	public function getTagInstancesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collTagInstancesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagInstancesRelatedByCreatedBy) {
				// return empty collection
				$this->initTagInstancesRelatedByCreatedBy();
			} else {
				$collTagInstancesRelatedByCreatedBy = TagInstanceQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collTagInstancesRelatedByCreatedBy;
				}
				$this->collTagInstancesRelatedByCreatedBy = $collTagInstancesRelatedByCreatedBy;
			}
		}
		return $this->collTagInstancesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related TagInstance objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related TagInstance objects.
	 * @throws     PropelException
	 */
	public function countTagInstancesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collTagInstancesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagInstancesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = TagInstanceQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collTagInstancesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a TagInstance object to this object
	 * through the TagInstance foreign key attribute.
	 *
	 * @param      TagInstance $l TagInstance
	 * @return     User The current object (for fluent API support)
	 */
	public function addTagInstanceRelatedByCreatedBy(TagInstance $l)
	{
		if ($this->collTagInstancesRelatedByCreatedBy === null) {
			$this->initTagInstancesRelatedByCreatedBy();
		}
		if (!$this->collTagInstancesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collTagInstancesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related TagInstancesRelatedByCreatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array TagInstance[] List of TagInstance objects
	 */
	public function getTagInstancesRelatedByCreatedByJoinTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = TagInstanceQuery::create(null, $criteria);
		$query->joinWith('Tag', $join_behavior);

		return $this->getTagInstancesRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collTagInstancesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addTagInstancesRelatedByUpdatedBy()
	 */
	public function clearTagInstancesRelatedByUpdatedBy()
	{
		$this->collTagInstancesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collTagInstancesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collTagInstancesRelatedByUpdatedBy collection to an empty array (like clearcollTagInstancesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initTagInstancesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collTagInstancesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collTagInstancesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collTagInstancesRelatedByUpdatedBy->setModel('TagInstance');
	}

	/**
	 * Gets an array of TagInstance objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array TagInstance[] List of TagInstance objects
	 * @throws     PropelException
	 */
	public function getTagInstancesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collTagInstancesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagInstancesRelatedByUpdatedBy) {
				// return empty collection
				$this->initTagInstancesRelatedByUpdatedBy();
			} else {
				$collTagInstancesRelatedByUpdatedBy = TagInstanceQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collTagInstancesRelatedByUpdatedBy;
				}
				$this->collTagInstancesRelatedByUpdatedBy = $collTagInstancesRelatedByUpdatedBy;
			}
		}
		return $this->collTagInstancesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related TagInstance objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related TagInstance objects.
	 * @throws     PropelException
	 */
	public function countTagInstancesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collTagInstancesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collTagInstancesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = TagInstanceQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collTagInstancesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a TagInstance object to this object
	 * through the TagInstance foreign key attribute.
	 *
	 * @param      TagInstance $l TagInstance
	 * @return     User The current object (for fluent API support)
	 */
	public function addTagInstanceRelatedByUpdatedBy(TagInstance $l)
	{
		if ($this->collTagInstancesRelatedByUpdatedBy === null) {
			$this->initTagInstancesRelatedByUpdatedBy();
		}
		if (!$this->collTagInstancesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collTagInstancesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this User is new, it will return
	 * an empty collection; or if this User has previously
	 * been saved, it will retrieve related TagInstancesRelatedByUpdatedBy from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in User.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array TagInstance[] List of TagInstance objects
	 */
	public function getTagInstancesRelatedByUpdatedByJoinTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = TagInstanceQuery::create(null, $criteria);
		$query->joinWith('Tag', $join_behavior);

		return $this->getTagInstancesRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collLinksRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLinksRelatedByCreatedBy()
	 */
	public function clearLinksRelatedByCreatedBy()
	{
		$this->collLinksRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLinksRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collLinksRelatedByCreatedBy collection to an empty array (like clearcollLinksRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLinksRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collLinksRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collLinksRelatedByCreatedBy = new PropelObjectCollection();
		$this->collLinksRelatedByCreatedBy->setModel('Link');
	}

	/**
	 * Gets an array of Link objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Link[] List of Link objects
	 * @throws     PropelException
	 */
	public function getLinksRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLinksRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinksRelatedByCreatedBy) {
				// return empty collection
				$this->initLinksRelatedByCreatedBy();
			} else {
				$collLinksRelatedByCreatedBy = LinkQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLinksRelatedByCreatedBy;
				}
				$this->collLinksRelatedByCreatedBy = $collLinksRelatedByCreatedBy;
			}
		}
		return $this->collLinksRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Link objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Link objects.
	 * @throws     PropelException
	 */
	public function countLinksRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLinksRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinksRelatedByCreatedBy) {
				return 0;
			} else {
				$query = LinkQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLinksRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Link object to this object
	 * through the Link foreign key attribute.
	 *
	 * @param      Link $l Link
	 * @return     User The current object (for fluent API support)
	 */
	public function addLinkRelatedByCreatedBy(Link $l)
	{
		if ($this->collLinksRelatedByCreatedBy === null) {
			$this->initLinksRelatedByCreatedBy();
		}
		if (!$this->collLinksRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLinksRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Link[] List of Link objects
	 */
	public function getLinksRelatedByCreatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LinkQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLinksRelatedByCreatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Link[] List of Link objects
	 */
	public function getLinksRelatedByCreatedByJoinLinkCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LinkQuery::create(null, $criteria);
		$query->joinWith('LinkCategory', $join_behavior);

		return $this->getLinksRelatedByCreatedBy($query, $con);
	}

	/**
	 * Clears out the collLinksRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLinksRelatedByUpdatedBy()
	 */
	public function clearLinksRelatedByUpdatedBy()
	{
		$this->collLinksRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLinksRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collLinksRelatedByUpdatedBy collection to an empty array (like clearcollLinksRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLinksRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collLinksRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collLinksRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collLinksRelatedByUpdatedBy->setModel('Link');
	}

	/**
	 * Gets an array of Link objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Link[] List of Link objects
	 * @throws     PropelException
	 */
	public function getLinksRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLinksRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinksRelatedByUpdatedBy) {
				// return empty collection
				$this->initLinksRelatedByUpdatedBy();
			} else {
				$collLinksRelatedByUpdatedBy = LinkQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLinksRelatedByUpdatedBy;
				}
				$this->collLinksRelatedByUpdatedBy = $collLinksRelatedByUpdatedBy;
			}
		}
		return $this->collLinksRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Link objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Link objects.
	 * @throws     PropelException
	 */
	public function countLinksRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLinksRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinksRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = LinkQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLinksRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Link object to this object
	 * through the Link foreign key attribute.
	 *
	 * @param      Link $l Link
	 * @return     User The current object (for fluent API support)
	 */
	public function addLinkRelatedByUpdatedBy(Link $l)
	{
		if ($this->collLinksRelatedByUpdatedBy === null) {
			$this->initLinksRelatedByUpdatedBy();
		}
		if (!$this->collLinksRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLinksRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Link[] List of Link objects
	 */
	public function getLinksRelatedByUpdatedByJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LinkQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getLinksRelatedByUpdatedBy($query, $con);
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
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Link[] List of Link objects
	 */
	public function getLinksRelatedByUpdatedByJoinLinkCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = LinkQuery::create(null, $criteria);
		$query->joinWith('LinkCategory', $join_behavior);

		return $this->getLinksRelatedByUpdatedBy($query, $con);
	}

	/**
	 * Clears out the collLinkCategorysRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLinkCategorysRelatedByCreatedBy()
	 */
	public function clearLinkCategorysRelatedByCreatedBy()
	{
		$this->collLinkCategorysRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLinkCategorysRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collLinkCategorysRelatedByCreatedBy collection to an empty array (like clearcollLinkCategorysRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLinkCategorysRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collLinkCategorysRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collLinkCategorysRelatedByCreatedBy = new PropelObjectCollection();
		$this->collLinkCategorysRelatedByCreatedBy->setModel('LinkCategory');
	}

	/**
	 * Gets an array of LinkCategory objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array LinkCategory[] List of LinkCategory objects
	 * @throws     PropelException
	 */
	public function getLinkCategorysRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLinkCategorysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinkCategorysRelatedByCreatedBy) {
				// return empty collection
				$this->initLinkCategorysRelatedByCreatedBy();
			} else {
				$collLinkCategorysRelatedByCreatedBy = LinkCategoryQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLinkCategorysRelatedByCreatedBy;
				}
				$this->collLinkCategorysRelatedByCreatedBy = $collLinkCategorysRelatedByCreatedBy;
			}
		}
		return $this->collLinkCategorysRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related LinkCategory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related LinkCategory objects.
	 * @throws     PropelException
	 */
	public function countLinkCategorysRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLinkCategorysRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinkCategorysRelatedByCreatedBy) {
				return 0;
			} else {
				$query = LinkCategoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLinkCategorysRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a LinkCategory object to this object
	 * through the LinkCategory foreign key attribute.
	 *
	 * @param      LinkCategory $l LinkCategory
	 * @return     User The current object (for fluent API support)
	 */
	public function addLinkCategoryRelatedByCreatedBy(LinkCategory $l)
	{
		if ($this->collLinkCategorysRelatedByCreatedBy === null) {
			$this->initLinkCategorysRelatedByCreatedBy();
		}
		if (!$this->collLinkCategorysRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLinkCategorysRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collLinkCategorysRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addLinkCategorysRelatedByUpdatedBy()
	 */
	public function clearLinkCategorysRelatedByUpdatedBy()
	{
		$this->collLinkCategorysRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collLinkCategorysRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collLinkCategorysRelatedByUpdatedBy collection to an empty array (like clearcollLinkCategorysRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initLinkCategorysRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collLinkCategorysRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collLinkCategorysRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collLinkCategorysRelatedByUpdatedBy->setModel('LinkCategory');
	}

	/**
	 * Gets an array of LinkCategory objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array LinkCategory[] List of LinkCategory objects
	 * @throws     PropelException
	 */
	public function getLinkCategorysRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collLinkCategorysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinkCategorysRelatedByUpdatedBy) {
				// return empty collection
				$this->initLinkCategorysRelatedByUpdatedBy();
			} else {
				$collLinkCategorysRelatedByUpdatedBy = LinkCategoryQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collLinkCategorysRelatedByUpdatedBy;
				}
				$this->collLinkCategorysRelatedByUpdatedBy = $collLinkCategorysRelatedByUpdatedBy;
			}
		}
		return $this->collLinkCategorysRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related LinkCategory objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related LinkCategory objects.
	 * @throws     PropelException
	 */
	public function countLinkCategorysRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collLinkCategorysRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collLinkCategorysRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = LinkCategoryQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collLinkCategorysRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a LinkCategory object to this object
	 * through the LinkCategory foreign key attribute.
	 *
	 * @param      LinkCategory $l LinkCategory
	 * @return     User The current object (for fluent API support)
	 */
	public function addLinkCategoryRelatedByUpdatedBy(LinkCategory $l)
	{
		if ($this->collLinkCategorysRelatedByUpdatedBy === null) {
			$this->initLinkCategorysRelatedByUpdatedBy();
		}
		if (!$this->collLinkCategorysRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collLinkCategorysRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collReferencesRelatedByCreatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addReferencesRelatedByCreatedBy()
	 */
	public function clearReferencesRelatedByCreatedBy()
	{
		$this->collReferencesRelatedByCreatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collReferencesRelatedByCreatedBy collection.
	 *
	 * By default this just sets the collReferencesRelatedByCreatedBy collection to an empty array (like clearcollReferencesRelatedByCreatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initReferencesRelatedByCreatedBy($overrideExisting = true)
	{
		if (null !== $this->collReferencesRelatedByCreatedBy && !$overrideExisting) {
			return;
		}
		$this->collReferencesRelatedByCreatedBy = new PropelObjectCollection();
		$this->collReferencesRelatedByCreatedBy->setModel('Reference');
	}

	/**
	 * Gets an array of Reference objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Reference[] List of Reference objects
	 * @throws     PropelException
	 */
	public function getReferencesRelatedByCreatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collReferencesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collReferencesRelatedByCreatedBy) {
				// return empty collection
				$this->initReferencesRelatedByCreatedBy();
			} else {
				$collReferencesRelatedByCreatedBy = ReferenceQuery::create(null, $criteria)
					->filterByUserRelatedByCreatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collReferencesRelatedByCreatedBy;
				}
				$this->collReferencesRelatedByCreatedBy = $collReferencesRelatedByCreatedBy;
			}
		}
		return $this->collReferencesRelatedByCreatedBy;
	}

	/**
	 * Returns the number of related Reference objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Reference objects.
	 * @throws     PropelException
	 */
	public function countReferencesRelatedByCreatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collReferencesRelatedByCreatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collReferencesRelatedByCreatedBy) {
				return 0;
			} else {
				$query = ReferenceQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByCreatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collReferencesRelatedByCreatedBy);
		}
	}

	/**
	 * Method called to associate a Reference object to this object
	 * through the Reference foreign key attribute.
	 *
	 * @param      Reference $l Reference
	 * @return     User The current object (for fluent API support)
	 */
	public function addReferenceRelatedByCreatedBy(Reference $l)
	{
		if ($this->collReferencesRelatedByCreatedBy === null) {
			$this->initReferencesRelatedByCreatedBy();
		}
		if (!$this->collReferencesRelatedByCreatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collReferencesRelatedByCreatedBy[]= $l;
			$l->setUserRelatedByCreatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears out the collReferencesRelatedByUpdatedBy collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addReferencesRelatedByUpdatedBy()
	 */
	public function clearReferencesRelatedByUpdatedBy()
	{
		$this->collReferencesRelatedByUpdatedBy = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collReferencesRelatedByUpdatedBy collection.
	 *
	 * By default this just sets the collReferencesRelatedByUpdatedBy collection to an empty array (like clearcollReferencesRelatedByUpdatedBy());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @param      boolean $overrideExisting If set to true, the method call initializes
	 *                                        the collection even if it is not empty
	 *
	 * @return     void
	 */
	public function initReferencesRelatedByUpdatedBy($overrideExisting = true)
	{
		if (null !== $this->collReferencesRelatedByUpdatedBy && !$overrideExisting) {
			return;
		}
		$this->collReferencesRelatedByUpdatedBy = new PropelObjectCollection();
		$this->collReferencesRelatedByUpdatedBy->setModel('Reference');
	}

	/**
	 * Gets an array of Reference objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this User is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Reference[] List of Reference objects
	 * @throws     PropelException
	 */
	public function getReferencesRelatedByUpdatedBy($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collReferencesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collReferencesRelatedByUpdatedBy) {
				// return empty collection
				$this->initReferencesRelatedByUpdatedBy();
			} else {
				$collReferencesRelatedByUpdatedBy = ReferenceQuery::create(null, $criteria)
					->filterByUserRelatedByUpdatedBy($this)
					->find($con);
				if (null !== $criteria) {
					return $collReferencesRelatedByUpdatedBy;
				}
				$this->collReferencesRelatedByUpdatedBy = $collReferencesRelatedByUpdatedBy;
			}
		}
		return $this->collReferencesRelatedByUpdatedBy;
	}

	/**
	 * Returns the number of related Reference objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related Reference objects.
	 * @throws     PropelException
	 */
	public function countReferencesRelatedByUpdatedBy(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collReferencesRelatedByUpdatedBy || null !== $criteria) {
			if ($this->isNew() && null === $this->collReferencesRelatedByUpdatedBy) {
				return 0;
			} else {
				$query = ReferenceQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByUserRelatedByUpdatedBy($this)
					->count($con);
			}
		} else {
			return count($this->collReferencesRelatedByUpdatedBy);
		}
	}

	/**
	 * Method called to associate a Reference object to this object
	 * through the Reference foreign key attribute.
	 *
	 * @param      Reference $l Reference
	 * @return     User The current object (for fluent API support)
	 */
	public function addReferenceRelatedByUpdatedBy(Reference $l)
	{
		if ($this->collReferencesRelatedByUpdatedBy === null) {
			$this->initReferencesRelatedByUpdatedBy();
		}
		if (!$this->collReferencesRelatedByUpdatedBy->contains($l)) { // only add it if the **same** object is not already associated
			$this->collReferencesRelatedByUpdatedBy[]= $l;
			$l->setUserRelatedByUpdatedBy($this);
		}

		return $this;
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->username = null;
		$this->password = null;
		$this->digest_ha1 = null;
		$this->first_name = null;
		$this->last_name = null;
		$this->email = null;
		$this->language_id = null;
		$this->is_admin = null;
		$this->is_backend_login_enabled = null;
		$this->is_admin_login_enabled = null;
		$this->is_inactive = null;
		$this->password_recover_hint = null;
		$this->backend_settings = null;
		$this->created_at = null;
		$this->updated_at = null;
		$this->created_by = null;
		$this->updated_by = null;
		$this->alreadyInSave = false;
		$this->alreadyInValidation = false;
		$this->clearAllReferences();
		$this->applyDefaultValues();
		$this->resetModified();
		$this->setNew(true);
		$this->setDeleted(false);
	}

	/**
	 * Resets all references to other model objects or collections of model objects.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect
	 * objects with circular references (even in PHP 5.3). This is currently necessary
	 * when using Propel in certain daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all referrer objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collUserGroupsRelatedByUserId) {
				foreach ($this->collUserGroupsRelatedByUserId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserRolesRelatedByUserId) {
				foreach ($this->collUserRolesRelatedByUserId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentsRelatedByOwnerId) {
				foreach ($this->collDocumentsRelatedByOwnerId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLinksRelatedByOwnerId) {
				foreach ($this->collLinksRelatedByOwnerId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPagesRelatedByCreatedBy) {
				foreach ($this->collPagesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPagesRelatedByUpdatedBy) {
				foreach ($this->collPagesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPagePropertysRelatedByCreatedBy) {
				foreach ($this->collPagePropertysRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPagePropertysRelatedByUpdatedBy) {
				foreach ($this->collPagePropertysRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPageStringsRelatedByCreatedBy) {
				foreach ($this->collPageStringsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPageStringsRelatedByUpdatedBy) {
				foreach ($this->collPageStringsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collContentObjectsRelatedByCreatedBy) {
				foreach ($this->collContentObjectsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collContentObjectsRelatedByUpdatedBy) {
				foreach ($this->collContentObjectsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLanguageObjectsRelatedByCreatedBy) {
				foreach ($this->collLanguageObjectsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLanguageObjectsRelatedByUpdatedBy) {
				foreach ($this->collLanguageObjectsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLanguageObjectHistorysRelatedByCreatedBy) {
				foreach ($this->collLanguageObjectHistorysRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLanguageObjectHistorysRelatedByUpdatedBy) {
				foreach ($this->collLanguageObjectHistorysRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLanguagesRelatedByCreatedBy) {
				foreach ($this->collLanguagesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLanguagesRelatedByUpdatedBy) {
				foreach ($this->collLanguagesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collStringsRelatedByCreatedBy) {
				foreach ($this->collStringsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collStringsRelatedByUpdatedBy) {
				foreach ($this->collStringsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserGroupsRelatedByCreatedBy) {
				foreach ($this->collUserGroupsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserGroupsRelatedByUpdatedBy) {
				foreach ($this->collUserGroupsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGroupsRelatedByCreatedBy) {
				foreach ($this->collGroupsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGroupsRelatedByUpdatedBy) {
				foreach ($this->collGroupsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGroupRolesRelatedByCreatedBy) {
				foreach ($this->collGroupRolesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collGroupRolesRelatedByUpdatedBy) {
				foreach ($this->collGroupRolesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRolesRelatedByCreatedBy) {
				foreach ($this->collRolesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRolesRelatedByUpdatedBy) {
				foreach ($this->collRolesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserRolesRelatedByCreatedBy) {
				foreach ($this->collUserRolesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collUserRolesRelatedByUpdatedBy) {
				foreach ($this->collUserRolesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRightsRelatedByCreatedBy) {
				foreach ($this->collRightsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRightsRelatedByUpdatedBy) {
				foreach ($this->collRightsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentsRelatedByCreatedBy) {
				foreach ($this->collDocumentsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentsRelatedByUpdatedBy) {
				foreach ($this->collDocumentsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentTypesRelatedByCreatedBy) {
				foreach ($this->collDocumentTypesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentTypesRelatedByUpdatedBy) {
				foreach ($this->collDocumentTypesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentCategorysRelatedByCreatedBy) {
				foreach ($this->collDocumentCategorysRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collDocumentCategorysRelatedByUpdatedBy) {
				foreach ($this->collDocumentCategorysRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collTagsRelatedByCreatedBy) {
				foreach ($this->collTagsRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collTagsRelatedByUpdatedBy) {
				foreach ($this->collTagsRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collTagInstancesRelatedByCreatedBy) {
				foreach ($this->collTagInstancesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collTagInstancesRelatedByUpdatedBy) {
				foreach ($this->collTagInstancesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLinksRelatedByCreatedBy) {
				foreach ($this->collLinksRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLinksRelatedByUpdatedBy) {
				foreach ($this->collLinksRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLinkCategorysRelatedByCreatedBy) {
				foreach ($this->collLinkCategorysRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collLinkCategorysRelatedByUpdatedBy) {
				foreach ($this->collLinkCategorysRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collReferencesRelatedByCreatedBy) {
				foreach ($this->collReferencesRelatedByCreatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collReferencesRelatedByUpdatedBy) {
				foreach ($this->collReferencesRelatedByUpdatedBy as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		if ($this->collUserGroupsRelatedByUserId instanceof PropelCollection) {
			$this->collUserGroupsRelatedByUserId->clearIterator();
		}
		$this->collUserGroupsRelatedByUserId = null;
		if ($this->collUserRolesRelatedByUserId instanceof PropelCollection) {
			$this->collUserRolesRelatedByUserId->clearIterator();
		}
		$this->collUserRolesRelatedByUserId = null;
		if ($this->collDocumentsRelatedByOwnerId instanceof PropelCollection) {
			$this->collDocumentsRelatedByOwnerId->clearIterator();
		}
		$this->collDocumentsRelatedByOwnerId = null;
		if ($this->collLinksRelatedByOwnerId instanceof PropelCollection) {
			$this->collLinksRelatedByOwnerId->clearIterator();
		}
		$this->collLinksRelatedByOwnerId = null;
		if ($this->collPagesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collPagesRelatedByCreatedBy->clearIterator();
		}
		$this->collPagesRelatedByCreatedBy = null;
		if ($this->collPagesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collPagesRelatedByUpdatedBy->clearIterator();
		}
		$this->collPagesRelatedByUpdatedBy = null;
		if ($this->collPagePropertysRelatedByCreatedBy instanceof PropelCollection) {
			$this->collPagePropertysRelatedByCreatedBy->clearIterator();
		}
		$this->collPagePropertysRelatedByCreatedBy = null;
		if ($this->collPagePropertysRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collPagePropertysRelatedByUpdatedBy->clearIterator();
		}
		$this->collPagePropertysRelatedByUpdatedBy = null;
		if ($this->collPageStringsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collPageStringsRelatedByCreatedBy->clearIterator();
		}
		$this->collPageStringsRelatedByCreatedBy = null;
		if ($this->collPageStringsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collPageStringsRelatedByUpdatedBy->clearIterator();
		}
		$this->collPageStringsRelatedByUpdatedBy = null;
		if ($this->collContentObjectsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collContentObjectsRelatedByCreatedBy->clearIterator();
		}
		$this->collContentObjectsRelatedByCreatedBy = null;
		if ($this->collContentObjectsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collContentObjectsRelatedByUpdatedBy->clearIterator();
		}
		$this->collContentObjectsRelatedByUpdatedBy = null;
		if ($this->collLanguageObjectsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collLanguageObjectsRelatedByCreatedBy->clearIterator();
		}
		$this->collLanguageObjectsRelatedByCreatedBy = null;
		if ($this->collLanguageObjectsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collLanguageObjectsRelatedByUpdatedBy->clearIterator();
		}
		$this->collLanguageObjectsRelatedByUpdatedBy = null;
		if ($this->collLanguageObjectHistorysRelatedByCreatedBy instanceof PropelCollection) {
			$this->collLanguageObjectHistorysRelatedByCreatedBy->clearIterator();
		}
		$this->collLanguageObjectHistorysRelatedByCreatedBy = null;
		if ($this->collLanguageObjectHistorysRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collLanguageObjectHistorysRelatedByUpdatedBy->clearIterator();
		}
		$this->collLanguageObjectHistorysRelatedByUpdatedBy = null;
		if ($this->collLanguagesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collLanguagesRelatedByCreatedBy->clearIterator();
		}
		$this->collLanguagesRelatedByCreatedBy = null;
		if ($this->collLanguagesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collLanguagesRelatedByUpdatedBy->clearIterator();
		}
		$this->collLanguagesRelatedByUpdatedBy = null;
		if ($this->collStringsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collStringsRelatedByCreatedBy->clearIterator();
		}
		$this->collStringsRelatedByCreatedBy = null;
		if ($this->collStringsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collStringsRelatedByUpdatedBy->clearIterator();
		}
		$this->collStringsRelatedByUpdatedBy = null;
		if ($this->collUserGroupsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collUserGroupsRelatedByCreatedBy->clearIterator();
		}
		$this->collUserGroupsRelatedByCreatedBy = null;
		if ($this->collUserGroupsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collUserGroupsRelatedByUpdatedBy->clearIterator();
		}
		$this->collUserGroupsRelatedByUpdatedBy = null;
		if ($this->collGroupsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collGroupsRelatedByCreatedBy->clearIterator();
		}
		$this->collGroupsRelatedByCreatedBy = null;
		if ($this->collGroupsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collGroupsRelatedByUpdatedBy->clearIterator();
		}
		$this->collGroupsRelatedByUpdatedBy = null;
		if ($this->collGroupRolesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collGroupRolesRelatedByCreatedBy->clearIterator();
		}
		$this->collGroupRolesRelatedByCreatedBy = null;
		if ($this->collGroupRolesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collGroupRolesRelatedByUpdatedBy->clearIterator();
		}
		$this->collGroupRolesRelatedByUpdatedBy = null;
		if ($this->collRolesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collRolesRelatedByCreatedBy->clearIterator();
		}
		$this->collRolesRelatedByCreatedBy = null;
		if ($this->collRolesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collRolesRelatedByUpdatedBy->clearIterator();
		}
		$this->collRolesRelatedByUpdatedBy = null;
		if ($this->collUserRolesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collUserRolesRelatedByCreatedBy->clearIterator();
		}
		$this->collUserRolesRelatedByCreatedBy = null;
		if ($this->collUserRolesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collUserRolesRelatedByUpdatedBy->clearIterator();
		}
		$this->collUserRolesRelatedByUpdatedBy = null;
		if ($this->collRightsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collRightsRelatedByCreatedBy->clearIterator();
		}
		$this->collRightsRelatedByCreatedBy = null;
		if ($this->collRightsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collRightsRelatedByUpdatedBy->clearIterator();
		}
		$this->collRightsRelatedByUpdatedBy = null;
		if ($this->collDocumentsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collDocumentsRelatedByCreatedBy->clearIterator();
		}
		$this->collDocumentsRelatedByCreatedBy = null;
		if ($this->collDocumentsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collDocumentsRelatedByUpdatedBy->clearIterator();
		}
		$this->collDocumentsRelatedByUpdatedBy = null;
		if ($this->collDocumentTypesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collDocumentTypesRelatedByCreatedBy->clearIterator();
		}
		$this->collDocumentTypesRelatedByCreatedBy = null;
		if ($this->collDocumentTypesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collDocumentTypesRelatedByUpdatedBy->clearIterator();
		}
		$this->collDocumentTypesRelatedByUpdatedBy = null;
		if ($this->collDocumentCategorysRelatedByCreatedBy instanceof PropelCollection) {
			$this->collDocumentCategorysRelatedByCreatedBy->clearIterator();
		}
		$this->collDocumentCategorysRelatedByCreatedBy = null;
		if ($this->collDocumentCategorysRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collDocumentCategorysRelatedByUpdatedBy->clearIterator();
		}
		$this->collDocumentCategorysRelatedByUpdatedBy = null;
		if ($this->collTagsRelatedByCreatedBy instanceof PropelCollection) {
			$this->collTagsRelatedByCreatedBy->clearIterator();
		}
		$this->collTagsRelatedByCreatedBy = null;
		if ($this->collTagsRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collTagsRelatedByUpdatedBy->clearIterator();
		}
		$this->collTagsRelatedByUpdatedBy = null;
		if ($this->collTagInstancesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collTagInstancesRelatedByCreatedBy->clearIterator();
		}
		$this->collTagInstancesRelatedByCreatedBy = null;
		if ($this->collTagInstancesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collTagInstancesRelatedByUpdatedBy->clearIterator();
		}
		$this->collTagInstancesRelatedByUpdatedBy = null;
		if ($this->collLinksRelatedByCreatedBy instanceof PropelCollection) {
			$this->collLinksRelatedByCreatedBy->clearIterator();
		}
		$this->collLinksRelatedByCreatedBy = null;
		if ($this->collLinksRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collLinksRelatedByUpdatedBy->clearIterator();
		}
		$this->collLinksRelatedByUpdatedBy = null;
		if ($this->collLinkCategorysRelatedByCreatedBy instanceof PropelCollection) {
			$this->collLinkCategorysRelatedByCreatedBy->clearIterator();
		}
		$this->collLinkCategorysRelatedByCreatedBy = null;
		if ($this->collLinkCategorysRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collLinkCategorysRelatedByUpdatedBy->clearIterator();
		}
		$this->collLinkCategorysRelatedByUpdatedBy = null;
		if ($this->collReferencesRelatedByCreatedBy instanceof PropelCollection) {
			$this->collReferencesRelatedByCreatedBy->clearIterator();
		}
		$this->collReferencesRelatedByCreatedBy = null;
		if ($this->collReferencesRelatedByUpdatedBy instanceof PropelCollection) {
			$this->collReferencesRelatedByUpdatedBy->clearIterator();
		}
		$this->collReferencesRelatedByUpdatedBy = null;
		$this->aLanguageRelatedByLanguageId = null;
	}

	/**
	 * Return the string representation of this object
	 *
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->exportTo(UserPeer::DEFAULT_STRING_FORMAT);
	}

	// taggable behavior
	
	/**
	 * @return A list of TagInstances (not Tags) which reference this User
	 */
	public function getTags()
	{
		return TagPeer::tagInstancesForObject($this);
	}
	// extended_timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     User The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = UserPeer::UPDATED_AT;
		return $this;
	}
	
	/**
	 * @return created_at as int (timestamp)
	 */
	public function getCreatedAtTimestamp()
	{
		return $this->getCreatedAt('U');
	}
	
	/**
	 * @return created_at formatted to the current locale
	 */
	public function getCreatedAtFormatted($sLanguageId = null, $sFormatString = 'x')
	{
		if($this->created_at === null) {
			return null;
		}
		return LocaleUtil::localizeDate($this->created_at, $sLanguageId, $sFormatString);
	}
	
	/**
	 * @return updated_at as int (timestamp)
	 */
	public function getUpdatedAtTimestamp()
	{
		return $this->getUpdatedAt('U');
	}
	
	/**
	 * @return updated_at formatted to the current locale
	 */
	public function getUpdatedAtFormatted($sLanguageId = null, $sFormatString = 'x')
	{
		if($this->updated_at === null) {
			return null;
		}
		return LocaleUtil::localizeDate($this->updated_at, $sLanguageId, $sFormatString);
	}

	// attributable behavior
	
	/**
	 * Mark the current object so that the updated user doesn't get updated during next save
	 *
	 * @return     User The current object (for fluent API support)
	 */
	public function keepUpdateUserUnchanged()
	{
		$this->modifiedColumns[] = UserPeer::UPDATED_BY;
		return $this;
	}
	
		/**
		 * Get the associated User object
		 *
		 * @param     PropelPDO $con Optional Connection object.
		 * @return     User The associated User object.
		 * @throws     PropelException
		 */
		public function getUserRelatedByCreatedBy(PropelPDO $con = null)
		{
			return UserQuery::create()->findPk($this->created_by);
		}
		/**
		 * Get the associated User object
		 *
		 * @param      PropelPDO $con Optional Connection object.
		 * @return     User The associated User object.
		 * @throws     PropelException
		 */
		public function getUserRelatedByUpdatedBy(PropelPDO $con = null)
		{
			return UserQuery::create()->findPk($this->updated_by);
		}

} // BaseUser
