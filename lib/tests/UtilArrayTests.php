<?php
/**
* @package test
*/

class UtilArrayTests extends PHPUnit\Framework\TestCase {
	public function testAssocUnshift() {
		$aArray = array('one' => 1, 'two' => 2, 'three' => 3);
		ArrayUtil::assocUnshift($aArray, 'half', 0.5);
		ArrayUtil::assocUnshift($aArray, 'zero', 0);
		$this->assertSame(array('zero' => 0, 'half' => 0.5, 'one' => 1, 'two' => 2, 'three' => 3), $aArray);
	}
	public function testAssocUnshiftCombined() {
		$aArray = array('one' => 1, 'two' => 2, 'three' => 3);
		ArrayUtil::assocUnshift($aArray, 'zero', 0, 'half', 0.5);
		$this->assertSame(array('zero' => 0, 'half' => 0.5, 'one' => 1, 'two' => 2, 'three' => 3), $aArray);
	}
	public function testAssocUnshiftReset() {
		$aArray = array('one' => 1, 'half' => 0.4, 'two' => 2, 'three' => 3);
		ArrayUtil::assocUnshift($aArray, 'zero', 0, 'half', 0.5);
		$this->assertSame(array('zero' => 0, 'half' => 0.5, 'one' => 1, 'two' => 2, 'three' => 3), $aArray);
	}
}