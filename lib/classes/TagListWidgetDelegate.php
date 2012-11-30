<?php

class TagListWidgetDelegate extends CriteriaListWidgetDelegate {
	private $sTaggedModelName;
	private $sHeadingString;
	private $bIncludeAllAndWithout;
	
	public function __construct($sTaggedModelName, $sHeadingString, $bIncludeAllAndWithout = false) {
		parent::__construct(new CriteriaListTagListWidgetDelegate($this), 'Tag', 'name');
		$this->sTaggedModelName = $sTaggedModelName;
		$this->sHeadingString = $sHeadingString;
		$this->bIncludeAllAndWithout = $bIncludeAllAndWithout;
	}
	
	public function setTaggedModelName($sTaggedModelName) {
		$this->sTaggedModelName = $sTaggedModelName;
	}

	public function getTaggedModelName() {
		return $this->sTaggedModelName;
	}
	
	public function setHeadingString($sHeadingString) {
		$this->sHeadingString = $sHeadingString;
	}

	public function getHeadingString() {
		return $this->sHeadingString;
	}
	
	public function setIncludeAllAndWithout($bIncludeAllAndWithout) {
		$this->bIncludeAllAndWithout = $bIncludeAllAndWithout;
	}

	public function getIncludeAllAndWithout() {
		return $this->bIncludeAllAndWithout;
	}
}

class CriteriaListTagListWidgetDelegate {
	private $oTagList;
	
	public function __construct($oTagList) {
		$this->oTagList = $oTagList;
	}
	public function getColumnIdentifiers() {
		if($this->oTagList->getIncludeAllAndWithout()) {
			return array('name', 'display_name', 'magic_column');
		} else {
			return array('name', 'display_name');
		}
	}
	
	public function getMetadataForColumn($sColumnIdentifier) {
		$aResult = array();
		switch($sColumnIdentifier) {
			case 'name':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_DATA;
				$aResult['field_name'] = 'name';
				break;
			case 'display_name':
				$aResult['display_heading'] = false;
				$aResult['field_name'] = 'name';
				break;
			case 'magic_column':
				$aResult['display_type'] = ListWidgetModule::DISPLAY_TYPE_CLASSNAME;
				$aResult['has_data'] = false;
				break;
			}
		return $aResult;
	}
	
	public function getCustomListElements() {
		if($this->oTagList->getIncludeAllAndWithout() && TagQuery::create()->filterByTagged($this->oTagList->getTaggedModelName())->count() > 0) {
			return array(
				array('name' => CriteriaListWidgetDelegate::SELECT_ALL,
							'display_name' => StringPeer::getString('wns.tags.select_all_title'),
							'magic_column' => 'all'),
				array('name' => CriteriaListWidgetDelegate::SELECT_WITHOUT,
							'display_name' => StringPeer::getString('wns.tags.select_without_title'),
							'magic_column' => 'without'));
		}
		return array();
	}
	
	public function getCriteria() {
		return TagQuery::create()->filterByTagged($this->oTagList->getTaggedModelName());
	}
}