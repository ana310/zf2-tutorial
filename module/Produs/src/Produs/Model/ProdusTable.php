<?php

namespace Produs\Model;

use Zend\Db\TableGateway\TableGateway;

class ProdusTable {
    
   public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
}
