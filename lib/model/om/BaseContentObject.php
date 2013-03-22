<?php


/**
 * Base class that represents a row from the 'objects' table.
 *
 *
 *
 * @package    propel.generator.model.om
 */
abstract class BaseContentObject extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ContentObjectPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ContentObjectPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the page_id field.
     * @var        int
     */
    protected $page_id;

    /**
     * The value for the container_name field.
     * @var        string
     */
    protected $container_name;

    /**
     * The value for the object_type field.
     * @var        string
     */
    protected $object_type;

    /**
     * The value for the condition_serialized field.
     * @var        resource
     */
    protected $condition_serialized;

    /**
     * The value for the sort field.
     * @var        int
     */
    protected $sort;

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
     * @var        User
     */
    protected $aUserRelatedByCreatedBy;

    /**
     * @var        User
     */
    protected $aUserRelatedByUpdatedBy;

    /**
     * @var        PropelObjectCollection|LanguageObject[] Collection to store aggregation of LanguageObject objects.
     */
    protected $collLanguageObjects;
    protected $collLanguageObjectsPartial;

    /**
     * @var        PropelObjectCollection|LanguageObjectHistory[] Collection to store aggregation of LanguageObjectHistory objects.
     */
    protected $collLanguageObjectHistorys;
    protected $collLanguageObjectHistorysPartial;

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
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $languageObjectsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $languageObjectHistorysScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [page_id] column value.
     *
     * @return int
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * Get the [container_name] column value.
     *
     * @return string
     */
    public function getContainerName()
    {
        return $this->container_name;
    }

    /**
     * Get the [object_type] column value.
     *
     * @return string
     */
    public function getObjectType()
    {
        return $this->object_type;
    }

    /**
     * Get the [condition_serialized] column value.
     *
     * @return resource
     */
    public function getConditionSerialized()
    {
        return $this->condition_serialized;
    }

    /**
     * Get the [sort] column value.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = 'Y-m-d H:i:s')
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [created_by] column value.
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Get the [updated_by] column value.
     *
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ContentObjectPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [page_id] column.
     *
     * @param int $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setPageId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->page_id !== $v) {
            $this->page_id = $v;
            $this->modifiedColumns[] = ContentObjectPeer::PAGE_ID;
        }

        if ($this->aPage !== null && $this->aPage->getId() !== $v) {
            $this->aPage = null;
        }


        return $this;
    } // setPageId()

    /**
     * Set the value of [container_name] column.
     *
     * @param string $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setContainerName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->container_name !== $v) {
            $this->container_name = $v;
            $this->modifiedColumns[] = ContentObjectPeer::CONTAINER_NAME;
        }


        return $this;
    } // setContainerName()

    /**
     * Set the value of [object_type] column.
     *
     * @param string $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setObjectType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->object_type !== $v) {
            $this->object_type = $v;
            $this->modifiedColumns[] = ContentObjectPeer::OBJECT_TYPE;
        }


        return $this;
    } // setObjectType()

    /**
     * Set the value of [condition_serialized] column.
     *
     * @param resource $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setConditionSerialized($v)
    {
        // Because BLOB columns are streams in PDO we have to assume that they are
        // always modified when a new value is passed in.  For example, the contents
        // of the stream itself may have changed externally.
        if (!is_resource($v) && $v !== null) {
            $this->condition_serialized = fopen('php://memory', 'r+');
            fwrite($this->condition_serialized, $v);
            rewind($this->condition_serialized);
        } else { // it's already a stream
            $this->condition_serialized = $v;
        }
        $this->modifiedColumns[] = ContentObjectPeer::CONDITION_SERIALIZED;


        return $this;
    } // setConditionSerialized()

    /**
     * Set the value of [sort] column.
     *
     * @param int $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[] = ContentObjectPeer::SORT;
        }


        return $this;
    } // setSort()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ContentObject The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = ContentObjectPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return ContentObject The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = ContentObjectPeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[] = ContentObjectPeer::CREATED_BY;
        }

        if ($this->aUserRelatedByCreatedBy !== null && $this->aUserRelatedByCreatedBy->getId() !== $v) {
            $this->aUserRelatedByCreatedBy = null;
        }


        return $this;
    } // setCreatedBy()

    /**
     * Set the value of [updated_by] column.
     *
     * @param int $v new value
     * @return ContentObject The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[] = ContentObjectPeer::UPDATED_BY;
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
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
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
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->page_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->container_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->object_type = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            if ($row[$startcol + 4] !== null) {
                $this->condition_serialized = fopen('php://memory', 'r+');
                fwrite($this->condition_serialized, $row[$startcol + 4]);
                rewind($this->condition_serialized);
            } else {
                $this->condition_serialized = null;
            }
            $this->sort = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->updated_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->created_by = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->updated_by = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 10; // 10 = ContentObjectPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating ContentObject object", $e);
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
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aPage !== null && $this->page_id !== $this->aPage->getId()) {
            $this->aPage = null;
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
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
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
            $con = Propel::getConnection(ContentObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ContentObjectPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPage = null;
            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
            $this->collLanguageObjects = null;

            $this->collLanguageObjectHistorys = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentObjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ContentObjectQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // denyable behavior
            if(!(ContentObjectPeer::isIgnoringRights() || $this->mayOperate("delete"))) {
                throw new PropelException(new NotPermittedException("delete.backend_user", array("role_key" => "objects")));
            }

            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
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
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentObjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // denyable behavior
                if(!(ContentObjectPeer::isIgnoringRights() || $this->mayOperate("insert"))) {
                    throw new PropelException(new NotPermittedException("insert.backend_user", array("role_key" => "objects")));
                }

                // extended_timestampable behavior
                if (!$this->isColumnModified(ContentObjectPeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ContentObjectPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // attributable behavior

                if(Session::getSession()->isAuthenticated()) {
                    if (!$this->isColumnModified(ContentObjectPeer::CREATED_BY)) {
                        $this->setCreatedBy(Session::getSession()->getUser()->getId());
                    }
                    if (!$this->isColumnModified(ContentObjectPeer::UPDATED_BY)) {
                        $this->setUpdatedBy(Session::getSession()->getUser()->getId());
                    }
                }

            } else {
                $ret = $ret && $this->preUpdate($con);
                // denyable behavior
                if(!(ContentObjectPeer::isIgnoringRights() || $this->mayOperate("update"))) {
                    throw new PropelException(new NotPermittedException("update.backend_user", array("role_key" => "objects")));
                }

                // extended_timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ContentObjectPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // attributable behavior

                if(Session::getSession()->isAuthenticated()) {
                    if ($this->isModified() && !$this->isColumnModified(ContentObjectPeer::UPDATED_BY)) {
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
                ContentObjectPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
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
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
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

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                // Rewind the condition_serialized LOB column, since PDO does not rewind after inserting value.
                if ($this->condition_serialized !== null && is_resource($this->condition_serialized)) {
                    rewind($this->condition_serialized);
                }

                $this->resetModified();
            }

            if ($this->languageObjectsScheduledForDeletion !== null) {
                if (!$this->languageObjectsScheduledForDeletion->isEmpty()) {
                    LanguageObjectQuery::create()
                        ->filterByPrimaryKeys($this->languageObjectsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->languageObjectsScheduledForDeletion = null;
                }
            }

            if ($this->collLanguageObjects !== null) {
                foreach ($this->collLanguageObjects as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->languageObjectHistorysScheduledForDeletion !== null) {
                if (!$this->languageObjectHistorysScheduledForDeletion->isEmpty()) {
                    LanguageObjectHistoryQuery::create()
                        ->filterByPrimaryKeys($this->languageObjectHistorysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->languageObjectHistorysScheduledForDeletion = null;
                }
            }

            if ($this->collLanguageObjectHistorys !== null) {
                foreach ($this->collLanguageObjectHistorys as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = ContentObjectPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ContentObjectPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContentObjectPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ContentObjectPeer::PAGE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`page_id`';
        }
        if ($this->isColumnModified(ContentObjectPeer::CONTAINER_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`container_name`';
        }
        if ($this->isColumnModified(ContentObjectPeer::OBJECT_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`object_type`';
        }
        if ($this->isColumnModified(ContentObjectPeer::CONDITION_SERIALIZED)) {
            $modifiedColumns[':p' . $index++]  = '`condition_serialized`';
        }
        if ($this->isColumnModified(ContentObjectPeer::SORT)) {
            $modifiedColumns[':p' . $index++]  = '`sort`';
        }
        if ($this->isColumnModified(ContentObjectPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(ContentObjectPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }
        if ($this->isColumnModified(ContentObjectPeer::CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`created_by`';
        }
        if ($this->isColumnModified(ContentObjectPeer::UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`updated_by`';
        }

        $sql = sprintf(
            'INSERT INTO `objects` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`page_id`':
                        $stmt->bindValue($identifier, $this->page_id, PDO::PARAM_INT);
                        break;
                    case '`container_name`':
                        $stmt->bindValue($identifier, $this->container_name, PDO::PARAM_STR);
                        break;
                    case '`object_type`':
                        $stmt->bindValue($identifier, $this->object_type, PDO::PARAM_STR);
                        break;
                    case '`condition_serialized`':
                        if (is_resource($this->condition_serialized)) {
                            rewind($this->condition_serialized);
                        }
                        $stmt->bindValue($identifier, $this->condition_serialized, PDO::PARAM_LOB);
                        break;
                    case '`sort`':
                        $stmt->bindValue($identifier, $this->sort, PDO::PARAM_INT);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                    case '`created_by`':
                        $stmt->bindValue($identifier, $this->created_by, PDO::PARAM_INT);
                        break;
                    case '`updated_by`':
                        $stmt->bindValue($identifier, $this->updated_by, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
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
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
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


            if (($retval = ContentObjectPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collLanguageObjects !== null) {
                    foreach ($this->collLanguageObjects as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collLanguageObjectHistorys !== null) {
                    foreach ($this->collLanguageObjectHistorys as $referrerFK) {
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
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentObjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getPageId();
                break;
            case 2:
                return $this->getContainerName();
                break;
            case 3:
                return $this->getObjectType();
                break;
            case 4:
                return $this->getConditionSerialized();
                break;
            case 5:
                return $this->getSort();
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
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['ContentObject'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ContentObject'][$this->getPrimaryKey()] = true;
        $keys = ContentObjectPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPageId(),
            $keys[2] => $this->getContainerName(),
            $keys[3] => $this->getObjectType(),
            $keys[4] => $this->getConditionSerialized(),
            $keys[5] => $this->getSort(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
            $keys[8] => $this->getCreatedBy(),
            $keys[9] => $this->getUpdatedBy(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aPage) {
                $result['Page'] = $this->aPage->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserRelatedByCreatedBy) {
                $result['UserRelatedByCreatedBy'] = $this->aUserRelatedByCreatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserRelatedByUpdatedBy) {
                $result['UserRelatedByUpdatedBy'] = $this->aUserRelatedByUpdatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collLanguageObjects) {
                $result['LanguageObjects'] = $this->collLanguageObjects->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLanguageObjectHistorys) {
                $result['LanguageObjectHistorys'] = $this->collLanguageObjectHistorys->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentObjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPageId($value);
                break;
            case 2:
                $this->setContainerName($value);
                break;
            case 3:
                $this->setObjectType($value);
                break;
            case 4:
                $this->setConditionSerialized($value);
                break;
            case 5:
                $this->setSort($value);
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
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ContentObjectPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPageId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setContainerName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setObjectType($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setConditionSerialized($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSort($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setCreatedBy($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setUpdatedBy($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ContentObjectPeer::DATABASE_NAME);

        if ($this->isColumnModified(ContentObjectPeer::ID)) $criteria->add(ContentObjectPeer::ID, $this->id);
        if ($this->isColumnModified(ContentObjectPeer::PAGE_ID)) $criteria->add(ContentObjectPeer::PAGE_ID, $this->page_id);
        if ($this->isColumnModified(ContentObjectPeer::CONTAINER_NAME)) $criteria->add(ContentObjectPeer::CONTAINER_NAME, $this->container_name);
        if ($this->isColumnModified(ContentObjectPeer::OBJECT_TYPE)) $criteria->add(ContentObjectPeer::OBJECT_TYPE, $this->object_type);
        if ($this->isColumnModified(ContentObjectPeer::CONDITION_SERIALIZED)) $criteria->add(ContentObjectPeer::CONDITION_SERIALIZED, $this->condition_serialized);
        if ($this->isColumnModified(ContentObjectPeer::SORT)) $criteria->add(ContentObjectPeer::SORT, $this->sort);
        if ($this->isColumnModified(ContentObjectPeer::CREATED_AT)) $criteria->add(ContentObjectPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(ContentObjectPeer::UPDATED_AT)) $criteria->add(ContentObjectPeer::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(ContentObjectPeer::CREATED_BY)) $criteria->add(ContentObjectPeer::CREATED_BY, $this->created_by);
        if ($this->isColumnModified(ContentObjectPeer::UPDATED_BY)) $criteria->add(ContentObjectPeer::UPDATED_BY, $this->updated_by);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ContentObjectPeer::DATABASE_NAME);
        $criteria->add(ContentObjectPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
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
     * @param object $copyObj An object of ContentObject (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPageId($this->getPageId());
        $copyObj->setContainerName($this->getContainerName());
        $copyObj->setObjectType($this->getObjectType());
        $copyObj->setConditionSerialized($this->getConditionSerialized());
        $copyObj->setSort($this->getSort());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setUpdatedBy($this->getUpdatedBy());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getLanguageObjects() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addLanguageObject($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getLanguageObjectHistorys() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addLanguageObjectHistory($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return ContentObject Clone of current object.
     * @throws PropelException
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
     * @return ContentObjectPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ContentObjectPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Page object.
     *
     * @param             Page $v
     * @return ContentObject The current object (for fluent API support)
     * @throws PropelException
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
            $v->addContentObject($this);
        }


        return $this;
    }


    /**
     * Get the associated Page object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Page The associated Page object.
     * @throws PropelException
     */
    public function getPage(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPage === null && ($this->page_id !== null) && $doQuery) {
            $this->aPage = PageQuery::create()->findPk($this->page_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPage->addContentObjects($this);
             */
        }

        return $this->aPage;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return ContentObject The current object (for fluent API support)
     * @throws PropelException
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
            $v->addContentObjectRelatedByCreatedBy($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUserRelatedByCreatedBy(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUserRelatedByCreatedBy === null && ($this->created_by !== null) && $doQuery) {
            $this->aUserRelatedByCreatedBy = UserQuery::create()->findPk($this->created_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByCreatedBy->addContentObjectsRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return ContentObject The current object (for fluent API support)
     * @throws PropelException
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
            $v->addContentObjectRelatedByUpdatedBy($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUserRelatedByUpdatedBy(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUserRelatedByUpdatedBy === null && ($this->updated_by !== null) && $doQuery) {
            $this->aUserRelatedByUpdatedBy = UserQuery::create()->findPk($this->updated_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByUpdatedBy->addContentObjectsRelatedByUpdatedBy($this);
             */
        }

        return $this->aUserRelatedByUpdatedBy;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('LanguageObject' == $relationName) {
            $this->initLanguageObjects();
        }
        if ('LanguageObjectHistory' == $relationName) {
            $this->initLanguageObjectHistorys();
        }
    }

    /**
     * Clears out the collLanguageObjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return ContentObject The current object (for fluent API support)
     * @see        addLanguageObjects()
     */
    public function clearLanguageObjects()
    {
        $this->collLanguageObjects = null; // important to set this to null since that means it is uninitialized
        $this->collLanguageObjectsPartial = null;

        return $this;
    }

    /**
     * reset is the collLanguageObjects collection loaded partially
     *
     * @return void
     */
    public function resetPartialLanguageObjects($v = true)
    {
        $this->collLanguageObjectsPartial = $v;
    }

    /**
     * Initializes the collLanguageObjects collection.
     *
     * By default this just sets the collLanguageObjects collection to an empty array (like clearcollLanguageObjects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initLanguageObjects($overrideExisting = true)
    {
        if (null !== $this->collLanguageObjects && !$overrideExisting) {
            return;
        }
        $this->collLanguageObjects = new PropelObjectCollection();
        $this->collLanguageObjects->setModel('LanguageObject');
    }

    /**
     * Gets an array of LanguageObject objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ContentObject is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|LanguageObject[] List of LanguageObject objects
     * @throws PropelException
     */
    public function getLanguageObjects($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collLanguageObjectsPartial && !$this->isNew();
        if (null === $this->collLanguageObjects || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collLanguageObjects) {
                // return empty collection
                $this->initLanguageObjects();
            } else {
                $collLanguageObjects = LanguageObjectQuery::create(null, $criteria)
                    ->filterByContentObject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collLanguageObjectsPartial && count($collLanguageObjects)) {
                      $this->initLanguageObjects(false);

                      foreach($collLanguageObjects as $obj) {
                        if (false == $this->collLanguageObjects->contains($obj)) {
                          $this->collLanguageObjects->append($obj);
                        }
                      }

                      $this->collLanguageObjectsPartial = true;
                    }

                    $collLanguageObjects->getInternalIterator()->rewind();
                    return $collLanguageObjects;
                }

                if($partial && $this->collLanguageObjects) {
                    foreach($this->collLanguageObjects as $obj) {
                        if($obj->isNew()) {
                            $collLanguageObjects[] = $obj;
                        }
                    }
                }

                $this->collLanguageObjects = $collLanguageObjects;
                $this->collLanguageObjectsPartial = false;
            }
        }

        return $this->collLanguageObjects;
    }

    /**
     * Sets a collection of LanguageObject objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $languageObjects A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return ContentObject The current object (for fluent API support)
     */
    public function setLanguageObjects(PropelCollection $languageObjects, PropelPDO $con = null)
    {
        $languageObjectsToDelete = $this->getLanguageObjects(new Criteria(), $con)->diff($languageObjects);

        $this->languageObjectsScheduledForDeletion = unserialize(serialize($languageObjectsToDelete));

        foreach ($languageObjectsToDelete as $languageObjectRemoved) {
            $languageObjectRemoved->setContentObject(null);
        }

        $this->collLanguageObjects = null;
        foreach ($languageObjects as $languageObject) {
            $this->addLanguageObject($languageObject);
        }

        $this->collLanguageObjects = $languageObjects;
        $this->collLanguageObjectsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related LanguageObject objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related LanguageObject objects.
     * @throws PropelException
     */
    public function countLanguageObjects(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collLanguageObjectsPartial && !$this->isNew();
        if (null === $this->collLanguageObjects || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collLanguageObjects) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getLanguageObjects());
            }
            $query = LanguageObjectQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContentObject($this)
                ->count($con);
        }

        return count($this->collLanguageObjects);
    }

    /**
     * Method called to associate a LanguageObject object to this object
     * through the LanguageObject foreign key attribute.
     *
     * @param    LanguageObject $l LanguageObject
     * @return ContentObject The current object (for fluent API support)
     */
    public function addLanguageObject(LanguageObject $l)
    {
        if ($this->collLanguageObjects === null) {
            $this->initLanguageObjects();
            $this->collLanguageObjectsPartial = true;
        }
        if (!in_array($l, $this->collLanguageObjects->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddLanguageObject($l);
        }

        return $this;
    }

    /**
     * @param	LanguageObject $languageObject The languageObject object to add.
     */
    protected function doAddLanguageObject($languageObject)
    {
        $this->collLanguageObjects[]= $languageObject;
        $languageObject->setContentObject($this);
    }

    /**
     * @param	LanguageObject $languageObject The languageObject object to remove.
     * @return ContentObject The current object (for fluent API support)
     */
    public function removeLanguageObject($languageObject)
    {
        if ($this->getLanguageObjects()->contains($languageObject)) {
            $this->collLanguageObjects->remove($this->collLanguageObjects->search($languageObject));
            if (null === $this->languageObjectsScheduledForDeletion) {
                $this->languageObjectsScheduledForDeletion = clone $this->collLanguageObjects;
                $this->languageObjectsScheduledForDeletion->clear();
            }
            $this->languageObjectsScheduledForDeletion[]= clone $languageObject;
            $languageObject->setContentObject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ContentObject is new, it will return
     * an empty collection; or if this ContentObject has previously
     * been saved, it will retrieve related LanguageObjects from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ContentObject.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObject[] List of LanguageObject objects
     */
    public function getLanguageObjectsJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectQuery::create(null, $criteria);
        $query->joinWith('Language', $join_behavior);

        return $this->getLanguageObjects($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ContentObject is new, it will return
     * an empty collection; or if this ContentObject has previously
     * been saved, it will retrieve related LanguageObjects from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ContentObject.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObject[] List of LanguageObject objects
     */
    public function getLanguageObjectsJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $join_behavior);

        return $this->getLanguageObjects($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ContentObject is new, it will return
     * an empty collection; or if this ContentObject has previously
     * been saved, it will retrieve related LanguageObjects from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ContentObject.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObject[] List of LanguageObject objects
     */
    public function getLanguageObjectsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

        return $this->getLanguageObjects($query, $con);
    }

    /**
     * Clears out the collLanguageObjectHistorys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return ContentObject The current object (for fluent API support)
     * @see        addLanguageObjectHistorys()
     */
    public function clearLanguageObjectHistorys()
    {
        $this->collLanguageObjectHistorys = null; // important to set this to null since that means it is uninitialized
        $this->collLanguageObjectHistorysPartial = null;

        return $this;
    }

    /**
     * reset is the collLanguageObjectHistorys collection loaded partially
     *
     * @return void
     */
    public function resetPartialLanguageObjectHistorys($v = true)
    {
        $this->collLanguageObjectHistorysPartial = $v;
    }

    /**
     * Initializes the collLanguageObjectHistorys collection.
     *
     * By default this just sets the collLanguageObjectHistorys collection to an empty array (like clearcollLanguageObjectHistorys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initLanguageObjectHistorys($overrideExisting = true)
    {
        if (null !== $this->collLanguageObjectHistorys && !$overrideExisting) {
            return;
        }
        $this->collLanguageObjectHistorys = new PropelObjectCollection();
        $this->collLanguageObjectHistorys->setModel('LanguageObjectHistory');
    }

    /**
     * Gets an array of LanguageObjectHistory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ContentObject is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|LanguageObjectHistory[] List of LanguageObjectHistory objects
     * @throws PropelException
     */
    public function getLanguageObjectHistorys($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collLanguageObjectHistorysPartial && !$this->isNew();
        if (null === $this->collLanguageObjectHistorys || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collLanguageObjectHistorys) {
                // return empty collection
                $this->initLanguageObjectHistorys();
            } else {
                $collLanguageObjectHistorys = LanguageObjectHistoryQuery::create(null, $criteria)
                    ->filterByContentObject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collLanguageObjectHistorysPartial && count($collLanguageObjectHistorys)) {
                      $this->initLanguageObjectHistorys(false);

                      foreach($collLanguageObjectHistorys as $obj) {
                        if (false == $this->collLanguageObjectHistorys->contains($obj)) {
                          $this->collLanguageObjectHistorys->append($obj);
                        }
                      }

                      $this->collLanguageObjectHistorysPartial = true;
                    }

                    $collLanguageObjectHistorys->getInternalIterator()->rewind();
                    return $collLanguageObjectHistorys;
                }

                if($partial && $this->collLanguageObjectHistorys) {
                    foreach($this->collLanguageObjectHistorys as $obj) {
                        if($obj->isNew()) {
                            $collLanguageObjectHistorys[] = $obj;
                        }
                    }
                }

                $this->collLanguageObjectHistorys = $collLanguageObjectHistorys;
                $this->collLanguageObjectHistorysPartial = false;
            }
        }

        return $this->collLanguageObjectHistorys;
    }

    /**
     * Sets a collection of LanguageObjectHistory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $languageObjectHistorys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return ContentObject The current object (for fluent API support)
     */
    public function setLanguageObjectHistorys(PropelCollection $languageObjectHistorys, PropelPDO $con = null)
    {
        $languageObjectHistorysToDelete = $this->getLanguageObjectHistorys(new Criteria(), $con)->diff($languageObjectHistorys);

        $this->languageObjectHistorysScheduledForDeletion = unserialize(serialize($languageObjectHistorysToDelete));

        foreach ($languageObjectHistorysToDelete as $languageObjectHistoryRemoved) {
            $languageObjectHistoryRemoved->setContentObject(null);
        }

        $this->collLanguageObjectHistorys = null;
        foreach ($languageObjectHistorys as $languageObjectHistory) {
            $this->addLanguageObjectHistory($languageObjectHistory);
        }

        $this->collLanguageObjectHistorys = $languageObjectHistorys;
        $this->collLanguageObjectHistorysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related LanguageObjectHistory objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related LanguageObjectHistory objects.
     * @throws PropelException
     */
    public function countLanguageObjectHistorys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collLanguageObjectHistorysPartial && !$this->isNew();
        if (null === $this->collLanguageObjectHistorys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collLanguageObjectHistorys) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getLanguageObjectHistorys());
            }
            $query = LanguageObjectHistoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContentObject($this)
                ->count($con);
        }

        return count($this->collLanguageObjectHistorys);
    }

    /**
     * Method called to associate a LanguageObjectHistory object to this object
     * through the LanguageObjectHistory foreign key attribute.
     *
     * @param    LanguageObjectHistory $l LanguageObjectHistory
     * @return ContentObject The current object (for fluent API support)
     */
    public function addLanguageObjectHistory(LanguageObjectHistory $l)
    {
        if ($this->collLanguageObjectHistorys === null) {
            $this->initLanguageObjectHistorys();
            $this->collLanguageObjectHistorysPartial = true;
        }
        if (!in_array($l, $this->collLanguageObjectHistorys->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddLanguageObjectHistory($l);
        }

        return $this;
    }

    /**
     * @param	LanguageObjectHistory $languageObjectHistory The languageObjectHistory object to add.
     */
    protected function doAddLanguageObjectHistory($languageObjectHistory)
    {
        $this->collLanguageObjectHistorys[]= $languageObjectHistory;
        $languageObjectHistory->setContentObject($this);
    }

    /**
     * @param	LanguageObjectHistory $languageObjectHistory The languageObjectHistory object to remove.
     * @return ContentObject The current object (for fluent API support)
     */
    public function removeLanguageObjectHistory($languageObjectHistory)
    {
        if ($this->getLanguageObjectHistorys()->contains($languageObjectHistory)) {
            $this->collLanguageObjectHistorys->remove($this->collLanguageObjectHistorys->search($languageObjectHistory));
            if (null === $this->languageObjectHistorysScheduledForDeletion) {
                $this->languageObjectHistorysScheduledForDeletion = clone $this->collLanguageObjectHistorys;
                $this->languageObjectHistorysScheduledForDeletion->clear();
            }
            $this->languageObjectHistorysScheduledForDeletion[]= clone $languageObjectHistory;
            $languageObjectHistory->setContentObject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ContentObject is new, it will return
     * an empty collection; or if this ContentObject has previously
     * been saved, it will retrieve related LanguageObjectHistorys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ContentObject.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObjectHistory[] List of LanguageObjectHistory objects
     */
    public function getLanguageObjectHistorysJoinLanguage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectHistoryQuery::create(null, $criteria);
        $query->joinWith('Language', $join_behavior);

        return $this->getLanguageObjectHistorys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ContentObject is new, it will return
     * an empty collection; or if this ContentObject has previously
     * been saved, it will retrieve related LanguageObjectHistorys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ContentObject.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObjectHistory[] List of LanguageObjectHistory objects
     */
    public function getLanguageObjectHistorysJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectHistoryQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $join_behavior);

        return $this->getLanguageObjectHistorys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this ContentObject is new, it will return
     * an empty collection; or if this ContentObject has previously
     * been saved, it will retrieve related LanguageObjectHistorys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in ContentObject.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObjectHistory[] List of LanguageObjectHistory objects
     */
    public function getLanguageObjectHistorysJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectHistoryQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

        return $this->getLanguageObjectHistorys($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->page_id = null;
        $this->container_name = null;
        $this->object_type = null;
        $this->condition_serialized = null;
        $this->sort = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->created_by = null;
        $this->updated_by = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
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
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collLanguageObjects) {
                foreach ($this->collLanguageObjects as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collLanguageObjectHistorys) {
                foreach ($this->collLanguageObjectHistorys as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aPage instanceof Persistent) {
              $this->aPage->clearAllReferences($deep);
            }
            if ($this->aUserRelatedByCreatedBy instanceof Persistent) {
              $this->aUserRelatedByCreatedBy->clearAllReferences($deep);
            }
            if ($this->aUserRelatedByUpdatedBy instanceof Persistent) {
              $this->aUserRelatedByUpdatedBy->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collLanguageObjects instanceof PropelCollection) {
            $this->collLanguageObjects->clearIterator();
        }
        $this->collLanguageObjects = null;
        if ($this->collLanguageObjectHistorys instanceof PropelCollection) {
            $this->collLanguageObjectHistorys->clearIterator();
        }
        $this->collLanguageObjectHistorys = null;
        $this->aPage = null;
        $this->aUserRelatedByCreatedBy = null;
        $this->aUserRelatedByUpdatedBy = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContentObjectPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // denyable behavior
    public function mayOperate($sOperation, $oUser = false) {
        if($oUser === false) {
            $oUser = Session::getSession()->getUser();
        }
        $bIsAllowed = false;
        if($oUser && ($this->isNew() || $this->getCreatedBy() === $oUser->getId()) && ContentObjectPeer::mayOperateOnOwn($oUser, $this, $sOperation)) {
            $bIsAllowed = true;
        } else if(ContentObjectPeer::mayOperateOn($oUser, $this, $sOperation)) {
            $bIsAllowed = true;
        }
        FilterModule::getFilters()->handleContentObjectOperationCheck($sOperation, $this, $oUser, array(&$bIsAllowed));
        return $bIsAllowed;
    }
    public function mayBeInserted($oUser = false) {
        return $this->mayOperate("insert", $oUser);
    }
    public function mayBeUpdated($oUser = false) {
        return $this->mayOperate("update", $oUser);
    }
    public function mayBeDeleted($oUser = false) {
        return $this->mayOperate("delete", $oUser);
    }

    // extended_timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     ContentObject The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = ContentObjectPeer::UPDATED_AT;

        return $this;
    }

    /**
     * @return created_at as int (timestamp)
     */
    public function getCreatedAtTimestamp()
    {
        return (int)$this->getCreatedAt('U');
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
        return (int)$this->getUpdatedAt('U');
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
     * @return     ContentObject The current object (for fluent API support)
     */
    public function keepUpdateUserUnchanged()
    {
        $this->modifiedColumns[] = ContentObjectPeer::UPDATED_BY;
        return $this;
    }

    // extended_keyable behavior

    /**
     * @return the primary key as an array (even for non-composite keys)
     */
    public function getPKArray()
    {
        return array($this->getPrimaryKey());
    }

    /**
     * @return the composite primary key as a string, separated by _
     */
    public function getPKString()
    {
        return implode("", $this->getPKArray());
    }

}
