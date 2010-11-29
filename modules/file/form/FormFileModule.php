<?php
/**
 * @package modules.file
 */

require_once(BASE_DIR.'/'.DIRNAME_MODULES.'/frontend/form/FormFrontendModule.php');

class FormFileModule extends FileModule {

  private $iObjectId;
  private $sLanguageId;
  private $oFormStorage;
  private $sPageName;
  private $sEmailAddress;
  private $oEmailTemplate;
  private $oEmailItemTemplate;

  public function __construct($aRequestPath) {
    parent::__construct($aRequestPath);
    if(!isset($this->aPath[1])) {
      throw new Exception("Error in FormFileModule->__construct: no object ID or no language ID given");
    }
    $this->sLanguageId = $this->aPath[0];
    $this->iObjectId = $this->aPath[1];
    $oFormDataLanguageObject = LanguageObjectPeer::retrieveByPK($this->iObjectId, $this->sLanguageId);
    if($oFormDataLanguageObject == null || $oFormDataLanguageObject->getContentObject()->getObjectType() !== 'form') {
      throw new Exception("Error in FormFileModule->__construct: object ID does not correspond to form object in given language");
    }
    $this->oFormStorage = unserialize(stream_get_contents($oFormDataLanguageObject->getData()));
    $this->sPageName = $oFormDataLanguageObject->getContentObject()->getPage()->getName();
    
    if($this->oFormStorage->getFormType() !== 'email') {
      throw new Exception("Error in FormFileModule->renderFile(): form type {$this->oFormStorage->getFormType()} is not supported");
    }
    $this->sEmailAddress = $this->oFormStorage->getFormOption('email_address');
    $sTemplateName = $this->oFormStorage->getFormOption('template_addition');
    if($sTemplateName) {
      $sTemplateName = 'e_mail_form_output_'.$sTemplateName;
    } else {
      $sTemplateName = 'e_mail_form_output';
    }
    $this->oEmailTemplate = $this->constructTemplate($sTemplateName);
    $this->oEmailItemTemplate = $this->constructTemplate('e_mail_form_item');
  }

  public function renderFile() {
    $aCurrentValues = $this->oFormStorage->saveCurrentValuesToSession();
    $oFlash = Flash::getFlash();
    $oFlash->setArrayToCheck($aCurrentValues);
    $bHasCaptcha = false;
    foreach($this->oFormStorage->getFormObjects() as $oFormObject) {
      if($oFormObject instanceof CaptchaObject) {
        $bHasCaptcha = true;
      }
      if($oFormObject->shouldExcludeFromReport()) {
        continue;
      }
      if($oFormObject->isRequired()) {
        $oFlash->checkForValue($oFormObject->getName());
      }
      $oEmailItemTemplateInstance = clone $this->oEmailItemTemplate;
      $oEmailItemTemplateInstance->replaceIdentifier('name', $oFormObject->getName());
      $oEmailItemTemplateInstance->replaceIdentifier('label', $oFormObject->getLabel());
      $oEmailItemTemplateInstance->replaceIdentifier('value', $oFormObject->getCurrentValue());
      $this->oEmailTemplate->replaceIdentifierMultiple('form_content', $oEmailItemTemplateInstance);
    }
    if($bHasCaptcha && !FormFrontendModule::validateRecaptchaInput()) {
      $oFlash->addMessage('captcha_code_required');
    }
    $oFlash->finishReporting();
    if(Flash::noErrors()) {
      $oEmail = new EMail(StringPeer::getString('form_module.email_subject', null, null, array('page' => $this->sPageName)), $this->oEmailTemplate);
      $oEmail->addRecipient($this->sEmailAddress);
      $oEmail->send();
      $this->oFormStorage->deleteCurrentValuesFromSession();
      LinkUtil::redirect($_REQUEST['origin'].'?form_success=true');
    } else {
      $oFlash->stick();
      LinkUtil::redirect($_REQUEST['origin']);
    }
  }

}