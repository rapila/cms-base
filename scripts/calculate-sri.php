#!/usr/bin/env php
<?php

require(dirname(__FILE__).'/../lib/inc.php');

function getLibraryContents($sLibrary, $sVersion, $bCompressed) {
	$oIncluder = new ResourceIncluder();
	// Don’t use SSL for downloads
	// Don’t include dependencies either
	$oIncluder->addJavaScriptLibrary($sLibrary, $sVersion, $bCompressed, false, false, ResourceIncluder::PRIORITY_NORMAL, false);
	return LocalJsLibraryFileModule::getResourceIncluderContents($oIncluder);
}

function getResourceContents($mLocation, $sResourceType = null) {
	$oIncluder = new ResourceIncluder();
	$oIncluder->addResource($mLocation, $sResourceType);
	return LocalJsLibraryFileModule::getResourceIncluderContents($oIncluder);
}

function calculateDigest($sLibraryContents, $sHashFunction = 'sha384') {
	return $sHashFunction.'-'.base64_encode(hash($sHashFunction, $sLibraryContents, true));
}

if(count($argv) < 2) {
	$aLibraries = Settings::getSetting('libraries', null, array(), 'resource_includer');
	print('Usage:'.PHP_EOL);
	print('  calculate-sri.php <library>@<version> [hash-function (default: sha384)]'.PHP_EOL);
	print('    Where <library> is one of '.implode(', ', array_keys($aLibraries)).PHP_EOL);
	print('or'.PHP_EOL);
	print('  calculate-sri.php <resource-location> [hash-function (default: sha384)]'.PHP_EOL);
	exit(1);
}

$sLocation = $argv[1];
$sHashFunction = 'sha384';
if(isset($argv[2])) {
	$sHashFunction = $argv[2];
}

if(strpos($sLocation, '@') !== false) {
	$sLocation = explode('@', $sLocation);
	$sLibrary = $sLocation[0];
	$aLibConfig = Settings::getSetting('libraries', $sLibrary, null, 'resource_includer');
	if(!is_array($aLibConfig)) {
		print('Library '.$sLibrary.' not configured');
		exit(1);
	}
	$sVersion = $sLocation[1];
	print('sri: '.calculateDigest(getLibraryContents($sLibrary, $sVersion, true), $sHashFunction).PHP_EOL);
	print('sri_uncompressed: '.calculateDigest(getLibraryContents($sLibrary, $sVersion, false), $sHashFunction).PHP_EOL);
} else {
	// FIXME: Provide option to force specific type (for locations relative to type-specific dir)
	$sResourceType = null;
	print('sri: '.calculateDigest(getResourceContents($sLocation, $sResourceType), $sHashFunction).PHP_EOL);
}