<?php

class NotFoundFrontendModule extends FrontendModule {
                                          
  public function __construct($oLanguageObject, $aRequestPath = null) {
    parent::__construct($oLanguageObject, $aRequestPath);
  }

  public function renderFrontend() {
    $oTemplate = $this->constructTemplate('detail');
    $oTemplate->replaceIdentifier('request_uri', $_SERVER['REQUEST_URI']);
    return $oTemplate;
  }

  public function renderBackend() {
    return StringPeer::getString('wns.save');
  }

  public function getSaveData() {
    return "";
  }
}