<?php

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
	
	public function setParameters($aParameters) {
			$this->aParameters = $aParameters;
	}

	public function getParameters() {
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
	
	public function setParameter($sParameterName, $sParameterValue) {
		$this->aParameters[$sParameterName] = $sParameterValue;
	}
	
	public function hasParameter($sParameterName) {
		return isset($this->aParameters[$sParameterName]);
	}
	
	public function setName($sName) {
			$this->sName = $sName;
	}

	public function getName() {
			return $this->sName;
	}
	
	public function setChildren($aChildren) {
			$this->aChildren = $aChildren;
	}

	public function getChildren() {
			return $this->aChildren;
	}
	
	public function setParent($oParent) {
			$this->oParent = $oParent;
	}

	public function getParent() {
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
	
	public function setParseCallback($mParseCallback) {
		$this->mParseCallback = $mParseCallback;
		foreach($this->aChildren as $mChild) {
			if(!$mChild instanceof HtmlTag) {
				continue;
			}
			$mChild->setParseCallback($mParseCallback);
		}
	}

	public function getParseCallback() {
			return $this->mParseCallback;
	}
	
	/**
	* Does the actual parsing of the tag to produce valid XHTML output. The default implementation uses a TagWriter to produce the tag contents, passing it the name, parameters and parsed children (as string).
	*
	* If a parse callback is set, it relies on its implementation to return valid output given the parsed children.
	* Most callbacks will want to use TagWriter as well but transform the output a bit before doing so.
	*/
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