<?php
/**
 * class BackendManager
 * @package manager
 */
class BackendManager extends Manager {
	
	private $oTemplate;
	private $sModuleName;
	private $iId = null;
	private $oBackendModule = null;
	private $aBackendSettings = null;
	private $oUser;
	const CONTENT_EDIT_LANGUAGE_SESSION_KEY = 'content_edit_language';
	const LAST_REQUESTED_PAGE_SESSION_KEY = 'last_requested_page_info';

 /**
	* __construct()
	*/
	public function __construct() {
		parent::__construct();
		if(!Session::getSession()->isAuthenticated() || !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
			if(Session::getSession()->isAuthenticated() && !Session::getSession()->getUser()->getIsBackendLoginEnabled()) {
				Flash::getFlash()->addMessage('backend_login_denied');
				Flash::getFlash()->stick();
			}
			unset($_REQUEST["logout"]);
			unset($_REQUEST["be_logout"]);
			Session::getSession()->setAttribute('login_referrer', LinkUtil::linkToSelf(Manager::getRequestedPath()));
			LinkUtil::redirectToManager('', 'LoginManager');
		}
		if(isset($_REQUEST['be_logout'])) {
			Cache::clearAllCaches();
			$bLogoutBackToLogin = Settings::getSetting('general', 'logout_to_login', false, 'backend');
			$aLogoutParam = array('logout' => 'true');
			if($bLogoutBackToLogin) {
				LinkUtil::redirect(LinkUtil::linkToSelf(null, $aLogoutParam));
			} else {
				$oPage = isset($_REQUEST['page_id']) ? PagePeer::retrieveByPK($_REQUEST['page_id']) : null;
				LinkUtil::redirect(self::getWebLink(($oPage !== null) ? $oPage->getFullPathArray() : array(), $aLogoutParam));
			}
		}
		if(Session::getSession()->getUser()->getLanguageId() != null) {
			Session::getSession()->setLanguage(Session::getSession()->getUser()->getLanguageId());
		} else {
			if(!in_array(Session::language(), LanguagePeer::getBackendLanguages())) {
				Session::getSession()->setLanguage("de");
			}
		}
		
		$this->aBackendSettings = Session::getSession()->getUser()->getBackendSettingsValue();
		
		if(isset($_REQUEST['content_language'])) {
			self::setContentEditLanguage($_REQUEST['content_language']);
		}

		$this->oUser = Session::getSession()->getUser();
		if(self::hasNextPathItem()) {
			$this->sModuleName = self::usePath();
			// write last pages or content request to session
			if($this->sModuleName === 'content' || $this->sModuleName === 'pages') { 
				$this->handleLastRequestedPagePersistance();
			}
		} else {
			if($this->oUser->isFirstAdministrator() && $this->oUser->requiresUserName()) {
				Flash::getFlash()->addMessage('backend_first_user_name_required');
				Flash::getFlash()->stick();
				LinkUtil::redirectToManager(array('users', $this->oUser->getId()));
			}
			$aModuleNames = array_keys(ArrayUtil::assocPeek($this->aBackendSettings));
			LinkUtil::redirectToManager($aModuleNames[0]);
		}
		if(isset($_REQUEST['select_link'])) {
			LinkUtil::redirectToManager($_REQUEST['select_link']);
		}
	}
	
	private function handleLastRequestedPagePersistance() {
		// dont't do anything
		if(Manager::isPost() || isset($_REQUEST['action']) || isset($_REQUEST['get_module_info'])) {
			return;
		}
		// if no specific page is called check last_requested_page_session
		if(Manager::peekNextPathItem() == null) {
			if($aLastPageEditArray = Session::getSession()->getAttribute(self::LAST_REQUESTED_PAGE_SESSION_KEY)) {
				if(isset($aLastPageEditArray[1]) && $aLastPageEditArray[1] != null) {
					LinkUtil::redirect(LinkUtil::link($aLastPageEditArray[0]));
				}
			}
		} else {
			Session::getSession()->setAttribute(self::LAST_REQUESTED_PAGE_SESSION_KEY, array(Manager::getRequestedPath(), Manager::peekNextPathItem()));
		}
	}

	private function createTemplate() {
		if($this->oTemplate !== null) {
			return;
		}
		$oOutput = new XHTMLOutput('transitional');
		$oOutput->render();
		$this->oTemplate = new Template('be_main', null, false, true);
		$this->oTemplate->replaceIdentifier("title", Settings::getSetting('backend', 'title', 'no title set in config/config.yml for backend'), null, Template::LEAVE_IDENTIFIERS);
	}

 /**
	* render()
	* @return void
	*/
	public function render() {
		try {
			$this->fillBackend();
		} catch (PropelException $pe) {
			$this->createTemplate();
			if($pe->getCause() instanceof Exception) {
				$this->fillException($pe->getCause());
			} else {
				$this->fillException($pe, $pe->getCause());
			}
		} catch (Exception $e) {
			$this->createTemplate();
			$this->fillException($e);
		}
		try {
			$this->fillBackendNavigation();
		} catch (Exception $e) {
			$this->fillException($e);
		}
		try {
			$this->fillAttributes();
		} catch (Exception $e) {
			$this->fillException($e);
		}
		
		$this->oTemplate->render();
	}

 /**
	* fillException()
	* @param object Exception
	* @param string optional message
	* @return void
	*/
	private function fillException($e, $sMessage = null) {
		$this->oTemplate->replaceIdentifierMultiple("detail", "<pre>", null, Template::NO_HTML_ESCAPE);
		if($sMessage !== null) {
			$this->oTemplate->replaceIdentifierMultiple("detail", $sMessage, null);
		}
		if($e instanceof SQLException) {
			$this->oTemplate->replaceIdentifierMultiple("detail", $e->getNativeError(), null);
		}
		$this->oTemplate->replaceIdentifierMultiple("detail", $e->getMessage(), null);
		$this->oTemplate->replaceIdentifierMultiple("detail", "In File '".$e->getFile()."' On Line ".$e->getLine(), null);
		if($e->getCode() !== 0) {
			$this->oTemplate->replaceIdentifierMultiple("detail", "Code: ".$e->getCode(), null);
		}
		$this->oTemplate->replaceIdentifierMultiple("detail", $e->getTraceAsString(), null);
		$this->oTemplate->replaceIdentifierMultiple("detail", "</pre>", null, Template::NO_HTML_ESCAPE);
		$this->oTemplate->replaceIdentifier("chooser", "An error occured in '".$this->sModuleName."'", null, Template::NO_HTML_ESCAPE);
	}

 /**
	* fillBackendNavigation()
	* @return void
	*/ 
	private function fillBackendNavigation() {
		//Direct links
		$aDirectLinks = $this->aBackendSettings['direct_links'];
		// add excluded fixed modules for display. They just need to be excluded from configuring settings
		$aDirectLinks = array_merge(ArrayUtil::arrayWithValuesAsKeys(SettingsBackendModule::$FIXED_MODULE_NAMES), $aDirectLinks);
		if(isset($aDirectLinks['content'])) {
			unset($aDirectLinks['content']);
		}
		if(isset($aDirectLinks['my_dashboard'])) {
			unset($aDirectLinks['my_dashboard']);
		}		 

		foreach($aDirectLinks as $sModuleName => $mConfig) {
			if(!$this->oUser->mayUseBackendModule($sModuleName)) {
				continue;
			}
			$sClassName = '';
			if($this->sModuleName == $sModuleName) {
				$sClassName = 'active';
			} else if($this->sModuleName === 'content' && $sModuleName === 'pages') {
				$sClassName = 'active';
			}
			$oTemplate = new Template('admin_navigation', array(DIRNAME_TEMPLATES, DIRNAME_BACKEND));
			/**
			 * @todo: implement better solution for this
			 */
			$aUrlParameters = array($sModuleName);
			if(($sModuleName === "pages" || $sModuleName === "content") && FrontendManager::$CURRENT_PAGE) {
				array_push($aUrlParameters, FrontendManager::$CURRENT_PAGE->getId());
			}
			$sUrl = LinkUtil::link($aUrlParameters);
			
			$oTemplate->replaceIdentifier('status', $sClassName);
			$oTemplate->replaceIdentifier('title', BackendModule::getDisplayNameByName($sModuleName));
			
			$oTemplate->replaceIdentifier('link', $sUrl);
			if(in_array($sModuleName, SettingsBackendModule::$FIXED_MODULE_NAMES)) {
				$oTemplate->replaceIdentifier('class_pages_link', ' main_pages_link');
			}
			$this->oTemplate->replaceIdentifierMultiple("direct_links", $oTemplate);
		}
		
		// show my_dashboard if exists
		$oMyDashboardLink = null; 
		if(Module::moduleExists('my_dashboard', 'backend')) {
				$oMyDashboardLink = TagWriter::quickTag('a', array('href' => LinkUtil::link('my_dashboard'), 'title' => 'MyDashboard'), ' ');
		}
		$this->oTemplate->replaceIdentifier('my_dashboard_link', $oMyDashboardLink);

		$aSelectOptions = array();
		$sSelected = $this->sModuleName;
		
		//Site links
		$iCount=0;
		foreach($this->aBackendSettings['site_links'] as $sModuleName => $mConfig) {
			if(!$this->oUser->mayUseBackendModule($sModuleName)) {
				continue;
			}
			$iCount++;
			$aSelectOptions[$sModuleName]['first'] = false;
			$aSelectOptions[$sModuleName]['name'] = BackendModule::getDisplayNameByName($sModuleName);
		}
		//Admin links
		$aAdminOptions = array();
		$iCount=0;
		foreach($this->aBackendSettings['admin_links'] as $sModuleName => $mConfig) {
			if(!$this->oUser->mayUseBackendModule($sModuleName)) {
				continue;
			}
			$iCount++;
			$aAdminOptions[$sModuleName]['first'] = $iCount === 1 ? true : false;
			$aAdminOptions[$sModuleName]['name'] = BackendModule::getDisplayNameByName($sModuleName);
		}
		$aAllOptions = array_merge($aSelectOptions, $aAdminOptions);
		if(count($aAllOptions) > 0) {
			if(!isset($aAllOptions[$sSelected])){
				$this->oTemplate->replaceIdentifier("site_links_not_selected", ' site_links_not_selected');
			} else {
				$this->oTemplate->replaceIdentifier("site_select_class", 'active_select');
			}
			$this->setSelectOptionsFromHash($aAllOptions, $sSelected);
		}
		
		$this->oTemplate->replaceIdentifier("page_url", LinkUtil::link(Manager::getUsedPath(), null, array(), false));
		$aAvailableLanguages = LanguagePeer::getLanguagesAssoc();
		if(count($aAvailableLanguages) > 1) {
			$this->oTemplate->replaceIdentifier("title_language_select", StringPeer::getString('language.choose_content_edit_language'));
			$this->oTemplate->replaceIdentifier("language_choice_active", 'active_select');
		} else {
			$this->oTemplate->replaceIdentifier("title_language_select", StringPeer::getString('language.no_content_edit_language_choice'));
			$this->oTemplate->replaceIdentifier("language_choice_disabled", 'readonly="readonly" ', null, Template::NO_HTML_ESCAPE);
		}
		if(!Manager::isPost()) {
			
			$this->oTemplate->replaceIdentifier("available_language_options", TagWriter::optionsFromArray($aAvailableLanguages, self::getContentEditLanguage(), '', array()));
			foreach(array_diff_assoc($_REQUEST, $_COOKIE) as $sName=>$sValue) {
				if($sName === 'path' || $sName === 'content_language') {
					continue;
				}
				$oHiddenInputTemplate = new Template("hidden_input", array(DIRNAME_TEMPLATES, DIRNAME_BACKEND));
				$oHiddenInputTemplate->replaceIdentifier("name", $sName);
				$oHiddenInputTemplate->replaceIdentifier("value", $sValue);
				$this->oTemplate->replaceIdentifierMultiple("request_values", $oHiddenInputTemplate);
			}
			$this->oTemplate->replaceIdentifier("method", strtolower($_SERVER['REQUEST_METHOD']));
		} else {
			if(LanguagePeer::retrieveByPK(self::getContentEditLanguage()) !== null) 
			$this->oTemplate->replaceIdentifier("static_language", LanguagePeer::retrieveByPK(self::getContentEditLanguage())->getLanguageName());
		}
		
		$this->oTemplate->replaceIdentifier("domain_name", LinkUtil::getHostName());
		$sUserName = (trim(Session::getSession()->getUser()->getFullName()) != '') ? Session::getSession()->getUser()->getFullName() : Session::getSession()->getUser()->getUsername();
		$sUserName = Session::getSession()->getUser() ? $sUserName: 'Hans Muster';
		$this->oTemplate->replaceIdentifier('user_name', $sUserName);
		$this->oTemplate->replaceIdentifier('user_shortcut', Session::getSession()->getUser()->getUsername());
		$this->oTemplate->replaceIdentifier('link_to_user', LinkUtil::link(array('users', Session::getSession()->getUserId())));
		$this->oTemplate->replaceIdentifier('link_to_settings', LinkUtil::link('settings'));
	}

	private function setSelectOptionsFromHash($aSelectOptions, $sSelected) {
		if(!isset($aSelectOptions[$sSelected])) {
			$this->oTemplate->replaceIdentifierMultiple("available_site_links", TagWriter::quickTag('option', array('value' => ''), StringPeer::getString('content.choose_modules')));
		}
		foreach($aSelectOptions as $sModuleName => $aOptionParams) {
			$aOptionAttributes = array('value' => $sModuleName);
			if($sModuleName === $sSelected) {
				$aOptionAttributes = array_merge($aOptionAttributes, array('selected' => "selected"));
			}
			if($aOptionParams['first']) {
				$aOptionAttributes = array_merge($aOptionAttributes, array('class' => 'separator'));
			}
			$this->oTemplate->replaceIdentifierMultiple("available_site_links", TagWriter::quickTag('option', $aOptionAttributes, $aOptionParams['name']));
		}
	}

 /**
	* fillBackend()
	*/ 
	private function fillBackend() {
		if(!$this->oUser->mayUseBackendModule($this->sModuleName, false)) {
			throw new Exception("User is not allowed to use Backend module $this->sModuleName");
		}
		$this->oBackendModule = BackendModule::getModuleInstance($this->sModuleName);
		if(Manager::isPost()) {
			ArrayUtil::trimStringsInArray($_POST);
			ArrayUtil::runFunctionOnArrayValues($_POST, array('StringUtil', "encode"), Settings::getSetting("encoding", "browser", "utf-8"), Settings::getSetting("encoding", "db", "utf-8"));
			if(isset($_POST['action'])) {
				$sMethod = StringUtil::camelize($_POST['action']);
				if(method_exists($this->oBackendModule, $sMethod) || method_exists($this->oBackendModule, "__call")) {
					$this->oBackendModule->$sMethod();
				} else {
					$this->oBackendModule->doSave();
				}
			} else {
				$this->oBackendModule->doSave();
			}
		} else if (isset($_GET['action'])) {
			$sMethod = StringUtil::camelize($_GET['action']);
			if(method_exists($this->oBackendModule, $sMethod)) {
				$this->oBackendModule->$sMethod();
			}
		}
		
		$this->createTemplate();
		$this->oTemplate->replaceIdentifier("module_name", BackendModule::getDisplayNameByName($this->sModuleName));
		$this->oTemplate->replaceIdentifier("chooser", $this->oBackendModule->getChooser(), null, Template::NO_HTML_ESCAPE);
		$mNewEntryActionParams = $this->oBackendModule->getNewEntryActionParams();
		if ($mNewEntryActionParams !== null) {
			if (!is_array($mNewEntryActionParams)) {
				throw new Exception ('BackendModule->getNewEntryActionParams() expects null or array() of params');
			}
			if(isset($mNewEntryActionParams['action'])) {
				$this->oTemplate->replaceIdentifier("new_entry_action", $mNewEntryActionParams['action']);
			}
			if(isset($mNewEntryActionParams['custom'])) {
				$this->oTemplate->replaceIdentifier("custom_select", $mNewEntryActionParams['custom']);
			}
		}
		$this->oTemplate->replaceIdentifier("detail", $this->oBackendModule->getDetail(), null, Template::NO_HTML_ESCAPE);
		$oResourceIncluder = ResourceIncluder::defaultIncluder();
		if($this->oBackendModule->customJs()) {
			$oResourceIncluder->addCustomJs($this->oBackendModule->customJs());
		}
		if($this->oBackendModule->customCss()) {
			$oResourceIncluder->addCustomCss($this->oBackendModule->customCss());
		}
		$this->fillPanels();
	}
	
	private function fillPanels() {
		$this->fillTagPanel();
		$this->fillSearchPanel();
	}
	
	private function fillTagPanel() {
		$sModelName = $this->oBackendModule->getModelName();
		$iCurrentId = $this->oBackendModule->getCurrentId();
		if($iCurrentId === null || $sModelName === null) {
			return;
		}
		$oTagPanelTemplate = new Template('tag_panel', array(DIRNAME_TEMPLATES, DIRNAME_BACKEND));
		$oTagPanelTemplate->replaceIdentifier('model_name', $sModelName);
		$oTagPanelTemplate->replaceIdentifier('count_tags', TagInstancePeer::countByModelNameAndIdCriteria($sModelName, $iCurrentId));
		$oTagPanelTemplate->replaceIdentifier('tagged_item_id', $iCurrentId);
		$this->oTemplate->replaceIdentifier('tag_panel', $oTagPanelTemplate);
	}
	
	private function fillSearchPanel() {
		if(!$this->oBackendModule->hasSearch()) {
			return;
		}
		$oSession = Session::getSession();
		$aSearchPanelValues = $oSession->getAttribute("backend_search_panel");
		if($aSearchPanelValues === null) {
			$aSearchPanelValues = array();
		}
		if(!isset($aSearchPanelValues[$this->oBackendModule->getModuleName()])) {
			$aSearchPanelValues[$this->oBackendModule->getModuleName()] = "";
		}
		if(isset($_REQUEST['search'])) {
			$aSearchPanelValues[$this->oBackendModule->getModuleName()] = $_REQUEST['search'];
		}
		$oSession->setAttribute("backend_search_panel", $aSearchPanelValues);
		$oSearchPanelTemplate = new Template('search_panel', array(DIRNAME_TEMPLATES, DIRNAME_BACKEND));
		$oSearchPanelTemplate->replaceIdentifier('clear_link', LinkUtil::linkToSelf(null, array('search' => '')));
		$oSearchPanelTemplate->replaceIdentifier('search_value', $aSearchPanelValues[$this->oBackendModule->getModuleName()]);
		$this->oTemplate->replaceIdentifier('search_panel', $oSearchPanelTemplate);
	}
	
	public static function setCurrentPage($oPage) {
		FrontendManager::$CURRENT_PAGE = $oPage;
	}

 /**
	* fillAttributes()
	*/ 
	private function fillAttributes() {
		$sPreviewTitle = '';
		$aWeblinkPathArray = array();
		$iPageId = null;
		if(FrontendManager::$CURRENT_PAGE instanceof Page) {
			$aWeblinkPathArray = FrontendManager::$CURRENT_PAGE->getFullPathArray();
			$iPageId = FrontendManager::$CURRENT_PAGE->getId();
			$sPreviewTitle = FrontendManager::$CURRENT_PAGE->getLinkText();
			$this->oTemplate->replaceIdentifier("current_page_title", FrontendManager::$CURRENT_PAGE->getLinkText());
		} else {
			// handle last_requested_page if stored
			$aLastPageRequestArray = Session::getSession()->getAttribute(self::LAST_REQUESTED_PAGE_SESSION_KEY);
			if(isset($aLastPageRequestArray[1])) {
				$oLastPage = PagePeer::retrieveByPK($aLastPageRequestArray[1]);
				if($oLastPage) {
					$iPageId = $oLastPage->getId();
					$aWeblinkPathArray = $oLastPage->getFullPathArray();
					$sPreviewTitle = $oLastPage->getLinkText();
				}
			}
		}
		// always fill the attributes
		$this->oTemplate->replacePstring("preview_title", array("link_title" => $sPreviewTitle));
		$this->oTemplate->replaceIdentifier("web_link", self::getWebLink($aWeblinkPathArray));
		$this->oTemplate->replaceIdentifier("logout_link", LinkUtil::linkToSelf(null, array('be_logout' => 'true', 'page_id'=> $iPageId), true));
	}
	
	public static function getWebLink($aPath = array(), $aParameters = array()) {
		$bIsMultilingual = Settings::getSetting('general', 'multilingual', true);
		if(!$bIsMultilingual) {
			return LinkUtil::link($aPath, "FrontendManager", $aParameters);
		}
		$sLanguageId = self::getContentEditLanguage();
		$oLanguage = LanguagePeer::retrieveByPK($sLanguageId);
		if($oLanguage === null || $oLanguage->getIsActive() === false) {
			$sLanguageId = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, null);
		}
		array_unshift($aPath, $sLanguageId);

		return LinkUtil::link($aPath, "FrontendManager", $aParameters, false);
	}
	
	/**
	* @param optional string of template 'list item' identifier
	* retrieve all templates from site template dir that follow a naming convention
	* list template name: examplename.tmpl
	* list_item template name: examplename_item.tmpl
	* @return array assoc of path to examplename in key and value
	*/	
	public static function getSiteTemplatesForListOutput($sPostfix = '_item') {
		$aTemplateList = ArrayUtil::arrayWithValuesAsKeys(Template::listTemplates(DIRNAME_TEMPLATES, true));
		$aListTemplates = array();
		foreach($aTemplateList as $sPath => $sListName) {
			if(StringUtil::endsWith($sListName, $sPostfix)) {
				$sPath = substr($sListName, 0, -strlen($sPostfix));
				$aListTemplates[$sPath] = $sPath;
			}
		}
		foreach($aListTemplates as $sListPath) {
			if(!in_array($sListPath, $aTemplateList)) {
				unset($aListTemplates[$sListPath]);
			}
		}
		return $aListTemplates;
	}
	 
	public static function setContentEditLanguage($sLanguageId) {
		Session::getSession()->setAttribute(self::CONTENT_EDIT_LANGUAGE_SESSION_KEY, $sLanguageId);
	}
	
	public static function getContentEditLanguage() {
		$sLanguageId = Session::getSession()->getAttribute(self::CONTENT_EDIT_LANGUAGE_SESSION_KEY);
		if($sLanguageId === null) {
			$sLanguageId = Session::language();
		}
		if($sLanguageId === null) {
			$sLanguageId = Settings::getSetting("session_default", Session::SESSION_LANGUAGE_KEY, 'en');
		}
		// hack that should be removed in a future version of installManager()
		if(!LanguagePeer::languageExists($sLanguageId) && LanguagePeer::hasNoLanguage()) {
			$oLanguage = new Language();
			$oLanguage->setId($sLanguageId);
			$oLanguage->setIsActive(true);
			$oLanguage->save();
		}
		return $sLanguageId;
	}
	
	public static function shouldIncludeLanguageInLink() {
		return false;
	}
}