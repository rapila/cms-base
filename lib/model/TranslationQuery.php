<?php


/**
 * @package    propel.generator.model
 */
class TranslationQuery extends BaseTranslationQuery {

	public function filterByPKString($pkString) {
		$sSeparator = $this->getTableMap()->getBehaviours();
		$sSeparator = $sSeparator['extended_keyable']['key_separator'];
		$pkString = explode($sSeparator, $pkString);
		$sLanguageId = array_shift($pkString);
		$sStringKey = implode($pkString);
		return $this->filterByPrimaryKey(array($sLanguageId, $sStringKey));
	}

	public function filterByKeysWithoutNamespace() {
		return $this->filterByStringKey('%.%', Criteria::NOT_LIKE);
	}

	public function filterByNamespace($sNameSpace) {
		return $this->filterByStringKey("$sNameSpace%", Criteria::LIKE);
	}
}
