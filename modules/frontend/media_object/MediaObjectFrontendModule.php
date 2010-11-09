<?php
/**
 * @package modules.frontend
 */
include_once('propel/query/Criteria.php');

class MediaObjectFrontendModule extends FrontendModule implements WidgetBasedFrontendModule {
	
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
	
	public function widgetData() {
		return @unserialize($this->getData());	
	}
	
	public function widgetSave($mData) {
		$this->oLanguageObject->setData($this->dataFromPost($mData));
		return $this->oLanguageObject->save();
	}
	
	public function getWidget() {
		$oWidget = new MediaObjectEditWidgetModule(null, $this);
		return $oWidget;
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
		return $this->dataFromPost($_POST);
	}
	
	public function dataFromPost(&$aPostData) {
		$aResults = array();
		if(isset($aPostData['document_id'])) {
			foreach($aPostData['document_id'] as $iKey => $sId) {
				$sSrc = $aPostData['url'][$iKey];
				if($sId && !is_numeric($sId)) {
					$sSrc = $sId;
					$sId = '';
				}
				if(!$sId && !$sSrc) {
					continue;
				}
				if(!$sId && !$aPostData['mimetype'][$iKey]) {
					$bGetHeadersEnabled = ini_get('allow_url_fopen') == '1';
					if(!StringUtil::startsWith($sSrc, '/') && !$aPostData['mimetype'][$iKey] && file_exists(MAIN_DIR.'/'.$sSrc)) {
						//Relative url, assume it’s from the MAIN_DIR_FE
						$aMimeTypes = DocumentTypePeer::getMostAgreedMimetypes(MAIN_DIR.'/'.$sSrc);
						$aPostData['mimetype'][$iKey] = $aMimeTypes[0];
					} else {
						if($bGetHeadersEnabled && !$aPostData['mimetype'][$iKey]) {
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
								$aPostData['mimetype'][$iKey] = $sContentType;
							}
						}
					}
				}
				if(!$sId && !$aPostData['mimetype'][$iKey]) {
					$aPostData['mimetype'][$iKey] = 'application/octet-stream';
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
			$bGetHeadersEnabled = ini_get('allow_url_fopen') == '1';
			if(!StringUtil::startsWith($sSrc, '/') && file_exists(MAIN_DIR.'/'.$sSrc)) {
				//Relative url, assume it’s from the MAIN_DIR_FE
				$aMimeTypes = DocumentTypePeer::getMostAgreedMimetypes(MAIN_DIR.'/'.$sSrc);
				return $aMimeTypes[0];
			} else if($bGetHeadersEnabled) {
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
		$oDocument = DocumentPeer::retrieveByPK($aData['document_id']);
		return Util::nameForObject($oDocument);
	}
	
	private function replaceDocumentOptions($oTemplate, $iSelectedId = null) {
		$oTemplate->replaceIdentifier("available_documents", TagWriter::optionsFromObjects(DocumentPeer::getDocumentsByKindAndCategory(), "getId", "getNameAndExtension", $iSelectedId));
	}
}
?>