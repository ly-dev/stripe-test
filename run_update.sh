#!/usr/bin/env bash

set -e

cd "$(dirname "$0")"

php artisan clear-compiled
php artisan view:clear
php artisan cache:clear
