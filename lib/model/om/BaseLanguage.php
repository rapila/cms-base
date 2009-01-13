<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/LanguagePeer.php';

/**
 * Base class that represents a row from the 'languages' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseLanguage extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        LanguagePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        string
	 */
	protected $id;


	/**
	 * The value for the is_active field.
	 * @var        boolean
	 */
	protected $is_active;


	/**
	 * The value for the sort field.
	 * @var        int
	 */
	protected $sort;

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
	 * Collection to store aggregation of collLanguageObjects.
	 * @var        array
	 */
	protected $collLanguageObjects;

	/**
	 * The criteria used to select the current contents of collLanguageObjects.
	 * @var        Criteria
	 */
	protected $lastLanguageObjectCriteria = null;

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
	 * Collection to store aggregation of collStrings.
	 * @var        array
	 */
	protected $collStrings;

	/**
	 * The criteria used to select the current contents of collStrings.
	 * @var        Criteria
	 */
	protected $lastStringCriteria = null;

	/**
	 * Collection to store aggregation of collUsers.
	 * @var        array
	 */
	protected $collUsers;

	/**
	 * The criteria used to select the current contents of collUsers.
	 * @var        Criteria
	 */
	protected $lastUserCriteria = null;

	/**
	 * Collection to store aggregation of collDocuments.
	 * @var        array
	 */
	protected $collDocuments;

	/**
	 * The criteria used to select the current contents of collDocuments.
	 * @var        Criteria
	 */
	protected $lastDocumentCriteria = null;

	/**
	 * Collection to store aggregation of collLinks.
	 * @var        array
	 */
	protected $collLinks;

	/**
	 * The criteria used to select the current contents of collLinks.
	 * @var        Criteria
	 */
	protected $lastLinkCriteria = null;

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
	 * @return     string
	 */
	public function getId()
	{

		return $this->id;
	}

	/**
	 * Get the [is_active] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsActive()
	{

		return $this->is_active;
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
	 * Set the value of [id] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setId($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = LanguagePeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [is_active] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsActive($v)
	{

		if ($this->is_active !== $v) {
			$this->is_active = $v;
			$this->modifiedColumns[] = LanguagePeer::IS_ACTIVE;
		}

	} // setIsActive()

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
			$this->modifiedColumns[] = LanguagePeer::SORT;
		}

	} // setSort()

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

			$this->id = $rs->getString($startcol + 0);

			$this->is_active = $rs->getBoolean($startcol + 1);

			$this->sort = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 3; // 3 = LanguagePeer::NUM_COLUMNS - LanguagePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Language object", $e);
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
			$con = Propel::getConnection(LanguagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			LanguagePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(LanguagePeer::DATABASE_NAME);
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


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = LanguagePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += LanguagePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collPageStrings !== null) {
				foreach($this->collPageStrings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLanguageObjects !== null) {
				foreach($this->collLanguageObjects as $referrerFK) {
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

			if ($this->collStrings !== null) {
				foreach($this->collStrings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collUsers !== null) {
				foreach($this->collUsers as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collDocuments !== null) {
				foreach($this->collDocuments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collLinks !== null) {
				foreach($this->collLinks as $referrerFK) {
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


			if (($retval = LanguagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collPageStrings !== null) {
					foreach($this->collPageStrings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLanguageObjects !== null) {
					foreach($this->collLanguageObjects as $referrerFK) {
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

				if ($this->collStrings !== null) {
					foreach($this->collStrings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collUsers !== null) {
					foreach($this->collUsers as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collDocuments !== null) {
					foreach($this->collDocuments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collLinks !== null) {
					foreach($this->collLinks as $referrerFK) {
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
		$pos = LanguagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIsActive();
				break;
			case 2:
				return $this->getSort();
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
		$keys = LanguagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getIsActive(),
			$keys[2] => $this->getSort(),
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
		$pos = LanguagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setIsActive($value);
				break;
			case 2:
				$this->setSort($value);
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
		$keys = LanguagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIsActive($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSort($arr[$keys[2]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(LanguagePeer::DATABASE_NAME);

		if ($this->isColumnModified(LanguagePeer::ID)) $criteria->add(LanguagePeer::ID, $this->id);
		if ($this->isColumnModified(LanguagePeer::IS_ACTIVE)) $criteria->add(LanguagePeer::IS_ACTIVE, $this->is_active);
		if ($this->isColumnModified(LanguagePeer::SORT)) $criteria->add(LanguagePeer::SORT, $this->sort);

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
		$criteria = new Criteria(LanguagePeer::DATABASE_NAME);

		$criteria->add(LanguagePeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     string
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      string $key Primary key.
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
	 * @param      object $copyObj An object of Language (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIsActive($this->is_active);

		$copyObj->setSort($this->sort);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getPageStrings() as $relObj) {
				$copyObj->addPageString($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageObjects() as $relObj) {
				$copyObj->addLanguageObject($relObj->copy($deepCopy));
			}

			foreach($this->getLanguageObjectHistorys() as $relObj) {
				$copyObj->addLanguageObjectHistory($relObj->copy($deepCopy));
			}

			foreach($this->getStrings() as $relObj) {
				$copyObj->addString($relObj->copy($deepCopy));
			}

			foreach($this->getUsers() as $relObj) {
				$copyObj->addUser($relObj->copy($deepCopy));
			}

			foreach($this->getDocuments() as $relObj) {
				$copyObj->addDocument($relObj->copy($deepCopy));
			}

			foreach($this->getLinks() as $relObj) {
				$copyObj->addLink($relObj->copy($deepCopy));
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
	 * @return     Language Clone of current object.
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
	 * @return     LanguagePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new LanguagePeer();
		}
		return self::$peer;
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
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related PageStrings from storage.
	 * If this Language is new, it will return
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

				$criteria->add(PageStringPeer::LANGUAGE_ID, $this->getId());

				PageStringPeer::addSelectColumns($criteria);
				$this->collPageStrings = PageStringPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(PageStringPeer::LANGUAGE_ID, $this->getId());

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

		$criteria->add(PageStringPeer::LANGUAGE_ID, $this->getId());

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
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related PageStrings from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getPageStringsJoinPage($criteria = null, $con = null)
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

				$criteria->add(PageStringPeer::LANGUAGE_ID, $this->getId());

				$this->collPageStrings = PageStringPeer::doSelectJoinPage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(PageStringPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastPageStringCriteria) || !$this->lastPageStringCriteria->equals($criteria)) {
				$this->collPageStrings = PageStringPeer::doSelectJoinPage($criteria, $con);
			}
		}
		$this->lastPageStringCriteria = $criteria;

		return $this->collPageStrings;
	}

	/**
	 * Temporary storage of collLanguageObjects to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLanguageObjects()
	{
		if ($this->collLanguageObjects === null) {
			$this->collLanguageObjects = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related LanguageObjects from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLanguageObjects($criteria = null, $con = null)
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

		if ($this->collLanguageObjects === null) {
			if ($this->isNew()) {
			   $this->collLanguageObjects = array();
			} else {

				$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

				LanguageObjectPeer::addSelectColumns($criteria);
				$this->collLanguageObjects = LanguageObjectPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

				LanguageObjectPeer::addSelectColumns($criteria);
				if (!isset($this->lastLanguageObjectCriteria) || !$this->lastLanguageObjectCriteria->equals($criteria)) {
					$this->collLanguageObjects = LanguageObjectPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLanguageObjectCriteria = $criteria;
		return $this->collLanguageObjects;
	}

	/**
	 * Returns the number of related LanguageObjects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLanguageObjects($criteria = null, $distinct = false, $con = null)
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

		$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

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
	public function addLanguageObject(LanguageObject $l)
	{
		$this->collLanguageObjects[] = $l;
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related LanguageObjects from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLanguageObjectsJoinContentObject($criteria = null, $con = null)
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

		if ($this->collLanguageObjects === null) {
			if ($this->isNew()) {
				$this->collLanguageObjects = array();
			} else {

				$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

				$this->collLanguageObjects = LanguageObjectPeer::doSelectJoinContentObject($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLanguageObjectCriteria) || !$this->lastLanguageObjectCriteria->equals($criteria)) {
				$this->collLanguageObjects = LanguageObjectPeer::doSelectJoinContentObject($criteria, $con);
			}
		}
		$this->lastLanguageObjectCriteria = $criteria;

		return $this->collLanguageObjects;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related LanguageObjects from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLanguageObjectsJoinUserRelatedByCreatedBy($criteria = null, $con = null)
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

		if ($this->collLanguageObjects === null) {
			if ($this->isNew()) {
				$this->collLanguageObjects = array();
			} else {

				$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

				$this->collLanguageObjects = LanguageObjectPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLanguageObjectCriteria) || !$this->lastLanguageObjectCriteria->equals($criteria)) {
				$this->collLanguageObjects = LanguageObjectPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		}
		$this->lastLanguageObjectCriteria = $criteria;

		return $this->collLanguageObjects;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related LanguageObjects from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLanguageObjectsJoinUserRelatedByUpdatedBy($criteria = null, $con = null)
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

		if ($this->collLanguageObjects === null) {
			if ($this->isNew()) {
				$this->collLanguageObjects = array();
			} else {

				$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

				$this->collLanguageObjects = LanguageObjectPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLanguageObjectCriteria) || !$this->lastLanguageObjectCriteria->equals($criteria)) {
				$this->collLanguageObjects = LanguageObjectPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		}
		$this->lastLanguageObjectCriteria = $criteria;

		return $this->collLanguageObjects;
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
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related LanguageObjectHistorys from storage.
	 * If this Language is new, it will return
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

				$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

				LanguageObjectHistoryPeer::addSelectColumns($criteria);
				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

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

		$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

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
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related LanguageObjectHistorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
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

				$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinContentObject($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

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
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related LanguageObjectHistorys from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLanguageObjectHistorysJoinUser($criteria = null, $con = null)
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

				$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinUser($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LanguageObjectHistoryPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLanguageObjectHistoryCriteria) || !$this->lastLanguageObjectHistoryCriteria->equals($criteria)) {
				$this->collLanguageObjectHistorys = LanguageObjectHistoryPeer::doSelectJoinUser($criteria, $con);
			}
		}
		$this->lastLanguageObjectHistoryCriteria = $criteria;

		return $this->collLanguageObjectHistorys;
	}

	/**
	 * Temporary storage of collStrings to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initStrings()
	{
		if ($this->collStrings === null) {
			$this->collStrings = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related Strings from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getStrings($criteria = null, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseStringPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collStrings === null) {
			if ($this->isNew()) {
			   $this->collStrings = array();
			} else {

				$criteria->add(StringPeer::LANGUAGE_ID, $this->getId());

				StringPeer::addSelectColumns($criteria);
				$this->collStrings = StringPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(StringPeer::LANGUAGE_ID, $this->getId());

				StringPeer::addSelectColumns($criteria);
				if (!isset($this->lastStringCriteria) || !$this->lastStringCriteria->equals($criteria)) {
					$this->collStrings = StringPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastStringCriteria = $criteria;
		return $this->collStrings;
	}

	/**
	 * Returns the number of related Strings.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countStrings($criteria = null, $distinct = false, $con = null)
	{
		// include the Peer class
		include_once 'model/om/BaseStringPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(StringPeer::LANGUAGE_ID, $this->getId());

		return StringPeer::doCount($criteria, $distinct, $con);
	}

	/**
	 * Method called to associate a String object to this object
	 * through the String foreign key attribute
	 *
	 * @param      String $l String
	 * @return     void
	 * @throws     PropelException
	 */
	public function addString(String $l)
	{
		$this->collStrings[] = $l;
		$l->setLanguage($this);
	}

	/**
	 * Temporary storage of collUsers to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initUsers()
	{
		if ($this->collUsers === null) {
			$this->collUsers = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related Users from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getUsers($criteria = null, $con = null)
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

		if ($this->collUsers === null) {
			if ($this->isNew()) {
			   $this->collUsers = array();
			} else {

				$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

				UserPeer::addSelectColumns($criteria);
				$this->collUsers = UserPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

				UserPeer::addSelectColumns($criteria);
				if (!isset($this->lastUserCriteria) || !$this->lastUserCriteria->equals($criteria)) {
					$this->collUsers = UserPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastUserCriteria = $criteria;
		return $this->collUsers;
	}

	/**
	 * Returns the number of related Users.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countUsers($criteria = null, $distinct = false, $con = null)
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

		$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

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
	public function addUser(User $l)
	{
		$this->collUsers[] = $l;
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Users from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getUsersJoinUserRelatedByCreatedBy($criteria = null, $con = null)
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

		if ($this->collUsers === null) {
			if ($this->isNew()) {
				$this->collUsers = array();
			} else {

				$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

				$this->collUsers = UserPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastUserCriteria) || !$this->lastUserCriteria->equals($criteria)) {
				$this->collUsers = UserPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		}
		$this->lastUserCriteria = $criteria;

		return $this->collUsers;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Users from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getUsersJoinUserRelatedByUpdatedBy($criteria = null, $con = null)
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

		if ($this->collUsers === null) {
			if ($this->isNew()) {
				$this->collUsers = array();
			} else {

				$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

				$this->collUsers = UserPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(UserPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastUserCriteria) || !$this->lastUserCriteria->equals($criteria)) {
				$this->collUsers = UserPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		}
		$this->lastUserCriteria = $criteria;

		return $this->collUsers;
	}

	/**
	 * Temporary storage of collDocuments to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initDocuments()
	{
		if ($this->collDocuments === null) {
			$this->collDocuments = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related Documents from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getDocuments($criteria = null, $con = null)
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

		if ($this->collDocuments === null) {
			if ($this->isNew()) {
			   $this->collDocuments = array();
			} else {

				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				$this->collDocuments = DocumentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
					$this->collDocuments = DocumentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastDocumentCriteria = $criteria;
		return $this->collDocuments;
	}

	/**
	 * Returns the number of related Documents.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countDocuments($criteria = null, $distinct = false, $con = null)
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

		$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

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
	public function addDocument(Document $l)
	{
		$this->collDocuments[] = $l;
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getDocumentsJoinUserRelatedByOwnerId($criteria = null, $con = null)
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

		if ($this->collDocuments === null) {
			if ($this->isNew()) {
				$this->collDocuments = array();
			} else {

				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByOwnerId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByOwnerId($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getDocumentsJoinDocumentType($criteria = null, $con = null)
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

		if ($this->collDocuments === null) {
			if ($this->isNew()) {
				$this->collDocuments = array();
			} else {

				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinDocumentType($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getDocumentsJoinDocumentCategory($criteria = null, $con = null)
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

		if ($this->collDocuments === null) {
			if ($this->isNew()) {
				$this->collDocuments = array();
			} else {

				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getDocumentsJoinUserRelatedByCreatedBy($criteria = null, $con = null)
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

		if ($this->collDocuments === null) {
			if ($this->isNew()) {
				$this->collDocuments = array();
			} else {

				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getDocumentsJoinUserRelatedByUpdatedBy($criteria = null, $con = null)
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

		if ($this->collDocuments === null) {
			if ($this->isNew()) {
				$this->collDocuments = array();
			} else {

				$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}

	/**
	 * Temporary storage of collLinks to save a possible db hit in
	 * the event objects are add to the collection, but the
	 * complete collection is never requested.
	 * @return     void
	 */
	public function initLinks()
	{
		if ($this->collLinks === null) {
			$this->collLinks = array();
		}
	}

	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language has previously
	 * been saved, it will retrieve related Links from storage.
	 * If this Language is new, it will return
	 * an empty collection or the current collection, the criteria
	 * is ignored on a new object.
	 *
	 * @param      Connection $con
	 * @param      Criteria $criteria
	 * @throws     PropelException
	 */
	public function getLinks($criteria = null, $con = null)
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

		if ($this->collLinks === null) {
			if ($this->isNew()) {
			   $this->collLinks = array();
			} else {

				$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				$this->collLinks = LinkPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

				LinkPeer::addSelectColumns($criteria);
				if (!isset($this->lastLinkCriteria) || !$this->lastLinkCriteria->equals($criteria)) {
					$this->collLinks = LinkPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastLinkCriteria = $criteria;
		return $this->collLinks;
	}

	/**
	 * Returns the number of related Links.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      Connection $con
	 * @throws     PropelException
	 */
	public function countLinks($criteria = null, $distinct = false, $con = null)
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

		$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

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
	public function addLink(Link $l)
	{
		$this->collLinks[] = $l;
		$l->setLanguage($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Links from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLinksJoinUserRelatedByOwnerId($criteria = null, $con = null)
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

		if ($this->collLinks === null) {
			if ($this->isNew()) {
				$this->collLinks = array();
			} else {

				$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

				$this->collLinks = LinkPeer::doSelectJoinUserRelatedByOwnerId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLinkCriteria) || !$this->lastLinkCriteria->equals($criteria)) {
				$this->collLinks = LinkPeer::doSelectJoinUserRelatedByOwnerId($criteria, $con);
			}
		}
		$this->lastLinkCriteria = $criteria;

		return $this->collLinks;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Links from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLinksJoinDocumentCategory($criteria = null, $con = null)
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

		if ($this->collLinks === null) {
			if ($this->isNew()) {
				$this->collLinks = array();
			} else {

				$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

				$this->collLinks = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLinkCriteria) || !$this->lastLinkCriteria->equals($criteria)) {
				$this->collLinks = LinkPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		}
		$this->lastLinkCriteria = $criteria;

		return $this->collLinks;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Links from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLinksJoinUserRelatedByCreatedBy($criteria = null, $con = null)
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

		if ($this->collLinks === null) {
			if ($this->isNew()) {
				$this->collLinks = array();
			} else {

				$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

				$this->collLinks = LinkPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLinkCriteria) || !$this->lastLinkCriteria->equals($criteria)) {
				$this->collLinks = LinkPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		}
		$this->lastLinkCriteria = $criteria;

		return $this->collLinks;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this Language is new, it will return
	 * an empty collection; or if this Language has previously
	 * been saved, it will retrieve related Links from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in Language.
	 */
	public function getLinksJoinUserRelatedByUpdatedBy($criteria = null, $con = null)
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

		if ($this->collLinks === null) {
			if ($this->isNew()) {
				$this->collLinks = array();
			} else {

				$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

				$this->collLinks = LinkPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(LinkPeer::LANGUAGE_ID, $this->getId());

			if (!isset($this->lastLinkCriteria) || !$this->lastLinkCriteria->equals($criteria)) {
				$this->collLinks = LinkPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		}
		$this->lastLinkCriteria = $criteria;

		return $this->collLinks;
	}

} // BaseLanguage
