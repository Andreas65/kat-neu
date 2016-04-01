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

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilter;
use Album\Entity\Artist;

class ArtistService implements InputFilterAwareInterface
{
    protected $repository;
    protected $entityManager;
    protected $inputFilter;
    
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
    
    public function searchById($id)
    {
        $list = $this->getRepository()->find($id);
        return $list;
    }
    
    public function save(Artist $artist)
    {
        $em = $this->getEntityManager();
        $id = (int) $artist->getId();
        
        if ($id == 0) {
            
            try {

                $em->persist($artist);
                $em->flush();
            
            } catch(\Exception $ex) {
                \Zend\Debug\Debug::dump($ex->getMessage());
                die(__CLASS__);
            }
            
        } else {
            // updata
            if ($this->searchById($id)) {
                
                try {
                
                $qb = $em->createQueryBuilder();
                $qb ->update('Album\Entity\Artist','a')
                    ->where('a.id=' .  $id )                        
                    ->set('a.name','?0')
                    ->set('a.genre','?1')
                    ->set('a.albenAnzahl','?2')
                    ->setParameter(0,$artist->getName())
                    ->setParameter(1,$artist->getGenre())
                    ->setParameter(2,$artist->getAlbenAnzahl())
                    ->getQuery()
                    ->execute();

                } catch(\Exception $ex) {
                    \Zend\Debug\Debug::dump($ex->getMessage());
                    die(__CLASS__);
                }
            } else {
                throw new \Exception('Artist existiert nicht');
            }
        }
    }    
    
    public function deleteById($id)
    {
        $artist = $this->getRepository()->find($id);
        if ($artist instanceof \Album\Entity\Artist) {
            $em = $this->getEntityManager();
            $em->remove($artist);
            $em->flush();
        }
        
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Nicht verwendet");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 50,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'genre',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 500,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'albenAnzahl',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }    
}
