#!/bin/sh
composer update
# Hand off to the CMD
exec "$@"
