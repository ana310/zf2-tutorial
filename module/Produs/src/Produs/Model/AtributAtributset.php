<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of AtributAtributset
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AtributAtributset implements InputFilterAwareInterface {
    
    protected $inputFilter;
    public $id;
    public $idatributset;
    public $idatribut;
    
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->idatributset = (!empty($data['id_atributset'])) ? $data['id_atributset'] : null;
        $this->idatribut = (!empty($data['id_atribut'])) ? $data['id_atribut'] : null;   
    }
    
    public function getInputFilter() {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
          throwException("Nu il setez");
    }
}
