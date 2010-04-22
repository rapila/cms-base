<?php


/**
 * Base class that represents a query for the 'page_strings' table.
 *
 * 
 *
 * @method     PageStringQuery orderByPageId($order = Criteria::ASC) Order by the page_id column
 * @method     PageStringQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     PageStringQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     PageStringQuery orderByLongTitle($order = Criteria::ASC) Order by the long_title column
 * @method     PageStringQuery orderByKeywords($order = Criteria::ASC) Order by the keywords column
 * @method     PageStringQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     PageStringQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     PageStringQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     PageStringQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     PageStringQuery groupByPageId() Group by the page_id column
 * @method     PageStringQuery groupByLanguageId() Group by the language_id column
 * @method     PageStringQuery groupByTitle() Group by the title column
 * @method     PageStringQuery groupByLongTitle() Group by the long_title column
 * @method     PageStringQuery groupByKeywords() Group by the keywords column
 * @method     PageStringQuery groupByCreatedAt() Group by the created_at column
 * @method     PageStringQuery groupByUpdatedAt() Group by the updated_at column
 * @method     PageStringQuery groupByCreatedBy() Group by the created_by column
 * @method     PageStringQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     PageStringQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     PageStringQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     PageStringQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     PageStringQuery leftJoinPage($relationAlias = '') Adds a LEFT JOIN clause to the query using the Page relation
 * @method     PageStringQuery rightJoinPage($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Page relation
 * @method     PageStringQuery innerJoinPage($relationAlias = '') Adds a INNER JOIN clause to the query using the Page relation
 *
 * @method     PageStringQuery leftJoinLanguage($relationAlias = '') Adds a LEFT JOIN clause to the query using the Language relation
 * @method     PageStringQuery rightJoinLanguage($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     PageStringQuery innerJoinLanguage($relationAlias = '') Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     PageStringQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     PageStringQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     PageStringQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     PageStringQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     PageStringQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     PageStringQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     PageString findOne(PropelPDO $con = null) Return the first PageString matching the query
 * @method     PageString findOneByPageId(int $page_id) Return the first PageString filtered by the page_id column
 * @method     PageString findOneByLanguageId(string $language_id) Return the first PageString filtered by the language_id column
 * @method     PageString findOneByTitle(string $title) Return the first PageString filtered by the title column
 * @method     PageString findOneByLongTitle(string $long_title) Return the first PageString filtered by the long_title column
 * @method     PageString findOneByKeywords(string $keywords) Return the first PageString filtered by the keywords column
 * @method     PageString findOneByCreatedAt(string $created_at) Return the first PageString filtered by the created_at column
 * @method     PageString findOneByUpdatedAt(string $updated_at) Return the first PageString filtered by the updated_at column
 * @method     PageString findOneByCreatedBy(int $created_by) Return the first PageString filtered by the created_by column
 * @method     PageString findOneByUpdatedBy(int $updated_by) Return the first PageString filtered by the updated_by column
 *
 * @method     array findByPageId(int $page_id) Return PageString objects filtered by the page_id column
 * @method     array findByLanguageId(string $language_id) Return PageString objects filtered by the language_id column
 * @method     array findByTitle(string $title) Return PageString objects filtered by the title column
 * @method     array findByLongTitle(string $long_title) Return PageString objects filtered by the long_title column
 * @method     array findByKeywords(string $keywords) Return PageString objects filtered by the keywords column
 * @method     array findByCreatedAt(string $created_at) Return PageString objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return PageString objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return PageString objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return PageString objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BasePageStringQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BasePageStringQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'PageString', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new PageStringQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    PageStringQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof PageStringQuery) {
			return $criteria;
		}
		$query = new PageStringQuery();
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
	 * @param     array[$page_id, $language_id] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PageString|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = PageStringPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		$this->addUsingAlias(PageStringPeer::PAGE_ID, $key[0], Criteria::EQUAL);
		$this->addUsingAlias(PageStringPeer::LANGUAGE_ID, $key[1], Criteria::EQUAL);
		
		return $this;
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		foreach ($keys as $key) {
			$cton0 = $this->getNewCriterion(PageStringPeer::PAGE_ID, $key[0], Criteria::EQUAL);
			$cton1 = $this->getNewCriterion(PageStringPeer::LANGUAGE_ID, $key[1], Criteria::EQUAL);
			$cton0->addAnd($cton1);
			$this->addOr($cton0);
		}
		
		return $this;
	}

	/**
	 * Filter the query on the page_id column
	 * 
	 * @param     int|array $pageId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByPageId($pageId = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($pageId) && $comparison == Criteria::EQUAL) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(PageStringPeer::PAGE_ID, $pageId, $comparison);
	}

	/**
	 * Filter the query on the language_id column
	 * 
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByLanguageId($languageId = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($languageId)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $languageId)) {
			$languageId = str_replace('*', '%', $languageId);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PageStringPeer::LANGUAGE_ID, $languageId, $comparison);
	}

	/**
	 * Filter the query on the title column
	 * 
	 * @param     string $title The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByTitle($title = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($title)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $title)) {
			$title = str_replace('*', '%', $title);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PageStringPeer::TITLE, $title, $comparison);
	}

	/**
	 * Filter the query on the long_title column
	 * 
	 * @param     string $longTitle The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByLongTitle($longTitle = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($longTitle)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $longTitle)) {
			$longTitle = str_replace('*', '%', $longTitle);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PageStringPeer::LONG_TITLE, $longTitle, $comparison);
	}

	/**
	 * Filter the query on the keywords column
	 * 
	 * @param     string $keywords The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByKeywords($keywords = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($keywords)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $keywords)) {
			$keywords = str_replace('*', '%', $keywords);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PageStringPeer::KEYWORDS, $keywords, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(PageStringPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(PageStringPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PageStringPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(PageStringPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(PageStringPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PageStringPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(PageStringPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(PageStringPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PageStringPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(PageStringPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(PageStringPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PageStringPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByPage($page, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PageStringPeer::PAGE_ID, $page->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Page relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageStringQuery The current query, for fluid interface
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
	 * Filter the query by a related Language object
	 *
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PageStringPeer::LANGUAGE_ID, $language->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Language relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function joinLanguage($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Language');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	public function useLanguageQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
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
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PageStringPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageStringQuery The current query, for fluid interface
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
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PageStringPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageStringQuery The current query, for fluid interface
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
	 * Exclude object from result
	 *
	 * @param     PageString $pageString Object to remove from the list of results
	 *
	 * @return    PageStringQuery The current query, for fluid interface
	 */
	public function prune($pageString = null)
	{
		if ($pageString) {
			$this->addCond('pruneCond0', $this->getAliasedColName(PageStringPeer::PAGE_ID), $pageString->getPageId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond1', $this->getAliasedColName(PageStringPeer::LANGUAGE_ID), $pageString->getLanguageId(), Criteria::NOT_EQUAL);
			$this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
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
	 * @return     PageStringQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(PageStringPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     PageStringQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(PageStringPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     PageStringQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(PageStringPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     PageStringQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(PageStringPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     PageStringQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(PageStringPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     PageStringQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(PageStringPeer::CREATED_AT);
	}

	// attributable behavior
	
} // BasePageStringQuery
