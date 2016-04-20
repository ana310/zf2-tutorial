<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Form;

/**
 * Description of RegisterForm
 *
 * @author Mee
 */
use Zend\Form\Form;

class RegisterForm extends Form {
    
    public function __construct($name = null) {
        
        parent::__construct('customer');
        
        $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
        
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' =>array(
                'label' => 'Username: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'nume',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nume: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'prenume',
            'type' => 'Text',
            'options' => array(
                'label' => 'Prenume: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' =>array(
                'label' => 'Email: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'telefon',
            'type' => 'Text',
            'options' => array(
                'label' => 'Telefon: '
            ),
        ));
        
        $this->add(array(
            'name' => 'varsta',
            'type' => 'Text',
            'options' => array(
                'label' => 'Varsta: ',
            ),
        ));

        $this->add(array(
            'name' => 'parola',
            'type' => 'password',
            'options' => array(
                'label' => 'Parola: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'confirmaparola',
            'type' => 'password',
            'options' => array (
                'label' => 'Conforma parola:'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'type' =>'submit',
            'atributes' => array(
                'value' => 'Inregistrare',
                'id' => 'registerbutton',
            ),
        ));
    }
    
}
