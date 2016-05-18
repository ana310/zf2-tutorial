<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of CosTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;

class CosTable {
    
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaCos($token,$ip){
        $data = date("Y-m-d");
        $this->tableGateway->insert('',$token,$ip,$data);
    }
    
    public function getLastInsertId(){
        return $this->tableGateway->getLastInsertValue();
    }
}
