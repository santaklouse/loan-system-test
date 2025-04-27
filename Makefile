.PHONY: help build up down restart test logs shell lint cs-fix

help: ## Show this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build containers
	docker-compose build

up: ## Run containers
	docker-compose up -d
	docker-compose exec app composer install --no-interaction --optimize-autoloader --no-dev
	docker-compose exec app chmod -R 777 ./storage
	docker-compose exec app php artisan key:generate
	docker-compose exec app chown -R www-data:www-data /var/www
	docker-compose exec app php artisan migrate --force --no-interaction

down: ## Stop containers
	docker-compose down

restart: down up ## Restart containers

logs: ## View logs
	docker-compose logs -f

shell: ## Open a shell in the application container
	docker-compose exec app /bin/bash

test: ## Run tests
	docker-compose exec app vendor/bin/phpunit

lint: ## Check code for standards compliance
	docker-compose exec app vendor/bin/phpstan --memory-limit=1G analyse

cs-fix: ## Fix code style
	docker-compose exec app vendor/bin/php-cs-fixer fix
	@echo "Code style fixed."
