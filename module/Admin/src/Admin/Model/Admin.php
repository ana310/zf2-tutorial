<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Model;
/**
 * Description of Admin
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Admin implements InputFilterAwareInterface
{
    
    public $id;
    public $username;
    public $nume;
    public $prenume;
    public $email;
    public $telefon;
    public $parola;
    public $varsta;
    public $oras;
    public $judet;
    public $adresa;
    public $activ;
    public $data_inregistrare;
    public $data_modificare;
    protected $inputFilter;
    
    
    public function exchangeArray($data) 
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->nume  = (!empty($data['nume'])) ? $data['nume'] : null;
        $this->prenume = (!empty($data['prenume'])) ? $data['prenume'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->telefon = (!empty($data['telefon'])) ? $data['telefon'] : null;
        $this->parola = (!empty($data['parola'])) ? $data['parola'] : null;
        $this->varsta = (!empty($data['varsta'])) ? $data['varsta'] : null;
        $this->oras = (!empty($data['oras'])) ? $data['oras'] : null;
        $this->judet = (!empty($data['judet'])) ? $data['judet'] : null;
        $this->adresa = (!empty($data['adresa'])) ? $data['adresa'] : null;
        $this->activ = (!empty($data['activ'])) ? $data['activ'] : null;
        $this->data_inregistrare = (!empty($data['data_inregistrare'])) ? $data['data_inregistrare'] : null;
        $this->data_modificare = (!empty($data['data_modificare'])) ? $data['data_modificare'] : null;
    }

    public function getInputFilter() {
        
        if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

                $inputFilter->add(array(
                         'name'     => 'nume',
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
                 'name'     => 'parola',
                 'required' => true, 
             ));

                
                  $this->inputFilter = $inputFilter;
        }
         return $this->inputFilter;

    }

    public function setInputFilter( InputFilterInterface $inputFilter) {
        throw new Exception("Nu il setez");
    }

}
