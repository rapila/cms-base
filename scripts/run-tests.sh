#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

if [ "s$PHPUNIT_PATH" == "s" ]; then
	if [ ! -x "`which phpunit`" ]; then
		echo "Error: PHPUnit not found in path. Please make sure it is installed and in your path (see http://www.phpunit.de/pocket_guide/3.1/en/installation.html), or export PHPUNIT_PATH";
		exit 1
	fi
	PHPUNIT_PATH="`which phpunit`"
fi

if [ "s$SQLITE_PATH" == "s" ]; then
	if [ ! -x "`which sqlite3`" ]; then
		echo "Error: SQLite3 not found in path. Please make sure it is installed and in your path, or export SQLITE_PATH";
		exit 1
	fi
	SQLITE_PATH="`which sqlite3`"
fi


if [ "$1" != "" ]; then
		test_module=$1
		if [ "$1" == "help" ]; then
			echo "USAGE: run-tests.sh [<test name (default: Everything)>] [<filter>]"
			exit 1
		fi
	else
		test_module=Everything
fi

filter=""
if [ "$2" != "" ]; then
		filter="--filter $2"
fi

export RAPILA_ENVIRONMENT=test

# Prepare the test db
if [ -f ./test-db.sqlite ]; then
	rm ./test-db.sqlite
fi
./base/scripts/generate-model.sh --sql-only
sqlite3 ./test-db.sqlite < ./generated/*schema.sql

# Create test plugin
mkdir -p plugins/test_only

"$PHPUNIT_PATH" $filter --bootstrap "base/lib/tests/RapilaTestLoader.php" "./base/lib/tests/Test$test_module"
retval=$?

rm -Rf plugins/test_only

exit $retval