<?php

class LegacySQLCharset {
	private static $SQL_ENCODINGS = array("utf-8" => "utf8",
																				"iso-8859-1" => "latin1",
																				"iso-8859-2" => "latin2");

	public static function convertEncodingNameToSQL($sEncoding) {
		if(isset(self::$SQL_ENCODINGS[$sEncoding])) {
			return self::$SQL_ENCODINGS[$sEncoding];
		}
		return $sEncoding;
	}
	
	public function setConnectionCharset($sAdapter, $sCharset, PDOConnection $oConnection = null) {
		if($oConnection === null) {
			$oConnection = Propel::getConnection();
		}
		$sCharset = self::convertEncodingNameToSql($sCharset);
		if(StringUtil::startsWith($sAdapter, 'mysql')) {
			$sAdapter = 'mysql';
		}
		$sFile = ResourceFinder::create(array('data', 'sql', 'charset', "$sAdapter.sql"))->find();
		if($sFile === null) {
			return;
		}
		$sCharsetCode = file_get_contents($sFile);
		$sCharsetCode = str_replace('{{charset}}', $sCharset, $sCharsetCode);
		$oConnection->exec($sCharsetCode);
	}

	public function setConnectionCharsetToDefault($sAdapter, PropelPDO $oConnection = null) {
		$this->setConnectionCharset($sAdapter, Settings::getSetting("encoding", "db", "utf-8"));
	}
}
