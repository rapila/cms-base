<?php


/**
 * Skeleton subclass for performing query and update operations on the 'pages' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.model
 */
class PageQuery extends BasePageQuery {
	public function filterByParentAndName($sName, $mParent, $mCurrentToExclude = null) {
		if(!($mParent instanceof Page)) {
			$mParent = PagePeer::retrieveByPK($mParent);
		}
		$this->filterByName($sName)->childrenOf($mParent);
		if($oCurrentPageId !== null) {
			if($mCurrentToExclude instanceof Page) {
				$mCurrentToExclude = $mCurrentToExclude->getId();
			}
			$this->add(self::ID, $mCurrentToExclude, Criteria::NOT_EQUAL);
		}
		return $this;
	}
} // PageQuery
