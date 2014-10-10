<?php


/**
 * Base class that represents a query for the 'scheduled_actions' table.
 *
 *
 *
 * @method ScheduledActionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ScheduledActionQuery orderByModelId($order = Criteria::ASC) Order by the model_id column
 * @method ScheduledActionQuery orderByModelName($order = Criteria::ASC) Order by the model_name column
 * @method ScheduledActionQuery orderByScheduleDate($order = Criteria::ASC) Order by the schedule_date column
 * @method ScheduledActionQuery orderByExecutionDate($order = Criteria::ASC) Order by the execution_date column
 * @method ScheduledActionQuery orderByAction($order = Criteria::ASC) Order by the action column
 * @method ScheduledActionQuery orderByParams($order = Criteria::ASC) Order by the params column
 * @method ScheduledActionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method ScheduledActionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method ScheduledActionQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method ScheduledActionQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method ScheduledActionQuery groupById() Group by the id column
 * @method ScheduledActionQuery groupByModelId() Group by the model_id column
 * @method ScheduledActionQuery groupByModelName() Group by the model_name column
 * @method ScheduledActionQuery groupByScheduleDate() Group by the schedule_date column
 * @method ScheduledActionQuery groupByExecutionDate() Group by the execution_date column
 * @method ScheduledActionQuery groupByAction() Group by the action column
 * @method ScheduledActionQuery groupByParams() Group by the params column
 * @method ScheduledActionQuery groupByCreatedAt() Group by the created_at column
 * @method ScheduledActionQuery groupByUpdatedAt() Group by the updated_at column
 * @method ScheduledActionQuery groupByCreatedBy() Group by the created_by column
 * @method ScheduledActionQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method ScheduledActionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ScheduledActionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ScheduledActionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ScheduledActionQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method ScheduledActionQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method ScheduledActionQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method ScheduledActionQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method ScheduledActionQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method ScheduledActionQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method ScheduledAction findOne(PropelPDO $con = null) Return the first ScheduledAction matching the query
 * @method ScheduledAction findOneOrCreate(PropelPDO $con = null) Return the first ScheduledAction matching the query, or a new ScheduledAction object populated from the query conditions when no match is found
 *
 * @method ScheduledAction findOneByModelId(string $model_id) Return the first ScheduledAction filtered by the model_id column
 * @method ScheduledAction findOneByModelName(string $model_name) Return the first ScheduledAction filtered by the model_name column
 * @method ScheduledAction findOneByScheduleDate(string $schedule_date) Return the first ScheduledAction filtered by the schedule_date column
 * @method ScheduledAction findOneByExecutionDate(string $execution_date) Return the first ScheduledAction filtered by the execution_date column
 * @method ScheduledAction findOneByAction(string $action) Return the first ScheduledAction filtered by the action column
 * @method ScheduledAction findOneByParams(resource $params) Return the first ScheduledAction filtered by the params column
 * @method ScheduledAction findOneByCreatedAt(string $created_at) Return the first ScheduledAction filtered by the created_at column
 * @method ScheduledAction findOneByUpdatedAt(string $updated_at) Return the first ScheduledAction filtered by the updated_at column
 * @method ScheduledAction findOneByCreatedBy(int $created_by) Return the first ScheduledAction filtered by the created_by column
 * @method ScheduledAction findOneByUpdatedBy(int $updated_by) Return the first ScheduledAction filtered by the updated_by column
 *
 * @method array findById(int $id) Return ScheduledAction objects filtered by the id column
 * @method array findByModelId(string $model_id) Return ScheduledAction objects filtered by the model_id column
 * @method array findByModelName(string $model_name) Return ScheduledAction objects filtered by the model_name column
 * @method array findByScheduleDate(string $schedule_date) Return ScheduledAction objects filtered by the schedule_date column
 * @method array findByExecutionDate(string $execution_date) Return ScheduledAction objects filtered by the execution_date column
 * @method array findByAction(string $action) Return ScheduledAction objects filtered by the action column
 * @method array findByParams(resource $params) Return ScheduledAction objects filtered by the params column
 * @method array findByCreatedAt(string $created_at) Return ScheduledAction objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return ScheduledAction objects filtered by the updated_at column
 * @method array findByCreatedBy(int $created_by) Return ScheduledAction objects filtered by the created_by column
 * @method array findByUpdatedBy(int $updated_by) Return ScheduledAction objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseScheduledActionQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseScheduledActionQuery object.
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
            $modelName = 'ScheduledAction';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ScheduledActionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ScheduledActionQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ScheduledActionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ScheduledActionQuery) {
            return $criteria;
        }
        $query = new ScheduledActionQuery(null, null, $modelAlias);

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
     * @return   ScheduledAction|ScheduledAction[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ScheduledActionPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ScheduledActionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ScheduledAction A model object, or null if the key is not found
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
     * @return                 ScheduledAction A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `model_id`, `model_name`, `schedule_date`, `execution_date`, `action`, `params`, `created_at`, `updated_at`, `created_by`, `updated_by` FROM `scheduled_actions` WHERE `id` = :p0';
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
            $obj = new ScheduledAction();
            $obj->hydrate($row);
            ScheduledActionPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ScheduledAction|ScheduledAction[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ScheduledAction[]|mixed the list of results, formatted by the current formatter
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
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ScheduledActionPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ScheduledActionPeer::ID, $keys, Criteria::IN);
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
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the model_id column
     *
     * Example usage:
     * <code>
     * $query->filterByModelId('fooValue');   // WHERE model_id = 'fooValue'
     * $query->filterByModelId('%fooValue%'); // WHERE model_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modelId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByModelId($modelId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modelId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modelId)) {
                $modelId = str_replace('*', '%', $modelId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::MODEL_ID, $modelId, $comparison);
    }

    /**
     * Filter the query on the model_name column
     *
     * Example usage:
     * <code>
     * $query->filterByModelName('fooValue');   // WHERE model_name = 'fooValue'
     * $query->filterByModelName('%fooValue%'); // WHERE model_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modelName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByModelName($modelName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modelName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modelName)) {
                $modelName = str_replace('*', '%', $modelName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::MODEL_NAME, $modelName, $comparison);
    }

    /**
     * Filter the query on the schedule_date column
     *
     * Example usage:
     * <code>
     * $query->filterByScheduleDate('2011-03-14'); // WHERE schedule_date = '2011-03-14'
     * $query->filterByScheduleDate('now'); // WHERE schedule_date = '2011-03-14'
     * $query->filterByScheduleDate(array('max' => 'yesterday')); // WHERE schedule_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $scheduleDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByScheduleDate($scheduleDate = null, $comparison = null)
    {
        if (is_array($scheduleDate)) {
            $useMinMax = false;
            if (isset($scheduleDate['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::SCHEDULE_DATE, $scheduleDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($scheduleDate['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::SCHEDULE_DATE, $scheduleDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::SCHEDULE_DATE, $scheduleDate, $comparison);
    }

    /**
     * Filter the query on the execution_date column
     *
     * Example usage:
     * <code>
     * $query->filterByExecutionDate('2011-03-14'); // WHERE execution_date = '2011-03-14'
     * $query->filterByExecutionDate('now'); // WHERE execution_date = '2011-03-14'
     * $query->filterByExecutionDate(array('max' => 'yesterday')); // WHERE execution_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $executionDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByExecutionDate($executionDate = null, $comparison = null)
    {
        if (is_array($executionDate)) {
            $useMinMax = false;
            if (isset($executionDate['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::EXECUTION_DATE, $executionDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($executionDate['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::EXECUTION_DATE, $executionDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::EXECUTION_DATE, $executionDate, $comparison);
    }

    /**
     * Filter the query on the action column
     *
     * Example usage:
     * <code>
     * $query->filterByAction('fooValue');   // WHERE action = 'fooValue'
     * $query->filterByAction('%fooValue%'); // WHERE action LIKE '%fooValue%'
     * </code>
     *
     * @param     string $action The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByAction($action = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($action)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $action)) {
                $action = str_replace('*', '%', $action);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::ACTION, $action, $comparison);
    }

    /**
     * Filter the query on the params column
     *
     * @param     mixed $params The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByParams($params = null, $comparison = null)
    {

        return $this->addUsingAlias(ScheduledActionPeer::PARAMS, $params, $comparison);
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
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::CREATED_BY, $createdBy, $comparison);
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
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(ScheduledActionPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(ScheduledActionPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ScheduledActionPeer::UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ScheduledActionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByCreatedBy($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ScheduledActionPeer::CREATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ScheduledActionPeer::CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ScheduledActionQuery The current query, for fluid interface
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
     * @return                 ScheduledActionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(ScheduledActionPeer::UPDATED_BY, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ScheduledActionPeer::UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return ScheduledActionQuery The current query, for fluid interface
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
     * @param   ScheduledAction $scheduledAction Object to remove from the list of results
     *
     * @return ScheduledActionQuery The current query, for fluid interface
     */
    public function prune($scheduledAction = null)
    {
        if ($scheduledAction) {
            $this->addUsingAlias(ScheduledActionPeer::ID, $scheduledAction->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // extended_timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ScheduledActionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ScheduledActionPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ScheduledActionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ScheduledActionPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ScheduledActionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ScheduledActionPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ScheduledActionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ScheduledActionPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     ScheduledActionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ScheduledActionPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ScheduledActionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ScheduledActionPeer::CREATED_AT);
    }
    public function findMostRecentUpdate($bAsTimestamp = false) {
        $oQuery = clone $this;
        $sDate = $oQuery->lastUpdatedFirst()->select("UpdatedAt")->findOne();
        if($sDate === null) {
            return null;
        }
        $oDate = new DateTime($sDate);
        if($bAsTimestamp) {
            return $oDate->getTimestamp();
        }
        return $oDate;
    }

    // extended_keyable behavior

    public function filterByPKArray($pkArray) {
            return $this->filterByPrimaryKey($pkArray[0]);
    }

    public function filterByPKString($pkString) {
        return $this->filterByPrimaryKey($pkString);
    }

}
