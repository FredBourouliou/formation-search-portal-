.PHONY: help bootstrap up down restart ps logs clean test-api test-frontend api-migrate api-fixtures api-logs frontend-dev frontend-build frontend-logs

help:
	@echo "Available commands:"
	@echo "  make bootstrap     - Full installation (deps + DB + fixtures)"
	@echo "  make up           - Start all services"
	@echo "  make down         - Stop all services"
	@echo "  make restart      - Restart all services"
	@echo "  make ps           - Show container status"
	@echo "  make logs         - Show all logs"
	@echo "  make clean        - Clean everything (including volumes)"
	@echo "  make test-api     - Run API tests"
	@echo "  make test-frontend - Build frontend (type check)"

bootstrap:
	@echo "🚀 Bootstrapping Emfor POC..."
	docker compose build --no-cache
	docker compose up -d db
	@echo "⏳ Waiting for MySQL..."
	@sleep 10
	docker compose up -d
	@sleep 5
	$(MAKE) api-migrate
	$(MAKE) api-fixtures
	@echo "✅ Bootstrap complete! Access:"
	@echo "   API: http://localhost:8080"
	@echo "   Swagger: http://localhost:8080/api/docs"
	@echo "   Frontend: http://localhost:5173"

up:
	docker compose up -d
	@echo "✅ Services started"

down:
	docker compose down
	@echo "✅ Services stopped"

restart:
	$(MAKE) down
	$(MAKE) up

ps:
	docker compose ps

logs:
	docker compose logs -f --tail=100

clean:
	docker compose down -v
	rm -rf api/var api/vendor frontend/node_modules frontend/dist
	@echo "✅ Cleaned all data and dependencies"

test-api:
	docker compose exec api php bin/phpunit

test-frontend:
	docker compose exec frontend npm run build

api-migrate:
	docker compose exec api php bin/console doctrine:migrations:migrate --no-interaction

api-fixtures:
	docker compose exec api php bin/console doctrine:fixtures:load --no-interaction

api-logs:
	docker compose logs -f api web

frontend-dev:
	docker compose exec frontend npm run dev

frontend-build:
	docker compose exec frontend npm run build

frontend-logs:
	docker compose logs -f frontend frontend_web