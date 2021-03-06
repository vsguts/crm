#!/bin/bash

mkdir -p storage/dumps
./app mysql/mysqldump storage/dumps/`date +'%Y%m%d_%H%M%S'`.sql

git pull --rebase

# composer self-update
# rm -rf ./vendor
composer install

./yii migrate/up --interactive=0
./app rbac/init

# Cache static
#rm -rf web/assets/*
