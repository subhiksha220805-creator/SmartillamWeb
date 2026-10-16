#!/usr/bin/env bash
set -Eeuo pipefail

cd "$(dirname "$0")"

php artisan migrate --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
