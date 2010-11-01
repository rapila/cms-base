<?php

/**
* @package html
*/
class TagParser {
	private $oTag = null;
	private $sInput;
	private $oCurrentTag;
	
	public function __construct($sInput) {
		$this->sInput = str_replace('&nbsp;', '&#160;', $sInput);
		
		$iParseHandle = xml_parser_create(Settings::getSetting("encoding", "browser", "utf-8"));
		xml_parser_set_option($iParseHandle, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($iParseHandle, XML_OPTION_SKIP_WHITE, 1);
		xml_parser_set_option($iParseHandle, XML_OPTION_TARGET_ENCODING, Settings::getSetting("encoding", "db", "utf-8"));
		xml_set_element_handler($iParseHandle, array($this, "startTag"), array($this, "endTag"));
		xml_set_character_data_handler($iParseHandle, array($this, "characters"));
		xml_parse($iParseHandle, $this->sInput);
		$iParseResult = xml_get_error_code($iParseHandle);
		xml_parser_free($iParseHandle);
		if($iParseResult !== XML_ERROR_NONE) {
			throw new Exception("error parsing XML: ".xml_error_string($iParseResult).$sInput);
		}
	}
	
	public function startTag($iParseHandle, $sTagName, $aParameters) {
		$oNewTag = new HtmlTag($sTagName);
		if($this->oTag === null) {
			$this->oTag = $oNewTag;
		} else {
			$this->oCurrentTag->appendChild($oNewTag);
		}
		$this->oCurrentTag = $oNewTag;
		$this->oCurrentTag->setParameters($aParameters);
	}
	
	public function endTag($iParseHandle, $sTagName) {
		$this->oCurrentTag = $this->oCurrentTag->getParent();
	}
	
	public function characters($iParseHandle, $sCharacters) {
		$this->oCurrentTag->appendChild($sCharacters);
	}
	
	public function setTag($oTag)
	{
			$this->oTag = $oTag;
	}

	public function getTag()
	{
			return $this->oTag;
	}
}
