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
 * this iPager has been inspired by the PropelPager
 * • all Peer usage removed
 * Example Usage:
 * 
 * $oQuery = ExampleQuery::create()->whateverQuery();
 * $oPager = new SimplePager($oQuery, 1, 50);
 *	
 * Some template:
 * 
 * @author		Jürg Messmer <jm@mosaics.ch>
 * @version   0.9
 */
class SimplePager implements Countable, Iterator {

	// Criteria without count and limit
	private $oQuery;
	
	// total of records
	private $iRecordCount;
	
	// total of expected pages
	private $iPagesCount;
	
	// current page
	private $iPage;
	
	// propel collection
	private $aResult = null;

	//Iterator vars
	private $iCurrentKey = 0;

	/** @var        int Start row (offset) */
	protected $iStart = 0;

	/** @var        int Max rows per page to return (0 means all) */
	protected $iMaxRowsPerPage = 0;
	
	/** @var        string page link without page number */
	private $sPageLinkBase = null;

	/**
	 * Create a new Simple Pager.
	 * @param      Criteria $oQuery
	 * @param      int $iPage The current iPage (1-based).
	 * @param      int $iRowsPerPage The number of rows that should be displayed per iPage.
	 */
	public function __construct($oQuery, $iPage = 1, $iRowsPerPage = 25) {
		$this->oQuery = $oQuery;
		$this->iRecordCount = $oQuery->count();
		$this->iPagesCount = (int) ceil($this->iRecordCount / $iRowsPerPage);
		$this->setPage($iPage);
		$this->setRowsPerPage($iRowsPerPage);
	}
	
	/**
	 * @return  boolean
	 */
	public function requiresPagination() {
		if($this->iMaxRowsPerPage === 0) {
			return false;
		}
		return $this->iMaxRowsPerPage < $this->iRecordCount;
	}
	
	/**
	 * basic pager url without page number
	 * @return     void
	 */
	public function setPageLinkBase($sPageLinkBaseBase) {
		$this->sPageLinkBase = $sPageLinkBaseBase;
	}

	/**
	 * Get the iPaged resultset
	 *
	 * @return     mixed $aResult PropelCollection/array
	 */
	public function getResult($bReturnArray = false) {
		if (!isset($this->aResult)) {
			$this->find();
		}

		return $this->aResult;
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
	 * @return query object
	 */	
	public function getQuery() {
		$this->oQuery->setOffset($this->iStart);
		return $this->oQuery->setLimit($this->iMaxRowsPerPage);
	}

	/**
	 * Get the first iPage
	 *
	 * For now I can only think of returning 1 always.
	 * It should probably return 0 if there are no iPagesCount
	 *
	 * @return     int 1
	 */
	public function getFirstPage() {
		return '1';
	}

	/**
	 * Convenience method to indicate whether current iPage is the first iPage.
	 *
	 * @return     boolean
	 */
	public function atFirstPage() {
		return $this->getPage() == $this->getFirstPage();
	}

	/**
	 * Get last iPage
	 *
	 * @return     int $lastPage
	 */
	public function getLastPage() {
		$iTotalPages = $this->getTotalPages();
		if ($iTotalPages == 0) {
			return 1;
		} else {
			return $iTotalPages;
		}
	}

	/**
	 * Convenience method to indicate whether current iPage is the last iPage.
	 *
	 * @return     boolean
	 */
	public function atLastPage() {
		return $this->getPage() == $this->getLastPage();
	}

	/**
	 * get total iPagesCount
	 *
	 * @return     int $this->iPagesCount
	 */
	public function getTotalPages() {
		if (!isset($this->iPagesCount)) {
			if ($this->iMaxRowsPerPage > 0) {
					$this->iPagesCount = (int) ceil($this->getTotalRecordCount()/$this->iMaxRowsPerPage);
			} else {
					$this->iPagesCount = 0;
			}
		}
		return $this->iPagesCount;
	}

	/**
	 * get an array of previous id's
	 *
	 * @param      int $iRange
	 * @return     array $links
	 */
	public function getPreviousLinks($iRange = 5) {
		$iTotal = $this->getTotalPages();
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
	 * get an array of next id's
	 *
	 * @param      int $iRange
	 * @return     array $links
	 */
	public function getNextLinks($iRange = 5) {
		$iTotal = $this->getTotalPages();
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
	 * Returns whether last iPage is complete
	 *
	 * @return     bool Last iPage complete or not
	 */
	public function isLastPageComplete() {
		return !($this->getTotalRecordCount() % $this->iMaxRowsPerPage);
	}

	/**
	 * get previous id
	 *
	 * @return     mixed $prev
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
	 * get next id
	 *
	 * @return     mixed $next
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
	 * get relative or absolute page link
	 *
	 * @return     mixed string/null
	 */	
	public function getPreviousLink() {
		if($this->sPageLinkBase === null) {
			throw new Exception("Error in __METHOD__: use of method requires sPageLinkBase");
		}
		if($iPage = $this->getPrevious()) {
			return $this->sPageLinkBase.$iPage;
		}
		return false;
	}

	/**
	 * get relative or absolute page link
	 *
	 * @return     mixed string/null
	 */	
	public function getNextLink() {
		if($this->sPageLinkBase === null) {
			throw new Exception("Error in __METHOD__: use of method requires sPageLinkBase");
		}
		if($iPage = $this->getNext()) {
			return $this->sPageLinkBase.$iPage;
		}
		return false;
	}
	
	/**
	 * Set the current iPage number (First iPage is 1).
	 * @param      int $iPage
	 * @return     void
	 */
	public function setPage($iPage) {
		$this->iPage = $iPage;
		// (re-)calculate iStart rec
		$this->calculateStart();
	}

	/**
	 * Get current iPage.
	 * @return     int
	 */
	public function getPage() {
		return $this->iPage;
	}
	
	/**
	 * Set the number of rows per iPage.
	 * @param      int $iRowsPerPage
	 */
	public function setRowsPerPage($iRowsPerPage) {
		$this->iMaxRowsPerPage = (int) $iRowsPerPage;
		// (re-)calculate iStart rec
		$this->calculateStart();
	}

	/**
	 * Get number of rows per iPage.
	 * @return     int
	 */
	public function getRowsPerPage() {
		return $this->iMaxRowsPerPage;
	}

	/**
	 * Calculate iStartrow / max rows based on current iPage and rows-per-iPage.
	 * @return     void
	 */
	private function calculateStart() { 	
		$this->iStart = ( ($this->iPage - 1) * $this->iMaxRowsPerPage );
	}

	/**
	 * Gets the total number of (un-LIMITed) records.
	 * @return     int Total number of records - disregarding iPage, maxrows, etc.
	 */
	public function getTotalRecordCount() {
		return $this->iRecordCount;
	}

	/**
	 * Sets the iStart row or offset.
	 * @param      int $iValue
	 */
	public function setStart($iValue) {
		$this->iStart = $iValue;
	}

	/**
	 * Sets max rows (limit).
	 * @param      int $iValue
	 * @return     void
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
	
	/**
	 * Returns the current element of the iterator
	 * @return mixed
	 */
	public function current() {
		if (!isset($this->aResult)) {
			$this->find();
		}
		return $this->aResult[$this->iCurrentKey];
	}

	/**
	 * Returns the current key of the iterator
	 * @return int
	 */
	public function key() {
		return $this->iCurrentKey;
	}

	/**
	 * Advances the iterator to the next element
	 * @return void
	 */
	public function next() {
		$this->iCurrentKey++;
	}

	/**
	 * Resets the iterator to the first element
	 * @return void
	 */
	public function rewind() {
		$this->iCurrentKey = 0;
	}

	/**
	 * Checks if the current key exists in the container
	 * @return boolean
	 */
	public function valid() {
		if (!isset($this->aResult)) {
			$this->find();
		}
		return in_array($this->iCurrentKey, array_keys($this->aResult));
	}

}
