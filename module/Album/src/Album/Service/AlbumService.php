<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlbumService
 *
 * @author a.linde
 */
namespace Album\Service;

use Album\Entity\Album;

class AlbumService
{
    protected $repository;
    protected $entityManager;
    
    function getRepository()
    {
        return $this->repository;
    }

    function setRepository($repository)
    {
        $this->repository = $repository;
    }

    function getEntityManager()
    {
        return $this->entityManager;
    }

    function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchAll()
    {
        $list = $this->getRepository()->findAll();
        return $list;
    }

    public function search()
    {
        $list = $this->getRepository()->findBy(
                array('id' => 1, 'name' => 'Andreas'),
                array('name' => 'ASC'));
        return $list;
    }
    
    public function save($param)
    {
        $test = $param;
    }
}
