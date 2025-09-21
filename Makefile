#
# Developing
#
# Start watching on changes in file ==> on detect tests are triggered
test-dev:
	./vendor/bin/sail php ./vendor/bin/phpunit-watcher watch

# Start the development vue server
vue_serve:
	./vendor/bin/sail composer dev


# Start the development sail environment/php server
serve:
	./vendor/bin/sail up

#
# Testing
#
#  Model and Route Tests
test:
	./vendor/bin/sail test --coverage --min=100 --coverage-html=coverage

browser_test:
	./vendor/bin/sail php artisan dusk



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

