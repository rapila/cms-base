<?php


/**
 * Base class that represents a query for the 'tags' table.
 *
 * 
 *
 * @method     TagQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     TagQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     TagQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     TagQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     TagQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     TagQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     TagQuery groupById() Group by the id column
 * @method     TagQuery groupByName() Group by the name column
 * @method     TagQuery groupByCreatedAt() Group by the created_at column
 * @method     TagQuery groupByUpdatedAt() Group by the updated_at column
 * @method     TagQuery groupByCreatedBy() Group by the created_by column
 * @method     TagQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     TagQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     TagQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     TagQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     TagQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     TagQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     TagQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     TagQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     TagQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     TagQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     TagQuery leftJoinTagInstance($relationAlias = '') Adds a LEFT JOIN clause to the query using the TagInstance relation
 * @method     TagQuery rightJoinTagInstance($relationAlias = '') Adds a RIGHT JOIN clause to the query using the TagInstance relation
 * @method     TagQuery innerJoinTagInstance($relationAlias = '') Adds a INNER JOIN clause to the query using the TagInstance relation
 *
 * @method     Tag findOne(PropelPDO $con = null) Return the first Tag matching the query
 * @method     Tag findOneById(int $id) Return the first Tag filtered by the id column
 * @method     Tag findOneByName(string $name) Return the first Tag filtered by the name column
 * @method     Tag findOneByCreatedAt(string $created_at) Return the first Tag filtered by the created_at column
 * @method     Tag findOneByUpdatedAt(string $updated_at) Return the first Tag filtered by the updated_at column
 * @method     Tag findOneByCreatedBy(int $created_by) Return the first Tag filtered by the created_by column
 * @method     Tag findOneByUpdatedBy(int $updated_by) Return the first Tag filtered by the updated_by column
 *
 * @method     array findById(int $id) Return Tag objects filtered by the id column
 * @method     array findByName(string $name) Return Tag objects filtered by the name column
 * @method     array findByCreatedAt(string $created_at) Return Tag objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Tag objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return Tag objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return Tag objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseTagQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseTagQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'Tag', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new TagQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    TagQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof TagQuery) {
			return $criteria;
		}
		$query = new TagQuery();
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
	 * @return    Tag|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = TagPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			$stmt = $this
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $this->getFormatter()->formatOne($stmt);
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
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(TagPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(TagPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($id) && $comparison == Criteria::EQUAL) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(TagPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the name column
	 * 
	 * @param     string $name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByName($name = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($name)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $name)) {
			$name = str_replace('*', '%', $name);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TagPeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(TagPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(TagPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TagPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(TagPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(TagPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TagPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(TagPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(TagPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TagPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(TagPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(TagPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TagPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(TagPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(TagPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	 * Filter the query by a related TagInstance object
	 *
	 * @param     TagInstance $tagInstance  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function filterByTagInstance($tagInstance, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(TagPeer::ID, $tagInstance->getTagId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TagInstance relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function joinTagInstance($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TagInstance');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TagInstance');
		}
		
		return $this;
	}

	/**
	 * Use the TagInstance relation TagInstance object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TagInstanceQuery A secondary query class using the current class as primary query
	 */
	public function useTagInstanceQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinTagInstance($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TagInstance', 'TagInstanceQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Tag $tag Object to remove from the list of results
	 *
	 * @return    TagQuery The current query, for fluid interface
	 */
	public function prune($tag = null)
	{
		if ($tag) {
			$this->addUsingAlias(TagPeer::ID, $tag->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

	/**
	 * Code to execute before every SELECT statement
	 * 
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreSelect(PropelPDO $con)
	{
		return $this->preSelect($con);
	}

	/**
	 * Code to execute before every DELETE statement
	 * 
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreDelete(PropelPDO $con)
	{
		return $this->preDelete($con);
	}

	/**
	 * Code to execute before every UPDATE statement
	 * 
	 * @param     array $values The associatiove array of columns and values for the update
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreUpdate(&$values, PropelPDO $con)
	{
		return $this->preUpdate($values, $con);
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     TagQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(TagPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     TagQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(TagPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     TagQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(TagPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     TagQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(TagPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     TagQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(TagPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     TagQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(TagPeer::CREATED_AT);
	}

	// attributable behavior
	
} // BaseTagQuery
