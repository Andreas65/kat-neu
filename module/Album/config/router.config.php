<?php
return array(
    'routes' => array(
        'album' => array(
            'type' => 'segment',
            'options' => array(
                'route'         => '/album[/:action][/:id]',
                'constraints'   => array(
                    'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id'            => '[0-9]+',
                ),
                'defaults'      => array(
                    'controller'    => 'Album\Controller\Album',
                    'action'        => 'index',
                ),
            ),
        ),
        'artist' => array(
            'type' => 'segment',
            'options' => array(
                'route'         => '/artist[/:action][/:id]',
                'constraints'   => array(
                    'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id'            => '[0-9]+',
                ),
                'defaults'      => array(
                    'controller'    => 'Album\Controller\Artist',
                    'action'        => 'index',
                ),
            ),
        ),
        'song' => array(
            'type' => 'segment',
            'options' => array(
                'route'         => '/song[/:action][/:id]',
                'constraints'   => array(
                    'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'id'            => '[0-9]+',
                ),
                'defaults'      => array(
                    'controller'    => 'Album\Controller\Song',
                    'action'        => 'index',
                ),
            ),
        ),
    ),
);
