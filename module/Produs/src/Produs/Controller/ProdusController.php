<?php
namespace Produs\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ProdusController  extends AbstractActionController {
    
    protected $produsTable;
    protected $atributsetTable;
    
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
    
    public function indexAction() {
        return array('produse' => $this->getProdusTable()->fetchAll(),);
    }
    
    public function introducereprodusAction(){
        return array('categorii' => $this->getAtributsetTable()->fetchAll(),);
    }
}
