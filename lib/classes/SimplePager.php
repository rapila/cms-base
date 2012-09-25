<?php
/**
 * This file is part of the Rapila package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

/**
 * SimplePager
 * • inspired by the PropelPager
 * • handling only query objects
 * 
 * Example Usage:
 * 
 * $oQuery = ExampleQuery::create()->whateverQuery();
 * 
 * $oPager = new SimplePager($oQuery, 1, 50); [query, page, max_rows per_page] 
 * 
 * $oPager->requiresPagination()
 * $oPager->setPageLinkBase(url_without_page)
 * 
 * $oPager->getPreviousLink()
 * $oPager->getNextLink()
 * 
 * foreach($oPager->getPreviousLinks() as $iPage) {
 * 		echo $oPager->getPageLink($iPage);
 * }
 * // returns PropelCollection
 * $oPager->getResult()[->getData()]
 * 
 * Iterate since PropelObjects extends ArrayObject
 * $oIterator = $oPager->getResult()->getIterator();
 * while ($oIterator->valid()) {
 *	 echo $oIterator->current();
 *	 $oIterator->next();
 * }
 * 
 * // Queries executed with defined select 
 * $oPager->getQuery()->select('fieldName1', 'fieldName2')->find() // etc
 * 
 * @author		Jürg Messmer <jm@mosaics.ch>
 * @version   0.8
 * 20120908.1121
 */
class SimplePager {

	// Query without count and limit
	private $oQuery;
	
	// Total of records
	private $iTotalRecordCount;
	
	// Total of expected pages
	private $iTotalPagesCount;
	
	// Current page
	private $iPage;
	
	// Propel collection
	private $aResult = null;

	// Iterator vars
	private $iCurrentKey = 0;

	/** @var        int Start row (offset) */
	protected $iStart = 0;

	/** @var        int Max rows per page to return (0 means all) */
	protected $iMaxRowsPerPage = 0;
	
	/** @var        string page link without page number */
	private $sPageLinkBase = null;

	/**
	 * Create a new Simple Pager.
	 * @param  Criteria $oQuery
	 * @param  int $iPage The current iPage (1-based).
	 * @param  int $iMaxRowsPerPage The number of rows that should be displayed per iPage.
	 */
	public function __construct($oQuery, $iPage = 1, $iMaxRowsPerPage = 25) {
		$this->oQuery = $oQuery;
		$this->iTotalRecordCount = $oQuery->count();
		$this->iTotalPageCount = (int) ceil($this->iTotalRecordCount / $iMaxRowsPerPage);
		$this->setPage($iPage);
		$this->setRowsPerPage($iMaxRowsPerPage);
	}
	
	/**
	 * @return  boolean
	 */
	public function requiresPagination() {
		if($this->iMaxRowsPerPage === 0) {
			return false;
		}
		return $this->iMaxRowsPerPage < $this->iTotalRecordCount;
	}
	
	/**
	 * Set the asic pager url without page number
	 *
	 * @param string base url
	 * description: the base url without the page id
	 * @return  void
	 */
	public function setPageLinkBase($sPageLinkBaseBase) {
		if(!StringUtil::endsWith('/', $sPageLinkBaseBase)) {
			$sPageLinkBaseBase = $sPageLinkBaseBase.'/';
		}
		$this->sPageLinkBase = $sPageLinkBaseBase;
	}

	/**
	 * Get the iPaged resultset
	 *
	 * @return PropelCollection
	 */
	public function getResult() {
		if (!isset($this->aResult)) {
			$this->find();
		}
		return $this->aResult;
	}
	
	/**
	 * @return query object
	 */	
	public function getQuery() {
		$this->oQuery->setOffset($this->iStart);
		return $this->oQuery->setLimit($this->iMaxRowsPerPage);
	}

	/**
	 * Get the iPaged resultset
	 *
	 * Main method which creates a iPaged result set based on the oQuery
	 *
	 */
	private function find() {
		$this->oQuery->setOffset($this->iStart);
		$this->oQuery->setLimit($this->iMaxRowsPerPage);
		$this->aResult = $this->getQuery()->find();
	}

	/**
	 * Get the first iPage
	 *
	 * For now I can only think of returning 1 always.
	 * It should probably return 0 if there are no iTotalPageCount
	 *
	 * @return  int 1
	 */
	public function getFirstPage() {
		return '1';
	}

	/**
	 * Convenience method to indicate whether current iPage is the first iPage.
	 *
	 * @return  boolean
	 */
	public function atFirstPage() {
		return $this->getPage() == $this->getFirstPage();
	}

	/**
	 * Get last iPage
	 *
	 * @return  int $lastPage
	 */
	public function getLastPage() {
		$iTotalPages = $this->getTotalPageCount();
		if ($iTotalPages == 0) {
			return 1;
		} else {
			return $iTotalPages;
		}
	}

	/**
	 * Convenience method to indicate whether current iPage is the last page.
	 *
	 * @return  boolean
	 */
	public function atLastPage() {
		return $this->getPage() == $this->getLastPage();
	}

	/**
	 * Get an array of previous id's
	 *
	 * @param  int $iRange
	 * @return  array $links
	 */
	public function getPreviousLinks($iRange = 5) {
		$iTotal = $this->getTotalPageCount();
		$iStart = $this->getPage() - 1;
		$iEnd = $this->getPage() - $iRange;
		$first =  $this->getFirstPage();
		$links = array();
		for ($i=$iStart; $i>$iEnd; $i--) {
			if ($i < $first) {
					break;
			}
			$links[] = $i;
		}

		return array_reverse($links);
	}

	/**
	 * Get an array of next id's
	 *
	 * @param  int $iRange
	 * @return  array $links
	 */
	public function getNextLinks($iRange = 5) {
		$iTotal = $this->getTotalPageCount();
		$iStart = $this->getPage() + 1;
		$iEnd = $this->getPage() + $iRange;
		$last =  $this->getLastPage();
		$links = array();
		for ($i=$iStart; $i<$iEnd; $i++) {
			if ($i > $last) {
					break;
			}
			$links[] = $i;
		}

		return $links;
	}

	/**
	 * Returns whether last page is complete
	 *
	 * @return bool Last page complete or not
	 */
	public function isLastPageComplete() {
		return !($this->getTotalRecordCount() % $this->iMaxRowsPerPage);
	}

	/**
	 * Get previous id
	 *
	 * @return mixed $prev
	 */
	public function getPrevious() {
		if ($this->getPage() != $this->getFirstPage()) {
				$prev = $this->getPage() - 1;
		} else {
				$prev = false;
		}
		return $prev;
	}

	/**
	 * Get next id
	 *
	 * @return mixed $next
	 */
	public function getNext() {
		if ($this->getPage() != $this->getLastPage()) {
				$next = $this->getPage() + 1;
		} else {
				$next = false;
		}
		return $next;
	}
	
	/**
	 * @param int $iPage
	 *
	 * @return string
	 */	
	public function getPageLink($iPage) {
		return $this->sPageLinkBase.$iPage;
	}
	
	/**
	 * get relative or absolute page link
	 *
	 * @return  mixed string/null
	 */	
	public function getPreviousLink() {
		if($this->sPageLinkBase === null) {
			throw new Exception("Error in __METHOD__: use of method requires sPageLinkBase");
		}
		if($iPage = $this->getPrevious()) {
			return $this->getPageLink($iPage);
		}
		return false;
	}

	/**
	 * get relative or absolute page link
	 *
	 * @return  mixed string/null
	 */	
	public function getNextLink() {
		if($this->sPageLinkBase === null) {
			throw new Exception("Error in __METHOD__: use of method requires sPageLinkBase");
		}
		if($iPage = $this->getNext()) {
			return $this->getPageLink($iPage);
		}
		return false;
	}
	
	/**
	 * Set the current iPage number (First iPage is 1).
	 * @param  int $iPage
	 * @return  void
	 */
	public function setPage($iPage) {
		$this->iPage = $iPage;
		// (re-)calculate iStart rec
		$this->calculateStart();
	}

	/**
	 * Get current iPage.
	 * @return  int
	 */
	public function getPage() {
		return $this->iPage;
	}
	
	/**
	 * Set the number of rows per iPage.
	 * @param  int $iMaxRowsPerPage
	 */
	public function setRowsPerPage($iMaxRowsPerPage) {
		$this->iMaxRowsPerPage = (int) $iMaxRowsPerPage;
		// (re-)calculate iStart rec
		$this->calculateStart();
	}

	/**
	 * Get number of rows per iPage.
	 * @return  int
	 */
	public function getRowsPerPage() {
		return $this->iMaxRowsPerPage;
	}

	/**
	 * Calculate start row / max rows based on current iPage and iMaxRowsPerPage.
	 * @return  void
	 */
	private function calculateStart() { 	
		$this->iStart = ( ($this->iPage - 1) * $this->iMaxRowsPerPage );
	}

	/**
	 * Gets the total number of (un-LIMITed) records.
	 * @return int Total number of records - disregarding iPage, iMaxRowsPerPage, etc.
	 */
	public function getTotalRecordCount() {
		return $this->iTotalRecordCount;
	}

	/**
	 * Sets the start row or offset.
	 * @param int 
	 */
	public function setStart($iValue) {
		$this->iStart = $iValue;
	}

	/**
	 * get total iTotalPageCount
	 *
	 * @return int Total page count
	 */
	public function getTotalPageCount() {
		if (!isset($this->iTotalPageCount)) {
			if ($this->iMaxRowsPerPage > 0) {
					$this->iTotalPageCount = (int) ceil($this->getTotalRecordCount()/$this->iMaxRowsPerPage);
			} else {
					$this->iTotalPageCount = 0;
			}
		}
		return $this->iTotalPageCount;
	}
	
	/**
	 * Sets max rows (limit).
	 * @param  int $iValue
	 * @return  void
	 */
	public function setMaxRowPerPage($iValue) {
		$this->iMaxRowsPerPage = $iValue;
	}

	/**
	 * Returns the count of the current page's records
	 * @return 	int
	 */
	public function count() {
		return count($this->getResult());
	}
}
