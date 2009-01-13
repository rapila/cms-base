<?php
/**
 * classname:   CalendarUtil
 */
class CalendarUtil {
  
  private static $MONTH_NAMES = array('de' => 
                                  array(1 => 'Januar',
                                        2 => 'Februar',
                                        3 => 'März',
                                        4 => 'April',
                                        5 => 'Mai',
                                        6 => 'Juni',
                                        7 => 'Juli',
                                        8 => 'August',
                                        9 => 'September',
                                        10 => 'Oktober',
                                        11 => 'November',
                                        12 => 'Dezember'
                                        )
                                      );
                                      
  public static function getMonthNameByMonthId($iMonthId, $sLanguageId=null) {
    $sLanguageId = $sLanguageId !== null ? $sLanguageId : Session::language();
    return self::$MONTH_NAMES[$sLanguageId][$iMonthId];
  }
}