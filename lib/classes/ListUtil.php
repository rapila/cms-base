<?php
/**
 * @package utils
 */
 
class ListUtil {
  /**
  * handleBackendChooserListSelection()
  * @param string request name
  * @param boolean numeric to int, default: true
  * @param string preset value if nothing is selected, default: null
  * @param string $sDefaultReturn if all entries are required, default: null
  * 
  * @return mixed int|str|null
  */
  public static function handleBackendChooserListSelection($sRequestName = 'selected_name_id', $bNumericToInt = true, $sPresetValue = null, $sDefaultReturn = null) {
    if(isset($_REQUEST[$sRequestName])) {
      $mSelectedValue = $_REQUEST[$sRequestName];
      if($mSelectedValue === ListHelper::SELECT_ALL || $mSelectedValue === '') {
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