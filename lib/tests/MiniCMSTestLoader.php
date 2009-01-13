<?php
/**
 * @package test
 */
require_once 'PHPUnit/Framework.php';
require_once 'includes/inc.php';

set_include_path(ResourceFinder::findResource(array(DIRNAME_CLASSES, 'tests')).PATH_SEPARATOR.get_include_path());

class includes_classes_tests_MiniCMSTestLoader extends PHPUnit_Runner_StandardTestSuiteLoader {
  
}