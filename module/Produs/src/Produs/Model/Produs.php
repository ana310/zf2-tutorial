<?php

namespace Produs\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Produs implements InputFilterAwareInterface {
    
    protected $inputFilter;
    public $id;
    public $idatributset;
    public $status;
    
    /**
     * 
     * @param type $data
     */
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->idatributset = (!empty($data['id_atributset'])) ? $data['id_atributset'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
    } 
    /**
     * used for bind
     * @return type
     */
    public function getArrayCopy(){
        return get_object_vars($this);
    }
    /**
     * 
     * @return type
     */ 
    public function getInputFilter() {
        
        if(!$this->inputFilter) {
            
            $inputFilter = new InputFilter();
            
       
        }
        return $this->inputFilter;
    }
    /**
     * 
     * @param InputFilterInterface $inputFilter
     * @throws type
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw Exception("Nu il setez");
    }

//put your code here
}
