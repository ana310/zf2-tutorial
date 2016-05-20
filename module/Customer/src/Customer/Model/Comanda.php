<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer\Model;
/**
 * Description of Comanda
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
class Comanda implements InputFilterAwareInterface {
    
    public $id;
    public $idcos;
    public $pret;
    public $status;
    
    public function exchangeArray($data){
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->idcos = (!empty($data['id_cos'])) ? $data['id_cos'] : null;
        $this->pret = (!empty($data['pret'])) ? $data['pret'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
    }
    
    public function getInputFilter() {
        
    }
    public function setInputFilter(InputFilterInterface $inputFilter) {
        
    }
//put your code here
}