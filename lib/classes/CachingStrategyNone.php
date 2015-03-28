<?php
/**
 * Does not cache anything. May not be applicable in all scenarios.
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