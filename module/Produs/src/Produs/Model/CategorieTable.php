<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of CategorieTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CategorieTable {
   
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function joinAtributset($id){
      
        $resultSet = $this->tableGateway->select(function(Select $select) use ($id){
            $select->join(array('a' => 'atributset'),'categorie.id = a.id_categorie',array('idatributset'=>'denumire'));
            $where = array('a.id'=> $id);
            $select->where($where);
        });
        
        return $resultSet;
    }
    
}
