<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of ProdusComandaTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;

class ProdusCosTable {
    
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaCos($idprodus, $idcos){
        
    }
}
