<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/PageStringPeer.php';

/**
 * Base class that represents a row from the 'page_strings' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BasePageString extends BaseObject  implements Persistent {


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
	 * The value for the title field.
	 * @var        string
	 */
	protected $title = '';


	/**
	 * The value for the long_title field.
	 * @var        string
	 */
	protected $long_title;


	/**
	 * The value for the keywords field.
	 * @var        string
	 */
	protected $keywords;

	/**
	 * @var        Page
	 */
	protected $aPage;

	/**
	 * @var        Language
	 */
	protected $aLanguage;

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
	 * Get the [title] column value.
	 * 
	 * @return     string
	 */
	public function getTitle()
	{

		return $this->title;
	}

	/**
	 * Get the [long_title] column value.
	 * 
	 * @return     string
	 */
	public function getLongTitle()
	{

		return $this->long_title;
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
	 * Set the value of [page_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setPageId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->page_id !== $v) {
			$this->page_id = $v;
			$this->modifiedColumns[] = PageStringPeer::PAGE_ID;
		}

		if ($this->aPage !== null && $this->aPage->getId() !== $v) {
			$this->aPage = null;
		}

	} // setPageId()

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
			$this->modifiedColumns[] = PageStringPeer::LANGUAGE_ID;
		}

		if ($this->aLanguage !== null && $this->aLanguage->getId() !== $v) {
			$this->aLanguage = null;
		}

	} // setLanguageId()

	/**
	 * Set the value of [title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setTitle($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v || $v === '') {
			$this->title = $v;
			$this->modifiedColumns[] = PageStringPeer::TITLE;
		}

	} // setTitle()

	/**
	 * Set the value of [long_title] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setLongTitle($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->long_title !== $v) {
			$this->long_title = $v;
			$this->modifiedColumns[] = PageStringPeer::LONG_TITLE;
		}

	} // setLongTitle()

	/**
	 * Set the value of [keywords] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setKeywords($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->keywords !== $v) {
			$this->keywords = $v;
			$this->modifiedColumns[] = PageStringPeer::KEYWORDS;
		}

	} // setKeywords()

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

			$this->page_id = $rs->getInt($startcol + 0);

			$this->language_id = $rs->getString($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->long_title = $rs->getString($startcol + 3);

			$this->keywords = $rs->getString($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 5; // 5 = PageStringPeer::NUM_COLUMNS - PageStringPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating PageString object", $e);
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
			$con = Propel::getConnection(PageStringPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			PageStringPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(PageStringPeer::DATABASE_NAME);
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

			if ($this->aPage !== null) {
				if ($this->aPage->isModified()) {
					$affectedRows += $this->aPage->save($con);
				}
				$this->setPage($this->aPage);
			}

			if ($this->aLanguage !== null) {
				if ($this->aLanguage->isModified()) {
					$affectedRows += $this->aLanguage->save($con);
				}
				$this->setLanguage($this->aLanguage);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = PageStringPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

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
	 *                     one of the class type constants TYPE_PHPNAME,
	 *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PageStringPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPageId();
				break;
			case 1:
				return $this->getLanguageId();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getLongTitle();
				break;
			case 4:
				return $this->getKeywords();
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
		$keys = PageStringPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getPageId(),
			$keys[1] => $this->getLanguageId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getLongTitle(),
			$keys[4] => $this->getKeywords(),
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
				$this->setTitle($value);
				break;
			case 3:
				$this->setLongTitle($value);
				break;
			case 4:
				$this->setKeywords($value);
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
		$keys = PageStringPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setPageId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLanguageId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLongTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setKeywords($arr[$keys[4]]);
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
		if ($this->isColumnModified(PageStringPeer::TITLE)) $criteria->add(PageStringPeer::TITLE, $this->title);
		if ($this->isColumnModified(PageStringPeer::LONG_TITLE)) $criteria->add(PageStringPeer::LONG_TITLE, $this->long_title);
		if ($this->isColumnModified(PageStringPeer::KEYWORDS)) $criteria->add(PageStringPeer::KEYWORDS, $this->keywords);

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

		$copyObj->setTitle($this->title);

		$copyObj->setLongTitle($this->long_title);

		$copyObj->setKeywords($this->keywords);


		$copyObj->setNew(true);

		$copyObj->setPageId(NULL); // this is a pkey column, so set to default value

		$copyObj->setLanguageId(NULL); // this is a pkey column, so set to default value

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
	 * @return     void
	 * @throws     PropelException
	 */
	public function setPage($v)
	{


		if ($v === null) {
			$this->setPageId(NULL);
		} else {
			$this->setPageId($v->getId());
		}


		$this->aPage = $v;
	}


	/**
	 * Get the associated Page object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Page The associated Page object.
	 * @throws     PropelException
	 */
	public function getPage($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BasePagePeer.php';

		if ($this->aPage === null && ($this->page_id !== null)) {

			$this->aPage = PagePeer::retrieveByPK($this->page_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = PagePeer::retrieveByPK($this->page_id, $con);
			   $obj->addPages($this);
			 */
		}
		return $this->aPage;
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

} // BasePageString
