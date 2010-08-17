<?php
/**
 * @package modules.frontend
 */
include_once('propel/query/Criteria.php');

class MediaObjectFrontendModule extends FrontendModule {
	
	public function __construct($oLanguageObject = null, $aRequestPath = null, $iId = 1) {
		parent::__construct($oLanguageObject, $aRequestPath, $iId);
	}

	public function renderFrontend() {
		$aOptions = @unserialize($this->getData());
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier("content"), null, true);
		foreach($aOptions as $aDocumentInfo) {
			$oDocument = DocumentPeer::retrieveByPK($aDocumentInfo['document_id']);
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
				if(file_exists(MAIN_DIR.'/'.$aDocumentInfo['url'])) {
					$aDocumentInfo['url'] = MAIN_DIR_FE.$aDocumentInfo['url'];
				}
				$sSrc = @$aDocumentInfo['url'];
			} else {
				continue;
			}
			$oSubTemplate = null;
			try {
				$oSubTemplate = $this->constructTemplate($sMimeType);
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
	
	public function renderBackend() {
		$aOptions = @unserialize($this->getData());
		$oTemplate = $this->constructTemplate('backend');
		// if($aOptions !== null) {
		if($aOptions) {
			foreach($aOptions as $iKey => $aDocumentInfo) {
				$oMediaItemTemplate = $this->constructTemplate("backend_media_item");
				$oMediaItemTemplate->replaceIdentifier("sequence_id", $iKey);
				$oMediaItemTemplate->replaceIdentifier("url", @$aDocumentInfo['url']);
				$oMediaItemTemplate->replaceIdentifier("width", $aDocumentInfo['width']);
				$oMediaItemTemplate->replaceIdentifier("height", $aDocumentInfo['height']);
				$oMediaItemTemplate->replaceIdentifier("mimetype", @$aDocumentInfo['mimetype']);
				$this->replaceDocumentOptions($oMediaItemTemplate, (int)$aDocumentInfo['document_id']);
				$oTemplate->replaceIdentifierMultiple("documents", $oMediaItemTemplate);
			}
		}
		$this->replaceDocumentOptions($oTemplate);
		return $oTemplate;
	}
	
	public function getJsForBackend() {
		return $this->constructTemplate("backend.js")->render();
	}
	
	public function getSaveData() {
		$aResults = array();
		foreach($_POST['document_id'] as $iKey => $sId) {
			$sSrc = $_POST['url'][$iKey];
			if(!$sId && !$sSrc) {
				continue;
			}
			if(!$sId && !$_POST['mimetype'][$iKey]) {
				$bGetHeadersEnabled = ini_get('allow_url_fopen') == '1';
				if(!StringUtil::startsWith($sSrc, '/') && !$_POST['mimetype'][$iKey] && file_exists(MAIN_DIR.'/'.$sSrc)) {
					//Relative url, assume it’s from the MAIN_DIR_FE
					$aMimeTypes = DocumentTypePeer::getMostAgreedMimetypes(MAIN_DIR.'/'.$sSrc);
					$_POST['mimetype'][$iKey] = $aMimeTypes[0];
				} else {
					if($bGetHeadersEnabled && !$_POST['mimetype'][$iKey]) {
						$aHeaders = get_headers($sSrc, true);
						$_POST['mimetype'][$iKey] = $aHeaders['Content-Type'];
					}
				}
			}
			if(!$sId && !$_POST['mimetype'][$iKey]) {
				$_POST['mimetype'][$iKey] = 'application/octet-stream';
			}
			ErrorHandler::log($_POST);
			$aResults[] = array("document_id" => $sId, 'url' => $sSrc, "width" => $_POST["width"][$iKey], "height" => $_POST["height"][$iKey], "mimetype" => $_POST["mimetype"][$iKey]);
		}
		return serialize($aResults);
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
		$oDocument = DocumentPeer::retrieveByPK($aData['document_id']);
		return Util::nameForObject($oDocument);
	}
	
	private function replaceDocumentOptions($oTemplate, $iSelectedId = null) {
		$oTemplate->replaceIdentifier("available_documents", TagWriter::optionsFromObjects(DocumentPeer::getDocumentsByKindAndCategory(), "getId", "getNameAndExtension", $iSelectedId));
	}
}
?>