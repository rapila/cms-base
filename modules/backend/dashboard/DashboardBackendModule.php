<?php
/**
 * @package modules.backend
 */
class DashboardBackendModule extends BackendModule {
    
  public function __construct() {
    if(Manager::hasNextPathItem()) {
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate('list');
    // $oTemplate->replaceIdentfier();
    return $oTemplate;
  }
  
  public function getDetail() {    
    $oTemplate = $this->constructTemplate("detail");
    $oUser = Session::getSession()->getUser();
    $oTemplate->replaceIdentifier("user_name", $oUser->getFullName());
    $oTemplate->replaceIdentifier("dashboard", "Willkommen!");
    return $oTemplate;
  }
  
  public function create() {
  }
  
  public function delete() {
  }
    
  public function save() {
    // if($this->oLanguage === null) {
    //   $this->create();
    // }
    // $this->oLanguage->setId($_POST['id']);
    // $this->oLanguage->setSort($_POST['sort']);
    // $this->oLanguage->setIsActive(isset($_POST['is_active']));
    // if(Flash::noErrors()) {
    //   $this->oLanguage->save();
    //   LinkUtil::redirect($this->link($this->oLanguage->getId()));
    // }
  }
  
  public function getNewEntryActionParams() {
    // return array('action' => $this->link());
  }
}
