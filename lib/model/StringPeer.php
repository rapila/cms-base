<?php

	// include base peer class
	require_once 'model/om/BaseStringPeer.php';
	
	// include object class
	include_once 'model/String.php';
	
	// include template class
	include_once 'classes/Template.php';


/**
 * @package model
 */ 
class StringPeer extends BaseStringPeer {
	
	private static $STATIC_STRINGS = array();

	/**
	 * Loads all the static strings from either the cache or the ini files. Note that ini files in modules are not verified for outdatedness, so if they were updated, just clear all the caches or hard reload a page
	 * This method should not be called directly from outsite StringPeer except for testing and debugging purposes
	 */
	public static function getStaticStrings($sLanguageId) {
		if(!isset(self::$STATIC_STRINGS[$sLanguageId])) {
			$oCache = new Cache($sLanguageId, DIRNAME_LANG);
			$aLanguageFiles = ResourceFinder::findAllResources(array(DIRNAME_LANG, "$sLanguageId.ini"), ResourceFinder::SEARCH_BASE_FIRST);
			if($oCache->cacheFileExists() && !$oCache->isOutdated($aLanguageFiles)) {
				self::$STATIC_STRINGS[$sLanguageId] = $oCache->getContentsAsVariable();
			} else {
				self::$STATIC_STRINGS[$sLanguageId] = array();
				
				//Get default strings
				foreach($aLanguageFiles as $sLanguageFile) {
					self::$STATIC_STRINGS[$sLanguageId] = array_merge(self::$STATIC_STRINGS[$sLanguageId], parse_ini_file($sLanguageFile));
				}
				
				//Get strings for modules
				foreach(ResourceFinder::findResourceByExpressions(array(DIRNAME_MODULES, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN, DIRNAME_LANG, "$sLanguageId.ini"), ResourceFinder::SEARCH_SITE_FIRST) as $sLanguageFile) {
					self::$STATIC_STRINGS[$sLanguageId] = array_merge(self::$STATIC_STRINGS[$sLanguageId], parse_ini_file($sLanguageFile));
				}
				
				//Fix string encoding
				foreach(self::$STATIC_STRINGS[$sLanguageId] as $sStringKey => $sValue) {
					self::$STATIC_STRINGS[$sLanguageId][$sStringKey] = StringUtil::encodeForDbFromFile($sValue);
				}
				$oCache->setContents(self::$STATIC_STRINGS[$sLanguageId]);
			}
		}
		return self::$STATIC_STRINGS[$sLanguageId];
	}
	
	private static function getStaticString($sKey, $sLanguageId) {
		$aStaticStrings = self::getStaticStrings($sLanguageId);
		if(isset($aStaticStrings[$sKey])) {
			return html_entity_decode($aStaticStrings[$sKey], ENT_QUOTES, Settings::getSetting("encoding", "browser", "utf-8"));
		}
		return null;
	}
	
	public static function staticStringExists($sKey, $sLanguageId) {
		return self::getStaticString($sKey, $sLanguageId) !== null;
	}
	
	public static function getString($sKey, $sLanguageId=null, $sDefaultValue=null, $aParameters=null, $bMayReturnTemplate=false, $iFlags=0) {
		if(Settings::getSetting('frontend', 'display_string_keys', false)) {
			return $sKey;
		}
		if(!is_string($sDefaultValue)) {
			$sDefaultValue = "Translation missing: $sKey";
		}
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$oString = self::retrieveByPK($sLanguageId, $sKey);
		$sString = '';
		if($oString === null) {
			$sString = self::getStaticString($sKey, $sLanguageId);
			if($sString === null) {
				return $sDefaultValue;
			}
		} else {
			$sString = $oString->getText();
		}
		if((is_array($aParameters) && count($aParameters) > 0) || strpos($sString, TEMPLATE_IDENTIFIER_START) !== false) {
			if(!is_array($aParameters)) {
				$aParameters = array();
			}
			if(!$bMayReturnTemplate) {
				$iFlags = $iFlags|Template::NO_HTML_ESCAPE;
			}
			$tmpl = new Template(Template::htmlEncode($sString), "db", true, false, Settings::getSetting("encoding", "db", "utf-8"), null, $iFlags);
			foreach($aParameters as $sKey => $sValue) {
				//NO_HTML_ESCAPE should work in any case since strings will always be included in templates and thus always be encoded correctly in a second step
				$tmpl->replaceIdentifier($sKey, $sValue);
			}
			if($bMayReturnTemplate) {
				return $tmpl;
			}
			return $tmpl->render();
		}
		return $sString;
	}
	
	public static function getNamespaces() {
		$oConnection = Propel::getConnection(self::DATABASE_NAME);
		$sTable = self::TABLE_NAME;
		$sStringKeyColumn = self::STRING_KEY;
		$sSQL = <<<EOT
SELECT DISTINCT SUBSTR($sStringKeyColumn, 1, LOCATE('.',$sStringKeyColumn)-1) AS namespace FROM `$sTable` WHERE LOCATE('.',$sStringKeyColumn)>0;
EOT;
		$oStatement = $oConnection->prepare($sSQL);
		$oStatement->execute();
		$oStatement->setFetchMode(PDO::FETCH_OBJ);
		$aResult = array();
		foreach($oStatement as $oRow) {
			$sNamespace = $oRow->namespace;
			$aResult[$sNamespace] = $sNamespace;
		}
		return $aResult;
	}
	
	public static function getStringsByLanguageId($sLanguageId, $sSearch = null, $sNameSpace = null) {
		$oCriteria = self::getStringsByLanguageIdAndNameSpaceCriteria($sLanguageId, $sNameSpace);
		if($sSearch !== null) {
			self::addSearchToCriteria($oCriteria, $sSearch);
		}
		$oCriteria->addAscendingOrderByColumn(self::STRING_KEY);
		return self::doSelect($oCriteria);
	}

	public static function getStringsByLanguageIdAndNameSpaceCriteria($sLanguageId, $sNameSpace=null, $oCriteria = null) {
		$oCriteria = $oCriteria === null ? new Criteria() : $oCriteria;
		$oCriteria->add(self::LANGUAGE_ID, $sLanguageId);
		if($sNameSpace !== null) {
			if($sNameSpace === '0') {
				$oCriteria->add(self::STRING_KEY, "%.%", Criteria::NOT_LIKE);
			} else {
				$oCriteria->add(self::STRING_KEY, "$sNameSpace.%", Criteria::LIKE);
			}
		}
		return $oCriteria;		
	}
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::STRING_KEY, "%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::TEXT, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}

	public static function getStringsByStringKey($sStringKey, $sExcludeLang=true, $bOrderByLanguage=false) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::STRING_KEY, $sStringKey);
		if($sExcludeLang) {
			$oCriteria->add(self::LANGUAGE_ID, $sExcludeLang, Criteria::NOT_EQUAL);
		}
		if($bOrderByLanguage) {
			$oCriteria->addAscendingOrderByColumn(self::LANGUAGE_ID);
		}
		return self::doSelect($oCriteria);
	}
	
	public static function addOrUpdateString($sStringKey, $sContent, $sLanguageId = null) {
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$oString = StringPeer::retrieveByPK($sLanguageId, $sStringKey);
	
		if(!$sContent) {
			if($oString !== null) {
				$oString->delete();
			}
			return;
		}
		if($oString === null) {
			$oString = new String();
			$oString->setLanguageId($sLanguageId);
			$oString->setStringKey($sStringKey);
		}
		$oString->setText($sContent);
		$oString->save();
	}
	
	public static function nameSpaceExists($sNameSpace) {
		return self::countNameSpaceByName($sNameSpace) > 0;
	}
	
	public static function countNameSpaceByName($sNameSpace) {
		$oCriteria = new Criteria();
		$oCriteria->add(StringPeer::STRING_KEY, "$sNameSpace.%", Criteria::LIKE);
		return self::doCount($oCriteria);
	}

	public static function getNameSpaceFromStringKey($sStringKey) {
		$aParts = explode('.', $sStringKey);
		if(count($aParts) > 1) {
			return $aParts[0];
		}
		return null;
	}
}

