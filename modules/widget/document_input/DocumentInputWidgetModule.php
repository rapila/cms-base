<?php
class DocumentInputWidgetModule extends PersistentWidgetModule {
	
	public function allDocumentsByCategories() {
		$aResult = array();
		// find files in media dirs - large files that cannot be uploaded with http
		$aCustomFiles = array();
		$aMediaDirs = ResourceFinder::findResourceObjectsByExpressions(array('web', '/^(media|flash)$/', array()));
		foreach($aMediaDirs as $oFileResource) {
			if($oFileResource->isFile()) {
				$aCustomFiles[$oFileResource->getRelativePath()] = $oFileResource->getInstancePrefix().$oFileResource->getRelativePath();
			}
		}
		if(count($aCustomFiles) > 0) {
			$sCustomFiles = StringPeer::getString('wns.documents.custom_files');
			$aResult[$sCustomFiles] = array_flip($aCustomFiles);
		}
		// find files in database ordered by category
		$aCategories = DocumentCategoryPeer::getDocumentCategoriesSorted();
		foreach($aCategories as $oCategory) {
			$aDocuments = DocumentPeer::getDocumentsByCategory($oCategory->getId());
			foreach($aDocuments as $oDocument) {
				$aResult[$oCategory->getName()][$oDocument->getId()] = $oDocument->getName();
			}
		}
		$sWithoutCategory = StringPeer::getString('wns.documents.select_without_title');
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
