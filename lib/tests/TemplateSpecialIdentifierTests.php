<?php
/**
 * @package test
 */
define("CONSTANT", "myTest is great");
define("MANAGER", "AdminManager");
class TemplateSpecialIdentifierTests extends PHPUnit_Framework_TestCase {
	public function setUp() {
		ResourceIncluder::defaultIncluder()->clearIncludedResources();
		ErrorHandler::setEnvironment('production');
	}
	
	public function testConstant() {
		$sTemplateText = <<<EOT
{{writeConstantValue=CONSTANT}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		
		$this->assertSame("myTest is great", $oTemplate->render());
	}
	
	public function testConstantInSubTemplateWithDefaultValue() {
		$sTemplateText = <<<EOT
{{unfilledIdentifier;defaultValue=\{\{writeConstantValue=CONSTANT\}\}}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		
		$this->assertSame("myTest is great", $oTemplate->render());
	}
	
	public function testConstantInSubTemplateWithConditional() {
		$sTemplateText = <<<EOT
{{if=e;1=\{\{writeConstantValue=CONSTANT\}\};2=myTest is great}}TEST{{endIf}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		
		$this->assertSame("TEST", $oTemplate->render());
	}
	
	public function testConstantInTemplateIdentifierValue() {
		$sTemplateText = <<<EOT
{{writeManagerPrefix=\{\{writeConstantValue=MANAGER\}\}}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		
		$this->assertSame("admin", $oTemplate->render());
	}
	
	public function testQuoteWithInner() {
		Session::getSession()->setLanguage('en');
		$sTemplateText = <<<EOT
{{quoteString=test}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		
		$this->assertSame("“test”", $oTemplate->render());
	}
	
	public function testQuoteWithInnerDefault() {
		Session::getSession()->setLanguage('en');
		$sTemplateText = <<<EOT
{{quoteString=\{\{test\;defaultValue=default\}\}}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);

		$this->assertSame("“default”", $oTemplate->render());
	}
	
	public function testQuoteWithInnerDefaultValue() {
		Session::getSession()->setLanguage('en');
		$sTemplateText = <<<EOT
{{quoteString=\{\{test\}\};defaultValue=default}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);

		$this->assertSame("default", $oTemplate->render());
	}

	public function validCalculations() {
		return array(
			array('0.1 + 0.2', 0.3),
			array('1 + 2', 3),

			array('0.1 - 0.2', -0.1),
			array('1 - 2', -1),

			array('0.1 * 2', 0.2),
			array('1 * 2', 2),

			array('0.1 / 0.2', 0.5),
			array('1 / 2', 0.5),

			array('2 * 2 + 3 * 3', 13),

			array('1 + 0.6 - 3 * 2 / 50', 1.48),

			array('(5 + 3) * -1', -8),

			array('2+2*2', 6),
			array('(2+2)*2', 8),
			array('(2+2)*-2', -8),
			array('(2+-2)*2'),

			array('sin(10) * cos(50) / min(10, 20/2)', (sin(10) * cos(50) / min(10, 20/2))),

			array('100500 * 3.5E5', 100500 * 3.5E5),
			array('100500 * 3.5E-5', 100500 * 3.5E-5)
		);
	}

  /**
   * @dataProvider validCalculations
   */
	public function testCalculations($sCalculation, $sExpectedResult = '0') {
		$oTemplate = new Template(TemplateIdentifier::constructIdentifier('doCalculation', $sCalculation), null, true);
		$oExpected = new Template(TemplateIdentifier::constructIdentifier('result'), null, true);
		$oExpected->replaceIdentifier('result', $sExpectedResult);
		$this->assertSame($oExpected->render(), $oTemplate->render());
	}
	
	public function testWriteResourceIncludes() {
		$sTemplateText = <<<EOT
{{writeResourceIncludes;consolidate=false}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oIncluder = ResourceIncluder::defaultIncluder();
		$oIncluder->clearIncludedResources();
		$oIncluder->addResource('admin/accept.png', null, null, array('template' => 'icons'));
		$oIncluder->addResource(array('web', 'js', 'widget', 'ckeditor', 'skins', 'moono', 'editor.css'));
		$oIncluder->addJavaScriptLibrary('jqueryui', 1);
		$oIncluder->addResource('admin/admin-ui.css');
		$oIncluder->addResource('widget/ckeditor/ckeditor.js');
		$this->assertSame('<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/skins/moono/editor.css" />'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin/admin-ui.css" />'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/ckeditor.js"></script>'."\n", $oTemplate->render());
	}
	
	public function testWriteNamedResourceIncludes() {
		$sTemplateText = <<<EOT
{{writeResourceIncludes;consolidate=false;name=myIncluder}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$oIncluder = ResourceIncluder::namedIncluder('myIncluder');
		$oIncluder->clearIncludedResources();
		$oIncluder->addResource('admin/accept.png', null, null, array('template' => 'icons'));
		$oIncluder->addResource(array('web', 'js', 'widget', 'ckeditor', 'skins', 'moono', 'editor.css'));
		$oIncluder->addJavaScriptLibrary('jqueryui', 1);
		$oIncluder->addResource('admin/admin-ui.css');
		$oIncluder->addResource('widget/ckeditor/ckeditor.js');
		$this->assertSame('<link rel="icon" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/images/admin/accept.png" />'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/skins/moono/editor.css" />'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>'."\n".'<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>'."\n".'<link rel="stylesheet" media="all" href="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/css/admin/admin-ui.css" />'."\n".'<script type="text/javascript" src="'.MAIN_DIR_FE.DIRNAME_BASE.'/web/js/widget/ckeditor/ckeditor.js"></script>'."\n", $oTemplate->render());
	}

	public function testStringReplace() {
		$sTemplateText = <<<EOT
{{replaceIn=TeSt;string=t;with=1}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$this->assertSame('TeS1', $oTemplate->render());
	}

	public function testRegexReplace() {
		$sTemplateText = <<<EOT
{{replaceIn=TeSt;matching=[tT];with=1}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$this->assertSame('1eS1', $oTemplate->render());
	}
	
	public function testRegexCaptureReplace() {
		$sTemplateText = <<<EOT
{{replaceIn=Wonderful World;matching=\\\\w+(ful);with=1$1}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$this->assertSame('1ful World', $oTemplate->render());
	}
	
	public function testInlineResourceOrdering() {
		$sTemplateText = <<<EOT
{{writeResourceIncludes=GAGA}}{{addResourceInclude=jquery;library=1.7.0}}{{writeResourceIncludes}}{{addResourceInclude=mootools;library=1.4.5}}{{addResourceInclude=admin/accept.png;name=GAGA}}{{addResourceInclude=admin/accept.png;name=GAGA2}}
EOT;
		$oTemplate = new Template($sTemplateText, null, true);
		$this->assertSame('<img src="/base/web/images/admin/accept.png" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/mootools/1.4.5/mootools-yui-compressed.js"></script>
', $oTemplate->render());
	}
}
