<?php
/**
 * @package modules.widget
 */
class BackupWidgetModule extends PersistentWidgetModule {
	private $iFileSizeOfSiteDir;

	public function __construct($sWidgetId) {
		parent::__construct($sWidgetId);
		$this->setSetting('backup_storage_limit_warning', Settings::getSetting('admin', 'backup_storage_limit_warning', 1000000000));
	}

	public function possibleRestoreFiles() {
		$aAllSqlFiles = ResourceFinder::create(array(DIRNAME_DATA, "sql", "/.*\.sql$/"))->byExpressions()->noCache()->returnObjects()->find();
		$aResult = array();
		$this->iFileSizeOfSiteDir = 0;
		foreach($aAllSqlFiles as $oFile) {
			if(StringUtil::startsWith($oFile->getInternalPath(), 'site')) {
				$this->iFileSizeOfSiteDir += filesize(MAIN_DIR.'/'.$oFile->getInternalPath());
			}
			$aResult[$oFile->getFileName()] = $oFile->getInternalPath();
		}
		arsort($aResult);
		return $aResult;
	}

	public function getBackupDirSize() {
		$aResult = array();
		$aResult['integer'] = $this->iFileSizeOfSiteDir;
		$aResult['formatted']= DocumentPeer::getDocumentSize($this->iFileSizeOfSiteDir);
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
		$sOutput = null;
		$iCode = null;
		$aInfo = array();
		$aInfo['backup_dir'] = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql'))."/";
		$aDbConfig = $this->getDbConfig();
		$aInfo['suggested_backup_name'] = "{$aDbConfig['database']}@{$aDbConfig['host']}-".date('Ymd-Hi').".sql";
		$aInfo['mysql_dump_tool'] = static::detectMysqldumpLocation();
		return $aInfo;
	}

	private static function detectMysqldumpLocation() {
		ini_set('open_basedir', '.');
		// 1st: try config
		$sMySqlDumpTool = Settings::getSetting('admin', 'mysql_dump_tool', null);
		if($sMySqlDumpTool && self::is_executable($sMySqlDumpTool)) {
			return $sMySqlDumpTool;
		}

		// 2nd: use mysqldump location from “which” command.
		$sMySqlDumpTool = exec("which mysqldump");
		if (self::is_executable($sMySqlDumpTool)) {
			return $sMySqlDumpTool;
		}

		// 3rd: try to detect the path using “which” for “mysql” command.
		$sMySqlDumpTool = dirname(exec("which mysql")) . "/mysqldump";
		if (self::is_executable($sMySqlDumpTool)) {
			return $sMySqlDumpTool;
		}

		// 4th: detect the path from the available paths.
		// you can add additional paths you come across, in future, here.
		$aMySqyDumpToolPath = array(
			'/usr/bin/mysqldump', // Linux
			'/usr/local/mysql/bin/mysqldump', //Mac OS X
			'/usr/local/bin/mysqldump', //Linux
			'/usr/mysql/bin/mysqldump' //Linux
		 );
		foreach($aMySqyDumpToolPath as $sMySqlDumpTool) {
			if (self::is_executable($sMySqlDumpTool)) {
				return $sMySqlDumpTool;
			}
		}
		
		// 5th: detection has failed
		return null;
	}
	
	/**
	* Work around PHP bug, where is_executable() can not be used outside open_basedir even if exec() works.
	*/
	private static function is_executable($sPath) {
		$bUseAlternative = false;
		set_error_handler(function($iCode, $sMessage) use (&$bUseAlternative) {
			// If path is outside open_basedir then this warning is given
			if(strpos($sMessage, 'open_basedir restriction in effect')) {
				$bUseAlternative = true;
			}
		}, E_ALL);
		$bResult = @is_executable($sPath);
		restore_error_handler();
		if($bUseAlternative) {
			return exec($sPath) !== '';
		}
		return $bResult;
	}

	public function deleteBackupFile($sBackupFile) {
		$sFilePath = ResourceFinder::findResource(array(DIRNAME_DATA, 'sql', $sBackupFile));
		if($sFilePath) {
			return unlink($sFilePath);
		}
		return true;
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
