<?php
/**
 * Represents one file in the cache, identified by the dirname and the key (generated/caches/<dir>/<md5(key)>.cache).
*/
class CachingStrategyFile extends CachingStrategy {
	protected $file_name = 'generated/caches/${module}/${key}.cache';
	protected $use_var_export = false;
	protected $key_encode = 'md5';
	
	public function getFilePath(Cache $oCache) {
		return MAIN_DIR.'/'.$this->replaceOption($oCache, $this->file_name);
	}
	
	public function prepareFilePath(Cache $oCache) {
		$sPath = $this->getFilePath($oCache);
		$sDir = dirname($sPath);
		if(!is_dir($sDir)) {
			if(!@mkdir($sDir, 0775, true)) {
				throw new Exception("Error in File CachingStrategy: Cache folder $sDir does not exist and we do not have rights to create it");
			}
		}
		return $sPath;
	}

	public function exists(Cache $oCache) {
		return file_exists($this->getFilePath($oCache));
	}

	private static function blockingRead($sPath) {
		$rFile = fopen($sPath, 'rb');
		@flock($rFile, LOCK_SH);
		$sContents = file_get_contents($sPath);
		@flock($rFile, LOCK_UN);
		fclose($rFile);
		return $sContents;
}
	
	public function read(Cache $oCache) {
		$sPath = $this->getFilePath($oCache);
		return self::blockingRead($sPath);
	}
	
	public function readData(Cache $oCache) {
		$sPath = $this->getFilePath($oCache);
		if($this->use_var_export) {
			return include($sPath);
		} else {
			return unserialize(self::blockingRead($sPath));
		}
	}

	public function write(Cache $oCache, $sEntry, $bAppend = false) {
		$sPath = $this->prepareFilePath($oCache);
		return file_put_contents($this->getFilePath($oCache), $sEntry, $bAppend ? FILE_APPEND | LOCK_EX : LOCK_EX);
	}

	public function writeData(Cache $oCache, $mEntry, $bAppend = false) {
		if($this->use_var_export) {
			$mEntry = '<?php' . PHP_EOL . 'return ' . var_export($mEntry, true) . ';';
		} else {
			$mEntry = serialize($mEntry);
		}
		$this->write($oCache, $mEntry, $bAppend);
	}

	public function date(Cache $oCache) {
		return filemtime($this->getFilePath($oCache));
	}
	
	public function size(Cache $oCache) {
		return filesize($this->getFilePath($oCache));
	}
	
	public function clearCaches() {
		$sPath = str_replace(array('${module}', '${key}'), '*', $this->file_name);
		$aPath = explode('/', $sPath);
		foreach($aPath as &$sPathItem) {
			if(strpos($sPathItem, '*') !== false) {
				$sPathItem = '/^'.str_replace('\\*', '.+', preg_quote($sPathItem, '/')).'$/';
			}
		}
		$oFinder = ResourceFinder::create($aPath)->byExpressions()->searchMainOnly()->noCache();
		foreach($oFinder->find() as $sCachesFile) {
			unlink($sCachesFile);
		}
	}
	
}