#! /bin/bash

shopt -s nullglob

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

owner=`whoami`
path_to_buildfile="base/lib/vendor/propel/generator/build.xml"
action=migrate

part=base

if [ "$1" = "help" ]; then
	echo "USAGE: migrate-model.sh [-b|-s|-p <plugin-name> (default -b)] [migrate|up|down|status (default migrate)] [<path-to-buildfile (default $path_to_buildfile)>] [<php-user (default `whoami`)>]"
	echo "OR: migrate-model.sh migrate-all"
	exit 0
fi

if [ "$1" = "migrate-all" ]; then
	plugin_migrations="plugins/*"
	for plugin in $plugin_migrations; do
		plugin=${plugin/plugins\//}
		("$0" -p "$plugin" migrate)
	done
	("$0" -b migrate)
	("$0" -s migrate)
	exit 0
fi

if [ "$1" = "-b" ]; then
	part=base
	shift
elif [ "$1" = "-s" ]; then
	part=site
	shift
elif [ "$1" = "-p" ]; then
	shift
	part="plugins/$1"
	shift
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

SUDO="sudo -u $owner env RAPILA_ENVIRONMENT=${RAPILA_ENVIRONMENT}"

mkdir -p "./generated/migrations"

cp base/build.properties generated/ && \
$SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::preMigrate();BuildHelper::consolidateMigrations('$part');" && \
$SUDO /bin/sh "$PHING_PATH" -f "$path_to_buildfile" -Dproject.dir=generated/ "-Dpropel.migration.table=_migration_${part/\//_}" "$action" && \
$SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::postMigrate();" && \
rm "./generated/migrations/"*.php 2> /dev/null

