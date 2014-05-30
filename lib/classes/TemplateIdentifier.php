<?php
require_once('Template.php');
class TemplateIdentifier extends TemplatePart {
	private $sName;
	private $sValue;
	private $aParameters;
	
	public $iFlags = 0;

	public static $PARAMETER_EMPTY_VALUE = null;

	const PARAMETER_EMPTY_VALUE = null;

	function __construct($sName, $sValue, $sParameters = null, $oTemplate = null) {
		$this->aParameters = array();
		$this->oTemplate = $oTemplate;
		$this->iFlags = 0;

		$this->setName($sName);

		$sValue = self::unescapeIdentifier($sValue);
		if(strpos($sValue, TEMPLATE_IDENTIFIER_START) !== false) {
			$oValueTemplate = $this->oTemplate->derivativeTemplate($sValue, false, true);
			$oValueTemplate->bKillIdentifiersBeforeRender = false;
			$sValue = $oValueTemplate->render(true);
		}
		$this->setValue($sValue);

		if($sParameters === null || $sParameters === "") {
			return;
		}
		$aParameters = array();
		if(is_array($sParameters)) {
			$aParameters = $sParameters;
		} else {
			$aParameters = preg_split("/(?<!\\\\)".preg_quote(TEMPLATE_PARAMETER_SEPARATOR, "/")."/", $sParameters);
		}
		foreach($aParameters as $sParameter) {
			$aKeyValuePair = preg_split("/(?<!\\\\)".preg_quote(TEMPLATE_KEY_VALUE_SEPARATOR, "/")."/", $sParameter);
			$sParameterValue = self::PARAMETER_EMPTY_VALUE;
			if(isset($aKeyValuePair[1])) {
				$sParameterValue = implode(TEMPLATE_KEY_VALUE_SEPARATOR, array_slice($aKeyValuePair, 1));
				$sParameterValue = self::unescapeIdentifier($sParameterValue);
				if(strpos($sParameterValue, TEMPLATE_IDENTIFIER_START) !== false) {
					$oValueTemplate = $this->oTemplate->derivativeTemplate($sParameterValue, false, true);
					$oValueTemplate->bKillIdentifiersBeforeRender = false;
					$sParameterValue = $oValueTemplate->render(true);
				}
			}
			if($aKeyValuePair[0] === 'templateFlag') {
				foreach(explode('|', $sParameterValue) as $sFlagName) {
					$this->iFlags |= constant('Template::'.$sFlagName);
				}
				continue;
			}
			$this->aParameters[$aKeyValuePair[0]] = $sParameterValue;
		}
	}
	
	/**
	* @return true if neither the value nor any parameters contain identifiers
	*/
	public function isFinal() {
		if(strpos($this->sValue, TEMPLATE_IDENTIFIER_START) !== false) {
			return false;
		}
		foreach($this->aParameters as $sParameterName => $sParameterValue) {
			if(strpos($sParameterValue, TEMPLATE_IDENTIFIER_START) !== false) {
				return false;
			}
		}
		return true;
	}

	public function setName($sName) {
		$this->sName = $sName;
	}

	public function getName() {
		return $this->sName;
	}

	public function setValue($sValue) {
		if($sValue === "") {
			$sValue = null;
		}

		$this->sValue = $sValue;
	}

	public function getValue() {
		return $this->sValue;
	}

	public function setParameter($sName, $sValue) {
		$this->aParameters[$sName] = $sValue;
	}

	public function unsetParameter($sName) {
		unset($this->aParameters[$sName]);
	}

	public function hasParameter($sName) {
		return array_key_exists($sName, $this->aParameters);
	}

	public function getParameters() {
		return $this->aParameters;
	}

	public function getParameter($sName) {
		if(!$this->hasParameter($sName)) {
			return null;
		}
		return $this->aParameters[$sName];
	}

	public function __toString() {
		return self::constructIdentifier($this->getName(), $this->getValue(), $this->aParameters);
	}

	public function __sleep() {
		$aVars = get_object_vars($this);
		unset($aVars['oTemplate']);
		return array_keys($aVars);
	}

	public static function unescapeIdentifier($sText) {
		if($sText === null) {
			return null;
		}
		$sText = str_replace("\\\\", "\\", $sText);
		$sText = str_replace("\\".TEMPLATE_IDENTIFIER_START_SINGLE, TEMPLATE_IDENTIFIER_START_SINGLE, $sText);
		$sText = str_replace("\\".TEMPLATE_IDENTIFIER_END_SINGLE, TEMPLATE_IDENTIFIER_END_SINGLE, $sText);
		$sText = str_replace("\\".TEMPLATE_KEY_VALUE_SEPARATOR, TEMPLATE_KEY_VALUE_SEPARATOR, $sText);
		$sText = str_replace("\\".TEMPLATE_PARAMETER_SEPARATOR, TEMPLATE_PARAMETER_SEPARATOR, $sText);
		return $sText;
	}

	public static function escapeIdentifier($sText) {
		$sText = str_replace("\\", "\\\\", $sText);
		$sText = str_replace(TEMPLATE_IDENTIFIER_START_SINGLE, "\\".TEMPLATE_IDENTIFIER_START_SINGLE, $sText);
		$sText = str_replace(TEMPLATE_IDENTIFIER_END_SINGLE, "\\".TEMPLATE_IDENTIFIER_END_SINGLE, $sText);
		$sText = str_replace(TEMPLATE_KEY_VALUE_SEPARATOR, "\\".TEMPLATE_KEY_VALUE_SEPARATOR, $sText);
		$sText = str_replace(TEMPLATE_PARAMETER_SEPARATOR, "\\".TEMPLATE_PARAMETER_SEPARATOR, $sText);
		return $sText;
	}

	public static function constructIdentifier($sName, $sValue = null, $aParameters=array()) {
		$aParametersCombined = array();
		foreach($aParameters as $sParameterName => $sParameterValue) {
			$aParametersCombined[] = $sParameterName.($sParameterValue!==self::PARAMETER_EMPTY_VALUE ? TEMPLATE_KEY_VALUE_SEPARATOR.self::escapeIdentifier($sParameterValue) : '');
		}
		return TEMPLATE_IDENTIFIER_START.$sName.($sValue!==self::PARAMETER_EMPTY_VALUE ? TEMPLATE_KEY_VALUE_SEPARATOR.self::escapeIdentifier($sValue) : '').(count($aParametersCombined)!==0 ? TEMPLATE_PARAMETER_SEPARATOR.implode(TEMPLATE_PARAMETER_SEPARATOR, $aParametersCombined) : '').TEMPLATE_IDENTIFIER_END;
	}

}
