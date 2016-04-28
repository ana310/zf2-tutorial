<?php
namespace Produs\Model;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;



/**
 * Description of ValoareVarcharTable
 *
 * @author Mee
 */
class ValoareVarcharTable {
    
      public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaProdus($id_produs, $id_atribut, $value) {
        
        $data = array(
            'id_produs' => $id_produs,
            'id_atribut' => $id_atribut,
            'valoare' => $value,
       );
        
        $this->tableGateway->insert($data);
    }
    
}
