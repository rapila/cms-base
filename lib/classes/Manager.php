<?php
/**
 * class Manager
 * abstract
 */
abstract class Manager {
  protected static $REQUEST_PATH = array();
  private static $USED_PATH = array();
  
  private static $CURRENT_PAGE = null;
  private static $CURRENT_MANAGER = null;
  
  protected function __construct() {
    if(strrpos(self::getRequestedPath(), "/") === (strlen(self::getRequestedPath())-1)) {
      self::setRequestedPath(substr(self::getRequestedPath(), 0, -1));
    }
    self::$REQUEST_PATH = (!self::getRequestedPath()) ? array() : explode("/", self::getRequestedPath());
    self::$CURRENT_MANAGER = $this;
  }
  
  public abstract function render();
  
  public static function getUsedPath() {
    return self::$USED_PATH;
  }
  
  public static function getRequestPath() {
    return self::$REQUEST_PATH;
  }
  
  public final function usePath() {
    $sPathItem = array_shift(self::$REQUEST_PATH);
    array_push(self::$USED_PATH, $sPathItem);
    return $sPathItem;
  }
  
  public final function unusePath() {
    $sPathItem = array_pop(self::$USED_PATH);
    array_unshift(self::$REQUEST_PATH, $sPathItem);
    return $sPathItem;
  }
  
  public function hasNextPathItem() {
    return isset(self::$REQUEST_PATH[0]);
  }
  
  public function peekNextPathItem() {
    return @self::$REQUEST_PATH[0];
  }
  
  public static function getRequestedPath() {
    return $_REQUEST['path'];
  }
  
  protected static function setRequestedPath($sNewPath) {
    $_REQUEST['path'] = $sNewPath;
  }
  
  public static function getPrefixForManager($sManagerName) {
    if($sManagerName instanceof Manager) {
      $sManagerName = get_class($sManagerName);
    }
    $sDefaultRoute = Settings::getSetting('routing', "default", "content");
    $aRoutes = Settings::getSetting('routing', "routes", array());
    foreach($aRoutes as $sRouteName => $sClassName) {
      if($sClassName == $sManagerName) {
        if($sDefaultRoute === $sRouteName) {
          return null;
        }
        return $sRouteName;
      }
    }
    return null;
  }

  public static function getManager() {
    $sDefaultRoute = Settings::getSetting('routing', "default", "content");
    $aRoutes = Settings::getSetting('routing', "routes", array());
    foreach($aRoutes as $sRouteName => $sClassName) {
      if(StringUtil::startsWith(self::getRequestedPath(), $sRouteName.'/') || (StringUtil::endsWith(self::getRequestedPath(), $sRouteName) && StringUtil::startsWith(self::getRequestedPath(), $sRouteName))) {
        self::setRequestedPath(substr(self::getRequestedPath(), strlen($sRouteName.'/')));
        new $sClassName();
        return self::$CURRENT_MANAGER;
      }
    }
    $sClassName = $aRoutes[$sDefaultRoute];
    new $sClassName();
    return self::$CURRENT_MANAGER;
  }

  public static function getCurrentPrefix() {
    return self::getPrefixForManager(self::$CURRENT_MANAGER);
  }

  public static function getCurrentPage() {
    return self::$CURRENT_PAGE;
  }
  
  public static function isPost($sMethod = 'POST') {
    return $_SERVER['REQUEST_METHOD'] === $sMethod;
  }
  
  public static function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest";
  }
  
  public static function isXMLHttpRequest() {
    return self::isAjaxRequest();
  }

  public static function getCurrentManager() {
    return self::$CURRENT_MANAGER;
  }

  protected static function setCurrentPage($oCurrentPage) {
    self::$CURRENT_PAGE = $oCurrentPage;
  }

  public static function shouldIncludeLanguageInLink() {
    return false;
  }
  
  public static function listManagers() {
    $aResult = array_keys(ResourceFinder::findResourceByExpressions(array('classes', "/(\w+)Manager.php/")));
    foreach($aResult as $iKey => $sValue) {
      $aResult[$iKey] = substr($sValue, strrpos($sValue, '/')+1, 0-strlen('.php'));
    }
    return $aResult;
  }

  public static function getManagerClassNormalized($mManager = null) {
    if($mManager === null) {
      return self::getCurrentManager();
    }
    if(is_object($mManager)) {
      return get_class($mManager);
    }
    return $mManager;
  }
}
