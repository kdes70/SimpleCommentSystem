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
	make stop

init: up x-front-init ## start application, refresh configs and helpers

build: ## build application containers
	$(COMPOSE_COMMAND_BIN) build --no-cache

up: ## start application containers
	$(COMPOSE_COMMAND_BIN) up -d

stop: ## stop application containers
	$(COMPOSE_COMMAND_BIN) stop

down: ## stop and clear application containers
	$(COMPOSE_COMMAND_BIN) down -v --remove-orphans

# Utils: SHELLS
shell: up ## start shell into application container
	$(COMPOSE_COMMAND_BIN) exec $(APP_CONTAINER_NAME) bash

# HELPERS
x-copy-env: ## copy .env file to application containers
	if [ ! -f ./.env ]; then cp ./.env.example ./.env ; fi

x-composer-install: ## installing dependencies via Composer
	$(COMPOSE_COMMAND_BIN) exec $(APP_CONTAINER_NAME) composer install
	## Очистка кэша
	$(DOCKER_BIN) run --rm -v ./:/var/www/html -w /var/www/html rm -rf /var/www/html/vendor/composer/cache

x-front-init: ## installing frontend dependencies
	$(COMPOSE_COMMAND_BIN) exec $(APP_CONTAINER_NAME) npm install
	#$(DOCKER_BIN) run --rm -v $(API_DIR)/:/var/www/html -w /var/www/html node:18 npm install

x-front-build: ## build assets to deploy-ready state
#	$(DOCKER_BIN) run --rm -v $(API_DIR)/:/var/www/html -w /var/www/html node:18 npm run build:css
