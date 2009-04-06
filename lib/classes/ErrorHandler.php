<?php
class ErrorHandler {
  public static function handleError($iErrorNumber, $sErrorString, $sErrorFile, $iErrorLine, $aErrorContext) {
    if(error_reporting() === 0 || $iErrorNumber === E_STRICT) {
      return false;
    }
    self::handle(array( "number" => $iErrorNumber,
                        "message" => $sErrorString,
                        "filename" => $sErrorFile,
                        "line" => $iErrorLine,
                        "context" => $aErrorContext), !self::shouldContinue($iErrorNumber));
    if(self::shouldContinue($iErrorNumber)) {
      return true;
    }
    die("An Error occured, exiting");
  }
  
  public static function handleException($oException) {
    self::handle($oException);
  }
  
  public static function shouldPrintErrors() {
    return Settings::getSetting('general', 'environment', 'production') === "developer";
  }
  
  public static function shouldLogErrors() {
    return Settings::getSetting('general', 'environment', 'production') === "test";
  }
  
  public static function shouldMailErrors() {
    return Settings::getSetting('general', 'environment', 'production') === "production";
  }
  
  private static function shouldContinue($iErrorNumber) {
    if(self::shouldPrintErrors()) {
      return $iErrorNumber !== E_ERROR;
    } else {
      return false;
    }
  }
  
  private static function handle($aError, $bIsFatal = true) {
    if(self::shouldPrintErrors()) {
      if($bIsFatal) {
        Util::dumpAll($aError);
      } else {
        var_dump($aError);
      }
    }
    if(self::shouldLogErrors()) {
      if(is_writable(MAIN_DIR.'/error.log')) {
        file_put_contents(MAIN_DIR.'/error.log', "Error in Mini-CMS on ".LinkUtil::linkToSelf()."\n[HTTP_REFERER] ".$_SERVER['HTTP_REFERER']."\n".print_r($aError, true));
      } else {
        die("Error could not be logged, ".MAIN_DIR.'/error.log is not writable');
      }
    }
    if(self::shouldMailErrors()) {
      $sAddress = Settings::getSetting('developer', 'email', false);
      if(!$sAddress) {
        $sAddress = Settings::getSetting('domain_holder', 'email', false);
      }
      if($sAddress) {
        mb_send_mail($sAddress, "Error in Mini-CMS on ".LinkUtil::linkToSelf(), "[HTTP_REFERER] ".@$_SERVER['HTTP_REFERER']."\n".print_r($aError, true));
      }
    }
  }
}