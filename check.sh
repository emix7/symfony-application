bin/php-cs-fixer fix src
read -p "Press enter to run PHPUnit" nothing
bin/phpunit -c app
read -p "Press enter to run Behat" nothing
php -d memory_limit=2048M bin/behat --suite=api --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=app --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=messaging --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=pdf --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=search --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=wsse --no-snippets --verbose
