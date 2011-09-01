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
		ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_WEB, array(), '/^.+\.'.$sType.'$/'), $iResourceFinderFlags),
		ResourceFinder::findAllResourcesByExpressions(array(DIRNAME_MODULES, '/^(widget|admin)$/', true, DIRNAME_TEMPLATES, '/(widget|admin)\.'.$sType.'\.tmpl$/'), $iResourceFinderFlags)
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
		if(pcntl_fork() !== 0) {
			return;
		}
	}
	passthru($sCommand.' '.implode(' ', $aArguments));
}

// Stylus-convert all .styl files
$aFiles = find_files('styl');
$sNibLocation = isset($aOptions['nib']) ? $aOptions['nib'] : '/usr/local/lib/node_modules/nib';
foreach(ResourceFinder::findAllResources(array(DIRNAME_LIB, 'stylus_includes')) as $sIncludeDir) {
	array_unshift($aFiles, '-I', $sIncludeDir);
}
array_unshift($aFiles, '-u', $sNibLocation);
if(!$aOptions['u']) {
	array_unshift($aFiles, '-c');
}
if($aOptions['d']) {
	array_unshift($aFiles, '-f', '-l');
}
call_parser('stylus', $aFiles);

if($aOptions['w']) {
	pcntl_signal(SIGTERM, 'trap');  
	pcntl_signal(SIGINT, 'trap');  
	while(true) {
		sleep(1);
	}
}

