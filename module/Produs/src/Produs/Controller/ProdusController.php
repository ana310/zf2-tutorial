<?php
namespace Produs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

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
        
            $select = new Element\Select('categorii');
            $select->setLabel('Selectati categori din care face parte produsul. ');
            
            $categorii = $this->getAtributsetTable()->fetchAll();
            foreach ($categorii as $categorie) {
               $options[$categorie->denumire] = $categorie->denumire;
            }
             
            $select->setValueOptions($options);
            
            $submit =new Element\Submit('submit');
            $submit->setAttribute('id', 'introducere');
            $submit->setValue('Adauga');
            
            
            $form = new Form('categorii');
            $form->add($select);
            $form->add($submit);
         
            $inputCategorii = new Input('categorii');
            $inputCategorii->isRequired();
            
            $inputFilter = new InputFilter();
            $inputFilter->add($inputCategorii);
            
         
           $request = $this->getRequest();
           if($request->isPost()){
               
               $form->setInputFilter($inputFilter);
               $form->setData($request->getPost());
               
               if($form->isValid()){
                   
                  $data = $form->getData();
                  $categorie = $data['categorii'];
                  
                  $atributset = $this->getAtributsetTable()->getAtributsetByName($categorie);
                 
                  if($atributset->denumire == $categorie){
                        $id_categorie = $atributset->id;
                      }
                  }
                   return array('form' => $form, 'atribute' => $this->getAtributsetTable()->joinAtribut($id_categorie)); 
                   
               } else {
                   return (array('form' => $form));
               }  
               
           }      
             
    }
      
        

