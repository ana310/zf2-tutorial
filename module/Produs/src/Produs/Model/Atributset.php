<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of Atributset
 *
 * @author Mee
 */
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Produs\Model\Atribut;

class Atributset implements InputFilterAwareInterface {
    
    public $id;
    public $denumire;
    public $atribut;
    public $id_categorie;
    protected $inputfilter;
    
    public function exchangeArray($data){
    
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->denumire = (!empty($data['denumire'])) ? $data['denumire'] : null;
        $this->atribut = new Atribut();
        $this->atribut->exchangeArray($data);
        $this->id_categorie = (!empty($data['id_categorie'])) ? $data['id_categorie'] : null;
    }
    
    public function getInputFilter() {
        $inputfilter = new InputFilter();
        return $this->inputfilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throwException("Nu il setez");
    }

}
