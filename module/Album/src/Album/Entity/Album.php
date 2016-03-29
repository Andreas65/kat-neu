<?php
 
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/**
 * Album
 *
 * @ORM\Entity
 * @ORM\Table(name="AlbumArtist")
 * @property string $name
 * @property string $genre
 * @property int $albenAnzahl
 * 
 */


class Album implements InputFilterAwareInterface 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $genre;
    
    /**
     * @ORM\Column(type="integer");
     */
    protected $albenAnzahl;
    
    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getGenre()
    {
        return $this->genre;
    }

    function getAlbenAnzahl()
    {
        return $this->albenAnzahl;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setGenre($genre)
    {
        $this->genre = $genre;
    }

    function setAlbenAnzahl($albenAnzahl)
    {
        $this->albenAnzahl = $albenAnzahl;
    }

    public function getInputFilter()
    {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    
}