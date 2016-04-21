<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer\Form;
/**
 * Description of AdminForm
 *
 * @author Mee
 */
use Zend\Form\Form;

class AdresaForm extends Form 
{
    public function __construct($name = null) {
        
        parent::__construct('adresa');
        
         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
        
        $this->add(array(
            'name' => 'judet',
            'type' => 'Text',
            'options' => array(
                'label' => 'Judet: ',
            ),
        ));
        $this->add(array(
            'name' => 'oras',
            'type' => 'Text',
            'options' =>array(
                'label' => 'Oras: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'strada',
            'type' => 'Text',
            'options' =>array(
                'label' => 'Strada: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'numar',
            'type' => 'Text',
            'options' => array(
                'label' => 'Numar: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' =>'submit',
            'atributes' => array(
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }
}