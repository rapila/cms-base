<?php


/**
 * Base class that represents a query for the 'language_objects' table.
 *
 * 
 *
 * @method     LanguageObjectQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method     LanguageObjectQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     LanguageObjectQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     LanguageObjectQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     LanguageObjectQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     LanguageObjectQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     LanguageObjectQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     LanguageObjectQuery groupByObjectId() Group by the object_id column
 * @method     LanguageObjectQuery groupByLanguageId() Group by the language_id column
 * @method     LanguageObjectQuery groupByData() Group by the data column
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
 * @method     LanguageObject findOneByCreatedAt(string $created_at) Return the first LanguageObject filtered by the created_at column
 * @method     LanguageObject findOneByUpdatedAt(string $updated_at) Return the first LanguageObject filtered by the updated_at column
 * @method     LanguageObject findOneByCreatedBy(int $created_by) Return the first LanguageObject filtered by the created_by column
 * @method     LanguageObject findOneByUpdatedBy(int $updated_by) Return the first LanguageObject filtered by the updated_by column
 *
 * @method     array findByObjectId(int $object_id) Return LanguageObject objects filtered by the object_id column
 * @method     array findByLanguageId(string $language_id) Return LanguageObject objects filtered by the language_id column
 * @method     array findByData(resource $data) Return LanguageObject objects filtered by the data column
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
	public function __construct($dbName = 'mini_cms', $modelName = 'LanguageObject', $modelAlias = null)
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
	 * Find object by primary key
	 * <code>
	 * $obj = $c->findPk(array(12, 34), $con);
	 * </code>
	 * @param     array[$object_id, $language_id] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    LanguageObject|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = LanguageObjectPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
	 * @param     int|array $objectId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
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
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
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
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
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
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
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
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
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
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
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
	 * @param     ContentObject $contentObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByContentObject($contentObject, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectPeer::OBJECT_ID, $contentObject->getId(), $comparison);
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
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectPeer::LANGUAGE_ID, $language->getId(), $comparison);
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
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectPeer::CREATED_BY, $user->getId(), $comparison);
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
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectPeer::UPDATED_BY, $user->getId(), $comparison);
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
