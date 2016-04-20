<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Customer\Model;

/**
 * Description of AdresaTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Customer\Model\Adresa;
use Zend\Session\Container;
use Zend\Db\Sql\Sql;

class AdresaTable {
    
   public $tableGateway;
   
   public function __construct(TableGateway $tableGateway) {
       $this->tableGateway = $tableGateway;
   }
   
   public function fetchAll(){
       $resultSet = $this->tableGateway->select();
       return $resultSet;
   }
   
   public function getAdresa($id) {
       $id_adresa = (int) $id;
       $rowset = $this->tableGateway->select(array('id' => $id_adresa));
       $row = $rowset->current();
       
       if(!$row) {
            throw new Exception("Adresa inexistenta.");
        }
        return $row;
   }
   
   
   public function adaugaAdresa(Adresa $adresa){
       
       $data = array(
           'judet' => $adresa->judet,
           'oras' => $adresa->oras,
           'strada' =>$adresa->strada,
           'numar' =>$adresa->numar,
       );
       
       $id = (int) $adresa->id;
       if($id == 0) {
                $this->tableGateway->insert($data); 
                $id_adresa = $this->tableGateway->getLastInsertValue();
                
                $login = new Container('utilizator');
                $id_customer = $login->id;
      
                $adapter = $this->tableGateway->getAdapter();    
                $sql = new Sql($adapter);
                $insert = $sql->insert();
                $insert->into('adresa_customer');
                $insert->columns(array('id_adresa','id_customer'));
                $insert->values(array(
                     'id_adresa' => $id_adresa,
                    'id_customer' => $id_customer,
                ));
                $statement = $sql->prepareStatementForSqlObject($insert);
                $results = $statement->execute();
     
       }
       else {
           
             if ($this->getAdresa($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Id-ul adresei nu exista.');
             }
       }
   }
   
    public function stergeadresa($id) {
        $adapter = $this->tableGateway->getAdapter();    
        $sql1 = new Sql($adapter);
        $delete = $sql1->delete('adresa_customer')->where("id_adresa = $id");
        $statement = $sql1->prepareStatementForSqlObject($delete);
        $results = $statement->execute();
        $this->tableGateway->delete(array('id' => (int) $id));
     }
     
    
}
