<?php


/**
 * Base class that represents a query for the 'languages' table.
 *
 * 
 *
 * @method     LanguageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     LanguageQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method     LanguageQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method     LanguageQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     LanguageQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     LanguageQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     LanguageQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     LanguageQuery groupById() Group by the id column
 * @method     LanguageQuery groupByIsActive() Group by the is_active column
 * @method     LanguageQuery groupBySort() Group by the sort column
 * @method     LanguageQuery groupByCreatedAt() Group by the created_at column
 * @method     LanguageQuery groupByUpdatedAt() Group by the updated_at column
 * @method     LanguageQuery groupByCreatedBy() Group by the created_by column
 * @method     LanguageQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     LanguageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     LanguageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     LanguageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     LanguageQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     LanguageQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     LanguageQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     LanguageQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     LanguageQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     LanguageQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     LanguageQuery leftJoinPageString($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageString relation
 * @method     LanguageQuery rightJoinPageString($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageString relation
 * @method     LanguageQuery innerJoinPageString($relationAlias = '') Adds a INNER JOIN clause to the query using the PageString relation
 *
 * @method     LanguageQuery leftJoinLanguageObject($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObject relation
 * @method     LanguageQuery rightJoinLanguageObject($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObject relation
 * @method     LanguageQuery innerJoinLanguageObject($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObject relation
 *
 * @method     LanguageQuery leftJoinLanguageObjectHistory($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObjectHistory relation
 * @method     LanguageQuery rightJoinLanguageObjectHistory($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObjectHistory relation
 * @method     LanguageQuery innerJoinLanguageObjectHistory($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObjectHistory relation
 *
 * @method     LanguageQuery leftJoinString($relationAlias = '') Adds a LEFT JOIN clause to the query using the String relation
 * @method     LanguageQuery rightJoinString($relationAlias = '') Adds a RIGHT JOIN clause to the query using the String relation
 * @method     LanguageQuery innerJoinString($relationAlias = '') Adds a INNER JOIN clause to the query using the String relation
 *
 * @method     LanguageQuery leftJoinUser($relationAlias = '') Adds a LEFT JOIN clause to the query using the User relation
 * @method     LanguageQuery rightJoinUser($relationAlias = '') Adds a RIGHT JOIN clause to the query using the User relation
 * @method     LanguageQuery innerJoinUser($relationAlias = '') Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     LanguageQuery leftJoinDocument($relationAlias = '') Adds a LEFT JOIN clause to the query using the Document relation
 * @method     LanguageQuery rightJoinDocument($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Document relation
 * @method     LanguageQuery innerJoinDocument($relationAlias = '') Adds a INNER JOIN clause to the query using the Document relation
 *
 * @method     LanguageQuery leftJoinLink($relationAlias = '') Adds a LEFT JOIN clause to the query using the Link relation
 * @method     LanguageQuery rightJoinLink($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Link relation
 * @method     LanguageQuery innerJoinLink($relationAlias = '') Adds a INNER JOIN clause to the query using the Link relation
 *
 * @method     Language findOne(PropelPDO $con = null) Return the first Language matching the query
 * @method     Language findOneById(string $id) Return the first Language filtered by the id column
 * @method     Language findOneByIsActive(boolean $is_active) Return the first Language filtered by the is_active column
 * @method     Language findOneBySort(int $sort) Return the first Language filtered by the sort column
 * @method     Language findOneByCreatedAt(string $created_at) Return the first Language filtered by the created_at column
 * @method     Language findOneByUpdatedAt(string $updated_at) Return the first Language filtered by the updated_at column
 * @method     Language findOneByCreatedBy(int $created_by) Return the first Language filtered by the created_by column
 * @method     Language findOneByUpdatedBy(int $updated_by) Return the first Language filtered by the updated_by column
 *
 * @method     array findById(string $id) Return Language objects filtered by the id column
 * @method     array findByIsActive(boolean $is_active) Return Language objects filtered by the is_active column
 * @method     array findBySort(int $sort) Return Language objects filtered by the sort column
 * @method     array findByCreatedAt(string $created_at) Return Language objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Language objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return Language objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return Language objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseLanguageQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseLanguageQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'Language', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new LanguageQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    LanguageQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof LanguageQuery) {
			return $criteria;
		}
		$query = new LanguageQuery();
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
	 * @return    Language|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = LanguagePeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(LanguagePeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(LanguagePeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     string $id The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id)) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $id)) {
			$id = str_replace('*', '%', $id);
			if (null === $comparison) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(LanguagePeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the is_active column
	 * 
	 * @param     boolean|string $isActive The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByIsActive($isActive = null, $comparison = null)
	{
		if (is_string($isActive)) {
			$is_active = in_array(strtolower($isActive), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(LanguagePeer::IS_ACTIVE, $isActive, $comparison);
	}

	/**
	 * Filter the query on the sort column
	 * 
	 * @param     int|array $sort The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterBySort($sort = null, $comparison = null)
	{
		if (is_array($sort)) {
			$useMinMax = false;
			if (isset($sort['min'])) {
				$this->addUsingAlias(LanguagePeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($sort['max'])) {
				$this->addUsingAlias(LanguagePeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguagePeer::SORT, $sort, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(LanguagePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(LanguagePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguagePeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(LanguagePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(LanguagePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguagePeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = null)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(LanguagePeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(LanguagePeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguagePeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = null)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(LanguagePeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(LanguagePeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LanguagePeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
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
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
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
	 * Filter the query by a related PageString object
	 *
	 * @param     PageString $pageString  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByPageString($pageString, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $pageString->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageString relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinPageString($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageString');
		
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
			$this->addJoinObject($join, 'PageString');
		}
		
		return $this;
	}

	/**
	 * Use the PageString relation PageString object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageStringQuery A secondary query class using the current class as primary query
	 */
	public function usePageStringQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPageString($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageString', 'PageStringQuery');
	}

	/**
	 * Filter the query by a related LanguageObject object
	 *
	 * @param     LanguageObject $languageObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByLanguageObject($languageObject, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $languageObject->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObject relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinLanguageObject($relationAlias = '', $joinType = Criteria::INNER_JOIN)
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
		if($relationAlias) {
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
	 * @return    LanguageObjectQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageObjectQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinLanguageObject($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageObject', 'LanguageObjectQuery');
	}

	/**
	 * Filter the query by a related LanguageObjectHistory object
	 *
	 * @param     LanguageObjectHistory $languageObjectHistory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByLanguageObjectHistory($languageObjectHistory, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $languageObjectHistory->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObjectHistory relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinLanguageObjectHistory($relationAlias = '', $joinType = Criteria::INNER_JOIN)
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
		if($relationAlias) {
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
	 * @return    LanguageObjectHistoryQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageObjectHistoryQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinLanguageObjectHistory($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageObjectHistory', 'LanguageObjectHistoryQuery');
	}

	/**
	 * Filter the query by a related String object
	 *
	 * @param     String $string  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByString($string, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $string->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the String relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinString($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('String');
		
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
			$this->addJoinObject($join, 'String');
		}
		
		return $this;
	}

	/**
	 * Use the String relation String object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    StringQuery A secondary query class using the current class as primary query
	 */
	public function useStringQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinString($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'String', 'StringQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $user->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the User relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinUser($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('User');
		
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
			$this->addJoinObject($join, 'User');
		}
		
		return $this;
	}

	/**
	 * Use the User relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User', 'UserQuery');
	}

	/**
	 * Filter the query by a related Document object
	 *
	 * @param     Document $document  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByDocument($document, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $document->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Document relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinDocument($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Document');
		
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
			$this->addJoinObject($join, 'Document');
		}
		
		return $this;
	}

	/**
	 * Use the Document relation Document object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DocumentQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocument($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Document', 'DocumentQuery');
	}

	/**
	 * Filter the query by a related Link object
	 *
	 * @param     Link $link  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function filterByLink($link, $comparison = null)
	{
		return $this
			->addUsingAlias(LanguagePeer::ID, $link->getLanguageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Link relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function joinLink($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Link');
		
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
			$this->addJoinObject($join, 'Link');
		}
		
		return $this;
	}

	/**
	 * Use the Link relation Link object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LinkQuery A secondary query class using the current class as primary query
	 */
	public function useLinkQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLink($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Link', 'LinkQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Language $language Object to remove from the list of results
	 *
	 * @return    LanguageQuery The current query, for fluid interface
	 */
	public function prune($language = null)
	{
		if ($language) {
			$this->addUsingAlias(LanguagePeer::ID, $language->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

	// extended_timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     LanguageQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(LanguagePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     LanguageQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(LanguagePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     LanguageQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(LanguagePeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     LanguageQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(LanguagePeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     LanguageQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(LanguagePeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     LanguageQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(LanguagePeer::CREATED_AT);
	}

} // BaseLanguageQuery
