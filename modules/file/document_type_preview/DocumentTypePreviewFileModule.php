<?php
/**
 * @package modules.file
 */
class DocumentTypePreviewFileModule extends FileModule {
	
	const MIME_TYPE = 'image/png';
		
	protected $oDocumentType;
	protected $iSize;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		if(!isset($this->aPath[0])) {
			throw new Exception("Error in DocumentTypePreviewFileModule->__construct: no type given");
		}
		$this->oDocumentType = DocumentTypeQuery::create()->findPk($this->aPath[0]);
		if($this->oDocumentType === null) {
			throw new Exception("Error in DocumentTypePreviewFileModule->__construct: type invalid: {$this->aPath[0]}");
		}
		$this->iSize = 512;
		if(isset($_REQUEST['size'])) {
			$this->iSize = min($this->iSize, (int)$_REQUEST['size']);
		}
	}
	
	public function renderFile() {
		$sCacheString = 'preview_'.$this->oDocumentType->getId().'_'.$this->iSize;
		$oCache = new Cache($sCacheString, DIRNAME_IMAGES);
		
		LinkUtil::sendCacheControlHeaders($this->oDocumentType, $oCache);
		if($oCache->entryExists() && !$oCache->isOlderThan($this->oDocumentType)) {
			header("Content-Type: ".self::MIME_TYPE);
			$oCache->passContents(true);exit;
		}
		
		$sFileName = "{$this->oDocumentType->getDocumentKind()}.png";
		
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_MODULES, self::getType(), $this->getModuleName(), ResourceIncluder::RESOURCE_TYPE_ICON, $sFileName));
		if($sFilePath === null) {
			$sFileName = 'default.png';
		}
		
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_MODULES, self::getType(), $this->getModuleName(), ResourceIncluder::RESOURCE_TYPE_ICON, $sFileName));
		if($sFilePath === null) {
			throw new Exception("Error in DocumentTypePreviewFileModule->renderFile: type has unknown kind: {$this->oDocumentType->getDocumentKind()}");
		}
		
		$sFontFilePath = ResourceFinder::findResource(array(DIRNAME_MODULES, self::getType(), $this->getModuleName(), 'PTS55F.ttf'));
		$oImage = Image::imageFromPath($sFilePath);
		if(Image::supportsText()) {
			$sText = strtoupper($this->oDocumentType->getExtension());
			$fFontSize = 72.0;
			$aSize = Image::textSize($sFontFilePath, $sText, $fFontSize);
			$iDesiredWidth = 300;
			$iDesiredHeight = 145;
			$fWidthRatio = $iDesiredWidth/$aSize[0];
			$fHeightRatio = $iDesiredHeight/$aSize[1];
			
			$fRatio = min($fWidthRatio, $fHeightRatio);
			$fFontSize *= $fRatio;
			
			$iDesiredPositionX = 107 - (7 * $fRatio);
			$iDesiredPositionY = 338;
			$iStartPositionX = $iDesiredPositionX + (($iDesiredWidth - ($aSize[0] * $fRatio))/2);
			$iStartPositionY = $iDesiredPositionY + ($aSize[1] * $fRatio) + ($iDesiredHeight - ($aSize[1] * $fRatio))/2;
			
			$oImage->addText($sFontFilePath, $sText, 1, $fFontSize, 150, 150, 150, $iStartPositionX, $iStartPositionY);
		}
		if($this->iSize < 512) {
			$oImage->setSize($this->iSize, $this->iSize, Image::STRETCH);
		}
		$oImage->setFileType('png');
		$oImage->render(true, null, $oCache); exit;
	}
}