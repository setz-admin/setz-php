# Start watching on changes in file ==> on detect tests are triggered
test-dev:
	./vendor/bin/sail php ./vendor/bin/phpunit-watcher watch

# Start the development php server
serve:
	./vendor/bin/sail composer dev
# Start static code quality analysis of the project
phpstan:
	./vendor/bin/sail php ./vendor/bin/phpstan analyse


# check the code for style, architecture and complexity
insights:
	./vendor/bin/sail php ./vendor/bin/phpinsights analyse
# fix the code style issues automatically
insights-fix:
	./vendor/bin/sail php ./vendor/bin/phpinsights analyse --fix
