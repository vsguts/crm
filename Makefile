ROOT_DIR = $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

APP_NAME = Application

SHELL ?= /bin/bash
ARGS = $(filter-out $@,$(MAKECMDGOALS))

.SILENT: ;               # no need for @
.ONESHELL: ;             # recipes execute in same shell
.NOTPARALLEL: ;          # wait for this target to finish
.EXPORT_ALL_VARIABLES: ; # send all vars to shell
Makefile: ;              # skip prerequisite discovery

# Run make help by default
.DEFAULT_GOAL = help

ifneq ("$(wildcard ./VERSION)","")
VERSION ?= $(shell cat ./VERSION | head -n 1)
else
VERSION ?= 0.0.1
endif

%.env:
	cp $@.dist $@

# Public targets
.PHONY: .title
.title:
	$(info $(APP_NAME) v$(VERSION))

.PHONY: provision
provision:
	docker-compose exec php /usr/bin/php /app/docker/provision/consul.php i
	docker-compose exec php php artisan migrate:refresh --seed

.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: start
start:
	docker-compose start

.PHONY: stop
stop:
	docker-compose stop

.PHONY: reset
reset: down up

.PHONY: prune
prune:
	docker-compose down
	docker volume prune -f
	docker system prune -f

.PHONY: bash
bash:
	docker-compose exec php bash

.PHONY: help
help: .title
	@echo ''
	@echo 'Usage: make [target] [ENV_VARIABLE=ENV_VALUE ...]'
	@echo ''
	@echo 'Available targets:'
	@echo ''
	@echo '  help          Show this help and exit'
	@echo '  provision     Will start setting up Application provisioning'
	@echo '  up            Starts and attaches to containers for a service'
	@echo '  down          Down all containers.'
	@echo '  start         Start containers.'
	@echo '  stop          Stop containers.'
	@echo '  bash          Go to the application container.'
	@echo '  prune         Stop, kill and purge project containers.'
	@echo '                Also this coman will remove MySQL, Redis and Consul volumes'
	@echo ''

%:
	@:
