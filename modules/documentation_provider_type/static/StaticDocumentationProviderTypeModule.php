<?php

class StaticDocumentationProviderTypeModule extends DocumentationProviderTypeModule {

	public function metadataForAllParts() {
		$aResult = array();
		foreach($this->aConfig['docs'] as $sDocumentationPart => &$aDocumentationConfig) {
			$aResult[$sDocumentationPart] = array();
			foreach($aDocumentationConfig as $sLanguageId => &$aLanguageConfig) {
				$aResult[$sDocumentationPart][$sLanguageId] = array('title' => $aLanguageConfig['title'], 'url' => null);
			}
		}
		return $aResult;
	}

	public function contentForPart($sDocumentationPart, $sLanguageId) {
		return @$this->aConfig['docs'][$sDocumentationPart][$sLanguageId]['html'];
	}
}