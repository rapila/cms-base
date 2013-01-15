<?php

	// include base peer class
	require_once 'model/om/BaseDocumentPeer.php';
	
	// include object class
	include_once 'model/Document.php';

/**
 * @package model
 */
class DocumentPeer extends BaseDocumentPeer {
	public static $LICENSES = array(
	  "by" => array(
	    'image' => 'http://i.creativecommons.org/l/by/3.0/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/by/3.0/'
	  ),
	  "by-nc-nd" => array(
	    'image' => 'http://i.creativecommons.org/l/by-nc-nd/3.0/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/by-nc-nd/3.0/'
	  ),
	  "by-nc-sa" => array(
	    'image' => 'http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/by-nc-sa/3.0/'
	  ),
	  "by-nc" => array(
	    'image' => 'http://i.creativecommons.org/l/by-nc/3.0/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/by-nc/3.0/'
	  ),
	  "by-nd" => array(
	    'image' => 'http://i.creativecommons.org/l/by-nd/3.0/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/by-nd/3.0/'
	  ),
	  "by-sa" => array(
	    'image' => 'http://i.creativecommons.org/l/by-sa/3.0/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/by-sa/3.0/'
	  ),
	  "publicdomain" => array(
	    'image' => 'http://i.creativecommons.org/l/publicdomain/80x15.png',
	    'url' => 'http://creativecommons.org/licenses/publicdomain/',
			'disclaimer' => 'no'
	  ),
	  "gpl" => array(
	    'image' => 'http://creativecommons.org/images/license/40gnugpl.gif',
	    'url' => 'http://www.opensource.org/licenses/gpl-license.php'
	  ),
	  "lgpl" => array(
	    'image' => 'http://creativecommons.org/images/license/40gnulgpl.gif',
	    'url' => 'http://www.opensource.org/licenses/lgpl-license.php'
	  ),
		'NULL' => array(
			'disclaimer' => 'all'
		)
	);
	public static function getDocumentSize($mDocContent = null, $sFormat = 'auto', $iRoundCount=1) {
		$iDocLength = 0;
		if(is_string($mDocContent)) {
			$iDocLength = strlen($mDocContent); 
		} else if(is_resource($mDocContent)) {
			fseek($mDocContent, 0, SEEK_END);
			$iDocLength = ftell($mDocContent);
			rewind($mDocContent);
		} else if(is_numeric($mDocContent)) {
			$iDocLength = $mDocContent;
		}
		if($sFormat === 'auto') {
			$sFormat = 'B';
			if($iDocLength > 1024) {
				$sFormat = 'KiB';
			}
			if($iDocLength > (1024 * 1024)) {
				$sFormat = 'MiB';
			}
			if($iDocLength > (1024 * 1024 * 1024)) {
				$sFormat = 'GiB';
			}
			if($iDocLength > (1024 * 1024 * 1024 * 1024)) {
				$sFormat = 'TiB';
			}
		}
		if($sFormat === 'auto_iso') {
			$sFormat = 'B';
			if($iDocLength > 1000) {
				$sFormat = 'KB';
			}
			if($iDocLength > (1000 * 1000)) {
				$sFormat = 'MB';
			}
			if($iDocLength > (1000 * 1000 * 1000)) {
				$sFormat = 'GB';
			}
			if($iDocLength > (1000 * 1000 * 1000 * 1000)) {
				$sFormat = 'TB';
			}
		}
		$fOutputDividor = 1.0;
		switch($sFormat) {
			case "KB":
				$fOutputDividor = 1000;
				break;
			case "KiB":
				$fOutputDividor = 1024;
				break;
			case "MB":
				$fOutputDividor = 1000 * 1000;
				break;
			case "MiB":
				$fOutputDividor = 1024 * 1024;
				break;
			case "GB":
				$fOutputDividor = 1000 * 1000 * 1000;
				break;
			case "GiB":
				$fOutputDividor = 1024 * 1024 * 1024;
				break;
			case "TB":
				$fOutputDividor = 1000 * 1000 * 1000 * 1000;
				break;
			case "TiB":
				$fOutputDividor = 1024 * 1024 * 1024 * 1024;
				break;
		}
		return round($iDocLength/$fOutputDividor, $iRoundCount)." ".$sFormat;
	}

	public static function getDocumentsByKindAndCategory($sDocumentKind=null, $iDocumentCategory=null, $bDocumentKindIsNotInverted=true, $bExcludeExternallyManaged = true) {
		$oCriteria = self::getDocumentsByKindAndCategoryCriteria($sDocumentKind, $iDocumentCategory, $bDocumentKindIsNotInverted, $bExcludeExternallyManaged);
		$oCriteria->addAscendingOrderByColumn(self::NAME);
		return self::doSelect($oCriteria);
	}

	public static function getDocumentsByKindAndCategoryCriteria($sDocumentKind=null, $iDocumentCategory=null, $bDocumentKindIsNotInverted=true, $bExcludeExternallyManaged = true) {
		$oCriteria = self::getDocumentsCriteria($bExcludeExternallyManaged);
		if($iDocumentCategory !== null) {
			$oCriteria->add(self::DOCUMENT_CATEGORY_ID, $iDocumentCategory);
		}
		if($sDocumentKind !== null) {
			$oCriteria->add(self::DOCUMENT_TYPE_ID, array_keys(DocumentTypeQuery::findDocumentTypeAndMimetypeByDocumentKind($sDocumentKind, $bDocumentKindIsNotInverted)), Criteria::IN);
		}
		return $oCriteria;
	}
	
	public static function getDocumentsCriteria($bExcludeExternallyManaged = true) {
		$oCriteria = new Criteria();
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_TYPE_ID, DocumentTypePeer::ID);
		$oCriteria->addJoin(DocumentPeer::DOCUMENT_CATEGORY_ID, DocumentCategoryPeer::ID, Criteria::LEFT_JOIN);
		if($bExcludeExternallyManaged) {
			$oExternalCriterion = $oCriteria->getNewCriterion(DocumentPeer::DOCUMENT_CATEGORY_ID, null);
			$oExternalCriterion->addOr($oCriteria->getNewCriterion(DocumentCategoryPeer::IS_EXTERNALLY_MANAGED, false));
			$oCriteria->add($oExternalCriterion);
		}
		return $oCriteria;
	}
		
	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::DESCRIPTION, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}
		
	public static function getDocumentsByCategory($iDocumentCategory=null, $sDocumentKind=null) {
		return self::getDocumentsByKindAndCategory($sDocumentKind, $iDocumentCategory);
	}
	
	public static function getDocumentsByKindOfNotImage($bExcludeExternallyManaged = true) {
		return self::getDocumentsByKindAndCategory('image', null, false, $bExcludeExternallyManaged);
	}
	
	// changed this for use in get_link_array, ordered by category for easier access in tinymce
	public static function getDocumentsByKindOfImage($bExcludeExternallyManaged = true) {
		return self::getDocumentsByKindAndCategory('image', null, true, $bExcludeExternallyManaged);
	}

	public static function getDisplayUrl($iDocumentId, $aUrlParameters = array(), $sFileModule = 'display_document') {
		return LinkUtil::link(array($sFileModule, $iDocumentId), "FileManager", $aUrlParameters);
	}
	
	public static function mayOperateOnOwn($oUser, $mObject, $sOperation) {
		$bResult = parent::mayOperateOnOwn($oUser, $mObject, $sOperation);
		///When changing the sort or the category, I have to have the rights to said category as well
		if($bResult && ($mObject->isColumnModified(DocumentPeer::SORT) || $mObject->isColumnModified(DocumentPeer::DOCUMENT_CATEGORY_ID))) {
			return $mObject->getDocumentCategory() === null || $mObject->getDocumentCategory()->getIsExternallyManaged() || $mObject->getDocumentCategory()->mayBeUpdated($oUser);
		}
		return $bResult;
	}

}
