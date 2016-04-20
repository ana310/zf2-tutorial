<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer\Model;
/**
 * Description of CustomerTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;
use Customer\Model\Adresa;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class CustomerTable {
   
    public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
     /**
      * 
      * @param type $table --tabela cu care customer face join
      * @param type $foreignkey -- c=coloana din customer care e cheie straina
      * @param type $column -- coloana din tabela cealalata de care am nevoie
      * @return type
      */

    public function join($id) {
        
        
     $resultSet = $this->tableGateway->select(function (Select $select) use($id) {
//    $select->join(array('g' => 'grup'),
//                        'customer.id_grup = g.id');
    $select->join(array('ac' => 'adresa_customer'),'customer.id = ac.id_customer');
    $select->join(array('a' => 'adresa'),'ac.id_adresa = a.id');
    $where = array('customer.id' => $id);
    $select->where($where);
});  
       return $resultSet;
        
    }

    public function getCustomer($id) {
       
        $id_customer = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id_customer));
        $row = $rowset->current();
        
        if(!$row) {
            throw new Exception("Utilizatorul nu exista.");
        }
        return $row;
    }
    
    public function loginCustomer(Customer $customer){
       $username = $customer->username;
       $parola = $customer->parola;
       
       $rowset = $this->tableGateway->select(array('username' => $username, 'parola' => $parola));
       $row = $rowset->current();
       
       if(!$row) {
            echo $username." ". $parola;
           throw new \Exception ('Nu exista acest utilizator.');
       }
       
       $login = new Container('utilizator');
       $login->username = $username;
       $login->id = $row->id;
       
   }

    public function registerCustomer(Customer $customer) {

       $data = array(
            'username' => $customer->username,
            'nume' => $customer->nume,
            'prenume' => $customer->prenume,
            'email' => $customer->email,
            'telefon' => $customer->telefon,
            'parola' => $customer->parola,
            'varsta' => $customer->varsta,
            'data_inregistrare' => date("Y-m-d"),
            'data_modificare' => date("Y-m-d"),
            'id_grup' => 1,
   
       );
       $edit = new Container('editare');
       if(isset($edit) && $customer->id != 0){
           $data['username'] = $edit->username;
           $data['email'] = $edit->email;
           $data['parola'] = $edit->parola;
       }
       
       $id = (int) $customer->id;
       if($id == 0) {
           //$edit->getManager()->getStorage()->clear('editare');
           print_r($data);
            $result = $this->tableGateway->select(array('username' => $data['username']));
            $row = $result->current();
            print_r($row);
            if($row){
                throw new \Exception("Exista deja un utilizator cu acest username.");
            }
            $rowset = $this->tableGateway->select(array('email' => $data['email']));
            $row1 = $rowset->current();

            if($row1){
                throw new \Exception("Exista deja un utilizator cu acest email.");
            }
           $this->tableGateway->insert($data); 
       }
       else {
           if ($this->getCustomer($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
                 unset($edit);
             } else {
                 throw new \Exception('Utilizatorul cu acest id nu exista.');
             }
       }
   
   }  
   
    public function stergeCustomer($id) {
        
         $result = $this->getCustomer($id);
         $idgrup = $result->id_grup;
        
         $where = array('id' => $id);
         
         if($idgrup == 4) {
             $this->tableGateway->update(array('id_grup' => 1), $where);
         } else {
             $this->tableGateway->update(array('id_grup' => 4), $where);
         }
//        
//        
//        $where->like(('nume_grup', "%".$data['section_name']."%");
//        $update = $sql->set(array('id_grup' => 2])->where($where);
//        $this->tableGateway->delete(array('id' => (int) $id));
//       
    }
 
  
}
