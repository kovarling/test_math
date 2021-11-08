APP_CONTAINER_NAME := app

up:
	docker-compose up --no-recreate -d

down:
	docker-compose down

# --- [ Cli services ] ------------------------------------------------------------------------------------------------

cli: ## Start PHP shell for manual operations
	docker-compose -f ../docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" /bin/sh

# --- [ Install] ------------------------------------------------------------------------------------------------------
install: ## Install Composer deps
	docker-compose -f docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" composer install --no-interaction --ansi

update: ## Install Composer deps
	docker-compose -f docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" composer update --no-interaction --ansi

run-math:
	docker-compose -f docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" php ./bin/MathTestScript.php

php-version:
	docker-compose -f docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" php -v

run-test:
	docker-compose -f docker-compose.yml run --rm "$(APP_CONTAINER_NAME)" composer run test