#!/usr/bin/env bash

set -e

cd "$(dirname "$0")"

if test "$#" -ne 1; then
    ENV=qa
else
    ENV=$1
fi

php artisan db:seed
php artisan db:seed --class=TestSeeder

vendor/bin/codecept run --env $ENV --xml --no-exit --no-colors
