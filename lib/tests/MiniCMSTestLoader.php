<?php
/**
 * @package test
 */
require_once 'base/lib/inc.php';

set_include_path(ResourceFinder::findResource(array(DIRNAME_LIB, 'tests')).PATH_SEPARATOR.get_include_path());

class base_lib_tests_MiniCMSTestLoader extends PHPUnit_Runner_StandardTestSuiteLoader {
  
}