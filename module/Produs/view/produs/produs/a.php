<?php

namespace Test\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Adapter\Adapter;

class a extends Form {
    
        protected $adapter;
        public function __construct(AdapterInterface $dbAdapter) {

            $this->adapter =$dbAdapter;

            parent::__construct("Test Form");

            $this->setAttribute('method', 'post');

//your select field

            $this->add(array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'name',
                'tabindex' =>2,
                'options' => array(
                    'label' => 'Author',
                    'empty_option' => 'Please select an author',
                    'value_options' => $this->getOptionsForSelect(),
                    )
                ));

// another fields

}
public function getOptionsForSelect(){

    $dbAdapter = $this->adapter;
    $sql = 'SELECT id,name FROM newsauthor where active=1 ORDER BY sortorder ASC';
    $statement = $dbAdapter->query($sql);
    $result = $statement->execute();
    $selectData = array();
    foreach ($result as $res) {
        $selectData[$res['id']] = $res['name'];
    }
    return $selectData;
    }

}
