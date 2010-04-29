<?php
/**
* @package email
*/
abstract class MIMEPart {
	protected $aHeaders = array();
	protected $sEncoding = null;
	
	public function addToHeader($sName, $sValue) {
		if(isset($this->aHeaders[$sName])) {
			$this->aHeaders[$sName] = $this->aHeaders[$sName] . ", $sValue";
		} else {
			$this->setHeader($sName, $sValue);
		}
	}
	
	public function setHeader($sName, $sValue, $aParameters = array()) {
		if($sValue === null) {
			return;
		}
		foreach($aParameters as $sParameterName => $sParameterValue) {
			if($sParameterValue !== null) {
				$sValue .= "; $sParameterName=\"$sParameterValue\"";
			}
		}
		$this->aHeaders[$sName] = $sValue;
	}
	
	public function removeHeader($sName) {
		unset($this->aHeaders[$sName]);
	}
	
	public function getHeaders() {
		$aImpliedHeaders = array('MIME-Version' => '1.0');
		if($this->sEncoding !== null) {
			$aImpliedHeaders['Content-Transfer-Encoding'] = $this->sEncoding;
		}
		$this->finalizeHeaders();
		
		return array_merge($aImpliedHeaders, $this->aHeaders);
	}
	
	public function getHeaderString() {
		$aHeaders = array();
		foreach($this->getHeaders() as $sHeaderName => $sHeaderValue) {
			$aHeaders[] = "$sHeaderName: $sHeaderValue";
		}
		
		return $sHeaders = implode(EMail::SEPARATOR, $aHeaders);
	}
	
	public function getMessage() {
		return $this->getHeaderString().EMail::SEPARATOR.EMail::SEPARATOR.$this->getBody();
	}
	
	protected abstract function finalizeHeaders();
	public abstract function getBody();
}