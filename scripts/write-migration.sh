#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

owner=`whoami`
path_to_buildfile="base/lib/vendor/propel/generator/build.xml"
context=site

if [ "$1" = "help" ]; then
	echo "USAGE: write-migration.sh [-b|-p <plugin>|-s (default -s)] [<path-to-buildfile (default $path_to_buildfile)>] [<php-user (default `whoami`)>]"
	exit 0
fi

if [ "$1" = "-b" ]; then
	context=base
	shift
elif [ "$1" = "-p" ]; then
	context=plugins/$2
	shift 2
elif [ "$1" = "-s" ]; then
	shift
fi

echo "Assuming all changes to be for $context"

destination_path="./$context/data/migrations"

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

SUDO="sudo -u $owner env RAPILA_ENVIRONMENT=${RAPILA_ENVIRONMENT}"

cp base/build.properties generated/
$SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::preMigrate();"
$SUDO /bin/sh "$PHING_PATH" -f "$path_to_buildfile" -Dproject.dir=generated/ diff
$SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::postMigrate();"

mkdir -p "$destination_path"
mv "./generated/migrations/"*.php "$destination_path/"
