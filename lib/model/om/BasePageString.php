<?php

/**
 * Base class that represents a row from the 'page_strings' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BasePageString extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
  const PEER = 'PageStringPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        PageStringPeer
	 */
	protected static $peer;

	/**
	 * The value for the page_id field.
	 * @var        int
	 */
	protected $page_id;

	/**
	 * The value for the language_id field.
	 * @var        string
	 */
	protected $language_id;

	/**
	 * The value for the is_inactive field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_inactive;

	/**
	 * The value for the link_text field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $link_text;

	/**
	 * The value for the page_title field.
	 * @var        string
	 */
	protected $page_title;

	/**
	 * The value for the keywords field.
	 * @var        string
	 */
	protected $keywords;

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
	 * @var        Page
	 */
	protected $aPage;

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
		$this->is_inactive = false;
		$this->link_text = '';
	}

	/**
	 * Initializes internal state of BasePageString object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [page_id] column value.
	 * 
	 * @return     int
	 */
	public function getPageId()
	{
		return $this->page_id;
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
	 * Get the [is_inactive] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsInactive()
	{
		return $this->is_inactive;
	}

	/**
	 * Get the [link_text] column value.
	 * 
	 * @return     string
	 */
	public function getLinkText()
	{
		return $this->link_text;
	}

	/**
	 * Get the [page_title] column value.
	 * 
	 * @return     string
	 */
	public function getPageTitle()
	{
		return $this->page_title;
	}

	/**
	 * Get the [keywords] column value.
	 * 
	 * @return     string
	 */
	public function getKeywords()
	{
		return $this->keywords;
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
	 * Set the value of [page_id] column.
	 * 
	 * @param      int $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setPageId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->page_id !== $v) {
			$this->page_id = $v;
			$this->modifiedColumns[] = PageStringPeer::PAGE_ID;
		}

		if ($this->aPage !== null && $this->aPage->getId() !== $v) {
			$this->aPage = null;
		}

		return $this;
	} // setPageId()

	/**
	 * Set the value of [language_id] column.
	 * 
	 * @param      string $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setLanguageId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->language_id !== $v) {
			$this->language_id = $v;
			$this->modifiedColumns[] = PageStringPeer::LANGUAGE_ID;
		}

		if ($this->aLanguage !== null && $this->aLanguage->getId() !== $v) {
			$this->aLanguage = null;
		}

		return $this;
	} // setLanguageId()

	/**
	 * Set the value of [is_inactive] column.
	 * 
	 * @param      boolean $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setIsInactive($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_inactive !== $v || $this->isNew()) {
			$this->is_inactive = $v;
			$this->modifiedColumns[] = PageStringPeer::IS_INACTIVE;
		}

		return $this;
	} // setIsInactive()

	/**
	 * Set the value of [link_text] column.
	 * 
	 * @param      string $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setLinkText($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->link_text !== $v || $this->isNew()) {
			$this->link_text = $v;
			$this->modifiedColumns[] = PageStringPeer::LINK_TEXT;
		}

		return $this;
	} // setLinkText()

	/**
	 * Set the value of [page_title] column.
	 * 
	 * @param      string $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setPageTitle($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->page_title !== $v) {
			$this->page_title = $v;
			$this->modifiedColumns[] = PageStringPeer::PAGE_TITLE;
		}

		return $this;
	} // setPageTitle()

	/**
	 * Set the value of [keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setKeywords($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->keywords !== $v) {
			$this->keywords = $v;
			$this->modifiedColumns[] = PageStringPeer::KEYWORDS;
		}

		return $this;
	} // setKeywords()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PageString The current object (for fluent API support)
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
				$this->modifiedColumns[] = PageStringPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     PageString The current object (for fluent API support)
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
				$this->modifiedColumns[] = PageStringPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [created_by] column.
	 * 
	 * @param      int $v new value
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setCreatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = PageStringPeer::CREATED_BY;
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
	 * @return     PageString The current object (for fluent API support)
	 */
	public function setUpdatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = PageStringPeer::UPDATED_BY;
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
			if ($this->is_inactive !== false) {
				return false;
			}

			if ($this->link_text !== '') {
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

			$this->page_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->language_id = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->is_inactive = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
			$this->link_text = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->page_title = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->keywords = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->updated_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->created_by = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->updated_by = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 10; // 10 = PageStringPeer::NUM_COLUMNS - PageStringPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PageString object", $e);
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

		if ($this->aPage !== null && $this->page_id !== $this->aPage->getId()) {
			$this->aPage = null;
		}
		if ($this->aLanguage !== null && $this->language_id !== $this->aLanguage->getId()) {
			$this->aLanguage = null;
		}
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
			$con = Propel::getConnection(PageStringPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = PageStringPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aPage = null;
			$this->aLanguage = null;
			$this->aUserRelatedByCreatedBy = null;
			$this->aUserRelatedByUpdatedBy = null;
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
			$con = Propel::getConnection(PageStringPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			if ($ret) {
				PageStringQuery::create()
					->filterByPrimaryKey($this->getPrimaryKey())
					->delete($con);
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
			$con = Propel::getConnection(PageStringPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// extended_timestampable behavior
				if (!$this->isColumnModified(PageStringPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(PageStringPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if (!$this->isColumnModified(PageStringPeer::CREATED_BY)) {
						$this->setCreatedBy(Session::getSession()->getUser()->getId());
					}
					if (!$this->isColumnModified(PageStringPeer::UPDATED_BY)) {
						$this->setUpdatedBy(Session::getSession()->getUser()->getId());
					}
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
				// extended_timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(PageStringPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if ($this->isModified() && !$this->isColumnModified(PageStringPeer::UPDATED_BY)) {
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
				PageStringPeer::addInstanceToPool($this);
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

			if ($this->aPage !== null) {
				if ($this->aPage->isModified() || $this->aPage->isNew()) {
					$affectedRows += $this->aPage->save($con);
				}
				$this->setPage($this->aPage);
			}

			if ($this->aLanguage !== null) {
				if ($this->aLanguage->isModified() || $this->aLanguage->isNew()) {
					$affectedRows += $this->aLanguage->save($con);
				}
				$this->setLanguage($this->aLanguage);
			}

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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setNew(false);
				} else {
					$affectedRows += PageStringPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
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

			if ($this->aPage !== null) {
				if (!$this->aPage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPage->getValidationFailures());
				}
			}

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


			if (($retval = PageStringPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
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
		$pos = PageStringPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPageId();
				break;
			case 1:
				return $this->getLanguageId();
				break;
			case 2:
				return $this->getIsInactive();
				break;
			case 3:
				return $this->getLinkText();
				break;
			case 4:
				return $this->getPageTitle();
				break;
			case 5:
				return $this->getKeywords();
				break;
			case 6:
				return $this->getCreatedAt();
				break;
			case 7:
				return $this->getUpdatedAt();
				break;
			case 8:
				return $this->getCreatedBy();
				break;
			case 9:
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
		$keys = PageStringPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getPageId(),
			$keys[1] => $this->getLanguageId(),
			$keys[2] => $this->getIsInactive(),
			$keys[3] => $this->getLinkText(),
			$keys[4] => $this->getPageTitle(),
			$keys[5] => $this->getKeywords(),
			$keys[6] => $this->getCreatedAt(),
			$keys[7] => $this->getUpdatedAt(),
			$keys[8] => $this->getCreatedBy(),
			$keys[9] => $this->getUpdatedBy(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aPage) {
				$result['Page'] = $this->aPage->toArray($keyType, $includeLazyLoadColumns, true);
			}
			if (null !== $this->aLanguage) {
				$result['Language'] = $this->aLanguage->toArray($keyType, $includeLazyLoadColumns, true);
			}
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
		$pos = PageStringPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setPageId($value);
				break;
			case 1:
				$this->setLanguageId($value);
				break;
			case 2:
				$this->setIsInactive($value);
				break;
			case 3:
				$this->setLinkText($value);
				break;
			case 4:
				$this->setPageTitle($value);
				break;
			case 5:
				$this->setKeywords($value);
				break;
			case 6:
				$this->setCreatedAt($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
			case 8:
				$this->setCreatedBy($value);
				break;
			case 9:
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
		$keys = PageStringPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setPageId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLanguageId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsInactive($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLinkText($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPageTitle($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setKeywords($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedBy($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUpdatedBy($arr[$keys[9]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(PageStringPeer::DATABASE_NAME);

		if ($this->isColumnModified(PageStringPeer::PAGE_ID)) $criteria->add(PageStringPeer::PAGE_ID, $this->page_id);
		if ($this->isColumnModified(PageStringPeer::LANGUAGE_ID)) $criteria->add(PageStringPeer::LANGUAGE_ID, $this->language_id);
		if ($this->isColumnModified(PageStringPeer::IS_INACTIVE)) $criteria->add(PageStringPeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(PageStringPeer::LINK_TEXT)) $criteria->add(PageStringPeer::LINK_TEXT, $this->link_text);
		if ($this->isColumnModified(PageStringPeer::PAGE_TITLE)) $criteria->add(PageStringPeer::PAGE_TITLE, $this->page_title);
		if ($this->isColumnModified(PageStringPeer::KEYWORDS)) $criteria->add(PageStringPeer::KEYWORDS, $this->keywords);
		if ($this->isColumnModified(PageStringPeer::CREATED_AT)) $criteria->add(PageStringPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PageStringPeer::UPDATED_AT)) $criteria->add(PageStringPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PageStringPeer::CREATED_BY)) $criteria->add(PageStringPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(PageStringPeer::UPDATED_BY)) $criteria->add(PageStringPeer::UPDATED_BY, $this->updated_by);

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
		$criteria = new Criteria(PageStringPeer::DATABASE_NAME);
		$criteria->add(PageStringPeer::PAGE_ID, $this->page_id);
		$criteria->add(PageStringPeer::LANGUAGE_ID, $this->language_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();
		$pks[0] = $this->getPageId();
		$pks[1] = $this->getLanguageId();
		
		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{
		$this->setPageId($keys[0]);
		$this->setLanguageId($keys[1]);
	}

	/**
	 * Returns true if the primary key for this object is null.
	 * @return     boolean
	 */
	public function isPrimaryKeyNull()
	{
		return (null === $this->getPageId()) && (null === $this->getLanguageId());
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of PageString (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{
		$copyObj->setPageId($this->page_id);
		$copyObj->setLanguageId($this->language_id);
		$copyObj->setIsInactive($this->is_inactive);
		$copyObj->setLinkText($this->link_text);
		$copyObj->setPageTitle($this->page_title);
		$copyObj->setKeywords($this->keywords);
		$copyObj->setCreatedAt($this->created_at);
		$copyObj->setUpdatedAt($this->updated_at);
		$copyObj->setCreatedBy($this->created_by);
		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setNew(true);
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
	 * @return     PageString Clone of current object.
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
	 * @return     PageStringPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new PageStringPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Page object.
	 *
	 * @param      Page $v
	 * @return     PageString The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setPage(Page $v = null)
	{
		if ($v === null) {
			$this->setPageId(NULL);
		} else {
			$this->setPageId($v->getId());
		}

		$this->aPage = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Page object, it will not be re-added.
		if ($v !== null) {
			$v->addPageString($this);
		}

		return $this;
	}


	/**
	 * Get the associated Page object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Page The associated Page object.
	 * @throws     PropelException
	 */
	public function getPage(PropelPDO $con = null)
	{
		if ($this->aPage === null && ($this->page_id !== null)) {
			$this->aPage = PageQuery::create()->findPk($this->page_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aPage->addPageStrings($this);
			 */
		}
		return $this->aPage;
	}

	/**
	 * Declares an association between this object and a Language object.
	 *
	 * @param      Language $v
	 * @return     PageString The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setLanguage(Language $v = null)
	{
		if ($v === null) {
			$this->setLanguageId(NULL);
		} else {
			$this->setLanguageId($v->getId());
		}

		$this->aLanguage = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Language object, it will not be re-added.
		if ($v !== null) {
			$v->addPageString($this);
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
	public function getLanguage(PropelPDO $con = null)
	{
		if ($this->aLanguage === null && (($this->language_id !== "" && $this->language_id !== null))) {
			$this->aLanguage = LanguageQuery::create()->findPk($this->language_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aLanguage->addPageStrings($this);
			 */
		}
		return $this->aLanguage;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     PageString The current object (for fluent API support)
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
			$v->addPageStringRelatedByCreatedBy($this);
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
			   $this->aUserRelatedByCreatedBy->addPageStringsRelatedByCreatedBy($this);
			 */
		}
		return $this->aUserRelatedByCreatedBy;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     PageString The current object (for fluent API support)
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
			$v->addPageStringRelatedByUpdatedBy($this);
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
			   $this->aUserRelatedByUpdatedBy->addPageStringsRelatedByUpdatedBy($this);
			 */
		}
		return $this->aUserRelatedByUpdatedBy;
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->page_id = null;
		$this->language_id = null;
		$this->is_inactive = null;
		$this->link_text = null;
		$this->page_title = null;
		$this->keywords = null;
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
		} // if ($deep)

		$this->aPage = null;
		$this->aLanguage = null;
		$this->aUserRelatedByCreatedBy = null;
		$this->aUserRelatedByUpdatedBy = null;
	}

	// extended_timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     PageString The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = PageStringPeer::UPDATED_AT;
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
		return $this->updated_at;
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
	 * @return     PageString The current object (for fluent API support)
	 */
	public function keepUpdateUserUnchanged()
	{
		$this->modifiedColumns[] = PageStringPeer::UPDATED_BY;
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

} // BasePageString
