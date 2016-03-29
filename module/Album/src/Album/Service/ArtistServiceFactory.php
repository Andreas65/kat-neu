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
use Album\Service\ArtistService;

class ArtistServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        $artistService = new ArtistService();
        $artistService->setRepository($em->getRepository('Album\Entity\Artist'));
        $artistService->setEntityManager($em);
        return $artistService;
    }
}
