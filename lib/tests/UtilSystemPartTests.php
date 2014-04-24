<?php
/**
 * @package test
 */
class UtilSystemPartTests extends PHPUnit_Framework_TestCase {
	public function setUp() {
		SystemPart::reset();
	}
	public function testSimpleOrder() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('test/3', array('dependencies' => array()));
		$aParts[] = SystemPart::getPart('test/1', array('dependencies' => array('test/2' => true)));
		$aParts[] = SystemPart::getPart('test/2', array('dependencies' => array('test/3' => true)));
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('test/3', 'test/2', 'test/1'), $aParts);
	}
	
	public function testComplexOrder() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('test/ip', array('dependencies' => array('test/network' => true, 'test/tcp' => true)));
		$aParts[] = SystemPart::getPart('test/dhcp', array('dependencies' => array('test/ip' => true)));
		$aParts[] = SystemPart::getPart('test/tcp', array('dependencies' => array('test/network' => true)));
		$aParts[] = SystemPart::getPart('test/network', array('dependencies' => array()));
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('test/network', 'test/tcp', 'test/ip', 'test/dhcp'), $aParts);
	}
	
	public function testCycle() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('test/3', array('dependencies' => array('test/1' => true)));
		$aParts[] = SystemPart::getPart('test/1', array('dependencies' => array('test/2' => true)));
		$aParts[] = SystemPart::getPart('test/2', array('dependencies' => array('test/3' => true)));
		$this->setExpectedException('Exception');
		$aParts = SystemPart::orderedParts($aParts);
	}
	
	public function testSelfCycle() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('test/1', array('dependencies' => array('test/1' => true)));
		$this->setExpectedException('Exception');
		$aParts = SystemPart::orderedParts($aParts);
	}
	
	public function testImpliedOrdering() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('base');
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('base', 'site'), $aParts);
	}
	
	public function testImpliedOrderingWithPlugin() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('plugins/gaga');
		$aParts[] = SystemPart::getPart('base');
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('base', 'plugins/gaga', 'site'), $aParts);
	}
	
	public function testImpliedOrderingWithPluginForced() {
		$aParts = array();
		$aParts[] = SystemPart::getPart('base');
		$aParts[] = SystemPart::getPart('plugins/gaga', array('dependencies' => array('base' => true)));
		$aParts = array_map(function($oPart) {
			return $oPart->getPrefix();
		}, SystemPart::orderedParts($aParts));
		$this->assertSame(array('base', 'plugins/gaga', 'site'), $aParts);
	}
}