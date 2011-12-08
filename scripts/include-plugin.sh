#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

if [ "$1" = "" ] || [ "$1" = "help" ]; then
	echo "USAGE: include-plugin.sh <plugin-on-github> [git|http|ssh]"
	echo "       include-plugin.sh <plugin-repo-url> <plugin-name>"
	echo "       include-plugin.sh help"
	echo "       include-plugin.sh list"
	exit 0
fi
if [ "$1" = "list" ]; then
"$PHP_PATH" <<"END"
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
exit 0
fi

plugin_name="$1"
plugin_location="$1"

if [[ "$plugin_location" == */* ]]; then
	plugin_name="$2"
else
	plugin_location="git://github.com/rapila/plugin-$plugin_name.git"
	if [ "$2" = "http" ]; then
		plugin_location="https://github.com/rapila/plugin-$plugin_name.git"
	fi
	if [ "$2" = "ssh" ]; then
		plugin_location="git@github.com:rapila/plugin-$plugin_name.git"
	fi
fi

if [ ! -d "plugins" ]; then
	mkdir plugins
fi

if [ ! -d ".git" ]; then
	# not a git repo -> clone
	git clone "$plugin_location" "plugins/$plugin_name"
	if [ $? -ne 0 ]; then
		echo "The plugin $plugin_name does not exist.";
		exit 1;
	fi
	cd "plugins/$plugin_name"
	git submodule update --init --recursive
else
	# site is a git repo -> add as submodule
	git submodule add "$plugin_location" "plugins/$plugin_name"
	if [ $? -ne 0 ]; then
		echo "The plugin $plugin_name does not exist.";
		exit 1;
	fi
	git submodule update --init --recursive "plugins/$plugin_name"
fi
