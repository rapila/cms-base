<?php
/**
 * @package test
 */
class UtilLinkTests extends PHPUnit_Framework_TestCase {
	public function testPrepareLinkParameters_simple() {
		$aParams = array(
			'test[1]' => '',
			'test[2]' => null,
			'test[3]' => '0',
			'test[4]' => 0,
			'test[5]' => 'gaga',
			'test[6]' => 3,
			'test[7]' => '42'
		);
		$sLink = LinkUtil::prepareLinkParameters($aParams);
		$this->assertSame('?test%5B1%5D&test%5B2%5D&test%5B3%5D=0&test%5B4%5D=0&test%5B5%5D=gaga&test%5B6%5D=3&test%5B7%5D=42', $sLink);
	}

	public function testPrepareLinkParameters_empty() {
		$this->assertSame('', LinkUtil::prepareLinkParameters(array()));
	}

	public function testPrepareLinkParameters_single() {
		$this->assertSame('?one=first', LinkUtil::prepareLinkParameters(array('one' => 'first')));
	}


	public function testPrepareLinkParameters_complex() {
		$aParams = array(
			'first' => array(
				'one' => 1,
				'two' => 2,
				'three' => 3
			),
			'second' => array(2, array('one' => 1, 'two' => array('third' => 'here')))
		);
		$this->assertSame(
			'?&first[one]=1&&first[two]=2&&first[three]=3&&second[]=2&&&second[][one]=1&&&second[][two][third]=here',
			LinkUtil::prepareLinkParameters($aParams)
		);
	}
}
