<?php
/**
 * @package test
 */
class PasswordHashTests extends PHPUnit_Framework_TestCase {
  public function testSimplePassword() {
    $sPassword = <<<EOT
myTestPassword
EOT;
    $sHash = PasswordHash::hashPassword($sPassword);
    $this->assertNotEquals('', $sHash);
  }
  
  public function testSimplePasswordCheck() {
    $sPassword = <<<EOT
myTestPassword
EOT;
    $this->assertEquals(true, PasswordHash::comparePassword($sPassword, PasswordHash::hashPassword($sPassword)));
  }
  
  public function testSimplePasswordCheckFallback() {
    $sPassword = <<<EOT
myTestPassword
EOT;
    $this->assertEquals(true, PasswordHash::comparePasswordFallback($sPassword, md5($sPassword)));
  }
  
  public function testSimplePasswordCheckFalse() {
    $sPassword = <<<EOT
myTestPassword
EOT;
    $sHash = <<<EOT
0af11d132e45f9b3b96407174c7a6151ae5e11b7cfb7b26ea4bb27f746a9e02aaaa22da50dd1834aef1182a52f14ab6f857ed582bac7b285135d9544c410dcac400f27098fe333c1
EOT;
    $this->assertEquals(false, PasswordHash::comparePassword($sPassword, $sHash));
  }
  
  public function testComplicatedPassword() {
    $sPassword = <<<EOT
myTestPassword-#%!@#$%^&*()_üöYÿØ
EOT;
    $this->assertEquals(true, PasswordHash::comparePassword($sPassword, PasswordHash::hashPassword($sPassword)));
  }
  
  public function testGeneratedPassword() {
    $sPassword = PasswordHash::generatePassword();
    $this->assertEquals(1, preg_match("/^\w+$/", $sPassword));
  }
  
  public function testGeneratedPasswordRepeatedly() {
    for($i=0;$i<1000;$i++) {
      $this->testGeneratedPassword();
    }
  }
  
  public function testGeneratedPasswordEncryption() {
    $sPassword = PasswordHash::generatePassword();
    $sHash = PasswordHash::hashPassword($sPassword);
    $this->assertEquals(true, PasswordHash::comparePassword($sPassword, $sHash));
  }
  
  public function testGeneratedPasswordEncryptionRepeatedly() {
    for($i=0;$i<1000;$i++) {
      $this->testGeneratedPasswordEncryption();
    }
  }
}