<?php
/**
 * @package modules.widget
 */
class LinkInputWidgetModule extends WidgetModule {

	public function externalLinks() {

		$aResult = array();
		foreach(LinkCategoryQuery::create()
		->filterByHasLinks()->orderByName()
		->select(array('Id', 'Name'))->find()
		->toKeyValue('Id', 'Name') as $iCategoryId => $sCategoryName) {
			foreach(LinkQuery::create()
			->filterByLinkCategoryId($iCategoryId)->orderByName()
			->select(array('Id', 'Name'))->find()
			->toKeyValue('Id', 'Name') as $iId => $sName) {
				$aResult[$sCategoryName][$iId] = $sName;
			}
		}

		$sWithoutCategoryName = TranslationPeer::getString('wns.links.select_without_title');
		foreach(LinkQuery::create()
		->filterByLinkCategoryId(null, Criteria::ISNULL)->orderByName()
		->select(array('Id', 'Name'))->find()
		->toKeyValue('Id', 'Name') as $iId => $sName) {
			$aResult[$sWithoutCategoryName][$iId] = $sName;
		}
		return $aResult;
	}

	public function getElementType() {
		return 'select';
	}
}
