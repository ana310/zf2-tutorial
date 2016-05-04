<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of Stoc
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Stoc implements InputFilterAwareInterface{
    protected $inputFilter;
    
    public $id;
    public $id_produs;
    public $stoc;

    public function exchangeArray($data){
        
          $this->id = (!empty($data['id'])) ? $data['id'] : null;
          $this->id_produs = (!empty($data['id_produs'])) ? $data['id_produs'] : null;
          $this->stoc = (!empty($data['stoc'])) ? $data['stoc'] : null;
    }

    public function getInputFilter() {
        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
      return "Nu il setez." ;
    }
}
