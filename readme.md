## Prerequisites to launch project

- Clone project to your local machine (a.k.a computer).
- Install PHP 7.1+ . For my Linux machine i'm using [PhpBrew](https://github.com/phpbrew/phpbrew/wiki) software to be able switch Php versions seamlessly
- Install [Composer](https://getcomposer.org/doc/00-intro.md) software.
- Run ``composer install`` (or even ``composer auto-run-server`` if you are brave enough :) )

# User stories

## US-1

To use the developer CLI tool, first navigate to root project dir.  

In case of User Story called US-1 and its scenario 1, run the following command in terminal:

``
bin/console app:get-inventory "assets/inventory_US-1.csv" "2017-01-01" "2017-07-01"
``

In case of User Story called US-1 and its scenario 2:

``
bin/console app:get-inventory "assets/inventory_US-1.csv" "2017-08-01" "2017-08-15"
``

## US-2

To see, what was implemented, using console tools of your choice navigate to root project dir, and then issue such command:

``
composer auto-run-server
``

This command should install all required project code dependencies and probably inform about the missing PHP extensions.

# Code Coverage

To generate code coverage html file, first navigate to root project dir and then run this command in terminal:

``
./vendor/bin/simple-phpunit --coverage-html coverage
``

Then this repo user should be able to view or open a file in browser, located at:

``
./coverage/index.html
``