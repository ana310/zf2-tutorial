<?php

namespace Produs\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


/**
 * Description of Atribut
 *
 * @author Mee
 */
class Atribut implements InputFilterAwareInterface{
   
    
    public $id;
    public $nume;
    public $tip;
    public $required;
    protected $inputfilter;
    
    public function exchangeArray($data){
    
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->nume = (!empty($data['nume'])) ? $data['nume'] : null;
        $this->tip = (!empty($data['tip'])) ? $data['tip'] : null;
        $this->required = (!empty($data['required'])) ? $data['required'] : null;
        
    }
    
    public function getInputFilter() {
        $inputfilter = new InputFilter();
        return $this->inputfilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throwException("Nu il setez");
    }
}
