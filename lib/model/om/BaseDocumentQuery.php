<?php


/**
 * Base class that represents a query for the 'documents' table.
 *
 *
 *
 * @method DocumentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method DocumentQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method DocumentQuery orderByOriginalName($order = Criteria::ASC) Order by the original_name column
 * @method DocumentQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method DocumentQuery orderByContentCreatedAt($order = Criteria::ASC) Order by the content_created_at column
 * @method DocumentQuery orderByLicense($order = Criteria::ASC) Order by the license column
 * @method DocumentQuery orderByAuthor($order = Criteria::ASC) Order by the author column
 * @method DocumentQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method DocumentQuery orderByOwnerId($order = Criteria::ASC) Order by the owner_id column
 * @method DocumentQuery orderByDocumentTypeId($order = Criteria::ASC) Order by the document_type_id column
 * @method DocumentQuery orderByDocumentCategoryId($order = Criteria::ASC) Order by the document_category_id column
 * @method DocumentQuery orderByIsPrivate($order = Criteria::ASC) Order by the is_private column
 * @method DocumentQuery orderByIsInactive($order = Criteria::ASC) Order by the is_inactive column
 * @method DocumentQuery orderByIsProtected($order = Criteria::ASC) Order by the is_protected column
 * @method DocumentQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method DocumentQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method DocumentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method DocumentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method DocumentQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method DocumentQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method DocumentQuery groupById() Group by the id column
 * @method DocumentQuery groupByName() Group by the name column
 * @method DocumentQuery groupByOriginalName() Group by the original_name column
 * @method DocumentQuery groupByDescription() Group by the description column
 * @method DocumentQuery groupByContentCreatedAt() Group by the content_created_at column
 * @method DocumentQuery groupByLicense() Group by the license column
 * @method DocumentQuery groupByAuthor() Group by the author column
 * @method DocumentQuery groupByLanguageId() Group by the language_id column
 * @method DocumentQuery groupByOwnerId() Group by the owner_id column
 * @method DocumentQuery groupByDocumentTypeId() Group by the document_type_id column
 * @method DocumentQuery groupByDocumentCategoryId() Group by the document_category_id column
 * @method DocumentQuery groupByIsPrivate() Group by the is_private column
 * @method DocumentQuery groupByIsInactive() Group by the is_inactive column
 * @method DocumentQuery groupByIsProtected() Group by the is_protected column
 * @method DocumentQuery groupBySort() Group by the sort column
 * @method DocumentQuery groupByData() Group by the data column
 * @method DocumentQuery groupByCreatedAt() Group by the created_at column
 * @method DocumentQuery groupByUpdatedAt() Group by the updated_at column
 * @method DocumentQuery groupByCreatedBy() Group by the created_by column
 * @method DocumentQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method DocumentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method DocumentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method DocumentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method DocumentQuery leftJoinLanguage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Language relation
 * @method DocumentQuery rightJoinLanguage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Language relation
 * @method DocumentQuery innerJoinLanguage($relationAlias = null) Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method DocumentQuery leftJoinUserRelatedByOwnerId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByOwnerId relation
 * @method DocumentQuery rightJoinUserRelatedByOwnerId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByOwnerId relation
 * @method DocumentQuery innerJoinUserRelatedByOwnerId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByOwnerId relation
 *
 * @method DocumentQuery leftJoinDocumentType($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentType relation
 * @method DocumentQuery rightJoinDocumentType($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentType relation
 * @method DocumentQuery innerJoinDocumentType($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentType relation
 *
 * @method DocumentQuery leftJoinDocumentCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentCategory relation
 * @method DocumentQuery rightJoinDocumentCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentCategory relation
 * @method DocumentQuery innerJoinDocumentCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentCategory relation
 *
 * @method DocumentQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method DocumentQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method DocumentQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method DocumentQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method DocumentQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method DocumentQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method Document findOne(PropelPDO $con = null) Return the first Document matching the query
 * @method Document findOneOrCreate(PropelPDO $con = null) Return the first Document matching the query, or a new Document object populated from the query conditions when no match is found
 *
 * @method Document findOneByName(string $name) Return the first Document filtered by the name column
 * @method Document findOneByOriginalName(string $original_name) Return the first Document filtered by the original_name column
 * @method Document findOneByDescription(string $description) Return the first Document filtered by the description column
 * @method Document findOneByContentCreatedAt(string $content_created_at) Return the first Document filtered by the content_created_at column
 * @method Document findOneByLicense(string $license) Return the first Document filtered by the license column
 * @method Document findOneByAuthor(string $author) Return the first Document filtered by the author column
 * @method Document findOneByLanguageId(string $language_id) Return the first Document filtered by the language_id column
 * @method Document findOneByOwnerId(int $owner_id) Return the first Document filtered by the owner_id column
 * @method Document findOneByDocumentTypeId(int $document_type_id) Return the first Document filtered by the document_type_id column
 * @method Document findOneByDocumentCategoryId(int $document_category_id) Return the first Document filtered by the document_category_id column
 * @method Document findOneByIsPrivate(boolean $is_private) Return the first Document filtered by the is_private column
 * @method Document findOneByIsInactive(boolean $is_inactive) Return the first Document filtered by the is_inactive column
 * @method Document findOneByIsProtected(boolean $is_protected) Return the first Document filtered by the is_protected column
 * @method Document findOneBySort(int $sort) Return the first Document filtered by the sort column
 * @method Document findOneByData(resource $data) Return the first Document filtered by the data column
 * @method Document findOneByCreatedAt(string $created_at) Return the first Document filtered by the created_at column
 * @method Document findOneByUpdatedAt(string $updated_at) Return the first Document filtered by the updated_at column
 * @method Document findOneByCreatedBy(int $created_by) Return the first Document filtered by the created_by column
 * @method Document findOneByUpdatedBy(int $updated_by) Return the first Document filtered by the updated_by column
 *
 * @method array findById(int $id) Return Document objects filtered by the id column
 * @method array findByName(string $name) Return Document objects filtered by the name column
 * @method array findByOriginalName(string $original_name) Return Document objects filtered by the original_name column
 * @method array findByDescription(string $description) Return Document objects filtered by the description column
 * @method array findByContentCreatedAt(string $content_created_at) Return Document objects filtered by the content_created_at column
 * @method array findByLicense(string $license) Return Document objects filtered by the license column
 * @method array findByAuthor(string $author) Return Document objects filtered by the author column
 * @method array findByLanguageId(string $language_id) Return Document objects filtered by the language_id column
 * @method array findByOwnerId(int $owner_id) Return Document objects filtered by the owner_id column
 * @method array findByDocumentTypeId(int $document_type_id) Return Document objects filtered by the document_type_id column
 * @method array findByDocumentCategoryId(int $document_category_id) Return Document objects filtered by the document_category_id column
 * @method array findByIsPrivate(boolean $is_private) Return Document objects filtered by the is_private column
 * @method array findByIsInactive(boolean $is_inactive) Return Document objects filtered by the is_inactive column
 * @method array findByIsProtected(boolean $is_protected) Return Document objects filtered by the is_protected column
 * @method array findBySort(int $sort) Return Document objects filtered by the sort column
 * @method array findByData(resource $data) Return Document objects filtered by the data column
 * @method array findByCreatedAt(string $created_at) Return Document objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return Document objects filtered by the updated_at column
 * @method array findByCreatedBy(int $created_by) Return Document objects filtered by the created_by column
 * @method array findByUpdatedBy(int $updated_by) Return Document objects filtered by the updated_by column
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
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'rapila';
        }
        if (null === $modelName) {
            $modelName = 'Document';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new DocumentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   DocumentQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return DocumentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof DocumentQuery) {
            return $criteria;
        }
        $query = new DocumentQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Document|Document[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DocumentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(DocumentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Document A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Document A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `original_name`, `description`, `content_created_at`, `license`, `author`, `language_id`, `owner_id`, `document_type_id`, `document_category_id`, `is_private`, `is_inactive`, `is_protected`, `sort`, `created_at`, `updated_at`, `created_by`, `updated_by` FROM `documents` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Document();
            $obj->hydrate($row);
            DocumentPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Document|Document[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Document[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DocumentPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DocumentPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DocumentPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the original_name column
     *
     * Example usage:
     * <code>
     * $query->filterByOriginalName('fooValue');   // WHERE original_name = 'fooValue'
     * $query->filterByOriginalName('%fooValue%'); // WHERE original_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $originalName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByOriginalName($originalName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($originalName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $originalName)) {
                $originalName = str_replace('*', '%', $originalName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentPeer::ORIGINAL_NAME, $originalName, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the content_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByContentCreatedAt('2011-03-14'); // WHERE content_created_at = '2011-03-14'
     * $query->filterByContentCreatedAt('now'); // WHERE content_created_at = '2011-03-14'
     * $query->filterByContentCreatedAt(array('max' => 'yesterday')); // WHERE content_created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $contentCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByContentCreatedAt($contentCreatedAt = null, $comparison = null)
    {
        if (is_array($contentCreatedAt)) {
            $useMinMax = false;
            if (isset($contentCreatedAt['min'])) {
                $this->addUsingAlias(DocumentPeer::CONTENT_CREATED_AT, $contentCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($contentCreatedAt['max'])) {
                $this->addUsingAlias(DocumentPeer::CONTENT_CREATED_AT, $contentCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentPeer::CONTENT_CREATED_AT, $contentCreatedAt, $comparison);
    }

    /**
     * Filter the query on the license column
     *
     * Example usage:
     * <code>
     * $query->filterByLicense('fooValue');   // WHERE license = 'fooValue'
     * $query->filterByLicense('%fooValue%'); // WHERE license LIKE '%fooValue%'
     * </code>
     *
     * @param     string $license The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByLicense($license = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($license)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $license)) {
                $license = str_replace('*', '%', $license);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentPeer::LICENSE, $license, $comparison);
    }

    /**
     * Filter the query on the author column
     *
     * Example usage:
     * <code>
     * $query->filterByAuthor('fooValue');   // WHERE author = 'fooValue'
     * $query->filterByAuthor('%fooValue%'); // WHERE author LIKE '%fooValue%'
     * </code>
     *
     * @param     string $author The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByAuthor($author = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($author)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $author)) {
                $author = str_replace('*', '%', $author);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentPeer::AUTHOR, $author, $comparison);
    }

    /**
     * Filter the query on the language_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLanguageId('fooValue');   // WHERE language_id = 'fooValue'
     * $query->filterByLanguageId('%fooValue%'); // WHERE language_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $languageId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByLanguageId($languageId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($languageId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $languageId)) {
                $languageId = str_replace('*', '%', $languageId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DocumentPeer::LANGUAGE_ID, $languageId, $comparison);
    }

    /**
     * Filter the query on the owner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOwnerId(1234); // WHERE owner_id = 1234
     * $query->filterByOwnerId(array(12, 34)); // WHERE owner_id IN (12, 34)
     * $query->filterByOwnerId(array('min' => 12)); // WHERE owner_id >= 12
     * $query->filterByOwnerId(array('max' => 12)); // WHERE owner_id <= 12
     * </code>
     *
     * @see       filterByUserRelatedByOwnerId()
     *
     * @param     mixed $ownerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * Example usage:
     * <code>
     * $query->filterByDocumentTypeId(1234); // WHERE document_type_id = 1234
     * $query->filterByDocumentTypeId(array(12, 34)); // WHERE document_type_id IN (12, 34)
     * $query->filterByDocumentTypeId(array('min' => 12)); // WHERE document_type_id >= 12
     * $query->filterByDocumentTypeId(array('max' => 12)); // WHERE document_type_id <= 12
     * </code>
     *
     * @see       filterByDocumentType()
     *
     * @param     mixed $documentTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * Example usage:
     * <code>
     * $query->filterByDocumentCategoryId(1234); // WHERE document_category_id = 1234
     * $query->filterByDocumentCategoryId(array(12, 34)); // WHERE document_category_id IN (12, 34)
     * $query->filterByDocumentCategoryId(array('min' => 12)); // WHERE document_category_id >= 12
     * $query->filterByDocumentCategoryId(array('max' => 12)); // WHERE document_category_id <= 12
     * </code>
     *
     * @see       filterByDocumentCategory()
     *
     * @param     mixed $documentCategoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * Example usage:
     * <code>
     * $query->filterByIsPrivate(true); // WHERE is_private = true
     * $query->filterByIsPrivate('yes'); // WHERE is_private = true
     * </code>
     *
     * @param     boolean|string $isPrivate The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByIsPrivate($isPrivate = null, $comparison = null)
    {
        if (is_string($isPrivate)) {
            $isPrivate = in_array(strtolower($isPrivate), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DocumentPeer::IS_PRIVATE, $isPrivate, $comparison);
    }

    /**
     * Filter the query on the is_inactive column
     *
     * Example usage:
     * <code>
     * $query->filterByIsInactive(true); // WHERE is_inactive = true
     * $query->filterByIsInactive('yes'); // WHERE is_inactive = true
     * </code>
     *
     * @param     boolean|string $isInactive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByIsInactive($isInactive = null, $comparison = null)
    {
        if (is_string($isInactive)) {
            $isInactive = in_array(strtolower($isInactive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DocumentPeer::IS_INACTIVE, $isInactive, $comparison);
    }

    /**
     * Filter the query on the is_protected column
     *
     * Example usage:
     * <code>
     * $query->filterByIsProtected(true); // WHERE is_protected = true
     * $query->filterByIsProtected('yes'); // WHERE is_protected = true
     * </code>
     *
     * @param     boolean|string $isProtected The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByIsProtected($isProtected = null, $comparison = null)
    {
        if (is_string($isProtected)) {
            $isProtected = in_array(strtolower($isProtected), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DocumentPeer::IS_PROTECTED, $isProtected, $comparison);
    }

    /**
     * Filter the query on the sort column
     *
     * Example usage:
     * <code>
     * $query->filterBySort(1234); // WHERE sort = 1234
     * $query->filterBySort(array(12, 34)); // WHERE sort IN (12, 34)
     * $query->filterBySort(array('min' => 12)); // WHERE sort >= 12
     * $query->filterBySort(array('max' => 12)); // WHERE sort <= 12
     * </code>
     *
     * @param     mixed $sort The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(DocumentPeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(DocumentPeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentPeer::SORT, $sort, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * @param     mixed $data The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {

        return $this->addUsingAlias(DocumentPeer::DATA, $data, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * Example usage:
     * <code>
     * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
     * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
     * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by >= 12
     * $query->filterByCreatedBy(array('max' => 12)); // WHERE created_by <= 12
     * </code>
     *
     * @see       filterByUserRelatedByCreatedBy()
     *
     * @param     mixed $createdBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * Example usage:
     * <code>
     * $query->filterByUpdatedBy(1234); // WHERE updated_by = 1234
     * $query->filterByUpdatedBy(array(12, 34)); // WHERE updated_by IN (12, 34)
     * $query->filterByUpdatedBy(array('min' => 12)); // WHERE updated_by >= 12
     * $query->filterByUpdatedBy(array('max' => 12)); // WHERE updated_by <= 12
     * </code>
     *
     * @see       filterByUserRelatedByUpdatedBy()
     *
     * @param     mixed $updatedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * @param   Language|PropelObjectCollection $language The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DocumentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguage($language, $comparison = null)
    {
        if ($language instanceof Language) {
            return $this
                ->addUsingAlias(DocumentPeer::LANGUAGE_ID, $language->getId(), $comparison);
        } elseif ($language instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentPeer::LANGUAGE_ID, $language->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLanguage() only accepts arguments of type Language or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Language relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function joinLanguage($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
        if ($relationAlias) {
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
     * @return   LanguageQuery A secondary query class using the current class as primary query
     */
    public function useLanguageQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Language', 'LanguageQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DocumentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByOwnerId($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(DocumentPeer::OWNER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentPeer::OWNER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByOwnerId() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByOwnerId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function joinUserRelatedByOwnerId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
        if ($relationAlias) {
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
     * @return   UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByOwnerIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRelatedByOwnerId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByOwnerId', 'UserQuery');
    }

    /**
     * Filter the query by a related DocumentType object
     *
     * @param   DocumentType|PropelObjectCollection $documentType The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DocumentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentType($documentType, $comparison = null)
    {
        if ($documentType instanceof DocumentType) {
            return $this
                ->addUsingAlias(DocumentPeer::DOCUMENT_TYPE_ID, $documentType->getId(), $comparison);
        } elseif ($documentType instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentPeer::DOCUMENT_TYPE_ID, $documentType->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDocumentType() only accepts arguments of type DocumentType or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentType relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function joinDocumentType($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
        if ($relationAlias) {
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
     * @return   DocumentTypeQuery A secondary query class using the current class as primary query
     */
    public function useDocumentTypeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDocumentType($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentType', 'DocumentTypeQuery');
    }

    /**
     * Filter the query by a related DocumentCategory object
     *
     * @param   DocumentCategory|PropelObjectCollection $documentCategory The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DocumentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentCategory($documentCategory, $comparison = null)
    {
        if ($documentCategory instanceof DocumentCategory) {
            return $this
                ->addUsingAlias(DocumentPeer::DOCUMENT_CATEGORY_ID, $documentCategory->getId(), $comparison);
        } elseif ($documentCategory instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentPeer::DOCUMENT_CATEGORY_ID, $documentCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDocumentCategory() only accepts arguments of type DocumentCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function joinDocumentCategory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
        if ($relationAlias) {
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
     * @return   DocumentCategoryQuery A secondary query class using the current class as primary query
     */
    public function useDocumentCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentCategory', 'DocumentCategoryQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DocumentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(DocumentPeer::CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentPeer::CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByCreatedBy() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function joinUserRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
        if ($relationAlias) {
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
     * @return   UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', 'UserQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DocumentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(DocumentPeer::UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentPeer::UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserRelatedByUpdatedBy() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DocumentQuery The current query, for fluid interface
     */
    public function joinUserRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
        if ($relationAlias) {
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
     * @return   UserQuery A secondary query class using the current class as primary query
     */
    public function useUserRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUpdatedBy', 'UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Document $document Object to remove from the list of results
     *
     * @return DocumentQuery The current query, for fluid interface
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
     * @return     DocumentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(DocumentPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     DocumentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(DocumentPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     DocumentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(DocumentPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     DocumentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(DocumentPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     DocumentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(DocumentPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     DocumentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(DocumentPeer::CREATED_AT);
    }
    // extended_keyable behavior

    public function filterByPKArray($pkArray) {
            return $this->filterByPrimaryKey($pkArray[0]);
    }

    public function filterByPKString($pkString) {
        return $this->filterByPrimaryKey($pkString);
    }

}
