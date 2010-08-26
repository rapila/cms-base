<?php


/**
 * Base class that represents a query for the 'documents' table.
 *
 * 
 *
 * @method     DocumentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     DocumentQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     DocumentQuery orderByOriginalName($order = Criteria::ASC) Order by the original_name column
 * @method     DocumentQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     DocumentQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     DocumentQuery orderByOwnerId($order = Criteria::ASC) Order by the owner_id column
 * @method     DocumentQuery orderByDocumentTypeId($order = Criteria::ASC) Order by the document_type_id column
 * @method     DocumentQuery orderByDocumentCategoryId($order = Criteria::ASC) Order by the document_category_id column
 * @method     DocumentQuery orderByIsPrivate($order = Criteria::ASC) Order by the is_private column
 * @method     DocumentQuery orderByIsInactive($order = Criteria::ASC) Order by the is_inactive column
 * @method     DocumentQuery orderByIsProtected($order = Criteria::ASC) Order by the is_protected column
 * @method     DocumentQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     DocumentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     DocumentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     DocumentQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     DocumentQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     DocumentQuery groupById() Group by the id column
 * @method     DocumentQuery groupByName() Group by the name column
 * @method     DocumentQuery groupByOriginalName() Group by the original_name column
 * @method     DocumentQuery groupByDescription() Group by the description column
 * @method     DocumentQuery groupByLanguageId() Group by the language_id column
 * @method     DocumentQuery groupByOwnerId() Group by the owner_id column
 * @method     DocumentQuery groupByDocumentTypeId() Group by the document_type_id column
 * @method     DocumentQuery groupByDocumentCategoryId() Group by the document_category_id column
 * @method     DocumentQuery groupByIsPrivate() Group by the is_private column
 * @method     DocumentQuery groupByIsInactive() Group by the is_inactive column
 * @method     DocumentQuery groupByIsProtected() Group by the is_protected column
 * @method     DocumentQuery groupByData() Group by the data column
 * @method     DocumentQuery groupByCreatedAt() Group by the created_at column
 * @method     DocumentQuery groupByUpdatedAt() Group by the updated_at column
 * @method     DocumentQuery groupByCreatedBy() Group by the created_by column
 * @method     DocumentQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     DocumentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     DocumentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     DocumentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     DocumentQuery leftJoinLanguage($relationAlias = '') Adds a LEFT JOIN clause to the query using the Language relation
 * @method     DocumentQuery rightJoinLanguage($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     DocumentQuery innerJoinLanguage($relationAlias = '') Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     DocumentQuery leftJoinUserRelatedByOwnerId($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByOwnerId relation
 * @method     DocumentQuery rightJoinUserRelatedByOwnerId($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByOwnerId relation
 * @method     DocumentQuery innerJoinUserRelatedByOwnerId($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByOwnerId relation
 *
 * @method     DocumentQuery leftJoinDocumentType($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentType relation
 * @method     DocumentQuery rightJoinDocumentType($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentType relation
 * @method     DocumentQuery innerJoinDocumentType($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentType relation
 *
 * @method     DocumentQuery leftJoinDocumentCategory($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentCategory relation
 * @method     DocumentQuery rightJoinDocumentCategory($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentCategory relation
 * @method     DocumentQuery innerJoinDocumentCategory($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentCategory relation
 *
 * @method     DocumentQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     DocumentQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     DocumentQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     DocumentQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     DocumentQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     DocumentQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     Document findOne(PropelPDO $con = null) Return the first Document matching the query
 * @method     Document findOneById(int $id) Return the first Document filtered by the id column
 * @method     Document findOneByName(string $name) Return the first Document filtered by the name column
 * @method     Document findOneByOriginalName(string $original_name) Return the first Document filtered by the original_name column
 * @method     Document findOneByDescription(string $description) Return the first Document filtered by the description column
 * @method     Document findOneByLanguageId(string $language_id) Return the first Document filtered by the language_id column
 * @method     Document findOneByOwnerId(int $owner_id) Return the first Document filtered by the owner_id column
 * @method     Document findOneByDocumentTypeId(int $document_type_id) Return the first Document filtered by the document_type_id column
 * @method     Document findOneByDocumentCategoryId(int $document_category_id) Return the first Document filtered by the document_category_id column
 * @method     Document findOneByIsPrivate(boolean $is_private) Return the first Document filtered by the is_private column
 * @method     Document findOneByIsInactive(boolean $is_inactive) Return the first Document filtered by the is_inactive column
 * @method     Document findOneByIsProtected(boolean $is_protected) Return the first Document filtered by the is_protected column
 * @method     Document findOneByData(resource $data) Return the first Document filtered by the data column
 * @method     Document findOneByCreatedAt(string $created_at) Return the first Document filtered by the created_at column
 * @method     Document findOneByUpdatedAt(string $updated_at) Return the first Document filtered by the updated_at column
 * @method     Document findOneByCreatedBy(int $created_by) Return the first Document filtered by the created_by column
 * @method     Document findOneByUpdatedBy(int $updated_by) Return the first Document filtered by the updated_by column
 *
 * @method     array findById(int $id) Return Document objects filtered by the id column
 * @method     array findByName(string $name) Return Document objects filtered by the name column
 * @method     array findByOriginalName(string $original_name) Return Document objects filtered by the original_name column
 * @method     array findByDescription(string $description) Return Document objects filtered by the description column
 * @method     array findByLanguageId(string $language_id) Return Document objects filtered by the language_id column
 * @method     array findByOwnerId(int $owner_id) Return Document objects filtered by the owner_id column
 * @method     array findByDocumentTypeId(int $document_type_id) Return Document objects filtered by the document_type_id column
 * @method     array findByDocumentCategoryId(int $document_category_id) Return Document objects filtered by the document_category_id column
 * @method     array findByIsPrivate(boolean $is_private) Return Document objects filtered by the is_private column
 * @method     array findByIsInactive(boolean $is_inactive) Return Document objects filtered by the is_inactive column
 * @method     array findByIsProtected(boolean $is_protected) Return Document objects filtered by the is_protected column
 * @method     array findByData(resource $data) Return Document objects filtered by the data column
 * @method     array findByCreatedAt(string $created_at) Return Document objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Document objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return Document objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return Document objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseDocumentQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseDocumentQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'Document', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new DocumentQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    DocumentQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof DocumentQuery) {
			return $criteria;
		}
		$query = new DocumentQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    Document|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = DocumentPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			$criteria = $this->isKeepQuery() ? clone $this : $this;
			$stmt = $criteria
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
		}
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{	
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(DocumentPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(DocumentPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(DocumentPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the name column
	 * 
	 * @param     string $name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = null)
	{
		if (is_array($name)) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $name)) {
			$name = str_replace('*', '%', $name);
			if (null === $comparison) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DocumentPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the original_name column
	 * 
	 * @param     string $originalName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByOriginalName($originalName = null, $comparison = null)
	{
		if (is_array($originalName)) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $originalName)) {
			$originalName = str_replace('*', '%', $originalName);
			if (null === $comparison) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DocumentPeer::ORIGINAL_NAME, $originalName, $comparison);
	}

	/**
	 * Filter the query on the description column
	 * 
	 * @param     string $description The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByDescription($description = null, $comparison = null)
	{
		if (is_array($description)) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $description)) {
			$description = str_replace('*', '%', $description);
			if (null === $comparison) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DocumentPeer::DESCRIPTION, $description, $comparison);
	}

	/**
	 * Filter the query on the language_id column
	 * 
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByLanguageId($languageId = null, $comparison = null)
	{
		if (is_array($languageId)) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $languageId)) {
			$languageId = str_replace('*', '%', $languageId);
			if (null === $comparison) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DocumentPeer::LANGUAGE_ID, $languageId, $comparison);
	}

	/**
	 * Filter the query on the owner_id column
	 * 
	 * @param     int|array $ownerId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByOwnerId($ownerId = null, $comparison = null)
	{
		if (is_array($ownerId)) {
			$useMinMax = false;
			if (isset($ownerId['min'])) {
				$this->addUsingAlias(DocumentPeer::OWNER_ID, $ownerId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($ownerId['max'])) {
				$this->addUsingAlias(DocumentPeer::OWNER_ID, $ownerId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::OWNER_ID, $ownerId, $comparison);
	}

	/**
	 * Filter the query on the document_type_id column
	 * 
	 * @param     int|array $documentTypeId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByDocumentTypeId($documentTypeId = null, $comparison = null)
	{
		if (is_array($documentTypeId)) {
			$useMinMax = false;
			if (isset($documentTypeId['min'])) {
				$this->addUsingAlias(DocumentPeer::DOCUMENT_TYPE_ID, $documentTypeId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($documentTypeId['max'])) {
				$this->addUsingAlias(DocumentPeer::DOCUMENT_TYPE_ID, $documentTypeId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::DOCUMENT_TYPE_ID, $documentTypeId, $comparison);
	}

	/**
	 * Filter the query on the document_category_id column
	 * 
	 * @param     int|array $documentCategoryId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByDocumentCategoryId($documentCategoryId = null, $comparison = null)
	{
		if (is_array($documentCategoryId)) {
			$useMinMax = false;
			if (isset($documentCategoryId['min'])) {
				$this->addUsingAlias(DocumentPeer::DOCUMENT_CATEGORY_ID, $documentCategoryId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($documentCategoryId['max'])) {
				$this->addUsingAlias(DocumentPeer::DOCUMENT_CATEGORY_ID, $documentCategoryId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::DOCUMENT_CATEGORY_ID, $documentCategoryId, $comparison);
	}

	/**
	 * Filter the query on the is_private column
	 * 
	 * @param     boolean|string $isPrivate The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByIsPrivate($isPrivate = null, $comparison = null)
	{
		if (is_string($isPrivate)) {
			$is_private = in_array(strtolower($isPrivate), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(DocumentPeer::IS_PRIVATE, $isPrivate, $comparison);
	}

	/**
	 * Filter the query on the is_inactive column
	 * 
	 * @param     boolean|string $isInactive The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByIsInactive($isInactive = null, $comparison = null)
	{
		if (is_string($isInactive)) {
			$is_inactive = in_array(strtolower($isInactive), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(DocumentPeer::IS_INACTIVE, $isInactive, $comparison);
	}

	/**
	 * Filter the query on the is_protected column
	 * 
	 * @param     boolean|string $isProtected The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByIsProtected($isProtected = null, $comparison = null)
	{
		if (is_string($isProtected)) {
			$is_protected = in_array(strtolower($isProtected), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(DocumentPeer::IS_PROTECTED, $isProtected, $comparison);
	}

	/**
	 * Filter the query on the data column
	 * 
	 * @param     mixed $data The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByData($data = null, $comparison = null)
	{
		return $this->addUsingAlias(DocumentPeer::DATA, $data, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(DocumentPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(DocumentPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(DocumentPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(DocumentPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = null)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(DocumentPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(DocumentPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = null)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(DocumentPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(DocumentPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DocumentPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related Language object
	 *
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = null)
	{
		return $this
			->addUsingAlias(DocumentPeer::LANGUAGE_ID, $language->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Language relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function joinLanguage($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Language');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Language');
		}
		
		return $this;
	}

	/**
	 * Use the Language relation Language object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguage($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Language', 'LanguageQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByOwnerId($user, $comparison = null)
	{
		return $this
			->addUsingAlias(DocumentPeer::OWNER_ID, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByOwnerId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByOwnerId($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByOwnerId');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByOwnerId');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByOwnerId relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByOwnerIdQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUserRelatedByOwnerId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByOwnerId', 'UserQuery');
	}

	/**
	 * Filter the query by a related DocumentType object
	 *
	 * @param     DocumentType $documentType  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByDocumentType($documentType, $comparison = null)
	{
		return $this
			->addUsingAlias(DocumentPeer::DOCUMENT_TYPE_ID, $documentType->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentType relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function joinDocumentType($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentType');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'DocumentType');
		}
		
		return $this;
	}

	/**
	 * Use the DocumentType relation DocumentType object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentTypeQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentTypeQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinDocumentType($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentType', 'DocumentTypeQuery');
	}

	/**
	 * Filter the query by a related DocumentCategory object
	 *
	 * @param     DocumentCategory $documentCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByDocumentCategory($documentCategory, $comparison = null)
	{
		return $this
			->addUsingAlias(DocumentPeer::DOCUMENT_CATEGORY_ID, $documentCategory->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentCategory relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function joinDocumentCategory($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentCategory');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'DocumentCategory');
		}
		
		return $this;
	}

	/**
	 * Use the DocumentCategory relation DocumentCategory object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentCategoryQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentCategory($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentCategory', 'DocumentCategoryQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(DocumentPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByCreatedBy relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', 'UserQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(DocumentPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByUpdatedBy relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUpdatedBy', 'UserQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Document $document Object to remove from the list of results
	 *
	 * @return    DocumentQuery The current query, for fluid interface
	 */
	public function prune($document = null)
	{
		if ($document) {
			$this->addUsingAlias(DocumentPeer::ID, $document->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

	// extended_timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     DocumentQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(DocumentPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     DocumentQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(DocumentPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     DocumentQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(DocumentPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     DocumentQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(DocumentPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     DocumentQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(DocumentPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     DocumentQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(DocumentPeer::CREATED_AT);
	}

} // BaseDocumentQuery
