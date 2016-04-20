<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer\Model;
/**
 * Description of Customer
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Customer\Model\Adresa;

class Customer implements InputFilterAwareInterface {
    
    protected $inputFilter;
    public $id;
    public $username;
    public $nume;
    public $prenume;
    public $email;
    public $telefon;
    public $parola;
    public $varsta;
    public $data_inregistrare;
    public $data_modificare;
    public $id_grup;
    public $adresa;
    
    public function exchangeArray($data) 
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->nume = (!empty($data['nume'])) ? $data['nume'] : null;
        $this->prenume = (!empty($data['prenume'])) ? $data['prenume'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->telefon = (!empty($data['telefon'])) ? $data['telefon'] : null;
        $this->parola = (!empty($data['parola'])) ? $data['parola'] : null;
        $this->varsta = (!empty($data['varsta'])) ? $data['varsta'] : null;
        $this->data_inregistrare = (!empty($data['data_inregistrare'])) ? $data['data_inregistrare'] : null;
        $this->data_modificare = (!empty($data['data_modificare'])) ? $data['data_modificare'] : null;
        $this->id_grup = (!empty($data['id_grup'])) ? $data['id_grup'] : null;
        $this->adresa = new Adresa();
        $this->adresa->exchangeArray($data);
    }
    
    public function getArrayCopy()
     {
         return get_object_vars($this);
     }

    
        public function getInputFilter() {
        
            if (!$this->inputFilter) {
                
             $inputFilter = new InputFilter();

                $inputFilter->add(array(
                         'name'     => 'username',
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
                                     'min'      => 6,
                                     'max'      => 20,
                                 ),
                             ),
                         ),
                     ));
                
                $inputFilter->add(array(
                         'name'     => 'parola',
                         'required' => true, 
                    ));
                
                  $this->inputFilter = $inputFilter;
        }
         return $this->inputFilter;

    }
    public function getInputFilterRegister(){
       
        if (!$this->inputFilter) {
                
             $inputFilter = new InputFilter();
              
                $inputFilter->add(array(
                         'name'     => 'username',
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
                                     'min'      => 6,
                                     'max'      => 20,
                                 ),
                             ),
                         ),
                     ));
                
                 $inputFilter->add(array(
                          'name' => 'nume',
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
                         'name' => 'prenume',
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
                          'name' => 'email',
                          'required' => true,
                          'filters' => array(
                              array('name' => 'StripTags'),
                              array('name' => 'StringTrim'),
                          ),
                           'validators' => array(
                               array(
                                   'name' => 'StringLength',
                                   'options' => array(
                                       'encouding' => 'UTF-8',
                                       'min' => 7,
                                      // 'pattern' => '/^ [A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/',
                                   ),
                               ),
                           ),
                 ));
                 
                 $inputFilter->add(array(
                            'name' => 'telefon',
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
                 'name'     => 'varsta',
                 'required' => true,
                 'validators' => array(
                                array(
                                    'name' => 'Digits',
                                ),
                     ),
                 ));
                 
                $inputFilter->add(array(
                            'name'     => 'confirmaparola',
                            'required' => true, 
                ));
                
                $inputFilter->add(array(
                         'name'     => 'parola',
                         'required' => true, 
                    ));
 
                  $this->inputFilter = $inputFilter;
        }
         return $this->inputFilter;
    }
    
    public function getInputFilterEdit(){
        
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
                          'name' => 'nume',
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
                         'name' => 'prenume',
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
                            'name' => 'telefon',
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
                 'name'     => 'varsta',
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
    
   
    public function setInputFilter( InputFilterInterface $inputFilter) {
       throw Exception("Nu il setez");
    }

}
