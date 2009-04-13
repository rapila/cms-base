<?php
/**
 * @package utils
 */

class ArrayUtil {
  public static function runFunctionOnArrayValues(&$aArray, $mCallback) {
    $aShortenedArgs = func_get_args();
    $aShortenedArgs = array_slice($aShortenedArgs, 2);
    foreach($aArray as $mKey => $mValue) {
      if(is_string($mValue))
      {
        $aArray[$mKey] = call_user_func_array($mCallback, array_merge(array($mValue), $aShortenedArgs));
      } else if(is_array($mValue)) {
        $aArray[$mKey] = call_user_func_array(array("ArrayUtil", 'runFunctionOnArrayValues'), array_merge(array($mValue), array($mCallback), $aShortenedArgs));
      }
    }
    return $aArray;
  }

  public static function trimStringsInArray(&$aArray) {
    return self::runFunctionOnArrayValues($aArray, 'trim');
  }
  
  public static function arrayIsAssociative(&$aArray) {
    if (!is_array($aArray) || empty($aArray) ) {
      return false;
    }
    foreach (array_keys($aArray) as $mKey => $mValue) {
      if ($mKey !== $mValue) { 
        return true;
      }
    }
    return false;
  }

  public static function setEmptyArrayValuesToNull(&$aArray) {
    return self::runFunctionOnArrayValues($aArray, create_function('$mValue', 'return $mValue === "" ? null : $mValue;'));
  }
  
  public static function inArray($mScalar, $aArray, $bStrict = true, $sKeyMethod = null) {
    if(in_array($mScalar, $aArray, $bStrict)) {
      return true;
    }
    foreach($aArray as $mValue) {
      if(Util::equals($mScalar, $mValue, $sKeyMethod)) {
        return true;
      }
    }
    return false;
  }

  public static function arrayWithValuesAsKeys($aArray) {
    $aValues = array_values($aArray);
    return array_combine($aValues, $aValues);
  }
}