<?php
/**
 * @package modules.backend
 */
class UsersBackendModule extends BackendModule {
  
  private $oUser = null;
  private $iUserKind;
  private $bIsBackendLoginEnabled=true;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->oUser=UserPeer::retrieveByPk(Manager::usePath());
    }
    if(isset($_REQUEST['user_kind'])) {
      $this->iUserKind = $_REQUEST['user_kind'];
      Session::getSession()->setAttribute('user_kind', $this->iUserKind);
    } else {
      $this->iUserKind = Session::getSession()->getAttribute('user_kind') !== null ? Session::getSession()->getAttribute('user_kind') : UserPeer::BACKEND_USER;
    }
    $this->bIsBackendLoginEnabled = $this->iUserKind !== UserPeer::FRONTEND_USER;
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    $sSearch = isset($_REQUEST['search']) && $_REQUEST['search'] != null ? $_REQUEST['search'] : null;
    // users that are not administrators can only see their own entry
    $iUserId = !Session::getSession()->getUser()->getIsAdmin() ? Session::getSession()->getUserId() : null;
    if(Session::getSession()->getUser()->getIsAdmin()) {
      if($this->iUserKind === UserPeer::BACKEND_USER) {
        $aUsers = UserPeer::getBackendUsers($sSearch, $iUserId);
      } elseif($this->iUserKind === UserPeer::BACKEND_ADMINISTRATOR) {
        $aUsers = UserPeer::getBackendAdministrators($sSearch, $iUserId);
      } elseif($this->iUserKind === UserPeer::BACKEND_USER_WITH_RIGHTS) {
        $aUsers = UserPeer::getBackendUsersWithRights($sSearch, $iUserId);
      } elseif($this->iUserKind === UserPeer::BACKEND_USER_OTHER) {
        $aUsers = UserPeer::getBackendUsersOther($sSearch, $iUserId);
      } else {
        $aUsers = UserPeer::getFrontendUsers($sSearch);
      }
      if($aUserOptions = UserPeer::getUserOptions()) {
        $oTemplate->replaceIdentifier("user_options", Util::optionsFromArray($aUserOptions, $this->iUserKind, null, array()));
      }
    }
    $this->parseTree($oTemplate, $aUsers, $this->oUser);
    return $oTemplate;
  }

  public function getDetail() {
    if($this->oUser === null || 
        !Session::getSession()->getUser()->mayEditUser($this->oUser)) {
      return;
    }

    $oTemplate = $this->constructTemplate("user_detail");
    $oTemplate->replaceIdentifier("id", $this->oUser->getId());
    if(Session::getSession()->hasAttribute('change_password')) {
      $oTemplate->replaceIdentifier("change_password", StringPeer::getString('user_change_password'));
      Session::getSession()->resetAttribute('change_password');
      $this->oUser->setIsAdmin(true);
    }
    $oTemplate->replaceIdentifier("user_name", $this->oUser->getUsername());
    $oTemplate->replaceIdentifier("first_name", $this->oUser->getFirstName());
    $oTemplate->replaceIdentifier("last_name", $this->oUser->getLastName());
    $oTemplate->replaceIdentifier("email", $this->oUser->getEmail());  
    $oTemplate->replaceIdentifier("language_id", $this->oUser->getLanguageId());

    // get language ini files to provide available user_language choice
    $aLanguageFiles = Util::getFolderContents(ResourceFinder::findResource(DIRNAME_LANG, ResourceFinder::SEARCH_BASE_ONLY));
    $aLanguages = array();
    foreach($aLanguageFiles as $sKey => $sValue) {
      if(Util::endsWith($sKey, '.ini')) {
        $sLanguageId = substr($sKey, 0, -4);  
        $aLanguages[$sLanguageId] = StringPeer::getString('language.'.$sLanguageId);
      }
    }
    $aUserLanguageOptions = Util::optionsFromArray($aLanguages, $this->oUser->getLanguageId(), null, false);
    $oTemplate->replaceIdentifier("user_language_options", $aUserLanguageOptions);
    $sChecked = ' checked="checked"';

    if(!$this->oUser->isSessionUser()) { 
      $oUserBooleanTemplate = $this->constructTemplate('user_booleans');
      $oUserBooleanTemplate->replaceIdentifier("is_inactive", $this->oUser->getIsInactive() ? $sChecked : '', null, Template::NO_HTML_ESCAPE);
      $oUserBooleanTemplate->replaceIdentifier("is_admin", $this->oUser->getIsAdmin() ? $sChecked : '', null, Template::NO_HTML_ESCAPE);
      $oTemplate->replaceIdentifier('user_booleans', $oUserBooleanTemplate);
    }
    
    if($this->oUser->isNew()) {
      $oTemplate->replaceIdentifier("full_name", "[neu]");
    } else {
      $oTemplate->replaceIdentifier("full_name", $this->oUser->getFullName());
    }

    if($this->oUser->getId() !== null) {
      $oDeleteTemplate = $this->constructTemplate("delete_button", true);
      $oDeleteTemplate->replacePstring('delete_item', array('name' => $this->oUser->getFullName()));
      $oTemplate->replaceIdentifier("delete_button", $oDeleteTemplate, null, Template::LEAVE_IDENTIFIERS);
    }
    $oTemplate->replaceIdentifier("action", $this->link($this->oUser->getId()));
    
    //Groups
    if(!$this->oUser->isSessionUser()) { 
      $oTemplate->replaceIdentifier("has_groups", "");
      $aGroups = GroupPeer::doSelect(new Criteria());
      if(count($aGroups) > 0) {
        $aGroupOptions = Util::optionsFromObjects($aGroups, 'getId', 'getName', $this->oUser->getGroups(), false);
        $oTemplate->replaceIdentifier("group_options", $aGroupOptions);
      } else {
        $oTemplate->replaceIdentifier("no_groups_message", StringPeer::getString('no_groups_message'));
      }
    }
    return $oTemplate;
  }
  
  public function create() {
    if(!Session::getSession()->getUser()->mayEditUser()) {
      return;
    }    
    $this->oUser = new User();
    $this->oUser->setCreatedBy(Session::getSession()->getUserId());
  }
  
  public function delete() {
    if(!Session::getSession()->getUser()->getIsAdmin()) {
      return;
    }
    $this->oUser->delete();
    $this->oUser=null;
  }
  
  protected function validateForm($oFlash) {
    $oFlash->checkForValue('user_name');
    $oFlash->checkForValue('first_name');
    $oFlash->checkForValue('last_name');
    $oFlash->checkForEmail('email');
    
    if(($_POST['be_password']) !== '') { 
      if($_POST['be_password'] !== $_POST['be_password_confirm']) {
        $oFlash->addMessage('password_confirm');
      }
      PasswordHash::checkPasswordValidity($_POST['be_password'], $oFlash);
    } else if($this->oUser === null || $this->oUser->isNew()) {
      $oFlash->addMessage('password_new');
    }
  }
  
  protected function save() {
    if($this->oUser === null) {
      $this->create();
    }
    if(!Session::getSession()->getUser()->mayEditUser($this->oUser)) {
      return;
    }    
    $this->oUser->setUserName($_POST['user_name']);
    $this->oUser->setFirstName($_POST['first_name']);
    $this->oUser->setLastName($_POST['last_name']);
    $this->oUser->setEmail($_POST['email']);
    $this->oUser->setLanguageId($_POST['language_id']); 
    
    //Password
    if($_POST['be_password'] !== '') {
      $this->oUser->setPassword(PasswordHash::hashPassword($_POST['be_password']));
      $this->oUser->setPasswordRecoverHint(null);
    }
    
    //This also means the user’s an admin because non-admins can only edit themselves
    if(!$this->oUser->isSessionUser()) {
      //Admin & inactive flags
      $this->oUser->setIsInactive(isset($_POST['is_inactive']));
      $this->oUser->setIsAdmin(isset($_POST['is_admin']));
      
      //Groups
      if(isset($_POST['has_groups'])) {
        foreach($this->oUser->getUserGroups() as $oUserGroup) {
          $oUserGroup->delete();
        }
        $aRequestedGroups = isset($_POST['group_ids']) ? $_POST['group_ids'] : array();
        foreach($aRequestedGroups as $iGroupId) {
          $oUserGroup = new UserGroup();
          $oUserGroup->setGroupId($iGroupId);
          $this->oUser->addUserGroup($oUserGroup);
        }
      }
    }
    
    if(Flash::noErrors()) {
      $this->oUser->setUpdatedBy(Session::getSession()->getUserId());
      $this->oUser->setUpdatedAt(date('c'));
      $this->oUser->save();
      Util::redirect($this->link($this->oUser->getId()));
    }
  }
  
  public function hasSearch() {
    return true;
  }
  
  public function getNewEntryActionParams() {
    if(Session::getSession()->getUser()->getIsAdmin()) {
      return array('action' => $this->link());
    }
  }
}
