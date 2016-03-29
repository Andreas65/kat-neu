<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Album;

return array(
    'router'                    => include __DIR__ . '/router.config.php',
    'service_manager'           => include __DIR__ . '/service_manager.config.php',    
    'controllers'               => include __DIR__ . '/controllers.config.php',
    'view_manager'              => include __DIR__ . '/view_manager.config.php',
    'doctrine'                  => include __DIR__ . '/doctrine.config.php'
);
