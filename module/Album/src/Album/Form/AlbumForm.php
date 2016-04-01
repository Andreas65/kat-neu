<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArtistForm
 *
 * @author a.linde
 */
namespace Album\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Album\Service\SongService;

class AlbumForm extends Form
{

    
    public function __construct($songs = null)
    {
        parent::__construct('album');

        
        
        
        
        
        $songArray = array();
        foreach ($songs as $song) {
            $songArray[$song->getId()] = $song->getName();
        }
        
        
        
        
        
        //$select = new Element\Select('songauswahl');
        $select = new Element\MultiCheckbox('songauswahl');
        $select->setLabel('songauswahl');
        $select->setValueOptions($songArray);

        $this->add($select);
        
        $this->add(
            array(
                'name' => 'id',
                'type' => 'Hidden',
                )
        );
        $this->add(
            array(
                'name' => 'name',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Name',
                ),
            )
        );
        $this->add(
            array(
                'name' => 'submit',
                'type' => 'Submit',
                'attributes' => array(
                    'value' => 'Go',
                    'id' => 'submitbutton',
                ),
            )
        );
    }
}