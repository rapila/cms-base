<?php
/**
 * @package test
 */
class TemplateDirectOutputTests extends PHPUnit\Framework\TestCase {
	public function testDirectOutput() {
		$sTemplateText = <<<EOT
test
EOT;
		$this->expectOutputString('test');
		$oTemplate = new Template($sTemplateText, null, true, true);
	}
	
	public function testDirectOutputWithIdentifier() {
		$sTemplateText = <<<EOT
test{{id}}test2
EOT;
		$this->expectOutputString('testtest2');
		$oTemplate = new Template($sTemplateText, null, true, true);
		$oTemplate->replaceIdentifier("id", "");
	}
	
	public function testDirectOutputWithIdentifierAndValue() {
		$sTemplateText = <<<EOT
test{{id}}test2
EOT;
		$this->expectOutputString('test value test2');
		$oTemplate = new Template($sTemplateText, null, true, true);
		$oTemplate->replaceIdentifier("id", " value ");
	}
	
	public function testDirectOutputFinal() {
		$sTemplateText = <<<EOT
test{{id;defaultValue= value }}test2
EOT;
		$this->expectOutputString('test value test2');
		$oTemplate = new Template($sTemplateText, null, true, true);
		$oTemplate->render();
	}
	
	public function testDirectOutputMultiple() {
		$sTemplateText = <<<EOT
test{{id}}test2
EOT;
		$this->expectOutputString('test string');
		$oTemplate = new Template($sTemplateText, null, true, true);
		$oTemplate->replaceIdentifierMultiple('id', ' string', null, Template::NO_NEWLINE);
	}
}