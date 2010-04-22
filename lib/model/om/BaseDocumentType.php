<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/DocumentTypePeer.php';

/**
 * Base class that represents a row from the 'document_types' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseDocumentType extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DocumentTypePeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the extension field.
	 * @var        string
	 */
	protected $extension;


	/**
	 * The value for the mimetype field.
	 * @var        string
	 */
	protected $mimetype;


	/**
	 * The value for the is_office_doc field.
	 * @var        boolean
	 */
	protected $is_office_doc = false;

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
	 * Get the [extension] column value.
	 * 
	 * @return     string
	 */
	public function getExtension()
	{

		return $this->extension;
	}

	/**
	 * Get the [mimetype] column value.
	 * 
	 * @return     string
	 */
	public function getMimetype()
	{

		return $this->mimetype;
	}

	/**
	 * Get the [is_office_doc] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsOfficeDoc()
	{

		return $this->is_office_doc;
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
			$this->modifiedColumns[] = DocumentTypePeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [extension] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setExtension($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->extension !== $v) {
			$this->extension = $v;
			$this->modifiedColumns[] = DocumentTypePeer::EXTENSION;
		}

	} // setExtension()

	/**
	 * Set the value of [mimetype] column.
	 * 
	 * @param      string $v new value
	 * @return     void
	 */
	public function setMimetype($v)
	{

		// Since the native PHP type for this column is string,
		// we will cast the input to a string (if it is not).
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mimetype !== $v) {
			$this->mimetype = $v;
			$this->modifiedColumns[] = DocumentTypePeer::MIMETYPE;
		}

	} // setMimetype()

	/**
	 * Set the value of [is_office_doc] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsOfficeDoc($v)
	{

		if ($this->is_office_doc !== $v || $v === false) {
			$this->is_office_doc = $v;
			$this->modifiedColumns[] = DocumentTypePeer::IS_OFFICE_DOC;
		}

	} // setIsOfficeDoc()

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

			$this->extension = $rs->getString($startcol + 1);

			$this->mimetype = $rs->getString($startcol + 2);

			$this->is_office_doc = $rs->getBoolean($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 4; // 4 = DocumentTypePeer::NUM_COLUMNS - DocumentTypePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating DocumentType object", $e);
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
			$con = Propel::getConnection(DocumentTypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			DocumentTypePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(DocumentTypePeer::DATABASE_NAME);
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
					$pk = DocumentTypePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += DocumentTypePeer::doUpdate($this, $con);
				}
				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collDocuments !== null) {
				foreach($this->collDocuments as $referrerFK) {
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


			if (($retval = DocumentTypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collDocuments !== null) {
					foreach($this->collDocuments as $referrerFK) {
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
		$pos = DocumentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getExtension();
				break;
			case 2:
				return $this->getMimetype();
				break;
			case 3:
				return $this->getIsOfficeDoc();
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
		$keys = DocumentTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getExtension(),
			$keys[2] => $this->getMimetype(),
			$keys[3] => $this->getIsOfficeDoc(),
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
		$pos = DocumentTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setExtension($value);
				break;
			case 2:
				$this->setMimetype($value);
				break;
			case 3:
				$this->setIsOfficeDoc($value);
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
		$keys = DocumentTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setExtension($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setMimetype($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsOfficeDoc($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DocumentTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(DocumentTypePeer::ID)) $criteria->add(DocumentTypePeer::ID, $this->id);
		if ($this->isColumnModified(DocumentTypePeer::EXTENSION)) $criteria->add(DocumentTypePeer::EXTENSION, $this->extension);
		if ($this->isColumnModified(DocumentTypePeer::MIMETYPE)) $criteria->add(DocumentTypePeer::MIMETYPE, $this->mimetype);
		if ($this->isColumnModified(DocumentTypePeer::IS_OFFICE_DOC)) $criteria->add(DocumentTypePeer::IS_OFFICE_DOC, $this->is_office_doc);

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
		$criteria = new Criteria(DocumentTypePeer::DATABASE_NAME);

		$criteria->add(DocumentTypePeer::ID, $this->id);

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
	 * @param      object $copyObj An object of DocumentType (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setExtension($this->extension);

		$copyObj->setMimetype($this->mimetype);

		$copyObj->setIsOfficeDoc($this->is_office_doc);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach($this->getDocuments() as $relObj) {
				$copyObj->addDocument($relObj->copy($deepCopy));
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
	 * @return     DocumentType Clone of current object.
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
	 * @return     DocumentTypePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DocumentTypePeer();
		}
		return self::$peer;
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
	 * Otherwise if this DocumentType has previously
	 * been saved, it will retrieve related Documents from storage.
	 * If this DocumentType is new, it will return
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

				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

				DocumentPeer::addSelectColumns($criteria);
				$this->collDocuments = DocumentPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

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

		$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

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
		$l->setDocumentType($this);
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DocumentType is new, it will return
	 * an empty collection; or if this DocumentType has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DocumentType.
	 */
	public function getDocumentsJoinLanguage($criteria = null, $con = null)
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

				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinLanguage($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}


	/**
	 * If this collection has already been initialized with
	 * an identical criteria, it returns the collection.
	 * Otherwise if this DocumentType is new, it will return
	 * an empty collection; or if this DocumentType has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DocumentType.
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

				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByOwnerId($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

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
	 * Otherwise if this DocumentType is new, it will return
	 * an empty collection; or if this DocumentType has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DocumentType.
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

				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinDocumentCategory($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

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
	 * Otherwise if this DocumentType is new, it will return
	 * an empty collection; or if this DocumentType has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DocumentType.
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

				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByCreatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

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
	 * Otherwise if this DocumentType is new, it will return
	 * an empty collection; or if this DocumentType has previously
	 * been saved, it will retrieve related Documents from storage.
	 *
	 * This method is protected by default in order to keep the public
	 * api reasonable.  You can provide public methods for those you
	 * actually need in DocumentType.
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

				$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		} else {
			// the following code is to determine if a new query is
			// called for.  If the criteria is the same as the last
			// one, just return the collection.

			$criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->getId());

			if (!isset($this->lastDocumentCriteria) || !$this->lastDocumentCriteria->equals($criteria)) {
				$this->collDocuments = DocumentPeer::doSelectJoinUserRelatedByUpdatedBy($criteria, $con);
			}
		}
		$this->lastDocumentCriteria = $criteria;

		return $this->collDocuments;
	}

} // BaseDocumentType
