<?php

abstract class SystemPart {
	protected $sPrefix;
	protected $aInfo;
	protected $aDependees;
	
	protected function __construct($sPrefix, $aInfo = null) {
		$this->sPrefix = $sPrefix;
		$this->aInfo = $aInfo;
		$this->aDependees = new SplObjectStorage();

		$aPrefix = explode('/', $sPrefix);
	}
	
	/**
	* Returns info schema. Either given at construction time, loaded from YAML or generated on-the-fly
	*/
	public function getInfo() {
		if($this->aInfo === null) {
			$sInfoFilePath = ResourceFinder::create($this->sPrefix)->mainOnly()->addPath(FILENAME_INFO)->find();
			if($sInfoFilePath) {
				require_once(BASE_DIR.'/'.DIRNAME_LIB.'/'.DIRNAME_VENDOR.'/'."spyc/Spyc.php");
				$this->aInfo = Spyc::YAMLLoad($sInfoFilePath);
			} else {
				$this->aInfo = array();
			}
			if(!isset($this->aInfo['name'])) {
				$this->aInfo['name'] = implode(' ', explode('/', $this->sPrefix));
			}
			if(!isset($this->aInfo['dependencies'])) {
				$this->aInfo['dependencies'] = array();
			}
		}
		return $this->aInfo;
	}
	
	public function setInfo($aInfo) {
		$this->aInfo = $aInfo;
	}
	
	public function dependOn($oPart) {
		$oPart->addDependee($this);
		return $this;
	}
	
	public function addDependee(SystemPart $oDependee) {
		$this->aDependees->attach($oDependee);
		return $this;
	}
	
	public function getPrefix() {
		return $this->sPrefix;
	}
	
	public function getDependees() {
		return $this->aDependees;
	}
	
	public function __sleep() {
		$aObjects = array();
		$this->aDependees->rewind();
		while($this->aDependees->valid()) {
			$aObjects[] = $this->aDependees->current();
			$this->aDependees->next();
		}
		$this->aDependees = $aObjects;
		return array_keys(get_object_vars($this));
	}
	
	public function __wakeup() {
		$aObjects = $this->aDependees;
		$this->aDependees = new SplObjectStorage();
		foreach($aObjects as $oDependee) {
			$this->aDependees->attach($oDependee);
		}
	}

	public static function getPart($sPrefix, $aInfo = null) {
		$aPrefix = explode('/', $sPrefix);
		if($aPrefix[0] === DIRNAME_BASE) {
			return new BasePart($aInfo);
		}
		if($aPrefix[0] === DIRNAME_PLUGINS) {
			return new PluginPart($aPrefix[1], $aInfo);
		}
		if($aPrefix[0] === DIRNAME_SITE) {
			return new SitePart($aInfo);
		}
		if($aPrefix[0] === 'test') {
			return new TestPart($aPrefix[1]);
		}
		throw new Exception("$aPrefix[0] is not a valid system part prefix");
	}
	
	public static function orderedParts($aParts) {
		$aOrderedParts = array();

		$aMarked = new SplObjectStorage();
		$aTemporarilyMarked = new SplObjectStorage();

		$cVisit = null;
		$cVisit = function(SystemPart $oPart) use ($aMarked, $aTemporarilyMarked, &$aOrderedParts, &$cVisit) {
			if($aTemporarilyMarked->contains($oPart)) {
				throw new Exception('Detected cyclic plugin references to '.$oPart->getPrefix());
			}
			if($aMarked->contains($oPart)) {
				// Visited already
				return;
			}

			$aTemporarilyMarked->attach($oPart);
			foreach($oPart->getDependees() as $oDependeePart) {
				$cVisit($oDependeePart);
			}
			$aMarked->attach($oPart);
			$aTemporarilyMarked->detach($oPart);

			array_unshift($aOrderedParts, $oPart);
		};
		foreach($aParts as $oPart) {
			$cVisit($oPart);
		}
		return $aOrderedParts;
	}
	
	public static function allParts() {
		$oCache = new Cache("system_parts", DIRNAME_CONFIG);
		if($oCache->cacheFileExists()) {
			return $oCache->getContentsAsVariable();
		}
		$oBasePart = new BasePart();
		$oSitePart = new SitePart();
		$aParts = array(DIRNAME_BASE => $oBasePart);
		// Get all plugins
		foreach(ResourceFinder::pluginFinder()->returnObjects()->find() as $oPath) {
			$oPluginPart = SystemPart::getPart($oPath->getRelativePath());
			// Plugins depend on base implicitly
			$oPluginPart->dependOn($oBasePart);
			// Site depends on plugins implicitly
			$oSitePart->dependOn($oPluginPart);
			$aParts[$oPath->getRelativePath()] = $oPluginPart;
		}
		$oSitePart->dependOn($oBasePart);
		$aParts[DIRNAME_SITE] = $oSitePart;
		// Add dependencies from info
		foreach($aParts as $oPart) {
			$aInfo = $oPart->getInfo();
			foreach($aInfo['dependencies'] as $sDependencyPrefix => $sVersion) {
				if(isset($aParts[$sDependencyPrefix])) {
					$oPart->dependOn($aParts[$sDependencyPrefix]);
				} else {
					throw new Exception("Dependency of {$oPart->getPrefix()} on $sDependencyPrefix can not be satisfied");
				}
			}
		}
		// Order list by dependencies
		$aParts = self::orderedParts($aParts);
		// Cache ordered list
		$oCache->setContents($aParts);
		return $aParts;
	}
}

class BasePart extends SystemPart {
	public function __construct($aInfo = null) {
		parent::__construct(DIRNAME_BASE, $aInfo, array(DIRNAME_SITE));
	}
}

class SitePart extends SystemPart {
	public function __construct($aInfo = null) {
		parent::__construct(DIRNAME_SITE, $aInfo);
	}
}

class PluginPart extends SystemPart {
	public function __construct($sPluginName, $aInfo = null) {
		parent::__construct(DIRNAME_PLUGINS."/$sPluginName", $aInfo, array(DIRNAME_SITE));
	}
	
	public static function allPlugins() {
		return array_filter(SystemPart::allParts(), function($oPart) {
			return $oPart instanceof PluginPart;
		});
	}
}

class TestPart extends SystemPart {
	public function __construct($sTestName) {
		parent::__construct("test/$sTestName", array());
	}
}