<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of GrupTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;

class GrupTable {
    protected $tableGateway;
    
     public function __construct(TableGateway $tableGateway) {
       $this->tableGateway = $tableGateway;
   }
   
   public function fetchAll(){
       $resultSet = $this->tableGateway->select();
       return $resultSet;
   }
    
    public function getGrup($id){
        $id_grup = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id_grup));
        $row = $rowset->current();
        
          if(!$row) {
            throw new Exception("Grup inexistent.");
        }
        return $row;
    }
}
