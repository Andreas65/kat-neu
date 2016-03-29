<?php

/**
 * Skeleton
 *
 * Starts the application lifecylce.
 *
 * @copyright Copyright (c) 2014 Unister GmbH
 * @author    Unister GmbH <teamleitung-dev@unister-gmbh.de>
 * @author    Fabian Grutschus <fabian.grutschus@unister.de>
 */

// zend dev toolbar
define('REQUEST_MICROTIME', microtime(true));

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// load composer autoloading
if (!($loader = @include 'vendor/autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
