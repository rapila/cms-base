#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

if [ "s$PHPUNIT_PATH" == "s" ]; then
	if [ ! -x `which phpunit` ]; then
		echo "Error: PHPUnit not found in path. Please make sure it is installed and in your path (see http://www.phpunit.de/pocket_guide/3.1/en/installation.html), or export PHPUNIT_PATH";
		exit 1
	fi
	PHPUNIT_PATH="`which phpunit`"
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

"$PHPUNIT_PATH" $filter --bootstrap "base/lib/tests/RapilaTestLoader.php" "./base/lib/tests/Test$test_module"

