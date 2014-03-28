<?php


/**
 * Base class that represents a row from the 'languages' table.
 *
 *
 *
 * @package    propel.generator.model.om
 */
abstract class BaseLanguage extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'LanguagePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        LanguagePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        string
     */
    protected $id;

    /**
     * The value for the path_prefix field.
     * @var        string
     */
    protected $path_prefix;

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
     * @var        PropelObjectCollection|PageString[] Collection to store aggregation of PageString objects.
     */
    protected $collPageStrings;
    protected $collPageStringsPartial;

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
     * @var        PropelObjectCollection|String[] Collection to store aggregation of String objects.
     */
    protected $collStrings;
    protected $collStringsPartial;

    /**
     * @var        PropelObjectCollection|User[] Collection to store aggregation of User objects.
     */
    protected $collUsersRelatedByLanguageId;
    protected $collUsersRelatedByLanguageIdPartial;

    /**
     * @var        PropelObjectCollection|Document[] Collection to store aggregation of Document objects.
     */
    protected $collDocuments;
    protected $collDocumentsPartial;

    /**
     * @var        PropelObjectCollection|Link[] Collection to store aggregation of Link objects.
     */
    protected $collLinks;
    protected $collLinksPartial;

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
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pageStringsScheduledForDeletion = null;

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
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $stringsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $usersRelatedByLanguageIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $documentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $linksScheduledForDeletion = null;

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [path_prefix] column value.
     *
     * @return string
     */
    public function getPathPrefix()
    {
        return $this->path_prefix;
    }

    /**
     * Get the [is_active] column value.
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
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
        } else {
            try {
                $dt = new DateTime($this->created_at);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
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
        } else {
            try {
                $dt = new DateTime($this->updated_at);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
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
     * @param string $v new value
     * @return Language The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = LanguagePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [path_prefix] column.
     *
     * @param string $v new value
     * @return Language The current object (for fluent API support)
     */
    public function setPathPrefix($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->path_prefix !== $v) {
            $this->path_prefix = $v;
            $this->modifiedColumns[] = LanguagePeer::PATH_PREFIX;
        }


        return $this;
    } // setPathPrefix()

    /**
     * Sets the value of the [is_active] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Language The current object (for fluent API support)
     */
    public function setIsActive($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_active !== $v) {
            $this->is_active = $v;
            $this->modifiedColumns[] = LanguagePeer::IS_ACTIVE;
        }


        return $this;
    } // setIsActive()

    /**
     * Set the value of [sort] column.
     *
     * @param int $v new value
     * @return Language The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[] = LanguagePeer::SORT;
        }


        return $this;
    } // setSort()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Language The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = LanguagePeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Language The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = LanguagePeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return Language The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[] = LanguagePeer::CREATED_BY;
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
     * @return Language The current object (for fluent API support)
     */
    public function setUpdatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->updated_by !== $v) {
            $this->updated_by = $v;
            $this->modifiedColumns[] = LanguagePeer::UPDATED_BY;
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

            $this->id = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
            $this->path_prefix = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->is_active = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
            $this->sort = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->created_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->updated_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->created_by = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->updated_by = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = LanguagePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Language object", $e);
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
            $con = Propel::getConnection(LanguagePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = LanguagePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUserRelatedByCreatedBy = null;
            $this->aUserRelatedByUpdatedBy = null;
            $this->collPageStrings = null;

            $this->collLanguageObjects = null;

            $this->collLanguageObjectHistorys = null;

            $this->collStrings = null;

            $this->collUsersRelatedByLanguageId = null;

            $this->collDocuments = null;

            $this->collLinks = null;

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
            $con = Propel::getConnection(LanguagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = LanguageQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // denyable behavior
            if(!(LanguagePeer::isIgnoringRights() || $this->mayOperate("delete"))) {
                throw new PropelException(new NotPermittedException("delete.by_role", array("role_key" => "languages")));
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
            $con = Propel::getConnection(LanguagePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // denyable behavior
                if(!(LanguagePeer::isIgnoringRights() || $this->mayOperate("insert"))) {
                    throw new PropelException(new NotPermittedException("insert.by_role", array("role_key" => "languages")));
                }

                // extended_timestampable behavior
                if (!$this->isColumnModified(LanguagePeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(LanguagePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // attributable behavior

                if(Session::getSession()->isAuthenticated()) {
                    if (!$this->isColumnModified(LanguagePeer::CREATED_BY)) {
                        $this->setCreatedBy(Session::getSession()->getUser()->getId());
                    }
                    if (!$this->isColumnModified(LanguagePeer::UPDATED_BY)) {
                        $this->setUpdatedBy(Session::getSession()->getUser()->getId());
                    }
                }

            } else {
                $ret = $ret && $this->preUpdate($con);
                // denyable behavior
                if(!(LanguagePeer::isIgnoringRights() || $this->mayOperate("update"))) {
                    throw new PropelException(new NotPermittedException("update.by_role", array("role_key" => "languages")));
                }

                // extended_timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(LanguagePeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // attributable behavior

                if(Session::getSession()->isAuthenticated()) {
                    if ($this->isModified() && !$this->isColumnModified(LanguagePeer::UPDATED_BY)) {
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
                LanguagePeer::addInstanceToPool($this);
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
                $this->resetModified();
            }

            if ($this->pageStringsScheduledForDeletion !== null) {
                if (!$this->pageStringsScheduledForDeletion->isEmpty()) {
                    PageStringQuery::create()
                        ->filterByPrimaryKeys($this->pageStringsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pageStringsScheduledForDeletion = null;
                }
            }

            if ($this->collPageStrings !== null) {
                foreach ($this->collPageStrings as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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
                    if (!$referrerFK->isDeleted()) {
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
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stringsScheduledForDeletion !== null) {
                if (!$this->stringsScheduledForDeletion->isEmpty()) {
                    StringQuery::create()
                        ->filterByPrimaryKeys($this->stringsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stringsScheduledForDeletion = null;
                }
            }

            if ($this->collStrings !== null) {
                foreach ($this->collStrings as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->usersRelatedByLanguageIdScheduledForDeletion !== null) {
                if (!$this->usersRelatedByLanguageIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->usersRelatedByLanguageIdScheduledForDeletion as $userRelatedByLanguageId) {
                        // need to save related object because we set the relation to null
                        $userRelatedByLanguageId->save($con);
                    }
                    $this->usersRelatedByLanguageIdScheduledForDeletion = null;
                }
            }

            if ($this->collUsersRelatedByLanguageId !== null) {
                foreach ($this->collUsersRelatedByLanguageId as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->documentsScheduledForDeletion !== null) {
                if (!$this->documentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->documentsScheduledForDeletion as $document) {
                        // need to save related object because we set the relation to null
                        $document->save($con);
                    }
                    $this->documentsScheduledForDeletion = null;
                }
            }

            if ($this->collDocuments !== null) {
                foreach ($this->collDocuments as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->linksScheduledForDeletion !== null) {
                if (!$this->linksScheduledForDeletion->isEmpty()) {
                    foreach ($this->linksScheduledForDeletion as $link) {
                        // need to save related object because we set the relation to null
                        $link->save($con);
                    }
                    $this->linksScheduledForDeletion = null;
                }
            }

            if ($this->collLinks !== null) {
                foreach ($this->collLinks as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(LanguagePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(LanguagePeer::PATH_PREFIX)) {
            $modifiedColumns[':p' . $index++]  = '`PATH_PREFIX`';
        }
        if ($this->isColumnModified(LanguagePeer::IS_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = '`IS_ACTIVE`';
        }
        if ($this->isColumnModified(LanguagePeer::SORT)) {
            $modifiedColumns[':p' . $index++]  = '`SORT`';
        }
        if ($this->isColumnModified(LanguagePeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_AT`';
        }
        if ($this->isColumnModified(LanguagePeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`UPDATED_AT`';
        }
        if ($this->isColumnModified(LanguagePeer::CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`CREATED_BY`';
        }
        if ($this->isColumnModified(LanguagePeer::UPDATED_BY)) {
            $modifiedColumns[':p' . $index++]  = '`UPDATED_BY`';
        }

        $sql = sprintf(
            'INSERT INTO `languages` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_STR);
                        break;
                    case '`PATH_PREFIX`':
                        $stmt->bindValue($identifier, $this->path_prefix, PDO::PARAM_STR);
                        break;
                    case '`IS_ACTIVE`':
                        $stmt->bindValue($identifier, (int) $this->is_active, PDO::PARAM_INT);
                        break;
                    case '`SORT`':
                        $stmt->bindValue($identifier, $this->sort, PDO::PARAM_INT);
                        break;
                    case '`CREATED_AT`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`UPDATED_AT`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                    case '`CREATED_BY`':
                        $stmt->bindValue($identifier, $this->created_by, PDO::PARAM_INT);
                        break;
                    case '`UPDATED_BY`':
                        $stmt->bindValue($identifier, $this->updated_by, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

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


            if (($retval = LanguagePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collPageStrings !== null) {
                    foreach ($this->collPageStrings as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
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

                if ($this->collStrings !== null) {
                    foreach ($this->collStrings as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collUsersRelatedByLanguageId !== null) {
                    foreach ($this->collUsersRelatedByLanguageId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collDocuments !== null) {
                    foreach ($this->collDocuments as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collLinks !== null) {
                    foreach ($this->collLinks as $referrerFK) {
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
        $pos = LanguagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getPathPrefix();
                break;
            case 2:
                return $this->getIsActive();
                break;
            case 3:
                return $this->getSort();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
                return $this->getUpdatedAt();
                break;
            case 6:
                return $this->getCreatedBy();
                break;
            case 7:
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
        if (isset($alreadyDumpedObjects['Language'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Language'][$this->getPrimaryKey()] = true;
        $keys = LanguagePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPathPrefix(),
            $keys[2] => $this->getIsActive(),
            $keys[3] => $this->getSort(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getUpdatedAt(),
            $keys[6] => $this->getCreatedBy(),
            $keys[7] => $this->getUpdatedBy(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aUserRelatedByCreatedBy) {
                $result['UserRelatedByCreatedBy'] = $this->aUserRelatedByCreatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserRelatedByUpdatedBy) {
                $result['UserRelatedByUpdatedBy'] = $this->aUserRelatedByUpdatedBy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPageStrings) {
                $result['PageStrings'] = $this->collPageStrings->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLanguageObjects) {
                $result['LanguageObjects'] = $this->collLanguageObjects->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLanguageObjectHistorys) {
                $result['LanguageObjectHistorys'] = $this->collLanguageObjectHistorys->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStrings) {
                $result['Strings'] = $this->collStrings->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUsersRelatedByLanguageId) {
                $result['UsersRelatedByLanguageId'] = $this->collUsersRelatedByLanguageId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDocuments) {
                $result['Documents'] = $this->collDocuments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collLinks) {
                $result['Links'] = $this->collLinks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = LanguagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setPathPrefix($value);
                break;
            case 2:
                $this->setIsActive($value);
                break;
            case 3:
                $this->setSort($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
                $this->setUpdatedAt($value);
                break;
            case 6:
                $this->setCreatedBy($value);
                break;
            case 7:
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
        $keys = LanguagePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setPathPrefix($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIsActive($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSort($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUpdatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCreatedBy($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUpdatedBy($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(LanguagePeer::DATABASE_NAME);

        if ($this->isColumnModified(LanguagePeer::ID)) $criteria->add(LanguagePeer::ID, $this->id);
        if ($this->isColumnModified(LanguagePeer::PATH_PREFIX)) $criteria->add(LanguagePeer::PATH_PREFIX, $this->path_prefix);
        if ($this->isColumnModified(LanguagePeer::IS_ACTIVE)) $criteria->add(LanguagePeer::IS_ACTIVE, $this->is_active);
        if ($this->isColumnModified(LanguagePeer::SORT)) $criteria->add(LanguagePeer::SORT, $this->sort);
        if ($this->isColumnModified(LanguagePeer::CREATED_AT)) $criteria->add(LanguagePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(LanguagePeer::UPDATED_AT)) $criteria->add(LanguagePeer::UPDATED_AT, $this->updated_at);
        if ($this->isColumnModified(LanguagePeer::CREATED_BY)) $criteria->add(LanguagePeer::CREATED_BY, $this->created_by);
        if ($this->isColumnModified(LanguagePeer::UPDATED_BY)) $criteria->add(LanguagePeer::UPDATED_BY, $this->updated_by);

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
        $criteria = new Criteria(LanguagePeer::DATABASE_NAME);
        $criteria->add(LanguagePeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  string $key Primary key.
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
     * @param object $copyObj An object of Language (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPathPrefix($this->getPathPrefix());
        $copyObj->setIsActive($this->getIsActive());
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

            foreach ($this->getPageStrings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPageString($relObj->copy($deepCopy));
                }
            }

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

            foreach ($this->getStrings() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addString($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUsersRelatedByLanguageId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserRelatedByLanguageId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDocuments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDocument($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getLinks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addLink($relObj->copy($deepCopy));
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
     * @return Language Clone of current object.
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
     * @return LanguagePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new LanguagePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return Language The current object (for fluent API support)
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
            $v->addLanguageRelatedByCreatedBy($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUserRelatedByCreatedBy(PropelPDO $con = null)
    {
        if ($this->aUserRelatedByCreatedBy === null && ($this->created_by !== null)) {
            $this->aUserRelatedByCreatedBy = UserQuery::create()->findPk($this->created_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByCreatedBy->addLanguagesRelatedByCreatedBy($this);
             */
        }

        return $this->aUserRelatedByCreatedBy;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return Language The current object (for fluent API support)
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
            $v->addLanguageRelatedByUpdatedBy($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUserRelatedByUpdatedBy(PropelPDO $con = null)
    {
        if ($this->aUserRelatedByUpdatedBy === null && ($this->updated_by !== null)) {
            $this->aUserRelatedByUpdatedBy = UserQuery::create()->findPk($this->updated_by, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserRelatedByUpdatedBy->addLanguagesRelatedByUpdatedBy($this);
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
        if ('PageString' == $relationName) {
            $this->initPageStrings();
        }
        if ('LanguageObject' == $relationName) {
            $this->initLanguageObjects();
        }
        if ('LanguageObjectHistory' == $relationName) {
            $this->initLanguageObjectHistorys();
        }
        if ('String' == $relationName) {
            $this->initStrings();
        }
        if ('UserRelatedByLanguageId' == $relationName) {
            $this->initUsersRelatedByLanguageId();
        }
        if ('Document' == $relationName) {
            $this->initDocuments();
        }
        if ('Link' == $relationName) {
            $this->initLinks();
        }
    }

    /**
     * Clears out the collPageStrings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPageStrings()
     */
    public function clearPageStrings()
    {
        $this->collPageStrings = null; // important to set this to null since that means it is uninitialized
        $this->collPageStringsPartial = null;
    }

    /**
     * reset is the collPageStrings collection loaded partially
     *
     * @return void
     */
    public function resetPartialPageStrings($v = true)
    {
        $this->collPageStringsPartial = $v;
    }

    /**
     * Initializes the collPageStrings collection.
     *
     * By default this just sets the collPageStrings collection to an empty array (like clearcollPageStrings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPageStrings($overrideExisting = true)
    {
        if (null !== $this->collPageStrings && !$overrideExisting) {
            return;
        }
        $this->collPageStrings = new PropelObjectCollection();
        $this->collPageStrings->setModel('PageString');
    }

    /**
     * Gets an array of PageString objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Language is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PageString[] List of PageString objects
     * @throws PropelException
     */
    public function getPageStrings($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPageStringsPartial && !$this->isNew();
        if (null === $this->collPageStrings || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPageStrings) {
                // return empty collection
                $this->initPageStrings();
            } else {
                $collPageStrings = PageStringQuery::create(null, $criteria)
                    ->filterByLanguage($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPageStringsPartial && count($collPageStrings)) {
                      $this->initPageStrings(false);

                      foreach($collPageStrings as $obj) {
                        if (false == $this->collPageStrings->contains($obj)) {
                          $this->collPageStrings->append($obj);
                        }
                      }

                      $this->collPageStringsPartial = true;
                    }

                    return $collPageStrings;
                }

                if($partial && $this->collPageStrings) {
                    foreach($this->collPageStrings as $obj) {
                        if($obj->isNew()) {
                            $collPageStrings[] = $obj;
                        }
                    }
                }

                $this->collPageStrings = $collPageStrings;
                $this->collPageStringsPartial = false;
            }
        }

        return $this->collPageStrings;
    }

    /**
     * Sets a collection of PageString objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pageStrings A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setPageStrings(PropelCollection $pageStrings, PropelPDO $con = null)
    {
        $this->pageStringsScheduledForDeletion = $this->getPageStrings(new Criteria(), $con)->diff($pageStrings);

        foreach ($this->pageStringsScheduledForDeletion as $pageStringRemoved) {
            $pageStringRemoved->setLanguage(null);
        }

        $this->collPageStrings = null;
        foreach ($pageStrings as $pageString) {
            $this->addPageString($pageString);
        }

        $this->collPageStrings = $pageStrings;
        $this->collPageStringsPartial = false;
    }

    /**
     * Returns the number of related PageString objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PageString objects.
     * @throws PropelException
     */
    public function countPageStrings(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPageStringsPartial && !$this->isNew();
        if (null === $this->collPageStrings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPageStrings) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getPageStrings());
                }
                $query = PageStringQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguage($this)
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
     * @param    PageString $l PageString
     * @return Language The current object (for fluent API support)
     */
    public function addPageString(PageString $l)
    {
        if ($this->collPageStrings === null) {
            $this->initPageStrings();
            $this->collPageStringsPartial = true;
        }
        if (!$this->collPageStrings->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddPageString($l);
        }

        return $this;
    }

    /**
     * @param	PageString $pageString The pageString object to add.
     */
    protected function doAddPageString($pageString)
    {
        $this->collPageStrings[]= $pageString;
        $pageString->setLanguage($this);
    }

    /**
     * @param	PageString $pageString The pageString object to remove.
     */
    public function removePageString($pageString)
    {
        if ($this->getPageStrings()->contains($pageString)) {
            $this->collPageStrings->remove($this->collPageStrings->search($pageString));
            if (null === $this->pageStringsScheduledForDeletion) {
                $this->pageStringsScheduledForDeletion = clone $this->collPageStrings;
                $this->pageStringsScheduledForDeletion->clear();
            }
            $this->pageStringsScheduledForDeletion[]= $pageString;
            $pageString->setLanguage(null);
        }
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PageString[] List of PageString objects
     */
    public function getPageStringsJoinPage($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PageStringQuery::create(null, $criteria);
        $query->joinWith('Page', $join_behavior);

        return $this->getPageStrings($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PageString[] List of PageString objects
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
     * Otherwise if this Language is new, it will return
     * an empty collection; or if this Language has previously
     * been saved, it will retrieve related PageStrings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Language.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PageString[] List of PageString objects
     */
    public function getPageStringsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PageStringQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

        return $this->getPageStrings($query, $con);
    }

    /**
     * Clears out the collLanguageObjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addLanguageObjects()
     */
    public function clearLanguageObjects()
    {
        $this->collLanguageObjects = null; // important to set this to null since that means it is uninitialized
        $this->collLanguageObjectsPartial = null;
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
     * If this Language is new, it will return
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
                    ->filterByLanguage($this)
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
     */
    public function setLanguageObjects(PropelCollection $languageObjects, PropelPDO $con = null)
    {
        $this->languageObjectsScheduledForDeletion = $this->getLanguageObjects(new Criteria(), $con)->diff($languageObjects);

        foreach ($this->languageObjectsScheduledForDeletion as $languageObjectRemoved) {
            $languageObjectRemoved->setLanguage(null);
        }

        $this->collLanguageObjects = null;
        foreach ($languageObjects as $languageObject) {
            $this->addLanguageObject($languageObject);
        }

        $this->collLanguageObjects = $languageObjects;
        $this->collLanguageObjectsPartial = false;
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
            } else {
                if($partial && !$criteria) {
                    return count($this->getLanguageObjects());
                }
                $query = LanguageObjectQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguage($this)
                    ->count($con);
            }
        } else {
            return count($this->collLanguageObjects);
        }
    }

    /**
     * Method called to associate a LanguageObject object to this object
     * through the LanguageObject foreign key attribute.
     *
     * @param    LanguageObject $l LanguageObject
     * @return Language The current object (for fluent API support)
     */
    public function addLanguageObject(LanguageObject $l)
    {
        if ($this->collLanguageObjects === null) {
            $this->initLanguageObjects();
            $this->collLanguageObjectsPartial = true;
        }
        if (!$this->collLanguageObjects->contains($l)) { // only add it if the **same** object is not already associated
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
        $languageObject->setLanguage($this);
    }

    /**
     * @param	LanguageObject $languageObject The languageObject object to remove.
     */
    public function removeLanguageObject($languageObject)
    {
        if ($this->getLanguageObjects()->contains($languageObject)) {
            $this->collLanguageObjects->remove($this->collLanguageObjects->search($languageObject));
            if (null === $this->languageObjectsScheduledForDeletion) {
                $this->languageObjectsScheduledForDeletion = clone $this->collLanguageObjects;
                $this->languageObjectsScheduledForDeletion->clear();
            }
            $this->languageObjectsScheduledForDeletion[]= $languageObject;
            $languageObject->setLanguage(null);
        }
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObject[] List of LanguageObject objects
     */
    public function getLanguageObjectsJoinContentObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectQuery::create(null, $criteria);
        $query->joinWith('ContentObject', $join_behavior);

        return $this->getLanguageObjects($query, $con);
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
     * Otherwise if this Language is new, it will return
     * an empty collection; or if this Language has previously
     * been saved, it will retrieve related LanguageObjects from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Language.
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
     * @return void
     * @see        addLanguageObjectHistorys()
     */
    public function clearLanguageObjectHistorys()
    {
        $this->collLanguageObjectHistorys = null; // important to set this to null since that means it is uninitialized
        $this->collLanguageObjectHistorysPartial = null;
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
     * If this Language is new, it will return
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
                    ->filterByLanguage($this)
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
     */
    public function setLanguageObjectHistorys(PropelCollection $languageObjectHistorys, PropelPDO $con = null)
    {
        $this->languageObjectHistorysScheduledForDeletion = $this->getLanguageObjectHistorys(new Criteria(), $con)->diff($languageObjectHistorys);

        foreach ($this->languageObjectHistorysScheduledForDeletion as $languageObjectHistoryRemoved) {
            $languageObjectHistoryRemoved->setLanguage(null);
        }

        $this->collLanguageObjectHistorys = null;
        foreach ($languageObjectHistorys as $languageObjectHistory) {
            $this->addLanguageObjectHistory($languageObjectHistory);
        }

        $this->collLanguageObjectHistorys = $languageObjectHistorys;
        $this->collLanguageObjectHistorysPartial = false;
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
            } else {
                if($partial && !$criteria) {
                    return count($this->getLanguageObjectHistorys());
                }
                $query = LanguageObjectHistoryQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguage($this)
                    ->count($con);
            }
        } else {
            return count($this->collLanguageObjectHistorys);
        }
    }

    /**
     * Method called to associate a LanguageObjectHistory object to this object
     * through the LanguageObjectHistory foreign key attribute.
     *
     * @param    LanguageObjectHistory $l LanguageObjectHistory
     * @return Language The current object (for fluent API support)
     */
    public function addLanguageObjectHistory(LanguageObjectHistory $l)
    {
        if ($this->collLanguageObjectHistorys === null) {
            $this->initLanguageObjectHistorys();
            $this->collLanguageObjectHistorysPartial = true;
        }
        if (!$this->collLanguageObjectHistorys->contains($l)) { // only add it if the **same** object is not already associated
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
        $languageObjectHistory->setLanguage($this);
    }

    /**
     * @param	LanguageObjectHistory $languageObjectHistory The languageObjectHistory object to remove.
     */
    public function removeLanguageObjectHistory($languageObjectHistory)
    {
        if ($this->getLanguageObjectHistorys()->contains($languageObjectHistory)) {
            $this->collLanguageObjectHistorys->remove($this->collLanguageObjectHistorys->search($languageObjectHistory));
            if (null === $this->languageObjectHistorysScheduledForDeletion) {
                $this->languageObjectHistorysScheduledForDeletion = clone $this->collLanguageObjectHistorys;
                $this->languageObjectHistorysScheduledForDeletion->clear();
            }
            $this->languageObjectHistorysScheduledForDeletion[]= $languageObjectHistory;
            $languageObjectHistory->setLanguage(null);
        }
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|LanguageObjectHistory[] List of LanguageObjectHistory objects
     */
    public function getLanguageObjectHistorysJoinContentObject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LanguageObjectHistoryQuery::create(null, $criteria);
        $query->joinWith('ContentObject', $join_behavior);

        return $this->getLanguageObjectHistorys($query, $con);
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
     * Otherwise if this Language is new, it will return
     * an empty collection; or if this Language has previously
     * been saved, it will retrieve related LanguageObjectHistorys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Language.
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
     * Clears out the collStrings collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStrings()
     */
    public function clearStrings()
    {
        $this->collStrings = null; // important to set this to null since that means it is uninitialized
        $this->collStringsPartial = null;
    }

    /**
     * reset is the collStrings collection loaded partially
     *
     * @return void
     */
    public function resetPartialStrings($v = true)
    {
        $this->collStringsPartial = $v;
    }

    /**
     * Initializes the collStrings collection.
     *
     * By default this just sets the collStrings collection to an empty array (like clearcollStrings());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStrings($overrideExisting = true)
    {
        if (null !== $this->collStrings && !$overrideExisting) {
            return;
        }
        $this->collStrings = new PropelObjectCollection();
        $this->collStrings->setModel('String');
    }

    /**
     * Gets an array of String objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Language is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|String[] List of String objects
     * @throws PropelException
     */
    public function getStrings($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStringsPartial && !$this->isNew();
        if (null === $this->collStrings || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStrings) {
                // return empty collection
                $this->initStrings();
            } else {
                $collStrings = StringQuery::create(null, $criteria)
                    ->filterByLanguage($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStringsPartial && count($collStrings)) {
                      $this->initStrings(false);

                      foreach($collStrings as $obj) {
                        if (false == $this->collStrings->contains($obj)) {
                          $this->collStrings->append($obj);
                        }
                      }

                      $this->collStringsPartial = true;
                    }

                    return $collStrings;
                }

                if($partial && $this->collStrings) {
                    foreach($this->collStrings as $obj) {
                        if($obj->isNew()) {
                            $collStrings[] = $obj;
                        }
                    }
                }

                $this->collStrings = $collStrings;
                $this->collStringsPartial = false;
            }
        }

        return $this->collStrings;
    }

    /**
     * Sets a collection of String objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $strings A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setStrings(PropelCollection $strings, PropelPDO $con = null)
    {
        $this->stringsScheduledForDeletion = $this->getStrings(new Criteria(), $con)->diff($strings);

        foreach ($this->stringsScheduledForDeletion as $stringRemoved) {
            $stringRemoved->setLanguage(null);
        }

        $this->collStrings = null;
        foreach ($strings as $string) {
            $this->addString($string);
        }

        $this->collStrings = $strings;
        $this->collStringsPartial = false;
    }

    /**
     * Returns the number of related String objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related String objects.
     * @throws PropelException
     */
    public function countStrings(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStringsPartial && !$this->isNew();
        if (null === $this->collStrings || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStrings) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getStrings());
                }
                $query = StringQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguage($this)
                    ->count($con);
            }
        } else {
            return count($this->collStrings);
        }
    }

    /**
     * Method called to associate a String object to this object
     * through the String foreign key attribute.
     *
     * @param    String $l String
     * @return Language The current object (for fluent API support)
     */
    public function addString(String $l)
    {
        if ($this->collStrings === null) {
            $this->initStrings();
            $this->collStringsPartial = true;
        }
        if (!$this->collStrings->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddString($l);
        }

        return $this;
    }

    /**
     * @param	String $string The string object to add.
     */
    protected function doAddString($string)
    {
        $this->collStrings[]= $string;
        $string->setLanguage($this);
    }

    /**
     * @param	String $string The string object to remove.
     */
    public function removeString($string)
    {
        if ($this->getStrings()->contains($string)) {
            $this->collStrings->remove($this->collStrings->search($string));
            if (null === $this->stringsScheduledForDeletion) {
                $this->stringsScheduledForDeletion = clone $this->collStrings;
                $this->stringsScheduledForDeletion->clear();
            }
            $this->stringsScheduledForDeletion[]= $string;
            $string->setLanguage(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Language is new, it will return
     * an empty collection; or if this Language has previously
     * been saved, it will retrieve related Strings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Language.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|String[] List of String objects
     */
    public function getStringsJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StringQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $join_behavior);

        return $this->getStrings($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Language is new, it will return
     * an empty collection; or if this Language has previously
     * been saved, it will retrieve related Strings from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Language.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|String[] List of String objects
     */
    public function getStringsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StringQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

        return $this->getStrings($query, $con);
    }

    /**
     * Clears out the collUsersRelatedByLanguageId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUsersRelatedByLanguageId()
     */
    public function clearUsersRelatedByLanguageId()
    {
        $this->collUsersRelatedByLanguageId = null; // important to set this to null since that means it is uninitialized
        $this->collUsersRelatedByLanguageIdPartial = null;
    }

    /**
     * reset is the collUsersRelatedByLanguageId collection loaded partially
     *
     * @return void
     */
    public function resetPartialUsersRelatedByLanguageId($v = true)
    {
        $this->collUsersRelatedByLanguageIdPartial = $v;
    }

    /**
     * Initializes the collUsersRelatedByLanguageId collection.
     *
     * By default this just sets the collUsersRelatedByLanguageId collection to an empty array (like clearcollUsersRelatedByLanguageId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUsersRelatedByLanguageId($overrideExisting = true)
    {
        if (null !== $this->collUsersRelatedByLanguageId && !$overrideExisting) {
            return;
        }
        $this->collUsersRelatedByLanguageId = new PropelObjectCollection();
        $this->collUsersRelatedByLanguageId->setModel('User');
    }

    /**
     * Gets an array of User objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Language is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|User[] List of User objects
     * @throws PropelException
     */
    public function getUsersRelatedByLanguageId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUsersRelatedByLanguageIdPartial && !$this->isNew();
        if (null === $this->collUsersRelatedByLanguageId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUsersRelatedByLanguageId) {
                // return empty collection
                $this->initUsersRelatedByLanguageId();
            } else {
                $collUsersRelatedByLanguageId = UserQuery::create(null, $criteria)
                    ->filterByLanguageRelatedByLanguageId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUsersRelatedByLanguageIdPartial && count($collUsersRelatedByLanguageId)) {
                      $this->initUsersRelatedByLanguageId(false);

                      foreach($collUsersRelatedByLanguageId as $obj) {
                        if (false == $this->collUsersRelatedByLanguageId->contains($obj)) {
                          $this->collUsersRelatedByLanguageId->append($obj);
                        }
                      }

                      $this->collUsersRelatedByLanguageIdPartial = true;
                    }

                    return $collUsersRelatedByLanguageId;
                }

                if($partial && $this->collUsersRelatedByLanguageId) {
                    foreach($this->collUsersRelatedByLanguageId as $obj) {
                        if($obj->isNew()) {
                            $collUsersRelatedByLanguageId[] = $obj;
                        }
                    }
                }

                $this->collUsersRelatedByLanguageId = $collUsersRelatedByLanguageId;
                $this->collUsersRelatedByLanguageIdPartial = false;
            }
        }

        return $this->collUsersRelatedByLanguageId;
    }

    /**
     * Sets a collection of UserRelatedByLanguageId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $usersRelatedByLanguageId A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setUsersRelatedByLanguageId(PropelCollection $usersRelatedByLanguageId, PropelPDO $con = null)
    {
        $this->usersRelatedByLanguageIdScheduledForDeletion = $this->getUsersRelatedByLanguageId(new Criteria(), $con)->diff($usersRelatedByLanguageId);

        foreach ($this->usersRelatedByLanguageIdScheduledForDeletion as $userRelatedByLanguageIdRemoved) {
            $userRelatedByLanguageIdRemoved->setLanguageRelatedByLanguageId(null);
        }

        $this->collUsersRelatedByLanguageId = null;
        foreach ($usersRelatedByLanguageId as $userRelatedByLanguageId) {
            $this->addUserRelatedByLanguageId($userRelatedByLanguageId);
        }

        $this->collUsersRelatedByLanguageId = $usersRelatedByLanguageId;
        $this->collUsersRelatedByLanguageIdPartial = false;
    }

    /**
     * Returns the number of related User objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related User objects.
     * @throws PropelException
     */
    public function countUsersRelatedByLanguageId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUsersRelatedByLanguageIdPartial && !$this->isNew();
        if (null === $this->collUsersRelatedByLanguageId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUsersRelatedByLanguageId) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getUsersRelatedByLanguageId());
                }
                $query = UserQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguageRelatedByLanguageId($this)
                    ->count($con);
            }
        } else {
            return count($this->collUsersRelatedByLanguageId);
        }
    }

    /**
     * Method called to associate a User object to this object
     * through the User foreign key attribute.
     *
     * @param    User $l User
     * @return Language The current object (for fluent API support)
     */
    public function addUserRelatedByLanguageId(User $l)
    {
        if ($this->collUsersRelatedByLanguageId === null) {
            $this->initUsersRelatedByLanguageId();
            $this->collUsersRelatedByLanguageIdPartial = true;
        }
        if (!$this->collUsersRelatedByLanguageId->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddUserRelatedByLanguageId($l);
        }

        return $this;
    }

    /**
     * @param	UserRelatedByLanguageId $userRelatedByLanguageId The userRelatedByLanguageId object to add.
     */
    protected function doAddUserRelatedByLanguageId($userRelatedByLanguageId)
    {
        $this->collUsersRelatedByLanguageId[]= $userRelatedByLanguageId;
        $userRelatedByLanguageId->setLanguageRelatedByLanguageId($this);
    }

    /**
     * @param	UserRelatedByLanguageId $userRelatedByLanguageId The userRelatedByLanguageId object to remove.
     */
    public function removeUserRelatedByLanguageId($userRelatedByLanguageId)
    {
        if ($this->getUsersRelatedByLanguageId()->contains($userRelatedByLanguageId)) {
            $this->collUsersRelatedByLanguageId->remove($this->collUsersRelatedByLanguageId->search($userRelatedByLanguageId));
            if (null === $this->usersRelatedByLanguageIdScheduledForDeletion) {
                $this->usersRelatedByLanguageIdScheduledForDeletion = clone $this->collUsersRelatedByLanguageId;
                $this->usersRelatedByLanguageIdScheduledForDeletion->clear();
            }
            $this->usersRelatedByLanguageIdScheduledForDeletion[]= $userRelatedByLanguageId;
            $userRelatedByLanguageId->setLanguageRelatedByLanguageId(null);
        }
    }

    /**
     * Clears out the collDocuments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDocuments()
     */
    public function clearDocuments()
    {
        $this->collDocuments = null; // important to set this to null since that means it is uninitialized
        $this->collDocumentsPartial = null;
    }

    /**
     * reset is the collDocuments collection loaded partially
     *
     * @return void
     */
    public function resetPartialDocuments($v = true)
    {
        $this->collDocumentsPartial = $v;
    }

    /**
     * Initializes the collDocuments collection.
     *
     * By default this just sets the collDocuments collection to an empty array (like clearcollDocuments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDocuments($overrideExisting = true)
    {
        if (null !== $this->collDocuments && !$overrideExisting) {
            return;
        }
        $this->collDocuments = new PropelObjectCollection();
        $this->collDocuments->setModel('Document');
    }

    /**
     * Gets an array of Document objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Language is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Document[] List of Document objects
     * @throws PropelException
     */
    public function getDocuments($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collDocumentsPartial && !$this->isNew();
        if (null === $this->collDocuments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDocuments) {
                // return empty collection
                $this->initDocuments();
            } else {
                $collDocuments = DocumentQuery::create(null, $criteria)
                    ->filterByLanguage($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collDocumentsPartial && count($collDocuments)) {
                      $this->initDocuments(false);

                      foreach($collDocuments as $obj) {
                        if (false == $this->collDocuments->contains($obj)) {
                          $this->collDocuments->append($obj);
                        }
                      }

                      $this->collDocumentsPartial = true;
                    }

                    return $collDocuments;
                }

                if($partial && $this->collDocuments) {
                    foreach($this->collDocuments as $obj) {
                        if($obj->isNew()) {
                            $collDocuments[] = $obj;
                        }
                    }
                }

                $this->collDocuments = $collDocuments;
                $this->collDocumentsPartial = false;
            }
        }

        return $this->collDocuments;
    }

    /**
     * Sets a collection of Document objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $documents A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setDocuments(PropelCollection $documents, PropelPDO $con = null)
    {
        $this->documentsScheduledForDeletion = $this->getDocuments(new Criteria(), $con)->diff($documents);

        foreach ($this->documentsScheduledForDeletion as $documentRemoved) {
            $documentRemoved->setLanguage(null);
        }

        $this->collDocuments = null;
        foreach ($documents as $document) {
            $this->addDocument($document);
        }

        $this->collDocuments = $documents;
        $this->collDocumentsPartial = false;
    }

    /**
     * Returns the number of related Document objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Document objects.
     * @throws PropelException
     */
    public function countDocuments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collDocumentsPartial && !$this->isNew();
        if (null === $this->collDocuments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDocuments) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getDocuments());
                }
                $query = DocumentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguage($this)
                    ->count($con);
            }
        } else {
            return count($this->collDocuments);
        }
    }

    /**
     * Method called to associate a Document object to this object
     * through the Document foreign key attribute.
     *
     * @param    Document $l Document
     * @return Language The current object (for fluent API support)
     */
    public function addDocument(Document $l)
    {
        if ($this->collDocuments === null) {
            $this->initDocuments();
            $this->collDocumentsPartial = true;
        }
        if (!$this->collDocuments->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddDocument($l);
        }

        return $this;
    }

    /**
     * @param	Document $document The document object to add.
     */
    protected function doAddDocument($document)
    {
        $this->collDocuments[]= $document;
        $document->setLanguage($this);
    }

    /**
     * @param	Document $document The document object to remove.
     */
    public function removeDocument($document)
    {
        if ($this->getDocuments()->contains($document)) {
            $this->collDocuments->remove($this->collDocuments->search($document));
            if (null === $this->documentsScheduledForDeletion) {
                $this->documentsScheduledForDeletion = clone $this->collDocuments;
                $this->documentsScheduledForDeletion->clear();
            }
            $this->documentsScheduledForDeletion[]= $document;
            $document->setLanguage(null);
        }
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Document[] List of Document objects
     */
    public function getDocumentsJoinUserRelatedByOwnerId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DocumentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByOwnerId', $join_behavior);

        return $this->getDocuments($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Document[] List of Document objects
     */
    public function getDocumentsJoinDocumentType($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DocumentQuery::create(null, $criteria);
        $query->joinWith('DocumentType', $join_behavior);

        return $this->getDocuments($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Document[] List of Document objects
     */
    public function getDocumentsJoinDocumentCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DocumentQuery::create(null, $criteria);
        $query->joinWith('DocumentCategory', $join_behavior);

        return $this->getDocuments($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Document[] List of Document objects
     */
    public function getDocumentsJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DocumentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $join_behavior);

        return $this->getDocuments($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Document[] List of Document objects
     */
    public function getDocumentsJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DocumentQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

        return $this->getDocuments($query, $con);
    }

    /**
     * Clears out the collLinks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addLinks()
     */
    public function clearLinks()
    {
        $this->collLinks = null; // important to set this to null since that means it is uninitialized
        $this->collLinksPartial = null;
    }

    /**
     * reset is the collLinks collection loaded partially
     *
     * @return void
     */
    public function resetPartialLinks($v = true)
    {
        $this->collLinksPartial = $v;
    }

    /**
     * Initializes the collLinks collection.
     *
     * By default this just sets the collLinks collection to an empty array (like clearcollLinks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initLinks($overrideExisting = true)
    {
        if (null !== $this->collLinks && !$overrideExisting) {
            return;
        }
        $this->collLinks = new PropelObjectCollection();
        $this->collLinks->setModel('Link');
    }

    /**
     * Gets an array of Link objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Language is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Link[] List of Link objects
     * @throws PropelException
     */
    public function getLinks($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collLinksPartial && !$this->isNew();
        if (null === $this->collLinks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collLinks) {
                // return empty collection
                $this->initLinks();
            } else {
                $collLinks = LinkQuery::create(null, $criteria)
                    ->filterByLanguage($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collLinksPartial && count($collLinks)) {
                      $this->initLinks(false);

                      foreach($collLinks as $obj) {
                        if (false == $this->collLinks->contains($obj)) {
                          $this->collLinks->append($obj);
                        }
                      }

                      $this->collLinksPartial = true;
                    }

                    return $collLinks;
                }

                if($partial && $this->collLinks) {
                    foreach($this->collLinks as $obj) {
                        if($obj->isNew()) {
                            $collLinks[] = $obj;
                        }
                    }
                }

                $this->collLinks = $collLinks;
                $this->collLinksPartial = false;
            }
        }

        return $this->collLinks;
    }

    /**
     * Sets a collection of Link objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $links A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setLinks(PropelCollection $links, PropelPDO $con = null)
    {
        $this->linksScheduledForDeletion = $this->getLinks(new Criteria(), $con)->diff($links);

        foreach ($this->linksScheduledForDeletion as $linkRemoved) {
            $linkRemoved->setLanguage(null);
        }

        $this->collLinks = null;
        foreach ($links as $link) {
            $this->addLink($link);
        }

        $this->collLinks = $links;
        $this->collLinksPartial = false;
    }

    /**
     * Returns the number of related Link objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Link objects.
     * @throws PropelException
     */
    public function countLinks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collLinksPartial && !$this->isNew();
        if (null === $this->collLinks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collLinks) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getLinks());
                }
                $query = LinkQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByLanguage($this)
                    ->count($con);
            }
        } else {
            return count($this->collLinks);
        }
    }

    /**
     * Method called to associate a Link object to this object
     * through the Link foreign key attribute.
     *
     * @param    Link $l Link
     * @return Language The current object (for fluent API support)
     */
    public function addLink(Link $l)
    {
        if ($this->collLinks === null) {
            $this->initLinks();
            $this->collLinksPartial = true;
        }
        if (!$this->collLinks->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddLink($l);
        }

        return $this;
    }

    /**
     * @param	Link $link The link object to add.
     */
    protected function doAddLink($link)
    {
        $this->collLinks[]= $link;
        $link->setLanguage($this);
    }

    /**
     * @param	Link $link The link object to remove.
     */
    public function removeLink($link)
    {
        if ($this->getLinks()->contains($link)) {
            $this->collLinks->remove($this->collLinks->search($link));
            if (null === $this->linksScheduledForDeletion) {
                $this->linksScheduledForDeletion = clone $this->collLinks;
                $this->linksScheduledForDeletion->clear();
            }
            $this->linksScheduledForDeletion[]= $link;
            $link->setLanguage(null);
        }
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Link[] List of Link objects
     */
    public function getLinksJoinUserRelatedByOwnerId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LinkQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByOwnerId', $join_behavior);

        return $this->getLinks($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Link[] List of Link objects
     */
    public function getLinksJoinLinkCategory($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LinkQuery::create(null, $criteria);
        $query->joinWith('LinkCategory', $join_behavior);

        return $this->getLinks($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Link[] List of Link objects
     */
    public function getLinksJoinUserRelatedByCreatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LinkQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByCreatedBy', $join_behavior);

        return $this->getLinks($query, $con);
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
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Link[] List of Link objects
     */
    public function getLinksJoinUserRelatedByUpdatedBy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = LinkQuery::create(null, $criteria);
        $query->joinWith('UserRelatedByUpdatedBy', $join_behavior);

        return $this->getLinks($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->path_prefix = null;
        $this->is_active = null;
        $this->sort = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->created_by = null;
        $this->updated_by = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
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
        if ($deep) {
            if ($this->collPageStrings) {
                foreach ($this->collPageStrings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
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
            if ($this->collStrings) {
                foreach ($this->collStrings as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUsersRelatedByLanguageId) {
                foreach ($this->collUsersRelatedByLanguageId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDocuments) {
                foreach ($this->collDocuments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collLinks) {
                foreach ($this->collLinks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collPageStrings instanceof PropelCollection) {
            $this->collPageStrings->clearIterator();
        }
        $this->collPageStrings = null;
        if ($this->collLanguageObjects instanceof PropelCollection) {
            $this->collLanguageObjects->clearIterator();
        }
        $this->collLanguageObjects = null;
        if ($this->collLanguageObjectHistorys instanceof PropelCollection) {
            $this->collLanguageObjectHistorys->clearIterator();
        }
        $this->collLanguageObjectHistorys = null;
        if ($this->collStrings instanceof PropelCollection) {
            $this->collStrings->clearIterator();
        }
        $this->collStrings = null;
        if ($this->collUsersRelatedByLanguageId instanceof PropelCollection) {
            $this->collUsersRelatedByLanguageId->clearIterator();
        }
        $this->collUsersRelatedByLanguageId = null;
        if ($this->collDocuments instanceof PropelCollection) {
            $this->collDocuments->clearIterator();
        }
        $this->collDocuments = null;
        if ($this->collLinks instanceof PropelCollection) {
            $this->collLinks->clearIterator();
        }
        $this->collLinks = null;
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
        return (string) $this->exportTo(LanguagePeer::DEFAULT_STRING_FORMAT);
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
        if($oUser && ($this->isNew() || $this->getCreatedBy() === $oUser->getId()) && LanguagePeer::mayOperateOnOwn($oUser, $this, $sOperation)) {
            $bIsAllowed = true;
        } else if(LanguagePeer::mayOperateOn($oUser, $this, $sOperation)) {
            $bIsAllowed = true;
        }
        FilterModule::getFilters()->handleLanguageOperationCheck($sOperation, $this, $oUser, array(&$bIsAllowed));
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
     * @return     Language The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = LanguagePeer::UPDATED_AT;

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
     * @return     Language The current object (for fluent API support)
     */
    public function keepUpdateUserUnchanged()
    {
        $this->modifiedColumns[] = LanguagePeer::UPDATED_BY;
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
