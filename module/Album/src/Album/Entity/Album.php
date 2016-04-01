<?php
 
namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album
 *
 * @ORM\Entity
 * @ORM\Table(name="album")
 * @property string $name
 * @property string $genre
 * @property int $albenAnzahl
 * 
 */


class Album
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
     * @ORM\ManyToMany(targetEntity="Song")
     * @ORM\JoinTable(name="album_x_song",
     *      joinColumns={@ORM\JoinColumn(name="album_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")}
     *      )
     */
    private $songs;

    public function __construct() {
        $this->songs = new \Doctrine\Common\Collections\ArrayCollection();
    }    
    
    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    public function getSongs()
    {
        return $this->songs;
    }
    
    public function setSongs($songs)
    {
        $this->songs = $songs;
    }
    
    public function exchangeArray(array $data, array $songs = array())
    {
        $this->id           = (!empty($data['id'])) ? $data['id'] : null;
        $this->name         = (!empty($data['name'])) ? $data['name'] : null;
        $this->setSongs($songs);
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