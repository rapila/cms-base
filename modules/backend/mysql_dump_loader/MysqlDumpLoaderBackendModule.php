<?php
/**
 * @package modules.backend
 */
 
class MysqlDumpLoaderBackendModule extends BackendModule {
  
  private $sMethod = 'from_local_file';
  
  private $aMethodsAvailable = array("from_local_file");
  // array("from_local_file", "from_upload");
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->sMethod = Manager::usePath();
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    foreach($this->aMethodsAvailable as $sMethod) {
      $oMethodTemplate = $this->constructTemplate('list_item');
      if($sMethod == $this->sMethod) {
        $oMethodTemplate->replaceIdentifier("class_active", ' active');
      }
      $oMethodTemplate->replaceIdentifier("link", $this->link($sMethod));
      $oMethodTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_loader.'.$sMethod));
      $oTemplate->replaceIdentifier("tree", $oMethodTemplate);
    }
    return $oTemplate;
  }
  
	public function getDetail() {
	  if(isset($_REQUEST['get_module_info'])) {
      return $this->constructTemplate("module_info");
	  }
	  
	  if(Manager::isPost()) {
	    if($_POST['choose_file'] != null) {
    	  switch($this->sMethod) {
    	    case "from_upload":
            return $this->doCommitFromUpload();
    	    break;
    	    default: return $this->doCommitFromLocalFile();;
    	  }
	    }
	  }
	  
	  switch($this->sMethod) {
	    case "from_upload":
        return $this->doFromUpload();
	    break;
      default: return $this->doFromLocalFile();;
	  }
	}
	
	private function doFromLocalFile() {
    $oTemplate = $this->constructTemplate("local_file");
    $this->setModuleInfoLink($oTemplate);
    $aAllSqlFiles = ResourceFinder::findResourceByExpressions(array(DIRNAME_DATA, "sql", "/.*\.sql/"));
    $oTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_loader.'.$this->sMethod));
    $oTemplate->replaceIdentifier("sql_file_select", TagWriter::optionsFromArray(array_flip($aAllSqlFiles)));
    if(Manager::isPost()) {
      $oTemplate->replaceIdentifier("error_message", StringPeer::getString('flash.choose_file'));
    }
    return $oTemplate;
	}
	
	private function setModuleInfoLink(&$oTemplate) {
    $oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'info', 'href' => LinkUtil::link('mysql_dump_loader', null, array('get_module_info' => 'true')))));
	}
	
	private function doCommitFromLocalFile($sFileName=null) {
    if($sFileName === null) {
      $sFileName = $_POST['choose_file'];
    }
    $oConnection = Propel::getConnection();
    $bFileError = false;
    if(!is_readable($sFileName)) {
      $bFileError = true;
    }
    $rFile = fopen($sFileName, 'r');
    if(!$rFile) {
      $bFileError = true;
    }
    if($bFileError) {
      $oTemplate = $this->constructTemplate("error_message");
      $this->setModuleInfoLink($oTemplate);
      $oTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_loader.'.$this->sMethod));
      $oTemplate->replacePstring("mysql_dump_loader.upload_error", array('filename' => $sFileName));
      return $oTemplate;
    }
    // continue importing from local file
    $sStatement = "";
    $sReadLine = "";
    $iQueryCount = 1;
    while (($sReadLine = fgets($rFile)) !== false ) {
      if($sReadLine !== "\n" && !StringUtil::startsWith($sReadLine, "#") && !StringUtil::startsWith($sReadLine, "--")) {
        $sStatement .= $sReadLine;
      }
      if($sReadLine === "\n" || StringUtil::endsWith($sReadLine, ";\n")) {
        if(trim($sStatement) !== "") {
          $oConnection->exec($sStatement);
          $iQueryCount++;
        }
        $sStatement = "";
      }
    }
    if(trim($sStatement) !== "") {
      $oConnection->exec($sStatement);
    }
    // report successfull upload
    Cache::clearAllCaches();
    $oTemplate = $this->constructTemplate("success_message");
    $this->setModuleInfoLink($oTemplate);
    $oTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_loader.'.$this->sMethod));
    $oTemplate->replacePstring("mysql_dump_loader.upload_success", array('query_count' => $iQueryCount));
    return $oTemplate;
	}
	
	private function doFromUpload() {
    $oTemplate = $this->constructTemplate("upload");
    return $oTemplate;
	}
	
	private function doCommitFromUpload() {
    return $this->doCommitFromLocalFile($_FILES['choose_file']['tmp_name']);
	}
}