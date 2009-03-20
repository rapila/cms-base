<?php
/**
* @package email
*/
class EMail {
  private $aRecipients;
  private $aCarbonCopyRecipients;
  private $aBlindCarbonCopyRecipients;
  private $sCharset;
  private $sMimeType;
  private $oContent;
  private $sSenderName;
  private $sSenderAddress;
  private $sReplyTo;
  private $sSubject;
  
  private $oFlash;
  
  const SEPARATOR = "\r\n";
  
  public function __construct($sSubject, $oContent = null, $bIsHtml = false, $bUseMultipart = false) {
    $this->aRecipients = array();
    $this->aCarbonCopyRecipients = array();
    $this->aBlindCarbonCopyRecipients = array();
    
    if($oContent instanceof Template) {
      $this->sCharset = $oContent->getCharset();
    } else {
      $this->sCharset = Settings::getSetting('encoding', 'db', 'utf-8');
    }
    $this->sMimeType = 'text/plain';
    if($bIsHtml) {
      $this->sMimeType = 'text/html';
    }
    $this->oContent = $oContent;
    $this->sSenderName = null;
    $this->sSenderAddress = Settings::getSetting('domain_holder', 'email', 'mailer-daemon@localhost');
    $this->oFlash = new Flash();
    
    $this->sReplyTo = null;
    
    $this->sSubject = $sSubject;
  }
  
  public function setCharset($sCharset)
  {
      $this->sCharset = $sCharset;
  }

  public function getCharset()
  {
      return $this->sCharset;
  }
  
  public function setTemplate($oContent)
  {
      $this->oContent = $oContent;
  }

  public function getTemplate()
  {
      return $this->oContent;
  }
  
  public function setRecipients($aRecipients)
  {
      $this->aRecipients = $aRecipients;
  }

  public function getRecipients()
  {
      return $this->aRecipients;
  }
  
  public function setCarbonCopyRecipients($aCarbonCopyRecipients)
  {
      $this->aCarbonCopyRecipients = $aCarbonCopyRecipients;
  }

  public function getCarbonCopyRecipients()
  {
      return $this->aCarbonCopyRecipients;
  }
  
  public function setBlindCarbonCopyRecipients($aBlindCarbonCopyRecipients)
  {
      $this->aBlindCarbonCopyRecipients = $aBlindCarbonCopyRecipients;
  }

  public function getBlindCarbonCopyRecipients()
  {
      return $this->aBlindCarbonCopyRecipients;
  }
  
  public function addRecipient($sAddress, $sName = null) {
    $this->aRecipients[$sAddress] = $sName;
  }
  
  public function addCarbonCopyRecipient($sAddress, $sName = null) {
    $this->aCarbonCopyRecipients[$sAddress] = $sName;
  }
  
  public function addBlindCarbonCopyRecipient($sAddress, $sName = null) {
    $this->aBlindCarbonCopyRecipients[$sAddress] = $sName;
  }
  
  public function setSender($sSenderName, $sSenderAddress)
  {
      $this->sSenderName = $sSenderName;
      $this->sSenderAddress = $sSenderAddress;
  }

  public function getSender()
  {
      return array($this->sSenderName, $this->sSenderAddress);
  }
  
  public function setReplyTo($sReplyTo) {
      $this->sReplyTo = $sReplyTo;
  }

  public function getReplyTo() {
      return $this->sReplyTo;
  }
  
  public function send() {
    $aRecipients = array();
    
    foreach($this->aRecipients as $sAddress => $sName) {
      $aRecipients[] = $this->getAddressToken($sName, $sAddress);
    }
    
    $sRecipients = implode(', ', $aRecipients);
    
    if($this->oContent instanceof Template) {
      $this->oContent = MIMELeaf::leafWithTemplate($this->oContent, $this->sMimeType, '8bit', null, null, $this->sCharset);
    }
    
    foreach($this->aCarbonCopyRecipients as $sAddress => $sName) {
      $this->oContent->addToHeader("Cc", $this->getAddressToken($sName, $sAddress));
    }
    
    foreach($this->aBlindCarbonCopyRecipients as $sAddress => $sName) {
      $this->oContent->addToHeader("Bcc", $this->getAddressToken($sName, $sAddress));
    }
    
    if($this->sReplyTo !== null) {
      $this->oContent->addToHeader("Reply-To", $this->sReplyTo);
    }
    
    $this->oContent->setHeader('From', $this->getAddressToken($this->sSenderName, $this->sSenderAddress));
    
    $bResult = mb_send_mail($sRecipients, $this->sSubject, $this->oContent->getBody(), $this->oContent->getHeaderString());
    
    if($bResult === false) {
    	throw new Exception("Error in EMail->send(): mail() returned false");
    }
  }
  
  private function getAddressToken($sName, $sAddress) {
    $this->oFlash->setArrayToCheck(array('email' => $sAddress));
    $this->oFlash->checkForEmail('email', 'e_mail');
    if($this->oFlash->hasMessages()) {
      throw new Exception("Exception in EMail->getAddressToken(): address $sAddress not valid");
    }
    if($sName === null || trim($sName) === '') {
      return $sAddress;
    }
    if(strpos($sName, ',') !== false) {
      $sName = "\"$sName\"";
    }
    return "$sName <$sAddress>";
  }
}