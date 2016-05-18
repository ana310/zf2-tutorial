<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of ProdusComanda
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ProdusCos implements InputFilterAwareInterface {
    
    public $id;
    public $idprodus;
    public $idcos;
    public $cantitate;
    
     public function exchangeArray($data){
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->idprodus = (!empty($data['id_produs'])) ? $data['id_produs'] : null;
        $this->idcos = (!empty($data['id_cos'])) ? $data['id_cos'] : null;
        $this->cantitate = (!empty($data['cantitate'])) ? $data['cantitate'] : null;
    }
    
    public function getInputFilter() {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        
    }

//put your code here
}
