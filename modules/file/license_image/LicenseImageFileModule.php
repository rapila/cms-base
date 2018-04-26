<?php
class LicenseImageFileModule extends FileModule {
	private $sLicense;
	private $sURL;
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sLicense = Manager::usePath();
		if(!isset(DocumentPeer::$LICENSES[$this->sLicense])) {
			throw new Exception("License invalid: ".$this->sLicense);
		}
		$aLicenseInfo = DocumentPeer::$LICENSES[$this->sLicense];
		if(!isset($aLicenseInfo['image'])) {
			throw new Exception("No Image for license: ".$this->sLicense);
		}
		$this->sURL = $aLicenseInfo['image'];
	}
	
	public function renderFile() {
		$oCache = new Cache('license_'.$this->sLicense, DIRNAME_IMAGES);
		$sExtension = substr($this->sURL, strrpos($this->sURL, '.')+1);
		$oDocumentType = DocumentTypePeer::getDocumentTypeByExtension($sExtension);
		$sMimeType = 'image/'.$sExtension;
		if($oDocumentType !== null) {
			$sMimeType = $oDocumentType->getMimetype();
		}
		header('Content-Type: '.$sMimeType);
		if($oCache->entryExists()) {
			$oCache->sendCacheControlHeaders();
			$oCache->passContents(true);
		} else {
			$sImage = file_get_contents($this->sURL);
			$oCache->setContents($sImage);
			$oCache->sendCacheControlHeaders();
			header("Content-Length: ".strlen($sImage));
			print($sImage);
		}
	}
}
