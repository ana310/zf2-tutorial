<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of AdminTAble
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;

class AdminTable
{
   public $tableGateway;
   
   public function __construct(TableGateway $tableGetaway) 
   {
       $this->tableGateway = $tableGetaway ;
   }
   
   public function fetchAll() 
   {
       // returneaza toate datele dintr-un tabel
       $resultSet = $this->tableGateway->select();
       return $resultSet;
   }
   
   public function getAdmin($id){
       
       $id = (int) $id;
       $rowset = $this->tableGateway->select(array('id' => $id));
       $row = $rowset->current();
       if (!$row) {
           throw new Exception ("Utilizatorul nu exista.");
       }
     return $row;
   }
   
   public function loginAdmin(Admin $admin)
   {
       $username = $admin->nume;
       $parola = $admin->parola;
       $rowset = $this->tableGateway->select(array('username' => $username, 'parola' => $parola));
       $row = $rowset->current();
       
       if(!$row) {
           throw new \Exception ('Nu exista acest administrator.');
       }
       
       $login = new Container('utilizator');
       $login->username = $username;
        
   }
  
}
