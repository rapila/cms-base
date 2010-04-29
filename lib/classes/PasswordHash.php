<?php
class PasswordHash {
	private static function getPasswordSalt() {
			$sSalt = str_pad(dechex(mt_rand()), 8, '0', STR_PAD_LEFT).str_pad(dechex(mt_rand()), 8, '0', STR_PAD_LEFT);
			return substr($sSalt , -16);
	}
	
	public static function hashPassword($sPassword) {
		return self::getPasswordHash(self::getPasswordSalt(), $sPassword);
	}
	
	private static function getPasswordHash($sSalt, $sPassword) {
		return $sSalt.hash('whirlpool', $sSalt . $sPassword);
	}

	public static function comparePassword($sPassword, $sHash) {
		$sSalt = substr($sHash, 0, 16);
		return $sHash === self::getPasswordHash($sSalt, $sPassword);
	}
	
	public static function comparePasswordFallback($sPassword, $sHash) {
		return strlen($sHash) === strlen(md5('')) && md5($sPassword) === $sHash;
	}
	
	public static function generateHint() {
		return self::generatePassword();
	}
	
	public static function checkPasswordValidity($sPassword, $oFlash) {
		if((strlen($sPassword)<4) || (strlen($sPassword)>15)) {
			$oFlash->addMessage('password_length');
			return false;
		}
		return true;
	}
	
	public static function generatePassword() {
		$iLength = mt_rand(8, 10);
		$sResult = "";
		while(mb_strlen($sResult)<$iLength) {
			$iCharCode = mt_rand(65, 116);
			if($iCharCode > 90) {
				$iCharCode += 6;
			}
			$sResult .= chr($iCharCode);
		}
		return $sResult;
	}
}
?>
