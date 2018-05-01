<?php
class SanityCheck {
	//Check suites
	public static function completeCheck() {
		BasicSanityCheck::check();
		return CompleteSanityCheck::check();
	}

	public static function basicCheck() {
		BasicSanityCheck::check();
	}

	//Check runner
	protected static function check() {
		$aResults = array();
		$oClass = new ReflectionClass(get_called_class());
		$oObject = $oClass->newInstance();
		foreach($oClass->getMethods(ReflectionMethod::IS_PUBLIC) as $oMethod) {
			if($oMethod->isStatic()) {
				continue;
			}
			try {
				$oMethod->invoke($oObject);
			} catch(Exception $ex) {
				$aResults[$oMethod->getName()] = $ex;
			}
		}
	}
}

//Actual checks
class CompleteSanityCheck extends SanityCheck {

}

class BasicSanityCheck extends SanityCheck {
	public function verifySessionDefaultLanguage() {
		$sSessionDefaultLanguage = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, null);
		if(LanguageQuery::create()->filterById($sSessionDefaultLanguage)->count() < 1) {
			$oLanguage = new Language();
			$oLanguage->setId($sSessionDefaultLanguage);
			$oLanguage->setPathPrefix($sSessionDefaultLanguage);
			$oLanguage->setIsActive(true);
			$oLanguage->save();
		}
	}
}
