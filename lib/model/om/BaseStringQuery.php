<?php


/**
 * Base class that represents a query for the 'strings' table.
 *
 * 
 *
 * @method     StringQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     StringQuery orderByStringKey($order = Criteria::ASC) Order by the string_key column
 * @method     StringQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method     StringQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     StringQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     StringQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     StringQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     StringQuery groupByLanguageId() Group by the language_id column
 * @method     StringQuery groupByStringKey() Group by the string_key column
 * @method     StringQuery groupByText() Group by the text column
 * @method     StringQuery groupByCreatedAt() Group by the created_at column
 * @method     StringQuery groupByUpdatedAt() Group by the updated_at column
 * @method     StringQuery groupByCreatedBy() Group by the created_by column
 * @method     StringQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     StringQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     StringQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     StringQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     StringQuery leftJoinLanguage($relationAlias = '') Adds a LEFT JOIN clause to the query using the Language relation
 * @method     StringQuery rightJoinLanguage($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     StringQuery innerJoinLanguage($relationAlias = '') Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     StringQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     StringQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     StringQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     StringQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     StringQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     StringQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     String findOne(PropelPDO $con = null) Return the first String matching the query
 * @method     String findOneByLanguageId(string $language_id) Return the first String filtered by the language_id column
 * @method     String findOneByStringKey(string $string_key) Return the first String filtered by the string_key column
 * @method     String findOneByText(string $text) Return the first String filtered by the text column
 * @method     String findOneByCreatedAt(string $created_at) Return the first String filtered by the created_at column
 * @method     String findOneByUpdatedAt(string $updated_at) Return the first String filtered by the updated_at column
 * @method     String findOneByCreatedBy(int $created_by) Return the first String filtered by the created_by column
 * @method     String findOneByUpdatedBy(int $updated_by) Return the first String filtered by the updated_by column
 *
 * @method     array findByLanguageId(string $language_id) Return String objects filtered by the language_id column
 * @method     array findByStringKey(string $string_key) Return String objects filtered by the string_key column
 * @method     array findByText(string $text) Return String objects filtered by the text column
 * @method     array findByCreatedAt(string $created_at) Return String objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return String objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return String objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return String objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseStringQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseStringQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'String', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new StringQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    StringQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof StringQuery) {
			return $criteria;
		}
		$query = new StringQuery();
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
	 * @param     array[$language_id, $string_key] $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    String|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = StringPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		$this->addUsingAlias(StringPeer::LANGUAGE_ID, $key[0], Criteria::EQUAL);
		$this->addUsingAlias(StringPeer::STRING_KEY, $key[1], Criteria::EQUAL);
		
		return $this;
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		foreach ($keys as $key) {
			$cton0 = $this->getNewCriterion(StringPeer::LANGUAGE_ID, $key[0], Criteria::EQUAL);
			$cton1 = $this->getNewCriterion(StringPeer::STRING_KEY, $key[1], Criteria::EQUAL);
			$cton0->addAnd($cton1);
			$this->addOr($cton0);
		}
		
		return $this;
	}

	/**
	 * Filter the query on the language_id column
	 * 
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
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
		return $this->addUsingAlias(StringPeer::LANGUAGE_ID, $languageId, $comparison);
	}

	/**
	 * Filter the query on the string_key column
	 * 
	 * @param     string $stringKey The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByStringKey($stringKey = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($stringKey)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $stringKey)) {
			$stringKey = str_replace('*', '%', $stringKey);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(StringPeer::STRING_KEY, $stringKey, $comparison);
	}

	/**
	 * Filter the query on the text column
	 * 
	 * @param     string $text The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByText($text = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($text)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $text)) {
			$text = str_replace('*', '%', $text);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(StringPeer::TEXT, $text, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(StringPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(StringPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(StringPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(StringPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(StringPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(StringPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(StringPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(StringPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(StringPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(StringPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(StringPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(StringPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related Language object
	 *
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(StringPeer::LANGUAGE_ID, $language->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Language relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    StringQuery The current query, for fluid interface
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
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(StringPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    StringQuery The current query, for fluid interface
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
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(StringPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    StringQuery The current query, for fluid interface
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
	 * @param     String $string Object to remove from the list of results
	 *
	 * @return    StringQuery The current query, for fluid interface
	 */
	public function prune($string = null)
	{
		if ($string) {
			$this->addCond('pruneCond0', $this->getAliasedColName(StringPeer::LANGUAGE_ID), $string->getLanguageId(), Criteria::NOT_EQUAL);
			$this->addCond('pruneCond1', $this->getAliasedColName(StringPeer::STRING_KEY), $string->getStringKey(), Criteria::NOT_EQUAL);
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
	 * @return     StringQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(StringPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     StringQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(StringPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     StringQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(StringPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     StringQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(StringPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     StringQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(StringPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     StringQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(StringPeer::CREATED_AT);
	}

	// attributable behavior
	
} // BaseStringQuery
