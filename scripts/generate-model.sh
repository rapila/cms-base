#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

owner=`whoami`

path_to_buildfile="base/lib/vendor/propel/generator/build.xml"

if [ "$1" = "help" ]; then
	echo "USAGE: generate-model.sh [-b] [<path-to-buildfile (default $path_to_buildfile)>] [<php-user (default `whoami`)>]"
	echo "       generate-model.sh --sql-only"
	exit 0
fi

if [ ! -f "base/build.properties" ]; then
	echo "Error: No build.properties found in base, make sure you are in a rapila root directory"
	exit 1
fi

profiles="sql om"
is_dev=false

if [ "$1" = "--sql-only" ]; then
	profiles="sql"
	shift
elif [ "$1" = "-b" ]; then
	is_dev=true #internal use only
	shift
	echo "Moving model for base-dev environment"
else
	echo "Moving model for site environment"
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

if [ "b$MIGRATION_SUDO" = "b" ]; then
	MIGRATION_SUDO="sudo -u $owner -E"
fi

cp base/build.properties generated/

adapter=$($MIGRATION_SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');print BuildHelper::getDBAdapter();")
echo "Using adapter $adapter"

$MIGRATION_SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::preBuild($is_dev);"
if [[ " $profiles " == *" om "* ]]; then
	$MIGRATION_SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::preOM($is_dev);"
fi

$MIGRATION_SUDO "$PHP_PATH" ./base/lib/vendor/phing/bin/phing -f "$path_to_buildfile" -Dproject.dir=generated/ -Dpropel.database="$adapter" $profiles

if [[ " $profiles " == *" om "* ]]; then
	$MIGRATION_SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::postOM($is_dev);"
fi
$MIGRATION_SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::postBuild($is_dev);"
