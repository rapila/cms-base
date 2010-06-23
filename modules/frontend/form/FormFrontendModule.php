<?php
/**
 * @package modules.frontend
 */

require_once('recaptcha/recaptchalib.php');

class FormFrontendModule extends DynamicFrontendModule {
	
	public function __construct(LanguageObject $oLanguageObject = null, $aRequestPath = null, $iId = 1) {
		parent::__construct($oLanguageObject, $aRequestPath, $iId);
	}

	public function renderFrontend() {
		$oFormStorage = $this->getFormStorage();
		$oTemplate = $this->constructTemplate("form_".$oFormStorage->getFormType());
		$oFormStorage->addFormOption("object_id", $this->oLanguageObject->getObjectId());
		$oFormStorage->renderForm($oTemplate, $this->iId);
		return $oTemplate;
	}
	
	public function renderBackend() {
		$oFormStorage = $this->getFormStorage();
		$oTemplate = $this->constructTemplate('backend');
		$oTemplate->replaceIdentifier('request_methods', TagWriter::optionsFromArray(ArrayUtil::arrayWithValuesAsKeys(array('post', 'get')), $oFormStorage->getRequestMethod(), "", array()));
		$oTemplate->replaceIdentifier('form_types', TagWriter::optionsFromArray(array('email' => StringPeer::getString('form_type.email'), 'external' => StringPeer::getString('form_type.external'), 'manager' => StringPeer::getString('form_type.manager')), $oFormStorage->getFormType(), "", array()));
		foreach($oFormStorage->getFormObjects() as $iKey => $oFormObject) {
			$oObjectTemplate = $this->constructTemplate('backend_form_field');
			$oObjectTemplate->replaceIdentifier('field_name', $oFormObject->getName());
			$oObjectTemplate->replaceIdentifier('field_label', $oFormObject->getLabel());
			$oObjectTemplate->replaceIdentifier('default_value', $oFormObject->getDefaultValue());
			$oObjectTemplate->replaceIdentifier('class_name', $oFormObject->getClassName());
			$oObjectTemplate->replaceIdentifier('is_required_checked', $oFormObject->isRequired() ? ' checked="checked"' : '', null, Template::NO_HTML_ESCAPE);
			$oObjectTemplate->replaceIdentifier('sequence_id', $iKey);
			$oObjectTemplate->replaceIdentifier('available_types', TagWriter::optionsFromArray(ArrayUtil::arrayWithValuesAsKeys(FormStorage::getAvailableTypes()), $oFormObject->getType(), "", array()));
			$oTemplate->replaceIdentifierMultiple('form_fields', $oObjectTemplate, null, Template::LEAVE_IDENTIFIERS);
		}
		$oTemplate->replaceIdentifier('form_id', $this->iId);
		$oTemplate->replaceIdentifier('form_action', $oFormStorage->getFormOption('form_action'));
		$oTemplate->replaceIdentifier('email_address', $oFormStorage->getFormOption('email_address'));
		$oTemplate->replaceIdentifier('template_addition', $oFormStorage->getFormOption('template_addition'));
		$oTemplate->replaceIdentifier('manager', TagWriter::optionsFromArray(ArrayUtil::arrayWithValuesAsKeys(Manager::listManagers()), $oFormStorage->getFormOption('manager')));
		$oTemplate->replaceIdentifier('available_types', TagWriter::optionsFromArray(ArrayUtil::arrayWithValuesAsKeys(FormStorage::getAvailableTypes()), null, "", array()));
		return $oTemplate;
	}
	
	public function getSaveData() {
		$oFormStorage = $this->getFormStorage();
		$oFormStorage->clearObjects();
		$oFormStorage->clearOptions();
		$oFormStorage->setRequestMethod($_POST['request_method']);
		$oFormStorage->setFormType($_POST['form_type']);
		if($oFormStorage->getFormType() === "external") {
			$oFormStorage->addFormOption("form_action", $_POST['form_action']);
		}
		if($oFormStorage->getFormType() === "email") {
			$oFormStorage->addFormOption("email_address", $_POST['email_address']);
			$oFormStorage->addFormOption("template_addition", $_POST['template_addition']);
		}
		if($oFormStorage->getFormType() === "manager") {
			$oFormStorage->addFormOption("manager", $_POST['manager']);
		}

		foreach($_POST['field_names_'.$this->iId] as $iKey => $sFieldName) {
			if($sFieldName === "") {
				continue;
			}
			$oFormObject = null;
			if($_POST['field_types_'.$this->iId][$iKey] === 'captcha') {
				$oFormObject = new CaptchaObject($_POST['field_types_'.$this->iId][$iKey]);
			} else {
				$oFormObject = new FormObject($_POST['field_types_'.$this->iId][$iKey]);
			}
			$oFormObject->setName($sFieldName);
			$oFormObject->setLabel($_POST['field_labels_'.$this->iId][$iKey]);
			$oFormObject->setDefaultValue($_POST['default_values_'.$this->iId][$iKey]);
			$oFormObject->setClassName($_POST['class_names_'.$this->iId][$iKey]);
			$oFormObject->setIsRequired(isset($_POST['is_required_'.$this->iId.'_'.$iKey]));
			$oFormStorage->addFormObject($oFormObject);
		}
		return serialize($oFormStorage);
	} // save()
	
	private function getFormStorage() {
		$oFormStorage = @unserialize($this->getData());
		if(!($oFormStorage instanceof FormStorage)) {
			$oFormStorage = new FormStorage($this->oLanguageObject);
		}
		return $oFormStorage;
	}
	
	public function getJsForBackend() {
		return $this->constructTemplate("backend.js")->render();
	}
 
	public static function getRecaptchaCode($sId = '') {
		$oTemplate = self::constructTemplateForModuleAndType(self::$MODULE_TYPE, 'form', 'recaptcha');
		$oTemplate->replaceIdentifier('server', RECAPTCHA_API_SERVER);
		$oTemplate->replaceIdentifier('key', Settings::getSetting('frontend', 're_captcha_public_key', '6Lfm_gQAAAAAACIbK9PxwwhDhkGJHcHEcdIRRRR9'));
		$oTemplate->replaceIdentifier('id', 'recaptcha_content_'.$sId);
		return $oTemplate;
	}
	
	public static function validateRecaptchaInput() {
		$oAnswer = recaptcha_check_answer(Settings::getSetting('frontend', 're_captcha_private_key', '6Lfm_gQAAAAAALjNy87IkZ8An1gryBROu40vxgJi'), $_SERVER["REMOTE_ADDR"], @$_POST["recaptcha_challenge_field"], @$_POST["recaptcha_response_field"]);
		return $oAnswer->is_valid;
	}
	
	public static function getContentInfo($oLanguageObject) {
		$oFormStorage = unserialize(stream_get_contents($oLanguageObject->getData()));
		
		$sType = $oFormStorage->getFormType();
		$sAction = '';
		if($sType === "external") {
			$sAction = $oFormStorage->getFormOption('form_action');
		} else if($sType === "email") {
			$sAction = $oFormStorage->getFormOption('email_address');
		} else if($sType === "manager") {
			$sAction = $oFormStorage->getFormOption('manager');
		}
		return $sType.' » '.$sAction.' ['.strtoupper($oFormStorage->getRequestMethod()).']';
	}
}

class FormStorage {
	private $aFormObjects;
	private $sFormType;
	private $aFormOptions;
	private $sFormSessionKeyPart;
	private $sRequestMethod;
	
	public function __construct(LanguageObject $oLanguageObject) {
		$this->sFormSessionKeyPart = $oLanguageObject->getLanguageId()."_".$oLanguageObject->getObjectId();
		$this->sRequestMethod = "post";
		$this->aFormObjects = array();
		$this->aFormOptions = array();
		$this->sFormType = "general";
	}
	
	public function renderForm($oTemplate, $iFormId) {
		foreach($this->aFormObjects as $oFormObject) {
			$oTemplate->replaceIdentifierMultiple('form_objects', $oFormObject->renderFormObject($iFormId));
		}
		
		$oValidationObject = new FormObject('hidden', 'form_action', 'form_frontend_module_'.$iFormId, $this);
		$oTemplate->replaceIdentifierMultiple('form_objects', $oValidationObject->renderFormObject($iFormId));
		$oOriginObject = new FormObject('hidden', 'origin', LinkUtil::linkToSelf(), $this);
		$oTemplate->replaceIdentifierMultiple('form_objects', $oOriginObject->renderFormObject($iFormId));

		foreach($this->aFormOptions as $sOptionName => $sOptionValue) {
			$oTemplate->replaceIdentifier('option', $sOptionValue, $sOptionName);
		}
		$oTemplate->replaceIdentifier('method', $this->getRequestMethod());
	}
	
	public function getFormSessionKey() {
		return "form_".md5($this->sFormSessionKeyPart);
	}
	
	public function getRequestProperty($sName) {
		if($this->sRequestMethod === "post") {
			return @$_POST[$sName];
		}
		return @$_GET[$sName];
	}
	
	public function addFormObject(FormObject $oFormObject) {
		$oFormObject->setParent($this);
		$this->aFormObjects[] = $oFormObject;
	}
	
	public function addFormOption($sOptionName, $sOptionValue) {
		$this->aFormOptions[$sOptionName] = $sOptionValue;
	}
	
	public function getFormOption($sOptionName) {
		return @$this->aFormOptions[$sOptionName];
	}
	
	public function getFormObjects() {
		return $this->aFormObjects;
	}
	
	public function getFormOptions() {
		return $this->aFormOptions;
	}
	
	public function &saveCurrentValuesToSession() {
		$aCurrentValues = array();
		foreach($this->aFormObjects as $oFormObject) {
			$aCurrentValues[$oFormObject->getName()] = $oFormObject->getCurrentValue();
		}
		$oSession = Session::getSession();
		$oSession->setAttribute($this->getFormSessionKey(), $aCurrentValues);
		return $aCurrentValues;
	}
	
	public function deleteCurrentValuesFromSession() {
		Session::getSession()->resetAttribute($this->getFormSessionKey());
	}
	
	public function getCurrentValueFor($sName) {
		$sProperty = $this->getRequestProperty($sName);
		if($sProperty !== null) {
			return $sProperty;
		}
		$oSession = Session::getSession();
		$sSessionKey = $this->getFormSessionKey();
		if(!$oSession->hasAttribute($sSessionKey)) {
			$oSession->setAttribute($sSessionKey, array());
		}
		
		$aFormAttributes = $oSession->getAttribute($sSessionKey);
		return @$aFormAttributes[$sName];
	}
	
	public function setRequestMethod($sRequestMethod) {
			$this->sRequestMethod = $sRequestMethod;
	}

	public function getRequestMethod() {
			return $this->sRequestMethod;
	}
	
	public function setFormType($sFormType) {
			$this->sFormType = $sFormType;
	}

	public function getFormType() {
			return $this->sFormType;
	}
	
	public function clearObjects() {
		$this->aFormObjects = array();
	}
	
	public function clearOptions() {
		$this->aFormOptions = array();
	}
	
	public static function getAvailableTypes() {
		return array('text', 'textarea', 'password', 'submit', 'hidden', 'flash', 'captcha');
		// return array('textarea', 'text', 'password', 'submit', 'select', 'checkbox', 'radio', 'button');
	}
}

class FormObject {
	private $sType;
	private $sDefaultValue;
	private $sLabel;
	private $sName;
	private $sClassName;
	private $oParent;
	private $sValidator;
	private $bIsRequired;
	
	public function __construct($sType, $sName = null, $sDefaultValue = null, $oParent = null, $sClassName = null) {
		$this->sType = $sType;
		$this->sName = $sName;
		$this->sDefaultValue = $sDefaultValue;
		$this->sClassName = $sClassName;
		$this->oParent = $oParent;
		$this->sValidator = null;
		$this->bIsRequired = true;
	}
	
	public function renderFormObject($iFormId) {
		$oKeyValueTemplate = new Template("{{label}} {{field}} {{identifierContext=start;name=writeFlashValue;value=\{\{name\}\}}}<br />{{writeFlashValue=\{\{name\}\}}}{{identifierContext=end;name=writeFlashValue;value=\{\{name\}\}}}", null, true);
		$oKeyValueTemplate->replaceIdentifier('field', $this->getFieldCode($iFormId));
		$oKeyValueTemplate->replaceIdentifier("name", $this->sName);
		$sTagName = 'p';
		if($this->isVisibleFormElement()) {
			if($this->sLabel === '') {
				$this->sLabel = new Template(' ', null, true); //nbsp
			}
			$oKeyValueTemplate->replaceIdentifier("label", TagWriter::quickTag("label", array('for' => $this->getFormObjectId($iFormId), 'class' => $this->sClassName), $this->sLabel));
		} else {
			$sTagName = 'span';
		}
		return TagWriter::quickTag($sTagName, array('class' => $this->sClassName), $oKeyValueTemplate);
	}
	
	//methods for deciding how to render a form object
	protected function isVisibleFormElement() {
		return $this->sType !== 'hidden';
	}
	
	protected function getFormObjectId($iFormId) {
		return 'form_'.$iFormId.'_'.$this->sName;
	}
	
	protected function getFieldCode($iFormId) {
		if($this->sType === 'textarea') {
			return TagWriter::quickTag($this->sType, array('id' => $this->getFormObjectId($iFormId), 'name' => $this->sName, 'class' => $this->sClassName), $this->getCurrentValue());
		}
		return TagWriter::quickTag('input', array('value' => $this->getCurrentValue(), 'id' => $this->getFormObjectId($iFormId), 'name' => $this->sName, 'type' => $this->sType, 'class' => $this->sClassName));
	}
	
	public function shouldExcludeFromReport() {
		return $this->sType === 'submit';
	}
	
	public function setParent($oParent) {
			$this->oParent = $oParent;
	}

	public function getParent() {
			return $this->oParent;
	}
	
	public function setLabel($sLabel) {
			$this->sLabel = $sLabel;
	}

	public function getLabel() {
			return $this->sLabel;
	}
	
	public function setDefaultValue($sDefaultValue) {
			$this->sDefaultValue = $sDefaultValue;
	}

	public function getDefaultValue() {
			return $this->sDefaultValue;
	}
	
	public function setType($sType) {
			$this->sType = $sType;
	}

	public function getType() {
			return $this->sType;
	}
	
	public function setName($sName) {
			$this->sName = $sName;
	}

	public function getName() {
			return $this->sName;
	}
	
	public function setClassName($sClassName) {
			$this->sClassName = $sClassName;
	}

	public function getClassName() {
			return $this->sClassName;
	}
	
	public function setValidator($sValidator) {
			$this->sValidator = $sValidator;
	}

	public function getValidator() {
			return $this->sValidator;
	}
	
	public function setIsRequired($bIsRequired) {
			$this->bIsRequired = $bIsRequired;
	}

	public function isRequired() {
			return $this->bIsRequired;
	}
	
	public function getCurrentValue() {
		$sValue = $this->oParent->getCurrentValueFor($this->sName);
		if($sValue === null) {
			$sValue = $this->sDefaultValue;
		}
		return $sValue;
	}
}

class CaptchaObject extends FormObject {
	public function __construct($sType, $sName = null, $sDefaultValue = null, $oParent = null, $sClassName = null) {
		parent::__construct($sType, $sName, $sDefaultValue, $oParent, $sClassName);
	}
	
	protected function getFormObjectId($iFormId) {
		return 'recaptcha_response_field';
	}
	
	protected function getFieldCode($iFormId) {
		return FormFrontendModule::getRecaptchaCode('form_frontend_module_'.$iFormId);
	}
	
	public function shouldExcludeFromReport() {
		return true;
	}
	
	protected function isVisibleFormElement() {
		return true;
	}
}