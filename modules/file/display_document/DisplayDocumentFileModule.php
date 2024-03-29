<?php
/**
 * @package modules.file
 */
class DisplayDocumentFileModule extends FileModule {
	protected $oDocument;
	protected $oSession;
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		if(!isset($this->aPath[0])) {
			// Exceptions thrown in a file module’s constructor yield a UserError but that’s OK.
			throw new Exception("Error in DisplayDocumentFileModule->__construct: no key given");
		}
		$this->oSession = Session::close();
		
		$sIdPart = explode('.', $this->aPath[0])[0]; // Drop the extension
		list($iId, $sHash) = explode('@', $sIdPart.'@'); // Split ID and Hash

		$this->oDocument = DocumentQuery::create()->findPk(intval($iId));

		if(!empty($sHash)) {
			// Compare the given prefix with the complete hash
			if(!StringUtil::startsWith($this->oDocument->getImmutableUrlKey(), $sHash)) {
				// The hash is out-of-date, redirect
				$aParams = array_filter($_GET, function($sKey) {
					return $sKey !== 'path';
				}, ARRAY_FILTER_USE_KEY);
				LinkUtil::redirect($this->oDocument->getDisplayUrl($aParams));
				return;
			} else {
				// The hash is current, tell the browser to cache long-term
				header('Cache-Control: public,max-age=31557600,immutable');
			}
		} else if(isset($_REQUEST['no-cache'])) {
			header('Cache-Control: no-cache');
		} 

		if($this->oDocument === null || ($this->oDocument->getIsProtected() && !$this->isAuthenticated())) {
			$oErrorPage = PageQuery::create()->findOneByName(Settings::getSetting('error_pages', 'not_found', 'error_404'));
			if($oErrorPage) {
				LinkUtil::redirect(LinkUtil::link($oErrorPage->getLinkArray(), "FrontendManager"));
			} else {
				print "Not found";exit;
			}
		}
		Session::close();
	}
	
	protected function isAuthenticated() {
		return $this->oSession->isAuthenticated();
	}

	public function renderFile() {
		$mMaxWidth = (isset($_REQUEST['max_width']) && is_numeric($_REQUEST['max_width'])) ? (int)$_REQUEST['max_width'] : 'full';
		$mMaxHeight = (isset($_REQUEST['max_height']) && is_numeric($_REQUEST['max_height'])) ? (int)$_REQUEST['max_height'] : 'full';
		if(!$this->oDocument->isGDImage()) {
			$mMaxWidth = 'full';
			$mMaxHeight = 'full';
		}

		$sCacheString = 'doc_'.$this->oDocument->getId().'_'.$mMaxWidth.'x'.$mMaxHeight.(isset($_REQUEST['add_text']) ? '_'.$_REQUEST['add_text'] : "");
		$oCache = new Cache($sCacheString, DIRNAME_IMAGES);

		$sDisplay = "inline";
		if(isset($_REQUEST['download']) && $_REQUEST['download'] == "true") {
			$sDisplay = "attachment";
		}
		header('Content-Disposition: '.$sDisplay.';filename="'.$this->oDocument->getFullName().'"');

		//Don’t base the last-modified off the cache but rather off the document’s updated-at.
		LinkUtil::sendCacheControlHeaders($this->oDocument, $oCache);

		if($oCache->entryExists() && !$oCache->isOlderThan($this->oDocument)) {
			header("Content-Type: ".$this->oDocument->getDocumentType()->getMimetype());
			$oCache->passContents(true);exit;
		}

		$rDataStream = $this->oDocument->getData();

		try {
			if(is_int($mMaxWidth) || is_int($mMaxHeight)) {
				$oImage = Image::imageFromStream($rDataStream, 'DocumentId: '.$this->oDocument->getId());
				if(is_int($mMaxWidth) && is_int($mMaxHeight)) {
					$oImage->setSize((int) $mMaxWidth, (int) $mMaxHeight, Image::RESIZE_TO_SMALLER_VALUE);
				} else if(is_int($mMaxWidth)) {
					$oImage->setSize((int) $mMaxWidth, 0, Image::RESIZE_TO_WIDTH);
				} else {
					$oImage->setSize(0, (int) $mMaxHeight, Image::RESIZE_TO_HEIGHT);
				}
				//Since $bDontBlowUp is true, do a preliminary check whether it’s necessary to even use the image class
				if($oImage->getScalingFactor() < 1.0) {
					$oImage->setFileType($this->oDocument->getDocumentType()->getExtension());
					$oImage->render(true, null, $oCache); exit;
				} else {
					//Free up space
					$oImage->destroy();
					rewind($rDataStream);
				}
			}
		} catch(Exception $ex) {} //Ignore unrecognized image format

		header("Content-Type: ".$this->oDocument->getDocumentType()->getMimetype());
		header("Content-Length: ".$this->oDocument->getDataSize());
		$oCache->setContents(stream_get_contents($rDataStream));
		rewind($rDataStream);
		fpassthru($rDataStream);
	}

	public static function getPath($iId, $sHash, $sExtension) {
		if(!empty($sHash)) {
			$sHash = substr($sHash, 0, 6);
			$sHash = '@'.$sHash;
		}
		return "$iId$sHash.$sExtension";
	}
}
