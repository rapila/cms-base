<?php


/**
 * Base class that represents a query for the 'objects' table.
 *
 * 
 *
 * @method     ContentObjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ContentObjectQuery orderByPageId($order = Criteria::ASC) Order by the page_id column
 * @method     ContentObjectQuery orderByContainerName($order = Criteria::ASC) Order by the container_name column
 * @method     ContentObjectQuery orderByObjectType($order = Criteria::ASC) Order by the object_type column
 * @method     ContentObjectQuery orderByConditionSerialized($order = Criteria::ASC) Order by the condition_serialized column
 * @method     ContentObjectQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method     ContentObjectQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ContentObjectQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ContentObjectQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ContentObjectQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     ContentObjectQuery groupById() Group by the id column
 * @method     ContentObjectQuery groupByPageId() Group by the page_id column
 * @method     ContentObjectQuery groupByContainerName() Group by the container_name column
 * @method     ContentObjectQuery groupByObjectType() Group by the object_type column
 * @method     ContentObjectQuery groupByConditionSerialized() Group by the condition_serialized column
 * @method     ContentObjectQuery groupBySort() Group by the sort column
 * @method     ContentObjectQuery groupByCreatedAt() Group by the created_at column
 * @method     ContentObjectQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ContentObjectQuery groupByCreatedBy() Group by the created_by column
 * @method     ContentObjectQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     ContentObjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ContentObjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ContentObjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ContentObjectQuery leftJoinPage($relationAlias = '') Adds a LEFT JOIN clause to the query using the Page relation
 * @method     ContentObjectQuery rightJoinPage($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Page relation
 * @method     ContentObjectQuery innerJoinPage($relationAlias = '') Adds a INNER JOIN clause to the query using the Page relation
 *
 * @method     ContentObjectQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ContentObjectQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     ContentObjectQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     ContentObjectQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ContentObjectQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     ContentObjectQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     ContentObjectQuery leftJoinLanguageObject($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObject relation
 * @method     ContentObjectQuery rightJoinLanguageObject($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObject relation
 * @method     ContentObjectQuery innerJoinLanguageObject($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObject relation
 *
 * @method     ContentObjectQuery leftJoinLanguageObjectHistory($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObjectHistory relation
 * @method     ContentObjectQuery rightJoinLanguageObjectHistory($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObjectHistory relation
 * @method     ContentObjectQuery innerJoinLanguageObjectHistory($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObjectHistory relation
 *
 * @method     ContentObject findOne(PropelPDO $con = null) Return the first ContentObject matching the query
 * @method     ContentObject findOneById(int $id) Return the first ContentObject filtered by the id column
 * @method     ContentObject findOneByPageId(int $page_id) Return the first ContentObject filtered by the page_id column
 * @method     ContentObject findOneByContainerName(string $container_name) Return the first ContentObject filtered by the container_name column
 * @method     ContentObject findOneByObjectType(string $object_type) Return the first ContentObject filtered by the object_type column
 * @method     ContentObject findOneByConditionSerialized(resource $condition_serialized) Return the first ContentObject filtered by the condition_serialized column
 * @method     ContentObject findOneBySort(int $sort) Return the first ContentObject filtered by the sort column
 * @method     ContentObject findOneByCreatedAt(string $created_at) Return the first ContentObject filtered by the created_at column
 * @method     ContentObject findOneByUpdatedAt(string $updated_at) Return the first ContentObject filtered by the updated_at column
 * @method     ContentObject findOneByCreatedBy(int $created_by) Return the first ContentObject filtered by the created_by column
 * @method     ContentObject findOneByUpdatedBy(int $updated_by) Return the first ContentObject filtered by the updated_by column
 *
 * @method     array findById(int $id) Return ContentObject objects filtered by the id column
 * @method     array findByPageId(int $page_id) Return ContentObject objects filtered by the page_id column
 * @method     array findByContainerName(string $container_name) Return ContentObject objects filtered by the container_name column
 * @method     array findByObjectType(string $object_type) Return ContentObject objects filtered by the object_type column
 * @method     array findByConditionSerialized(resource $condition_serialized) Return ContentObject objects filtered by the condition_serialized column
 * @method     array findBySort(int $sort) Return ContentObject objects filtered by the sort column
 * @method     array findByCreatedAt(string $created_at) Return ContentObject objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ContentObject objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return ContentObject objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return ContentObject objects filtered by the updated_by column
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
	public function __construct($dbName = 'mini_cms', $modelName = 'ContentObject', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new ContentObjectQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    ContentObjectQuery
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
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    ContentObject|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = ContentObjectPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    ContentObjectQuery The current query, for fluid interface
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
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(ContentObjectPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($id) && $comparison == Criteria::EQUAL) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(ContentObjectPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the page_id column
	 * 
	 * @param     int|array $pageId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByPageId($pageId = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::PAGE_ID, $pageId, $comparison);
	}

	/**
	 * Filter the query on the container_name column
	 * 
	 * @param     string $containerName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByContainerName($containerName = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($containerName)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $containerName)) {
			$containerName = str_replace('*', '%', $containerName);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::CONTAINER_NAME, $containerName, $comparison);
	}

	/**
	 * Filter the query on the object_type column
	 * 
	 * @param     string $objectType The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByObjectType($objectType = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($objectType)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $objectType)) {
			$objectType = str_replace('*', '%', $objectType);
			if ($comparison == Criteria::EQUAL) {
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
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByConditionSerialized($conditionSerialized = null, $comparison = Criteria::EQUAL)
	{
		return $this->addUsingAlias(ContentObjectPeer::CONDITION_SERIALIZED, $conditionSerialized, $comparison);
	}

	/**
	 * Filter the query on the sort column
	 * 
	 * @param     int|array $sort The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterBySort($sort = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::SORT, $sort, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(ContentObjectPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByPage($page, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(ContentObjectPeer::PAGE_ID, $page->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Page relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function joinPage($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Page');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PageQuery A secondary query class using the current class as primary query
	 */
	public function usePageQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPage($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Page', 'PageQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(ContentObjectPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
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
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(ContentObjectPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
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
	 * Filter the query by a related LanguageObject object
	 *
	 * @param     LanguageObject $languageObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByLanguageObject($languageObject, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(ContentObjectPeer::ID, $languageObject->getObjectId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObject relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function joinLanguageObject($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageObject');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function filterByLanguageObjectHistory($languageObjectHistory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(ContentObjectPeer::ID, $languageObjectHistory->getObjectId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObjectHistory relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function joinLanguageObjectHistory($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageObjectHistory');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	 * Exclude object from result
	 *
	 * @param     ContentObject $contentObject Object to remove from the list of results
	 *
	 * @return    ContentObjectQuery The current query, for fluid interface
	 */
	public function prune($contentObject = null)
	{
		if ($contentObject) {
			$this->addUsingAlias(ContentObjectPeer::ID, $contentObject->getId(), Criteria::NOT_EQUAL);
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

	// extended_timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     ContentObjectQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(ContentObjectPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     ContentObjectQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(ContentObjectPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     ContentObjectQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(ContentObjectPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     ContentObjectQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(ContentObjectPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     ContentObjectQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(ContentObjectPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     ContentObjectQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(ContentObjectPeer::CREATED_AT);
	}

} // BaseContentObjectQuery
