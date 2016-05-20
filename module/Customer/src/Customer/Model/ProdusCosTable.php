<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer\Model;
/**
 * Description of ProdusComandaTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
class ProdusCosTable {
    
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaCos($idprodus, $idcos){
        $this->tableGateway->insert(array('id_produs' => $idprodus,'id_cos' => $idcos,'cantitate' => 1));       
    }
    
    public function getLastInsertId(){
        return $this->tableGateway->getLastInsertValue();
    }
    
    public function getProduseCos($idcos){
        $where = array('id_cos' => $idcos);
        $resultSet = $this->tableGateway->select($where);
        
        return $resultSet;
    }
    
    public function updateCantitate($idcos, $idprodus,$cantitate){
        $where = array('id_cos'=>$idcos, 'id_produs' => $idprodus);
        $this->tableGateway->update(array('cantitate' => $cantitate), $where);
    }
    
    public function existaProdus($idcos,$idprodus){
        
        $where = array('id_cos'=>$idcos, 'id_produs' => $idprodus);
        $resultSet = $this->tableGateway->select($where);
        
        return $resultSet->current();
        
    }
    
     public function adaugaInCos($cosexistent,$coscurent) {
        foreach ($cosexistent as $ce):
            $idcos = $ce->idcos;
            $cos[$ce->idprodus] = $ce->cantitate;
        endforeach;
        foreach($coscurent as $cc):
            $cosc[$cc->idprodus] = $cc->cantitate;
        endforeach;
        //petru fiecare element din cosul curent daca exista deja unul in cos cresc cantitatea daca nu adaug in cos
        foreach ($cosc as $key => $value):
            if(array_key_exists($key, $cos)){
                $cos[$key] = $cos[$key]+$value;
                $this->tableGateway->update(array('cantitate' => $cos[$key]), array('id_cos'=>$idcos,'id_produs'=>$key));
            } else {
                $this->tableGateway->insert(array('id_produs'=>$key, 'id_cos' =>$idcos, 'cantitate' => $value));
            }
        endforeach;
    }
    
    public function stergeCosCurent($coscurent){
        
        $idcos = $coscurent->id;
        $this->tableGateway->delete(array('id_cos' => $idcos));
    }
}
