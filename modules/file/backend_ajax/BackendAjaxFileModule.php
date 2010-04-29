<?php
/**
 * @package modules.file
* This class is actually a file module and is not designed to be filled into pages. Its purpose is to redirect some ajax calls to the appropriate backend module whose name is given as the first path item. Currently, this is used for the tagging mechanism as well as reordering containers in the default page type module.
*/
class BackendAjaxFileModule extends FileModule {
	private $sBackendModuleName;
	private $aRequestPath;
	
	const ERROR_NOT_LOGGED_IN = "not_logged_in";
	const ERROR_NOT_PERMITTED = "not_permitted";
	const ERROR_MODULE_NOT_FOUND = "module_not_found";
	
	public function __construct($aRequestPath) {
		parent::__construct($aRequestPath);
		$this->sBackendModuleName = array_shift($aRequestPath);
		$this->aRequestPath = $aRequestPath;
	}
	
	public function renderFile() {
		$sCharset = Settings::getSetting("encoding", "browser", "utf-8");
		header("Content-Type: application/xml;charset=".$sCharset);
		if(!Session::getSession()->isAuthenticated()) {
			self::printError(self::ERROR_NOT_LOGGED_IN);
		}
		$oModule = BackendModule::getModuleInstance($this->sBackendModuleName);
		if($oModule === null) {
			self::printError(self::ERROR_MODULE_NOT_FOUND);
		}
		$mResult = $oModule->getAjax($this->aRequestPath);
		if($mResult instanceof DOMDocument) {
			print $mResult->saveXML();
		} else {
			print "<?xml version=\"1.0\" encoding=\"$sCharset\"?>";
			print $mResult;
		}
	}
	
	public static function printError($sErrorMessage) {
		$oDocument = new DOMDocument();
		$oRoot = $oDocument->createElement("error");
		$oRoot->setAttribute('id', $sErrorMessage);
		$oDocument->appendChild($oRoot);
		print $oDocument->saveXML();
		exit;
	}
}