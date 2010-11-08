<?php
class DocumentInputWidgetModule extends PersistentWidgetModule {
	
	public function getDocuments() {
		$aResult = array();
		$aCategories = DocumentCategoryPeer::getDocumentCategoriesSorted();
		foreach($aCategories as $oCategory) {
			$aDocuments = DocumentPeer::getDocumentsByCategory($oCategory->getId());
			foreach($aDocuments as $oDocument) {
				$aResult[$oCategory->getName()][$oDocument->getId()] = $oDocument->getName();
			}
		}
		$sWithoutCategory = StringPeer::getString('widget.documents.select_without_title');
		foreach(self::getDocumentWithoutCategoryId() as $oDocument) {
			$aResult[$sWithoutCategory][$oDocument->getId()] = $oDocument->getName();
		}
		return $aResult;
	}

	private static function getDocumentWithoutCategoryId() {
		$oCriteria = new Criteria();
		$oCriteria->add(DocumentPeer::DOCUMENT_CATEGORY_ID, null, Criteria::ISNULL);
		$oCriteria->addAscendingOrderByColumn(DocumentPeer::NAME);
		return DocumentPeer::doSelect($oCriteria);
	}
	
	public function getElementType() {
		return 'select';
	}
}