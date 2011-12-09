<?php


/**
 * @package    propel.generator.model
 */
class PageQuery extends BasePageQuery {
	public function filterByParentAndName($sName, $mParent, $mCurrentToExclude = null) {
		if(!($mParent instanceof Page)) {
			$mParent = PagePeer::retrieveByPK($mParent);
		}
		$this->filterByName($sName)->childrenOf($mParent);
		if($mCurrentToExclude !== null) {
			if($mCurrentToExclude instanceof Page) {
				$mCurrentToExclude = $mCurrentToExclude->getId();
			}
			$this->add(PagePeer::ID, $mCurrentToExclude, Criteria::NOT_EQUAL);
		}
		return $this;
	}

	public function active($bIsActive = true) {
		return $this->filterByIsInactive(!$bIsActive);
	}
}

