<?php
/**
 * @package utils
 */
class RichtextUtil {
	
	private static $RICHTEXT_INDEX = 0;
	
	public static $USE_ABSOLUTE_LINKS = null;
	
	private $sAreaName;
	private $aSettings;
	
	private $mTrackReferences = null;
	
	public function __construct($sAreaName=null, $aSettings=null) {
		if($sAreaName === null) {
			$sAreaName = "richtext_area_";
		}
		$this->sAreaName = $sAreaName.self::$RICHTEXT_INDEX;
		self::$RICHTEXT_INDEX++;
		
		if($aSettings === null) {
			$aSettings = Settings::getSetting('admin', 'text_module', array());
		}
		$this->aSettings = $aSettings;
	}
	
	public static function parseInputFromEditorForStorage($sInput) {
		$oRichtextUtil = new RichtextUtil();
		$_POST[$oRichtextUtil->sAreaName] = $sInput;
		return $oRichtextUtil->parseInputFromEditor();
	}
	
	/**
	* Returns a TagParser instance all the handlers set correctly to parse text coming from a richtext area.
	*/
	public function getTagParser($sInput = null) {
		if($sInput === null) {
			$sInput = $_POST[$this->sAreaName];
		}
		$oTagParser = new TagParser("<text>".$sInput."</text>");
		$oTagParser->getTag()->setParseCallback(array($this, 'textTagParseCallback'));
		return $oTagParser;
	}
	
	/**
	* Returns a string with parsed text coming from a richtext area.
	* Calls getTagParser internally but also does the parsing by calling __toString.
	*/
	public function parseInputFromEditor($sInput = null) {
		return $this->getTagParser($sInput)->getTag()->__toString();
	}
	
	public static function parseStorageForOutput($sStorage, $bIsAdmin) {
		if(is_resource($sStorage)) {
			$sStorage = stream_get_contents($sStorage);
		}
		$oTemplate = new Template($sStorage, "db", true);
		self::replaceIdentifierWithCallback($oTemplate, 'internal_link', 'internalLinkCallback', $bIsAdmin);
		self::replaceIdentifierWithCallback($oTemplate, 'external_link', 'externalLinkCallback', $bIsAdmin);
		self::replaceIdentifierWithCallback($oTemplate, 'file_link', 'fileLinkCallback', $bIsAdmin);
		self::replaceIdentifierWithCallback($oTemplate, 'image', 'imageCallback', $bIsAdmin);
		self::replaceIdentifierWithCallback($oTemplate, 'mailto_link', 'mailtoLinkCallback', $bIsAdmin);
		return $oTemplate;
	}
	
	public static function parseStorageForFrontendOutput($sStorage) {
		return self::parseStorageForOutput($sStorage, false);
	}
	
	public static function parseStorageForBackendOutput($sStorage) {
		return self::parseStorageForOutput($sStorage, true);
	}
	
	private static function replaceIdentifierWithCallback($oTemplate, $sIdentifierName, $sCallbackName, $bIsAdmin) {
		if($bIsAdmin) {
			$sCallbackName .= 'Be';
		}
		$oTemplate->replaceIdentifierCallback($sIdentifierName, 'RichtextUtil', $sCallbackName, Template::NO_HTML_ESCAPE|Template::LEAVE_IDENTIFIERS);
	}
	
	private static function writeTagForIdentifier($sTagName, $aParameters, $oIdentifier, $sTagContent = null, $mCallbackContext = null) {
		if($sTagContent === null) {
			$sTagContent = $oIdentifier->getParameter("link_text");
		}
		FilterModule::getFilters()->handleRichtextWriteTagForIdentifier($sTagName, array(&$aParameters), $oIdentifier, $sTagContent, $mCallbackContext);
		$oWriter = new TagWriter($sTagName, array(), $sTagContent);
		foreach($aParameters as $sName => $sValue) {
			$oWriter->setParameter($sName, $sValue);
		}
		return self::writeTagForIdentifierWithWriter($oIdentifier, $oWriter);
	}
	
	private static function writeTagForIdentifierWithWriter($oIdentifier, $oWriter) {
		foreach($oIdentifier->getParameters() as $sName => $sValue) {
			if($sName === 'class') {
				$oWriter->addToParameter($sName, $sValue);
			} else if ($sName !== "link_text" && $sName !== "href") {
				$oWriter->setParameter($sName, $sValue);
			}
		}
		return $oWriter->parse(true);
	}
	
	public static function imageCallback($oIdentifier) {
		$iDocumentId = $oIdentifier->getValue();
		$oDocument = DocumentQuery::create()->findPk($iDocumentId);
		if($oDocument !== null && $oDocument->isImage()) {
			$oWriter = new TagWriter('img', $oIdentifier->getParameters());
			$aParameters = array();
			if($oIdentifier->hasParameter('max_width')) {
				$aParameters['max_width'] = $oIdentifier->getParameter('max_width');
				$oWriter->setParameter('max_width', null);
			}
			$oWriter->setParameter('src', self::link($oDocument->getDisplayUrl($aParameters)));
			$oWriter->setParameter('alt', $oDocument->getDescription());
			$oWriter->setParameter('title', $oDocument->getDescription());
			return $oWriter->parse();
		}
	}
	
	public static function imageCallbackBe($oIdentifier) {
		$iDocumentId = $oIdentifier->getValue();
		$oDocument = DocumentQuery::create()->findPk($iDocumentId);
		if($oDocument !== null && $oDocument->isImage()) {
			$oWriter = new TagWriter('img', $oIdentifier->getParameters());
			$oWriter->setParameter('src', self::link($oDocument->getDisplayUrl()));
			$oWriter->setParameter('alt', $oDocument->getDescription());
			$oWriter->setParameter('title', $oDocument->getDescription());
			if($oIdentifier->hasParameter('max_width')) {
				$oWriter->setParameter('width', $oIdentifier->getParameter('max_width'));
			}
			return $oWriter->parse();
		}
	}
	
	public static function internalLinkCallback($oIdentifier) {
		$aValue = explode('/', $oIdentifier->getValue());
		$iId = array_shift($aValue);
		$oPage = PageQuery::create()->findPk($iId);
		if($oPage) {
			$mManager = Manager::getManagerClassNormalized();
			if($mManager !== "PreviewManager") {
				$mManager = "FrontendManager";
			}
			$sLink = self::getLink(array_merge($oPage->getFullPathArray(), $aValue), $mManager);
			return self::writeTagForIdentifier("a", array('href' => $sLink, 'title' => $oPage->getPageTitle(), 'rel' => 'internal', 'class' => 'internal_link'), $oIdentifier, null, $oPage);
		}
	}
	
	public static function internalLinkCallbackBe($oIdentifier) {
		$aValue = explode('/', $oIdentifier->getValue());
		$iId = $aValue[0];
		$oPage = PageQuery::create()->findPk($iId);
		array_unshift($aValue, 'internal_link_proxy');
		if($oPage) {
			$sLink = self::getLink($aValue, 'FileManager');
			return self::writeTagForIdentifier("a", array('href' => $sLink), $oIdentifier, null, $oPage);
		}
	}
	
	public static function mailtoLinkCallback($oIdentifier) {
		$sLinkUrl = $oIdentifier->getValue();
		$sText = $oIdentifier->getParameter("link_text");
		$oWriter = TagWriter::getEmailLinkWriter($sLinkUrl, $sText);
		return self::writeTagForIdentifierWithWriter($oIdentifier, $oWriter);
	}
	
	public static function mailtoLinkCallbackBe($oIdentifier) {
		return self::writeTagForIdentifier("a", array('href' => "mailto:".$oIdentifier->getValue()), $oIdentifier);
	}
	
	public static function externalLinkCallback($oIdentifier) {
		$oLink = LinkQuery::create()->findPk($oIdentifier->getValue());
		if($oLink) {
			//Mailto-Link handling
			if(StringUtil::startsWith($oLink->getUrl(), 'mailto:')) {
				return self::mailtoLinkCallback(new TemplateIdentifier('mailto_link', substr($oLink->getUrl(), strlen('mailto:')), array('link_text' => $oIdentifier->getParameter("link_text"))));
			}
			return self::writeTagForIdentifier("a", array('href' => $oLink->getUrl(), 'title' => $oLink->getDescription(), 'rel' => 'external', 'class' => 'external_link'), $oIdentifier, null, $oLink);
		}
		return new Template($oIdentifier->getParameter('link_text'), null, true);
	}
	
	public static function externalLinkCallbackBe($oIdentifier) {
		$oLink = LinkQuery::create()->findPk($oIdentifier->getValue());
		if($oLink) {
			return self::writeTagForIdentifier("a", array('href' => self::getLink(array('external_link_proxy', $oLink->getId()), 'FileManager')), $oIdentifier, null, $oLink);
		} else {
			return self::writeTagForIdentifier("a", array('href' => '#', 'style' => "color: red;!important;"), $oIdentifier, $oIdentifier->getParameter("link_text").' [Link missing!]');
		}
	}
	
	public static function fileLinkCallback($oIdentifier) {
		$oDocument = DocumentQuery::create()->findPk($oIdentifier->getValue());
		if($oDocument !== null) {
		 return self::writeTagForIdentifier("a", array('href' => self::link($oDocument->getDisplayUrl()), 'title' => $oDocument->getDescription() ? $oDocument->getDescription() : $oDocument->getName(), 'rel' => 'document', 'class' => 'document_link '.$oDocument->getExtension()), $oIdentifier, null, $oDocument);
		} else {
		 return new Template($oIdentifier->getParameter('link_text'), null, true);
		}
	}
	
	public static function fileLinkCallbackBe($oIdentifier) {
		$oDocument = DocumentQuery::create()->findPk($oIdentifier->getValue());
		if($oDocument !== null) {
			return self::writeTagForIdentifier("a", array('href' => self::link($oDocument->getDisplayUrl())), $oIdentifier, null, $oDocument);
		} else {
			return self::writeTagForIdentifier("a", array('style' => "color: red;"), $oIdentifier, $oIdentifier->getParameter("link_text").' [Document missing!]');
		}
	}
	
	private static function getLink($mLocation, $sManager=null, $aParameters=array()) {
		return self::link(LinkUtil::link($mLocation, $sManager, $aParameters));
	}
	
	private static function link($sLocation) {
		if(self::$USE_ABSOLUTE_LINKS !== null) {
			return LinkUtil::absoluteLink($sLocation, null, self::$USE_ABSOLUTE_LINKS);
		} else {
			return $sLocation;
		}
	}

	public function getAreaName() {
			return $this->sAreaName;
	}
	
	public function setTrackReferences($mTrackReferences) {
		$this->mTrackReferences = $mTrackReferences;
		if($this->mTrackReferences !== null) {
			// delete all references before saving the tracked ones
			ReferencePeer::removeReferences($this->mTrackReferences);
		}
	}

	public function getTrackReferences() {
		return $this->mTrackReferences;
	}
	
	private function addTrackReference($iToId, $sToClass) {
		if($this->mTrackReferences === null) {
			return;
		}
		ReferencePeer::addReference($this->mTrackReferences, array($iToId, $sToClass));
	}
	
	public function textTagParseCallback($oHtmlTag, $sParsedChildren) {
		if($oHtmlTag->getName() === 'text') {
			return $sParsedChildren;
		}
		if($oHtmlTag->getName() === 'img') {
			if(preg_match("%display_document/(\\d+)%", $oHtmlTag->getParameter('src'), $aMatches)) {
				$aParameters = $oHtmlTag->getParameters();
				if($oHtmlTag->hasParameter('width')) {
					$aParameters['max_width'] = $oHtmlTag->getParameter('width');
					unset($aParameters['width']);
					unset($aParameters['height']);
				}
				$this->addTrackReference($aMatches[1], "Document");
				return TemplateIdentifier::constructIdentifier('image', $aMatches[1], $aParameters);
			}
		}
		if($oHtmlTag->getName() === 'a') {
			if($sParsedChildren === '') return '';
			$bHasMatched = preg_match("%/".preg_quote(Manager::getPrefixForManager('FileManager'), "%")."/([^/]+)/(\\d+)((/.+)*)$%", $oHtmlTag->getParameter('href'), $aMatches) === 1;
			if($bHasMatched) {
				$sFileMethod = $aMatches[1];
				$iId = $aMatches[2];
				$sAdditional = $aMatches[3];
				$sIdentifier = 'file_link';
				$sModel = 'Document';
				if($sFileMethod === 'external_link_proxy') {
					$sIdentifier = 'external_link';
					$sModel = 'Link';
				} else if($sFileMethod === 'internal_link_proxy') {
					$sIdentifier = 'internal_link';
					$sModel = 'Page';
				}
				$this->addTrackReference($iId, $sModel);
				return TemplateIdentifier::constructIdentifier($sIdentifier, "$iId$sAdditional", array_merge($oHtmlTag->getParameters(), array('link_text' => $sParsedChildren)));
			} else if(strpos($oHtmlTag->getParameter('href'), "mailto:") === 0) {
				return TemplateIdentifier::constructIdentifier("mailto_link", substr($oHtmlTag->getParameter('href'), strlen("mailto:")), array("link_text" => $sParsedChildren));
			}
		}
		$oTagWriter = new TagWriter($oHtmlTag->getName(), $oHtmlTag->getParameters(), $sParsedChildren);
		$oTagTemplate = $oTagWriter->parse(true);
		$oTagTemplate->bKillIdentifiersBeforeRender = false;
		return $oTagTemplate->render();
	}	
}// end class RichtextUtil