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

	public static function addSearchToCriteria($sSearch, $oCriteria) {
		$oSearchCriterion = $oCriteria->getNewCriterion(self::NAME, "%$sSearch%", Criteria::LIKE);
		$oSearchCriterion->addOr($oCriteria->getNewCriterion(self::DESCRIPTION, "%$sSearch%", Criteria::LIKE));
		$oCriteria->add($oSearchCriterion);
	}
	
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

	/**
	*	@deprecated
	* use query methods of DocumentQuery and document related query classes and query notation in general directly
	*/
	public static function getDocumentsByKindAndCategory($sDocumentKind=null, $iDocumentCategory=null, $bDocumentKindIsNotInverted=true, $bExcludeExternallyManaged = true) {
		$oQuery = DocumentQuery::create()->joinDocumentType();
		if($bExcludeExternallyManaged) {
			$oQuery->excludeExternallyManaged();
		}
		if($iDocumentCategory !== null) {
			$oQuery->filterByDocumentCategory($iDocumentCategory);
		}
		if($sDocumentKind !== null) {
			$oQuery->filterByDocumentKind($sDocumentKind, $bDocumentKindIsNotInverted);
		}
		return $oQuery->orderByName()->find();
	}
	
	/**
	*	@deprecated
	*/
	public static function getDocumentsByCategory($iDocumentCategory=null, $sDocumentKind=null) {
		return self::getDocumentsByKindAndCategory($sDocumentKind, $iDocumentCategory);
	}
	
	/**
	*	@deprecated
	*/
	public static function getDocumentsByKindOfNotImage($bExcludeExternallyManaged = true) {
		return self::getDocumentsByKindAndCategory('image', null, false, $bExcludeExternallyManaged);
	}
	
	/**
	*	@deprecated
	*/
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
