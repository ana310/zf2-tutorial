<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Produs\Model;

/**
 * Description of PretTable
 *
 * @author Mee
 */
use Zend\Db\TableGateway\TableGateway;
use \Exception;

class PretTable {
    
     public $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function adaugaProdus(Pret $pret ,$id, $tva){
        
        $pretcutva = $pret->pret + ($pret->pret * $tva/100);
        $pretspecialcutva = $pret->pretspecial + ($pret->pret * $tva/100);
        $data = array( 'pret' => $pret->pret,
            'pretspecial' => $pret->pretspecial,
            'pretspecialcutva' => $pretspecialcutva,
            'pretcutva' => $pretcutva,
            'data_inceput' => $pret->data_inceput,
            'data_sfarsit' => $pret->data_sfarsit,
            'id_produs' => $id,
        );
        
             $this->tableGateway->insert($data);
       
    }
    
}
