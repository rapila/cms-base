<?php
/**
 * @package utils
 */
class DocumentUtil {
 /**
	* updateDocument()
	* @param string : uplaod input[type=file] name 
	* @param int : document_id if insert
	* @param int : optional document_category_id
	* @param string : optional document description
	* @param string : optional language_id (if not international)
	* 
	* @return int : document_id
	*/														 
	public static function updateDocument($sUploadFileName, 
																				$iDocumentId=null, 
																				$sDocumentName=null, 
																				$iDocumentCategoryId=null, 
																				$sLanguageId=null) {

		// nice to have flash check integrated
		$oDocument = DocumentPeer::retrieveByPK($iDocumentId);
		if($oDocument === null || !$iDocumentId) {
			$oDocument = new Document();
			$oDocument->setData(new Blob());
			$oDocument->setOwnerId(Session::getSession()->getUser()->getId());
		}
		$oDocument->setDocumentCategoryId($iDocumentCategoryId);
		if($sLanguageId !== null) {
			$oDocument->setLanguageId($sLanguageId);
		}
		$oDocument->setDescription(null);
		
		$aFileName = explode(".", $_FILES[$sUploadFileName]['name']);
		if(count($aFileName) > 1) {
			array_pop($aFileName);
		}

		$oDocument->setName($sDocumentName.': '.implode(".", $aFileName));
		$oDocument->getData()->readFromFile($_FILES[$sUploadFileName]['tmp_name']);
		$oDocument->setData($oDocument->getData());
		$oDocumentType = DocumentTypePeer::getDocumentTypeForUpload($sUploadFileName);
		$oDocument->setDocumentType($oDocumentType);
		$oDocument->save();
		return $oDocument->getId();
	}

	public static function getDocumentSize($mDocContent = null, $sFormat = 'auto') {
		$iDocLength = 0;
		if(is_string($mDocContent)) {
			$iDocLength = strlen($mDocContent); 
		} else if($mDocContent instanceof Blob) {
			$iDocLength = strlen($mDocContent->getContents()); 
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
		return round($iDocLength/$fOutputDividor, 2)." ".$sFormat;
	}
}