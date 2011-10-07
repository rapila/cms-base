<?php

	// include base peer class
	require_once 'model/om/BaseLinkPeer.php';
	
	// include object class
	include_once 'model/Link.php';


/**
 * @package model
 */ 
class LinkPeer extends BaseLinkPeer {
	
	private static $aLinkProtocols = array('http'	 => 'http://', 
																				 'https' => 'https://', 
																				 'ftp'	 => 'ftp://', 
																				 'ftps'	 => 'ftps://', 
																				 'mailto'=> 'mailto');
	
	public static function getLinksSorted($sOrderField='NAME', $sSortOrder='ASC') {
		$oCriteria = new Criteria();
		Util::addSortColumn($oCriteria, constant("LinkPeer::".strtoupper($sOrderField)), $sSortOrder);
		return self::doSelect($oCriteria);
	}

	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::DESCRIPTION, "%$sSearch%", Criteria::LIKE));
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::URL, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}

	/** 
	 * getLinksByTagName()
	 * @param string|array $mTagName The name(s) of the tag(s) for which links are to be found $mTagName
	 * @param boolean $bOrderByLinkName optional sortorder
	 * @return array of objects
	 */
	public static function getLinksByTagName($mTagName, $bOrderByLinkName=true) {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(self::ID, TagInstancePeer::TAGGED_ITEM_ID, Criteria::INNER_JOIN);
		$oCriteria->addJoin(TagInstancePeer::TAG_ID, TagPeer::ID, Criteria::INNER_JOIN);
		$oCriteria->add(TagInstancePeer::MODEL_NAME, 'Link');
		if(!is_array($mTagName)) $mTagName = array($mTagName);
		$oCriteria->add(TagPeer::NAME, $mTagName, Criteria::IN);
		if($bOrderByLinkName) {
			$oCriteria->addAscendingOrderByColumn(self::NAME);
		} else {
			$oCriteria->addAscendingOrderByColumn(self::URL);
		}
		return self::doSelect($oCriteria);
	}
	
	public static function getLinksByName($sName = null, $sOrderField='NAME', $sSortOrder='ASC') {
		return self::doSelect(self::getLinksByNameCriteria($sName, $sOrderField, $sSortOrder));
	}
	
	public static function getLinksByNameCriteria($sName = null, $sOrderField='NAME', $sSortOrder='ASC', $oCriteria=null) {
		$oCriteria = $oCriteria === null ? new Criteria() : $oCriteria; 
		if($sName !== null) {
			self::addSearchToCriteria($sName, $oCriteria);
		}
		Util::addSortColumn($oCriteria, constant("LinkPeer::".strtoupper($sOrderField)), $sSortOrder);
		return $oCriteria;
	}
	
	public static function getProtocolsWithLinksAssoc() {
		$aResult = array();
		foreach(self::getProtocolsWithLinks() as $oLink) {
			foreach(self::$aLinkProtocols as $sKey => $sProtocols) {
				if(StringUtil::startsWith($oLink->getUrl(), $sProtocols)) {
					$aResult[$sKey] = $sProtocols;
				}
			}
		}
		return $aResult;
	}
	
	public static function getProtocolsWithLinks() {
		$oCriteria = new Criteria();
		$oCriteria->setDistinct();
		$oSearchCriterion = null;
		foreach(self::$aLinkProtocols as $sProtocols) {
			if($oSearchCriterion === null) {
				$oSearchCriterion = $oCriteria->getNewCriterion(self::URL, "$sProtocols%", Criteria::LIKE);
			} else {
				$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::URL, "$sProtocols%", Criteria::LIKE));
			}
		}
		$oCriteria->add($oSearchCriterion);
		return self::doSelect($oCriteria);
	}
	
	public static function getLinksByLinkCategory($iLinkCategoryId = null) {
		$oCriteria = new Criteria();
		if($iLinkCategoryId !== null) {
			$oCriteria->add(self::LINK_CATEGORY_ID, $iLinkCategoryId);
		}
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}
	
	public static function getHightestSortByCategory($iLinkCategoryId) {
		$oCriteria = new Criteria();
		$oCriteria->add(self::LINK_CATEGORY_ID, $iLinkCategoryId);
		$oCriteria->addDescendingOrderByColumn(self::SORT);
		$oLink = self::doSelectOne($oCriteria);
		if($oLink && $oLink->getSort() != null) {
			return $oLink->getSort();
		}
		return 0;
	}
	
	public static function mayOperateOnOwn($oUser, $mObject, $sOperation) {
		$bResult = parent::mayOperateOnOwn($oUser, $mObject, $sOperation);
		///When changing the sort or the category, I have to have the rights to said category as well
		if($bResult && ($mObject->isColumnModified(LinkPeer::SORT) || $mObject->isColumnModified(LinkPeer::LINK_CATEGORY_ID))) {
			return $mObject->getLinkCategory() === null || $mObject->getLinkCategory()->mayOperate($sOperation, $oUser);
		}
		return $bResult;
	}

}

