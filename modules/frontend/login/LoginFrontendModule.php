<?php

class LoginFrontendModule extends DynamicFrontendModule {
  private $oPage;

  private static $ACTIONS = array('login_simple', 'login_with_password_forgotten');

  public function __construct(LanguageObject $oLanguageObject = null, $aRequestPath = null, $iId = 1) {
    parent::__construct($oLanguageObject, $aRequestPath, $iId);
    $this->oPage = Manager::getCurrentPage();
  }

  public function renderFrontend($sAction = 'login') {
    $aOptions = @unserialize($this->getData());
    $sLoginType = isset($aOptions['login_type']) ? $aOptions['login_type'] : 'login_simple';
    if(Session::getSession()->getUser() && Session::getSession()->getUser()->mayViewPage($this->oPage)) {
      $oTemplate = $this->constructTemplate('logout');
      $oTemplate->replaceIdentifier('fullname', Session::getSession()->getUser()->getFullName());
      $oTemplate->replaceIdentifier('action', LinkUtil::link($this->oPage->getFullPathArray(), null, array('logout' => 'true')));
      return $oTemplate;
    }
    $oTemplate = $this->constructTemplate('login');
    $oTemplate->replaceIdentifier('login_action', $sAction);
    $oTemplate->replaceIdentifier('login_title', StringPeer::getString('login'));
    $oTemplate->doIncludes();
    $oTemplate->replaceIdentifier('action', LinkUtil::linkToSelf(null, null, true));
    if($sAction === 'login') {
      $this->renderLogin($oTemplate, $sLoginType);
    }
    return $oTemplate;
  }
 
  private function renderLogin($oTemplate, $sLoginType) {
    if($sLoginType === 'login_with_password_forgotten') {
      $oTemplate->replaceIdentifier('password_forgotten_action', LinkUtil::linkToSelf(null, array('password_forgotten' => 'true'), true));
    }
  }

  public function renderBackend() {
    $aOptions = @unserialize($this->getData());
    $oTemplate = $this->constructTemplate('backend');
    $oTemplate->replaceIdentifier('login_types', TagWriter::optionsFromArray(ArrayUtil::arrayWithValuesAsKeys(self::$ACTIONS), @$aOptions['login_type'], false, array()));
    return $oTemplate;
  }

  private function executeRecover() {
  }

  public function save(Blob $oData) {
    $oData->setContents(serialize($_POST));
  }
}
