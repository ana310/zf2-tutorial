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

    public function __construct($name = null) {
        
        parent::__construct('produs');
        $this->add(array(
            'name' => 'imagine',
             'type'  => 'file',
            'atributes' => array(
                'value' => 'Imagine',
                'id' => 'imagine-file',
            ),
            'options' => array(
                'label' => 'Imagine: ',
            ),
        ));
        $this->add(array(
            'name' => 'denumire',
            'type' => 'Text',
            'options' => array(
                'label' => 'Denumire: ',
            ),
        ));
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
            'options' => array(
                'label' => 'Descriere: ',
            ),
        ));
        $this->add(array(
            'name' => 'pret',
            'type' => 'Text',
            'options' => array(
                'label' => 'Pret: ',
            ),
        ));
        $this->add(array(
            'name' => 'pretspecial',
            'type' => 'Text',
            'options' => array(
                'label' => 'Pret special: ',
            ),
        ));
        $this->add(array(
            'name' => 'data_inceput',
            'type' => 'date',
            'options' => array(
                'label' => 'Data start: ',
            ),
        ));
        $this->add(array(
            'name' => 'data_sfarsit',
            'type' => 'date',
            'options' => array(
                'label' => 'Data sfarsit: ',
            ),
        ));
        $this->add(array(
            'name' => 'stoc',
            'type' => 'Number',
            'options' => array(
                'label' => 'Stoc: ',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' =>'submit',
            'atributes' => array(
                'value' => 'Insert',
                'id' => 'insertprodus',
            ),
        ));
        
        
        
         
    }
}
