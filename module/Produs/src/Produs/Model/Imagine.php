<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of Imagine
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Imagine implements InputFilterAwareInterface{
    
    public $id;
    public $denumire;
    public $id_produs;
    
    public function exchangeArray($data){
    
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->denumire = (!empty($data['denumire'])) ? $data['denumire'] : null;
        $this->id_produs = (!empty($data['id_produs'])) ? $data['id_produs'] : null;
        
    }
    
    public function getInputFilter() {
       
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throwException("Nu il setez");
    }
    
   
}
