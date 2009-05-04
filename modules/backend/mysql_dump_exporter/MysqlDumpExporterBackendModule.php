<?php
/**
 * @package modules.backend
 */
 
class MysqlDumpExporterBackendModule extends BackendModule {
  private $sMethod;

  public function __construct() {
    if(Manager::hasNextPathItem()) {
      $this->sMethod = Manager::usePath();
    }
  }

  public function getChooser() {
    $oTemplate = new Template('{{tree}}', null, true);
    $this->parseTree($oTemplate, array("to_local_file", "to_download"), $this->sMethod);
    return $oTemplate;
  }

	public function getDetail() {
	  if($this->sMethod === null) {
      return $this->constructTemplate("module_info");
	  }

	  if(Manager::isPost()) {
  	  switch($this->sMethod) {
  	    case "to_local_file":
          return $this->doCommitToLocalFile();
  	    break;
  	    case "to_download":
          return $this->doCommitToDownload();
  	    break;
  	  }
	  }

	  switch($this->sMethod) {
	    case "to_local_file":
        return $this->doToLocalFile();
	    break;
	    case "to_download":
        return $this->doToDownload();
	    break;
	  }
	}

	private function doToLocalFile() {
    $oTemplate = $this->constructTemplate("local_file");
    $sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/";
    $oTemplate->replaceIdentifier("save_dir", $sFilePath);
    $aDbConfig = $this->getDbConfig();
    $oTemplate->replaceIdentifier("dump_name", "{$aDbConfig['database']}@{$aDbConfig['host']}-".date('Ymd').".sql");
    exec('which mysqldump', $sOutput, $iCode);
    if($iCode !== 0) {
      $sOutput = 'no mysqldump in '.exec('echo $PATH');
    }
    $oTemplate->replaceIdentifier('dump_tool', $sOutput);
    return $oTemplate;
	}

	private function doCommitToLocalFile($sFileName=null) {
    if($sFileName === null) {
      $sFileName = $_POST['choose_file'];
    }
    if($sFileName === '') {
      return;
    }
    $sMysqlDumpUtil = $_POST['dump_tool'];
    $aDbConfig = $this->getDbConfig();
    $sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/$sFileName";
    $sOutput = null;
    $iCode = null;
    putenv('LANG=en_US.'.Settings::getSetting('encoding', 'browser', 'utf-8'));
    $sCommand = escapeshellcmd($sMysqlDumpUtil).' -h '.escapeshellarg($aDbConfig['host']).' -u '.escapeshellarg($aDbConfig['user']).' '.escapeshellarg('--password='.$aDbConfig['password']).' --skip-add-locks --opt --lock-tables=FALSE -r '.escapeshellarg($sFilePath).' '.escapeshellarg($aDbConfig['database']).' 2>&1';
    exec($sCommand, $aOutput, $iCode);
    $sOutput = str_replace("\x7", '', implode('', $aOutput));
    if($iCode !== 0) {
      return TagWriter::quickTag('pre', array(), "Error while dumping. Output of $sMysqlDumpUtil:\n$sOutput".($iCode === 0 ? '' : '; I am '.exec('whoami')));
    }
    return TagWriter::quickTag('span', array(), "Command $sMysqlDumpUtil ran successfully. Output: $sOutput");
	}

	private function getDbConfig() {
    $aResult = array();
	  $aDbConfig = Propel::getConfiguration();
    $aDbConfig = $aDbConfig['datasources'][Propel::getDefaultDB()]['connection'];
    $aResult['user'] = isset($aDbConfig['user']) ? $aDbConfig['user'] : $aDbConfig['username'];
    $aResult['password'] = $aDbConfig['password'];
    $aResult['host'] = @$aDbConfig['hostspec'];
    $aResult['database'] = @$aDbConfig['database'];
    if(isset($aDbConfig['dsn'])) {
      $sDsn = $aDbConfig['dsn'];
      $sDsn = substr($sDsn, strpos($sDsn, ':')+1);
      $aDsn = explode(';', $sDsn);
      $aDsnAssoc = array();
      foreach($aDsn as $sDsnEntry) {
        $aDsnEntry = explode('=', $sDsnEntry);
        $aDsnAssoc[$aDsnEntry[0]] = $aDsnEntry[1];
      }
      $aResult['host'] = $aDsnAssoc['host'];
      $aResult['database'] = $aDsnAssoc['dbname'];
    }
    return $aResult;
	}

	private function doToDownload() {

	}

	private function doCommitToDownload() {

	}
}