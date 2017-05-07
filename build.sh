#!/usr/bin/env bash
source scripts/set_env.sh

echo Environment is $_x_env
mkdir -p cache
db=`php scripts/getdb.php`
mysql -uroot -e "create  database IF NOT EXISTS $db"
phalcon migration run