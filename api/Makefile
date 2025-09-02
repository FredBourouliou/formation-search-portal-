.PHONY: help install migrate fixtures test cs cache-clear

help:
	@echo "Available commands:"
	@echo "  make install    - Install dependencies"
	@echo "  make migrate    - Run database migrations"
	@echo "  make fixtures   - Load fixtures"
	@echo "  make test       - Run tests"
	@echo "  make cs         - Check coding standards (if PHP-CS-Fixer installed)"
	@echo "  make cache-clear - Clear cache"

install:
	composer install

migrate:
	php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	php bin/console doctrine:fixtures:load --no-interaction

test:
	php bin/phpunit

cache-clear:
	php bin/console cache:clear

cs:
	@echo "PHP-CS-Fixer not configured for this project"