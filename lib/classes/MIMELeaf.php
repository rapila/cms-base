<?php

/**
* @package email
*/
class MIMELeaf extends MIMEPart {
	private $sContent;
	private $sMimeType;
	private $sCharset;
	private $sFileName;
	private $sDisposition;
	private $sCid;
	
	public function __construct($sContent, $sMimeType, $sEncoding, $sCharset = null, $sFileName = null, $sDisposition = null, $sCid = null) {
		$this->sContent = $sContent;
		$this->sMimeType = $sMimeType;
		$this->sEncoding = $sEncoding;
		$this->sCharset = $sCharset;
		if($sFileName !== null && $sDisposition === null) {
			$sDisposition = 'attachment';
		}
		$this->sFileName = $sFileName;
		$this->sDisposition = $sDisposition;
		$this->sCid = $sCid;
	}
	
	protected function finalizeHeaders() {
		$this->setHeader('Content-Type', $this->sMimeType, array('charset' => $this->sCharset));
		$this->setHeader('Content-Disposition', $this->sDisposition, array('filename' => '"'.$this->sFileName.'"'));
		$this->setHeader('Content-ID', $this->sCid);
	}
	
	public function getBody() {
		return $this->sContent;
	}
	
	public static function leafWithDocument($oDocument, $sEncoding = 'base64', $sDisposition = null, $sCharset = null, $sCid = null) {
		$sContent = self::encode(stream_get_contents($oDocument->getData()), $sEncoding);
		$sMimeType = $oDocument->getMimetype();
		$sFileName = $oDocument->getFullName();
		return new MIMELeaf($sContent, $sMimeType, $sEncoding, $sCharset, $sFileName, $sDisposition, $sCid);
	}
	
	public static function leafWithTemplate($oTemplate, $sMimeType, $sEncoding = '8bit', $sDisposition = null, $sFileName = null, $sCharset = null, $sCid = null) {
		$sContent = $oTemplate->render();
		if($sCharset === null) {
			$sCharset = $oTemplate->getCharset();
		}
		if($sFileName === true) {
			$sFileName = $oTemplate->getTemplateName();
		}
		return new MIMELeaf(self::encode($sContent, $sEncoding), $sMimeType, $sEncoding, $sCharset, $sFileName, $sDisposition, $sCid);
	}
	
	public static function leafWithText($sText, $sEncoding = '8bit', $sCharset = 'utf-8') {
		return new MIMELeaf(self::encode($sText, $sEncoding), 'text/plain', $sEncoding, $sCharset, null, null, null);
	}
	
	public static function encode($sContent, $sEncoding, $iLineLength = 76) {
		if($sEncoding === 'base64') {
			return self::encodeBase64($sContent, $iLineLength);
		} else if($sEncoding === 'quoted-printable') {
			return self::encodeQuotedPrintable($sContent, $iLineLength);
		} else if($sEncoding === 'none' || $sEncoding === '8bit' || $sEncoding === '7bit' || $sEncoding === 'binary') {
			return $sContent;
		} else {
			throw new Exception("Exception in MIMELeaf::encode(): Encoding $sEncoding is not known");
		}
	}
	
	public static function encodeBase64($sContent, $iMaxLineLength = 76) {
		return rtrim(chunk_split(base64_encode($sContent), $iMaxLineLength, EMail::SEPARATOR));
	}
	
	public static function encodeQuotedPrintable($sContent, $iMaxLineLength = 76, $bAlwaysEncodeSpaces = false, $bAlwaysEncodeTabs = false) {
		$aLines	 = preg_split("/\r?\n/", $sContent);
		$sEscape = '=';
		$sOutput = '';
		while (list(, $sLine) = each($aLines)) {
			$sLine = preg_split('||', $sLine, -1, PREG_SPLIT_NO_EMPTY);
			$iLineLength = count($sLine);
			$sNewLine = '';
			for ($i = 0; $i < $iLineLength; $i++) {
				$sCharValue = $sLine[$i];
				$iDecValue = ord($sCharValue);

				if (($iDecValue == 32) AND ($i == ($iLineLength - 1) || $bAlwaysEncodeSpaces)) {		// convert space at eol only
						$sCharValue = '=20';
				} elseif (($iDecValue == 9) AND ($i == ($iLineLength - 1) || $bAlwaysEncodeTabs)) {	 // convert tab at eol only
						$sCharValue = '=09';
				} elseif ($iDecValue == 9) {
						; // Do nothing if a tab.
				} elseif (($iDecValue == 61) OR ($iDecValue < 32 ) OR ($iDecValue > 126)) { // always encode "\t", which is *not* required
						$sCharValue = $sEscape.strtoupper(sprintf('%02s', dechex($iDecValue)));
				} elseif (($iDecValue == 46) AND ($sNewLine == '')) {
						//Bug #9722: convert full-stop at bol
						//Some Windows servers need this, won't break anything (cipri)
						$sCharValue = '=2E';
				}

				if ($iMaxLineLength !== -1 && (strlen($sNewLine) + strlen($sCharValue)) >= $iMaxLineLength) {				 // MAIL_MIMEPART_CRLF is not counted
						$sOutput .= $sNewLine.$sEscape.EMail::SEPARATOR;										// soft line break; " =\r\n" is okay
						$sNewLine = '';
				}
				$sNewLine .= $sCharValue;
			} // end of for
			$sOutput .= $sNewLine.EMail::SEPARATOR;
		}
		$sOutput = substr($sOutput, 0, -1 * strlen(EMail::SEPARATOR)); // Don't want last crlf
		return $sOutput;
	}
	
}
