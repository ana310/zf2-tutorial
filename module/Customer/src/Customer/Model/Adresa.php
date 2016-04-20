<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of Adresa
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Adresa implements InputFilterAwareInterface {
   
    protected $inputFilter;
    public $ida;
    public $oras;
    public $judet;
    public $strada;
    public $numar;
    
    public function exchangeArray($data) {
        $this->ida = (!empty($data['id'])) ? $data['id'] : null;
        $this->judet = (!empty($data['judet'])) ? $data['judet'] : null;
        $this->oras = (!empty($data['oras'])) ? $data['oras'] : null;
        $this->strada = (!empty($data['strada'])) ? $data['strada'] : null;
        $this->numar = (!empty($data['numar'])) ? $data['numar'] : null;
    }

    public function contructor($data) {
        $this->judet = (!empty($data['judet'])) ? $data['judet'] : null;
        $this->oras = (!empty($data['oras'])) ? $data['oras'] : null;
        $this->strada = (!empty($data['strada'])) ? $data['strada'] : null;
        $this->numar = (!empty($data['numar'])) ? $data['numar'] : null;
    }
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
      public function getInputFilterAdd() {
        
        if (!$this->inputFilter) {
                
             $inputFilter = new InputFilter();
                 
                 $inputFilter->add(array(
                          'name' => 'judet',
                          'required' => true,
                          'flters' => array(
                              array('name' => 'StripTags'),
                              array('name' => 'StringTrim'),
                          ),
                          'validators' => array(
                              array(
                                  'name' => 'StringLength',
                                  'options' => array (
                                      'encouding' => 'UTF-8',
                                      'min' => 3,
                                      'max' => 20,
                                  ),
                                 // 'pattern' => '/^[A-Za-z ]/',
                              ),
                          ),
                    
                    ));
                 
                 $inputFilter->add(array(
                         'name' => 'oras',
                         'required' => true,
                         'filters' => array(
                             array('name' => 'StripTags'),
                             array('name' => 'StringTrim'),
                         ),
                         'validators' => array(
                             array(
                                 'name' => 'StringLength',
                                 'options' => array (
                                     'encouding' => 'UTF-8',
                                     'min' => 3,
                                     'max' => 20,
                                     //'pattern' => '/^[A-Za-z ]/',
                                 ),
                             ),
                         ),    
                 ));
                 $inputFilter->add(array(
                            'name' => 'strada',
                            'required' => true,
                            'filters' => array(
                                array('name' => 'StripTags'),
                                array('name' => 'Stringtrim'),
                            ),
                            'validators' => array(
                                array(
                                    'name' => 'StringLength',
                                    'options' => array (
                                    'encouding' => 'UTF-8',
                                    //'pattern' => '/^0[0-9]{9}/',
                                    ), 
                                ),
                            ),
                 ));
                 $inputFilter->add(array(
                 'name'     => 'numar',
                 'required' => true,
                 'validators' => array(
                                array(
                                    'name' => 'Digits',
                                ),
                     ),
                 ));
 
                  $this->inputFilter = $inputFilter;
        }
         return $this->inputFilter;
    }
    
    public function getInputFilter() {
        
        if (!$this->inputFilter) {
                
             $inputFilter = new InputFilter();
             
                 $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                ));
                 
                 $inputFilter->add(array(
                          'name' => 'judet',
                          'required' => true,
                          'flters' => array(
                              array('name' => 'StripTags'),
                              array('name' => 'StringTrim'),
                          ),
                          'validators' => array(
                              array(
                                  'name' => 'StringLength',
                                  'options' => array (
                                      'encouding' => 'UTF-8',
                                      'min' => 3,
                                      'max' => 20,
                                  ),
                                 // 'pattern' => '/^[A-Za-z ]/',
                              ),
                          ),
                    
                    ));
                 
                 $inputFilter->add(array(
                         'name' => 'oras',
                         'required' => true,
                         'filters' => array(
                             array('name' => 'StripTags'),
                             array('name' => 'StringTrim'),
                         ),
                         'validators' => array(
                             array(
                                 'name' => 'StringLength',
                                 'options' => array (
                                     'encouding' => 'UTF-8',
                                     'min' => 3,
                                     'max' => 20,
                                     //'pattern' => '/^[A-Za-z ]/',
                                 ),
                             ),
                         ),    
                 ));
                 $inputFilter->add(array(
                            'name' => 'strada',
                            'required' => true,
                            'filters' => array(
                                array('name' => 'StripTags'),
                                array('name' => 'Stringtrim'),
                            ),
                            'validators' => array(
                                array(
                                    'name' => 'StringLength',
                                    'options' => array (
                                    'encouding' => 'UTF-8',
                                    //'pattern' => '/^0[0-9]{9}/',
                                    ), 
                                ),
                            ),
                 ));
                 $inputFilter->add(array(
                 'name'     => 'numar',
                 'required' => true,
                 'validators' => array(
                                array(
                                    'name' => 'Digits',
                                ),
                     ),
                 ));
 
                  $this->inputFilter = $inputFilter;
        }
         return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
          throw Exception("Nu il setez");
    }

//put your code here
}
