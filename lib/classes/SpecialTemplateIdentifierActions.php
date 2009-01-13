<?php
class SpecialTemplateIdentifierActions {
  private $oTemplate;
  
  public function __construct($oTemplate) {
    $this->oTemplate = $oTemplate;
  }
  
  public function writeSessionAttribute($oTemplateIdentifier) {
    return Session::getSession()->getAttribute($oTemplateIdentifier->getValue());
  }
  
  public function writeString($oTemplateIdentifier) {
    return StringPeer::getString($oTemplateIdentifier->getValue(), null, null, null, true, $this->oTemplate->iDefaultFlags);
  }
  
  public function writeParameterizedString($oTemplateIdentifier) {
    return StringPeer::getString($oTemplateIdentifier->getValue(), null, null, $oTemplateIdentifier->getParameters(), true, $this->oTemplate->iDefaultFlags);
  }
  
  public function writeFlashValue($oTemplateIdentifier) {
    return Flash::getFlash()->getMessage($oTemplateIdentifier->getValue());
  }
  
  public function normalize($oTemplateIdentifier) {
    return Util::normalize($oTemplateIdentifier->getValue());
  }
  
  public function truncate($oTemplateIdentifier) {
    $iLength=20;
    if($oTemplateIdentifier->hasParameter('length')) {
      $iLength = $oTemplateIdentifier->getParameter('length');
    }
    
    $sPostfix = "…";
    if($oTemplateIdentifier->hasParameter('postfix')) {
      $sPostfix = $oTemplateIdentifier->getParameter('postfix');
    }
    
    $iTolerance = 3;
    if($oTemplateIdentifier->hasParameter('tolerance')) {
      $iTolerance = $oTemplateIdentifier->getParameter('tolerance');
    }
    return Util::truncate($oTemplateIdentifier->getValue(), $iLength, $sPostfix, $iTolerance);
  }
  
  public function writeLink($oTemplateIdentifier) {
    $sDestination = $oTemplateIdentifier->getValue();
    $aParameters = $oTemplateIdentifier->getParameters();
    if($sDestination === "to_self") {
      $bIgnoreRequest = $oTemplateIdentifier->getParameter('ignore_request') === 'true';
      unset($aParameters['ignore_request']);
      return Util::linkToSelf(null, $aParameters, $bIgnoreRequest);
    }
    if($sDestination === "base_href") {
      return Util::absoluteLink(MAIN_DIR_FE);
    }
    $sManager = null;
    if($oTemplateIdentifier->hasParameter('manager')) {
      unset($aParameters['manager']);
      $sManager = $oTemplateIdentifier->getParameter('manager');
    }
    $bIsAbsolute = $oTemplateIdentifier->getParameter('is_absolute') === 'true';
    unset($aParameters['is_absolute']);
    if($bIsAbsolute) {
      return Util::absoluteLink(Util::link($sDestination, $sManager, $aParameters));
    } else {
      return Util::link($sDestination, $sManager, $aParameters);
    }
  }
  
  public function includeTemplate($oTemplateIdentifier, &$iFlags) {
    $oTemplate = new Template($oTemplateIdentifier->getValue(), $this->oTemplate->getTemplatePath(), false, false, null, $this->oTemplate->getTemplateName());
    $iFlags = Template::LEAVE_IDENTIFIERS|Template::NO_RECODE;
    if($oTemplateIdentifier->hasParameter('omitIdentifiers')) {
      $iFlags = Template::NO_RECODE;
    }
    return $oTemplate;
  }
  
  public function writeDate($oTemplateIdentifier) {
    return Util::localizeDate(null, null, $oTemplateIdentifier->getValue());
  }
  
  public function writeRequestValue($oTemplateIdentifier) {
    if(isset($_REQUEST[$oTemplateIdentifier->getValue()])) {
      return $_REQUEST[$oTemplateIdentifier->getValue()];
    }
    return null;
  }
  
  public function writeSettingValue($oTemplateIdentifier) {
    if(!$oTemplateIdentifier->hasParameter('section')) {
      return null;
    }
    return Settings::getSetting($oTemplateIdentifier->getParameter('section'), $oTemplateIdentifier->getValue(), null);
  }
  
  public function writeManagerPrefix($oTemplateIdentifier) {
    return Manager::getPrefixForManager($oTemplateIdentifier->getValue());
  }
  
  public function writeConstantValue($oTemplateIdentifier) {
    return constant($oTemplateIdentifier->getValue());
  }
  
  public function writeTemplateName($oTemplateIdentifier) {
    return $this->oTemplate->getTemplateName();
  }
    
  public static function getSpecialIdentifierNames() {
    return array_diff(get_class_methods('SpecialTemplateIdentifierActions'), array('getSpecialIdentifierNames', 'getAlwaysLastNames', '__construct'));
  }
  
  public static function getAlwaysLastNames() {
      return array('writeParameterizedString', 'writeFlashValue', 'writeRequestValue');
  }
}