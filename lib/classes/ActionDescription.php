<?php

/**
 * Describes a (schedulable) action
 */
class ActionDescription {
	const ACTION_DESCRIPTION_METHOD_PREFIX = 'describeAction';

	private $sName = null;
	private $sDescription = null;
	private $aParameters = [];

	private function __construct() {}

	public static function create($sKey = null) {
		$result = new ActionDescription();
		if($sKey) {
			$result->withKeyedName($sKey)->withKeyedDescription($sKey);
		}
		return $result;
	}

	public static function fromAction($sModelName, $sActionName) {
		$sDescriptionMethodName = self::ACTION_DESCRIPTION_METHOD_PREFIX.StringUtil::camelize($sActionName, true);
		if(is_callable("$sModelName::$sDescriptionMethodName")) {
			return $sModelName::$sDescriptionMethodName();
		} else {
			return self::create()->withName(StringUtil::makeReadableName($sActionName));
		}
}

	public function withName($sName) {
		$this->sName = $sName;
		return $this;
	}

	public function withKeyedName($sNameKey) {
		$this->sName = TranslationPeer::getString("wns.action.$sNameKey", null, StringUtil::makeReadableName($sNameKey));
		return $this;
	}

	public function withDescription($sDescription) {
		$this->sDescription = $sDescription;
		return $this;
	}

	public function withKeyedDescription($sDescriptionKey) {
		$this->sDescription = TranslationPeer::getString("wns.action.$sDescriptionKey.description", null, '');
		return $this;
	}

	public function addParameter(ActionParameterDescription ...$oParameters) {
		array_push($this->aParameters, ...$oParameters);
		return $this;
	}

	public function toJson() {
		$oContents = new stdClass();
		$oContents->name = $this->sName;
		$oContents->description = $this->sDescription;
		$oContents->parameters = array_map(function($oParameter) {
			return $oParameter->toJson();
		}, $this->aParameters);
		return $oContents;
	}

	public function getName() {
		return $this->sName;
	}

}

class ActionParameterDescription {
	private $oType;
	private $mDefaultValue;
	private $bAllowsNull = false;

	private $sName = null;
	private $sDescription = null;

	private function __construct(ActionParameterType $oType) {
		$this->oType = $oType;
	}

	public static function create(ActionParameterType $oType, $sKey = null) {
		$result = new ActionParameterDescription($oType);
		if($sKey) {
			$result->withKeyedName($sKey)->withKeyedDescription($sKey);
		}
		return $result;
	}
	
	public function withName($sName) {
		$this->sName = $sName;
		return $this;
	}

	public function withKeyedName($sNameKey) {
		$this->sName = TranslationPeer::getString("wns.action_param.$sNameKey", null, StringUtil::makeReadableName($sNameKey));
		return $this;
	}

	public function withDescription($sDescription) {
		$this->sDescription = $sDescription;
		return $this;
	}

	public function withKeyedDescription($sDescriptionKey) {
		$this->sDescription = TranslationPeer::getString("wns.action_param.$sDescriptionKey.description", null, '');
		return $this;
	}

	public function withDefaultValue($mDefaultValue) {
		$this->mDefaultValue = $mDefaultValue;
		return $this;
	}

	public function allowNull($bAllowsNull = true) {
		$this->bAllowsNull = $bAllowsNull;
		return $this;
	}

	public function toJson() {
		$oContents = new stdClass();
		$oContents->name = $this->sName;
		$oContents->description = $this->sDescription;
		$oContents->type = $this->oType->toJson();
		$oContents->defaultValue = $this->mDefaultValue;
		$oContents->allowsNull = $this->bAllowsNull;
		return $oContents;
	}
}

abstract class ActionParameterType {
	public function toJson() {
		$oContents = new stdClass();
		$oContents->type = $this->getType();
		$this->enhanceJson($oContents);
		return $oContents;
	}

	protected abstract function getType();
	protected function enhanceJson($oJson) {}
}

class ActionParameterStringType extends ActionParameterType {
	protected function getType() {
		return 'string';
	}

	private function __construct() {}
	public static function create() {
		return new ActionParameterStringType();
	}
}

class ActionParameterBooleanType extends ActionParameterType {
	protected function getType() {
		return 'boolean';
	}

	private function __construct() {}
	public static function create() {
		return new ActionParameterBooleanType();
	}
}

class ActionParameterNumberType extends ActionParameterType {
	protected function getType() {
		return 'number';
	}
	protected function enhanceJson($oContents) {
		$oContents->integer = $this->bIntegerOnly;
		$oContents->min = $this->iMin;
		$oContents->max = $this->iMax;
	}

	private $bIntegerOnly = false;
	private $iMin = null;
	private $iMax = null;

	private function __construct() {}
	public static function create() {
		return new ActionParameterNumberType();
	}

	public function withIntegerOnly($bIntegerOnly) {
		$this->bIntegerOnly = $bIntegerOnly;
		return $this;
	}

	public function withMin($iMin) {
		$this->iMin = $iMin;
		return $this;
	}

	public function withMax($iMax) {
		$this->iMax = $iMax;
		return $this;
	}
}

class ActionParameterChoiceType extends ActionParameterType {
	protected function getType() {
		return 'choice';
	}
	protected function enhanceJson($oContents) {
		$oContents->choice = $this->aChoices;
	}

	private $aChoices = [];

	private function __construct() {}
	public static function create() {
		return new ActionParameterChoiceType();
	}

	public function addChoice($sName, $mValue) {
		$oChoice = new stdClass();
		$oChoice->name = $sName;
		$oChoice->value = $mValue;
		$this->aChoices[] = $oChoice;
		return $this;
	}
}