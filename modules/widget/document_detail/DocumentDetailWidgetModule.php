<?php
/**
 * @package modules.widget
 */
class DocumentDetailWidgetModule extends PersistentWidgetModule {
	private $iDocumentId = null;
	private static $LICENSES = array();

	public function __construct($sSessionKey = null) {
		parent::__construct($sSessionKey);
		$oPopover = WidgetModule::getWidget('popover', null, $this);
		$this->setSetting('popover', $oPopover->getSessionKey());
	}

	public function popoverContents($oPopover) {
		$aResult = array();
		foreach(DocumentPeer::$LICENSES as $sLicenseKey => $aLicenseInfo) {
			if($sLicenseKey === 'NULL') {
				$aResult[] = new TagWriter('div', array(), '©');
				continue;
			}
			$aResult[] = new TagWriter('img', array('src' => $aLicenseInfo['image'], 'data-license' => $sLicenseKey));
		}
		return $aResult;
	}
	
	public function setDocumentId($iDocumentId) {
		$this->iDocumentId = $iDocumentId;
	}
	
	public function documentData() {
		$aResult = array();
		$oDocument = DocumentQuery::create()->findPk($this->iDocumentId);
		$aResult = $oDocument->toArray(BasePeer::TYPE_PHPNAME, false);
		$sDimensions = '';
		if($sValue = $oDocument->getDimensionsIfImage()) {
			$sDimensions = ' ('.$sValue.')';
		}
		$aResult['FileInfo'] = $oDocument->getExtension().'/'.DocumentPeer::getDocumentSize($oDocument->getDataSize(), 'auto_iso').$sDimensions;
		$aResult['CreatedInfo'] = Util::formatCreatedInfo($oDocument);
		$aResult['UpdatedInfo'] = Util::formatUpdatedInfo($oDocument);
		$aResult['ContentCreatedAt'] = $oDocument->getContentCreatedAt('d.m.Y');
    // self::addReferences($oDocument, $aResult);
		return $aResult;
	}
	
	private static function addReferences($oDocument, &$aResult) {
		if($oDocument->isInternallyManaged()) {
			$aResult['References'] = array();
		  foreach(ReferencePeer::getReferences($oDocument) as $oReference) {
        $aResult['References'][] = $oReference->toArray();
			}
		}
	}
	
	public static function documentPreview($iDocumentId, $iSize) {
		$oDocument = DocumentQuery::create()->findPk($iDocumentId);
		if($oDocument) {
			return DocumentQuery::create()->findPk($iDocumentId)->getPreview($iSize);
		}
		return null;
	}
	
	public function preview() {
		return self::documentPreview($this->iDocumentId, 190);
	}
	
	public function validate($aDocumentData, $oDocument) {
		$oFlash = Flash::getFlash();
		$oFlash->setArrayToCheck($aDocumentData);
		if($this->iDocumentId === null) {
			$oFlash->addMessage('document.requires_file');
		}
		$oFlash->finishReporting();
	}

	public function saveData($aDocumentData) {
		if($this->iDocumentId === null) {
			$oDocument = new Document();
		} else {
			$oDocument = DocumentQuery::create()->findPk($this->iDocumentId);
		}
		if($aDocumentData['name'] == null && $oDocument->getName()) {
			$aDocumentData['name'] = $oDocument->getName();
		}
		$oDocument->fromArray($aDocumentData, BasePeer::TYPE_FIELDNAME);
		$this->validate($aDocumentData, $oDocument);
		if(!Flash::noErrors()) {
			throw new ValidationException();
		}
		$oDocument->setDescription($aDocumentData['description'] == '' ? null : $aDocumentData['description']);
		$oDocument->setAuthor($aDocumentData['author'] == '' ? null : $aDocumentData['author']);
		$oDocument->setLicense($aDocumentData['license'] == '' ? null : $aDocumentData['license']);
		$oDocument->setContentCreatedAt($aDocumentData['content_created_at'] == '' ? null : $aDocumentData['content_created_at']);
		// Set/reset sort order
		if($oDocument->getDocumentCategoryId() != null) {
			if($oDocument->isNew() || $oDocument->isColumnModified(DocumentPeer::DOCUMENT_CATEGORY_ID)) {
				$oDocument->setSort(DocumentQuery::create()->filterByDocumentCategoryId($oDocument->getDocumentCategoryId())->count() + 1);
			}
		}
		$oDocument->save();
		return $oDocument->getId();
	}
	
	public function deleteDocument() {
		if($this->iDocumentId === null) {
			return false;
		}
		$oDocument = DocumentQuery::create()->findPk($this->iDocumentId);
		$oDocument->delete();
		return true;
	}
}
