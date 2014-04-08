<?php
/**
 * @package modules.frontend
 */
include_once('propel/runtime/lib/query/Criteria.php');

class MediaObjectFrontendModule extends FrontendModule {
	
	public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
		parent::__construct($oLanguageObject, $aRequestPath, $iId);
	}

	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		if(!$aOptions) {
			$aOptions = array();
		}
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier("content"), null, true);
		foreach($aOptions as $aDocumentInfo) {
			$oDocument = DocumentQuery::create()->findPk($aDocumentInfo['document_id']);
			$sMimeType = @$aDocumentInfo['mimetype'];
			$sSrc = null;
			
			if($oDocument !== null) {
				$aParameters = array();
				if(@$aDocumentInfo['max_width']) {
					$aParameters['max_width'] = $aDocumentInfo['max_width'];
				}
				if(@$aDocumentInfo['max_height']) {
					$aParameters['max_height'] = $aDocumentInfo['max_width'];
				}
				if(@$aDocumentInfo['force_refresh']) {
          $aParameters['refresh'] = time();
				}
				
				$sSrc = $oDocument->getDisplayUrl($aParameters);
				if(!$sMimeType) {
					$sMimeType = $oDocument->getMimetype();
				}
			} else if ((@$aDocumentInfo['url'])) {
				$sSrcToCheck = $aDocumentInfo['url'];
				if(($iQSPos = strrpos($sSrcToCheck, '?')) !== false) {
					$sSrcToCheck = substr($sSrcToCheck, 0, $iQSPos);
				}
				if(file_exists(MAIN_DIR.'/'.$sSrcToCheck)) {
					$aDocumentInfo['url'] = MAIN_DIR_FE.$aDocumentInfo['url'];
				}
				$sSrc = @$aDocumentInfo['url'];
			} else {
				continue;
			}
			$oSubTemplate = null;
			try {
				try {
					$oSubTemplate = $this->constructTemplate($sMimeType);
				} catch (Exception $e) {
					$sMimeTypePrefix = explode('/', $sMimeType);
					$sMimeTypePrefix = $sMimeTypePrefix[0];
					$oSubTemplate = $this->constructTemplate("$sMimeTypePrefix/generic");
				}
			} catch (Exception $e) {
				$oSubTemplate = $this->constructTemplate("generic");
			}
			if(@$aDocumentInfo['width']) {
				$oSubTemplate->replaceIdentifier('width', $aDocumentInfo['width']);
			}
			if(@$aDocumentInfo['height']) {
				$oSubTemplate->replaceIdentifier('height', $aDocumentInfo['height']);
			}
			$oSubTemplate->replaceIdentifier('src', $sSrc);
			$oSubTemplate->replaceIdentifier('mimeType', $sMimeType);
			$oTemplate->replaceIdentifier("content", $oSubTemplate, null, Template::LEAVE_IDENTIFIERS);
		}
		return $oTemplate;
	}
	
	public function getSaveData($mData) {
		ReferencePeer::removeReferences($this->oLanguageObject);
		if(isset($mData['document_id'])) {
			foreach($mData['document_id'] as $iDocumentId) {
				if($iDocumentId) {
					ReferencePeer::addReference($this->oLanguageObject, array($iDocumentId, 'Document'));
				}
			}
		}
		return $this->dataFromPost($mData);
	}
	
	public function dataFromPost(&$aPostData) {
		$aResults = array();
		if(isset($aPostData['document_id'])) {
			foreach($aPostData['document_id'] as $iKey => $sId) {
				$sSrc = $aPostData['url'][$iKey];
				if(!$sId && !$sSrc) {
					continue;
				}
				if($sId && !is_numeric($sId)) {
					$sSrc = $sId;
					$sId = '';
				}
				if(!$sId && !$aPostData['mimetype'][$iKey]) {
					$aPostData['mimetype'][$iKey] = $this->mimetypeFor(null, $sSrc);
					if(!$aPostData['mimetype'][$iKey]) {
						$aPostData['mimetype'][$iKey] = null;
					}
				}
				$aResults[] = array("document_id" => $sId, 'url' => $sSrc, "width" => $aPostData["width"][$iKey], "height" => $aPostData["height"][$iKey], "mimetype" => $aPostData["mimetype"][$iKey]);
			}
		}
		return serialize($aResults);
	}
	
	public function mimetypeFor($sId, $sSrc) {
		if($sId && !is_numeric($sId)) {
			$sSrc = $sId;
			$sId = '';
		}
		if($sSrc) {
			if(($iQSPos = strrpos($sSrc, '?')) !== false) {
				$sSrc = substr($sSrc, 0, $iQSPos);
			}
			$bGetHeadersEnabled = ini_get('allow_url_fopen') == '1';
			if(!StringUtil::startsWith($sSrc, '/') && file_exists(MAIN_DIR.'/'.$sSrc)) {
				//Relative url, assume it’s from the MAIN_DIR_FE
				$aMimeTypes = DocumentTypePeer::getMostAgreedMimetypes(MAIN_DIR.'/'.$sSrc);
				return $aMimeTypes[0];
			} else if($bGetHeadersEnabled) {
				if(StringUtil::startsWith($sSrc, '//')) {
					$sSrc = "http:$sSrc";
				}
				$aHeaders = @get_headers($sSrc, true);
				if($aHeaders && isset($aHeaders['Content-Type'])) {
					$sContentType = $aHeaders['Content-Type'];
					if(is_array($sContentType)) {
						$sContentType = array_pop($sContentType);
					}
					$iCharsetLocation = strpos($sContentType, ';');
					if($iCharsetLocation !== false) {
						$sContentType = substr($sContentType, 0, $iCharsetLocation);
					}
					return $sContentType;
				}
			}
		}
		return '';
	}

	public static function getContentInfo($oLanguageObject) {
		if(!$oLanguageObject) {
			return null;
		}
		$aData = @unserialize(stream_get_contents($oLanguageObject->getData()));
		if(!$aData && !isset($aData[0])) {
			return null;
		}
		$aData = $aData[0];
		$oDocument = DocumentQuery::create()->findPk($aData['document_id']);
		return Util::nameForObject($oDocument);
	}
}
