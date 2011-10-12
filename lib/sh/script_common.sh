if [ ! -d "site" ]; then
  echo "Current directory is not a project with a site folder"
  exit 1
fi

if [ "s$PHP_PATH" == "s" ]; then
	if [ ! -x `which php` ]; then
	  echo "Error: php not found in path. Please make sure it is installed and in your path or export PHP_PATH."
	  exit 1
	fi
	PHP_PATH="`which php`"
fi

if [ "s$PHING_PATH" == "s" ]; then
	PHING_PATH="./base/lib/vendor/phing/bin/phing"
	export PHING_HOME="./base/lib/vendor/phing"
fi

