<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlbumServiceFacture
 *
 * @author a.linde
 */
namespace Album\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Album\Service\AlbumService;

class AlbumServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        $albumService = new AlbumService();
        $albumService->setRepository($em->getRepository('Album\Entity\Album'));
        $albumService->setEntityManager($em);
        return $albumService;
    }
}
