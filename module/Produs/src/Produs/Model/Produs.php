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
    public $denumire;
    public $brand;
    public $descriere;
    /**
     * 
     * @param type $data
     */
    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->idatributset = (!empty($data['id_atributset'])) ? $data['id_atributset'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->denumire = (!empty($data['denumire'])) ? $data['denumire'] : null;
        $this->brand = (!empty($data['brand'])) ? $data['brand'] : null;
        $this->descriere = (!empty($data['descriere'])) ? $data['descriere'] : null;
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
            
            $inputFilter->add(array(
                         'name'     => 'denumire',
                         'required' => true,
                         'filters'  => array(
                             array('name' => 'StripTags'),
                             array('name' => 'StringTrim'),
                         ),
                         'validators' => array(
                             array(
                                 'name'    => 'StringLength',
                                 'options' => array(
                                     'encoding' => 'UTF-8',
                                     'min'      => 3,
                                     'max'      => 20,
                                 ),
                             ),
                         ),
            ));
            $inputFilter->add(array(
                         'name'     => 'brand',
                         'required' => true,
                         'filters'  => array(
                             array('name' => 'StripTags'),
                             array('name' => 'StringTrim'),
                         ),
                         'validators' => array(
                             array(
                                 'name'    => 'StringLength',
                                 'options' => array(
                                     'encoding' => 'UTF-8',
                                     'min'      => 3,
                                     'max'      => 20,
                                 ),
                             ),
                         ),
             ));
            $inputFilter->add(array(
                         'name'     => 'descriere',
                         'required' => true,
                         'filters'  => array(
                             array('name' => 'StripTags'),
                             array('name' => 'StringTrim'),
                         ),
                         'validators' => array(
                             array(
                                 'name'    => 'StringLength',
                                 'options' => array(
                                     'encoding' => 'UTF-8',
                                     'min'      => 3,
                                 ),
                             ),
                         ),
            ));
          $this->inputFilter = $inputFilter;  
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
