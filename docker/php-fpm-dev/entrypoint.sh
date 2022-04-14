#!/bin/sh
composer update
bin/console build-entrypoints
# Hand off to the CMD
exec "$@"
