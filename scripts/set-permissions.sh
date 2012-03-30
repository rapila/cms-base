#! /bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

if [ "$1" = "help" ]; then
  echo "USAGE: set-permissions.sh [<cache-owner (default `whoami`)> [<cache-group (default www)>]]"
  exit 0
fi

owner=`whoami`
group=www

if [ "$1" != "" ]; then
  owner="$1"
fi

if [ "$2" != "" ]; then
  group="$2"
fi

echo "setting user/group to $owner:$group"
sudo chown -R $owner:$group .

echo "setting folder permissions – global"
find . -type d \( -not -name 'vendor' -prune \) -print0 | xargs -0 chmod 755
echo "setting file permissions – global"
find . -type f \( -not -name 'vendor' -prune \) -print0 | xargs -0 chmod 644

echo "setting file permissions – executable"
sudo chmod a+x base/scripts/*

echo "setting folder permissions – apache-writable"
sudo chmod -R 775 generated base/lib/model base/config base/data site/lib/model site/config site/data site/modules plugins/*/lib/model plugins/*/config plugins/*/data >& /dev/null
echo "setting file permissions – apache-writable"
find generated base/lib/model base/config base/data site/lib/model site/config site/data site/modules plugins/*/lib/model plugins/*/config plugins/*/data -type f -print0 | xargs -0 chmod 664 >& /dev/null
