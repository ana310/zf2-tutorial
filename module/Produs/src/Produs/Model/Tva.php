<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of Tva
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Tva implements InputFilterAwareInterface{
    
    protected $inputFilter;
    
    public $id;
    public $denumire;
    public  $valoare;

    public function exchangeArray($data){
        
          $this->id = (!empty($data['id'])) ? $data['id'] : null;
          $this->denumire = (!empty($data['denumire'])) ? $data['denumire'] : null;
          $this->valoare = (!empty($data['valoare'])) ? $data['valoare'] : null;
    }
        
    public function getInputFilter() {
        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
      return "Nu il setez." ;
    }
}
