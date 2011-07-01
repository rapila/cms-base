<?php


/**
 * Base class that represents a query for the 'language_object_history' table.
 *
 * 
 *
 * @method     LanguageObjectHistoryQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method     LanguageObjectHistoryQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     LanguageObjectHistoryQuery orderByData($order = Criteria::ASC) Order by the data column
 * @method     LanguageObjectHistoryQuery orderByRevision($order = Criteria::ASC) Order by the revision column
 * @method     LanguageObjectHistoryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     LanguageObjectHistoryQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     LanguageObjectHistoryQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     LanguageObjectHistoryQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     LanguageObjectHistoryQuery groupByObjectId() Group by the object_id column
 * @method     LanguageObjectHistoryQuery groupByLanguageId() Group by the language_id column
 * @method     LanguageObjectHistoryQuery groupByData() Group by the data column
 * @method     LanguageObjectHistoryQuery groupByRevision() Group by the revision column
 * @method     LanguageObjectHistoryQuery groupByCreatedAt() Group by the created_at column
 * @method     LanguageObjectHistoryQuery groupByUpdatedAt() Group by the updated_at column
 * @method     LanguageObjectHistoryQuery groupByCreatedBy() Group by the created_by column
 * @method     LanguageObjectHistoryQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     LanguageObjectHistoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     LanguageObjectHistoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     LanguageObjectHistoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     LanguageObjectHistoryQuery leftJoinContentObject($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentObject relation
 * @method     LanguageObjectHistoryQuery rightJoinContentObject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentObject relation
 * @method     LanguageObjectHistoryQuery innerJoinContentObject($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentObject relation
 *
 * @method     LanguageObjectHistoryQuery leftJoinLanguage($relationAlias = null) Adds a LEFT JOIN clause to the query using the Language relation
 * @method     LanguageObjectHistoryQuery rightJoinLanguage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     LanguageObjectHistoryQuery innerJoinLanguage($relationAlias = null) Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     LanguageObjectHistoryQuery leftJoinUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     LanguageObjectHistoryQuery rightJoinUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     LanguageObjectHistoryQuery innerJoinUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     LanguageObjectHistoryQuery leftJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     LanguageObjectHistoryQuery rightJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     LanguageObjectHistoryQuery innerJoinUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     LanguageObjectHistory findOne(PropelPDO $con = null) Return the first LanguageObjectHistory matching the query
 * @method     LanguageObjectHistory findOneOrCreate(PropelPDO $con = null) Return the first LanguageObjectHistory matching the query, or a new LanguageObjectHistory object populated from the query conditions when no match is found
 *
 * @method     LanguageObjectHistory findOneByObjectId(int $object_id) Return the first LanguageObjectHistory filtered by the object_id column
 * @method     LanguageObjectHistory findOneByLanguageId(string $language_id) Return the first LanguageObjectHistory filtered by the language_id column
 * @method     LanguageObjectHistory findOneByData(resource $data) Return the first LanguageObjectHistory filtered by the data column
 * @method     LanguageObjectHistory findOneByRevision(int $revision) Return the first LanguageObjectHistory filtered by the revision column
 * @method     LanguageObjectHistory findOneByCreatedAt(string $created_at) Return the first LanguageObjectHistory filtered by the created_at column
 * @method     LanguageObjectHistory findOneByUpdatedAt(string $updated_at) Return the first LanguageObjectHistory filtered by the updated_at column
 * @method     LanguageObjectHistory findOneByCreatedBy(int $created_by) Return the first LanguageObjectHistory filtered by the created_by column
 * @method     LanguageObjectHistory findOneByUpdatedBy(int $updated_by) Return the first LanguageObjectHistory filtered by the updated_by column
 *
 * @method     array findByObjectId(int $object_id) Return LanguageObjectHistory objects filtered by the object_id column
 * @method     array findByLanguageId(string $language_id) Return LanguageObjectHistory objects filtered by the language_id column
 * @method     array findByData(resource $data) Return LanguageObjectHistory objects filtered by the data column
 * @method     array findByRevision(int $revision) Return LanguageObjectHistory objects filtered by the revision column
 * @method     array findByCreatedAt(string $created_at) Return LanguageObjectHistory objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return LanguageObjectHistory objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return LanguageObjectHistory objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return LanguageObjectHistory objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseLanguageObjectHistoryQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseLanguageObjectHistoryQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'LanguageObjectHistory', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new LanguageObjectHistoryQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    LanguageObjectHistoryQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof LanguageObjectHistoryQuery) {
			return $criteria;
		}
		$query = new LanguageObjectHistoryQuery();
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
	 * $obj = $c->findPk(array(12, 34, 56), $con);
	 * </code>
	 * @param     array[$object_id, $language_id, $revision] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    LanguageObjectHistory|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = LanguageObjectHistoryPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		$this->addUsingAlias(LanguageObjectHistoryPeer::OBJECT_ID, $key[0], Criteria::EQUAL);
		$this->addUsingAlias(LanguageObjectHistoryPeer::LANGUAGE_ID, $key[1], Criteria::EQUAL);
		$this->addUsingAlias(LanguageObjectHistoryPeer::REVISION, $key[2], Criteria::EQUAL);
		
		return $this;
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		if (empty($keys)) {
			return $this->add(null, '1<>1', Criteria::CUSTOM);
		}
		foreach ($keys as $key) {
			$cton0 = $this->getNewCriterion(LanguageObjectHistoryPeer::OBJECT_ID, $key[0], Criteria::EQUAL);
			$cton1 = $this->getNewCriterion(LanguageObjectHistoryPeer::LANGUAGE_ID, $key[1], Criteria::EQUAL);
			$cton0->addAnd($cton1);
			$cton2 = $this->getNewCriterion(LanguageObjectHistoryPeer::REVISION, $key[2], Criteria::EQUAL);
			$cton0->addAnd($cton2);
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
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByObjectId($objectId = null, $comparison = null)
	{
		if (is_array($objectId) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(LanguageObjectHistoryPeer::OBJECT_ID, $objectId, $comparison);
	}

	/**
	 * Filter the query on the language_id column
	 * 
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
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
		return $this->addUsingAlias(LanguageObjectHistoryPeer::LANGUAGE_ID, $languageId, $comparison);
	}

	/**
	 * Filter the query on the data column
	 * 
	 * @param     mixed $data The value to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByData($data = null, $comparison = null)
	{
		return $this->addUsingAlias(LanguageObjectHistoryPeer::DATA, $data, $comparison);
	}

	/**
	 * Filter the query on the revision column
	 * 
	 * @param     int|array $revision The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByRevision($revision = null, $comparison = null)
	{
		if (is_array($revision) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(LanguageObjectHistoryPeer::REVISION, $revision, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = null)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = null)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related ContentObject object
	 *
	 * @param     ContentObject $contentObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByContentObject($contentObject, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectHistoryPeer::OBJECT_ID, $contentObject->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ContentObject relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
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
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectHistoryPeer::LANGUAGE_ID, $language->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Language relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
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
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectHistoryPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
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
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
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
	 * @param     LanguageObjectHistory $languageObjectHistory Object to remove from the list of results
	 *
	 * @return    LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function prune($languageObjectHistory = null)
	{
		if ($languageObjectHistory) {
			$this->addCond('pruneCond0', $this->getAliasedColName(LanguageObjectHistoryPeer::OBJECT_ID), $languageObjectHistory->getObjectId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond1', $this->getAliasedColName(LanguageObjectHistoryPeer::LANGUAGE_ID), $languageObjectHistory->getLanguageId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond2', $this->getAliasedColName(LanguageObjectHistoryPeer::REVISION), $languageObjectHistory->getRevision(), Criteria::NOT_EQUAL);
			$this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
	  }
	  
		return $this;
	}

	// extended_timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(LanguageObjectHistoryPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(LanguageObjectHistoryPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(LanguageObjectHistoryPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(LanguageObjectHistoryPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(LanguageObjectHistoryPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     LanguageObjectHistoryQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(LanguageObjectHistoryPeer::CREATED_AT);
	}

} // BaseLanguageObjectHistoryQuery
