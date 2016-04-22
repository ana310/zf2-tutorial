<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of AtributsetTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class AtributsetTable {
    
    public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function joinAtribut($id){
         $resultSet = $this->tableGateway->select(function (Select $select) use($id) {
                $select->join(array('aa' => 'atribut_atributset'),'atributset.id = aa.id_atributset');
                $select->join(array('a' => 'atribut'),'aa.id_atribut = a.id');
                $where = array('atributset.id' => $id);
                $select->where($where);
            });  
       return $resultSet;
        
    }
    
    public function getAtributsetByName($name){
        
       $rowset = $this->tableGateway->select(array('denumire' => $name));
       $row = $rowset->current();
       if (!$row) {
           throw new Exception ("Categoria nu exista.");
       }
     return $row;
    }
}
