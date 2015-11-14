#!/bin/bash

git pull --rebase

composer self-update
composer update

./app migrate/up --interactive=0
