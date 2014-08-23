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
