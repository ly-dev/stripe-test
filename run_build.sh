#!/usr/bin/env bash

set -e

cd "$(dirname "$0")"

npm-cache install npm
npm run production
