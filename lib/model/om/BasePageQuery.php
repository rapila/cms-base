<?php


/**
 * Base class that represents a query for the 'pages' table.
 *
 * 
 *
 * @method     PageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     PageQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method     PageQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method     PageQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     PageQuery orderByPageType($order = Criteria::ASC) Order by the page_type column
 * @method     PageQuery orderByTemplateName($order = Criteria::ASC) Order by the template_name column
 * @method     PageQuery orderByIsInactive($order = Criteria::ASC) Order by the is_inactive column
 * @method     PageQuery orderByIsFolder($order = Criteria::ASC) Order by the is_folder column
 * @method     PageQuery orderByIsHidden($order = Criteria::ASC) Order by the is_hidden column
 * @method     PageQuery orderByIsProtected($order = Criteria::ASC) Order by the is_protected column
 * @method     PageQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     PageQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     PageQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     PageQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     PageQuery groupById() Group by the id column
 * @method     PageQuery groupByParentId() Group by the parent_id column
 * @method     PageQuery groupBySort() Group by the sort column
 * @method     PageQuery groupByName() Group by the name column
 * @method     PageQuery groupByPageType() Group by the page_type column
 * @method     PageQuery groupByTemplateName() Group by the template_name column
 * @method     PageQuery groupByIsInactive() Group by the is_inactive column
 * @method     PageQuery groupByIsFolder() Group by the is_folder column
 * @method     PageQuery groupByIsHidden() Group by the is_hidden column
 * @method     PageQuery groupByIsProtected() Group by the is_protected column
 * @method     PageQuery groupByCreatedAt() Group by the created_at column
 * @method     PageQuery groupByUpdatedAt() Group by the updated_at column
 * @method     PageQuery groupByCreatedBy() Group by the created_by column
 * @method     PageQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     PageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     PageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     PageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     PageQuery leftJoinPageRelatedByParentId($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageRelatedByParentId relation
 * @method     PageQuery rightJoinPageRelatedByParentId($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageRelatedByParentId relation
 * @method     PageQuery innerJoinPageRelatedByParentId($relationAlias = '') Adds a INNER JOIN clause to the query using the PageRelatedByParentId relation
 *
 * @method     PageQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     PageQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     PageQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     PageQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     PageQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     PageQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     PageQuery leftJoinPageRelatedById($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageRelatedById relation
 * @method     PageQuery rightJoinPageRelatedById($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageRelatedById relation
 * @method     PageQuery innerJoinPageRelatedById($relationAlias = '') Adds a INNER JOIN clause to the query using the PageRelatedById relation
 *
 * @method     PageQuery leftJoinPageProperty($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageProperty relation
 * @method     PageQuery rightJoinPageProperty($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageProperty relation
 * @method     PageQuery innerJoinPageProperty($relationAlias = '') Adds a INNER JOIN clause to the query using the PageProperty relation
 *
 * @method     PageQuery leftJoinPageString($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageString relation
 * @method     PageQuery rightJoinPageString($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageString relation
 * @method     PageQuery innerJoinPageString($relationAlias = '') Adds a INNER JOIN clause to the query using the PageString relation
 *
 * @method     PageQuery leftJoinContentObject($relationAlias = '') Adds a LEFT JOIN clause to the query using the ContentObject relation
 * @method     PageQuery rightJoinContentObject($relationAlias = '') Adds a RIGHT JOIN clause to the query using the ContentObject relation
 * @method     PageQuery innerJoinContentObject($relationAlias = '') Adds a INNER JOIN clause to the query using the ContentObject relation
 *
 * @method     PageQuery leftJoinRight($relationAlias = '') Adds a LEFT JOIN clause to the query using the Right relation
 * @method     PageQuery rightJoinRight($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Right relation
 * @method     PageQuery innerJoinRight($relationAlias = '') Adds a INNER JOIN clause to the query using the Right relation
 *
 * @method     Page findOne(PropelPDO $con = null) Return the first Page matching the query
 * @method     Page findOneById(int $id) Return the first Page filtered by the id column
 * @method     Page findOneByParentId(int $parent_id) Return the first Page filtered by the parent_id column
 * @method     Page findOneBySort(int $sort) Return the first Page filtered by the sort column
 * @method     Page findOneByName(string $name) Return the first Page filtered by the name column
 * @method     Page findOneByPageType(string $page_type) Return the first Page filtered by the page_type column
 * @method     Page findOneByTemplateName(string $template_name) Return the first Page filtered by the template_name column
 * @method     Page findOneByIsInactive(boolean $is_inactive) Return the first Page filtered by the is_inactive column
 * @method     Page findOneByIsFolder(boolean $is_folder) Return the first Page filtered by the is_folder column
 * @method     Page findOneByIsHidden(boolean $is_hidden) Return the first Page filtered by the is_hidden column
 * @method     Page findOneByIsProtected(boolean $is_protected) Return the first Page filtered by the is_protected column
 * @method     Page findOneByCreatedAt(string $created_at) Return the first Page filtered by the created_at column
 * @method     Page findOneByUpdatedAt(string $updated_at) Return the first Page filtered by the updated_at column
 * @method     Page findOneByCreatedBy(int $created_by) Return the first Page filtered by the created_by column
 * @method     Page findOneByUpdatedBy(int $updated_by) Return the first Page filtered by the updated_by column
 *
 * @method     array findById(int $id) Return Page objects filtered by the id column
 * @method     array findByParentId(int $parent_id) Return Page objects filtered by the parent_id column
 * @method     array findBySort(int $sort) Return Page objects filtered by the sort column
 * @method     array findByName(string $name) Return Page objects filtered by the name column
 * @method     array findByPageType(string $page_type) Return Page objects filtered by the page_type column
 * @method     array findByTemplateName(string $template_name) Return Page objects filtered by the template_name column
 * @method     array findByIsInactive(boolean $is_inactive) Return Page objects filtered by the is_inactive column
 * @method     array findByIsFolder(boolean $is_folder) Return Page objects filtered by the is_folder column
 * @method     array findByIsHidden(boolean $is_hidden) Return Page objects filtered by the is_hidden column
 * @method     array findByIsProtected(boolean $is_protected) Return Page objects filtered by the is_protected column
 * @method     array findByCreatedAt(string $created_at) Return Page objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return Page objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return Page objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return Page objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BasePageQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BasePageQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'mini_cms', $modelName = 'Page', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new PageQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    PageQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof PageQuery) {
			return $criteria;
		}
		$query = new PageQuery();
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
	 * @return    Page|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = PagePeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(PagePeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(PagePeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($id) && $comparison == Criteria::EQUAL) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(PagePeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the parent_id column
	 * 
	 * @param     int|array $parentId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByParentId($parentId = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($parentId)) {
			$useMinMax = false;
			if (isset($parentId['min'])) {
				$this->addUsingAlias(PagePeer::PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($parentId['max'])) {
				$this->addUsingAlias(PagePeer::PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PagePeer::PARENT_ID, $parentId, $comparison);
	}

	/**
	 * Filter the query on the sort column
	 * 
	 * @param     int|array $sort The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterBySort($sort = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($sort)) {
			$useMinMax = false;
			if (isset($sort['min'])) {
				$this->addUsingAlias(PagePeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($sort['max'])) {
				$this->addUsingAlias(PagePeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PagePeer::SORT, $sort, $comparison);
	}

	/**
	 * Filter the query on the name column
	 * 
	 * @param     string $name The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
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
		return $this->addUsingAlias(PagePeer::NAME, $name, $comparison);
	}

	/**
	 * Filter the query on the page_type column
	 * 
	 * @param     string $pageType The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPageType($pageType = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($pageType)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $pageType)) {
			$pageType = str_replace('*', '%', $pageType);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PagePeer::PAGE_TYPE, $pageType, $comparison);
	}

	/**
	 * Filter the query on the template_name column
	 * 
	 * @param     string $templateName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByTemplateName($templateName = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($templateName)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $templateName)) {
			$templateName = str_replace('*', '%', $templateName);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(PagePeer::TEMPLATE_NAME, $templateName, $comparison);
	}

	/**
	 * Filter the query on the is_inactive column
	 * 
	 * @param     boolean|string $isInactive The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByIsInactive($isInactive = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isInactive)) {
			$is_inactive = in_array(strtolower($isInactive), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(PagePeer::IS_INACTIVE, $isInactive, $comparison);
	}

	/**
	 * Filter the query on the is_folder column
	 * 
	 * @param     boolean|string $isFolder The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByIsFolder($isFolder = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isFolder)) {
			$is_folder = in_array(strtolower($isFolder), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(PagePeer::IS_FOLDER, $isFolder, $comparison);
	}

	/**
	 * Filter the query on the is_hidden column
	 * 
	 * @param     boolean|string $isHidden The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByIsHidden($isHidden = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isHidden)) {
			$is_hidden = in_array(strtolower($isHidden), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(PagePeer::IS_HIDDEN, $isHidden, $comparison);
	}

	/**
	 * Filter the query on the is_protected column
	 * 
	 * @param     boolean|string $isProtected The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByIsProtected($isProtected = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isProtected)) {
			$is_protected = in_array(strtolower($isProtected), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(PagePeer::IS_PROTECTED, $isProtected, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(PagePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(PagePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PagePeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(PagePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(PagePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PagePeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($createdBy)) {
			$useMinMax = false;
			if (isset($createdBy['min'])) {
				$this->addUsingAlias(PagePeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdBy['max'])) {
				$this->addUsingAlias(PagePeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PagePeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($updatedBy)) {
			$useMinMax = false;
			if (isset($updatedBy['min'])) {
				$this->addUsingAlias(PagePeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedBy['max'])) {
				$this->addUsingAlias(PagePeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(PagePeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPageRelatedByParentId($page, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::PARENT_ID, $page->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageRelatedByParentId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function joinPageRelatedByParentId($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageRelatedByParentId');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PageRelatedByParentId');
		}
		
		return $this;
	}

	/**
	 * Use the PageRelatedByParentId relation Page object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery A secondary query class using the current class as primary query
	 */
	public function usePageRelatedByParentIdQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPageRelatedByParentId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageRelatedByParentId', 'PageQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
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
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
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
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPageRelatedById($page, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::ID, $page->getParentId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageRelatedById relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function joinPageRelatedById($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageRelatedById');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PageRelatedById');
		}
		
		return $this;
	}

	/**
	 * Use the PageRelatedById relation Page object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery A secondary query class using the current class as primary query
	 */
	public function usePageRelatedByIdQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPageRelatedById($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageRelatedById', 'PageQuery');
	}

	/**
	 * Filter the query by a related PageProperty object
	 *
	 * @param     PageProperty $pageProperty  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPageProperty($pageProperty, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::ID, $pageProperty->getPageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageProperty relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function joinPageProperty($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageProperty');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'PageProperty');
		}
		
		return $this;
	}

	/**
	 * Use the PageProperty relation PageProperty object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PagePropertyQuery A secondary query class using the current class as primary query
	 */
	public function usePagePropertyQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPageProperty($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageProperty', 'PagePropertyQuery');
	}

	/**
	 * Filter the query by a related PageString object
	 *
	 * @param     PageString $pageString  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByPageString($pageString, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::ID, $pageString->getPageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageString relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function joinPageString($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageString');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	 * Filter the query by a related ContentObject object
	 *
	 * @param     ContentObject $contentObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByContentObject($contentObject, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::ID, $contentObject->getPageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ContentObject relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function joinContentObject($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ContentObject');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
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
	public function useContentObjectQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinContentObject($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ContentObject', 'ContentObjectQuery');
	}

	/**
	 * Filter the query by a related Right object
	 *
	 * @param     Right $right  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function filterByRight($right, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(PagePeer::ID, $right->getPageId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Right relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function joinRight($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Right');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Right');
		}
		
		return $this;
	}

	/**
	 * Use the Right relation Right object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    RightQuery A secondary query class using the current class as primary query
	 */
	public function useRightQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinRight($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Right', 'RightQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Page $page Object to remove from the list of results
	 *
	 * @return    PageQuery The current query, for fluid interface
	 */
	public function prune($page = null)
	{
		if ($page) {
			$this->addUsingAlias(PagePeer::ID, $page->getId(), Criteria::NOT_EQUAL);
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
	 * @return     PageQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(PagePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     PageQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(PagePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     PageQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(PagePeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     PageQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(PagePeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     PageQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(PagePeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     PageQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(PagePeer::CREATED_AT);
	}

} // BasePageQuery
