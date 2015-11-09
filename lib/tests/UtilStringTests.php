<?php
/**
 * @package test
 */
class UtilStringTests extends PHPUnit_Framework_TestCase {
	public function testSpecialCharsInPath() {
		$this->assertSame("test", StringUtil::normalizePath("test"));
		$this->assertSame("rämi", StringUtil::normalizePath("rämi"));
		$this->assertSame("rä-mï", StringUtil::normalizePath("rä/mï"));
		$this->assertSame("rä-mï-", StringUtil::normalizePath("rä?mï#"));
	}

	public function testNormalizationToASCII() {
		$this->assertSame("raemi", StringUtil::normalizeToASCII("rämi"));
		$this->assertSame("sudo", StringUtil::normalizeToASCII("sudó"));
		$this->assertSame("remy", StringUtil::normalizeToASCII("rémy"));
		$this->assertSame("rund-lauf-themen", StringUtil::normalizeToASCII("rund lauf – themen"));
		$this->assertSame("rund_lauf_-_themen", StringUtil::normalizeToASCII("rund lauf – themen", '_'));
		$this->assertSame("ruembael-aosduf-o-asso-faoss-duf", StringUtil::normalizeToASCII("rümbäl-aosduf-ø-ˆå¨ß∂ˆø¨-ƒåøßˆ-duf"));
	}
	
	public function testNormalizationOfDiacriticsToASCII() {
		if(defined('ICONV_VERSION') && version_compare(ICONV_VERSION, '1.11', '>=')) {
			$this->assertSame("ruembael-aosduf-o-asso-faoss-duf", StringUtil::normalizeToASCII("rümbäl-aosduf-ø-ˆå¨ß∂ˆø¨-ƒåøßˆ-duf"));
		} else {
			$this->markTestSkipped('Iconv not present or too old.');
		}
	}
}