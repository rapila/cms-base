#!/usr/bin/env php
<?php

require(dirname(__FILE__).'/../lib/inc.php');

$sDir = realpath(@$argv[1]);

foreach(DocumentQuery::create()->find() as $oDocument) {
	$sFileName = "{$oDocument->getId()}_{$oDocument->getName()}.{$oDocument->getExtension()}";
	$rFile = @fopen("$sDir/$sFileName", 'x');
	if($rFile === false) {
		echo "File $sDir/$sFileName exists. Ignoring\n";
		continue;
	}
	$rDocument = $oDocument->getData();
	while(!feof($rDocument) && ($sContents = fread($rDocument,  8192)) !== false) {
		fwrite($rFile, $sContents);
	}
	fclose($rFile);fclose($rDocument);
	echo "Exported $sDir/$sFileName\n";
}