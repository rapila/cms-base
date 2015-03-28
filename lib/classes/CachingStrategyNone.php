<?php
/**
 * Represents one file in the cache, identified by the dirname and the key (generated/caches/<dir>/<md5(key)>.cache).
*/
class CachingStrategyNone extends CachingStrategy {
	public function exists(Cache $oCache) {
		return false;
	}
	public function read(Cache $oCache, $bAsString = true) {
		return null;
	}
	public function write(Cache $oCache, $mEntry, $bAsString = true, $bAppend = false) {}
	public function date(Cache $oCache) {
		return time();
	}
	public function size(Cache $oCache) {
		return null;
	}
	public function cacheIsOff() {
		return true;
	}
	public function cacheIsOffForWriting() {
		return true;
	}
}