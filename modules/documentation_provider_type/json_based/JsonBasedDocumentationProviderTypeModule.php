<?php

class JsonBasedDocumentationProviderTypeModule extends DocumentationProviderTypeModule {

	public function metadataForAllParts() {
		return json_decode(file_get_contents($this->aConfig['metadata_url']), true);
	}

	public function contentForPart($sDocumentationPart, $sLanguageId) {
		$sUrl = $this->aConfig['content_url'];
		$sUrl = str_replace('${language}', $sLanguageId, $sUrl);
		$sUrl = str_replace('${part}', $sDocumentationPart, $sUrl);
		return json_decode(file_get_contents($sUrl), true);
	}
}