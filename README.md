# Endroid Symfony Application

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/symfony-application.svg)](https://packagist.org/packages/endroid/symfony-application)
[![Build Status](http://img.shields.io/travis/endroid/symfony-application.svg)](https://travis-ci.org/endroid/symfony-application)
[![Scrutinizer Quality Score](http://img.shields.io/scrutinizer/g/endroid/symfony-application.svg)](https://scrutinizer-ci.com/g/endroid/symfony-application/)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/symfony-application.svg)](https://packagist.org/packages/endroid/symfony-application)
[![License](http://img.shields.io/packagist/l/endroid/symfony-application.svg)](https://packagist.org/packages/endroid/symfony-application)
[![PayPayl donate button](http://img.shields.io/badge/paypal-donate-orange.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RGH86QN825TWN "Keep me off the streets")

Use this project if you want to quickly set up a basis for your web application. This application
is built on [`endroid/symfony-standard`](https://github.com/symfony/symfony-standard) and extended
with popular and well-maintained community bundles and some example implementations to speed up the
development process. You decide which functionalities you use, depending on the type of web
application you are building. Browse the [`live demo`](http://symfony-application.endroid.nl/) and
the [`admin section`](http://symfony-application.endroid.nl/admin/dashboard) (admin/admin)
to get a quick impression of the full package.

## Live demo

  * Front end - [`symfony-application.endroid.nl`](http://symfony-application.endroid.nl/)
  * Admin - [`symfony-application.endroid.nl/admin/dashboard`](http://symfony-application.endroid.nl/admin/dashboard) (admin/admin)

## Installation

### Create the project

    composer create-project endroid/symfony-application <target>

### Create the database and schema

    php app/console doctrine:database:create
    php app/console doctrine:schema:update --force

### Set permissions

    HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
    sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs

### Install ElasticSearch (optional)

See http://www.elasticsearch.org/guide/reference/setup/installation/ for more information.

### Install wkhtmltopdf and wkhtmltoimage (optional)

See https://code.google.com/p/wkhtmltopdf/ for more information.

### Load fixtures (optional)

    php app/console doctrine:fixtures:load -n
    php app/console assets:install --symlink
    php app/console fos:elastica:populate

## Note

Please note that if you are using PHP < 5.4 and you want to make use of the provided behaviors
you will have to copy the trait code into your entities instead of using the traits.

## Documentation

The documentation is stored in the `src/Endroid/Bundle/SiteBundle/Resources/doc/index.md` file in this bundle.
[Read the Documentation](https://github.com/endroid/symfony-application/tree/master/src/Endroid/Bundle/SiteBundle/Resources/doc/index.md)
