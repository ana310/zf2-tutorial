<?php
namespace Produs\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ProdusController  extends AbstractActionController {
    
    protected $produsTable;
    protected $atributsetTable;
    protected $atributTable;
    protected $atributAtributsetTable;
    
    public function getProdusTable(){
        
        if(!$this->produsTable) {
            $sm = $this->getServiceLocator();
            $this->produsTable = $sm->get('Produs\Model\ProdusTable');
        }
        
        return $this->produsTable;
    }
    
    public function getAtributsetTable() {
        
        if(!$this->atributsetTable){
            $sm = $this->getServiceLocator();
            $this->atributsetTable = $sm->get('Produs\Model\AtributsetTable');
        }
        return $this->atributsetTable;
    }
    
    public function getAtributTable() {
        if(!$this->atributTable) {
            $sm = $this->getServiceLocator();
            $this->atributTable = $sm->get('Produs\Model\AtributTable');
        }
        return $this->atributTable;
    }
    
    public function getAtributAtributsetTable() {
        if(!$this->atributAtributsetTable) {
            $sm = $this->getServiceLocator();
            $this->atributAtributsetTable = $sm->get('Produs\Model\AtributAtributsetTable');
        }
        return $this->atributAtributsetTable;
    }
    
    public function indexAction() {
        return array('produse' => $this->getProdusTable()->fetchAll(),);
    }
    
    public function introducereprodusAction(){
        $id_categorie = (int) $this->params()->fromRoute('id', 0);
         if (!$id_categorie) {
             return array('categorii' => $this->getAtributsetTable()->fetchAll(),
                     'atribute' => $this->getAtributTable()->fetchAll());
         } else {
              return array('categorii' => $this->getAtributsetTable()->fetchAll(),
                     'atribute' => $this->getAtributsetTable()->joinAtribut($id_categorie)); 
             
         }
             
    }
      
        
}
