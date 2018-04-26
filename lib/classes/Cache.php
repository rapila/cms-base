<?php
/**
 * Represents one file in the cache, identified by the dirname and the key (generated/caches/<dir>/<md5(key)>.cache).
*/
class Cache {
	private $oStrategy;
	private $sKey;
	private $sModule;
	
	public function __construct($sKey, $sModule, $oStrategy=null) {
		if(is_int($oStrategy)) {
			throw new Exception('Cache flags are not supported anymore. Use an option to the caching strategy.');
		}

		if($sKey instanceof CacheKey) {
			$sKey = $sKey->render();
		}
		$this->sKey = $sKey;

		if(!($oStrategy instanceof CachingStrategy)) {
			$oStrategy = CachingStrategy::forModule($sModule);
		}
		$this->oStrategy = $oStrategy;

		$this->sModule = $sModule;
	}
	
	/**
	* Returns true if a file representing this cache entry already exists, false otherwise
	* @deprecated use cacheEntryExists
	*/
	public function cacheFileExists($bTakeOffStatusIntoAccount = true) {
		return $this->entryExists($bTakeOffStatusIntoAccount);
	}
	
	/**
	* Returns true if this cache entry already exists, false otherwise
	*/
	public function entryExists($bTakeOffStatusIntoAccount = true) {
		if($bTakeOffStatusIntoAccount && $this->cacheIsOff()) {
			return false;
		}
		return $this->oStrategy->exists($this);
	}
	
	/**
	 * Returns the full path to the cache file. Note that this file may not yet exist
	 * @deprecated only works if caching strategy is CachingStrategyFile. Use $oCache->getStrategy()->getFilePath($oCache)
	 */
	public function getFilePath() {
		return $this->oStrategy->getFilePath($this);
	}
	
	/**
	 * Returns the md5()’ed cache key.
	 * @deprecated use md5(getKey()) or $oCache->getStrategy()->encodedKey($oCache)
	 */
	public function getFileName() {
		return md5($this->getKey());
	}
	
	/**
	* Returns the cache key.
	*/
	public function getKey() {
		return $this->sKey;
	}
	
	/**
	* Returns the cache module.
	*/
	public function getModule() {
		return $this->sModule;
	}
	
	/**
	* Returns the caching strategy used.
	*/
	public function getStrategy() {
		return $this->oStrategy;
	}
	
	/**
	 * Returns the cached content's modification date. Note that this will possibly result in an error if the cache entry does not (yet) exist
	 */
	public function getModificationDate() {
		return $this->oStrategy->date($this);
	}
	
	/**
	* Returns the age of the cached contents in seconds
	*/
	public function getAge() {
		return time()-$this->getModificationDate();
	}
	
	/**
	 * Looks if the cached contents are older than the modified dates of any of the given files
	 * Pass a ResourceFinder instance rather than an array to prevent the (potentially expensive) call to ResourceFinder->find() in production.
	 * @param string|array|ResourceFinder $mOriginalFilePath
	 */
	public function isOutdated($mOriginalFilePath) {
		if(ErrorHandler::isProduction()) {
			//Files are never out of date in production (clear the cache manually when deploying)… no need to check
			return false;
		}
		if($mOriginalFilePath instanceof ResourceFinder) {
			$mOriginalFilePath = $mOriginalFilePath->find();
		}
		if($mOriginalFilePath === null) {
			return false;
		}
		if(!is_array($mOriginalFilePath)) {
			$mOriginalFilePath = array($mOriginalFilePath);
		}
		foreach($mOriginalFilePath as $sOriginalFilePath) {
			if($sOriginalFilePath instanceof FileResource) {
				$sOriginalFilePath = $sOriginalFilePath->getFullPath();
			}
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
		if($iTimestamp instanceof BaseObject) {
			$iTimestamp = $iTimestamp->getUpdatedAtTimestamp();
		}
		if($iTimestamp instanceof ModelCriteria) {
			$iTimestamp = $iTimestamp->findMostRecentUpdate(true);
		}
		if(is_string($iTimestamp)) {
			$iTimestamp = strtotime($iTimestamp);
		}
		if($iTimestamp instanceof DateTime) {
			$iTimestamp = $iTimestamp->getTimestamp();
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
	* Gets the size of the cache file without reading the contents
	* @deprecated use size()
	*/
	public function fileSize() {
		return $this->size();
	}
	
	/**
	* Gets the size of the cache contents without reading the contents. May return null if unknown.
	*/
	public function size() {
		return $this->oStrategy->size($this);
	}
	
	/**
	* Outputs the raw contents directly to the client
	*/
	public function passContents($bOutputContentLength=false) {
		if($bOutputContentLength) {
			$iSize = $this->size();
			if($iSize !== null) {
				header("Content-Length: ".$iSize);
			}
		}
		return $this->oStrategy->pass($this);
	}
	
	/**
	* Gets the raw (possibly binary) contents of the cache file
	*/
	public function getContentsAsString() {
		return $this->oStrategy->read($this);
	}

	/**
	* Returns the cached contents if they were not a string when saving
	*/
	public function getContentsAsVariable() {
		return $this->oStrategy->readData($this);
	}
	
	/**
	* Saves the cache file with the given contents. If value is a string, the data is saved to the file in raw, serialized otherwise
	*/
	public function setContents($mContents, $bForceSerialize = false, $bAppend = false) {
		if($this->cacheIsOffForWriting()) {
			return;
		}
		if(!$bForceSerialize && is_string($mContents)) {
			return $this->oStrategy->write($this, $mContents, $bAppend);
		}
		return $this->oStrategy->writeData($this, $mContents);
	}
	
	/**
	* Sends the cache control headers Last-Modified and ETag
	* Uses the timestamp of the cache file as base for calculation.
	* Additionally, this method exits if the client sent a matching If-None-Match or If-Modified-Since header
	* You can call this method twice if you created a new cache file and don’t have any other timestamp. It will only output the headers once.
	* @param $iTimestamp deprecated: to use this method without a cache file, call LinkUtil::sendCacheControlHeaders directly
	*/
	public function sendCacheControlHeaders($iTimestamp = null) {
		if($iTimestamp !== null) {
			LinkUtil::sendCacheControlHeaders($iTimestamp);
		} else {
			LinkUtil::sendCacheControlHeadersForCache($this);
		}
	}
	
	/**
	* Returns true if, for whatever reason, no data should be written to the cache.
	* This can be triggered by the general->caching boolean setting in config.yml
	* Caching of config files is always on (because it is there that this setting is defined)
	*/
	public function cacheIsOffForWriting() {
		return $this->oStrategy->cacheIsOffForWriting();
	}
	
	/**
	* Returns true if, for whatever reason, no data should be read from the cache.
	* This returns true if either
	* The cache is off for writing
	* The request parameter nocache is set
	* The cache-control headers are set to no-cache (i.e. the user forced a-super reload in the browser)
	*/
	public function cacheIsOff() {
		return $this->oStrategy->cacheIsOff();
	}
	
	/**
	* Removes all cache files but not their parent directories.
	*/
	public static function clearAllCaches() {
		foreach(CachingStrategy::configuredStrategies() as $oStrategy) {
			$oStrategy->clearCaches();
		}
	}
}
