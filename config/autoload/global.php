<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return [
    'phpSettings'   => [
        'display_startup_errors'        => false,
        'display_errors'                => false,
        'max_execution_time'            => 30,
        'date.timezone'                 => 'Europe/London',
        'mbstring.internal_encoding'    => 'UTF-8',
    ]
];
