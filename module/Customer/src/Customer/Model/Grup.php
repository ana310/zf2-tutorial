<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of Grup
 *
 * @author Mee
 */
use Zend\Form\Annotation\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Grup implements InputFilterAwareInterface{
    
    protected $inputFilter;
    public $id;
    public $nume;
    
    public function exchangeArray($data){
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->nume = (!empty($data['nume'])) ? $data['nume'] : null;
    }
    
    public function getInputFilter() {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        
    }

//put your code here
}
