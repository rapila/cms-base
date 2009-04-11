<?php
/**
 * classname:   ListUtil
 */
class ListUtil {
  const SELECT_ALL = '__all';
  
  public static function getSelectedListFilter($sRequestName = 'selected_name_id', $bNumericToInt=true, $sPresetValue=null, $sDefaultReturn=null) {
    if(isset($_REQUEST[$sRequestName])) {

      $mSelectedValue = $_REQUEST[$sRequestName];
      if($mSelectedValue === self::SELECT_ALL || $mSelectedValue === '') {
        $mSelectedValue = $sDefaultReturn;
      } else if(is_numeric($mSelectedValue) && $bNumericToInt) {
        $mSelectedValue= (int) $mSelectedValue;
      }
      Session::getSession()->setAttribute($sRequestName, $mSelectedValue);
      return $mSelectedValue;
    } else {
      return (Session::getSession()->getAttribute($sRequestName) ? Session::getSession()->getAttribute($sRequestName) : $sPresetValue);
    }
  }
}