<?php
 
namespace Album\Entity;

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
use Doctrine\ORM\Mapping as ORM;


class Artist
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
    
    public function exchangeArray(array $data)
    {
        $this->id           = (!empty($data['id'])) ? $data['id'] : null;
        $this->name         = (!empty($data['name'])) ? $data['name'] : null;
        $this->genre        = (!empty($data['genre'])) ? $data['genre'] : null;
        $this->albenAnzahl  = (!empty($data['albenAnzahl'])) ? $data['albenAnzahl'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}