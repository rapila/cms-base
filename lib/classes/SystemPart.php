<?php

abstract class SystemPart {
	private static $PARTS = null;
	
	private $sPrefix;
	private $aInfo;
	private $aDependees;
	
	protected function __construct($sPrefix, $aImpliedDependees = array()) {
		$this->sPrefix = $sPrefix;
		$aPrefix = explode('/', $sPrefix);
		$sInfoFilePath = ResourceFinder::create($aPrefix)->mainOnly()->addPath(Module::INFO_FILE)->find();
		if($sInfoFilePath) {
			require_once("spyc/Spyc.php");
			$this->aInfo = Spyc::YAMLLoad($sInfoFilePath);
		} else {
			$this->aInfo = array();
		}
		if(!isset($this->aInfo['name'])) {
			$this->aInfo['name'] = implode(' ', $aPrefix);
		}
		if(!isset($this->aInfo['dependencies'])) {
			$this->aInfo['dependencies'] = array();
		}
		$this->aDependees = array();
		foreach($aImpliedDependees as $sDependeePrefix) {
			$this->addDependee(self::getPart($sDependeePrefix));
		}
	}
	
	public function resolveDependencies() {
		foreach($this->aInfo['dependencies'] as $sDependencyPrefix => $sDependencyVersion) {
			self::getPart($sDependencyPrefix)->addDependee($this);
		}
	}
	
	public function addDependee(SystemPart $oDependee) {
		$this->aDependees[] = $oDependee;
	}
	
	private static function init() {
		if(!self::$PARTS) {
			// FIXME: Cache the parts array?
			self::$PARTS = array();
		}
	}
	
	private static function createPart($sPrefix) {
		$aPrefix = explode('/', $sPrefix);
		if($aPrefix[0] === DIRNAME_BASE) {
			return new BasePart();
		}
		if($aPrefix[0] === DIRNAME_PLUGINS) {
			return new PluginPart($aPrefix[1]);
		}
		if($aPrefix[0] === DIRNAME_SITE) {
			return new SitePart();
		}
		throw new Exception("$aPrefix[0] is not a valid system part prefix");
	}
	
	public static function getPart($sPrefix) {
		self::init();
		if(!isset(self::$PARTS[$sPrefix])) {
			self::$PARTS[$sPrefix] = self::createPart($sPrefix);
		}
		return self::$PARTS[$sPrefix];
	}
}

class BasePart extends SystemPart {
	public function __construct() {
		parent::__construct(DIRNAME_BASE, array(DIRNAME_SITE));
	}
}

class PluginPart extends SystemPart {
	public function __construct($sPluginName) {
		parent::__construct(DIRNAME_PLUGINS."/$sPluginName", array(DIRNAME_SITE));
	}
}

class SitePart extends SystemPart {
	public function __construct() {
		parent::__construct(DIRNAME_SITE);
	}
}