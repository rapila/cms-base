<?php

abstract class DocumentationProviderTypeModule extends Module {
	protected static $MODULE_TYPE = 'documentation_provider_type';

	protected $aConfig;

	public function __construct($aConfig) {
		$this->aConfig = $aConfig;
	}

	public abstract function metadataForAllParts();
	public abstract function contentForPart($sDocumentationPart, $sLanguageId);

	public function getPriority() {
		return $this->aConfig['priority'];
	}

	public function getConfigKey() {
		return $this->aConfig['config_key'];
	}

	// Helper methods
	public static function completeMetadata() {
		$aSettings = array_keys(Settings::getInstance('documentation')->getSettingsArray());
		$oCache = new Cache('documentation_provider_type_metadata', DIRNAME_CONFIG);
		$oSettingsCache = new Cache(Settings::createCacheKey('documentation'), DIRNAME_CONFIG);
		if($oCache->cacheFileExists() && !$oCache->isOlderThan($oSettingsCache->getModificationDate())) {
			return $oCache->getContentsAsVariable();
		}
		$aProviders = array();
		foreach($aSettings as $sDocumentationInstance) {
			$oProvider = self::providerInstance($sDocumentationInstance);
			if(!$oProvider) {
				continue;
			}
			$aProviders[] = $oProvider;
		}
		usort($aProviders, function($oProvider1, $oProvider2) {
			if($oProvider1->getPriority() === $oProvider2->getPriority()) {
				return 0;
			}
			return $oProvider1->getPriority() < $oProvider2->getPriority() ? -1 : 1;
		});
		$aResult = array();
		// Consolidate all
		foreach($aProviders as $oProvider) {

			foreach($oProvider->metadataForAllParts() as $sPart => $aData) {
				$sPart = strtolower($sPart);
				if(!isset($aResult[$sPart])) {
					$aResult[$sPart] = array();
				}
				foreach($aData as $sLanguageId => $sLanguageData) {
					$aResult[$sPart][$sLanguageId] = array('title' => $sLanguageData['title'], 'url' => $sLanguageData['url'], 'is_part' => $sLanguageData['is_part'], 'provider' => $oProvider->getConfigKey());
				}
			}
		}
		$oCache->setContents($aResult);
		return $aResult;
	}

	public static function dataForPart($sDocumentationPart, $sLanguageId) {
		$oCache = new Cache("documentation_content_$sLanguageId:$sDocumentationPart", DIRNAME_CONFIG);
		$oSettingsCache = new Cache(Settings::createCacheKey('documentation'), DIRNAME_CONFIG);
		if($oCache->cacheFileExists() && !$oCache->isOlderThan($oSettingsCache->getModificationDate())) {
			return $oCache->getContentsAsVariable();
		}
		$aMetadata = self::completeMetadata();
		if(!isset($aMetadata[$sDocumentationPart]) || !isset($aMetadata[$sDocumentationPart][$sLanguageId])) {
			$aMetadata = null;
		} else {
			$aMetadata = $aMetadata[$sDocumentationPart][$sLanguageId];
			$aMetadata['content'] = self::providerInstance($aMetadata['provider'])->contentForPart($sDocumentationPart, $sLanguageId);
		}
		$oCache->setContents($aMetadata);
		return $aMetadata;
	}

	public static function providerInstance($sConfigKey) {
		$aMetadata = Settings::getSetting($sConfigKey, null, null, 'documentation');
		if($aMetadata === null) {
			return null;
		}
		if(!isset($aMetadata['provider'])) {
			$aMetadata['provider'] = 'static';
		}
		if(!isset($aMetadata['priority'])) {
			$aMetadata['priority'] = 0;
		}
		$aMetadata['config_key'] = $sConfigKey;
		return self::getModuleInstance($aMetadata['provider'], $aMetadata);
	}
}
