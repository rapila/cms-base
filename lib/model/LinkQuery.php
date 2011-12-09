<?php


/**
 * @package    propel.generator.model
 */
class LinkQuery extends BaseLinkQuery {

	public function excludeExternallyManaged() {
		$this->addJoin(LinkPeer::LINK_CATEGORY_ID, LinkCategoryPeer::ID, Criteria::LEFT_JOIN);
		$oManagedFalse = $this->getNewCriterion(LinkCategoryPeer::IS_EXTERNALLY_MANAGED, false, Criteria::EQUAL);
		$oManagedNull = $this->getNewCriterion(LinkCategoryPeer::IS_EXTERNALLY_MANAGED, null, Criteria::ISNULL);
		$oManagedFalse->addOr($oManagedNull);
		$this->addAnd($oManagedFalse);
		return $this;
	}
	
	public function filterByDisplayLanguage($sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$oLangCriterion = $this->getNewCriterion(LinkPeer::LANGUAGE_ID, $sLanguageId);
		$oLangCriterion->addOr($this->getNewCriterion(LinkPeer::LANGUAGE_ID, null));
		$this->add($oLangCriterion);
		return $this;
	}


}

