<?php


/**
 * Base class that represents a query for the 'language_objects' table.
 *
 * 
 *
 * @method     LanguageObjectQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method     LanguageObjectQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     LanguageObjectQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     LanguageObjectQuery orderByHasDraft($order = Criteria::ASC) Order by the has_draft column
 * @method     LanguageObjectQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     LanguageObjectQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     LanguageObjectQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     LanguageObjectQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     LanguageObjectQuery groupByObjectId() Group by the object_id column
 * @method     LanguageObjectQuery groupByLanguageId() Group by the language_id column
 * @method     LanguageObjectQuery groupByData() Group by the data column
 * @method     LanguageObjectQuery groupByHasDraft() Group by the has_draft column
 * @method     LanguageObjectQuery groupByCreatedAt() Group by the created_at column
 * @method     LanguageObjectQuery groupByUpdatedAt() Group by the updated_at column
 * @method     LanguageObjectQuery groupByCreatedBy() Group by the created_by column
 * @method     LanguageObjectQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     LanguageObjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     LanguageObjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     LanguageObjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     LanguageObjectQuery leftJoinContentObject($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentObject relation
 * @method     LanguageObjectQuery rightJoinContentObject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentObject relation
 * @method     LanguageObjectQuery innerJoinContentObject($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentObject relation
 *
 * @method     LanguageObjectQuery leftJoinLanguage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Language relation
 * @method     LanguageObjectQuery rightJoinLanguage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     LanguageObjectQuery innerJoinLanguage($relationAlias = null) Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     LanguageObjectQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     LanguageObjectQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     LanguageObjectQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     LanguageObjectQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     LanguageObjectQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     LanguageObjectQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     LanguageObject findOne(PropelPDO $con = null) Return the first LanguageObject matching the query
 * @method     LanguageObject findOneOrCreate(PropelPDO $con = null) Return the first LanguageObject matching the query, or a new LanguageObject object populated from the query conditions when no match is found
 *
 * @method     LanguageObject findOneByObjectId(int $object_id) Return the first LanguageObject filtered by the object_id column
 * @method     LanguageObject findOneByLanguageId(string $language_id) Return the first LanguageObject filtered by the language_id column
 * @method     LanguageObject findOneByData(resource $data) Return the first LanguageObject filtered by the data column
 * @method     LanguageObject findOneByHasDraft(boolean $has_draft) Return the first LanguageObject filtered by the has_draft column
 * @method     LanguageObject findOneByCreatedAt(string $created_at) Return the first LanguageObject filtered by the created_at column
 * @method     LanguageObject findOneByUpdatedAt(string $updated_at) Return the first LanguageObject filtered by the updated_at column
 * @method     LanguageObject findOneByCreatedBy(int $created_by) Return the first LanguageObject filtered by the created_by column
 * @method     LanguageObject findOneByUpdatedBy(int $updated_by) Return the first LanguageObject filtered by the updated_by column
 *
 * @method     array findByObjectId(int $object_id) Return LanguageObject objects filtered by the object_id column
 * @method     array findByLanguageId(string $language_id) Return LanguageObject objects filtered by the language_id column
 * @method     array findByData(resource $data) Return LanguageObject objects filtered by the data column
 * @method     array findByHasDraft(boolean $has_draft) Return LanguageObject objects filtered by the has_draft column
 * @method     array findByCreatedAt(string $created_at) Return LanguageObject objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return LanguageObject objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return LanguageObject objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return LanguageObject objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseLanguageObjectQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseLanguageObjectQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'rapila', $modelName = 'LanguageObject', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new LanguageObjectQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    LanguageObjectQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof LanguageObjectQuery) {
			return $criteria;
		}
		$query = new LanguageObjectQuery();
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
	 * $obj = $c->findPk(array(12, 34), $con);
	 * </code>
	 *
	 * @param     array[$object_id, $language_id] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    LanguageObject|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = LanguageObjectPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(LanguageObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    LanguageObject A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `OBJECT_ID`, `LANGUAGE_ID`, `DATA`, `HAS_DRAFT`, `CREATED_AT`, `UPDATED_AT`, `CREATED_BY`, `UPDATED_BY` FROM `language_objects` WHERE `OBJECT_ID` = :p0 AND `LANGUAGE_ID` = :p1';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
			$stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new LanguageObject();
			$obj->hydrate($row);
			LanguageObjectPeer::addInstanceToPool($obj, serialize(array((string) $row[0], (string) $row[1])));
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
	 * @return    LanguageObject|array|mixed the result, formatted by the current formatter
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
	 * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		$this->addUsingAlias(LanguageObjectPeer::OBJECT_ID, $key[0], Criteria::EQUAL);
		$this->addUsingAlias(LanguageObjectPeer::LANGUAGE_ID, $key[1], Criteria::EQUAL);

		return $this;
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		if (empty($keys)) {
			return $this->add(null, '1<>1', Criteria::CUSTOM);
		}
		foreach ($keys as $key) {
			$cton0 = $this->getNewCriterion(LanguageObjectPeer::OBJECT_ID, $key[0], Criteria::EQUAL);
			$cton1 = $this->getNewCriterion(LanguageObjectPeer::LANGUAGE_ID, $key[1], Criteria::EQUAL);
			$cton0->addAnd($cton1);
			$this->addOr($cton0);
		}

		return $this;
	}

	/**
	 * Filter the query on the object_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByObjectId(1234); // WHERE object_id = 1234
	 * $query->filterByObjectId(array(12, 34)); // WHERE object_id IN (12, 34)
	 * $query->filterByObjectId(array('min' => 12)); // WHERE object_id > 12
	 * </code>
	 *
	 * @see       filterByContentObject()
	 *
	 * @param     mixed $objectId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByObjectId($objectId = null, $comparison = null)
	{
		if (is_array($objectId) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(LanguageObjectPeer::OBJECT_ID, $objectId, $comparison);
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
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
		return $this->addUsingAlias(LanguageObjectPeer::LANGUAGE_ID, $languageId, $comparison);
	}

	/**
	 * Filter the query on the data column
	 *
	 * @param     mixed $data The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByData($data = null, $comparison = null)
	{
		return $this->addUsingAlias(LanguageObjectPeer::DATA, $data, $comparison);
	}

	/**
	 * Filter the query on the has_draft column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByHasDraft(true); // WHERE has_draft = true
	 * $query->filterByHasDraft('yes'); // WHERE has_draft = true
	 * </code>
	 *
	 * @param     boolean|string $hasDraft The value to use as filter.
	 *              Non-boolean arguments are converted using the following rules:
	 *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
	 *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
	 *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByHasDraft($hasDraft = null, $comparison = null)
	{
		if (is_string($hasDraft)) {
			$has_draft = in_array(strtolower($hasDraft), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
		}
		return $this->addUsingAlias(LanguageObjectPeer::HAS_DRAFT, $hasDraft, $comparison);
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(LanguageObjectPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(LanguageObjectPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(LanguageObjectPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(LanguageObjectPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
	 * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
	 * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by > 12
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = null)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(LanguageObjectPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(LanguageObjectPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByUpdatedBy(1234); // WHERE updated_by = 1234
	 * $query->filterByUpdatedBy(array(12, 34)); // WHERE updated_by IN (12, 34)
	 * $query->filterByUpdatedBy(array('min' => 12)); // WHERE updated_by > 12
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = null)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(LanguageObjectPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(LanguageObjectPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related ContentObject object
	 *
	 * @param     ContentObject|PropelCollection $contentObject The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByContentObject($contentObject, $comparison = null)
	{
		if ($contentObject instanceof ContentObject) {
			return $this
				->addUsingAlias(LanguageObjectPeer::OBJECT_ID, $contentObject->getId(), $comparison);
		} elseif ($contentObject instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(LanguageObjectPeer::OBJECT_ID, $contentObject->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByContentObject() only accepts arguments of type ContentObject or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the ContentObject relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function joinContentObject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ContentObject');

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
			$this->addJoinObject($join, 'ContentObject');
		}

		return $this;
	}

	/**
	 * Use the ContentObject relation ContentObject object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContentObjectQuery A secondary query class using the current class as primary query
	 */
	public function useContentObjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinContentObject($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ContentObject', 'ContentObjectQuery');
	}

	/**
	 * Filter the query by a related Language object
	 *
	 * @param     Language|PropelCollection $language The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = null)
	{
		if ($language instanceof Language) {
			return $this
				->addUsingAlias(LanguageObjectPeer::LANGUAGE_ID, $language->getId(), $comparison);
		} elseif ($language instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(LanguageObjectPeer::LANGUAGE_ID, $language->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function joinLanguage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
	public function useLanguageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinLanguage($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Language', 'LanguageQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(LanguageObjectPeer::CREATED_BY, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(LanguageObjectPeer::CREATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
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
	public function useUserRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', 'UserQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User|PropelCollection $user The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
	{
		if ($user instanceof User) {
			return $this
				->addUsingAlias(LanguageObjectPeer::UPDATED_BY, $user->getId(), $comparison);
		} elseif ($user instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(LanguageObjectPeer::UPDATED_BY, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
	 * @return    LanguageObjectQuery The current query, for fluid interface
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
	public function useUserRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUpdatedBy', 'UserQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     LanguageObject $languageObject Object to remove from the list of results
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function prune($languageObject = null)
	{
		if ($languageObject) {
			$this->addCond('pruneCond0', $this->getAliasedColName(LanguageObjectPeer::OBJECT_ID), $languageObject->getObjectId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond1', $this->getAliasedColName(LanguageObjectPeer::LANGUAGE_ID), $languageObject->getLanguageId(), Criteria::NOT_EQUAL);
			$this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
		}

		return $this;
	}

	// extended_timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     LanguageObjectQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(LanguageObjectPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     LanguageObjectQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(LanguageObjectPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     LanguageObjectQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(LanguageObjectPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     LanguageObjectQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(LanguageObjectPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     LanguageObjectQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(LanguageObjectPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     LanguageObjectQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(LanguageObjectPeer::CREATED_AT);
	}

} // BaseLanguageObjectQuery