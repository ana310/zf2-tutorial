<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Description of Pret
 *
 * @author Mee
 */
class Pret implements InputFilterAwareInterface{
    protected $inputFilter;
    
    public $id;
    public $pret;
    public $pretspecial;
    public $pretspecialcutva;
    public $pretcutva;
    public $data_inceput;
    public $data_sfarsit;
    public $id_produs;
    
    public function exchangeArray($data){
         $this->id = (!empty($data['id'])) ? $data['id'] : null;
         $this->pret = (!empty($data['pret'])) ? $data['pret'] : null;
         $this->pretspecial = (!empty($data['pretspecial'])) ? $data['pretspecial'] : null;
         $this->pretspecialcutva = (!empty($data['pretspecialcutva'])) ? $data['pretspecialcutva'] : null;
         $this->pretcutva = (!empty($data['pretcutva'])) ? $data['pretcutva'] : null;
         $this->data_inceput = (!empty($data['data_inceput'])) ? $data['data_inceput'] : null;
         $this->data_sfarsit = (!empty($data['data_sfarsit'])) ? $data['data_sfarsit'] : null;
         $this->id_produs = (!empty($data['id_produs'])) ? $data['id_produs'] : null;
    }

    public function getInputFilter() {
        
        if(!$this->inputFilter) {
            
            $inputFilter = new InputFilter(); 
            
           
          $this->inputFilter = $inputFilter;  
        }
        return $this->inputFilter;
    }
    

    public function setInputFilter(InputFilterInterface $inputFilter) {
        return "Nu s-a setat";
    }

}
