<?php
namespace Produs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Produs\Form\ProdusForm;
use Produs\Model\Produs;

class ProdusController  extends AbstractActionController {
    
    protected $produsTable;
    protected $atributsetTable;
    protected $atributTable;
    protected $atributAtributsetTable;
    protected $valoareIntTable;
    protected $valoareVarcharTable;
    
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
    
    public function getValoareIntTable(){
         if(!$this->valoareIntTable) {
            $sm = $this->getServiceLocator();
            $this->valoareIntTable = $sm->get('Produs\Model\ValoareIntTable');
        }
        return $this->valoareIntTable;
    }
    
    public function getValoareVarcharTable(){
         if(!$this->valoareVarcharTable) {
            $sm = $this->getServiceLocator();
            $this->valoareVarcharTable = $sm->get('Produs\Model\ValoareVarcharTable');
        }
        return $this->valoareVarcharTable;
    }
    
    public function indexAction() {
        return array('produse' => $this->getProdusTable()->fetchAll(),);
    }
    
    public function introducereprodusAction(){
        
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             $select = new Element\Select('categorii');
            $select->setLabel('Selectati categori din care face parte produsul. ');
            
            $categorii = $this->getAtributsetTable()->fetchAll();
            foreach ($categorii as $categorie) {
               $options[$categorie->id] = $categorie->denumire;
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
           if(!$request->isPost()){
               return array('form' => $form); 
            }
            
            $form->setInputFilter($inputFilter);
            $form->setData($request->getPost());
               
           if(!$form->isValid()){
               return (array('form' => $form));
               } 
            $data = $form->getData();
            $id_categorie = $data['categorii'];
            
            return $this->redirect()->toRoute('produs', array(
                 'action' => 'introducereprodus','id' => $id_categorie,
             ));
         }
           
           $request = $this->getRequest();
           $produsform = new ProdusForm();
           $produsform->get('submit')->setValue('Insert');
           
           $produs = new Produs();
           $inputFilter = $produs->getInputFilter();
            
           $atribute = $this->getAtributsetTable()->joinAtribut($id);
          
           foreach($atribute as $atribut):
               
                $nume = $atribut->atribut->nume;
                $tip = $atribut->atribut->tip;
                if($atribut->atribut->required == 1){
                    $required = 'true' ;
                } else {
                    $required = 'false';
                }
                
                
                $element = new Element\Text($nume);
                $element ->setLabel(ucfirst($nume));
                $element ->setAttributes(array( 'type' => $tip, 'required' => $required));
                
                $produsform->add($element);
                
                $inputElement = new Input($nume);
                $inputElement->isRequired();
                
                $inputFilter->add($inputElement);

                $numefield[] = $nume;
            endforeach;
                if($request->isPost()){
                   
                    $produsform->setInputFilter($produs->getInputFilter()); 
                    $produsform->setData($request->getPost());
                     
                     if($produsform->isValid()){
                         $produs->exchangeArray($produsform->getData());
                         $values = $produsform->getData();
                         $atribute = $this->getAtributsetTable()->joinAtribut($id);
                         
                         $this->getProdusTable()->adaugaProdus($produs,$id);
                         $id_produs = $this->getProdusTable()->getProdusId();
                         
                         foreach($atribute as $atribut):
                             $nume = $atribut->atribut->nume;
                             $tip = $atribut->atribut->tip;
                             $ida = $atribut->atribut->id;
                            
                             
                             if($tip == 'number') {
                                 $this->getValoareIntTable()->adaugaProdus($id_produs, $ida, $values[$nume]);
                             } 
                             if($tip == 'text') {
                                 $this->getValoareVarcharTable()->adaugaProdus($id_produs, $ida, $values[$nume]);
                             }
                         endforeach;
                     }
                    
                }
//            if($request->isPost()){
//               
//                $produs = new Produs();
//                $produsform->setInputFilter($produs->getInputFilter());
//                $produsform->setData($request->getPost());
//                
//                
//                if($produsform->isValid()){
//                    
//                   $produs->exchangeArray($produsform->getData());
//                   echo "<pre>";
//                  print_r($produs);die;
//                   $this->getProdusTable()->adaugaProdus($produs);
//                   return array('produsform' => $produsform, 'numefield' => $numefield,);
//                }
//                
//            }
             return array('produsform' => $produsform, 'numefield' => $numefield,);
     
               }
                
      
}       

