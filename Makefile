#!/usr/bin/make

SHELL = /bin/sh

export PWD := $(PWD)

ifneq (,$(wildcard ./.env))
    include ./.env
    export
endif

APP_DIR= $(PWD)/app
APP_CONTAINER_NAME := app

DOCKER_BIN := $(shell command -v docker 2> /dev/null)
# The "new" version integrates compose in the docker command.
COMPOSE_COMMAND_BIN := docker compose

DOCKER_COMPOSE_NEW := $(shell docker compose version 2>/dev/null)
ifndef DOCKER_COMPOSE_NEW
	DOCKER_COMPOSE_OLD := $(shell docker-compose --version 2>/dev/null)
	ifdef DOCKER_COMPOSE_OLD
		COMPOSE_COMMAND_BIN = docker-compose
	else
		$(error "docker compose is not available, please install it")
	endif
endif

install: down x-copy-env ## build and install application
	make build
	make up
	#make front-init
	make stop

init: up x-composer-install x-database ## start application, refresh configs and helpers

build:
	$(COMPOSE_COMMAND_BIN) build --no-cache

up: ## start application containers
	$(COMPOSE_COMMAND_BIN) up -d

stop: ## stop application containers
	$(COMPOSE_COMMAND_BIN) stop

down: ## stop and clear application containers
	$(COMPOSE_COMMAND_BIN) down -v --remove-orphans

#front-init:
#	$(DOCKER_BIN) run --rm -v $(API_DIR)/:/var/www/html -w /var/www/html node:18 npm install
#
#front-build: ## build assets to deploy-ready state
#	$(DOCKER_BIN) run --rm -v $(API_DIR)/:/var/www/html -w /var/www/html node:18 npm run build:css

# Utils: SHELLS
shell: up ## start shell into application container
	$(docker_compose_bin) exec $(APP_CONTAINER_NAME) bash

# DATABASE
x-database: ## recreating database with all migrations and seeds
	sleep 5; # waiting for mysql initialization (0_o)'

# HELPERS
x-copy-env:
	if [ ! -f ./.env ]; then cp ./.env.example ./.env ; fi

x-composer-install:
	$(COMPOSE_COMMAND_BIN) exec -w /var/www/html/api $(APP_CONTAINER_NAME)  composer install

x-composer-autoload:
	$(COMPOSE_COMMAND_BIN) exec $(APP_CONTAINER_NAME) composer dump-autoload
