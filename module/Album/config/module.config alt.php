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
    'router' => array(
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
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Album\Service\AlbumService' => 'Album\Service\AlbumServiceFactory',
            'Album\Service\SongService' => 'Album\Service\SongServiceFactory',
            'Album\Service\ArtistService' => 'Album\Service\ArtistServiceFactory'
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
            'Album\Controller\Song' => 'Album\Controller\SongController',
            'Album\Controller\Artist' => 'Album\Controller\ArtistController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
          'album' =>  __DIR__ . '/../view',
        ),
    ),
    // Doctrine config
    'doctrine' => array(
        'driver'        => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ),
            ),
            'orm_default' => array(
                'drivers'   => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ),
            ),
        ),
    )    
);
