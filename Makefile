#
# Developing
#
# Start watching on changes in file ==> on detect tests are triggered
test-dev:
	./vendor/bin/sail php ./vendor/bin/phpunit-watcher watch

# Start the development vue server
vue_serve:
	./vendor/bin/sail composer dev

# erstellt den Test User mit der E-Mail test@example.com und dem Passwort password.
test_user:
	./vendor/bin/sail php artisan db:seed --class=UserSeeder

# Start the development sail environment/php server
serve:
	./vendor/bin/sail up

# delete Tables ; migrate ; add data with all Seeders .
gen_data:
	./vendor/bin/sail php artisan migrate:fresh --seed 


aserve:
	php artisan serve --host=0.0.0.0 --port=8000

#
# Testing
#
#  Model and Route Tests
test:
	./vendor/bin/sail test --coverage --min=40 --coverage-html=coverage

browser_test:
	./vendor/bin/sail php artisan dusk

# Docker Integration Test
# Erstellt ein Docker Image, startet einen Container mit .env_local_docker
# und führt das Smoke-Test-Skript aus
docker_test:
	@echo "════════════════════════════════════════════════════════════"
	@echo "  Docker Integration Test"
	@echo "════════════════════════════════════════════════════════════"
	@echo ""
	@echo "1. Building Docker Image..."
	@docker build \
		--build-arg VERSION=test-$(shell date +%Y%m%d-%H%M%S) \
		--build-arg BUILD_DATE=$(shell date -u +'%Y-%m-%dT%H:%M:%SZ') \
		-t setz-php:test \
		-t setz-php:latest \
		. || (echo "❌ Docker build failed"; exit 1)
	@echo ""
	@echo "2. Starting Container..."
	@docker run -d \
		--name setz-php-test \
		-p 8080:80 \
		-v $(PWD)/.env_local_docker:/var/www/html/.env:ro \
		setz-php:test || (echo "❌ Container start failed"; exit 1)
	@echo ""
	@echo "3. Waiting for services to start (10 seconds)..."
	@sleep 10
	@echo ""
	@echo "4. Running Smoke Tests..."
	@./scripts/smoke_system_test.sh || \
		(docker stop setz-php-test && docker rm setz-php-test && echo "❌ Tests failed" && exit 1)
	@echo ""
	@echo "5. Cleaning up..."
	@docker stop setz-php-test
	@docker rm setz-php-test
	@echo ""
	@echo "✅ Docker Integration Test completed successfully!"

#
# Quality Analysis
#


pint:
	./vendor/bin/sail php ./vendor/bin/pint

# Start static code quality (code complexity) analysis of the project
phpstan:
	./vendor/bin/sail php ./vendor/bin/phpstan analyse
# check the code for style, architecture and complexity
insights:
	./vendor/bin/sail php ./vendor/bin/phpinsights analyse
# fix the code style issues automatically
insights-fix:
	./vendor/bin/sail php ./vendor/bin/phpinsights analyse --fix

check : pint test phpstan

