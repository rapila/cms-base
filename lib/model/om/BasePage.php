<?php

/**
 * Base class that represents a row from the 'pages' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BasePage extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
  const PEER = 'PagePeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PagePeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the name field.
	 * @var        string
	 */
	protected $name;

	/**
	 * The value for the page_type field.
	 * @var        string
	 */
	protected $page_type;

	/**
	 * The value for the template_name field.
	 * @var        string
	 */
	protected $template_name;

	/**
	 * The value for the is_inactive field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $is_inactive;

	/**
	 * The value for the is_folder field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_folder;

	/**
	 * The value for the is_hidden field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_hidden;

	/**
	 * The value for the is_protected field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_protected;

	/**
	 * The value for the tree_left field.
	 * @var        int
	 */
	protected $tree_left;

	/**
	 * The value for the tree_right field.
	 * @var        int
	 */
	protected $tree_right;

	/**
	 * The value for the tree_level field.
	 * @var        int
	 */
	protected $tree_level;

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
	 * @var        User
	 */
	protected $aUserRelatedByCreatedBy;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByUpdatedBy;

	/**
	 * @var        array PageProperty[] Collection to store aggregation of PageProperty objects.
	 */
	protected $collPagePropertys;

	/**
	 * @var        array PageString[] Collection to store aggregation of PageString objects.
	 */
	protected $collPageStrings;

	/**
	 * @var        array ContentObject[] Collection to store aggregation of ContentObject objects.
	 */
	protected $collContentObjects;

	/**
	 * @var        array Right[] Collection to store aggregation of Right objects.
	 */
	protected $collRights;

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

	// nested_set behavior
	
	/**
	 * Queries to be executed in the save transaction
	 * @var        array
	 */
	protected $nestedSetQueries = array();
	
	/**
	 * Internal cache for children nodes
	 * @var        null|PropelObjectCollection
	 */
	protected $collNestedSetChildren = null;
	
	/**
	 * Internal cache for parent node
	 * @var        null|Page
	 */
	protected $aNestedSetParent = null;
	

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_inactive = true;
		$this->is_folder = false;
		$this->is_hidden = false;
		$this->is_protected = false;
	}

	/**
	 * Initializes internal state of BasePage object.
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
	 * Get the [name] column value.
	 * 
	 * @return     string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Get the [page_type] column value.
	 * 
	 * @return     string
	 */
	public function getPageType()
	{
		return $this->page_type;
	}

	/**
	 * Get the [template_name] column value.
	 * 
	 * @return     string
	 */
	public function getTemplateName()
	{
		return $this->template_name;
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
	 * Get the [is_folder] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsFolder()
	{
		return $this->is_folder;
	}

	/**
	 * Get the [is_hidden] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsHidden()
	{
		return $this->is_hidden;
	}

	/**
	 * Get the [is_protected] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsProtected()
	{
		return $this->is_protected;
	}

	/**
	 * Get the [tree_left] column value.
	 * 
	 * @return     int
	 */
	public function getTreeLeft()
	{
		return $this->tree_left;
	}

	/**
	 * Get the [tree_right] column value.
	 * 
	 * @return     int
	 */
	public function getTreeRight()
	{
		return $this->tree_right;
	}

	/**
	 * Get the [tree_level] column value.
	 * 
	 * @return     int
	 */
	public function getTreeLevel()
	{
		return $this->tree_level;
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
	 * @return     Page The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = PagePeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = PagePeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [page_type] column.
	 * 
	 * @param      string $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setPageType($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->page_type !== $v) {
			$this->page_type = $v;
			$this->modifiedColumns[] = PagePeer::PAGE_TYPE;
		}

		return $this;
	} // setPageType()

	/**
	 * Set the value of [template_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setTemplateName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->template_name !== $v) {
			$this->template_name = $v;
			$this->modifiedColumns[] = PagePeer::TEMPLATE_NAME;
		}

		return $this;
	} // setTemplateName()

	/**
	 * Set the value of [is_inactive] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setIsInactive($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_inactive !== $v || $this->isNew()) {
			$this->is_inactive = $v;
			$this->modifiedColumns[] = PagePeer::IS_INACTIVE;
		}

		return $this;
	} // setIsInactive()

	/**
	 * Set the value of [is_folder] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setIsFolder($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_folder !== $v || $this->isNew()) {
			$this->is_folder = $v;
			$this->modifiedColumns[] = PagePeer::IS_FOLDER;
		}

		return $this;
	} // setIsFolder()

	/**
	 * Set the value of [is_hidden] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setIsHidden($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_hidden !== $v || $this->isNew()) {
			$this->is_hidden = $v;
			$this->modifiedColumns[] = PagePeer::IS_HIDDEN;
		}

		return $this;
	} // setIsHidden()

	/**
	 * Set the value of [is_protected] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setIsProtected($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_protected !== $v || $this->isNew()) {
			$this->is_protected = $v;
			$this->modifiedColumns[] = PagePeer::IS_PROTECTED;
		}

		return $this;
	} // setIsProtected()

	/**
	 * Set the value of [tree_left] column.
	 * 
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setTreeLeft($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tree_left !== $v) {
			$this->tree_left = $v;
			$this->modifiedColumns[] = PagePeer::TREE_LEFT;
		}

		return $this;
	} // setTreeLeft()

	/**
	 * Set the value of [tree_right] column.
	 * 
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setTreeRight($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tree_right !== $v) {
			$this->tree_right = $v;
			$this->modifiedColumns[] = PagePeer::TREE_RIGHT;
		}

		return $this;
	} // setTreeRight()

	/**
	 * Set the value of [tree_level] column.
	 * 
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setTreeLevel($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->tree_level !== $v) {
			$this->tree_level = $v;
			$this->modifiedColumns[] = PagePeer::TREE_LEVEL;
		}

		return $this;
	} // setTreeLevel()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Page The current object (for fluent API support)
	 */
	public function setCreatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->created_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PagePeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Page The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = PagePeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [created_by] column.
	 * 
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setCreatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = PagePeer::CREATED_BY;
		}

		if ($this->aUserRelatedByCreatedBy !== null && $this->aUserRelatedByCreatedBy->getId() !== $v) {
			$this->aUserRelatedByCreatedBy = null;
		}

		return $this;
	} // setCreatedBy()

	/**
	 * Set the value of [updated_by] column.
	 * 
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setUpdatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = PagePeer::UPDATED_BY;
		}

		if ($this->aUserRelatedByUpdatedBy !== null && $this->aUserRelatedByUpdatedBy->getId() !== $v) {
			$this->aUserRelatedByUpdatedBy = null;
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
			if ($this->is_inactive !== true) {
				return false;
			}

			if ($this->is_folder !== false) {
				return false;
			}

			if ($this->is_hidden !== false) {
				return false;
			}

			if ($this->is_protected !== false) {
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
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->page_type = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->template_name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->is_inactive = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->is_folder = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->is_hidden = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
			$this->is_protected = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
			$this->tree_left = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->tree_right = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->tree_level = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->created_at = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
			$this->updated_at = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
			$this->created_by = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
			$this->updated_by = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 15; // 15 = PagePeer::NUM_COLUMNS - PagePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Page object", $e);
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

		if ($this->aUserRelatedByCreatedBy !== null && $this->created_by !== $this->aUserRelatedByCreatedBy->getId()) {
			$this->aUserRelatedByCreatedBy = null;
		}
		if ($this->aUserRelatedByUpdatedBy !== null && $this->updated_by !== $this->aUserRelatedByUpdatedBy->getId()) {
			$this->aUserRelatedByUpdatedBy = null;
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
			$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PagePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aUserRelatedByCreatedBy = null;
			$this->aUserRelatedByUpdatedBy = null;
			$this->collPagePropertys = null;

			$this->collPageStrings = null;

			$this->collContentObjects = null;

			$this->collRights = null;

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
			$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// nested_set behavior
			if ($this->isRoot()) {
				throw new PropelException('Deletion of a root node is disabled for nested sets. Use PagePeer::deleteTree() instead to delete an entire tree');
			}
			$this->deleteDescendants($con);

			// referenceable behavior
			if(ReferencePeer::hasReference($this)) {
				throw new PropelException("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
			}
			if ($ret) {
				PageQuery::create()
					->filterByPrimaryKey($this->getPrimaryKey())
					->delete($con);
				$this->postDelete($con);
				// nested_set behavior
				// fill up the room that was used by the node
				PagePeer::shiftRLValues(-2, $this->getRightValue() + 1, null, $con);

				// taggable behavior
				TagPeer::deleteTagsForObject($this);
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
			$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// nested_set behavior
			$this->processNestedSetQueries($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// extended_timestampable behavior
				if (!$this->isColumnModified(PagePeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(PagePeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if (!$this->isColumnModified(PagePeer::CREATED_BY)) {
						$this->setCreatedBy(Session::getSession()->getUser()->getId());
					}
					if (!$this->isColumnModified(PagePeer::UPDATED_BY)) {
						$this->setUpdatedBy(Session::getSession()->getUser()->getId());
					}
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
				// extended_timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(PagePeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if ($this->isModified() && !$this->isColumnModified(PagePeer::UPDATED_BY)) {
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
				PagePeer::addInstanceToPool($this);
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

			if ($this->aUserRelatedByCreatedBy !== null) {
				if ($this->aUserRelatedByCreatedBy->isModified() || $this->aUserRelatedByCreatedBy->isNew()) {
					$affectedRows += $this->aUserRelatedByCreatedBy->save($con);
				}
				$this->setUserRelatedByCreatedBy($this->aUserRelatedByCreatedBy);
			}

			if ($this->aUserRelatedByUpdatedBy !== null) {
				if ($this->aUserRelatedByUpdatedBy->isModified() || $this->aUserRelatedByUpdatedBy->isNew()) {
					$affectedRows += $this->aUserRelatedByUpdatedBy->save($con);
				}
				$this->setUserRelatedByUpdatedBy($this->aUserRelatedByUpdatedBy);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = PagePeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					if ($criteria->keyContainsValue(PagePeer::ID) ) {
						throw new PropelException('Cannot insert a value for auto-increment primary key ('.PagePeer::ID.')');
					}

					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setId($pk);  //[IMV] update autoincrement primary key
					$this->setNew(false);
				} else {
					$affectedRows += PagePeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPagePropertys !== null) {
				foreach ($this->collPagePropertys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPageStrings !== null) {
				foreach ($this->collPageStrings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collContentObjects !== null) {
				foreach ($this->collContentObjects as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRights !== null) {
				foreach ($this->collRights as $referrerFK) {
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


			if (($retval = PagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPagePropertys !== null) {
					foreach ($this->collPagePropertys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPageStrings !== null) {
					foreach ($this->collPageStrings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collContentObjects !== null) {
					foreach ($this->collContentObjects as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRights !== null) {
					foreach ($this->collRights as $referrerFK) {
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
		$pos = PagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 2:
				return $this->getPageType();
				break;
			case 3:
				return $this->getTemplateName();
				break;
			case 4:
				return $this->getIsInactive();
				break;
			case 5:
				return $this->getIsFolder();
				break;
			case 6:
				return $this->getIsHidden();
				break;
			case 7:
				return $this->getIsProtected();
				break;
			case 8:
				return $this->getTreeLeft();
				break;
			case 9:
				return $this->getTreeRight();
				break;
			case 10:
				return $this->getTreeLevel();
				break;
			case 11:
				return $this->getCreatedAt();
				break;
			case 12:
				return $this->getUpdatedAt();
				break;
			case 13:
				return $this->getCreatedBy();
				break;
			case 14:
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
	 * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
	 *
	 * @return    array an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $includeForeignObjects = false)
	{
		$keys = PagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getPageType(),
			$keys[3] => $this->getTemplateName(),
			$keys[4] => $this->getIsInactive(),
			$keys[5] => $this->getIsFolder(),
			$keys[6] => $this->getIsHidden(),
			$keys[7] => $this->getIsProtected(),
			$keys[8] => $this->getTreeLeft(),
			$keys[9] => $this->getTreeRight(),
			$keys[10] => $this->getTreeLevel(),
			$keys[11] => $this->getCreatedAt(),
			$keys[12] => $this->getUpdatedAt(),
			$keys[13] => $this->getCreatedBy(),
			$keys[14] => $this->getUpdatedBy(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aUserRelatedByCreatedBy) {
				$result['UserRelatedByCreatedBy'] = $this->aUserRelatedByCreatedBy->toArray($keyType, $includeLazyLoadColumns, true);
			}
			if (null !== $this->aUserRelatedByUpdatedBy) {
				$result['UserRelatedByUpdatedBy'] = $this->aUserRelatedByUpdatedBy->toArray($keyType, $includeLazyLoadColumns, true);
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
		$pos = PagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setName($value);
				break;
			case 2:
				$this->setPageType($value);
				break;
			case 3:
				$this->setTemplateName($value);
				break;
			case 4:
				$this->setIsInactive($value);
				break;
			case 5:
				$this->setIsFolder($value);
				break;
			case 6:
				$this->setIsHidden($value);
				break;
			case 7:
				$this->setIsProtected($value);
				break;
			case 8:
				$this->setTreeLeft($value);
				break;
			case 9:
				$this->setTreeRight($value);
				break;
			case 10:
				$this->setTreeLevel($value);
				break;
			case 11:
				$this->setCreatedAt($value);
				break;
			case 12:
				$this->setUpdatedAt($value);
				break;
			case 13:
				$this->setCreatedBy($value);
				break;
			case 14:
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
		$keys = PagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPageType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTemplateName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsInactive($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setIsFolder($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsHidden($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsProtected($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTreeLeft($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTreeRight($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setTreeLevel($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCreatedAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedBy($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUpdatedBy($arr[$keys[14]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PagePeer::DATABASE_NAME);

		if ($this->isColumnModified(PagePeer::ID)) $criteria->add(PagePeer::ID, $this->id);
		if ($this->isColumnModified(PagePeer::NAME)) $criteria->add(PagePeer::NAME, $this->name);
		if ($this->isColumnModified(PagePeer::PAGE_TYPE)) $criteria->add(PagePeer::PAGE_TYPE, $this->page_type);
		if ($this->isColumnModified(PagePeer::TEMPLATE_NAME)) $criteria->add(PagePeer::TEMPLATE_NAME, $this->template_name);
		if ($this->isColumnModified(PagePeer::IS_INACTIVE)) $criteria->add(PagePeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(PagePeer::IS_FOLDER)) $criteria->add(PagePeer::IS_FOLDER, $this->is_folder);
		if ($this->isColumnModified(PagePeer::IS_HIDDEN)) $criteria->add(PagePeer::IS_HIDDEN, $this->is_hidden);
		if ($this->isColumnModified(PagePeer::IS_PROTECTED)) $criteria->add(PagePeer::IS_PROTECTED, $this->is_protected);
		if ($this->isColumnModified(PagePeer::TREE_LEFT)) $criteria->add(PagePeer::TREE_LEFT, $this->tree_left);
		if ($this->isColumnModified(PagePeer::TREE_RIGHT)) $criteria->add(PagePeer::TREE_RIGHT, $this->tree_right);
		if ($this->isColumnModified(PagePeer::TREE_LEVEL)) $criteria->add(PagePeer::TREE_LEVEL, $this->tree_level);
		if ($this->isColumnModified(PagePeer::CREATED_AT)) $criteria->add(PagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PagePeer::UPDATED_AT)) $criteria->add(PagePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PagePeer::CREATED_BY)) $criteria->add(PagePeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(PagePeer::UPDATED_BY)) $criteria->add(PagePeer::UPDATED_BY, $this->updated_by);

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
		$criteria = new Criteria(PagePeer::DATABASE_NAME);
		$criteria->add(PagePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Page (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{
		$copyObj->setName($this->name);
		$copyObj->setPageType($this->page_type);
		$copyObj->setTemplateName($this->template_name);
		$copyObj->setIsInactive($this->is_inactive);
		$copyObj->setIsFolder($this->is_folder);
		$copyObj->setIsHidden($this->is_hidden);
		$copyObj->setIsProtected($this->is_protected);
		$copyObj->setTreeLeft($this->tree_left);
		$copyObj->setTreeRight($this->tree_right);
		$copyObj->setTreeLevel($this->tree_level);
		$copyObj->setCreatedAt($this->created_at);
		$copyObj->setUpdatedAt($this->updated_at);
		$copyObj->setCreatedBy($this->created_by);
		$copyObj->setUpdatedBy($this->updated_by);

		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getPagePropertys() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPageProperty($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getPageStrings() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addPageString($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getContentObjects() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addContentObject($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getRights() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addRight($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


		$copyObj->setNew(true);
		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
	 * @return     Page Clone of current object.
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
	 * @return     PagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PagePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Page The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUserRelatedByCreatedBy(User $v = null)
	{
		if ($v === null) {
			$this->setCreatedBy(NULL);
		} else {
			$this->setCreatedBy($v->getId());
		}

		$this->aUserRelatedByCreatedBy = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addPageRelatedByCreatedBy($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByCreatedBy(PropelPDO $con = null)
	{
		if ($this->aUserRelatedByCreatedBy === null && ($this->created_by !== null)) {
			$this->aUserRelatedByCreatedBy = UserQuery::create()->findPk($this->created_by);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUserRelatedByCreatedBy->addPagesRelatedByCreatedBy($this);
			 */
		}
		return $this->aUserRelatedByCreatedBy;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Page The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUserRelatedByUpdatedBy(User $v = null)
	{
		if ($v === null) {
			$this->setUpdatedBy(NULL);
		} else {
			$this->setUpdatedBy($v->getId());
		}

		$this->aUserRelatedByUpdatedBy = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addPageRelatedByUpdatedBy($this);
		}

		return $this;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByUpdatedBy(PropelPDO $con = null)
	{
		if ($this->aUserRelatedByUpdatedBy === null && ($this->updated_by !== null)) {
			$this->aUserRelatedByUpdatedBy = UserQuery::create()->findPk($this->updated_by);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aUserRelatedByUpdatedBy->addPagesRelatedByUpdatedBy($this);
			 */
		}
		return $this->aUserRelatedByUpdatedBy;
	}

	/**
	 * Clears out the collPagePropertys collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPagePropertys()
	 */
	public function clearPagePropertys()
	{
		$this->collPagePropertys = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPagePropertys collection.
	 *
	 * By default this just sets the collPagePropertys collection to an empty array (like clearcollPagePropertys());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPagePropertys()
	{
		$this->collPagePropertys = new PropelObjectCollection();
		$this->collPagePropertys->setModel('PageProperty');
	}

	/**
	 * Gets an array of PageProperty objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Page is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 * @throws     PropelException
	 */
	public function getPagePropertys($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPagePropertys || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagePropertys) {
				// return empty collection
				$this->initPagePropertys();
			} else {
				$collPagePropertys = PagePropertyQuery::create(null, $criteria)
					->filterByPage($this)
					->find($con);
				if (null !== $criteria) {
					return $collPagePropertys;
				}
				$this->collPagePropertys = $collPagePropertys;
			}
		}
		return $this->collPagePropertys;
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
	public function countPagePropertys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPagePropertys || null !== $criteria) {
			if ($this->isNew() && null === $this->collPagePropertys) {
				return 0;
			} else {
				$query = PagePropertyQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByPage($this)
					->count($con);
			}
		} else {
			return count($this->collPagePropertys);
		}
	}

	/**
	 * Method called to associate a PageProperty object to this object
	 * through the PageProperty foreign key attribute.
	 *
	 * @param      PageProperty $l PageProperty
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPageProperty(PageProperty $l)
	{
		if ($this->collPagePropertys === null) {
			$this->initPagePropertys();
		}
		if (!$this->collPagePropertys->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPagePropertys[]= $l;
			$l->setPage($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PagePropertys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 */
	public function getPagePropertysJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PagePropertyQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByCreatedBy', $join_behavior);

		return $this->getPagePropertys($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PagePropertys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageProperty[] List of PageProperty objects
	 */
	public function getPagePropertysJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PagePropertyQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

		return $this->getPagePropertys($query, $con);
	}

	/**
	 * Clears out the collPageStrings collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addPageStrings()
	 */
	public function clearPageStrings()
	{
		$this->collPageStrings = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collPageStrings collection.
	 *
	 * By default this just sets the collPageStrings collection to an empty array (like clearcollPageStrings());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initPageStrings()
	{
		$this->collPageStrings = new PropelObjectCollection();
		$this->collPageStrings->setModel('PageString');
	}

	/**
	 * Gets an array of PageString objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Page is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 * @throws     PropelException
	 */
	public function getPageStrings($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collPageStrings || null !== $criteria) {
			if ($this->isNew() && null === $this->collPageStrings) {
				// return empty collection
				$this->initPageStrings();
			} else {
				$collPageStrings = PageStringQuery::create(null, $criteria)
					->filterByPage($this)
					->find($con);
				if (null !== $criteria) {
					return $collPageStrings;
				}
				$this->collPageStrings = $collPageStrings;
			}
		}
		return $this->collPageStrings;
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
	public function countPageStrings(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collPageStrings || null !== $criteria) {
			if ($this->isNew() && null === $this->collPageStrings) {
				return 0;
			} else {
				$query = PageStringQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByPage($this)
					->count($con);
			}
		} else {
			return count($this->collPageStrings);
		}
	}

	/**
	 * Method called to associate a PageString object to this object
	 * through the PageString foreign key attribute.
	 *
	 * @param      PageString $l PageString
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPageString(PageString $l)
	{
		if ($this->collPageStrings === null) {
			$this->initPageStrings();
		}
		if (!$this->collPageStrings->contains($l)) { // only add it if the **same** object is not already associated
			$this->collPageStrings[]= $l;
			$l->setPage($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PageStrings from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('Language', $join_behavior);

		return $this->getPageStrings($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PageStrings from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByCreatedBy', $join_behavior);

		return $this->getPageStrings($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PageStrings from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array PageString[] List of PageString objects
	 */
	public function getPageStringsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = PageStringQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

		return $this->getPageStrings($query, $con);
	}

	/**
	 * Clears out the collContentObjects collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addContentObjects()
	 */
	public function clearContentObjects()
	{
		$this->collContentObjects = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collContentObjects collection.
	 *
	 * By default this just sets the collContentObjects collection to an empty array (like clearcollContentObjects());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initContentObjects()
	{
		$this->collContentObjects = new PropelObjectCollection();
		$this->collContentObjects->setModel('ContentObject');
	}

	/**
	 * Gets an array of ContentObject objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Page is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 * @throws     PropelException
	 */
	public function getContentObjects($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collContentObjects || null !== $criteria) {
			if ($this->isNew() && null === $this->collContentObjects) {
				// return empty collection
				$this->initContentObjects();
			} else {
				$collContentObjects = ContentObjectQuery::create(null, $criteria)
					->filterByPage($this)
					->find($con);
				if (null !== $criteria) {
					return $collContentObjects;
				}
				$this->collContentObjects = $collContentObjects;
			}
		}
		return $this->collContentObjects;
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
	public function countContentObjects(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collContentObjects || null !== $criteria) {
			if ($this->isNew() && null === $this->collContentObjects) {
				return 0;
			} else {
				$query = ContentObjectQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByPage($this)
					->count($con);
			}
		} else {
			return count($this->collContentObjects);
		}
	}

	/**
	 * Method called to associate a ContentObject object to this object
	 * through the ContentObject foreign key attribute.
	 *
	 * @param      ContentObject $l ContentObject
	 * @return     void
	 * @throws     PropelException
	 */
	public function addContentObject(ContentObject $l)
	{
		if ($this->collContentObjects === null) {
			$this->initContentObjects();
		}
		if (!$this->collContentObjects->contains($l)) { // only add it if the **same** object is not already associated
			$this->collContentObjects[]= $l;
			$l->setPage($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related ContentObjects from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 */
	public function getContentObjectsJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = ContentObjectQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByCreatedBy', $join_behavior);

		return $this->getContentObjects($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related ContentObjects from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array ContentObject[] List of ContentObject objects
	 */
	public function getContentObjectsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = ContentObjectQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

		return $this->getContentObjects($query, $con);
	}

	/**
	 * Clears out the collRights collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addRights()
	 */
	public function clearRights()
	{
		$this->collRights = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collRights collection.
	 *
	 * By default this just sets the collRights collection to an empty array (like clearcollRights());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initRights()
	{
		$this->collRights = new PropelObjectCollection();
		$this->collRights->setModel('Right');
	}

	/**
	 * Gets an array of Right objects which contain a foreign key that references this object.
	 *
	 * If the $criteria is not null, it is used to always fetch the results from the database.
	 * Otherwise the results are fetched from the database the first time, then cached.
	 * Next time the same method is called without $criteria, the cached collection is returned.
	 * If this Page is new, it will return
	 * an empty collection or the current collection; the criteria is ignored on a new object.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @return     PropelCollection|array Right[] List of Right objects
	 * @throws     PropelException
	 */
	public function getRights($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collRights || null !== $criteria) {
			if ($this->isNew() && null === $this->collRights) {
				// return empty collection
				$this->initRights();
			} else {
				$collRights = RightQuery::create(null, $criteria)
					->filterByPage($this)
					->find($con);
				if (null !== $criteria) {
					return $collRights;
				}
				$this->collRights = $collRights;
			}
		}
		return $this->collRights;
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
	public function countRights(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if(null === $this->collRights || null !== $criteria) {
			if ($this->isNew() && null === $this->collRights) {
				return 0;
			} else {
				$query = RightQuery::create(null, $criteria);
				if($distinct) {
					$query->distinct();
				}
				return $query
					->filterByPage($this)
					->count($con);
			}
		} else {
			return count($this->collRights);
		}
	}

	/**
	 * Method called to associate a Right object to this object
	 * through the Right foreign key attribute.
	 *
	 * @param      Right $l Right
	 * @return     void
	 * @throws     PropelException
	 */
	public function addRight(Right $l)
	{
		if ($this->collRights === null) {
			$this->initRights();
		}
		if (!$this->collRights->contains($l)) { // only add it if the **same** object is not already associated
			$this->collRights[]= $l;
			$l->setPage($this);
		}
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related Rights from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsJoinGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('Group', $join_behavior);

		return $this->getRights($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related Rights from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByCreatedBy', $join_behavior);

		return $this->getRights($query, $con);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related Rights from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 *
	 * @param      Criteria $criteria optional Criteria object to narrow the query
	 * @param      PropelPDO $con optional connection object
	 * @param      string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
	 * @return     PropelCollection|array Right[] List of Right objects
	 */
	public function getRightsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
	{
		$query = RightQuery::create(null, $criteria);
		$query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

		return $this->getRights($query, $con);
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->name = null;
		$this->page_type = null;
		$this->template_name = null;
		$this->is_inactive = null;
		$this->is_folder = null;
		$this->is_hidden = null;
		$this->is_protected = null;
		$this->tree_left = null;
		$this->tree_right = null;
		$this->tree_level = null;
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
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
			if ($this->collPagePropertys) {
				foreach ((array) $this->collPagePropertys as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collPageStrings) {
				foreach ((array) $this->collPageStrings as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collContentObjects) {
				foreach ((array) $this->collContentObjects as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collRights) {
				foreach ((array) $this->collRights as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		// nested_set behavior
		$this->collNestedSetChildren = null;
		$this->aNestedSetParent = null;
		$this->collPagePropertys = null;
		$this->collPageStrings = null;
		$this->collContentObjects = null;
		$this->collRights = null;
		$this->aUserRelatedByCreatedBy = null;
		$this->aUserRelatedByUpdatedBy = null;
	}

	// nested_set behavior
	
	/**
	 * Execute queries that were saved to be run inside the save transaction
	 */
	protected function processNestedSetQueries($con)
	{
		foreach ($this->nestedSetQueries as $query) {
			$query['arguments'][]= $con;
			call_user_func_array($query['callable'], $query['arguments']);
		}
		$this->nestedSetQueries = array();
	}
	
	/**
	 * Wraps the getter for the nested set left value
	 *
	 * @return     int
	 */
	public function getLeftValue()
	{
		return $this->tree_left;
	}
	
	/**
	 * Wraps the getter for the nested set right value
	 *
	 * @return     int
	 */
	public function getRightValue()
	{
		return $this->tree_right;
	}
	
	/**
	 * Wraps the getter for the nested set level
	 *
	 * @return     int
	 */
	public function getLevel()
	{
		return $this->tree_level;
	}
	
	/**
	 * Set the value left column
	 *
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setLeftValue($v)
	{
		return $this->setTreeLeft($v);
	}
	
	/**
	 * Set the value of right column
	 *
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setRightValue($v)
	{
		return $this->setTreeRight($v);
	}
	
	/**
	 * Set the value of level column
	 *
	 * @param      int $v new value
	 * @return     Page The current object (for fluent API support)
	 */
	public function setLevel($v)
	{
		return $this->setTreeLevel($v);
	}
	
	/**
	 * Creates the supplied node as the root node.
	 *
	 * @return     Page The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function makeRoot()
	{
		if ($this->getLeftValue() || $this->getRightValue()) {
			throw new PropelException('Cannot turn an existing node into a root node.');
		}
	
		$this->setLeftValue(1);
		$this->setRightValue(2);
		$this->setLevel(0);
		return $this;
	}
	
	/**
	 * Tests if onbject is a node, i.e. if it is inserted in the tree
	 *
	 * @return     bool
	 */
	public function isInTree()
	{
		return $this->getLeftValue() > 0 && $this->getRightValue() > $this->getLeftValue();
	}
	
	/**
	 * Tests if node is a root
	 *
	 * @return     bool
	 */
	public function isRoot()
	{
		return $this->isInTree() && $this->getLeftValue() == 1;
	}
	
	/**
	 * Tests if node is a leaf
	 *
	 * @return     bool
	 */
	public function isLeaf()
	{
		return $this->isInTree() &&  ($this->getRightValue() - $this->getLeftValue()) == 1;
	}
	
	/**
	 * Tests if node is a descendant of another node
	 *
	 * @param      Page $node Propel node object
	 * @return     bool
	 */
	public function isDescendantOf($parent)
	{
		return $this->isInTree() && $this->getLeftValue() > $parent->getLeftValue() && $this->getRightValue() < $parent->getRightValue();
	}
	
	/**
	 * Tests if node is a ancestor of another node
	 *
	 * @param      Page $node Propel node object
	 * @return     bool
	 */
	public function isAncestorOf($child)
	{
		return $child->isDescendantOf($this);
	}
	
	/**
	 * Tests if object has an ancestor
	 *
	 * @param      PropelPDO $con Connection to use.
	 * @return     bool
	 */
	public function hasParent(PropelPDO $con = null)
	{
		return $this->getLevel() > 0;
	}
	
	/**
	 * Sets the cache for parent node of the current object.
	 * Warning: this does not move the current object in the tree.
	 * Use moveTofirstChildOf() or moveToLastChildOf() for that purpose
	 *
	 * @param      Page $parent
	 * @return     Page The current object, for fluid interface
	 */
	public function setParent($parent = null)
	{
		$this->aNestedSetParent = $parent;
		return $this;
	}
	
	/**
	 * Gets parent node for the current object if it exists
	 * The result is cached so further calls to the same method don't issue any queries
	 *
	 * @param      PropelPDO $con Connection to use.
	 * @return     mixed 		Propel object if exists else false
	 */
	public function getParent(PropelPDO $con = null)
	{
		if ($this->aNestedSetParent === null && $this->hasParent()) {
			$this->aNestedSetParent = PageQuery::create()
				->ancestorsOf($this)
				->orderByLevel(true)
				->findOne($con);
		}
		return $this->aNestedSetParent;
	}
	
	/**
	 * Determines if the node has previous sibling
	 *
	 * @param      PropelPDO $con Connection to use.
	 * @return     bool
	 */
	public function hasPrevSibling(PropelPDO $con = null)
	{
		if (!PagePeer::isValid($this)) {
			return false;
		}
		return PageQuery::create()
			->filterByTreeRight($this->getLeftValue() - 1)
			->count($con) > 0;
	}
	
	/**
	 * Gets previous sibling for the given node if it exists
	 *
	 * @param      PropelPDO $con Connection to use.
	 * @return     mixed 		Propel object if exists else false
	 */
	public function getPrevSibling(PropelPDO $con = null)
	{
		return PageQuery::create()
			->filterByTreeRight($this->getLeftValue() - 1)
			->findOne($con);
	}
	
	/**
	 * Determines if the node has next sibling
	 *
	 * @param      PropelPDO $con Connection to use.
	 * @return     bool
	 */
	public function hasNextSibling(PropelPDO $con = null)
	{
		if (!PagePeer::isValid($this)) {
			return false;
		}
		return PageQuery::create()
			->filterByTreeLeft($this->getRightValue() + 1)
			->count($con) > 0;
	}
	
	/**
	 * Gets next sibling for the given node if it exists
	 *
	 * @param      PropelPDO $con Connection to use.
	 * @return     mixed 		Propel object if exists else false
	 */
	public function getNextSibling(PropelPDO $con = null)
	{
		return PageQuery::create()
			->filterByTreeLeft($this->getRightValue() + 1)
			->findOne($con);
	}
	
	/**
	 * Clears out the $collNestedSetChildren collection
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 */
	public function clearNestedSetChildren()
	{
		$this->collNestedSetChildren = null;
	}
	
	/**
	 * Initializes the $collNestedSetChildren collection.
	 *
	 * @return     void
	 */
	public function initNestedSetChildren()
	{
		$this->collNestedSetChildren = new PropelObjectCollection();
		$this->collNestedSetChildren->setModel('Page');
	}
	
	/**
	 * Adds an element to the internal $collNestedSetChildren collection.
	 * Beware that this doesn't insert a node in the tree.
	 * This method is only used to facilitate children hydration.
	 *
	 * @param      Page $page
	 *
	 * @return     void
	 */
	public function addNestedSetChild($page)
	{
		if ($this->collNestedSetChildren === null) {
			$this->initNestedSetChildren();
		}
		if (!$this->collNestedSetChildren->contains($page)) { // only add it if the **same** object is not already associated
			$this->collNestedSetChildren[]= $page;
			$page->setParent($this);
		}
	}
	
	/**
	 * Tests if node has children
	 *
	 * @return     bool
	 */
	public function hasChildren()
	{
		return ($this->getRightValue() - $this->getLeftValue()) > 1;
	}
	
	/**
	 * Gets the children of the given node
	 *
	 * @param      Criteria  $criteria Criteria to filter results.
	 * @param      PropelPDO $con Connection to use.
	 * @return     array     List of Page objects
	 */
	public function getChildren($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collNestedSetChildren || null !== $criteria) {
			if ($this->isLeaf() || ($this->isNew() && null === $this->collNestedSetChildren)) {
				// return empty collection
				$this->initNestedSetChildren();
			} else {
				$collNestedSetChildren = PageQuery::create(null, $criteria)
	  			->childrenOf($this)
	  			->orderByBranch()
					->find($con);
				if (null !== $criteria) {
					return $collNestedSetChildren;
				}
				$this->collNestedSetChildren = $collNestedSetChildren;
			}
		}
		return $this->collNestedSetChildren;
	}
	
	/**
	 * Gets number of children for the given node
	 *
	 * @param      Criteria  $criteria Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     int       Number of children
	 */
	public function countChildren($criteria = null, PropelPDO $con = null)
	{
		if(null === $this->collNestedSetChildren || null !== $criteria) {
			if ($this->isLeaf() || ($this->isNew() && null === $this->collNestedSetChildren)) {
				return 0;
			} else {
				return PageQuery::create(null, $criteria)
					->childrenOf($this)
					->count($con);
			}
		} else {
			return count($this->collNestedSetChildren);
		}
	}
	
	/**
	 * Gets the first child of the given node
	 *
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     array 		List of Page objects
	 */
	public function getFirstChild($query = null, PropelPDO $con = null)
	{
		if($this->isLeaf()) {
			return array();
		} else {
			return PageQuery::create(null, $query)
				->childrenOf($this)
				->orderByBranch()
				->findOne($con);
		}
	}
	
	/**
	 * Gets the last child of the given node
	 *
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     array 		List of Page objects
	 */
	public function getLastChild($query = null, PropelPDO $con = null)
	{
		if($this->isLeaf()) {
			return array();
		} else {
			return PageQuery::create(null, $query)
				->childrenOf($this)
				->orderByBranch(true)
				->findOne($con);
		}
	}
	
	/**
	 * Gets the siblings of the given node
	 *
	 * @param      bool			$includeNode Whether to include the current node or not
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 *
	 * @return     array 		List of Page objects
	 */
	public function getSiblings($includeNode = false, $query = null, PropelPDO $con = null)
	{
		if($this->isRoot()) {
			return array();
		} else {
			 $query = PageQuery::create(null, $query)
					->childrenOf($this->getParent($con))
					->orderByBranch(true);
			if (!$includeNode) {
				$query->prune($this);
			}
			return $query->find($con);
		}
	}
	
	/**
	 * Gets descendants for the given node
	 *
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     array 		List of Page objects
	 */
	public function getDescendants($query = null, PropelPDO $con = null)
	{
		if($this->isLeaf()) {
			return array();
		} else {
			return PageQuery::create(null, $query)
				->descendantsOf($this)
				->orderByBranch()
				->find($con);
		}
	}
	
	/**
	 * Gets number of descendants for the given node
	 *
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     int 		Number of descendants
	 */
	public function countDescendants($query = null, PropelPDO $con = null)
	{
		if($this->isLeaf()) {
			// save one query
			return 0;
		} else {
			return PageQuery::create(null, $query)
				->descendantsOf($this)
				->count($con);
		}
	}
	
	/**
	 * Gets descendants for the given node, plus the current node
	 *
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     array 		List of Page objects
	 */
	public function getBranch($query = null, PropelPDO $con = null)
	{
		return PageQuery::create(null, $query)
			->branchOf($this)
			->orderByBranch()
			->find($con);
	}
	
	/**
	 * Gets ancestors for the given node, starting with the root node
	 * Use it for breadcrumb paths for instance
	 *
	 * @param      Criteria $query Criteria to filter results. 
	 * @param      PropelPDO $con Connection to use.
	 * @return     array 		List of Page objects
	 */
	public function getAncestors($query = null, PropelPDO $con = null)
	{
		if($this->isRoot()) {
			// save one query
			return array();
		} else {
			return PageQuery::create(null, $query)
				->ancestorsOf($this)
				->orderByBranch()
				->find($con);
		}
	}
	
	/**
	 * Inserts the given $child node as first child of current
	 * The modifications in the current object and the tree
	 * are not persisted until the child object is saved.
	 *
	 * @param      Page $child	Propel object for child node
	 *
	 * @return     Page The current Propel object
	 */
	public function addChild(Page $child)
	{
		if ($this->isNew()) {
			throw new PropelException('A Page object must not be new to accept children.');
		}
		$child->insertAsFirstChildOf($this);
		return $this;
	}
	
	/**
	 * Inserts the current node as first child of given $parent node
	 * The modifications in the current object and the tree
	 * are not persisted until the current object is saved.
	 *
	 * @param      Page $parent	Propel object for parent node
	 *
	 * @return     Page The current Propel object
	 */
	public function insertAsFirstChildOf($parent)
	{
		if ($this->isInTree()) {
			throw new PropelException('A Page object must not already be in the tree to be inserted. Use the moveToFirstChildOf() instead.');
		}
		$left = $parent->getLeftValue() + 1;
		// Update node properties
		$this->setLeftValue($left);
		$this->setRightValue($left + 1);
		$this->setLevel($parent->getLevel() + 1);
		// update the children collection of the parent
		$parent->addNestedSetChild($this);
		
		// Keep the tree modification query for the save() transaction
		$this->nestedSetQueries []= array(
			'callable'  => array('PagePeer', 'makeRoomForLeaf'),
			'arguments' => array($left)
		);
		return $this;
	}
	
	/**
	 * Inserts the current node as last child of given $parent node
	 * The modifications in the current object and the tree
	 * are not persisted until the current object is saved.
	 *
	 * @param      Page $parent	Propel object for parent node
	 *
	 * @return     Page The current Propel object
	 */
	public function insertAsLastChildOf($parent)
	{
		if ($this->isInTree()) {
			throw new PropelException('A Page object must not already be in the tree to be inserted. Use the moveToLastChildOf() instead.');
		}
		$left = $parent->getRightValue();
		// Update node properties
		$this->setLeftValue($left);
		$this->setRightValue($left + 1);
		$this->setLevel($parent->getLevel() + 1);
		// update the children collection of the parent
		$parent->addNestedSetChild($this);
		
		// Keep the tree modification query for the save() transaction
		$this->nestedSetQueries []= array(
			'callable'  => array('PagePeer', 'makeRoomForLeaf'),
			'arguments' => array($left)
		);
		return $this;
	}
	
	/**
	 * Inserts the current node as prev sibling given $sibling node
	 * The modifications in the current object and the tree
	 * are not persisted until the current object is saved.
	 *
	 * @param      Page $sibling	Propel object for parent node
	 *
	 * @return     Page The current Propel object
	 */
	public function insertAsPrevSiblingOf($sibling)
	{
		if ($this->isInTree()) {
			throw new PropelException('A Page object must not already be in the tree to be inserted. Use the moveToPrevSiblingOf() instead.');
		}
		$left = $sibling->getLeftValue();
		// Update node properties
		$this->setLeftValue($left);
		$this->setRightValue($left + 1);
		$this->setLevel($sibling->getLevel());
		// Keep the tree modification query for the save() transaction
		$this->nestedSetQueries []= array(
			'callable'  => array('PagePeer', 'makeRoomForLeaf'),
			'arguments' => array($left)
		);
		return $this;
	}
	
	/**
	 * Inserts the current node as next sibling given $sibling node
	 * The modifications in the current object and the tree
	 * are not persisted until the current object is saved.
	 *
	 * @param      Page $sibling	Propel object for parent node
	 *
	 * @return     Page The current Propel object
	 */
	public function insertAsNextSiblingOf($sibling)
	{
		if ($this->isInTree()) {
			throw new PropelException('A Page object must not already be in the tree to be inserted. Use the moveToNextSiblingOf() instead.');
		}
		$left = $sibling->getRightValue() + 1;
		// Update node properties
		$this->setLeftValue($left);
		$this->setRightValue($left + 1);
		$this->setLevel($sibling->getLevel());
		// Keep the tree modification query for the save() transaction
		$this->nestedSetQueries []= array(
			'callable'  => array('PagePeer', 'makeRoomForLeaf'),
			'arguments' => array($left)
		);
		return $this;
	}
	
	/**
	 * Moves current node and its subtree to be the first child of $parent
	 * The modifications in the current object and the tree are immediate
	 *
	 * @param      Page $parent	Propel object for parent node
	 * @param      PropelPDO $con	Connection to use.
	 *
	 * @return     Page The current Propel object
	 */
	public function moveToFirstChildOf($parent, PropelPDO $con = null)
	{
		if (!$this->isInTree()) {
			throw new PropelException('A Page object must be already in the tree to be moved. Use the insertAsFirstChildOf() instead.');
		}
		if ($parent->isDescendantOf($this)) {
			throw new PropelException('Cannot move a node as child of one of its subtree nodes.');
		}
		
		$this->moveSubtreeTo($parent->getLeftValue() + 1, $parent->getLevel() - $this->getLevel() + 1, $con);
		
		return $this;
	}
	
	/**
	 * Moves current node and its subtree to be the last child of $parent
	 * The modifications in the current object and the tree are immediate
	 *
	 * @param      Page $parent	Propel object for parent node
	 * @param      PropelPDO $con	Connection to use.
	 *
	 * @return     Page The current Propel object
	 */
	public function moveToLastChildOf($parent, PropelPDO $con = null)
	{
		if (!$this->isInTree()) {
			throw new PropelException('A Page object must be already in the tree to be moved. Use the insertAsLastChildOf() instead.');
		}
		if ($parent->isDescendantOf($this)) {
			throw new PropelException('Cannot move a node as child of one of its subtree nodes.');
		}
		
		$this->moveSubtreeTo($parent->getRightValue(), $parent->getLevel() - $this->getLevel() + 1, $con);
		
		return $this;
	}
	
	/**
	 * Moves current node and its subtree to be the previous sibling of $sibling
	 * The modifications in the current object and the tree are immediate
	 *
	 * @param      Page $sibling	Propel object for sibling node
	 * @param      PropelPDO $con	Connection to use.
	 *
	 * @return     Page The current Propel object
	 */
	public function moveToPrevSiblingOf($sibling, PropelPDO $con = null)
	{
		if (!$this->isInTree()) {
			throw new PropelException('A Page object must be already in the tree to be moved. Use the insertAsPrevSiblingOf() instead.');
		}
		if ($sibling->isRoot()) {
			throw new PropelException('Cannot move to previous sibling of a root node.');
		}
		if ($sibling->isDescendantOf($this)) {
			throw new PropelException('Cannot move a node as sibling of one of its subtree nodes.');
		}
		
		$this->moveSubtreeTo($sibling->getLeftValue(), $sibling->getLevel() - $this->getLevel(), $con);
		
		return $this;
	}
	
	/**
	 * Moves current node and its subtree to be the next sibling of $sibling
	 * The modifications in the current object and the tree are immediate
	 *
	 * @param      Page $sibling	Propel object for sibling node
	 * @param      PropelPDO $con	Connection to use.
	 *
	 * @return     Page The current Propel object
	 */
	public function moveToNextSiblingOf($sibling, PropelPDO $con = null)
	{
		if (!$this->isInTree()) {
			throw new PropelException('A Page object must be already in the tree to be moved. Use the insertAsNextSiblingOf() instead.');
		}
		if ($sibling->isRoot()) {
			throw new PropelException('Cannot move to next sibling of a root node.');
		}
		if ($sibling->isDescendantOf($this)) {
			throw new PropelException('Cannot move a node as sibling of one of its subtree nodes.');
		}
		
		$this->moveSubtreeTo($sibling->getRightValue() + 1, $sibling->getLevel() - $this->getLevel(), $con);
		
		return $this;
	}
	
	/**
	 * Move current node and its children to location $destLeft and updates rest of tree
	 *
	 * @param      int	$destLeft Destination left value
	 * @param      int	$levelDelta Delta to add to the levels
	 * @param      PropelPDO $con		Connection to use.
	 */
	protected function moveSubtreeTo($destLeft, $levelDelta, PropelPDO $con = null)
	{
		$left  = $this->getLeftValue();
		$right = $this->getRightValue();
	
		$treeSize = $right - $left +1;
		
		if ($con === null) {
			$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
			
		$con->beginTransaction();
		try {
			// make room next to the target for the subtree
			PagePeer::shiftRLValues($treeSize, $destLeft, null, $con);
		
			if ($left >= $destLeft) { // src was shifted too?
				$left += $treeSize;
				$right += $treeSize;
			}
			
			if ($levelDelta) {
				// update the levels of the subtree
				PagePeer::shiftLevel($levelDelta, $left, $right, $con);
			}
			
			// move the subtree to the target
			PagePeer::shiftRLValues($destLeft - $left, $left, $right, $con);
		
			// remove the empty room at the previous location of the subtree
			PagePeer::shiftRLValues(-$treeSize, $right + 1, null, $con);
			
			// update all loaded nodes
			PagePeer::updateLoadedNodes($con);
			
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}
	
	/**
	 * Deletes all descendants for the given node
	 * Instance pooling is wiped out by this command, 
	 * so existing Page instances are probably invalid (except for the current one)
	 *
	 * @param      PropelPDO $con Connection to use.
	 *
	 * @return     int 		number of deleted nodes
	 */
	public function deleteDescendants(PropelPDO $con = null)
	{
		if($this->isLeaf()) {
			// save one query
			return;
		}
		if ($con === null) {
			$con = Propel::getConnection(PagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$left = $this->getLeftValue();
		$right = $this->getRightValue();
		$con->beginTransaction();
		try {
			// delete descendant nodes (will empty the instance pool)
			$ret = PageQuery::create()
				->descendantsOf($this)
				->delete($con);
			
			// fill up the room that was used by descendants
			PagePeer::shiftRLValues($left - $right + 1, $right, null, $con);
			
			// fix the right value for the current node, which is now a leaf
			$this->setRightValue($left + 1);
			
			$con->commit();
		} catch (Exception $e) {
			$con->rollback();
			throw $e;
		}
		
		return $ret;
	}
	
	/**
	 * Returns a pre-order iterator for this node and its children.
	 *
	 * @return     RecursiveIterator
	 */
	public function getIterator()
	{
		return new NestedSetRecursiveIterator($this);
	}

	// referenceable behavior
	
	/**
	 * @return A list of References (not Objects) which reference this Page
	 */
	public function getReferees()
	{
		return ReferencePeer::getReferences($this);
	}
	// taggable behavior
	
	/**
	 * @return A list of TagInstances (not Tags) which reference this Page
	 */
	public function getTags()
	{
		return TagPeer::tagInstancesForObject($this);
	}
	// extended_timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     Page The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = PagePeer::UPDATED_AT;
		return $this;
	}
	
	/**
	 * @return created_at as int (timestamp)
	 */
	public function getCreatedAtTimestamp()
	{
		return $this->created_at;
	}
	
	/**
	 * @return created_at formatted to the current locale
	 */
	public function getCreatedAtFormatted()
	{
		return LocaleUtil::localizeDate($this->created_at);
	}
	
	/**
	 * @return updated_at as int (timestamp)
	 */
	public function getUpdatedAtTimestamp()
	{
		return $this->updated_at;
	}
	
	/**
	 * @return updated_at formatted to the current locale
	 */
	public function getUpdatedAtFormatted()
	{
		return LocaleUtil::localizeDate($this->updated_at);
	}

	// attributable behavior
	
	/**
	 * Mark the current object so that the updated user doesn't get updated during next save
	 *
	 * @return     Page The current object (for fluent API support)
	 */
	public function keepUpdateUserUnchanged()
	{
		$this->modifiedColumns[] = PagePeer::UPDATED_BY;
		return $this;
	}

	/**
	 * Catches calls to virtual methods
	 */
	public function __call($name, $params)
	{
		if (preg_match('/get(\w+)/', $name, $matches) && $this->hasVirtualColumn($matches[1])) {
			return $this->getVirtualColumn($matches[1]);
		}
		throw new PropelException('Call to undefined method: ' . $name);
	}

} // BasePage
