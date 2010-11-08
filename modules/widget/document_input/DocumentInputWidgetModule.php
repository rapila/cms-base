<?php
class DocumentInputWidgetModule extends PersistentWidgetModule {
	
	public function getDocuments() {
		$aResult = array();
		// find files in media dirs - large files that cannot be uploaded with http
		$aCustomFiles = array();
		$aMediaDirs = ResourceFinder::findAllResources(array('web', 'media'));
		foreach($aMediaDirs as $sAbsolutePath) {
			self::readDirectory($sAbsolutePath, $aCustomFiles);
		}
		if(count($aCustomFiles) > 0) {
			$sCustomFiles = StringPeer::getString('widget.documents.custom_files');
			$aResult[$sCustomFiles] = $aCustomFiles;
		}
		// find files in database ordered by category
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
	
	private static function readDirectory($sDir, &$aResult) {
		$rDir = opendir($sDir);
		if($rDir) {
			while(($sFile = readdir($rDir)) !== false) {
				$sFilePath = $sDir.DIRECTORY_SEPARATOR.$sFile;
				if(StringUtil::startsWith($sFile, '.')) {
					continue;
				}
				if(is_dir($sFilePath)) {
					self::readDirectory($sFilePath, $aResult);
				} else {
					$oPath = new FileResource($sFilePath);
					$aResult[$oPath->getRelativePath()] = $oPath->getFrontendPath();
				}
			}
			closedir($rDir);
		}
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