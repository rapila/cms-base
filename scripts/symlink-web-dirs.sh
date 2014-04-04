#!/bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

if [ "$1" = "help" ]; then
	echo "USAGE: symlink-web-dirs.sh [document-root (default: $(pwd)/php)]"
	exit 0
fi

PREFIXES=("base/" "site/" plugins/*/)
DOCROOT="php"

if [ "$1" != "" ]; then
  DOCROOT="$1"
fi

shopt -s nullglob

for PREFIX in ${PREFIXES[@]}; do
  SRC="$(pwd)/${PREFIX}web"
  TARGET="$DOCROOT/${PREFIX}web"

  if [ -d "$SRC" ]; then
    mkdir -p "$DOCROOT/$PREFIX"
    rm "$TARGET"
    ln -s "$SRC" "$TARGET"
  fi
done


