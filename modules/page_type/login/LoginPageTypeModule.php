<?php
/**
  * @package modules.page_type
  */
class LoginPageTypeModule extends DefaultPageTypeModule {
  private $sAction;
  
  public function __construct(Page $oPage) {
    parent::__construct($oPage);
    $this->sAction = 'login';
  }

  public function display(Template $oTemplate) {
    if(Manager::isPost()) {
      ArrayUtil::trimStringsInArray($_POST);
    }
    
    //1st step: user clicked on the recovery link
    //  • Display email field
    if(isset($_REQUEST['password_forgotten'])) {
      $this->sAction = 'password_forgotten';
    }
    //2nd step: user has entered an email address
    //  • Send the email with the recovery link (and generate the hint)
    //  • Add confirmation message to flash
    if(isset($_POST['password_reset_user_name'])) {
      $this->sAction = LoginManager::sendResetMail(LinkUtil::link($this->oPage->getFullPathArray(), 'FrontendManager'));
    }
    //3rd step: user has clicked on the reset link in the e-mail
    //  • Validate the hint
    //  • Display a form for entering a new password (form also contains hidden fields for email and hint)
    //  • Add the referrer to the session (again)
    if(isset($_REQUEST['recover_username'])) {
      $this->sAction = LoginManager::passwordReset();
    }
    //4th step: user has submitted the new password
    //  • Validate the hint (again)
    //  • Validate password constraints
    //  • Set the new password (if valid)
    //  • Log in (if valid)
    //  • Redirect to the referrer (if valid)
    if(isset($_POST['new_password'])) {
      $this->sAction = LoginManager::loginNewPassword();
    }
    
    if(isset($_POST[LoginManager::USER_NAME])) {
      $iLogin = LoginManager::login();
    }
    
    return parent::display($oTemplate);
  }
  
  protected function getModuleContents($oModule) {
    if($oModule->getModuleName() === 'login') {
      return $oModule->renderFrontend($this->sAction);
    }
    return $oModule->renderFrontend();
  }
  
  public function backendInit() {
    return parent::backendInit();
  }
  
  public function backendSave() {
    return parent::backendSave();
  }
  
  protected function constructTemplate($sTemplateName = null, $bForceGlobalTemplatesDir = false) {
    try {
      return self::constructTemplateForModuleAndType($this->getType(), $this->getModuleName(), $sTemplateName, $bForceGlobalTemplatesDir);
    } catch (Exception $e) {
      return self::constructTemplateForModuleAndType($this->getType(), 'default', $sTemplateName, $bForceGlobalTemplatesDir);
    }
  }
}