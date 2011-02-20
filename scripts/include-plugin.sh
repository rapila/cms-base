#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

if [ "$1" = "" ] || [ "$1" = "help" ]; then
  echo "USAGE: include-plugin.sh <plugin-on-github> [git|http|ssh]"
  echo "       include-plugin.sh <plugin-repo-url> <plugin-name>"
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
	cd "plugins/$plugin_name"
	git submodule update --init --recursive
else
	# site is a git repo -> add as submodule
	git submodule add "$plugin_location" "plugins/$plugin_name"
	git submodule update --init --recursive "plugins/$plugin_name"
fi
