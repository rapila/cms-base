<?php


/**
 * @package    propel.generator.model
 */
class PageQuery extends BasePageQuery {
	
	public function filterByParentAndName($sName, $mParent, $mCurrentToExclude = null) {
		if(!($mParent instanceof Page)) {
			$mParent = PageQuery::create()->findPk($mParent);
		}
		$this->filterByName($sName)->childrenOf($mParent);
		if($mCurrentToExclude !== null) {
			if($mCurrentToExclude instanceof Page) {
				$mCurrentToExclude = $mCurrentToExclude->getId();
			}
			$this->filterById($mCurrentToExclude, Criteria::NOT_EQUAL);
		}
		return $this;
	}
	
	public function descendantsOf($oPage) {
		// Default implementation of childrenOf assumes $oPage is non-null.
		if($oPage !== null) {
			return parent::descendantsOf($oPage);
		}
		return $this;
	}

	public function childrenOf($oPage) {
		// Default implementation of childrenOf assumes $oPage is non-null.
		if($oPage === null) {
			return $this->addUsingAlias(PagePeer::LEVEL_COL, 0, Criteria::EQUAL);
		}
		return parent::childrenOf($oPage);
	}
	
	public function active($bIsActive = true) {
		return $this->filterByIsInactive(!$bIsActive);
	}
}

