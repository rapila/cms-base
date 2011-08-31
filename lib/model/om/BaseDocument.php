<?php


/**
 * Base class that represents a row from the 'documents' table.
 *
 * 
 *
 * @package    propel.generator.model.om
 */
abstract class BaseDocument extends BaseObject  implements Persistent
{

	/**
	 * Peer class name
	 */
	const PEER = 'DocumentPeer';

	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        DocumentPeer
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
	 * The value for the original_name field.
	 * @var        string
	 */
	protected $original_name;

	/**
	 * The value for the description field.
	 * @var        string
	 */
	protected $description;

	/**
	 * The value for the content_created_at field.
	 * @var        string
	 */
	protected $content_created_at;

	/**
	 * The value for the license field.
	 * @var        string
	 */
	protected $license;

	/**
	 * The value for the author field.
	 * @var        string
	 */
	protected $author;

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
	 * The value for the document_type_id field.
	 * @var        int
	 */
	protected $document_type_id;

	/**
	 * The value for the document_category_id field.
	 * @var        int
	 */
	protected $document_category_id;

	/**
	 * The value for the is_private field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_private;

	/**
	 * The value for the is_inactive field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_inactive;

	/**
	 * The value for the is_protected field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $is_protected;

	/**
	 * The value for the sort field.
	 * @var        int
	 */
	protected $sort;

	/**
	 * The value for the data field.
	 * @var        resource
	 */
	protected $data;

	/**
	 * Whether the lazy-loaded $data value has been loaded from database.
	 * This is necessary to avoid repeated lookups if $data column is NULL in the db.
	 * @var        boolean
	 */
	protected $data_isLoaded = false;

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
	 * @var        Language
	 */
	protected $aLanguage;

	/**
	 * @var        User
	 */
	protected $aUserRelatedByOwnerId;

	/**
	 * @var        DocumentType
	 */
	protected $aDocumentType;

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
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_private = false;
		$this->is_inactive = false;
		$this->is_protected = false;
	}

	/**
	 * Initializes internal state of BaseDocument object.
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
	 * Get the [original_name] column value.
	 * 
	 * @return     string
	 */
	public function getOriginalName()
	{
		return $this->original_name;
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
	 * Get the [optionally formatted] temporal [content_created_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getContentCreatedAt($format = '%x')
	{
		if ($this->content_created_at === null) {
			return null;
		}


		if ($this->content_created_at === '0000-00-00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->content_created_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->content_created_at, true), $x);
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
	 * Get the [license] column value.
	 * 
	 * @return     string
	 */
	public function getLicense()
	{
		return $this->license;
	}

	/**
	 * Get the [author] column value.
	 * 
	 * @return     string
	 */
	public function getAuthor()
	{
		return $this->author;
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
	 * Get the [document_type_id] column value.
	 * 
	 * @return     int
	 */
	public function getDocumentTypeId()
	{
		return $this->document_type_id;
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
	 * Get the [is_protected] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsProtected()
	{
		return $this->is_protected;
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
	 * Get the [data] column value.
	 * 
	 * @param      PropelPDO An optional PropelPDO connection to use for fetching this lazy-loaded column.
	 * @return     resource
	 */
	public function getData(PropelPDO $con = null)
	{
		if (!$this->data_isLoaded && $this->data === null && !$this->isNew()) {
			$this->loadData($con);
		}

		return $this->data;
	}

	/**
	 * Load the value for the lazy-loaded [data] column.
	 *
	 * This method performs an additional query to return the value for
	 * the [data] column, since it is not populated by
	 * the hydrate() method.
	 *
	 * @param      $con PropelPDO (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - any underlying error will be wrapped and re-thrown.
	 */
	protected function loadData(PropelPDO $con = null)
	{
		$c = $this->buildPkeyCriteria();
		$c->addSelectColumn(DocumentPeer::DATA);
		try {
			$stmt = DocumentPeer::doSelectStmt($c, $con);
			$row = $stmt->fetch(PDO::FETCH_NUM);
			$stmt->closeCursor();
			if ($row[0] !== null) {
				$this->data = fopen('php://memory', 'r+');
				fwrite($this->data, $row[0]);
				rewind($this->data);
			} else {
				$this->data = null;
			}
			$this->data_isLoaded = true;
		} catch (Exception $e) {
			throw new PropelException("Error loading value for [data] column on demand.", $e);
		}
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
	 * @return     Document The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = DocumentPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [name] column.
	 * 
	 * @param      string $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = DocumentPeer::NAME;
		}

		return $this;
	} // setName()

	/**
	 * Set the value of [original_name] column.
	 * 
	 * @param      string $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setOriginalName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->original_name !== $v) {
			$this->original_name = $v;
			$this->modifiedColumns[] = DocumentPeer::ORIGINAL_NAME;
		}

		return $this;
	} // setOriginalName()

	/**
	 * Set the value of [description] column.
	 * 
	 * @param      string $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setDescription($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = DocumentPeer::DESCRIPTION;
		}

		return $this;
	} // setDescription()

	/**
	 * Sets the value of [content_created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Document The current object (for fluent API support)
	 */
	public function setContentCreatedAt($v)
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

		if ( $this->content_created_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->content_created_at !== null && $tmpDt = new DateTime($this->content_created_at)) ? $tmpDt->format('Y-m-d') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->content_created_at = ($dt ? $dt->format('Y-m-d') : null);
				$this->modifiedColumns[] = DocumentPeer::CONTENT_CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setContentCreatedAt()

	/**
	 * Set the value of [license] column.
	 * 
	 * @param      string $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setLicense($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->license !== $v) {
			$this->license = $v;
			$this->modifiedColumns[] = DocumentPeer::LICENSE;
		}

		return $this;
	} // setLicense()

	/**
	 * Set the value of [author] column.
	 * 
	 * @param      string $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setAuthor($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->author !== $v) {
			$this->author = $v;
			$this->modifiedColumns[] = DocumentPeer::AUTHOR;
		}

		return $this;
	} // setAuthor()

	/**
	 * Set the value of [language_id] column.
	 * 
	 * @param      string $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setLanguageId($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->language_id !== $v) {
			$this->language_id = $v;
			$this->modifiedColumns[] = DocumentPeer::LANGUAGE_ID;
		}

		if ($this->aLanguage !== null && $this->aLanguage->getId() !== $v) {
			$this->aLanguage = null;
		}

		return $this;
	} // setLanguageId()

	/**
	 * Set the value of [owner_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setOwnerId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->owner_id !== $v) {
			$this->owner_id = $v;
			$this->modifiedColumns[] = DocumentPeer::OWNER_ID;
		}

		if ($this->aUserRelatedByOwnerId !== null && $this->aUserRelatedByOwnerId->getId() !== $v) {
			$this->aUserRelatedByOwnerId = null;
		}

		return $this;
	} // setOwnerId()

	/**
	 * Set the value of [document_type_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setDocumentTypeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->document_type_id !== $v) {
			$this->document_type_id = $v;
			$this->modifiedColumns[] = DocumentPeer::DOCUMENT_TYPE_ID;
		}

		if ($this->aDocumentType !== null && $this->aDocumentType->getId() !== $v) {
			$this->aDocumentType = null;
		}

		return $this;
	} // setDocumentTypeId()

	/**
	 * Set the value of [document_category_id] column.
	 * 
	 * @param      int $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setDocumentCategoryId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->document_category_id !== $v) {
			$this->document_category_id = $v;
			$this->modifiedColumns[] = DocumentPeer::DOCUMENT_CATEGORY_ID;
		}

		if ($this->aDocumentCategory !== null && $this->aDocumentCategory->getId() !== $v) {
			$this->aDocumentCategory = null;
		}

		return $this;
	} // setDocumentCategoryId()

	/**
	 * Set the value of [is_private] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setIsPrivate($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_private !== $v || $this->isNew()) {
			$this->is_private = $v;
			$this->modifiedColumns[] = DocumentPeer::IS_PRIVATE;
		}

		return $this;
	} // setIsPrivate()

	/**
	 * Set the value of [is_inactive] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setIsInactive($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_inactive !== $v || $this->isNew()) {
			$this->is_inactive = $v;
			$this->modifiedColumns[] = DocumentPeer::IS_INACTIVE;
		}

		return $this;
	} // setIsInactive()

	/**
	 * Set the value of [is_protected] column.
	 * 
	 * @param      boolean $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setIsProtected($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_protected !== $v || $this->isNew()) {
			$this->is_protected = $v;
			$this->modifiedColumns[] = DocumentPeer::IS_PROTECTED;
		}

		return $this;
	} // setIsProtected()

	/**
	 * Set the value of [sort] column.
	 * 
	 * @param      int $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setSort($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->sort !== $v) {
			$this->sort = $v;
			$this->modifiedColumns[] = DocumentPeer::SORT;
		}

		return $this;
	} // setSort()

	/**
	 * Set the value of [data] column.
	 * 
	 * @param      resource $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setData($v)
	{
		// explicitly set the is-loaded flag to true for this lazy load col;
		// it doesn't matter if the value is actually set or not (logic below) as
		// any attempt to set the value means that no db lookup should be performed
		// when the getData() method is called.
		$this->data_isLoaded = true;

		// Because BLOB columns are streams in PDO we have to assume that they are
		// always modified when a new value is passed in.  For example, the contents
		// of the stream itself may have changed externally.
		if (!is_resource($v) && $v !== null) {
			$this->data = fopen('php://memory', 'r+');
			fwrite($this->data, $v);
			rewind($this->data);
		} else { // it's already a stream
			$this->data = $v;
		}
		$this->modifiedColumns[] = DocumentPeer::DATA;

		return $this;
	} // setData()

	/**
	 * Sets the value of [created_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Document The current object (for fluent API support)
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
				$this->modifiedColumns[] = DocumentPeer::CREATED_AT;
			}
		} // if either are not null

		return $this;
	} // setCreatedAt()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     Document The current object (for fluent API support)
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
				$this->modifiedColumns[] = DocumentPeer::UPDATED_AT;
			}
		} // if either are not null

		return $this;
	} // setUpdatedAt()

	/**
	 * Set the value of [created_by] column.
	 * 
	 * @param      int $v new value
	 * @return     Document The current object (for fluent API support)
	 */
	public function setCreatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->created_by !== $v) {
			$this->created_by = $v;
			$this->modifiedColumns[] = DocumentPeer::CREATED_BY;
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
	 * @return     Document The current object (for fluent API support)
	 */
	public function setUpdatedBy($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->updated_by !== $v) {
			$this->updated_by = $v;
			$this->modifiedColumns[] = DocumentPeer::UPDATED_BY;
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
			if ($this->is_private !== false) {
				return false;
			}

			if ($this->is_inactive !== false) {
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
			$this->original_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->description = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->content_created_at = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->license = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
			$this->author = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->language_id = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->owner_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
			$this->document_type_id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
			$this->document_category_id = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
			$this->is_private = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
			$this->is_inactive = ($row[$startcol + 12] !== null) ? (boolean) $row[$startcol + 12] : null;
			$this->is_protected = ($row[$startcol + 13] !== null) ? (boolean) $row[$startcol + 13] : null;
			$this->sort = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
			$this->created_at = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
			$this->updated_at = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
			$this->created_by = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
			$this->updated_by = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			return $startcol + 19; // 19 = DocumentPeer::NUM_COLUMNS - DocumentPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating Document object", $e);
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

		if ($this->aLanguage !== null && $this->language_id !== $this->aLanguage->getId()) {
			$this->aLanguage = null;
		}
		if ($this->aUserRelatedByOwnerId !== null && $this->owner_id !== $this->aUserRelatedByOwnerId->getId()) {
			$this->aUserRelatedByOwnerId = null;
		}
		if ($this->aDocumentType !== null && $this->document_type_id !== $this->aDocumentType->getId()) {
			$this->aDocumentType = null;
		}
		if ($this->aDocumentCategory !== null && $this->document_category_id !== $this->aDocumentCategory->getId()) {
			$this->aDocumentCategory = null;
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
			$con = Propel::getConnection(DocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = DocumentPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		// Reset the data lazy-load column
		$this->data = null;
		$this->data_isLoaded = false;

		if ($deep) {  // also de-associate any related objects?

			$this->aLanguage = null;
			$this->aUserRelatedByOwnerId = null;
			$this->aDocumentType = null;
			$this->aDocumentCategory = null;
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
			$con = Propel::getConnection(DocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// referenceable behavior
			if(ReferencePeer::hasReference($this)) {
				throw new PropelException("Exception in ".__METHOD__.": tried removing an instance from the database even though it is still referenced.");
			}
			if ($ret) {
				DocumentQuery::create()
					->filterByPrimaryKey($this->getPrimaryKey())
					->delete($con);
				$this->postDelete($con);
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
			$con = Propel::getConnection(DocumentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// extended_timestampable behavior
				if (!$this->isColumnModified(DocumentPeer::CREATED_AT)) {
					$this->setCreatedAt(time());
				}
				if (!$this->isColumnModified(DocumentPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if (!$this->isColumnModified(DocumentPeer::CREATED_BY)) {
						$this->setCreatedBy(Session::getSession()->getUser()->getId());
					}
					if (!$this->isColumnModified(DocumentPeer::UPDATED_BY)) {
						$this->setUpdatedBy(Session::getSession()->getUser()->getId());
					}
				}

			} else {
				$ret = $ret && $this->preUpdate($con);
				// extended_timestampable behavior
				if ($this->isModified() && !$this->isColumnModified(DocumentPeer::UPDATED_AT)) {
					$this->setUpdatedAt(time());
				}
				// attributable behavior
				
				if(Session::getSession()->isAuthenticated()) {
					if ($this->isModified() && !$this->isColumnModified(DocumentPeer::UPDATED_BY)) {
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
				DocumentPeer::addInstanceToPool($this);
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

			if ($this->aLanguage !== null) {
				if ($this->aLanguage->isModified() || $this->aLanguage->isNew()) {
					$affectedRows += $this->aLanguage->save($con);
				}
				$this->setLanguage($this->aLanguage);
			}

			if ($this->aUserRelatedByOwnerId !== null) {
				if ($this->aUserRelatedByOwnerId->isModified() || $this->aUserRelatedByOwnerId->isNew()) {
					$affectedRows += $this->aUserRelatedByOwnerId->save($con);
				}
				$this->setUserRelatedByOwnerId($this->aUserRelatedByOwnerId);
			}

			if ($this->aDocumentType !== null) {
				if ($this->aDocumentType->isModified() || $this->aDocumentType->isNew()) {
					$affectedRows += $this->aDocumentType->save($con);
				}
				$this->setDocumentType($this->aDocumentType);
			}

			if ($this->aDocumentCategory !== null) {
				if ($this->aDocumentCategory->isModified() || $this->aDocumentCategory->isNew()) {
					$affectedRows += $this->aDocumentCategory->save($con);
				}
				$this->setDocumentCategory($this->aDocumentCategory);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = DocumentPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$criteria = $this->buildCriteria();
					if ($criteria->keyContainsValue(DocumentPeer::ID) ) {
						throw new PropelException('Cannot insert a value for auto-increment primary key ('.DocumentPeer::ID.')');
					}

					$pk = BasePeer::doInsert($criteria, $con);
					$affectedRows += 1;
					$this->setId($pk);  //[IMV] update autoincrement primary key
					$this->setNew(false);
				} else {
					$affectedRows += DocumentPeer::doUpdate($this, $con);
				}

				// Rewind the data LOB column, since PDO does not rewind after inserting value.
				if ($this->data !== null && is_resource($this->data)) {
					rewind($this->data);
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

			if ($this->aDocumentType !== null) {
				if (!$this->aDocumentType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aDocumentType->getValidationFailures());
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


			if (($retval = DocumentPeer::doValidate($this, $columns)) !== true) {
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
		$pos = DocumentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getOriginalName();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getContentCreatedAt();
				break;
			case 5:
				return $this->getLicense();
				break;
			case 6:
				return $this->getAuthor();
				break;
			case 7:
				return $this->getLanguageId();
				break;
			case 8:
				return $this->getOwnerId();
				break;
			case 9:
				return $this->getDocumentTypeId();
				break;
			case 10:
				return $this->getDocumentCategoryId();
				break;
			case 11:
				return $this->getIsPrivate();
				break;
			case 12:
				return $this->getIsInactive();
				break;
			case 13:
				return $this->getIsProtected();
				break;
			case 14:
				return $this->getSort();
				break;
			case 15:
				return $this->getData();
				break;
			case 16:
				return $this->getCreatedAt();
				break;
			case 17:
				return $this->getUpdatedAt();
				break;
			case 18:
				return $this->getCreatedBy();
				break;
			case 19:
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
		$keys = DocumentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getOriginalName(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getContentCreatedAt(),
			$keys[5] => $this->getLicense(),
			$keys[6] => $this->getAuthor(),
			$keys[7] => $this->getLanguageId(),
			$keys[8] => $this->getOwnerId(),
			$keys[9] => $this->getDocumentTypeId(),
			$keys[10] => $this->getDocumentCategoryId(),
			$keys[11] => $this->getIsPrivate(),
			$keys[12] => $this->getIsInactive(),
			$keys[13] => $this->getIsProtected(),
			$keys[14] => $this->getSort(),
			$keys[15] => ($includeLazyLoadColumns) ? $this->getData() : null,
			$keys[16] => $this->getCreatedAt(),
			$keys[17] => $this->getUpdatedAt(),
			$keys[18] => $this->getCreatedBy(),
			$keys[19] => $this->getUpdatedBy(),
		);
		if ($includeForeignObjects) {
			if (null !== $this->aLanguage) {
				$result['Language'] = $this->aLanguage->toArray($keyType, $includeLazyLoadColumns, true);
			}
			if (null !== $this->aUserRelatedByOwnerId) {
				$result['UserRelatedByOwnerId'] = $this->aUserRelatedByOwnerId->toArray($keyType, $includeLazyLoadColumns, true);
			}
			if (null !== $this->aDocumentType) {
				$result['DocumentType'] = $this->aDocumentType->toArray($keyType, $includeLazyLoadColumns, true);
			}
			if (null !== $this->aDocumentCategory) {
				$result['DocumentCategory'] = $this->aDocumentCategory->toArray($keyType, $includeLazyLoadColumns, true);
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
		$pos = DocumentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setOriginalName($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setContentCreatedAt($value);
				break;
			case 5:
				$this->setLicense($value);
				break;
			case 6:
				$this->setAuthor($value);
				break;
			case 7:
				$this->setLanguageId($value);
				break;
			case 8:
				$this->setOwnerId($value);
				break;
			case 9:
				$this->setDocumentTypeId($value);
				break;
			case 10:
				$this->setDocumentCategoryId($value);
				break;
			case 11:
				$this->setIsPrivate($value);
				break;
			case 12:
				$this->setIsInactive($value);
				break;
			case 13:
				$this->setIsProtected($value);
				break;
			case 14:
				$this->setSort($value);
				break;
			case 15:
				$this->setData($value);
				break;
			case 16:
				$this->setCreatedAt($value);
				break;
			case 17:
				$this->setUpdatedAt($value);
				break;
			case 18:
				$this->setCreatedBy($value);
				break;
			case 19:
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
		$keys = DocumentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setOriginalName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setContentCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLicense($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAuthor($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLanguageId($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setOwnerId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDocumentTypeId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setDocumentCategoryId($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setIsPrivate($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setIsInactive($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setIsProtected($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setSort($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setData($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setCreatedAt($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setUpdatedAt($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setCreatedBy($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setUpdatedBy($arr[$keys[19]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(DocumentPeer::DATABASE_NAME);

		if ($this->isColumnModified(DocumentPeer::ID)) $criteria->add(DocumentPeer::ID, $this->id);
		if ($this->isColumnModified(DocumentPeer::NAME)) $criteria->add(DocumentPeer::NAME, $this->name);
		if ($this->isColumnModified(DocumentPeer::ORIGINAL_NAME)) $criteria->add(DocumentPeer::ORIGINAL_NAME, $this->original_name);
		if ($this->isColumnModified(DocumentPeer::DESCRIPTION)) $criteria->add(DocumentPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(DocumentPeer::CONTENT_CREATED_AT)) $criteria->add(DocumentPeer::CONTENT_CREATED_AT, $this->content_created_at);
		if ($this->isColumnModified(DocumentPeer::LICENSE)) $criteria->add(DocumentPeer::LICENSE, $this->license);
		if ($this->isColumnModified(DocumentPeer::AUTHOR)) $criteria->add(DocumentPeer::AUTHOR, $this->author);
		if ($this->isColumnModified(DocumentPeer::LANGUAGE_ID)) $criteria->add(DocumentPeer::LANGUAGE_ID, $this->language_id);
		if ($this->isColumnModified(DocumentPeer::OWNER_ID)) $criteria->add(DocumentPeer::OWNER_ID, $this->owner_id);
		if ($this->isColumnModified(DocumentPeer::DOCUMENT_TYPE_ID)) $criteria->add(DocumentPeer::DOCUMENT_TYPE_ID, $this->document_type_id);
		if ($this->isColumnModified(DocumentPeer::DOCUMENT_CATEGORY_ID)) $criteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, $this->document_category_id);
		if ($this->isColumnModified(DocumentPeer::IS_PRIVATE)) $criteria->add(DocumentPeer::IS_PRIVATE, $this->is_private);
		if ($this->isColumnModified(DocumentPeer::IS_INACTIVE)) $criteria->add(DocumentPeer::IS_INACTIVE, $this->is_inactive);
		if ($this->isColumnModified(DocumentPeer::IS_PROTECTED)) $criteria->add(DocumentPeer::IS_PROTECTED, $this->is_protected);
		if ($this->isColumnModified(DocumentPeer::SORT)) $criteria->add(DocumentPeer::SORT, $this->sort);
		if ($this->isColumnModified(DocumentPeer::DATA)) $criteria->add(DocumentPeer::DATA, $this->data);
		if ($this->isColumnModified(DocumentPeer::CREATED_AT)) $criteria->add(DocumentPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(DocumentPeer::UPDATED_AT)) $criteria->add(DocumentPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(DocumentPeer::CREATED_BY)) $criteria->add(DocumentPeer::CREATED_BY, $this->created_by);
		if ($this->isColumnModified(DocumentPeer::UPDATED_BY)) $criteria->add(DocumentPeer::UPDATED_BY, $this->updated_by);

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
		$criteria = new Criteria(DocumentPeer::DATABASE_NAME);
		$criteria->add(DocumentPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of Document (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{
		$copyObj->setName($this->name);
		$copyObj->setOriginalName($this->original_name);
		$copyObj->setDescription($this->description);
		$copyObj->setContentCreatedAt($this->content_created_at);
		$copyObj->setLicense($this->license);
		$copyObj->setAuthor($this->author);
		$copyObj->setLanguageId($this->language_id);
		$copyObj->setOwnerId($this->owner_id);
		$copyObj->setDocumentTypeId($this->document_type_id);
		$copyObj->setDocumentCategoryId($this->document_category_id);
		$copyObj->setIsPrivate($this->is_private);
		$copyObj->setIsInactive($this->is_inactive);
		$copyObj->setIsProtected($this->is_protected);
		$copyObj->setSort($this->sort);
		$copyObj->setData($this->data);
		$copyObj->setCreatedAt($this->created_at);
		$copyObj->setUpdatedAt($this->updated_at);
		$copyObj->setCreatedBy($this->created_by);
		$copyObj->setUpdatedBy($this->updated_by);

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
	 * @return     Document Clone of current object.
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
	 * @return     DocumentPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new DocumentPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Language object.
	 *
	 * @param      Language $v
	 * @return     Document The current object (for fluent API support)
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
			$v->addDocument($this);
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
			$this->aLanguage = LanguageQuery::create()->findPk($this->language_id, $con);
			/* The following can be used additionally to
				 guarantee the related object contains a reference
				 to this object.  This level of coupling may, however, be
				 undesirable since it could result in an only partially populated collection
				 in the referenced object.
				 $this->aLanguage->addDocuments($this);
			 */
		}
		return $this->aLanguage;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Document The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setUserRelatedByOwnerId(User $v = null)
	{
		if ($v === null) {
			$this->setOwnerId(NULL);
		} else {
			$this->setOwnerId($v->getId());
		}

		$this->aUserRelatedByOwnerId = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the User object, it will not be re-added.
		if ($v !== null) {
			$v->addDocumentRelatedByOwnerId($this);
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
	public function getUserRelatedByOwnerId(PropelPDO $con = null)
	{
		if ($this->aUserRelatedByOwnerId === null && ($this->owner_id !== null)) {
			$this->aUserRelatedByOwnerId = UserQuery::create()->findPk($this->owner_id, $con);
			/* The following can be used additionally to
				 guarantee the related object contains a reference
				 to this object.  This level of coupling may, however, be
				 undesirable since it could result in an only partially populated collection
				 in the referenced object.
				 $this->aUserRelatedByOwnerId->addDocumentsRelatedByOwnerId($this);
			 */
		}
		return $this->aUserRelatedByOwnerId;
	}

	/**
	 * Declares an association between this object and a DocumentType object.
	 *
	 * @param      DocumentType $v
	 * @return     Document The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setDocumentType(DocumentType $v = null)
	{
		if ($v === null) {
			$this->setDocumentTypeId(NULL);
		} else {
			$this->setDocumentTypeId($v->getId());
		}

		$this->aDocumentType = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the DocumentType object, it will not be re-added.
		if ($v !== null) {
			$v->addDocument($this);
		}

		return $this;
	}


	/**
	 * Get the associated DocumentType object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     DocumentType The associated DocumentType object.
	 * @throws     PropelException
	 */
	public function getDocumentType(PropelPDO $con = null)
	{
		if ($this->aDocumentType === null && ($this->document_type_id !== null)) {
			$this->aDocumentType = DocumentTypeQuery::create()->findPk($this->document_type_id, $con);
			/* The following can be used additionally to
				 guarantee the related object contains a reference
				 to this object.  This level of coupling may, however, be
				 undesirable since it could result in an only partially populated collection
				 in the referenced object.
				 $this->aDocumentType->addDocuments($this);
			 */
		}
		return $this->aDocumentType;
	}

	/**
	 * Declares an association between this object and a DocumentCategory object.
	 *
	 * @param      DocumentCategory $v
	 * @return     Document The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setDocumentCategory(DocumentCategory $v = null)
	{
		if ($v === null) {
			$this->setDocumentCategoryId(NULL);
		} else {
			$this->setDocumentCategoryId($v->getId());
		}

		$this->aDocumentCategory = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the DocumentCategory object, it will not be re-added.
		if ($v !== null) {
			$v->addDocument($this);
		}

		return $this;
	}


	/**
	 * Get the associated DocumentCategory object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     DocumentCategory The associated DocumentCategory object.
	 * @throws     PropelException
	 */
	public function getDocumentCategory(PropelPDO $con = null)
	{
		if ($this->aDocumentCategory === null && ($this->document_category_id !== null)) {
			$this->aDocumentCategory = DocumentCategoryQuery::create()->findPk($this->document_category_id, $con);
			/* The following can be used additionally to
				 guarantee the related object contains a reference
				 to this object.  This level of coupling may, however, be
				 undesirable since it could result in an only partially populated collection
				 in the referenced object.
				 $this->aDocumentCategory->addDocuments($this);
			 */
		}
		return $this->aDocumentCategory;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Document The current object (for fluent API support)
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
			$v->addDocumentRelatedByCreatedBy($this);
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
			$this->aUserRelatedByCreatedBy = UserQuery::create()->findPk($this->created_by, $con);
			/* The following can be used additionally to
				 guarantee the related object contains a reference
				 to this object.  This level of coupling may, however, be
				 undesirable since it could result in an only partially populated collection
				 in the referenced object.
				 $this->aUserRelatedByCreatedBy->addDocumentsRelatedByCreatedBy($this);
			 */
		}
		return $this->aUserRelatedByCreatedBy;
	}

	/**
	 * Declares an association between this object and a User object.
	 *
	 * @param      User $v
	 * @return     Document The current object (for fluent API support)
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
			$v->addDocumentRelatedByUpdatedBy($this);
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
			$this->aUserRelatedByUpdatedBy = UserQuery::create()->findPk($this->updated_by, $con);
			/* The following can be used additionally to
				 guarantee the related object contains a reference
				 to this object.  This level of coupling may, however, be
				 undesirable since it could result in an only partially populated collection
				 in the referenced object.
				 $this->aUserRelatedByUpdatedBy->addDocumentsRelatedByUpdatedBy($this);
			 */
		}
		return $this->aUserRelatedByUpdatedBy;
	}

	/**
	 * Clears the current object and sets all attributes to their default values
	 */
	public function clear()
	{
		$this->id = null;
		$this->name = null;
		$this->original_name = null;
		$this->description = null;
		$this->content_created_at = null;
		$this->license = null;
		$this->author = null;
		$this->language_id = null;
		$this->owner_id = null;
		$this->document_type_id = null;
		$this->document_category_id = null;
		$this->is_private = null;
		$this->is_inactive = null;
		$this->is_protected = null;
		$this->sort = null;
		$this->data = null;
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
		$this->setDeleted(false);
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

		$this->aLanguage = null;
		$this->aUserRelatedByOwnerId = null;
		$this->aDocumentType = null;
		$this->aDocumentCategory = null;
		$this->aUserRelatedByCreatedBy = null;
		$this->aUserRelatedByUpdatedBy = null;
	}

	// referenceable behavior
	
	/**
	 * @return A list of References (not Objects) which reference this Document
	 */
	public function getReferees()
	{
		return ReferencePeer::getReferences($this);
	}
	// taggable behavior
	
	/**
	 * @return A list of TagInstances (not Tags) which reference this Document
	 */
	public function getTags()
	{
		return TagPeer::tagInstancesForObject($this);
	}
	// extended_timestampable behavior
	
	/**
	 * Mark the current object so that the update date doesn't get updated during next save
	 *
	 * @return     Document The current object (for fluent API support)
	 */
	public function keepUpdateDateUnchanged()
	{
		$this->modifiedColumns[] = DocumentPeer::UPDATED_AT;
		return $this;
	}
	
	/**
	 * @return created_at as int (timestamp)
	 */
	public function getCreatedAtTimestamp()
	{
		return $this->getCreatedAt('U');
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
		return $this->getUpdatedAt('U');
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
	 * @return     Document The current object (for fluent API support)
	 */
	public function keepUpdateUserUnchanged()
	{
		$this->modifiedColumns[] = DocumentPeer::UPDATED_BY;
		return $this;
	}

	/**
	 * Catches calls to virtual methods
	 */
	public function __call($name, $params)
	{
		if (preg_match('/get(\w+)/', $name, $matches)) {
			$virtualColumn = $matches[1];
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
			// no lcfirst in php<5.3...
			$virtualColumn[0] = strtolower($virtualColumn[0]);
			if ($this->hasVirtualColumn($virtualColumn)) {
				return $this->getVirtualColumn($virtualColumn);
			}
		}
		return parent::__call($name, $params);
	}

} // BaseDocument
