# TravelPackages Sekelon

## INSTALLATION

Read the [Installation instructions](INSTALL.md) for informations about how to setup a virtual machine,
install dependencies and configuring the application.

## DATABASE MIGRATION AND DEPLOYMENT

[See the README](database/skeleton/README.md) inside `database/skeleton`.

## GRUNT

The [Grunt Survival Pack](https://github.com/redaxmedia/gsp) (GSP) for Zend Framework 2
is used to run common Grunt tasks.

To run gsp run the following inside the project folder:

```
cd build
./bin/gsp.sh --config=../../../gsp [task1]…[taskN]
```

## ASSET MANAGEMENT

Front-end resources are managed by a asset management system.  
Composer is used to install components (e.g. jQuery) and will installed inside `data/components`.
Resources like CSS and JavaScript for the application can be found inside `data/assets`.
The files in `data/assets/sass/*.scss` are compiled by `sass` and are moved to `data/assets/css`.
The Zend Framework 2 Assetic Module then moves all components automatically to `public/assets`.
Also they are added to the view helper plugins, so they are straight available to the application.

The Assetic Module configuration can be found in `config/autoload/assetic.local.php.dist`.

## TESTING

The application is tested with PHPunit, Behat and Mink. PHPUnit is the framework for unit-testing,
where Behat is for acceptance tests (story files) and Mink can test the application inside a
web browser (browser acceptance tests). Run all those commands inside the Virtual Machine,
or otherwise you'll have a wrong PHP version.

###PHPUnit

```
./vendor/bin/phpunit -c tests
```

To generate a code-coverage report:

```
./vendor/bin/phpunit -c tests --coverage-html tests/log/coverage
```

Browse to that directory and open the report inside your favorite web browser.

###Behat

```
./vendor/bin/behat -c tests/behat.yml.dist
```

###Mink

Currently Mink is configured to run acceptance tests with Phantomjs, which is installed inside the VM.  
Then run Behat with the Mink extension:

```
./vendor/bin/behat -c tests/behat.yml.dist -p acceptance
```
