#! /usr/bin/env php
<?php
declare(ticks = 1);

require(dirname(__FILE__).'/../lib/inc.php');

$aOptions = getopt('whsn::ud');

if(!isset($aOptions['u'])) {
	$aOptions['u'] = isset($aOptions['d']);
} else {
	$aOptions['u'] = true;
}

foreach(explode('/', 'w/h/s/d') as $sOpt) {
	$aOptions[$sOpt] = isset($aOptions[$sOpt]);
}

if($aOptions['h']) {
	die('Usage: '.basename(__FILE__).' [-w] [-s] [-u] [d] [-n /path/to/nib]'."\n");
}

$iResourceFinderFlags = ResourceFinder::SEARCH_BASE_FIRST;
if($aOptions['s']) {
	$iResourceFinderFlags = ResourceFinder::SEARCH_SITE_ONLY;
}

function trap($iSignal) {
	exit();
}

function find_files($sType) {
	global $iResourceFinderFlags;
	return array_merge(
		ResourceFinder::create($iResourceFinderFlags)->addPath(DIRNAME_WEB)->addRecursive()->addExpression('/^.+\.'.$sType.'$/')->noCache()->all()->find(),
		ResourceFinder::create($iResourceFinderFlags)->addPath(DIRNAME_MODULES)->addExpression('/^(widget|admin)$/')->addDirPath()->addPath(DIRNAME_TEMPLATES)->addExpression('/(widget|admin)\.'.$sType.'\.tmpl$/')->noCache()->all()->find()
	);
}

function call_parser($sCommand, $aArguments) {
	global $aOptions;
	$sCommand = escapeshellcmd($sCommand);
	foreach($aArguments as $iKey => $sArgument) {
		$aArguments[$iKey] = escapeshellarg($sArgument);
	}
	if($aOptions['w']) {
		array_unshift($aArguments, '-w');
		if(function_exists('pcntl_fork')) {
			if(pcntl_fork() !== 0) {
				return;
			}
		} else {
			print('Launching '.$sCommand."\n");
			array_push($aArguments, '>/dev/null');
			array_push($aArguments, '2>&1');
			array_push($aArguments, '&');
		}
	}
	passthru($sCommand.' '.implode(' ', $aArguments));
}

// Stylus-convert all .styl files
$aStylFiles = find_files('styl');
if(count($aStylFiles) > 0) {
	$sNibLocation = isset($aOptions['nib']) ? $aOptions['nib'] : null;
	if($sNibLocation === null) {
		$sNibLocation = ResourceFinder::findResource(array(DIRNAME_LIB, DIRNAME_VENDOR, 'nib'));
	}
	foreach(ResourceFinder::create()->addPath(DIRNAME_LIB, 'stylus_includes')->searchSiteFirst()->noCache()->all()->find() as $sIncludeDir) {
		array_unshift($aStylFiles, '-I', $sIncludeDir);
	}
	array_unshift($aStylFiles, '-u', $sNibLocation);
	if(!$aOptions['u']) {
		array_unshift($aStylFiles, '-c');
	}
	if($aOptions['d']) {
		array_unshift($aStylFiles, '-f', '-l');
	}
	call_parser('stylus', $aStylFiles);
}

$aCoffeeFiles = find_files('coffee');
if(count($aCoffeeFiles) > 0) {
	array_unshift($aCoffeeFiles, '-c');
	if($aOptions['d']) {
		array_unshift($aCoffeeFiles, '-l');
	}
	call_parser('coffee', $aCoffeeFiles);
}

if($aOptions['w']) {
	if(function_exists('pcntl_signal')) {
		pcntl_signal(SIGTERM, 'trap');  
		pcntl_signal(SIGINT, 'trap');  
	}
	while(true) {
		sleep(100);
	}
}

