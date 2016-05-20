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
    
    public function getProdusById($id){
        $where = array('id' => $id);
        $resultSet = $this->tableGateway->select($where);
        
        return $resultSet->current();
    }
    
    public function stergeProdus($id){
        
        
        $where = array('id' => $id);
        $resultSet = $this->tableGateway->select($where);
        foreach($resultSet as $result):
            if($result->status == 'disponibil') {
                 $this->tableGateway->update(array('status' => 'indisponibil'), $where);
            } elseif($result->status == 'indisponibil'){
                 $this->tableGateway->update(array('status' => 'disponibil'), $where);
            } 
        endforeach;
        
       
    }
   
    public function joinProdus($id){
        $resultSet = $this->tableGateway->select(function (Select $select) use($id) {
                $select->join(array('p' =>'pret'),'produs.id = p.id_produs');
                $select->join(array('s' => 'stoc'),'produs.id = s.id_produs');
                $where = array('produs.id' => $id);
                $select->where($where);
            }); 
        return $resultSet->current();
    }
    public function joinValoariInt($id){
        $resultSet = $this->tableGateway->select(function (Select $select) use($id) {
                $select->join(array('vi' => 'valoriatributeint'), 'produs.id = vi.id_produs');
                $where = array('produs.id' => $id);
                $select->where($where);
            }); 
        return $resultSet;
    }

    public function joinValoariVarchar($id){
        $resultSet = $this->tableGateway->select(function (Select $select) use($id) {
                $select->join(array('vt' => 'valoriatributetext'), 'produs.id = vt.id_produs');
                $where = array('produs.id' => $id);
                $select->where($where);
            }); 
        return $resultSet;
    }
    
   
}
