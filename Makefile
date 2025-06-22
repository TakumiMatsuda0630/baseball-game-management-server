# Makefile
.PHONY: setup
setup: up build composer-install npm-ci migrate-fresh-seed key-generate

.PHONY: up
up:
	docker compose up -d

.PHONY: down
down:
	docker compose down

.PHONY: build
build:
	docker compose build

.PHONY: bash
bash:
	docker compose exec baseball-game-management-app bash

.PHONY: npm-install
npm-install:
	docker compose exec baseball-game-management-app npm install

.PHONY: npm-ci
npm-ci:
	docker compose exec baseball-game-management-app npm ci

.PHONY: composer-install
install:
	docker compose exec baseball-game-management-app composer install

.PHONY: conposer-lock
install-with-lock:
	docker compose exec baseball-game-management-app sh -c 'if [ -f composer.lock ]; then composer install; else echo "composer.lock not found"; fi'

.PHONY: migrate
migrate:
	docker compose exec baseball-game-management-app php artisan migrate

.PHONY: migrate-fresh-seed
migrate-seed: migrate-fresh seed

.PHONY: migrate-fresh
migrate-fresh:
	docker compose exec baseball-game-management-app php artisan migrate:fresh

.PHONY: seed
seed:
	docker compose exec baseball-game-management-app php artisan db:seed

.PHONY: key-generate
key-generate:
	docker compose exec baseball-game-management-app php artisan key:generate

.PHONY: phpstan
phpstan:
	docker compose exec baseball-game-management-app vendor/bin/phpstan analyse

.PHONY: php-cs-fixer
php-cs-fixer:
	docker compose exec baseball-game-management-app vendor/bin/php-cs-fixer fix --diff --dry-run

.PHONY: php-cs-fixer-fix
php-cs-fixer-fix:
	docker compose exec baseball-game-management-app vendor/bin/php-cs-fixer fix

.PHONY: phpunit
phpunit:
	docker compose exec baseball-game-management-app env XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html coverage/