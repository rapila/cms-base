<?php
/**
 * @package modules.file
 */
class DisplayDocumentFileModule extends FileModule {	
	protected $oDocument;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		if(!isset($this->aPath[0])) {
			throw new Exception("Error in DisplayDocumentFileModule->__construct: no key given");
		}
		$this->oDocument = DocumentPeer::retrieveByPK($this->aPath[0]);
		if($this->oDocument === null || ($this->oDocument->getIsProtected() && !$this->isAuthenticated())) {
			LinkUtil::redirect(LinkUtil::link(PagePeer::getPageByName(Settings::getSetting('error_pages', 'not_found', 'error_404'))->getLink(), "FrontendManager"));
			break;
		}	 
	}
	
	protected function isAuthenticated() {
		return Session::getSession()->isAuthenticated();
	}

	public function renderFile() {
		$mMaxWidth = is_numeric(@$_REQUEST['max_width']) ? (int)$_REQUEST['max_width'] : 'full';
		$mMaxHeight = is_numeric(@$_REQUEST['max_height']) ? (int)$_REQUEST['max_height'] : 'full';
		
		$sCacheString = 'doc_'.$this->oDocument->getId().'_'.$mMaxWidth.'x'.$mMaxHeight.(isset($_REQUEST['add_text']) ? '_'.$_REQUEST['add_text'] : "");
		$oCache = new Cache($sCacheString, DIRNAME_IMAGES);
		
		$sDisplay = "inline";
		if(isset($_REQUEST['download']) && $_REQUEST['download'] == "true") {
			$sDisplay = "attachment";
		}
		header('Content-Disposition: '.$sDisplay.';filename="'.$this->oDocument->getFullName().'"');
		
		$iTimestamp = $this->oDocument->getUpdatedAt();
		if($oCache->cacheFileExists() && !$oCache->isOlderThan($iTimestamp)) {
			$oCache->sendCacheControlHeaders($iTimestamp);
			header("Content-Type: ".$this->oDocument->getDocumentType()->getMimetype());
			$oCache->passContents(true);exit;
		}
		
		if(is_int($mMaxWidth) || is_int($mMaxHeight)) {
			$oImage = Image::imageFromData(stream_get_contents($this->oDocument->getData()));
			if(is_int($mMaxWidth) && is_int($mMaxHeight)) {
				$oImage->setSize($mMaxWidth, $mMaxHeight, Image::RESIZE_TO_SMALLER_VALUE);
			} else if(is_int($mMaxWidth)) {
				$oImage->setSize($mMaxWidth, 0, Image::RESIZE_TO_WIDTH);
			} else {
				$oImage->setSize(0, $mMaxHeight, Image::RESIZE_TO_HEIGHT);
			}
			//Since $bDontBlowUp is true, do a preliminary check whether it’s necessary to even use the image class
			if($oImage->getScalingFactor() < 1.0) {
				$oImage->setFileType($this->oDocument->getDocumentType()->getExtension());
				$oImage->render(true, null, $oCache); exit;
			} else {
				//Free up space
				$oImage->destroy();
			}
		}
		
		header("Content-Type: ".$this->oDocument->getDocumentType()->getMimetype());
		header("Content-Length: ".$this->oDocument->getDataSize());
		$oCache->setContents(stream_get_contents($this->oDocument->getData()));
		$oCache->sendCacheControlHeaders($iTimestamp);
		rewind($this->oDocument->getData());
		fpassthru($this->oDocument->getData());
	}
}
?>