<?php
class FileResource {
	private $sFullPath;
	private $sInstancePrefix;
	private $sRelativePath;
	
	private static $MAIN_DIR_CANONICAL = null;
	
	/**
	* Used to create FileResource instances. ResourceFinder will call this with given full path, instance prefix, relative path;
	* other uses will likely let the function figure out instance prefix and relative path.
	* Setting relative path to non-null and instance prefix null is not allowed.
	* Setting instance prefix but not relative path is redundant.
	* @param string $sFullPath The absolute file path
	* @param string $sInstancePrefix The part of the CMS’ folder which this file belongs to (base, site or plugins/*); includes trailing slash
	* @param string $sRelativePath The file path following the instance prefix. There can be multiple files in the installation with the same relative paths if the instance prefix differs.
	*/
	public function __construct($sFullPath, $sInstancePrefix = null, $sRelativePath = null) {
		if(file_exists($sFullPath)) {
			if(($sRealPath = realpath($sFullPath)) === false) {
					throw new Exception("File resource does not have the permissions for realpath($sFullPath)");
			}
			$sFullPath = $sRealPath;
		}
		if($sInstancePrefix !== null && !StringUtil::endsWith($sInstancePrefix, '/')) {
			$sInstancePrefix .= '/';
		}

		if($sRelativePath === null) {
			if(strpos($sFullPath, self::mainDirCanonical()) !== 0) {
				throw new Exception("Tried to instanciate file resource $sFullPath, which is not inside main dir (".self::mainDirCanonical().")");
			}
			//Also remove leading slash
			$sRelativePath = substr($sFullPath, strlen(self::mainDirCanonical())+1);

			$sPreviousRelativePath = $sRelativePath;
			$sTempInstancePrefix = '';
			do {
				if(strpos($sRelativePath, '/') === false) {
					$sTempInstancePrefix = '';
					$sRelativePath = $sPreviousRelativePath;
					break;
				}
				$sTempInstancePrefix .= substr($sRelativePath, 0, strpos($sRelativePath, '/')+1);
				if($sInstancePrefix !== null && $sTempInstancePrefix !== $sInstancePrefix) {
					throw new Exception("Error in FileResource::__construct(): Supplied instance prefix $sInstancePrefix does not match supplied path’s $sTempInstancePrefix");
				}
				$sRelativePath = substr($sPreviousRelativePath, strlen($sTempInstancePrefix));
			} while ($sTempInstancePrefix === 'plugins/');
			$sInstancePrefix = $sTempInstancePrefix;
		}
		
		$this->sFullPath = $sFullPath;
		$this->sInstancePrefix = $sInstancePrefix;
		$this->sRelativePath = $sRelativePath;
	}

	public function __toString() {
		return $this->sFullPath;
	}

	public function getFullPath() {
		return $this->sFullPath;
	}

	public function getInstancePrefix() {
		return $this->sInstancePrefix;
	}
	
	public function isBase() {
		$aPrefix = explode('/', $this->sInstancePrefix);
		return $aPrefix[0] === DIRNAME_BASE;
	}
	
	public function isSite() {
		$aPrefix = explode('/', $this->sInstancePrefix);
		return $aPrefix[0] === DIRNAME_SITE;
	}
	
	public function isPlugin() {
		$aPrefix = explode('/', $this->sInstancePrefix);
		if($aPrefix[0] !== DIRNAME_PLUGINS) {
			return false;
		}
		return $aPrefix[1];
	}
	
	public function baseVersion() {
		return $this->version(DIRNAME_BASE);
	}
	
	public function siteVersion() {
		return $this->version(DIRNAME_SITE);
	}
	
	public function pluginVersion($sPluginName) {
		return $this->version(DIRNAME_PLUGINS.'/'.$sPluginName);
	}
	
	private function version($sInstancePrefix) {
		$sFullPath = self::mainDirCanonical().'/'.$sInstancePrefix.'/'.$this->sRelativePath;
		return new FileResource($sFullPath, $sInstancePrefix, $this->sRelativePath);
	}

	public function getRelativePath() {
		return $this->sRelativePath;
	}
	
	public function getInternalPath() {
		return $this->sInstancePrefix.$this->sRelativePath;
	}

	public function getFrontendPath() {
		return MAIN_DIR_FE.$this->getInternalPath();
	}
	
	public function getFileName($sExtensionCutoff = '') {
		return basename($this->sFullPath, $sExtensionCutoff);
	}
	
	public function getDirectoryPath() {
		return dirname($this->sFullPath);
	}
	
	public function parent() {
		return new FileResource($this->getDirectoryPath());
	}

	public function isFile() {
		return is_file($this->sFullPath);
	}
	
	public function isDirectory() {
		return is_dir($this->sFullPath);
	}
	
	public function getFrontendDirectoryPath() {
		return MAIN_DIR_FE.substr($this->getDirectoryPath(), strlen(self::mainDirCanonical())+1);
	}
	
	public function addToPath($sPathItem) {
		$this->sFullPath .= "/$sPathItem";
		$this->sRelativePath .= "/$sPathItem";
	}
	
	public function unlink() {
		unlink($this->sFullPath);
	}
	
	public static function mainDirCanonical() {
		if(self::$MAIN_DIR_CANONICAL === null) {
			self::$MAIN_DIR_CANONICAL = realpath(MAIN_DIR);
		}
		return self::$MAIN_DIR_CANONICAL;
	}
}
