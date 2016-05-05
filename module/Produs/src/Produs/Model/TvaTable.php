<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of TvaTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class TvaTable {
    
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function joinCategorie($id){
        $resultSet = $this->tableGateway->select(function(Select $select) use($id){
            $select->join(array('c' => 'categorie'),'tva.id = c.id_tva',array('idatributset'=>'denumire'));
            $where = array('c.id_tva'=> $id);
            $select->where($where); 
        });
        return $resultSet;
    }
}
