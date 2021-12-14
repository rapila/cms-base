<?php

// include base peer class
require_once 'model/om/BaseTranslationPeer.php';

// include object class
include_once 'model/Translation.php';

// include template class
include_once 'classes/Template.php';

/**
 * @package model
 */ 
class TranslationPeer extends BaseTranslationPeer {
	
	private static $STATIC_STRINGS = array();

	/**
	 * Loads all the static strings from either the cache or the ini files. Note that ini files in modules are not verified for outdatedness, so if they were updated, just clear all the caches or hard reload a page
	 * This method should not be called directly from outsite TranslationPeer except for testing and debugging purposes
	 */
	public static function getStaticStrings($sLanguageId) {
		if(!isset(self::$STATIC_STRINGS[$sLanguageId])) {
			$oCache = new Cache($sLanguageId, DIRNAME_LANG);
			$aLanguageFiles = ResourceFinder::create()->addPath(DIRNAME_LANG, "$sLanguageId.ini")->all()->baseFirst()->find();
			if($oCache->entryExists() && !$oCache->isOutdated($aLanguageFiles)) {
				self::$STATIC_STRINGS[$sLanguageId] = $oCache->getContentsAsVariable();
			} else {
				self::$STATIC_STRINGS[$sLanguageId] = array();
				
				//Get default strings
				foreach($aLanguageFiles as $sLanguageFile) {
					self::$STATIC_STRINGS[$sLanguageId] = array_merge(self::$STATIC_STRINGS[$sLanguageId], parse_ini_file($sLanguageFile));
				}
				
				//Get strings for modules
				foreach(ResourceFinder::create()->addExpression(DIRNAME_MODULES, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN, ResourceFinder::ANY_NAME_OR_TYPE_PATTERN, DIRNAME_LANG, "$sLanguageId.ini")->all()->baseFirst()->find() as $sLanguageFile) {
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
			return $aStaticStrings[$sKey];
		}
		return null;
	}
	
	public static function staticStringExists($sKey, $sLanguageId) {
		return self::getStaticString($sKey, $sLanguageId) !== null;
	}
	
	public static function getString($sKey, $sLanguageId=null, $sDefaultValue=null, $aParameters=null, $bMayReturnTemplate=false, $iFlags=0) {
		$bNoHTMLInReturnedString = ($bMayReturnTemplate === null);
		if(Settings::getSetting('frontend', 'display_string_keys', false)) {
			return $sKey;
		}
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		$oString = self::retrieveByPK($sLanguageId, $sKey);
		$sString = '';
		if($oString === null) {
			$sString = self::getStaticString($sKey, $sLanguageId);
			if($sString === null) {
					if(!is_string($sDefaultValue)) {
						$sDefaultValue = "Translation missing: $sKey";
						if(!empty($aParameters)) {
							$sDefaultValue .= " (";
							foreach($aParameters as $sKey => $sValue) {
								$sDefaultValue .= "$sKey: $sValue, ";
							}
							$sDefaultValue = substr($sDefaultValue, 0, -2);
							$sDefaultValue .= ")";
						}
					}
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
				//NO_HTML_ESCAPE works in any case:
				//Case $bMayReturnTemplate === false: strings will always be included in templates and thus always be encoded correctly in a second step.
				//Case $bMayReturnTemplate === null: strings should not contain any HTML-characteristics, including entities. {{br}}-Tags will be stripped as well.
				$iFlags = $iFlags|Template::NO_HTML_ESCAPE;
			}
			if($bMayReturnTemplate) {
				//If returned item is a template, it is assumed that nothing will run htmlentities on it later on so we have to run it now.
				$sString = Template::htmlEncode($sString);
			}
			if($bNoHTMLInReturnedString) {
				$sString = str_replace('{{br}}', "\n", $sString);
			}
			$tmpl = new Template($sString, "db", true, false, Settings::getSetting("encoding", "db", "utf-8"), null, $iFlags);
			foreach($aParameters as $sKey => $sValue) {
				$tmpl->replaceIdentifier($sKey, $sValue);
			}
			if($bMayReturnTemplate) {
				return $tmpl;
			}
			$sString = $tmpl->render();
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
	
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::TEXT, "%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::STRING_KEY, "%$sSearch%", Criteria::LIKE));
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
		$oString = TranslationQuery::create()->findPk(array($sLanguageId, $sStringKey));
	
		if(!$sContent) {
			if($oString !== null) {
				$oString->delete();
			}
			return;
		}
		if($oString === null) {
			$oString = new Translation();
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
		return TranslationQuery::create()->filterByStringKey("$sNameSpace.%", Criteria::LIKE)->count();
	}

	public static function getNameSpaceFromStringKey($sStringKey) {
		$aParts = explode('.', $sStringKey);
		if(count($aParts) > 1) {
			return $aParts[0];
		}
		return null;
	}
	
	// Test-use only
	public static function setStaticStrings($aStatic) {
		self::$STATIC_STRINGS = $aStatic;
	}
}

