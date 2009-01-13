<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/LinkPeer.php';

/**
 * Base class that represents a row from the 'links' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseLink extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        LinkPeer
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
	 * The value for the url field.
	 * @var        string
	 */
	protected $url;


	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;


	/**
	 * The value for the language_id field.
	 * @var        string
	 */
	protected $language_id;


	/**
	 * The value for the owner_id field.
	 * @var        int
	 */
	protected $owner_id;


	/**
	 * The value for the document_category_id field.
	 * @var        int
	 */
	protected $document_category_id;


	/**
	 * The value for the is_private field.
	 * @var        boolean
	 */
	protected $is_private = false;


	/**
	 * The value for the is_inactive field.
	 * @var        boolean
	 */
	protected $is_inactive = false;


	/**
	 * The value for the created_by field.
	 * @var        int
	 */
	protected $created_by;


	/**
	 * The value for the created_at field.
	 * @var        int
	 */
	protected $created_at;


	/**
	 * The value for the updated_by field.
	 * @var        int
	 */
	protected $updated_by;


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
	protected $aUserRelatedByOwnerId;

	/**
	 * @var        DocumentCategory
	 */
	protected $aDocumentCategory;

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
	 * Get the [url] column value.
	 * 
	 * @return     string
	 */
	public function getUrl()
	{

		return $this->url;
	}

	/**
	 * Get the [description] column value.
	 * 
	 * @return     string
	 */
	public function getDescription()
	{

		return $this->description;
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
	 * Get the [owner_id] column value.
	 * 
	 * @return     int
	 */
	public function getOwnerId()
	{

		return $this->owner_id;
	}

	/**
	 * Get the [document_category_id] column value.
	 * 
	 * @return     int
	 */
	public function getDocumentCategoryId()
	{

		return $this->document_category_id;
	}

	/**
	 * Get the [is_private] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsPrivate()
	{

		return $this->is_private;
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
	 * Get the [created_by] column value.
	 * 
	 * @return     int
	 */
	public function getCreatedBy()
	{

		return $this->created_by;
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
	 * Get the [updated_by] column value.
	 * 
	 * @return     int
	 */
	public function getUpdatedBy()
	{

		return $this->updated_by;
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
			$this->modifiedColumns[] = LinkPeer::ID;
		}

	} // setId()

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
			$this->modifiedColumns[] = LinkPeer::NAME;
		}

	} // setName()

	/**
	 * Set the value of [url] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setUrl($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = LinkPeer::URL;
		}

	} // setUrl()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setDescription($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = LinkPeer::DESCRIPTION;
		}

	} // setDescription()

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
			$this->modifiedColumns[] = LinkPeer::LANGUAGE_ID;
		}

		if ($this->aLanguage !== null && $this->aLanguage->getId() !== $v) {
			$this->aLanguage = null;
		}

	} // setLanguageId()

	/**
	 * Set the value of [owner_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setOwnerId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->owner_id !== $v) {
			$this->owner_id = $v;
			$this->modifiedColumns[] = LinkPeer::OWNER_ID;
		}

		if ($this->aUserRelatedByOwnerId !== null && $this->aUserRelatedByOwnerId->getId() !== $v) {
			$this->aUserRelatedByOwnerId = null;
		}

	} // setOwnerId()

	/**
	 * Set the value of [document_category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setDocumentCategoryId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->document_category_id !== $v) {
			$this->document_category_id = $v;
			$this->modifiedColumns[] = LinkPeer::DOCUMENT_CATEGORY_ID;
		}

		if ($this->aDocumentCategory !== null && $this->aDocumentCategory->getId() !== $v) {
			$this->aDocumentCategory = null;
		}

	} // setDocumentCategoryId()

	/**
	 * Set the value of [is_private] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsPrivate($v)
	{

		if ($this->is_private !== $v || $v === false) {
			$this->is_private = $v;
			$this->modifiedColumns[] = LinkPeer::IS_PRIVATE;
		}

	} // setIsPrivate()

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
			$this->modifiedColumns[] = LinkPeer::IS_INACTIVE;
		}

	} // setIsInactive()

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
			$this->modifiedColumns[] = LinkPeer::CREATED_BY;
		}

		if ($this->aUserRelatedByCreatedBy !== null && $this->aUserRelatedByCreatedBy->getId() !== $v) {
			$this->aUserRelatedByCreatedBy = null;
		}

	} // setCreatedBy()

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
			$this->modifiedColumns[] = LinkPeer::CREATED_AT;
		}

	} // setCreatedAt()

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
			$this->modifiedColumns[] = LinkPeer::UPDATED_BY;
		}

		if ($this->aUserRelatedByUpdatedBy !== null && $this->aUserRelatedByUpdatedBy->getId() !== $v) {
			$this->aUserRelatedByUpdatedBy = null;
		}

	} // setUpdatedBy()

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
			$this->modifiedColumns[] = LinkPeer::UPDATED_AT;
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

			$this->name = $rs->getString($startcol + 1);

			$this->url = $rs->getString($startcol + 2);

			$this->description = $rs->getString($startcol + 3);

			$this->language_id = $rs->getString($startcol + 4);

			$this->owner_id = $rs->getInt($startcol + 5);

			$this->document_category_id = $rs->getInt($startcol + 6);

			$this->is_private = $rs->getBoolean($startcol + 7);

			$this->is_inactive = $rs->getBoolean($startcol + 8);

			$this->created_by = $rs->getInt($startcol + 9);

			$this->created_at = $rs->getTimestamp($startcol + 10, null);

			$this->updated_by = $rs->getInt($startcol + 11);

			$this->updated_at = $rs->getTimestamp($startcol + 12, null);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 13; // 13 = LinkPeer::NUM_COLUMNS - LinkPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Link object", $e);
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
			$con = Propel::getConnection(LinkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			LinkPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(LinkPeer::DATABASE_NAME);
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

			if ($this->aUserRelatedByOwnerId !== null) {
				if ($this->aUserRelatedByOwnerId->isModified()) {
					$affectedRows += $this->aUserRelatedByOwnerId->save($con);
				}
				$this->setUserRelatedByOwnerId($this->aUserRelatedByOwnerId);
			}

			if ($this->aDocumentCategory !== null) {
				if ($this->aDocumentCategory->isModified()) {
					$affectedRows += $this->aDocumentCategory->save($con);
				}
				$this->setDocumentCategory($this->aDocumentCategory);
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
					$pk = LinkPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += LinkPeer::doUpdate($this, $con);
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

			if ($this->aLanguage !== null) {
				if (!$this->aLanguage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aLanguage->getValidationFailures());
				}
			}

			if ($this->aUserRelatedByOwnerId !== null) {
				if (!$this->aUserRelatedByOwnerId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aUserRelatedByOwnerId->getValidationFailures());
				}
			}

			if ($this->aDocumentCategory !== null) {
				if (!$this->aDocumentCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDocumentCategory->getValidationFailures());
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


			if (($retval = LinkPeer::doValidate($this, $columns)) !== true) {
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
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = LinkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getName();
				break;
			case 2:
				return $this->getUrl();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getLanguageId();
				break;
			case 5:
				return $this->getOwnerId();
				break;
			case 6:
				return $this->getDocumentCategoryId();
				break;
			case 7:
				return $this->getIsPrivate();
				break;
			case 8:
				return $this->getIsInactive();
				break;
			case 9:
				return $this->getCreatedBy();
				break;
			case 10:
				return $this->getCreatedAt();
				break;
			case 11:
				return $this->getUpdatedBy();
				break;
			case 12:
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
		$keys = LinkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getUrl(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getLanguageId(),
			$keys[5] => $this->getOwnerId(),
			$keys[6] => $this->getDocumentCategoryId(),
			$keys[7] => $this->getIsPrivate(),
			$keys[8] => $this->getIsInactive(),
			$keys[9] => $this->getCreatedBy(),
			$keys[10] => $this->getCreatedAt(),
			$keys[11] => $this->getUpdatedBy(),
			$keys[12] => $this->getUpdatedAt(),
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
		$pos = LinkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setUrl($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setLanguageId($value);
				break;
			case 5:
				$this->setOwnerId($value);
				break;
			case 6:
				$this->setDocumentCategoryId($value);
				break;
			case 7:
				$this->setIsPrivate($value);
				break;
			case 8:
				$this->setIsInactive($value);
				break;
			case 9:
				$this->setCreatedBy($value);
				break;
			case 10:
				$this->setCreatedAt($value);
				break;
			case 11:
				$this->setUpdatedBy($value);
				break;
			case 12:
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
		$keys = LinkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setUrl($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLanguageId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setOwnerId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDocumentCategoryId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsPrivate($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsInactive($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setCreatedBy($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedAt($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUpdatedBy($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUpdatedAt($arr[$keys[12]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(LinkPeer::DATABASE_NAME);

		if ($this->isColumnModified(LinkPeer::ID)) $criteria->add(LinkPeer::ID, $this->id);
		if ($this->isColumnModified(LinkPeer::NAME)) $criteria->add(LinkPeer::NAME, $this->name);
		if ($this->isColumnModified(LinkPeer::URL)) $criteria->add(LinkPeer::URL, $this->url);
		if ($this->isColumnModified(LinkPeer::DESCRIPTION)) $criteria->add(LinkPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(LinkPeer::LANGUAGE_ID)) $criteria->add(LinkPeer::LANGUAGE_ID, $this->language_id);
		if ($this->isColumnModified(LinkPeer::OWNER_ID)) $criteria->add(LinkPeer::OWNER_ID, $this->owner_id);
		if ($this->isColumnModified(LinkPeer::DOCUMENT_CATEGORY_ID)) $criteria->add(LinkPeer::DOCUMENT_CATEGORY_ID, $this->document_category_id);
		if ($this->isColumnModified(LinkPeer::IS_PRIVATE)) $criteria->add(LinkPeer::IS_PRIVATE, $this->is_private);
		if ($this->isColumnModified(LinkPeer::IS_INACTIVE)) $criteria->add(LinkPeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(LinkPeer::CREATED_BY)) $criteria->add(LinkPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(LinkPeer::CREATED_AT)) $criteria->add(LinkPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(LinkPeer::UPDATED_BY)) $criteria->add(LinkPeer::UPDATED_BY, $this->updated_by);
		if ($this->isColumnModified(LinkPeer::UPDATED_AT)) $criteria->add(LinkPeer::UPDATED_AT, $this->updated_at);

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
		$criteria = new Criteria(LinkPeer::DATABASE_NAME);

		$criteria->add(LinkPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Link (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setUrl($this->url);

		$copyObj->setDescription($this->description);

		$copyObj->setLanguageId($this->language_id);

		$copyObj->setOwnerId($this->owner_id);

		$copyObj->setDocumentCategoryId($this->document_category_id);

		$copyObj->setIsPrivate($this->is_private);

		$copyObj->setIsInactive($this->is_inactive);

		$copyObj->setCreatedBy($this->created_by);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedBy($this->updated_by);

		$copyObj->setUpdatedAt($this->updated_at);


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
	 * @return     Link Clone of current object.
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
	 * @return     LinkPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new LinkPeer();
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
	public function setUserRelatedByOwnerId($v)
	{


		if ($v === null) {
			$this->setOwnerId(NULL);
		} else {
			$this->setOwnerId($v->getId());
		}


		$this->aUserRelatedByOwnerId = $v;
	}


	/**
	 * Get the associated User object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     User The associated User object.
	 * @throws     PropelException
	 */
	public function getUserRelatedByOwnerId($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BaseUserPeer.php';

		if ($this->aUserRelatedByOwnerId === null && ($this->owner_id !== null)) {

			$this->aUserRelatedByOwnerId = UserPeer::retrieveByPK($this->owner_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = UserPeer::retrieveByPK($this->owner_id, $con);
			   $obj->addUsersRelatedByOwnerId($this);
			 */
		}
		return $this->aUserRelatedByOwnerId;
	}

	/**
	 * Declares an association between this object and a DocumentCategory object.
	 *
	 * @param      DocumentCategory $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setDocumentCategory($v)
	{


		if ($v === null) {
			$this->setDocumentCategoryId(NULL);
		} else {
			$this->setDocumentCategoryId($v->getId());
		}


		$this->aDocumentCategory = $v;
	}


	/**
	 * Get the associated DocumentCategory object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     DocumentCategory The associated DocumentCategory object.
	 * @throws     PropelException
	 */
	public function getDocumentCategory($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BaseDocumentCategoryPeer.php';

		if ($this->aDocumentCategory === null && ($this->document_category_id !== null)) {

			$this->aDocumentCategory = DocumentCategoryPeer::retrieveByPK($this->document_category_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = DocumentCategoryPeer::retrieveByPK($this->document_category_id, $con);
			   $obj->addDocumentCategorys($this);
			 */
		}
		return $this->aDocumentCategory;
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

} // BaseLink
