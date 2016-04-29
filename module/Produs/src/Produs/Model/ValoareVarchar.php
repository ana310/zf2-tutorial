<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of ValoareInt
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class ValoareVarchar implements InputFilterAwareInterface{
    
     
    public $id;
    public $id_atribut;
    public $id_produs;
    public $valoare;
    protected $inputfilter;
    
    public function exchangeArray($data){
    
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->id_atribut = (!empty($data['id_atribut'])) ? $data['id_atribut'] : null;
        $this->id_produs = (!empty($data['id_produs'])) ? $data['id_produs'] : null;
        $this->valoare = (!empty($data['valoare'])) ? $data['valoare'] : null;
        
    }
    
    public function getInputFilter() {
       
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throwException("Nu il setez");
    }
}