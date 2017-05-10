#!/usr/bin/env bash
./build.sh test
./start.sh
XDEBUG_CONFIG="remote_enable=1" ./vendor/phpunit/phpunit/phpunit -c tests
./stop.sh