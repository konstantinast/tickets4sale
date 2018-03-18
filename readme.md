# User stories

## US-1

To use the developer CLI tool, first navigate to root project dir and then just issue the following commands.  

In case of User Story called US-1 and its scenario 1, run the following command in terminal:

``
bin/console app:get-inventory "assets/inventory_US-1.csv" "2017-01-01" "2017-07-01"
``

In case of User Story called US-1 and its scenario 2:

``
bin/console app:get-inventory "assets/inventory_US-1.csv" "2017-08-01" "2017-08-15"
``

# Code Coverage

To generate code coverage html file, first navigate to root project dir and then run this command in terminal:

``
./vendor/bin/simple-phpunit --coverage-html coverage
``

Then this repo user should be able to view or open a file in browser, located at:

``
./coverage/index.html
``