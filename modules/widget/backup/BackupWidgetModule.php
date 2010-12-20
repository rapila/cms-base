<?php
/**
 * @package modules.widget
 */
class BackupWidgetModule extends PersistentWidgetModule {
	
	public function getSqlFiles() {
		$aAllSqlFiles = ResourceFinder::findResourceByExpressions(array(DIRNAME_DATA, "sql", "/.*\.sql/"));
		return array_flip($aAllSqlFiles;
	}
	
	public function loadFromBackup($sFileName=null) {
		$oConnection = Propel::getConnection();
		$bFileError = false;
		if(!is_readable($sFileName)) {
			$bFileError = true;
		}
		$rFile = fopen($sFileName, 'r');
		if(!$rFile) {
			$bFileError = true;
		}
		// return error and filename on error
		if($bFileError) {
			return array('error' => $sFileName);
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
		
		// return success and query count on success
		Cache::clearAllCaches();
		return array('success' => $iQueryCount)
		return $oTemplate;
	}
	
	public function backupToFile($aBackupInfo = array()) {
	  $sFileName = $aBackupInfo['file_name'];
		if($sFileName === '') {
			return;
		}
		$sMysqlDumpUtil = $aBackupInfo['dump_tool'];
		$aDbConfig = $this->getDbConfig();
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/$sFileName";
		$sOutput = null;
		$iCode = null;
		putenv('LANG=en_US.'.Settings::getSetting('encoding', 'browser', 'utf-8'));
		$sCommand = escapeshellcmd($sMysqlDumpUtil).' -h '.escapeshellarg($aDbConfig['host']).' -u '.escapeshellarg($aDbConfig['user']).' '.escapeshellarg('--password='.$aDbConfig['password']).' --skip-add-locks --opt --lock-tables=FALSE -r '.escapeshellarg($sFilePath).' '.escapeshellarg($aDbConfig['database']).' 2>&1';
		exec($sCommand, $aOutput, $iCode);
		$sOutput = str_replace("\x7", '', implode('', $aOutput));
		
		// return error and error message
		if($iCode !== 0) {
			$sErrorMessage = "[Output of $sMysqlDumpUtil:\n$sOutput".($iCode === 0 ? '' : '; I am '.exec('whoami'))."]";
      return array('error' => $sErrorMessage);
		}

		// return success true
		return array('success' => true)
	}
	
	public function getBackupInfo() {
		$aInfo = array();
		$aInfo['backup_dir'] = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/";
		$aDbConfig = $this->getDbConfig();
		$aInfo['suggested_backup_name'] = "{$aDbConfig['database']}@{$aDbConfig['host']}-".date('Ymd-Hi').".sql";
		exec('which mysqldump', $sOutput, $iCode);
		if($iCode !== 0) {
		  $aInfo['mysql_dump_error'] = 'NO mysqldump in '.exec('echo $PATH');
		} else {
		  $aInfo['mysql_dump_tool'] = $sOutput;
		}
		return $aInfo;
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
}