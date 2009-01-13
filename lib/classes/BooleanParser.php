<?php
/**
 * class BooleanParser
 */
class BooleanParser
{
  private $aItems;

  private static $TRUE = "true";
  private static $FALSE = "false";
  private static $AND = "&";
  private static $OR = "|";
  private static $NOT = "!";

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
    if($sName === self::$TRUE || $sName === self::$FALSE) {
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
      if($sItem === self::$TRUE || $sItem === self::$FALSE || $sItem === self::$AND || $sItem === self::$OR || $sItem === self::$NOT) {
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
    return (($sValue === self::$TRUE) xor $bIsReversed);
  }

  public static function stringForBoolean($bValue, $bIsReversed=false) {
    return ($bValue xor $bIsReversed) ? self::$TRUE : self::$FALSE;
  }

  private function parseSimpleExpression($sExpression) {
    $aMatches = preg_split("/(\\".self::$OR."|".self::$NOT."|".self::$AND.")/", $sExpression, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
    return $aMatches;
  }

  private function executeStatement($aExpression) {
    $bValue = null;
    $sLastOperator = null;
    $bNextIsReversed = false;
    foreach($aExpression as $sExpressionItem) {
      switch($sExpressionItem) {
        case self::$TRUE:
        case self::$FALSE:
          switch($sLastOperator) {
            case self::$AND:
              $bValue = $bValue && self::booleanForString($sExpressionItem, $bNextIsReversed);
              break;
            case self::$OR:
              $bValue = $bValue || self::booleanForString($sExpressionItem, $bNextIsReversed);
              break;
            case null:
              $bValue = self::booleanForString($sExpressionItem, $bNextIsReversed);
              break;
          }
          $bNextIsReversed = false;
          break;
        case self::$NOT:
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