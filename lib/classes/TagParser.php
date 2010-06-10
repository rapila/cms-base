<?php
class TagParser {
	private $oTag = null;
	private $sInput;
	private $oCurrentTag;
	
	public function __construct($sInput) {
		$this->sInput = $sInput;
		
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

class HtmlTag {
	private $sName;
	private $oParent = null;
	private $aParameters = array();
	private $aChildren = array();
	private $mParseCallback = null;
	
	public function __construct($sName) {
		$this->sName = $sName;
	}
	
	public function addParameters($aParameters) {
		$this->aParameters = array_merge($this->aParameters, $aParameters);
	}
	
	public function setParameters($aParameters)
	{
			$this->aParameters = $aParameters;
	}

	public function getParameters()
	{
			return $this->aParameters;
	}
	
	public function clearParameter($sParameterName) {
		unset($this->aParameters[$sParameterName]);
	}
	
	public function getParameter($sParameterName) {
		if(!$this->hasParameter($sParameterName)) {
			return null;
		}
		return $this->aParameters[$sParameterName];
	}
	
	public function hasParameter($sParameterName) {
		return isset($this->aParameters[$sParameterName]);
	}
	
	public function setName($sName)
	{
			$this->sName = $sName;
	}

	public function getName()
	{
			return $this->sName;
	}
	
	public function setChildren($aChildren)
	{
			$this->aChildren = $aChildren;
	}

	public function getChildren()
	{
			return $this->aChildren;
	}
	
	public function setParent($oParent)
	{
			$this->oParent = $oParent;
	}

	public function getParent()
	{
			return $this->oParent;
	}
	
	public function appendChild($mChild) {
		if($mChild instanceof HtmlTag) {
			$mChild->setParent($this);
		}
		$this->aChildren[] = $mChild;
	}
	
	public function removeChild($mChild) {
		$iIndex = array_search($mChild, $this->aChildren, true);
		if($iIndex !== false) {
			unset($this->aChildren[$iIndex]);
		}
	}
	
	public function setParseCallback($mParseCallback)
	{
			$this->mParseCallback = $mParseCallback;
			foreach($this->aChildren as $mChild) {
				if(!$mChild instanceof HtmlTag) {
					continue;
				}
				$mChild->setParseCallback($mParseCallback);
			}
	}

	public function getParseCallback()
	{
			return $this->mParseCallback;
	}
	
	public function __toString() {
		$sParsedChildren = "";
		foreach($this->aChildren as $mChild) {
			if($mChild instanceof HtmlTag) {
				$sParsedChildren.= $mChild->__toString(false);
			} else {
				$sParsedChildren.= Template::htmlEncode($mChild);
			}
		}
		$sResult = "";
		if($this->mParseCallback === null) {
			$oTagWriter = new TagWriter($this->sName, $this->aParameters, $sParsedChildren);
			$sResult = $oTagWriter->parse(true)->render();
		} else {
			$sResult = call_user_func($this->mParseCallback, $this, $sParsedChildren);
		}
		return $sResult;
	}
}
?>