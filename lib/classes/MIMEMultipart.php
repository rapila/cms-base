<?php
/**
* @package email
*/
class MIMEMultipart extends MIMEPart {
	private $aParts;
	private $sPartSeparator;
	private $sMultipartType;
	
	public function __construct($sMultipartType = 'mixed') {
		$this->sMultipartType = $sMultipartType;
		srand((double)microtime()*1000000);
		$this->sPartSeparator = 'mime_'. md5(rand() . microtime());
		$this->aParts = array();
		$this->sEncoding = 'binary';
	}
	
	public function addPart(MIMEPart $oPart) {
		$this->aParts[] = $oPart;
	}
	
	protected function finalizeHeaders() {
		$this->setHeader('Content-Type', "multipart/$this->sMultipartType", array('boundary' => $this->sPartSeparator));
	}
	
	public function getBody() {
		$sPartSeparator = '--'.$this->sPartSeparator;
		$aParts = array();
		foreach($this->aParts as $oPart) {
			$aParts[] = $oPart->getMessage();
		}
		return $sPartSeparator.EMail::SEPARATOR.rtrim(implode(EMail::SEPARATOR.$sPartSeparator.EMail::SEPARATOR, $aParts), EMail::SEPARATOR).EMail::SEPARATOR.$sPartSeparator.'--'.EMail::SEPARATOR;
	}
	
	public static function alternativeMultipartForTemplate($oTemplate, $sAlternative = null, $sCharset = null) {
		require_once('markdownify/Markdownify_Extra.php');
		$oMarkdownify = new Markdownify_Extra(false, false, false);
		$sContent = $oTemplate->render();
		if($sCharset === null) {
			$sCharset = $oTemplate->getCharset();
		}
		if($sAlternative === null) {
			$sAlternative = $sContent;
		}
		$oMimeTree = new MIMEMultipart('alternative');
		$oMimeTree->addPart(MIMELeaf::leafWithText($oMarkdownify->parseString($sAlternative), '8bit', $sCharset));
		$oMimeTree->addPart(new MIMELeaf($sContent, 'text/html', '8bit', $sCharset));
		
		return $oMimeTree;
	}
}