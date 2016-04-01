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

class ArtistForm extends Form
{

    public function __construct($name = null)
    {
        parent::__construct('artist');

//        
//    $select = new Element\Select('language');
//     $select->setLabel('In welcher Sprache wird gesungen?');
//     $select->setValueOptions(array(
//             '0' => 'deutsch',
//             '1' => 'French',
//             '2' => 'English',
//             '3' => 'Japanese',
//             '4' => 'Chinese',
//     ));        
//        $this->add($select);
//        
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
                'name' => 'genre',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Genre',
                ),
            )
        );
        $this->add(
            array(
                'name' => 'albenAnzahl',
                'type' => 'Text',
                'options' => array(
                    'label' => 'Anzahl der Alben',
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