#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

owner=`whoami`
path_to_buildfile="base/lib/vendor/propel/generator/build.xml"
action=migrate

if [ "$1" = "help" ]; then
	echo "USAGE: migrate-model.sh [migrate|up|down|status (default migrate)] [<path-to-buildfile (default $path_to_buildfile)>] [<php-user (default `whoami`)>]"
	exit 0
fi

if [ "$1" = "up" ]; then
	action=up
	shift
elif [ "$1" = "down" ]; then
	action=down
	shift
elif [ "$1" = "status" ]; then
	action=status
	shift
elif [ "$1" = "migrate" ]; then
	shift
fi

if [ -f "$1" ]; then
	path_to_buildfile="$1"
	shift
fi

if [ "$1" != "" ]; then
	owner="$1"
fi

if [ ! -r "$path_to_buildfile" ]; then
	echo "Propel-Generator buildfile $path_to_buildfile not readable. Please make sure that the path is correct"
	exit 1
fi

cp base/build.properties generated/
mkdir -p "./generated/migrations"
sudo -u $owner "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::preMigrate();BuildHelper::consolidateMigrations();"
sudo -u $owner /bin/sh "$PHING_PATH" -f "$path_to_buildfile" -Dproject.dir=generated/ "$action"
sudo -u $owner "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::postMigrate();"
rm "./generated/migrations/"*.php

