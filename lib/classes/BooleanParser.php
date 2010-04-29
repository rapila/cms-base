<?php
/**
 * class BooleanParser
 */
class BooleanParser
{
	private $aItems;

	const BP_TRUE = "true";
	const BP_FALSE = "false";
	const BP_AND = "&";
	const BP_OR = "|";
	const BP_NOT = "!";

	public function __construct($aItems = null)
	{
		if($aItems == null) {
			$aItems = array();
		}
		$this->aItems = $aItems;
	}

	public function __get($sName)
	{
		return $this->aItems[$sName];
	}

	public function __set($sName, $sValue)
	{
		if($sName === self::BP_TRUE || $sName === self::BP_FALSE) {
			throw new Exception("Error in BooleanParser->__set: invalid key");
		}
		if(!is_bool($sValue)) {
			$sValue = $sValue == true;
		}
		$this->aItems[$sName] = $sValue;
		return true;
	}

	public function __isset($sName)
	{
		return isset($this->aItems[$sName]);
	}

	public function __unset($sName)
	{
		unset($this->aItems[$sName]);
	}

	public function parse($sQuery) {
		//Test the query for validity
		$iBracesCounter = 0;
		$iLength=strlen($sQuery);
		for($i=0;$i<$iLength;$i++) {
			$cCurrent = substr($sQuery, $i, 1);
			switch($cCurrent) {
				case "(":
					$iBracesCounter++;
					break;
				case ")":
					$iBracesCounter--;
					break;
			}
			if($iBracesCounter < 0) {
				throw new Exception("Error in BooleanParser->parse: query not well-formed");
			}
		}

		if($iBracesCounter != 0) {
			throw new Exception("Error in BooleanParser->parse: query not well-formed");
		}

		while(strpos($sQuery, "(") !== false) {
			$aBrace = $this->getInnermostBrace($sQuery);
			$sResult = $this->booleanTextForSimpleExpression($aBrace['inner_query']);
			$sQuery = substr_replace($sQuery, $sResult, $aBrace['start'], $aBrace['length']);
		}

		return $this->booleanForSimpleExpression($sQuery);
	}

	private function replaceVarsWithBooleanValues($aExpression) {
		foreach($aExpression as $iKey => $sItem) {
			if($sItem === self::BP_TRUE || $sItem === self::BP_FALSE || $sItem === self::BP_AND || $sItem === self::BP_OR || $sItem === self::BP_NOT) {
				continue;
			}
			if(!$this->__isset($sItem)) {
				throw new Exception("Error in BooleanParser->replaceByValue: $sItem was never set");
			}
			$aExpression[$iKey] = self::stringForBoolean($this->$sItem);
		}
		return $aExpression;
	}

	private function getInnermostBrace($sQuery) {
		//Test the query for validity
		$iBraceStartPosition = null;
		$iLastBracesCounter = 0;
		$iBracesCounter = 0;
		$iLength=strlen($sQuery);
		for($i=0;$i<$iLength;$i++) {
			$cCurrent = substr($sQuery, $i, 1);
			switch($cCurrent) {
				case "(":
					$iBracesCounter++;
					break;
				case ")":
					$iBracesCounter--;
					break;
			}

			if($iBracesCounter > $iLastBracesCounter) {
				$iLastBracesCounter = $iBracesCounter;
				$iBraceStartPosition = $i;
			}

		}

		if($iBraceStartPosition === null) {
			return array("start" => 0, "length" => strlen($sQuery), "inner_query" => $sQuery);
		}

		$iBraceStartPosition++;

		$iInnerQueryLength = strpos($sQuery, ")", $iBraceStartPosition)-$iBraceStartPosition;

		return array("start" => $iBraceStartPosition-1, "length" => $iInnerQueryLength+2, "inner_query" => substr($sQuery, $iBraceStartPosition, $iInnerQueryLength));
	}

	public static function booleanForString($sValue, $bIsReversed=false) {
		return (($sValue === self::BP_TRUE) xor $bIsReversed);
	}

	public static function stringForBoolean($bValue, $bIsReversed=false) {
		return ($bValue xor $bIsReversed) ? self::BP_TRUE : self::BP_FALSE;
	}

	private function parseSimpleExpression($sExpression) {
		$aMatches = preg_split("/(\\".self::BP_OR."|".self::BP_NOT."|".self::BP_AND.")/", $sExpression, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
		return $aMatches;
	}

	private function executeStatement($aExpression) {
		$bValue = null;
		$sLastOperator = null;
		$bNextIsReversed = false;
		foreach($aExpression as $sExpressionItem) {
			switch($sExpressionItem) {
				case self::BP_TRUE:
				case self::BP_FALSE:
					switch($sLastOperator) {
						case self::BP_AND:
							$bValue = $bValue && self::booleanForString($sExpressionItem, $bNextIsReversed);
							break;
						case self::BP_OR:
							$bValue = $bValue || self::booleanForString($sExpressionItem, $bNextIsReversed);
							break;
						case null:
							$bValue = self::booleanForString($sExpressionItem, $bNextIsReversed);
							break;
					}
					$bNextIsReversed = false;
					break;
				case self::BP_NOT:
					$bNextIsReversed = !$bNextIsReversed;
					break;
				default:
					$sLastOperator = $sExpressionItem;
					break;
			}
		}
		return $bValue;
	}

	private function booleanTextForSimpleExpression($sExpression) {
		return self::stringForBoolean($this->booleanForSimpleExpression($sExpression));
	}

	private function booleanForSimpleExpression($sExpression) {
		$aExpression = $this->parseSimpleExpression($sExpression);
		$aExpression = $this->replaceVarsWithBooleanValues($aExpression);
		return $this->executeStatement($aExpression);
	}
} // class BooleanParser