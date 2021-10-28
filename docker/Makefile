SHELL = /bin/sh

IMAGES_PREFIX := $(shell basename $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST)))))

# Important: Local images naming should be in docker-compose naming style

APP_CONTAINER_NAME := app

docker_bin := $(shell command -v docker 2> /dev/null)
docker_compose_bin := $(shell command -v docker-compose 2> /dev/null)

up:
	$(docker_compose_bin) up --no-recreate -d

down:
	$(docker_compose_bin) down

# --- [ Cli services ] ------------------------------------------------------------------------------------------------

cli: ## Start PHP shell for manual operations
	$(docker_compose_bin) -f ./docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" /bin/sh

# --- [ Install] ------------------------------------------------------------------------------------------------------
install: ## Install Composer deps
	$(docker_compose_bin) -f ./docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" composer install --no-interaction --ansi --no-suggest

update: ## Install Composer deps
	$(docker_compose_bin) -f ./docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" composer update --no-interaction --ansi --no-suggest

run-math:
	$(docker_compose_bin) -f ./docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" php ./bin/MathTestScript.php

php-version:
	$(docker_compose_bin) -f ./docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" php -v

run-test:
	$(docker_compose_bin) -f ./docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" composer run test