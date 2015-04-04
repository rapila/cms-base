<?php
/**
 * class Manager
 * abstract
 */
abstract class Manager {
	protected static $REQUEST_PATH = array();
	protected static $CURRENT_MANAGER = null;

	private static $USED_PATH = array();
	private static $ORIGINAL_PATH = null;
	private static $ROUTE_CONFIG = null;

	protected function __construct() {
		if(StringUtil::endsWith(self::getRequestedPath(), "/")) {
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

	public static final function usePath() {
		$sPathItem = array_shift(self::$REQUEST_PATH);
		if($sPathItem !== null) {
			self::$USED_PATH[] = $sPathItem;
		}
		return $sPathItem;
	}

	public static final function unusePath() {
		$sPathItem = array_pop(self::$USED_PATH);
		if($sPathItem !== null) {
			array_unshift(self::$REQUEST_PATH, $sPathItem);
		}
		return $sPathItem;
	}

	public static function hasNextPathItem() {
		return isset(self::$REQUEST_PATH[0]);
	}

	public static function peekNextPathItem() {
		return @self::$REQUEST_PATH[0];
	}

	public static function getRequestedPath() {
		return $_REQUEST['path'];
	}

	protected static function setRequestedPath($sNewPath) {
		$_REQUEST['path'] = $sNewPath;
	}

	public static function getOriginalPath() {
		return self::$ORIGINAL_PATH;
	}
	
	public static function routeConfig() {
		if(self::$ROUTE_CONFIG === null) {
			self::$ROUTE_CONFIG = new stdClass();
			self::$ROUTE_CONFIG->default = Settings::getSetting('defaults', 'empty_route', 'content', 'routing');
			self::$ROUTE_CONFIG->routes = array();
			$aRoutes = Settings::getSetting('routes', null, array(), 'routing');
			foreach($aRoutes as $sRouteName => $sClassName) {
				// Allow overrides to remove routes
				if($sClassName === null) {
					continue;
				}
				self::$ROUTE_CONFIG->routes[$sRouteName] = $sClassName;
			}
		}
		return self::$ROUTE_CONFIG;
	}

	public static function getPrefixForManager($sManagerName) {
		if($sManagerName instanceof Manager) {
			$sManagerName = get_class($sManagerName);
		}
		$oRouteConfig = self::routeConfig();
		if($oRouteConfig->default === $sManagerName) {
			return null;
		}
		foreach($oRouteConfig->routes as $sRouteName => $sClassName) {
			if($sClassName == $sManagerName) {
				return $sRouteName;
			}
		}
		throw new LocalizedException("wns.route_missing", array('class' => $sManagerName));
	}

	public static function getManager() {
		self::$ORIGINAL_PATH = self::getRequestedPath();

		$oRouteConfig = self::routeConfig();
		foreach($oRouteConfig->routes as $sRouteName => $sClassName) {
			if(StringUtil::startsWith(self::getRequestedPath(), $sRouteName.'/') || (StringUtil::endsWith(self::getRequestedPath(), $sRouteName) && StringUtil::startsWith(self::getRequestedPath(), $sRouteName))) {
				self::setRequestedPath(substr(self::getRequestedPath(), strlen($sRouteName.'/')));
				if(self::getRequestedPath() === false) {
					self::setRequestedPath('');
				}
				new $sClassName();
				return self::$CURRENT_MANAGER;
			}
		}
		$sClassName = $oRouteConfig->default;
		new $sClassName();
		return self::$CURRENT_MANAGER;
	}

	public static function getCurrentPrefix() {
		return self::getPrefixForManager(self::$CURRENT_MANAGER);
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

	public static function shouldIncludeLanguageInLink() {
		return false;
	}

	public static function listManagers() {
		$aResult = array();
		foreach(ResourceFinder::findAllResourceObjectsByExpressions(array('classes', "/(\w+)Manager.php/")) as $oResource) {
			$aResult[$oResource->getRelativePath()] = $oResource->getFileName('.php');
		}
		return $aResult;
	}

	public static function getManagerClassNormalized($mManager = null) {
		if($mManager === null) {
			$mManager = self::getCurrentManager();
		}
		if($mManager instanceof Manager) {
			return get_class($mManager);
		}
		return $mManager;
	}
}
