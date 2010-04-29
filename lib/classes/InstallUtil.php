<?php
/**
 * @package utils
 */
require_once("spyc/Spyc.php");

/**
 * classname:		InstallUtil
 */
class InstallUtil {

	/**
	 * loadYamlFile()
	 * description: 
	 * - reads yaml file into an array assoc (for further details @see Spyc class)
	 * @param string fullfilename.yml
	 * @param string optional path to directory (like '/dirname'), defaults to null
	 * @return array assoc
	 */
	public static function loadYamlFile($sFileName, $sFileDir = null) {
		$sFilePath = $sFileName;
		if ($sFileDir !== null) {
			$sFilePath = $sFileDir."/".$sFileName;
		}
		if (!file_exists($sFilePath)) {
			throw new Exception ("Error in InstallUtil::loadYamlFile: check your filepath ($sFilePath)! loadYamlFile() full file path or filename and dirpath");
		}
		return Spyc::YAMLLoad($sFilePath);
	} // loadYamlFile
	
	/**
	 * loadToDbFromYamlFile()
	 * description: 
	 * - reading yaml config file with params 'modelName', 'inserts', 'insert_pattern'
	 * - and processing the data by passing it to a propel modelName::insertRow() method passing a array assoc of fieldnames and values
	 * - works only already installed db, handled by propel 
	 * - see details in the data/install/'table_name.insert.yml' files and install_notes.txt
	 * @param string table_name or optionally fullfilename.yml
	 * @param string optional path to directory (like '/dirname'), defaults to MAIN_DIR/DIRNAME_DATA/install
	 * @return void
	 */
	public static function loadToDbFromYamlFile($sFileName, $sFileDir = null) {
		if($sFileDir === null) {
			$sFileDir = ResourceFinder::findResource(array(DIRNAME_DATA, 'install'));
		}
		$sFileName = count(explode('.', $sFileName)) == 1 ? $sFileName.'.insert.yml' : $sFileName;
		$aFileContent = self::loadYamlFile($sFileName, $sFileDir);
		if (!isset($aFileContent['model_name'])) {
			throw new Exception ('Error in InstallUtil: insertIntoDbFromConfigFile() expects file with param "model_name" set!');
		}		 
		if (!isset($aFileContent['insert_pattern'])) {
			throw new Exception ('Error in InstallUtil: insertIntoDbFromConfigFile() expects file with array "insert_pattern" set!');
		}
		$aArrayOfValues = array();
		foreach ($aFileContent['inserts'] as $sKey => $aData) {
			$i = 1;
			foreach ($aFileContent['insert_pattern'] as $sIndex => $sColumnName) {
				if ($sIndex == 'key' && $i === 1) {
					$aArrayOfValues[$sColumnName] = $sKey;
				} else {
					$aArrayOfValues[$sColumnName] = isset($aData[$sColumnName]) ? $aData[$sColumnName] : false; // optional boolean handling
				}
				$i++;
			}
			call_user_func(array($aFileContent['model_name'].'Peer', "insertRow"), $aArrayOfValues);
		}
	} // loadToDbFromYamlFile()

}// end class InstallUtil