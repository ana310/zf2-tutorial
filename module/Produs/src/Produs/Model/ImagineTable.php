<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of ImagineTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;

class ImagineTable {
   
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaProdus($imagine , $id) {
        $data = array(
           'id_produs' => $id,
            'denumire' => $imagine['name'],
            'tip' => $imagine['type'],
        );
        
        $this->tableGateway->insert($data);
    }
}
