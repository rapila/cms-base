<?php

abstract class SystemPart {
	private static $PARTS = null;
	
	private $sPrefix;
	private $aInfo;
	private $aDependees;
	
	protected function __construct($sPrefix, $aInfo = array(), $aImpliedDependees = array()) {
		$this->sPrefix = $sPrefix;
		$this->aInfo = $aInfo;
		$this->aDependees = new SplObjectStorage();

		$aPrefix = explode('/', $sPrefix);

		if(!isset($this->aInfo['name'])) {
			$this->aInfo['name'] = implode(' ', $aPrefix);
		}
		if(!isset($this->aInfo['dependencies'])) {
			$this->aInfo['dependencies'] = array();
		}

		foreach($aImpliedDependees as $sDependeePrefix) {
			$this->addDependee(self::getPart($sDependeePrefix));
		}
	}
	
	private function resolveDependencies() {
		foreach($this->aInfo['dependencies'] as $sDependencyPrefix => $sDependencyVersion) {
			self::getPart($sDependencyPrefix)->addDependee($this);
		}
	}
	
	public function addDependee(SystemPart $oDependee) {
		$this->aDependees->attach($oDependee);
	}
	
	public function getPrefix() {
		return $this->sPrefix;
	}
	
	public function getDependees() {
		return $this->aDependees;
	}
	
	private static function init() {
		if(!self::$PARTS) {
			// FIXME: Cache the parts array?
			self::$PARTS = array();
		}
	}
	
	public static function reset() {
		self::$PARTS = null;
	}
	
	private static function createPart($sPrefix, $aInfo = null) {
		$aPrefix = explode('/', $sPrefix);
		if($aInfo === null) {
			$sInfoFilePath = ResourceFinder::create($aPrefix)->mainOnly()->addPath(Module::INFO_FILE)->find();
			if($sInfoFilePath) {
				require_once("spyc/Spyc.php");
				$aInfo = Spyc::YAMLLoad($sInfoFilePath);
			} else {
				$aInfo = array();
			}
		}
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
			return new TestPart($aPrefix[1], $aInfo);
		}
		throw new Exception("$aPrefix[0] is not a valid system part prefix");
	}
	
	public static function getPart($sPrefix, $aInfo = null) {
		self::init();
		if(!isset(self::$PARTS[$sPrefix])) {
			self::$PARTS[$sPrefix] = self::createPart($sPrefix, $aInfo);
		}
		return self::$PARTS[$sPrefix];
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
			$oPart->resolveDependencies();
		}
		foreach($aParts as $oPart) {
			$cVisit($oPart);
		}
		return $aOrderedParts;
	}
	
}

class BasePart extends SystemPart {
	public function __construct($aInfo) {
		parent::__construct(DIRNAME_BASE, $aInfo, array(DIRNAME_SITE));
	}
}

class SitePart extends SystemPart {
	public function __construct($aInfo) {
		parent::__construct(DIRNAME_SITE, $aInfo);
	}
}

class PluginPart extends SystemPart {
	public function __construct($sPluginName, $aInfo) {
		parent::__construct(DIRNAME_PLUGINS."/$sPluginName", $aInfo, array(DIRNAME_SITE));
	}

	public static function allPluginParts() {
		return array_map(function(FileResource $oPath) {
			return SystemPart::getPart($oPath->getRelativePath());
		}, ResourceFinder::create()->addPath(DIRNAME_PLUGINS)->addExpression(ResourceFinder::ANY_NAME_OR_TYPE_PATTERN)->mainOnly()->returnObjects()->find());
	}

	public static function orderedPluginParts() {
		return array_filter(SystemPart::orderedParts(self::allPluginParts()+array(SystemPart::getPart(DIRNAME_BASE))), function(SystemPart $oPart) {
			return $oPart instanceof PluginPart;
		});
	}
}

class TestPart extends SystemPart {
	public function __construct($sTestName, $aInfo) {
		parent::__construct("test/$sTestName", $aInfo);
	}
}