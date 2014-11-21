bin/php-cs-fixer fix src
echo "\n"
read -p "Press enter to run PHPUnit" nothing
bin/phpunit -c app
echo "\n"
read -p "Press enter to run phpspec" nothing
bin/phpspec run -f dot
echo "\n"
read -p "Press enter to run Behat" nothing
php -d memory_limit=2048M bin/behat --suite=endroid_api --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=endroid_pdf --no-snippets --verbose
php -d memory_limit=2048M bin/behat --suite=endroid_site --no-snippets --verbose