<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'model/RightPeer.php';

/**
 * Base class that represents a row from the 'rights' table.
 *
 * 
 *
 * @package    model.om
 */
abstract class BaseRight extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        RightPeer
	 */
	protected static $peer;


	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;


	/**
	 * The value for the group_id field.
	 * @var        int
	 */
	protected $group_id;


	/**
	 * The value for the page_id field.
	 * @var        int
	 */
	protected $page_id;


	/**
	 * The value for the is_inherited field.
	 * @var        boolean
	 */
	protected $is_inherited = true;


	/**
	 * The value for the may_edit_page_details field.
	 * @var        boolean
	 */
	protected $may_edit_page_details = false;


	/**
	 * The value for the may_edit_page_contents field.
	 * @var        boolean
	 */
	protected $may_edit_page_contents = false;


	/**
	 * The value for the may_delete field.
	 * @var        boolean
	 */
	protected $may_delete = false;


	/**
	 * The value for the may_create_children field.
	 * @var        boolean
	 */
	protected $may_create_children = false;


	/**
	 * The value for the may_view_page field.
	 * @var        boolean
	 */
	protected $may_view_page = false;

	/**
	 * @var        Group
	 */
	protected $aGroup;

	/**
	 * @var        Page
	 */
	protected $aPage;

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
	 * Get the [group_id] column value.
	 * 
	 * @return     int
	 */
	public function getGroupId()
	{

		return $this->group_id;
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
	 * Get the [is_inherited] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsInherited()
	{

		return $this->is_inherited;
	}

	/**
	 * Get the [may_edit_page_details] column value.
	 * 
	 * @return     boolean
	 */
	public function getMayEditPageDetails()
	{

		return $this->may_edit_page_details;
	}

	/**
	 * Get the [may_edit_page_contents] column value.
	 * 
	 * @return     boolean
	 */
	public function getMayEditPageContents()
	{

		return $this->may_edit_page_contents;
	}

	/**
	 * Get the [may_delete] column value.
	 * 
	 * @return     boolean
	 */
	public function getMayDelete()
	{

		return $this->may_delete;
	}

	/**
	 * Get the [may_create_children] column value.
	 * 
	 * @return     boolean
	 */
	public function getMayCreateChildren()
	{

		return $this->may_create_children;
	}

	/**
	 * Get the [may_view_page] column value.
	 * 
	 * @return     boolean
	 */
	public function getMayViewPage()
	{

		return $this->may_view_page;
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
			$this->modifiedColumns[] = RightPeer::ID;
		}

	} // setId()

	/**
	 * Set the value of [group_id] column.
	 * 
	 * @param      int $v new value
	 * @return     void
	 */
	public function setGroupId($v)
	{

		// Since the native PHP type for this column is integer,
		// we will cast the input value to an int (if it is not).
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->group_id !== $v) {
			$this->group_id = $v;
			$this->modifiedColumns[] = RightPeer::GROUP_ID;
		}

		if ($this->aGroup !== null && $this->aGroup->getId() !== $v) {
			$this->aGroup = null;
		}

	} // setGroupId()

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
			$this->modifiedColumns[] = RightPeer::PAGE_ID;
		}

		if ($this->aPage !== null && $this->aPage->getId() !== $v) {
			$this->aPage = null;
		}

	} // setPageId()

	/**
	 * Set the value of [is_inherited] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setIsInherited($v)
	{

		if ($this->is_inherited !== $v || $v === true) {
			$this->is_inherited = $v;
			$this->modifiedColumns[] = RightPeer::IS_INHERITED;
		}

	} // setIsInherited()

	/**
	 * Set the value of [may_edit_page_details] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMayEditPageDetails($v)
	{

		if ($this->may_edit_page_details !== $v || $v === false) {
			$this->may_edit_page_details = $v;
			$this->modifiedColumns[] = RightPeer::MAY_EDIT_PAGE_DETAILS;
		}

	} // setMayEditPageDetails()

	/**
	 * Set the value of [may_edit_page_contents] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMayEditPageContents($v)
	{

		if ($this->may_edit_page_contents !== $v || $v === false) {
			$this->may_edit_page_contents = $v;
			$this->modifiedColumns[] = RightPeer::MAY_EDIT_PAGE_CONTENTS;
		}

	} // setMayEditPageContents()

	/**
	 * Set the value of [may_delete] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMayDelete($v)
	{

		if ($this->may_delete !== $v || $v === false) {
			$this->may_delete = $v;
			$this->modifiedColumns[] = RightPeer::MAY_DELETE;
		}

	} // setMayDelete()

	/**
	 * Set the value of [may_create_children] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMayCreateChildren($v)
	{

		if ($this->may_create_children !== $v || $v === false) {
			$this->may_create_children = $v;
			$this->modifiedColumns[] = RightPeer::MAY_CREATE_CHILDREN;
		}

	} // setMayCreateChildren()

	/**
	 * Set the value of [may_view_page] column.
	 * 
	 * @param      boolean $v new value
	 * @return     void
	 */
	public function setMayViewPage($v)
	{

		if ($this->may_view_page !== $v || $v === false) {
			$this->may_view_page = $v;
			$this->modifiedColumns[] = RightPeer::MAY_VIEW_PAGE;
		}

	} // setMayViewPage()

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

			$this->group_id = $rs->getInt($startcol + 1);

			$this->page_id = $rs->getInt($startcol + 2);

			$this->is_inherited = $rs->getBoolean($startcol + 3);

			$this->may_edit_page_details = $rs->getBoolean($startcol + 4);

			$this->may_edit_page_contents = $rs->getBoolean($startcol + 5);

			$this->may_delete = $rs->getBoolean($startcol + 6);

			$this->may_create_children = $rs->getBoolean($startcol + 7);

			$this->may_view_page = $rs->getBoolean($startcol + 8);

			$this->resetModified();

			$this->setNew(false);

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 9; // 9 = RightPeer::NUM_COLUMNS - RightPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Right object", $e);
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
			$con = Propel::getConnection(RightPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			RightPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(RightPeer::DATABASE_NAME);
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

			if ($this->aGroup !== null) {
				if ($this->aGroup->isModified()) {
					$affectedRows += $this->aGroup->save($con);
				}
				$this->setGroup($this->aGroup);
			}

			if ($this->aPage !== null) {
				if ($this->aPage->isModified()) {
					$affectedRows += $this->aPage->save($con);
				}
				$this->setPage($this->aPage);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RightPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += RightPeer::doUpdate($this, $con);
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

			if ($this->aGroup !== null) {
				if (!$this->aGroup->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aGroup->getValidationFailures());
				}
			}

			if ($this->aPage !== null) {
				if (!$this->aPage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aPage->getValidationFailures());
				}
			}


			if (($retval = RightPeer::doValidate($this, $columns)) !== true) {
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
		$pos = RightPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getGroupId();
				break;
			case 2:
				return $this->getPageId();
				break;
			case 3:
				return $this->getIsInherited();
				break;
			case 4:
				return $this->getMayEditPageDetails();
				break;
			case 5:
				return $this->getMayEditPageContents();
				break;
			case 6:
				return $this->getMayDelete();
				break;
			case 7:
				return $this->getMayCreateChildren();
				break;
			case 8:
				return $this->getMayViewPage();
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
		$keys = RightPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getGroupId(),
			$keys[2] => $this->getPageId(),
			$keys[3] => $this->getIsInherited(),
			$keys[4] => $this->getMayEditPageDetails(),
			$keys[5] => $this->getMayEditPageContents(),
			$keys[6] => $this->getMayDelete(),
			$keys[7] => $this->getMayCreateChildren(),
			$keys[8] => $this->getMayViewPage(),
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
		$pos = RightPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setGroupId($value);
				break;
			case 2:
				$this->setPageId($value);
				break;
			case 3:
				$this->setIsInherited($value);
				break;
			case 4:
				$this->setMayEditPageDetails($value);
				break;
			case 5:
				$this->setMayEditPageContents($value);
				break;
			case 6:
				$this->setMayDelete($value);
				break;
			case 7:
				$this->setMayCreateChildren($value);
				break;
			case 8:
				$this->setMayViewPage($value);
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
		$keys = RightPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setGroupId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPageId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsInherited($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMayEditPageDetails($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMayEditPageContents($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setMayDelete($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMayCreateChildren($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setMayViewPage($arr[$keys[8]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(RightPeer::DATABASE_NAME);

		if ($this->isColumnModified(RightPeer::ID)) $criteria->add(RightPeer::ID, $this->id);
		if ($this->isColumnModified(RightPeer::GROUP_ID)) $criteria->add(RightPeer::GROUP_ID, $this->group_id);
		if ($this->isColumnModified(RightPeer::PAGE_ID)) $criteria->add(RightPeer::PAGE_ID, $this->page_id);
		if ($this->isColumnModified(RightPeer::IS_INHERITED)) $criteria->add(RightPeer::IS_INHERITED, $this->is_inherited);
		if ($this->isColumnModified(RightPeer::MAY_EDIT_PAGE_DETAILS)) $criteria->add(RightPeer::MAY_EDIT_PAGE_DETAILS, $this->may_edit_page_details);
		if ($this->isColumnModified(RightPeer::MAY_EDIT_PAGE_CONTENTS)) $criteria->add(RightPeer::MAY_EDIT_PAGE_CONTENTS, $this->may_edit_page_contents);
		if ($this->isColumnModified(RightPeer::MAY_DELETE)) $criteria->add(RightPeer::MAY_DELETE, $this->may_delete);
		if ($this->isColumnModified(RightPeer::MAY_CREATE_CHILDREN)) $criteria->add(RightPeer::MAY_CREATE_CHILDREN, $this->may_create_children);
		if ($this->isColumnModified(RightPeer::MAY_VIEW_PAGE)) $criteria->add(RightPeer::MAY_VIEW_PAGE, $this->may_view_page);

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
		$criteria = new Criteria(RightPeer::DATABASE_NAME);

		$criteria->add(RightPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Right (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setGroupId($this->group_id);

		$copyObj->setPageId($this->page_id);

		$copyObj->setIsInherited($this->is_inherited);

		$copyObj->setMayEditPageDetails($this->may_edit_page_details);

		$copyObj->setMayEditPageContents($this->may_edit_page_contents);

		$copyObj->setMayDelete($this->may_delete);

		$copyObj->setMayCreateChildren($this->may_create_children);

		$copyObj->setMayViewPage($this->may_view_page);


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
	 * @return     Right Clone of current object.
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
	 * @return     RightPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RightPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Group object.
	 *
	 * @param      Group $v
	 * @return     void
	 * @throws     PropelException
	 */
	public function setGroup($v)
	{


		if ($v === null) {
			$this->setGroupId(NULL);
		} else {
			$this->setGroupId($v->getId());
		}


		$this->aGroup = $v;
	}


	/**
	 * Get the associated Group object
	 *
	 * @param      Connection Optional Connection object.
	 * @return     Group The associated Group object.
	 * @throws     PropelException
	 */
	public function getGroup($con = null)
	{
		// include the related Peer class
		include_once 'model/om/BaseGroupPeer.php';

		if ($this->aGroup === null && ($this->group_id !== null)) {

			$this->aGroup = GroupPeer::retrieveByPK($this->group_id, $con);

			/* The following can be used instead of the line above to
			   guarantee the related object contains a reference
			   to this object, but this level of coupling
			   may be undesirable in many circumstances.
			   As it can lead to a db query with many results that may
			   never be used.
			   $obj = GroupPeer::retrieveByPK($this->group_id, $con);
			   $obj->addGroups($this);
			 */
		}
		return $this->aGroup;
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

} // BaseRight
