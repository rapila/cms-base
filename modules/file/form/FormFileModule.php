<?php

require_once('FormFrontendModule.php');

class FormFileModule extends FileModule {

  private $iObjectId;
  private $sLanguageId;
  private $oFormStorage;
  private $sPageName;

  public function __construct($aRequestPath) {
    parent::__construct($aRequestPath);
    if(!isset($this->aPath[2])) {
      throw new Exception("Error in FormFileModule->__construct: no object ID or no language ID given");
    }
    $this->sLanguageId = $this->aPath[1];
    $this->iObjectId = $this->aPath[2];
    $oFormDataLanguageObject = LanguageObjectPeer::retrieveByPK($this->iObjectId, $this->sLanguageId);
    if($oFormDataLanguageObject == null || $oFormDataLanguageObject->getContentObject()->getObjectType() !== 'form') {
      throw new Exception("Error in FormFileModule->__construct: object ID does not correspond to form object in given language");
    }
    $this->oFormStorage = unserialize($oFormDataLanguageObject->getData()->getContents());
    $this->sPageName = $oFormDataLanguageObject->getContentObject()->getPage()->getName();
  }

  public function renderFile() {
    if($this->oFormStorage->getFormType() !== 'email') {
      throw new Exception("Error in FormFileModule->renderFile(): form type {$this->oFormStorage->getFormType()} is not supported");
    }
    $sEmailAddress = $this->oFormStorage->getFormOption('email_address');
    $sTemplateName = $this->oFormStorage->getFormOption('template_addition');
    if($sTemplateName) {
      $sTemplateName = 'e_mail_form_output_'.$sTemplateName;
    } else {
      $sTemplateName = 'e_mail_form_output';
    }
    $oEmailTemplate = $this->constructTemplate($sTemplateName);
    $oEmailItemTemplate = $this->constructTemplate('e_mail_form_item');
    foreach($this->oFormStorage->getFormObjects() as $oFormObject) {
      if($oFormObject->getType() === 'submit') {
        continue;
      }
      $oEmailItemTemplateInstance = clone $oEmailItemTemplate;
      $oEmailItemTemplateInstance->replaceIdentifier('name', $oFormObject->getName());
      $oEmailItemTemplateInstance->replaceIdentifier('label', $oFormObject->getLabel());
      $oEmailItemTemplateInstance->replaceIdentifier('value', $oFormObject->getCurrentValue());
      $oEmailTemplate->replaceIdentifierMultiple('form_content', $oEmailItemTemplateInstance);
    }
    $oEmail = new EMail(StringPeer::getString('form_module.email_subject', null, null, array('page' => $this->sPageName)), $oEmailTemplate);
    $oEmail->addRecipient($sEmailAddress);
    $oEmail->send();
    Util::redirect($_REQUEST['origin'].'?form_success=true');
  }

}