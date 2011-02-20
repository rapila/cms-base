#! /bin/bash

php <<"END"
<?php
require_once('base/lib/inc.php');

$aRepInfo = json_decode(file_get_contents('https://github.com/api/v2/json/organizations/rapila/public_repositories'), true);
foreach($aRepInfo['repositories'] as $aRepo) {
	if(!StringUtil::startsWith($aRepo['name'], 'plugin-')) {
		continue;
	}
	$sPluginName = substr($aRepo['name'], strlen('plugin-'));
	if(file_exists("plugins/$sPluginName")) {
		print '* ';
	} else {
		print '  ';
	}
	print($sPluginName.': '.$aRepo['description']."\n");
}
END