<?php
/**
 * @package modules.file
 */
class DisplayDocumentFileModule extends FileModule {  
  protected $oDocument;
  
  public function __construct($aRequestPath) {
    parent::__construct($aRequestPath);
    if(!isset($this->aPath[1])) {
      throw new Exception("Error in DisplayDocumentFileModule->__construct: no key given");
    }
    $this->oDocument = DocumentPeer::retrieveByPk($this->aPath[1]);
    if($this->oDocument === null || ($this->oDocument->getIsProtected() && !$this->isAuthenticated())) {
      Util::redirect(Util::link(PagePeer::getPageByName(Settings::getSetting('error_pages', 'not_found', 'error_404'))->getLink(), "FrontendManager"));
      break;
    }  
  }
  
  protected function isAuthenticated() {
    return Session::getSession()->isAuthenticated();
  }

  public function renderFile() {
    $sCacheString = 'doc_'.$this->oDocument->getId().'_'.(isset($_REQUEST['max_width']) ? $_REQUEST['max_width'] : "full").(isset($_REQUEST['add_text']) ? '_'.$_REQUEST['add_text'] : "");
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
    
    if(isset($_REQUEST['max_width'])) {
      $bRenderImage = true;
      $oImage = Image::imageFromData($this->oDocument->getData()->getContents());
      if(isset($_REQUEST['max_width'])) {
        $oImage->setSize((int)$_REQUEST['max_width'], 200, Image::RESIZE_TO_WIDTH);
        if($oImage->getWidth() >= $oImage->getOriginalWidth()) {
          $bRenderImage = false;
        }
      }
      if($bRenderImage) {
        $oImage->setFileType($this->oDocument->getDocumentType()->getExtension());
        $oImage->render(true, null, $oCache); exit;
      }
    }
    
    header("Content-Type: ".$this->oDocument->getDocumentType()->getMimetype());
    header("Content-Length: ".strlen($this->oDocument->getData()->getContents()));
    $oCache->setContents($this->oDocument->getData()->getContents());
    $this->oDocument->getData()->dump(); exit;
  }
}
?>