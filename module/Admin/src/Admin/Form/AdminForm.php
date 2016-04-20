<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Form;
/**
 * Description of AdminForm
 *
 * @author Mee
 */
use Zend\Form\Form;

class AdminForm extends Form 
{
    public function __construct($name = null) {
        
        parent::__construct('admin');
        
        $this->add(array(
            'name' => 'nume',
            'type' => 'Text',
            'options' => array(
                'label' => 'Username: ',
            ),
        ));
        $this->add(array(
            'name' => 'parola',
            'type' => 'password',
            'options' =>array(
                'label' => 'Parola: ',
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
