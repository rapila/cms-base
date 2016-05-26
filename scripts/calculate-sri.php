#!/usr/bin/env php
<?php

require(dirname(__FILE__).'/../lib/inc.php');

function getLibraryContents($sLibrary, $sVersion, $bCompressed) {
	$oIncluder = new ResourceIncluder();
	// Don’t use SSL for downloads
	// Don’t include dependencies either
	$oIncluder->addJavaScriptLibrary($sLibrary, $sVersion, $bCompressed, false, false, ResourceIncluder::PRIORITY_NORMAL, false);
	foreach($oIncluder->getResourceInfosForIncludedResourcesOfPriority() as $aInfo) {
		if(isset($aInfo['file_resource'])) {
			return file_get_contents($aInfo['file_resource']->getFullPath());
		} else {
			$sLocation = $aInfo['location'];
			if(StringUtil::startsWith($sLocation, '//')) {
				$sLocation = 'http:'.$sLocation;
			}
			return file_get_contents($sLocation);
		}
	}
}

function calculateDigest($sLibraryContents, $sHashFunction = 'sha384') {
	return $sHashFunction.'-'.base64_encode(hash($sHashFunction, $sLibraryContents, true));
}

if(count($argv) < 3) {
	$aLibraries = Settings::getSetting('libraries', null, array(), 'resource_includer');
	print('Usage: calculate-sri.php [-c] <library> <version> [hash-function=sha384]'.PHP_EOL);
	print('  Where <library> is one of '.implode(', ', array_keys($aLibraries)).PHP_EOL);
	exit(1);
}

$sLibrary = $argv[1];
$aLibConfig = Settings::getSetting('libraries', $sLibrary, null, 'resource_includer');
if(!is_array($aLibConfig)) {
	print('Library '.$sLibrary.' not configured');
	exit(1);
}
$sVersion = $argv[2];

$sHashFunction = 'sha384';
if(isset($argv[3])) {
	$sHashFunction = $argv[3];
}

print('sri: '.calculateDigest(getLibraryContents($sLibrary, $sVersion, true), $sHashFunction).PHP_EOL);
print('sri_uncompressed: '.calculateDigest(getLibraryContents($sLibrary, $sVersion, false), $sHashFunction).PHP_EOL);
