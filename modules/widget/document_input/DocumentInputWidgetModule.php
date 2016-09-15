<?php
class DocumentInputWidgetModule extends PersistentWidgetModule {

	public function allDocumentsByCategories() {
		$aResult = array();
		// find files in media dirs - large files that cannot be uploaded with http
		$aCustomFiles = array();
		$aMediaDirs = ResourceFinder::create()->addExpression('web', '/^(media|flash)$/')->addRecursion()->noCache()->returnObjects()->find();
		foreach($aMediaDirs as $oFileResource) {
			if($oFileResource->isFile()) {
				$aCustomFiles[$oFileResource->getRelativePath()] = $oFileResource->getInstancePrefix().$oFileResource->getRelativePath();
			}
		}
		if(count($aCustomFiles) > 0) {
			$sCustomFiles = TranslationPeer::getString('wns.documents.custom_files');
			$aResult[$sCustomFiles] = array_flip($aCustomFiles);
		}
		// find files in database ordered by category
		foreach(DocumentCategoryQuery::create()->filterByIsExternallyManaged(false)->orderByName()->find() as $oCategory) {
			$aDocuments = DocumentQuery::create()->useDocumentCategoryQuery()->filterByIsExternallyManaged(false)->endUse()->orderByDocumentCategoryId()->orderByName()->select(array('Id', 'Name'))->find();
			foreach($aDocuments as $aDocument) {
				$aResult[$oCategory->getName()][$aDocument['Id']] = $aDocument['Name'];
			}
		}
		$sWithoutCategory = TranslationPeer::getString('wns.documents.select_without_title');
		foreach(self::getDocumentsWithoutCategoryId() as $iId => $sName) {
			$aResult[$sWithoutCategory][$iId] = $sName;
		}
		return $aResult;
	}

	private static function getDocumentsWithoutCategoryId() {
		return DocumentQuery::create()->filterByDocumentCategoryId(null, Criteria::ISNULL)->orderByName()->find()->toKeyValue('Id', 'Name');
	}

	public function getElementType() {
		return 'select';
	}
}
