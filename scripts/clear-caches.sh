#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

rm -f generated/caches/*/*.cache