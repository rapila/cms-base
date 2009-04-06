<?php
class MysqlDumpLoaderBackendModule extends BackendModule {
  private $sMethod;
  
  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->sMethod = Manager::usePath();
    }
  }
  
  public function getChooser() {
    $oTemplate = $this->constructTemplate();
    $this->parseTree($oTemplate, array("from_local_file", "from_upload"), $this->sMethod);
    return $oTemplate;
  }
  
	public function getDetail() {
	  if($this->sMethod === null) {
	    return;
	  }
	  
	  if(Manager::isPost()) {
  	  switch($this->sMethod) {
  	    case "from_local_file":
          return $this->doCommitFromLocalFile();
  	    break;
  	    case "from_upload":
          return $this->doCommitFromUpload();
  	    break;
  	  }
	  }
	  
	  switch($this->sMethod) {
	    case "from_local_file":
        return $this->doFromLocalFile();
	    break;
	    case "from_upload":
        return $this->doFromUpload();
	    break;
	  }
	}
	
	private function doFromLocalFile() {
    $oTemplate = $this->constructTemplate("local_file");
    $aAllSqlFiles = ResourceFinder::findResourceByExpressions(array(DIRNAME_DATA, "sql", "/.*\.sql/"));
    $oTemplate->replaceIdentifier("sql_file_select", TagWriter::optionsFromArray(array_flip($aAllSqlFiles)));
    return $oTemplate;
	}
	
	private function doCommitFromLocalFile($sFileName=null) {
    if($sFileName === null) {
      $sFileName = $_POST['choose_file'];
    }
    $oConnection = Propel::getConnection();
    if(!is_readable($sFileName)) {
      return "Error: file $sFileName is not readable";
    }
    $rFile = fopen($sFileName, 'r');
    if(!$rFile) {
      return "Error: file $sFileName is not readable";
    }
    $sStatement = "";
    $sReadLine = "";
    $iQueryCount = 1;
    while (($sReadLine = fgets($rFile)) !== false ) {
      if($sReadLine !== "\n" && !Util::startsWith($sReadLine, "#") && !Util::startsWith($sReadLine, "--")) {
        $sStatement .= $sReadLine;
      }
      if($sReadLine === "\n" || Util::endsWith($sReadLine, ";\n")) {
        if(trim($sStatement) !== "") {
          $oConnection->executeQuery($sStatement);
          $iQueryCount++;
        }
        $sStatement = "";
      }
    }
    if(trim($sStatement) !== "") {
      $oConnection->executeQuery($sStatement);
    }
    Cache::clearAllCaches();
    $oTemplate = $this->constructTemplate("success_message");
    $oTemplate->replacePstring("sql_upload_success", array('query_count' => $iQueryCount));
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