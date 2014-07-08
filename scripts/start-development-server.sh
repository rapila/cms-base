#!/bin/bash

path_to_this="$(dirname "$0")";base_path="$(dirname "$path_to_this")";. "$base_path/lib/sh/script_common.sh"

port=8000

if [ "d$1" != "d" ]; then
	port=$1
fi

RAPILA_ENVIRONMENT=development php -S 0.0.0.0:$port &

sleep 1

url="http://$(hostname):$port"

if which xdg-open > /dev/null; then
	xdg-open $url
elif which gnome-open > /dev/null; then
	gnome-open $url
elif which open > /dev/null; then
	open $url
elif which python > /dev/null; then
	python -mwebbrowser $url
fi

trap "exit" INT TERM
trap "kill 0" EXIT

while true; do
	sleep 20 &
	wait $!
done