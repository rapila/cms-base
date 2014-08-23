#! /bin/bash

# Remark: always remove drop statements for _migration_[name] tables in PropelMigration_ file, so these tables will not be deleted.
# 1. before a schema update write and migrate the model without the new changes so all old schema inconsistencies are fixed.
#    and throw away that PropelMigration_ file
# 2. update to new schema
# 3. write_migration.sh, remove code @see Remark and run migration_model.sh and add/commit this file

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
elif [ "$1" = "-s" ]; then
	context=site
	shift
elif [ "$1" = "-p" ]; then
	shift
	if [ "$1s" = "s" ]; then
		echo "No plugin name given."
		exit 0
	fi
	context="plugins/$1"
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

SUDO="sudo -u $owner -E"

cp base/build.properties generated/ && \
$SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::preMigrate();" && \
$SUDO /bin/sh "$PHING_PATH" -f "$path_to_buildfile" -Dproject.dir=generated/ "-Dpropel.migration.table=_migration_${context/\//_}" diff && \
$SUDO "$PHP_PATH" -r "require_once('base/lib/inc.php');BuildHelper::postMigrate();" && \

mkdir -p "$destination_path" && \
mv "./generated/migrations/"*.php "$destination_path/"
