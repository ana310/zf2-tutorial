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
    
    public function adaugaCos($token, $idutilizator = null){
        $data = date("Y-m-d");
        if(isset($idutilizator)){
             $this->tableGateway->insert(array('token' => $token, 'data' => $data, 'id_utilizator' =>$idutilizator));
        } else {
            $this->tableGateway->insert(array('token' => $token, 'data' => $data));
        }
        
    }
    
    public function getLastInsertId(){
        return $this->tableGateway->getLastInsertValue();
    }
   
    public function getCosByToken($token){
        $where = array('token' => $token);
        $resultSet = $this->tableGateway->select($where);
        
        return $resultSet->current();
    }
    
    public function getCosByIdutilizator($idutilizator){
        $where = array('id_utilizator' => $idutilizator);
        $resultSet = $this->tableGateway->select($where);
        
        return $resultSet->current();
    }
    
    public function updateIdUtilizator($cookie,$idutilizator) {
        $where = array('token' => $cookie);
        $this->tableGateway->update(array('id_utilizator' => $idutilizator), $where);
    }
    
    
    public function stergeCosCurent($coscurent) {
    
        $idcos = $coscurent->id;
        $this->tableGateway->delete(array('id' => $idcos));
}
}