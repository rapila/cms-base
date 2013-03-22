<?php


/**
 * Base class that represents a query for the 'objects' table.
 *
 *
 *
 * @method ContentObjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ContentObjectQuery orderByPageId($order = Criteria::ASC) Order by the page_id column
 * @method ContentObjectQuery orderByContainerName($order = Criteria::ASC) Order by the container_name column
 * @method ContentObjectQuery orderByObjectType($order = Criteria::ASC) Order by the object_type column
 * @method ContentObjectQuery orderByConditionSerialized($order = Criteria::ASC) Order by the condition_serialized column
 * @method ContentObjectQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method ContentObjectQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method ContentObjectQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method ContentObjectQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method ContentObjectQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method ContentObjectQuery groupById() Group by the id column
 * @method ContentObjectQuery groupByPageId() Group by the page_id column
 * @method ContentObjectQuery groupByContainerName() Group by the container_name column
 * @method ContentObjectQuery groupByObjectType() Group by the object_type column
 * @method ContentObjectQuery groupByConditionSerialized() Group by the condition_serialized column
 * @method ContentObjectQuery groupBySort() Group by the sort column
 * @method ContentObjectQuery groupByCreatedAt() Group by the created_at column
 * @method ContentObjectQuery groupByUpdatedAt() Group by the updated_at column
 * @method ContentObjectQuery groupByCreatedBy() Group by the created_by column
 * @method ContentObjectQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method ContentObjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ContentObjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ContentObjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ContentObjectQuery leftJoinPage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Page relation
 * @method ContentObjectQuery rightJoinPage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Page relation
 * @method ContentObjectQuery innerJoinPage($relationAlias = null) Adds a INNER JOIN clause to the query using the Page relation
 *
 * @method ContentObjectQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method ContentObjectQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method ContentObjectQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method ContentObjectQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method ContentObjectQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method ContentObjectQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method ContentObjectQuery leftJoinLanguageObject($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObject relation
 * @method ContentObjectQuery rightJoinLanguageObject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObject relation
 * @method ContentObjectQuery innerJoinLanguageObject($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObject relation
 *
 * @method ContentObjectQuery leftJoinLanguageObjectHistory($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectHistory relation
 * @method ContentObjectQuery rightJoinLanguageObjectHistory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectHistory relation
 * @method ContentObjectQuery innerJoinLanguageObjectHistory($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectHistory relation
 *
 * @method ContentObject findOne(PropelPDO $con = null) Return the first ContentObject matching the query
 * @method ContentObject findOneOrCreate(PropelPDO $con = null) Return the first ContentObject matching the query, or a new ContentObject object populated from the query conditions when no match is found
 *
 * @method ContentObject findOneByPageId(int $page_id) Return the first ContentObject filtered by the page_id column
 * @method ContentObject findOneByContainerName(string $container_name) Return the first ContentObject filtered by the container_name column
 * @method ContentObject findOneByObjectType(string $object_type) Return the first ContentObject filtered by the object_type column
 * @method ContentObject findOneByConditionSerialized(resource $condition_serialized) Return the first ContentObject filtered by the condition_serialized column
 * @method ContentObject findOneBySort(int $sort) Return the first ContentObject filtered by the sort column
 * @method ContentObject findOneByCreatedAt(string $created_at) Return the first ContentObject filtered by the created_at column
 * @method ContentObject findOneByUpdatedAt(string $updated_at) Return the first ContentObject filtered by the updated_at column
 * @method ContentObject findOneByCreatedBy(int $created_by) Return the first ContentObject filtered by the created_by column
 * @method ContentObject findOneByUpdatedBy(int $updated_by) Return the first ContentObject filtered by the updated_by column
 *
 * @method array findById(int $id) Return ContentObject objects filtered by the id column
 * @method array findByPageId(int $page_id) Return ContentObject objects filtered by the page_id column
 * @method array findByContainerName(string $container_name) Return ContentObject objects filtered by the container_name column
 * @method array findByObjectType(string $object_type) Return ContentObject objects filtered by the object_type column
 * @method array findByConditionSerialized(resource $condition_serialized) Return ContentObject objects filtered by the condition_serialized column
 * @method array findBySort(int $sort) Return ContentObject objects filtered by the sort column
 * @method array findByCreatedAt(string $created_at) Return ContentObject objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return ContentObject objects filtered by the updated_at column
 * @method array findByCreatedBy(int $created_by) Return ContentObject objects filtered by the created_by column
 * @method array findByUpdatedBy(int $updated_by) Return ContentObject objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseContentObjectQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseContentObjectQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rapila', $modelName = 'ContentObject', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ContentObjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ContentObjectQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ContentObjectQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ContentObjectQuery) {
            return $criteria;
        }
        $query = new ContentObjectQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
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
     * @return   ContentObject|ContentObject[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ContentObjectPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ContentObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ContentObject A model object, or null if the key is not found
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
     * @return                 ContentObject A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `page_id`, `container_name`, `object_type`, `condition_serialized`, `sort`, `created_at`, `updated_at`, `created_by`, `updated_by` FROM `objects` WHERE `id` = :p0';
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
            $obj = new ContentObject();
            $obj->hydrate($row);
            ContentObjectPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ContentObject|ContentObject[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ContentObject[]|mixed the list of results, formatted by the current formatter
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContentObjectPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContentObjectPeer::ID, $keys, Criteria::IN);
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContentObjectPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContentObjectPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the page_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPageId(1234); // WHERE page_id = 1234
     * $query->filterByPageId(array(12, 34)); // WHERE page_id IN (12, 34)
     * $query->filterByPageId(array('min' => 12)); // WHERE page_id >= 12
     * $query->filterByPageId(array('max' => 12)); // WHERE page_id <= 12
     * </code>
     *
     * @see       filterByPage()
     *
     * @param     mixed $pageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByPageId($pageId = null, $comparison = null)
    {
        if (is_array($pageId)) {
            $useMinMax = false;
            if (isset($pageId['min'])) {
                $this->addUsingAlias(ContentObjectPeer::PAGE_ID, $pageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pageId['max'])) {
                $this->addUsingAlias(ContentObjectPeer::PAGE_ID, $pageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::PAGE_ID, $pageId, $comparison);
    }

    /**
     * Filter the query on the container_name column
     *
     * Example usage:
     * <code>
     * $query->filterByContainerName('fooValue');   // WHERE container_name = 'fooValue'
     * $query->filterByContainerName('%fooValue%'); // WHERE container_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $containerName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByContainerName($containerName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($containerName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $containerName)) {
                $containerName = str_replace('*', '%', $containerName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::CONTAINER_NAME, $containerName, $comparison);
    }

    /**
     * Filter the query on the object_type column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectType('fooValue');   // WHERE object_type = 'fooValue'
     * $query->filterByObjectType('%fooValue%'); // WHERE object_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $objectType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByObjectType($objectType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($objectType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $objectType)) {
                $objectType = str_replace('*', '%', $objectType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::OBJECT_TYPE, $objectType, $comparison);
    }

    /**
     * Filter the query on the condition_serialized column
     *
     * @param     mixed $conditionSerialized The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByConditionSerialized($conditionSerialized = null, $comparison = null)
    {

        return $this->addUsingAlias(ContentObjectPeer::CONDITION_SERIALIZED, $conditionSerialized, $comparison);
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(ContentObjectPeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(ContentObjectPeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::SORT, $sort, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ContentObjectPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ContentObjectPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ContentObjectPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ContentObjectPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(ContentObjectPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(ContentObjectPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::CREATED_BY, $createdBy, $comparison);
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
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(ContentObjectPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(ContentObjectPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContentObjectPeer::UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related Page object
     *
     * @param   Page|PropelObjectCollection $page The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentObjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPage($page, $comparison = null)
    {
        if ($page instanceof Page) {
            return $this
                ->addUsingAlias(ContentObjectPeer::PAGE_ID, $page->getId(), $comparison);
        } elseif ($page instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContentObjectPeer::PAGE_ID, $page->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPage() only accepts arguments of type Page or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Page relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function joinPage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Page');

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
            $this->addJoinObject($join, 'Page');
        }

        return $this;
    }

    /**
     * Use the Page relation Page object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PageQuery A secondary query class using the current class as primary query
     */
    public function usePageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Page', 'PageQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentObjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ContentObjectPeer::CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContentObjectPeer::CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ContentObjectQuery The current query, for fluid interface
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
     * @return                 ContentObjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ContentObjectPeer::UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContentObjectPeer::UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ContentObjectQuery The current query, for fluid interface
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
     * Filter the query by a related LanguageObject object
     *
     * @param   LanguageObject|PropelObjectCollection $languageObject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentObjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageObject($languageObject, $comparison = null)
    {
        if ($languageObject instanceof LanguageObject) {
            return $this
                ->addUsingAlias(ContentObjectPeer::ID, $languageObject->getObjectId(), $comparison);
        } elseif ($languageObject instanceof PropelObjectCollection) {
            return $this
                ->useLanguageObjectQuery()
                ->filterByPrimaryKeys($languageObject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageObject() only accepts arguments of type LanguageObject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageObject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function joinLanguageObject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageObject');

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
            $this->addJoinObject($join, 'LanguageObject');
        }

        return $this;
    }

    /**
     * Use the LanguageObject relation LanguageObject object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageObjectQuery A secondary query class using the current class as primary query
     */
    public function useLanguageObjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLanguageObject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageObject', 'LanguageObjectQuery');
    }

    /**
     * Filter the query by a related LanguageObjectHistory object
     *
     * @param   LanguageObjectHistory|PropelObjectCollection $languageObjectHistory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ContentObjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageObjectHistory($languageObjectHistory, $comparison = null)
    {
        if ($languageObjectHistory instanceof LanguageObjectHistory) {
            return $this
                ->addUsingAlias(ContentObjectPeer::ID, $languageObjectHistory->getObjectId(), $comparison);
        } elseif ($languageObjectHistory instanceof PropelObjectCollection) {
            return $this
                ->useLanguageObjectHistoryQuery()
                ->filterByPrimaryKeys($languageObjectHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageObjectHistory() only accepts arguments of type LanguageObjectHistory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageObjectHistory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function joinLanguageObjectHistory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageObjectHistory');

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
            $this->addJoinObject($join, 'LanguageObjectHistory');
        }

        return $this;
    }

    /**
     * Use the LanguageObjectHistory relation LanguageObjectHistory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageObjectHistoryQuery A secondary query class using the current class as primary query
     */
    public function useLanguageObjectHistoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLanguageObjectHistory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageObjectHistory', 'LanguageObjectHistoryQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ContentObject $contentObject Object to remove from the list of results
     *
     * @return ContentObjectQuery The current query, for fluid interface
     */
    public function prune($contentObject = null)
    {
        if ($contentObject) {
            $this->addUsingAlias(ContentObjectPeer::ID, $contentObject->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // extended_timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ContentObjectQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ContentObjectPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ContentObjectQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContentObjectPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ContentObjectQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContentObjectPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ContentObjectQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ContentObjectPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     ContentObjectQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ContentObjectPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ContentObjectQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ContentObjectPeer::CREATED_AT);
    }
    // extended_keyable behavior

    public function filterByPKArray($pkArray) {
            return $this->filterByPrimaryKey($pkArray[0]);
    }

    public function filterByPKString($pkString) {
        return $this->filterByPrimaryKey($pkString);
    }

}
