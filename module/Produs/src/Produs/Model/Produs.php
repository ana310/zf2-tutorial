<?php

namespace Produs\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Produs implements InputFilterAwareInterface {
    
    protected $inputFilter;
    
    public function getInputFilter() {
        
        $inputFilter = new InputFilter();
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw Exception("Nu il setez");
    }

//put your code here
}
