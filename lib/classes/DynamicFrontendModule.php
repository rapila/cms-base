<?php
/**
 */
abstract class DynamicFrontendModule extends FrontendModule {
	public static function isDynamic() {
		return true;
	}
	
	public function cacheKey() {
		return null;
	}
}
