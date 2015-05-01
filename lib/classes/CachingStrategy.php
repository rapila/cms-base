<?php
/**
 * Represents one file in the cache, identified by the dirname and the key (generated/caches/<dir>/<md5(key)>.cache).
*/
abstract class CachingStrategy {
	private static $NAMED_STRATEGIES = array();
	
	// Initialization
	
	private $bIsInitialized = false;

	/**
	* Default constructor. Does not need to be overridden by most implementations.
	*/
	public function __construct() {}
	
	/**
	* Called when all options have been set.
	*/
	public function init($aOptions = array()) {
		foreach($aOptions as $sKey => $mValue) {
			$this->setOption($sKey, $mValue);
		}
		$this->bIsInitialized = true;
	}
	
	/**
	* Sets an option (if applicable).
	*/
	public function setOption($sKey, $mValue) {
		if($this->bIsInitialized) {
			throw new Exception('Caching strategy already initialized');
		}
		if(property_exists($this, $sKey)) {
			$this->$sKey = $mValue;
		}
	}

	protected function replaceOption(Cache $oCache, $sOption) {
		return str_replace(array('${module}', '${key}'), array($oCache->getModule(), $this->encodedKey($oCache)), $sOption);
	}
	
	public function encodedKey(Cache $oCache) {
		$sKey = $oCache->getKey();
		if($this->key_encode) {
			$sKey = call_user_func($this->key_encode, $sKey);
		}
		return $sKey;
	}
	
	// Universal options
	protected $respect_cache_control_headers = true;
	protected $send_not_modified_response = true;
	protected $expires = null;
	protected $nocache_param = 'nocache';
	protected $key_encode = null;

	// API
	
	public abstract function exists(Cache $oCache);
	public abstract function read(Cache $oCache);
	public function readData(Cache $oCache) {
		return unserialize($this->read($oCache));
	}
	public function pass(Cache $oCache) {
		print $this->read($oCache, true);
	}
	public abstract function write(Cache $oCache, $sEntry, $bAppend = false);
	public function writeData(Cache $oCache, $mEntry) {
		$this->write($oCache, serialize($mEntry), false);
	}
	public abstract function date(Cache $oCache);
	public function size(Cache $oCache) {
		return null;
	}
	
	public function cacheIsOffForWriting() {
		return false;
	}
	
	public function cacheIsOff() {
		if($this->cacheIsOffForWriting()) {
			return true;
		}
		if($this->nocache_param && isset($_REQUEST[$this->nocache_param])) {
			return true;
		}
		if($this->respect_cache_control_headers && isset($_SERVER['HTTP_CACHE_CONTROL']) && stristr($_SERVER['HTTP_CACHE_CONTROL'], "no-cache") !== FALSE && $_SERVER['REQUEST_METHOD'] !== 'POST') {
			return true;
		}
		return false;
	}
	
	public function expiresTimestamp() {
		return $this->expires;
	}
	
	public function supportsNotModified() {
		return $this->send_not_modified_response;
	}
	
	public function clearCaches() {
		// Default implementation: do nothing
	}
	
	public function __clone() {
		$this->bIsInitialized = false;
	}
	
	// Creation helpers

	/**
	* Creates a caching strategy with the given options.
	*/
	static public function create($aOptions = array()) {
		$sSelf = get_called_class();
		$oResult = new $sSelf();
		$oResult->init($aOptions);
		return $oResult;
	}

	/**
	* Returns the strategy applicable for a certain modules as determined by the config.
	*/
	static public function forModule($sModule) {
		// TODO Deprecated, remove soon
		if(Settings::getSetting('general', 'caching', true) === false) {
			return CachingStrategyNone::create();
		}
		$sType = Settings::getSetting('modules', $sModule, null, 'caching');
		if($sType === null) {
			$sType = Settings::getSetting('modules', '_default', 'file', 'caching');
		}
		return self::fromConfig($sType);
	}

	/**
	* Returns a named strategy as declared in the config.
	*/
	static public function fromConfig($sType) {
		if(!isset(self::$NAMED_STRATEGIES[$sType])) {
			$aConfig = Settings::getSetting('strategies', $sType, null, 'caching');
			$sClass = $aConfig['class'];
			$aOptions = Settings::getSetting('options', null, array(), 'caching');
			if(isset($aConfig['options'])) {
				$aOptions = array_merge($aOptions, $aConfig['options']);
			}
			self::$NAMED_STRATEGIES[$sType] = $sClass::create($aOptions);
		}
		return self::$NAMED_STRATEGIES[$sType];
	}
	
	/**
	* Returns an array of all strategy instances declared in the config.
	*/
	static public function configuredStrategies() {
		$aResult = array();
		$aStrategies = Settings::getSetting('strategies', null, array(), 'caching');
		foreach($aStrategies as $sName => $aConfig) {
			$aResult[] = self::fromConfig($sName);
		}
		return $aResult;
	}
}
