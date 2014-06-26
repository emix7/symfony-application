# Endroid Symfony Application

[![License](https://poser.pugx.org/endroid/symfony-application/license.png)](https://packagist.org/packages/endroid/symfony-application)
[![Latest Stable Version](https://poser.pugx.org/endroid/symfony-application/v/stable.png)](https://packagist.org/packages/endroid/symfony-application)
[![Total Downloads](https://poser.pugx.org/endroid/symfony-application/downloads.png)](https://packagist.org/packages/endroid/symfony-application)
[![Build Status](https://travis-ci.org/endroid/symfony-application.png?branch=master)](https://travis-ci.org/endroid/symfony-application)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/endroid/symfony-application/badges/quality-score.png?s=0cb8f00fa293d34f949493bb755454690cfeb43c)](https://scrutinizer-ci.com/g/endroid/symfony-application/)
[![Dependency Status](https://www.versioneye.com/user/projects/53ac8f98d043f9b1d4000042/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53ac8f98d043f9b1d4000042)

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

See https://code.google.com/p/wkhtmltopdf/ and  for more information.

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
