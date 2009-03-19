<?php
/**
 * classname:   CalendarUtil
 */
class CalendarUtil {
  
  private static $MONTH_NAMES = array('de' => 
                                  array(1 => array('long'=> 'Januar',   'short' => 'Jan'),
                                        2 => array('long'=> 'Februar',  'short' => 'Feb'),
                                        3 => array('long'=> 'März',     'short' => 'März'),
                                        4 => array('long'=> 'April',    'short' => 'April'),
                                        5 => array('long'=> 'Mai',      'short' => 'Mai'),
                                        6 => array('long'=> 'Juni',     'short' => 'Juni'),
                                        7 => array('long'=> 'Juli',     'short' => 'Juli'),
                                        8 => array('long'=> 'August',   'short' => 'Aug.'),
                                        9 => array('long'=> 'September','short' => 'Sept.'),
                                        10 => array('long'=> 'Oktober', 'short' => 'Okt.'),
                                        11 => array('long'=> 'November','short' => 'Nov.'),
                                        12 => array('long'=> 'Dezember','short' => 'Dez.')
                                        )
                                      );
                                      
  public static function getMonthNameByMonthId($iMonthId, $sLanguageId=null, $sType='long') {
    $sLanguageId = $sLanguageId !== null ? $sLanguageId : Session::language();
    return self::$MONTH_NAMES[$sLanguageId][$iMonthId][$sType];
  }
}