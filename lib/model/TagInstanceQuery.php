<?php


/**
 * @package    propel.generator.model
 */
class TagInstanceQuery extends BaseTagInstanceQuery {
	public function filterByTagged($sModel = null, $iId = null) {
		if($sModel instanceof BaseObject) {
			$iId = $sModel->getPKString();
			$sModel = get_class($sModel);
		}
		if($sModel !== null) {
			$this->filterByModelName($sModel);
		}
		if($iId !== null) {
			$this->filterByTaggedItemId($iId);
		}
		return $this;
	}
	
	public function filterByTagName($mTagName) {
		$this->innerJoinTag();
		if(!is_array($mTagName)) {
			$this->add(TagPeer::NAME, $mTagName);
		} else {
			foreach($mTagName as $sTagName) {
				$this->add(TagPeer::NAME, $sTagName);
			}
		}
		return $this;
	}
}

