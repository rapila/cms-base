<?php
/**
 * @package modules.widget
 */
class BackupWidgetModule extends PersistentWidgetModule {
	
	public function possibleRestoreFiles() {
		$aAllSqlFiles = ResourceFinder::findResourceObjectsByExpressions(array(DIRNAME_DATA, "sql", "/.*\.sql/"));
		$aResult = array();
		foreach($aAllSqlFiles as $oFile) {
			$aResult[$oFile->getFileName()] = $oFile->getInternalPath();
		}
		arsort($aResult);
		return $aResult;
	}
	
	public function loadFromBackup($sFileName = null) {
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql', $sFileName));
		$oConnection = Propel::getConnection();
		$bFileError = false;
		if($sFilePath === null) {
			$bFileError = true;
		}
		if(!$bFileError) {
			if(!is_readable($sFilePath)) {
				$bFileError = true;
			}
			if(!$bFileError) {
				$rFile = fopen($sFilePath, 'r');
				if(!$rFile) {
					$bFileError = true;
				}
			}
		}
		// throw error and filename on error
		if($bFileError) {
			throw new LocalizedException('wns.backup.loader.load_error', array('filename' => $sFilePath));
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
		
		Cache::clearAllCaches();
		return $iQueryCount;
	}
	
	public function backupToFile($sFileName, $sMysqlDumpUtil) {
		$aDbConfig = $this->getDbConfig();
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/$sFileName";
		$sOutput = null;
		$iCode = null;
		putenv('LANG=en_US.'.Settings::getSetting('encoding', 'browser', 'utf-8'));
		$sCommand = '"'.escapeshellcmd($sMysqlDumpUtil).'" -h '.escapeshellarg($aDbConfig['host']).' -u '.escapeshellarg($aDbConfig['user']).' '.escapeshellarg('--password='.$aDbConfig['password']).' --skip-add-locks --opt --lock-tables=FALSE -r '.escapeshellarg($sFilePath).' '.escapeshellarg($aDbConfig['database']).' 2>&1';
		exec($sCommand, $aOutput, $iCode);
		$sOutput = str_replace("\x7", '', implode("\n", $aOutput));
		
		if($iCode === 0) {
			return $sOutput;
		}
		
		throw new LocalizedException('wns.backup.exporter.export_error', array('util' => $sMysqlDumpUtil, 'iam' => exec('whoami'), 'message' => $sOutput), null, $iCode);
	}
	
	public function backupInfo() {
		$aInfo = array();
		$aInfo['backup_dir'] = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/";
		$aDbConfig = $this->getDbConfig();
		$aInfo['suggested_backup_name'] = "{$aDbConfig['database']}@{$aDbConfig['host']}-".date('Ymd-Hi').".sql";
		exec('which mysqldump', $sOutput, $iCode);
		if($iCode === 0) {
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