#!/bin/bash

git pull --rebase

composer self-update
composer update

./yii migrate/up --interactive=0
