<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Produs\Form;
/**
 * Description of ProdusForm
 *
 * @author Mee
 */
use Zend\Form\Form;

class ProdusForm extends Form {
private $name;

   
    public function __construct($name = null) {
        
        parent::__construct('form');
        
         $this->add(array(
            'name' => 'brand',
            'type' => 'Text',
            'options' => array(
                'label' => 'Brand: ',
            ),
        ));
        $this->add(array(
            'name' => 'descriere',
            'type' => 'Text',
            'options' =>array(
                'label' => 'Descriere: ',
            ),
        ));
        $this->add(array(
            'name' => 'denumire',
            'type' => 'Text',
            'options' =>array(
                'label' => 'Denumire: ',
            ),
        ));
    }
}
