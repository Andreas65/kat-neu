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
use Album\Entity\Album;



class AlbumService implements InputFilterAwareInterface
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
    
    public function save($album)
    {
        $em = $this->getEntityManager();
        $id = (int) $album->getId();
        
        if ($id == 0) {
            
            try {

                $em->persist($album);
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
                    ->setParameter(0,$album->getName())
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
        $album = $this->getRepository()->find($id);
        if ($album instanceof \Album\Entity\Album) {
            $em = $this->getEntityManager();
            $em->remove($album);
            $em->flush();
        }
    }
    
    public function getAllAlbums()
    {
        //return true;
        $query = $this->entityManager->createQueryBuilder()
            ->select(array('i','also'))
            ->from('Album\Entity\Album','i')
            ->leftJoin('Album\Entity\AlbumSongs', 'also', 'WITH', 'i.id = also.album_id')
//            ->where('i.cancelled = 0')
//            ->andWhere('e.number IS NULL')
            ->getQuery();

        return $query->getResult();
    }    
    
    public function getAlbumSongArtist()
    {
        return 'getAlbumSongArtist';
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

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }    
}
