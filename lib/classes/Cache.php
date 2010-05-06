<?php
class Cache {
	
	private $bCacheIsNeverOff;
	private $sFilePath;
	private $bCacheControlHeaderSent;
	
	public function __construct($sKey, $mPath=null) {
		$this->bCacheIsNeverOff = $mPath === DIRNAME_CONFIG;
		
		$mPath = ResourceFinder::parsePathArguments(DIRNAME_GENERATED, DIRNAME_CACHES, $mPath);
		$sPath = ResourceFinder::findResource($mPath, ResourceFinder::SEARCH_MAIN_ONLY);
		if($sPath === null) {
			throw new Exception("Error in Cache->__construct(): Cache folder ".implode('/', $mPath)." does not exist");
		}
		
		$sFileName = md5($sKey);
		$this->sFilePath = $sPath.'/'.$sFileName.'.cache';
		
		$this->bCacheControlHeaderSent = false;
	}
	
	/**
	* Returns true if a file representing this cache entry already exists, false otherwise
	*/
	public function cacheFileExists($bTakeOffStatusIntoAccount = true) {
		if($bTakeOffStatusIntoAccount && $this->cacheIsOff()) {
			return false;
		}
		return file_exists($this->sFilePath);
	}
	
	/**
	 * Returns the full path to the cache file. Note that this file may not yet exist
	 */
	//
	public function getFilePath()
	{
			return $this->sFilePath;
	}
	
	/**
	 * Returns the cached content's modification date. Note that this will result in an error if the cache file does not (yet) exist
	 */
	public function getModificationDate() {
		return filemtime($this->sFilePath);
	}
	
	/**
	* Returns the age of the cached contents in seconds
	*/
	public function getAge() {
		return time()-$this->getModificationDate();
	}
	
	/**
	 * Looks if the cached contents are older than the modified dates of any of the given files
	 * @param string array $mOriginalFilePath
	 */
	public function isOutdated($mOriginalFilePath) {
		if(!is_array($mOriginalFilePath)) {
			$mOriginalFilePath = array($mOriginalFilePath);
		}
		foreach($mOriginalFilePath as $sOriginalFilePath) {
			$iFileModDate = 0;
			if(file_exists($sOriginalFilePath)) {
				$iFileModDate = filemtime($sOriginalFilePath);
			}
			if($this->isOlderThan($iFileModDate)) {
				return true;
			}
		}
		return false;
	}
	
	/**
	* Compares the timestamp of the cached contents to the given timestamp and returns true if the cached contents are older, false otherwise
	*/
	public function isOlderThan($iTimestamp) {
		if(is_string($iTimestamp)) {
			$iTimestamp = strtotime($iTimestamp);
		}
		return $iTimestamp > $this->getModificationDate();
	}
	
	/**
	* Convenience function for isOlderThan; takes a relative time and computes an absolute timestamp
	*/
	public function ageIsMoreThan($iSeconds = 0, $iMinutes = 0, $iHours = 0, $iDays = 0) {
		$iHours += $iDays * 24;
		$iMinutes += $iHours * 60;
		$iSeconds += $iMinutes * 60;
		
		return $this->isOlderThan(time() - $iSeconds);
	}
	
	/**
	* Gets the raw (possibly binary) contents of the cache file
	*/
	public function getContentsAsString() {
		return file_get_contents($this->sFilePath);
	}
	
	/**
	* Gets the size of the cache file without reading the contents
	*/
	public function fileSize() {
		return filesize($this->sFilePath);
	}
	
	/**
	* Outputs the raw contents directly to the client
	*/
	public function passContents($bOutputContentLength=false) {
		if($bOutputContentLength) {
			header("Content-Length: ".$this->fileSize());
		}
		return readfile($this->sFilePath);
	}

	/**
	* Returns the cached contents if they were not a string when saving
	*/
	public function getContentsAsVariable() {
		return unserialize(file_get_contents($this->sFilePath));
	}
	
	/**
	* Saves the cache file with the given contents. If value is a string, the data is saved to the file in raw, serialized otherwise
	*/
	public function setContents($mContents) {
		if($this->cacheIsOffForWriting()) {
			return;
		}
		if(is_string($mContents)) {
			return file_put_contents($this->sFilePath, $mContents);
		}
		return file_put_contents($this->sFilePath, serialize($mContents));
	}
	
	/**
	* Sends the cache control headers Last-Modified and ETag
	* Uses the given timestamp as base for calculation. If it is omitted, the timestamp of the cache file is used;
	* Additionally, this method exits if the client sent a matching If-None-Match or If-Modified-Since header
	* You can call this method twice if you created a new cache file and don’t have any other timestamp. It will only output the headers once.
	*/
	public function sendCacheControlHeaders($iTimestamp=null) {
		if(Settings::getSetting('general', 'send_not_modified_headers', null) === false) {
			return;
		}		 
		if($this->bCacheControlHeaderSent) {
			return;
		}
		
		if($iTimestamp === null) {
			if(!$this->cacheFileExists(false)) {
				return;
			}
			$iTimestamp = $this->getModificationDate();
		}
		if(is_string($iTimestamp)) {
			$iTimestamp = strtotime($iTimestamp);
		}
		
		//FIXME: This is not really correct according to specs: ETag should change, when the content changes, not the date…
		$sToken = md5($iTimestamp);
		$sModifyDate = gmdate("D, d M Y H:i:s", $iTimestamp)." GMT";
		header("ETag: $sToken");
		header("Last-Modified: $sModifyDate");
		$this->bCacheControlHeaderSent = true;
		
		if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] === $sToken) {
			header("Not Modified", true, 304);
			header('Content-Length: 0');
			exit;
		}
		
		//FIXME: should check if sent value is less than or equal to the stored value
		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] === $sModifyDate) {
			header("Not Modified", true, 304);
			header('Content-Length: 0');
			exit;
		}
	}
	
	/**
	* Returns true if, for whatever reason, no data should be written to the cache.
	* This can be triggered by the general->caching boolean setting in config.yml
	* Caching of config files is always on
	*/
	public function cacheIsOffForWriting() {
		return (!$this->bCacheIsNeverOff && !Settings::getSetting('general', 'caching', true));
	}
	
	/**
	* Returns true if, for whatever reason, no data should be read from the cache.
	* This returns true if either
	* The cache is off for writing
	* The request parameter nocache with a value that evaluates to true is set
	* The cache-control headers are set to no-cache (i.e. the user forced a super reload in the browser)
	*/
	public function cacheIsOff() {
		if($this->cacheIsOffForWriting()) {
			return true;
		}
		if(isset($_REQUEST['nocache'])) {
			return true;
		}
		if(isset($_SERVER['HTTP_CACHE_CONTROL']) && stristr($_SERVER['HTTP_CACHE_CONTROL'], "no-cache") !== FALSE && !Manager::isPost()) {
			return true;
		}
		return false;
	}
	
	/**
	* Removes all cache files but not their parent directories. This is used by the mini_cms_clear_cache_and_set_permissions.sh script
	*/
	public static function clearAllCaches() {
		$aCachesDirs = ResourceFinder::findAllResources(array(DIRNAME_GENERATED, DIRNAME_CACHES), ResourceFinder::SEARCH_MAIN_ONLY);
		foreach($aCachesDirs as $sCachesDir) {
			if($rCachesDir = opendir($sCachesDir)) {
				while(false !== ($sFileName = readdir($rCachesDir))) {
					$sFilePath = $sCachesDir."/".$sFileName;
					if(is_dir($sFilePath) && strpos($sFileName, ".") !== 0) {
						if($rSubDir = opendir($sFilePath)) {
							while(false !== ($sSubFileName = readdir($rSubDir))) {
								if(!is_dir("$sFilePath/$sSubFileName")) {
									unlink("$sFilePath/$sSubFileName");
								}
							}
							closedir($rSubDir);
						}
					} elseif(strpos($sFileName, ".") !== 0) {
						unlink($sFilePath);
					}
				}
				closedir($rCachesDir);
			}
		}
	} //clearAllCaches()
}