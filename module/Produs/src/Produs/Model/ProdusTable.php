<?php

namespace Produs\Model;

use Zend\Db\TableGateway\TableGateway;
use Produs\Model\AtributsetTable;
use Zend\Db\Sql\Select;

class ProdusTable {
    
   public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaProdus(Produs $produs, $id){
         $data = array(
            'status' => 'disponibil',
            'denumire' => $produs->denumire,
            'brand' => $produs->brand,
            'descriere' => $produs->descriere,
       );
         
         $data['id_atributset'] = $id;    
         $this->tableGateway->insert($data);
        
    }
    
    public function getProdusId(){
        return $this->tableGateway->getLastInsertValue();
    }
    
    public function getProdusByAtributset($id) {
        
        $where = array('id_atributset' => $id);
        $resultSet = $this->tableGateway->select($where);
        
        return $resultSet;
    }
   
}
