<?php
/**
 * @package modules.backend
 */
 
class MysqlDumpExporterBackendModule extends BackendModule {

	private $sMethod = 'to_local_file';
	private $aMethodsAvailable = array("to_local_file");
	// array("to_local_file", "to_download");

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
			$oMethodTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_exporter.'.$sMethod));
			$oTemplate->replaceIdentifier("tree", $oMethodTemplate);
		}
		return $oTemplate;
	}

	private function setModuleInfoLink(&$oTemplate) {
		$oTemplate->replaceIdentifier('module_info_link', TagWriter::quickTag('a', array('title' => StringPeer::getString('module_info'), 'class' => 'info', 'href' => LinkUtil::link('mysql_dump_exporter', null, array('get_module_info' => 'true')))));
	}
	
	public function getDetail() {
		if(isset($_REQUEST['get_module_info'])) {
			return $this->constructTemplate("module_info");
		}

		if(Manager::isPost()) {
			switch($this->sMethod) {
				case "to_download":
					return $this->doCommitToDownload();
				break;
				default: return $this->doCommitToLocalFile();;
			}
		}

		switch($this->sMethod) {
			case "to_download":
				return $this->doToDownload();
			break;
			default: return $this->doToLocalFile();;
		}
	}

	private function doToLocalFile() {
		$oTemplate = $this->constructTemplate("local_file");
		$this->setModuleInfoLink($oTemplate);
		$oTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_exporter.'.$this->sMethod));
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/";
		$oTemplate->replaceIdentifier("save_dir", $sFilePath);
		$aDbConfig = $this->getDbConfig();
		$oTemplate->replaceIdentifier("dump_name", "{$aDbConfig['database']}@{$aDbConfig['host']}-".date('Ymd-Hi').".sql");
		exec('which mysqldump', $sOutput, $iCode);
		if($iCode !== 0) {
			$sOutput = 'NO mysqldump in '.exec('echo $PATH');
			$oTemplate->replaceIdentifier('no_dump_style', ' style="color:red;"', null, Template::NO_HTML_ESCAPE);
		} else {
			$oTemplate->replaceIdentifier('no_dump_style', '', null, Template::NO_HTML_ESCAPE);
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
		
		// return error message
		if($iCode !== 0) {
			$oTemplate = $this->constructTemplate('error_message');
			$oTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_exporter.'.$this->sMethod));
			$sErrorMessage = "[Output of $sMysqlDumpUtil:\n$sOutput."($iCode === 0 ? '' : '; I am '.exec('whoami'))."]";
			$oTemplate->replacePstring("mysql_dump_exporter.export_error", array('error_message' => $sErrorMessage));
			$this->setModuleInfoLink($oTemplate);
			return $oTemplate;
		}

		// return success message
		$oTemplate = $this->constructTemplate('success_message');
		$oTemplate->replaceIdentifier("title", StringPeer::getString('mysql_dump_exporter.'.$this->sMethod));
		$oTemplate->replaceIdentifier("sql_export_success", StringPeer::getString('mysql_dump_exporter.export_success'));
		$this->setModuleInfoLink($oTemplate);
		return $oTemplate;
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