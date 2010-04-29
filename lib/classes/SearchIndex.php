<?php
class SearchIndex {
	private static $INSTANCES = array();
	private static $SYNONYMS;
	
	private $aIndex;
	private $sLanguage;
	
	public function __construct($sLanguage = null) {
		$this->aIndex = array();
		$this->sLanguage = $sLanguage;
		if($this->sLanguage === null) {
			$this->sLanguage = Session::language();
		}
		$this->initializeIndex();
	}
	
	private function initializeIndex() {
		$aPages = PagePeer::doSelect(new Criteria());
		
		foreach($aPages as $oPage) {
			if($oPage->getPageStringByLanguage($this->sLanguage) === null) {
				continue;
			}
			
			// get words from Page LongTitle
			$this->addWordsToIndexForPage(StringUtil::getWords($oPage->getPageStringByLanguage($this->sLanguage)->getPageTitle()), $oPage);
			// get words from Page keywords
			$this->addWordsToIndexForPage(StringUtil::getWords($oPage->getConsolidatedKeywords($this->sLanguage)), $oPage);
			
			$aObjects = $oPage->getContentObjects();
			foreach($aObjects as $oObject) {
				$oLanguageObject = $oObject->getLanguageObject($this->sLanguage);
				if($oLanguageObject === null) {
					continue;
				}
				$oModule = FrontendModule::getModuleInstance($oObject->getObjectType(), $oLanguageObject);
				//getWords() returns an array of normalized words
				$this->addWordsToIndexForPage($oModule->getWords(), $oPage);
			}
		}
	}
	
	private function addWordsToIndexForPage($aWords, $oPage) {
		foreach($aWords as $sWord) {
			$sWord = $this->findRootWord($sWord);
			if(!isset($this->aIndex[$sWord])) {
				$this->aIndex[$sWord] = array();
			}
			if(!isset($this->aIndex[$sWord][$oPage->getId()])) {
				$this->aIndex[$sWord][$oPage->getId()] = 1;
			} else {
				$this->aIndex[$sWord][$oPage->getId()]++;
			}
		}
	}
	
	private function findRootWord($sWord) {
		$aSynonyms = $this->loadSynonyms();
		if(isset($aSynonyms[$sWord])) {
			return $sWord;
		}
		foreach($aSynonyms as $sRootWord => $aSynonymList) {
			if(in_array($sWord, $aSynonymList)) {
				return $sRootWord;
			}
		}
		return $sWord;
	}
	
	private function getAllSynonymedWords() {
		$aResult = array();
		$aSynonyms = $this->loadSynonyms();
		foreach($aSynonyms as $sRootWord => $aSynonymList) {
			$aResult += $aSynonymList;
		}
		return $aResult;
	}
	
	public function find($sSearchString) {
		$aResults = array();
		$aSearchItems = StringUtil::getWords($sSearchString);
		foreach($aSearchItems as $sSearchItem) {
			$sSearchItem = $this->findRootWord($sSearchItem);
			if(!isset($this->aIndex[$sSearchItem])) {
				continue;
			}
			foreach($this->aIndex[$sSearchItem] as $iPageId => $iCount) {
				if(isset($aResults[$iPageId])) {
					$aResults[$iPageId] += $iCount;
				} else {
					$aResults[$iPageId] = $iCount;
				}
			}
		}
		arsort($aResults);
		return $aResults;
	}
	
	public function findPage($sSearchString) {
		$aAllItems = array_keys($this->find($sSearchString));
		if(count($aAllItems) === 0) {
			return null;
		}
		return PagePeer::retrieveByPK($aAllItems[0]);
	}
	
	public function findWordsByBeginning($sBeginning) {
		$iPageCount = PagePeer::doCount(new Criteria());
		$aResults = $this->aIndex;
		foreach($aResults as $sWord => $iCount) {
			if(!StringUtil::startsWith($sWord, $sBeginning)) {
				unset($aResults[$sWord]);
			} else {
				$aResults[$sWord] = round(count($aResults[$sWord])/$iPageCount, 2);
			}
		}
		
		foreach($this->getAllSynonymedWords() as $sSynonym) {
			if(!StringUtil::startsWith($sSynonym, $sBeginning)) {
				continue;
			}
			$iCount = count($this->find($sSynonym));
			if($iCount > 0) {
				$aResults[$sSynonym] = round(($iCount/$iPageCount), 2);
			}
		}
		
		return $aResults;
	}
	
	public function findPages($sSearchString) {
		$aAllItems = $this->find($sSearchString);
		$aResults = array();
		foreach($aAllItems as $iPageId => $iCount) {
			$aResults[$iPageId] = PagePeer::retrieveByPK($iPageId);
		}
		return $aResults;
	}
	
	private function loadSynonyms() {
		if(self::$SYNONYMS === null) {
			self::$SYNONYMS = Settings::getInstance('synonyms')->getSettingsArray();
			foreach(self::$SYNONYMS as $sLanguage => $aSynonymList) {
				foreach($aSynonymList as $sRootWord => $aSynonyms) {
					foreach($aSynonyms as $iKey => $sSynonym) {
						$aSynonyms[$iKey] = StringUtil::normalize($sSynonym);
					}
					unset(self::$SYNONYMS[$sLanguage][$sRootWord]);
					$sRootWord = StringUtil::normalize($sRootWord);
					self::$SYNONYMS[$sLanguage][$sRootWord] = $aSynonyms;
				}
			}
		}
		if(isset(self::$SYNONYMS[$this->sLanguage])) {
			return self::$SYNONYMS[$this->sLanguage];
		}
		return array();
	}
	
	public static function getSearchIndex() {
		$sLanguage = Session::language();
		if(!isset(self::$INSTANCES[$sLanguage])) {
			$oCache = new Cache('SearchIndex_'.$sLanguage, DIRNAME_LANG);
			if($oCache->cacheFileExists()) {
				self::$INSTANCES[$sLanguage] = $oCache->getContentsAsVariable();
			} else {
				self::$INSTANCES[$sLanguage] = new SearchIndex($sLanguage);
				$oCache->setContents(self::$INSTANCES[$sLanguage]);
			}
		}
		return self::$INSTANCES[$sLanguage];
	}
}