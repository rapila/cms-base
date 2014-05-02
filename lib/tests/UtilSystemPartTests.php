<?php
/**
 * @package test
 */
class UtilSystemPartTests extends PHPUnit_Framework_TestCase {
	public function testSimpleOrder() {
		$aParts = array();
		$aParts['test/3'] = SystemPart::getPart('test/3');
		$aParts['test/1'] = SystemPart::getPart('test/1');
		$aParts['test/2'] = SystemPart::getPart('test/2')->dependOn($aParts['test/3']);
		$aParts['test/1']->dependOn($aParts['test/2']);
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('test/3', 'test/2', 'test/1'), $aParts);
	}
	
	public function testComplexOrder() {
		$aParts = array();
		$aParts['test/ip'] = SystemPart::getPart('test/ip');
		$aParts['test/dhcp'] = SystemPart::getPart('test/dhcp')->dependOn($aParts['test/ip']);
		$aParts['test/tcp'] = SystemPart::getPart('test/tcp');
		$aParts['test/network'] = SystemPart::getPart('test/network');
		$aParts['test/ip']->dependOn($aParts['test/network'])->dependOn($aParts['test/tcp']);
		$aParts['test/tcp']->dependOn($aParts['test/network']);
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('test/network', 'test/tcp', 'test/ip', 'test/dhcp'), $aParts);
	}
	
	public function testCycle() {
		$aParts = array();
		$aParts['test/3'] = SystemPart::getPart('test/3');
		$aParts['test/1'] = SystemPart::getPart('test/1');
		$aParts['test/2'] = SystemPart::getPart('test/2')->dependOn($aParts['test/3']);
		$aParts['test/1']->dependOn($aParts['test/2']);
		$aParts['test/3']->dependOn($aParts['test/1']);
		$this->setExpectedException('Exception');
		$aParts = SystemPart::orderedParts($aParts);
	}
	
	public function testSelfCycle() {
		$aParts = array();
		$aParts['test/1'] = SystemPart::getPart('test/1');
		$aParts['test/1']->dependOn($aParts['test/1']);
		$this->setExpectedException('Exception');
		$aParts = SystemPart::orderedParts($aParts);
	}
}