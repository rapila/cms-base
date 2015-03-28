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
	
	public function read(Cache $oCache, $bAsString = true) {
		$sPath = $this->getFilePath($oCache);
		if($bAsString) {
			return file_get_contents($sPath);
		} else if($this->use_var_export) {
			return include($sPath);
		} else {
			return unserialize(file_get_contents($sPath));
		}
	}

	public function write(Cache $oCache, $mEntry, $bAsString = true, $bAppend = false) {
		$sPath = $this->prepareFilePath($oCache);
		if(!$bAsString) {
			if($this->use_var_export) {
				$mEntry = '<?php' . PHP_EOL . 'return ' . var_export($mEntry, true) . ';';
			} else {
				$mEntry = serialize($mEntry);
			}
		}
		return file_put_contents($this->getFilePath($oCache), $mEntry, $bAppend ? FILE_APPEND : 0);
	}

	public function date(Cache $oCache) {
		return filemtime($this->getFilePath($oCache));
	}
	
	public function size(Cache $oCache) {
		return filesize($this->getFilePath($oCache));
	}
	
}