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
 * @ORM\Table(name="song")
 * @property string $name
 * @property string $genre
 * @property int $albenAnzahl
 * 
 */


class Song implements InputFilterAwareInterface 
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
     * @ORM\ManyToMany(targetEntity="Artist")
     * @ORM\JoinTable(name="song_x_artist",
     *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id")}
     *      )
     */
    private $artist;

    public function __construct() {
        $this->artist = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function exchangeArray(array $data)
    {
        $this->id           = (!empty($data['id'])) ? $data['id'] : null;
        $this->name         = (!empty($data['name'])) ? $data['name'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function getInputFilter()
    {
        
    }


    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        
    }
}