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
  
  /**
  * Prepends an element/multiple elements to the beginning of the associative array
  * Usage: assocUnshift($array, $key1, value1, key2, value2, …)
  * 
  * If multiple elements are passed, they end up being in the order in which they are given
  * Example: assocUnshift($array, 'zero', 0, 'one', 1) will result in $array being array('zero' => 0, 'one' => 1, …)
  */
  public static function assocUnshift(&$aArray) {
    $aArray = array_reverse($aArray, true);
    for($i=func_num_args()-1;$i>=1;$i-=2) {
      unset($aArray[func_get_arg($i-1)]);
      $aArray[func_get_arg($i-1)] = func_get_arg($i);
    }
    $aArray = array_reverse($aArray, true);
  }
  
  public static function assocPeek(&$aArray) {
    $mKey = self::assocKeyPeek($aArray);
    if($mKey === null) {
      return null;
    }
    return $aArray[$mKey];
  }
  
  public static function assocKeyPeek(&$aArray) {
    $mKey = array_keys($aArray);
    if(!isset($mKey[0])) {
      return null;
    } $mKey = $mKey[0];
    return $mKey;
  }

  public static function arrayWithValuesAsKeys($aArray) {
    $aValues = array_values($aArray);
    return array_combine($aValues, $aValues);
  }
}