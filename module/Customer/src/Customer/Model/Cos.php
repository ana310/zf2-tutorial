<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of Cos
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Cos implements InputFilterAwareInterface {
    
    public $id;
    public $token;
    public $ip;
    public $data;
    
    public function exchangeArray($data){
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->token = (!empty($data['token'])) ? $data['token'] : null;
        $this->ip = (!empty($data['ip'])) ? $data['ip'] : null;
        $this->data = (!empty($data['data'])) ? $data['data'] : null;
    }

    public function getInputFilter() {
        
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        
    }

//put your code here
}
