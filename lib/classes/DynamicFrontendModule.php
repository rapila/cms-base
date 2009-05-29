<?php
/**
 */
abstract class DynamicFrontendModule extends FrontendModule {
  public static function isDynamic() {
    return true;
  }
  
  public static function acceptedRequestParams() {
    return array();
  }
}
