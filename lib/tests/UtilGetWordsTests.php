<?php
/**
 * @package test
 */
class UtilGetWordsTests extends PHPUnit_Framework_TestCase {
  public function testGetSingleWOrd() {
    $this->assertEquals(array('phil'), StringUtil::getWords("phil"));
  }
  public function testTwoWords() {
    $this->assertEquals(array('phil', 'allen'), StringUtil::getWords("phil allen"));
  }
  public function testEmailAddress() {
    $this->assertEquals(array('phil', 'allen', 'gems-europe', 'com'), StringUtil::getWords("phil.allen@gems-europe.com"));
  }
  public function testSpecialCharacters() {
    $this->assertEquals(array('raphael'), StringUtil::getWords("Raphaël"));
  }
  public function testFromHtml() {
    $sHtml = <<<EOT
lalila<br />toto
EOT;
    $this->assertEquals(array('lalila', 'toto'), StringUtil::getWords($sHtml, true));
  }
  public function testFromHtmlWithP() {
    $sHtml = <<<EOT
<p>lalila<br />toto</p>
EOT;
    $this->assertEquals(array('lalila', 'toto'), StringUtil::getWords($sHtml, true));
  }
  public function testFromHtmlWithLi() {
    $sHtml = <<<EOT
    <ul>
    <li>Test1</li><li>Test2</li><li>Test3</li>
    </ul>
EOT;
    $this->assertEquals(array('test1', 'test2', 'test3'), StringUtil::getWords($sHtml, true));
  }
}