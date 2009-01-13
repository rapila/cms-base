<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/PagePeer.php';

/**
 * Base class that represents a row from the 'pages' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BasePage extends BaseObject  implements Persistent {


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
	 * The value for the parent_id field.
	 * @var        int
	 */
	protected $parent_id;


	/**
	 * The value for the sort field.
	 * @var        int
	 */
	protected $sort;


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
	 * @var        boolean
	 */
	protected $is_inactive = true;


	/**
	 * The value for the is_folder field.
	 * @var        boolean
	 */
	protected $is_folder = false;


	/**
	 * The value for the is_hidden field.
	 * @var        boolean
	 */
	protected $is_hidden = false;


	/**
	 * The value for the is_protected field.
	 * @var        boolean
	 */
	protected $is_protected = false;


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
	 * @var        Page
	 */
	protected $aPageRelatedByParentId;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByCreatedBy;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByUpdatedBy;

	/**
	 * Collection to store aggregation of collPagesRelatedByParentId.
	 * @var        array
	 */
	protected $collPagesRelatedByParentId;

	/**
	 * The criteria used to select the current contents of collPagesRelatedByParentId.
	 * @var        Criteria
	 */
	protected $lastPageRelatedByParentIdCriteria = null;

	/**
	 * Collection to store aggregation of collPagePropertys.
	 * @var        array
	 */
	protected $collPagePropertys;

	/**
	 * The criteria used to select the current contents of collPagePropertys.
	 * @var        Criteria
	 */
	protected $lastPagePropertyCriteria = null;

	/**
	 * Collection to store aggregation of collPageStrings.
	 * @var        array
	 */
	protected $collPageStrings;

	/**
	 * The criteria used to select the current contents of collPageStrings.
	 * @var        Criteria
	 */
	protected $lastPageStringCriteria = null;

	/**
	 * Collection to store aggregation of collContentObjects.
	 * @var        array
	 */
	protected $collContentObjects;

	/**
	 * The criteria used to select the current contents of collContentObjects.
	 * @var        Criteria
	 */
	protected $lastContentObjectCriteria = null;

	/**
	 * Collection to store aggregation of collRights.
	 * @var        array
	 */
	protected $collRights;

	/**
	 * The criteria used to select the current contents of collRights.
	 * @var        Criteria
	 */
	protected $lastRightCriteria = null;

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
	 * Get the [parent_id] column value.
	 * 
	 * @return     int
	 */
	public function getParentId()
	{

		return $this->parent_id;
	}

	/**
	 * Get the [sort] column value.
	 * 
	 * @return     int
	 */
	public function getSort()
	{

		return $this->sort;
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
			$this->modifiedColumns[] = PagePeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [parent_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setParentId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->parent_id !== $v) {
			$this->parent_id = $v;
			$this->modifiedColumns[] = PagePeer::PARENT_ID;
		}

		if ($this->aPageRelatedByParentId !== null && $this->aPageRelatedByParentId->getId() !== $v) {
			$this->aPageRelatedByParentId = null;
		}

	} // setParentId()

	/**
	 * Set the value of [sort] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setSort($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sort !== $v) {
			$this->sort = $v;
			$this->modifiedColumns[] = PagePeer::SORT;
		}

	} // setSort()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setName($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = PagePeer::NAME;
		}

	} // setName()

	/**
	 * Set the value of [page_type] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setPageType($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->page_type !== $v) {
			$this->page_type = $v;
			$this->modifiedColumns[] = PagePeer::PAGE_TYPE;
		}

	} // setPageType()

	/**
	 * Set the value of [template_name] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTemplateName($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->template_name !== $v) {
			$this->template_name = $v;
			$this->modifiedColumns[] = PagePeer::TEMPLATE_NAME;
		}

	} // setTemplateName()

	/**
	 * Set the value of [is_inactive] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsInactive($v)
	{

		if ($this->is_inactive !== $v || $v === true) {
			$this->is_inactive = $v;
			$this->modifiedColumns[] = PagePeer::IS_INACTIVE;
		}

	} // setIsInactive()

	/**
	 * Set the value of [is_folder] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsFolder($v)
	{

		if ($this->is_folder !== $v || $v === false) {
			$this->is_folder = $v;
			$this->modifiedColumns[] = PagePeer::IS_FOLDER;
		}

	} // setIsFolder()

	/**
	 * Set the value of [is_hidden] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsHidden($v)
	{

		if ($this->is_hidden !== $v || $v === false) {
			$this->is_hidden = $v;
			$this->modifiedColumns[] = PagePeer::IS_HIDDEN;
		}

	} // setIsHidden()

	/**
	 * Set the value of [is_protected] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsProtected($v)
	{

		if ($this->is_protected !== $v || $v === false) {
			$this->is_protected = $v;
			$this->modifiedColumns[] = PagePeer::IS_PROTECTED;
		}

	} // setIsProtected()

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
			$this->modifiedColumns[] = PagePeer::CREATED_BY;
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
			$this->modifiedColumns[] = PagePeer::UPDATED_BY;
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
			$this->modifiedColumns[] = PagePeer::CREATED_AT;
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
			$this->modifiedColumns[] = PagePeer::UPDATED_AT;
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

			$this->parent_id = $rs->getInt($startcol + 1);

			$this->sort = $rs->getInt($startcol + 2);

			$this->name = $rs->getString($startcol + 3);

			$this->page_type = $rs->getString($startcol + 4);

			$this->template_name = $rs->getString($startcol + 5);

			$this->is_inactive = $rs->getBoolean($startcol + 6);

			$this->is_folder = $rs->getBoolean($startcol + 7);

			$this->is_hidden = $rs->getBoolean($startcol + 8);

			$this->is_protected = $rs->getBoolean($startcol + 9);

			$this->created_by = $rs->getInt($startcol + 10);

			$this->updated_by = $rs->getInt($startcol + 11);

			$this->created_at = $rs->getTimestamp($startcol + 12, null);

			$this->updated_at = $rs->getTimestamp($startcol + 13, null);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 14; // 14 = PagePeer::NUM_COLUMNS - PagePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Page object", $e);
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
			$con = Propel::getConnection(PagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			PagePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(PagePeer::DATABASE_NAME);
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

			if ($this->aPageRelatedByParentId !== null) {
				if ($this->aPageRelatedByParentId->isModified()) {
					$affectedRows += $this->aPageRelatedByParentId->save($con);
				}
				$this->setPageRelatedByParentId($this->aPageRelatedByParentId);
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
					$pk = PagePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += PagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPagesRelatedByParentId !== null) {
				foreach($this->collPagesRelatedByParentId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPagePropertys !== null) {
				foreach($this->collPagePropertys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collPageStrings !== null) {
				foreach($this->collPageStrings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collContentObjects !== null) {
				foreach($this->collContentObjects as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collRights !== null) {
				foreach($this->collRights as $referrerFK) {
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

			if ($this->aPageRelatedByParentId !== null) {
				if (!$this->aPageRelatedByParentId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPageRelatedByParentId->getValidationFailures());
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


			if (($retval = PagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPagePropertys !== null) {
					foreach($this->collPagePropertys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collPageStrings !== null) {
					foreach($this->collPageStrings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collContentObjects !== null) {
					foreach($this->collContentObjects as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collRights !== null) {
					foreach($this->collRights as $referrerFK) {
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
		$pos = PagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getParentId();
				break;
			case 2:
				return $this->getSort();
				break;
			case 3:
				return $this->getName();
				break;
			case 4:
				return $this->getPageType();
				break;
			case 5:
				return $this->getTemplateName();
				break;
			case 6:
				return $this->getIsInactive();
				break;
			case 7:
				return $this->getIsFolder();
				break;
			case 8:
				return $this->getIsHidden();
				break;
			case 9:
				return $this->getIsProtected();
				break;
			case 10:
				return $this->getCreatedBy();
				break;
			case 11:
				return $this->getUpdatedBy();
				break;
			case 12:
				return $this->getCreatedAt();
				break;
			case 13:
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
		$keys = PagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getParentId(),
			$keys[2] => $this->getSort(),
			$keys[3] => $this->getName(),
			$keys[4] => $this->getPageType(),
			$keys[5] => $this->getTemplateName(),
			$keys[6] => $this->getIsInactive(),
			$keys[7] => $this->getIsFolder(),
			$keys[8] => $this->getIsHidden(),
			$keys[9] => $this->getIsProtected(),
			$keys[10] => $this->getCreatedBy(),
			$keys[11] => $this->getUpdatedBy(),
			$keys[12] => $this->getCreatedAt(),
			$keys[13] => $this->getUpdatedAt(),
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
				$this->setParentId($value);
				break;
			case 2:
				$this->setSort($value);
				break;
			case 3:
				$this->setName($value);
				break;
			case 4:
				$this->setPageType($value);
				break;
			case 5:
				$this->setTemplateName($value);
				break;
			case 6:
				$this->setIsInactive($value);
				break;
			case 7:
				$this->setIsFolder($value);
				break;
			case 8:
				$this->setIsHidden($value);
				break;
			case 9:
				$this->setIsProtected($value);
				break;
			case 10:
				$this->setCreatedBy($value);
				break;
			case 11:
				$this->setUpdatedBy($value);
				break;
			case 12:
				$this->setCreatedAt($value);
				break;
			case 13:
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
		$keys = PagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setParentId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSort($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPageType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTemplateName($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsInactive($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsFolder($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsHidden($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setIsProtected($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedBy($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUpdatedBy($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setCreatedAt($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setUpdatedAt($arr[$keys[13]]);
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
		if ($this->isColumnModified(PagePeer::PARENT_ID)) $criteria->add(PagePeer::PARENT_ID, $this->parent_id);
		if ($this->isColumnModified(PagePeer::SORT)) $criteria->add(PagePeer::SORT, $this->sort);
		if ($this->isColumnModified(PagePeer::NAME)) $criteria->add(PagePeer::NAME, $this->name);
		if ($this->isColumnModified(PagePeer::PAGE_TYPE)) $criteria->add(PagePeer::PAGE_TYPE, $this->page_type);
		if ($this->isColumnModified(PagePeer::TEMPLATE_NAME)) $criteria->add(PagePeer::TEMPLATE_NAME, $this->template_name);
		if ($this->isColumnModified(PagePeer::IS_INACTIVE)) $criteria->add(PagePeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(PagePeer::IS_FOLDER)) $criteria->add(PagePeer::IS_FOLDER, $this->is_folder);
		if ($this->isColumnModified(PagePeer::IS_HIDDEN)) $criteria->add(PagePeer::IS_HIDDEN, $this->is_hidden);
		if ($this->isColumnModified(PagePeer::IS_PROTECTED)) $criteria->add(PagePeer::IS_PROTECTED, $this->is_protected);
		if ($this->isColumnModified(PagePeer::CREATED_BY)) $criteria->add(PagePeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(PagePeer::UPDATED_BY)) $criteria->add(PagePeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(PagePeer::CREATED_AT)) $criteria->add(PagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PagePeer::UPDATED_AT)) $criteria->add(PagePeer::UPDATED_AT, $this->updated_at);

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

		$copyObj->setParentId($this->parent_id);

		$copyObj->setSort($this->sort);

		$copyObj->setName($this->name);

		$copyObj->setPageType($this->page_type);

		$copyObj->setTemplateName($this->template_name);

		$copyObj->setIsInactive($this->is_inactive);

		$copyObj->setIsFolder($this->is_folder);

		$copyObj->setIsHidden($this->is_hidden);

		$copyObj->setIsProtected($this->is_protected);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPagesRelatedByParentId() as $relObj) {
				if($this->getPrimaryKey() === $relObj->getPrimaryKey()) {
						continue;
				}

				$copyObj->addPageRelatedByParentId($relObj->copy($deepCopy));
			}

			foreach($this->getPagePropertys() as $relObj) {
				$copyObj->addPageProperty($relObj->copy($deepCopy));
			}

			foreach($this->getPageStrings() as $relObj) {
				$copyObj->addPageString($relObj->copy($deepCopy));
			}

			foreach($this->getContentObjects() as $relObj) {
				$copyObj->addContentObject($relObj->copy($deepCopy));
			}

			foreach($this->getRights() as $relObj) {
				$copyObj->addRight($relObj->copy($deepCopy));
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
	 * Declares an association between this object and a Page object.
	 *
	 * @param      Page $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setPageRelatedByParentId($v)
	{


		if ($v === null) {
			$this->setParentId(NULL);
		} else {
			$this->setParentId($v->getId());
		}


		$this->aPageRelatedByParentId = $v;
	}


	/**
	 * Get the associated Page object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Page The associated Page object.
	 * @throws     PropelException
	 */
	public function getPageRelatedByParentId($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BasePagePeer.php';

		if ($this->aPageRelatedByParentId === null && ($this->parent_id !== null)) {

			$this->aPageRelatedByParentId = PagePeer::retrieveByPK($this->parent_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = PagePeer::retrieveByPK($this->parent_id, $con);
			   $obj->addPagesRelatedByParentId($this);
			 */
		}
		return $this->aPageRelatedByParentId;
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
	 * Temporary storage of collPagesRelatedByParentId to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPagesRelatedByParentId()
	{
		if ($this->collPagesRelatedByParentId === null) {
			$this->collPagesRelatedByParentId = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page has previously
	 * been saved, it will retrieve related PagesRelatedByParentId from storage.
	 * If this Page is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPagesRelatedByParentId($criteria = null, $con = null)
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

		if ($this->collPagesRelatedByParentId === null) {
			if ($this->isNew()) {
			   $this->collPagesRelatedByParentId = array();
			} else {

				$criteria->add(PagePeer::PARENT_ID, $this->getId());

				PagePeer::addSelectColumns($criteria);
				$this->collPagesRelatedByParentId = PagePeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PagePeer::PARENT_ID, $this->getId());

				PagePeer::addSelectColumns($criteria);
				if (!isset($this->lastPageRelatedByParentIdCriteria) || !$this->lastPageRelatedByParentIdCriteria->equals($criteria)) {
					$this->collPagesRelatedByParentId = PagePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPageRelatedByParentIdCriteria = $criteria;
		return $this->collPagesRelatedByParentId;
	}

	/**
	 * Returns the number of related PagesRelatedByParentId.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPagesRelatedByParentId($criteria = null, $distinct = false, $con = null)
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

		$criteria->add(PagePeer::PARENT_ID, $this->getId());

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
	public function addPageRelatedByParentId(Page $l)
	{
		$this->collPagesRelatedByParentId[] = $l;
		$l->setPageRelatedByParentId($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PagesRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 */
	public function getPagesRelatedByParentIdJoinUserRelatedByCreatedBy($criteria = null, $con = null)
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

		if ($this->collPagesRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collPagesRelatedByParentId = array();
			} else {

				$criteria->add(PagePeer::PARENT_ID, $this->getId());

				$this->collPagesRelatedByParentId = PagePeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PagePeer::PARENT_ID, $this->getId());

			if (!isset($this->lastPageRelatedByParentIdCriteria) || !$this->lastPageRelatedByParentIdCriteria->equals($criteria)) {
				$this->collPagesRelatedByParentId = PagePeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		}
		$this->lastPageRelatedByParentIdCriteria = $criteria;

		return $this->collPagesRelatedByParentId;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page is new, it will return
	 * an empty collection; or if this Page has previously
	 * been saved, it will retrieve related PagesRelatedByParentId from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Page.
	 */
	public function getPagesRelatedByParentIdJoinUserRelatedByUpdatedBy($criteria = null, $con = null)
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

		if ($this->collPagesRelatedByParentId === null) {
			if ($this->isNew()) {
				$this->collPagesRelatedByParentId = array();
			} else {

				$criteria->add(PagePeer::PARENT_ID, $this->getId());

				$this->collPagesRelatedByParentId = PagePeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PagePeer::PARENT_ID, $this->getId());

			if (!isset($this->lastPageRelatedByParentIdCriteria) || !$this->lastPageRelatedByParentIdCriteria->equals($criteria)) {
				$this->collPagesRelatedByParentId = PagePeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		}
		$this->lastPageRelatedByParentIdCriteria = $criteria;

		return $this->collPagesRelatedByParentId;
	}

	/**
	 * Temporary storage of collPagePropertys to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPagePropertys()
	{
		if ($this->collPagePropertys === null) {
			$this->collPagePropertys = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page has previously
	 * been saved, it will retrieve related PagePropertys from storage.
	 * If this Page is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPagePropertys($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePropertyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPagePropertys === null) {
			if ($this->isNew()) {
			   $this->collPagePropertys = array();
			} else {

				$criteria->add(PagePropertyPeer::PAGE_ID, $this->getId());

				PagePropertyPeer::addSelectColumns($criteria);
				$this->collPagePropertys = PagePropertyPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PagePropertyPeer::PAGE_ID, $this->getId());

				PagePropertyPeer::addSelectColumns($criteria);
				if (!isset($this->lastPagePropertyCriteria) || !$this->lastPagePropertyCriteria->equals($criteria)) {
					$this->collPagePropertys = PagePropertyPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPagePropertyCriteria = $criteria;
		return $this->collPagePropertys;
	}

	/**
	 * Returns the number of related PagePropertys.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPagePropertys($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePagePropertyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PagePropertyPeer::PAGE_ID, $this->getId());

		return PagePropertyPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PageProperty object to this object
	 * through the PageProperty foreign key attribute
	 *
	 * @param      PageProperty $l PageProperty
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPageProperty(PageProperty $l)
	{
		$this->collPagePropertys[] = $l;
		$l->setPage($this);
	}

	/**
	 * Temporary storage of collPageStrings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initPageStrings()
	{
		if ($this->collPageStrings === null) {
			$this->collPageStrings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page has previously
	 * been saved, it will retrieve related PageStrings from storage.
	 * If this Page is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getPageStrings($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePageStringPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPageStrings === null) {
			if ($this->isNew()) {
			   $this->collPageStrings = array();
			} else {

				$criteria->add(PageStringPeer::PAGE_ID, $this->getId());

				PageStringPeer::addSelectColumns($criteria);
				$this->collPageStrings = PageStringPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PageStringPeer::PAGE_ID, $this->getId());

				PageStringPeer::addSelectColumns($criteria);
				if (!isset($this->lastPageStringCriteria) || !$this->lastPageStringCriteria->equals($criteria)) {
					$this->collPageStrings = PageStringPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastPageStringCriteria = $criteria;
		return $this->collPageStrings;
	}

	/**
	 * Returns the number of related PageStrings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countPageStrings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePageStringPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(PageStringPeer::PAGE_ID, $this->getId());

		return PageStringPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a PageString object to this object
	 * through the PageString foreign key attribute
	 *
	 * @param      PageString $l PageString
	 * @return     void
	 * @throws     PropelException
	 */
	public function addPageString(PageString $l)
	{
		$this->collPageStrings[] = $l;
		$l->setPage($this);
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
	 */
	public function getPageStringsJoinLanguage($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BasePageStringPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collPageStrings === null) {
			if ($this->isNew()) {
				$this->collPageStrings = array();
			} else {

				$criteria->add(PageStringPeer::PAGE_ID, $this->getId());

				$this->collPageStrings = PageStringPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PageStringPeer::PAGE_ID, $this->getId());

			if (!isset($this->lastPageStringCriteria) || !$this->lastPageStringCriteria->equals($criteria)) {
				$this->collPageStrings = PageStringPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastPageStringCriteria = $criteria;

		return $this->collPageStrings;
	}

	/**
	 * Temporary storage of collContentObjects to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initContentObjects()
	{
		if ($this->collContentObjects === null) {
			$this->collContentObjects = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page has previously
	 * been saved, it will retrieve related ContentObjects from storage.
	 * If this Page is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getContentObjects($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseContentObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collContentObjects === null) {
			if ($this->isNew()) {
			   $this->collContentObjects = array();
			} else {

				$criteria->add(ContentObjectPeer::PAGE_ID, $this->getId());

				ContentObjectPeer::addSelectColumns($criteria);
				$this->collContentObjects = ContentObjectPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(ContentObjectPeer::PAGE_ID, $this->getId());

				ContentObjectPeer::addSelectColumns($criteria);
				if (!isset($this->lastContentObjectCriteria) || !$this->lastContentObjectCriteria->equals($criteria)) {
					$this->collContentObjects = ContentObjectPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastContentObjectCriteria = $criteria;
		return $this->collContentObjects;
	}

	/**
	 * Returns the number of related ContentObjects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countContentObjects($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseContentObjectPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ContentObjectPeer::PAGE_ID, $this->getId());

		return ContentObjectPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a ContentObject object to this object
	 * through the ContentObject foreign key attribute
	 *
	 * @param      ContentObject $l ContentObject
	 * @return     void
	 * @throws     PropelException
	 */
	public function addContentObject(ContentObject $l)
	{
		$this->collContentObjects[] = $l;
		$l->setPage($this);
	}

	/**
	 * Temporary storage of collRights to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initRights()
	{
		if ($this->collRights === null) {
			$this->collRights = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Page has previously
	 * been saved, it will retrieve related Rights from storage.
	 * If this Page is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getRights($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseRightPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRights === null) {
			if ($this->isNew()) {
			   $this->collRights = array();
			} else {

				$criteria->add(RightPeer::PAGE_ID, $this->getId());

				RightPeer::addSelectColumns($criteria);
				$this->collRights = RightPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(RightPeer::PAGE_ID, $this->getId());

				RightPeer::addSelectColumns($criteria);
				if (!isset($this->lastRightCriteria) || !$this->lastRightCriteria->equals($criteria)) {
					$this->collRights = RightPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastRightCriteria = $criteria;
		return $this->collRights;
	}

	/**
	 * Returns the number of related Rights.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countRights($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseRightPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(RightPeer::PAGE_ID, $this->getId());

		return RightPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a Right object to this object
	 * through the Right foreign key attribute
	 *
	 * @param      Right $l Right
	 * @return     void
	 * @throws     PropelException
	 */
	public function addRight(Right $l)
	{
		$this->collRights[] = $l;
		$l->setPage($this);
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
	 */
	public function getRightsJoinGroup($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseRightPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collRights === null) {
			if ($this->isNew()) {
				$this->collRights = array();
			} else {

				$criteria->add(RightPeer::PAGE_ID, $this->getId());

				$this->collRights = RightPeer::doSelectJoinGroup($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(RightPeer::PAGE_ID, $this->getId());

			if (!isset($this->lastRightCriteria) || !$this->lastRightCriteria->equals($criteria)) {
				$this->collRights = RightPeer::doSelectJoinGroup($criteria, $con);
			}
		}
		$this->lastRightCriteria = $criteria;

		return $this->collRights;
	}

} // BasePage
