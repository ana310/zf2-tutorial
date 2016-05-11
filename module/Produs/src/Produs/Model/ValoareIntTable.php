<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of ValoareIntTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ValoareIntTable {
    
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
    
     public function getValue($idp,$ida){
        $where = (array('id_produs' => $idp, 'id_atribut' => $ida));
       $resultSet = $this->tableGateway->select($where);
      
       return $resultSet;
    }
    
}
