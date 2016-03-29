<?php
/**
 * Unister-Core Library
 *
 * @copyright Copyright (c) 2013 Unister GmbH
 * @author    Unister GmbH <entwicklung@unister.de>
 * @author    Marcus Winkler <marcus.winkler@unister-gmbh.de>
 */

return [
    // used by \Zend\Session\Service\SessionConfigFactory
    'session_config' => [
        'use_cookies'             => true,
        'use_only_cookies'        => true,
        'cookie_lifetime'         => 0,
        'cookie_httponly'         => true,

        'gc_probability'          => 1,
        'gc_divisor'              => 100,
        'gc_max_lifetime'         => 60*5, // session expires in 5 minutes

        'name'                    => 'SKELETON',
        // length of session id depending on these configuration, default is a length of 32
        'hash_function'           => 1, // SHA1
        'hash_bits_per_character' => 5,
    ],
    // used by \Zend\Session\Service\StorageFactory
    'session_storage' => [
        'type' => 'SessionArrayStorage',
    ],
    // used by \Zend\Session\Service\SessionManagerFactory
    'session_manager' => [
        'enable_default_container_manager' => true,
    ],

    /* default config, see \Unister\Core\Session\SaveHandler\DoctrineDBALOptions for all options
    'unister_core_session' => array(
        'savehandler_doctrine_dbal' => array(
            'table' => 'Session',
        ),
    ),
    */
];
