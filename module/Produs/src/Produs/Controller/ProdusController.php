<?php
namespace Produs\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Produs\Form\ProdusForm;
use Produs\Model\Produs;
use Produs\Model\Pret;
use Produs\Model\Stoc;

class ProdusController  extends AbstractActionController {
    
    protected $produsTable;
    protected $atributsetTable;
    protected $atributTable;
    protected $atributAtributsetTable;
    protected $valoareIntTable;
    protected $valoareVarcharTable;
    protected $pretTable;
    protected $stocTable;
    protected $tvaTable;
    protected $categorieTable;


    /**
     * tabela produs
     * @return type
     */
    public function getProdusTable(){
        
        if(!$this->produsTable) {
            $sm = $this->getServiceLocator();
            $this->produsTable = $sm->get('Produs\Model\ProdusTable');
        }
        
        return $this->produsTable;
    }
    /**
     * tabela atributset
     * @return type
     */
    public function getAtributsetTable() {
        
        if(!$this->atributsetTable){
            $sm = $this->getServiceLocator();
            $this->atributsetTable = $sm->get('Produs\Model\AtributsetTable');
        }
        return $this->atributsetTable;
    }
    /**
     * tabela atribut
     * @return type
     */
    public function getAtributTable() {
        if(!$this->atributTable) {
            $sm = $this->getServiceLocator();
            $this->atributTable = $sm->get('Produs\Model\AtributTable');
        }
        return $this->atributTable;
    }
    /**
     * tabela atribut_atributset(leaga atribut i atributset)
     * @return type
     */
    public function getAtributAtributsetTable() {
        if(!$this->atributAtributsetTable) {
            $sm = $this->getServiceLocator();
            $this->atributAtributsetTable = $sm->get('Produs\Model\AtributAtributsetTable');
        }
        return $this->atributAtributsetTable;
    }
    /**
     * tabela valoriatributeint
     * @return type
     */
    public function getValoareIntTable(){
         if(!$this->valoareIntTable) {
            $sm = $this->getServiceLocator();
            $this->valoareIntTable = $sm->get('Produs\Model\ValoareIntTable');
        }
        return $this->valoareIntTable;
    }
    /**
     * tabela valoriatributetext
     * @return type
     */
    public function getValoareVarcharTable(){
         if(!$this->valoareVarcharTable) {
            $sm = $this->getServiceLocator();
            $this->valoareVarcharTable = $sm->get('Produs\Model\ValoareVarcharTable');
        }
        return $this->valoareVarcharTable;
    }
    /**
     * tabela pret
     */
    public function getPretTable(){
        if(!$this->pretTable) {
            $sm = $this->getServiceLocator();
            $this->pretTable = $sm->get('Produs\Model\PretTable');
        }
        return $this->pretTable;
    }
    /**
     * tabela stoc
     */
    public function getStocTable(){
        if(!$this->stocTable) {
            $sm = $this->getServiceLocator();
            $this->stocTable = $sm->get('Produs\Model\StocTable');
        }
        return $this->stocTable;
    }
     /**
     * tabela tva
     */
    public function getTvaTable(){
        if(!$this->tvaTable) {
            $sm = $this->getServiceLocator();
            $this->tvaTable = $sm->get('Produs\Model\TvaTable');
        }
        return $this->tvaTable;
    }
    /**
     * tabela tva
     */
    public function getCategorieTable(){
        if(!$this->categorieTable) {
            $sm = $this->getServiceLocator();
            $this->categorieTable = $sm->get('Produs\Model\CategorieTable');
        }
        return $this->categorieTable;
    }
    /**
     * afisare produse --incomplet
     * @return type
     */
    public function indexAction() {
       return array('produse' => $this->getProdusTable()->fetchAll(),);
    }
    /**
     * introducere produs
     * @return type
     */
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
         
           $idcategorie = $this->getCategorieTable()->joinAtributset($id);
           foreach ($idcategorie as $idcat):
               $idtva = $idcat->id_tva;
           endforeach;
         
           $tva = $this->getTvaTable()->joinCategorie($idtva);
           foreach($tva as $t):
              $valoaretva = $t->valoare;
           endforeach;
          
           
           $request = $this->getRequest();
           $produsform = new ProdusForm();
           $produsform->get('submit')->setValue('Insert');
           
           $produs = new Produs();
           $inputFilter = $produs->getInputFilter();
            
           $atribute = $this->getAtributsetTable()->joinAtribut($id);
          
           //constructia formularului dinamic in functie de atributele declarate
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
            
            //validarea datelor introduse in formular si introducerea lor in baza de date
                if($request->isPost()){
                   
                    $produsform->setInputFilter($produs->getInputFilter()); 
                    $produsform->setData($request->getPost());
                     
                     if($produsform->isValid()){
                    
                         $produs->exchangeArray($produsform->getData());
                         $values = $produsform->getData();
                         $atribute = $this->getAtributsetTable()->joinAtribut($id);
                         
                         //adaugarea in tabela produs
                         $this->getProdusTable()->adaugaProdus($produs,$id);
                         $id_produs = $this->getProdusTable()->getProdusId();
                         
                         //pentru diecare atribut verific tipul si adaug in valoriatributeint sau valoriatributechar
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
                         
                         $pret = new Pret();
                         $pret->exchangeArray($produsform->getData());
                         
                         $this->getPretTable()->adaugaProdus($pret, $id_produs, $valoaretva);
                         
                         $stoc = new Stoc();
                         $stoc->exchangeArray($produsform->getData());
                         $this->getStocTable()->adaugaProdus($stoc, $id_produs);
                       
                          return $this->redirect()->toRoute('produs', array(
                            'action' => 'index' ));
                     }
                    
                }
             return array('produsform' => $produsform, 'numefield' => $numefield,);
     
               }
    
    public function afisareproduseAction(){
         $idcat = (int) $this->params()->fromRoute('id', 0);
         
         if (!$idcat) {
             
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
                 'action' => 'afisareproduse','id' => $id_categorie,
             ));
         }
         
        $produse = $this->getProdusTable()->getProdusByAtributset($idcat);
       
        
        foreach($produse as $produs):
           
         $atribute = $this->getAtributsetTable()->joinAtribut($idcat);
            foreach($atribute as $atribut):
                
                if($atribut->atribut->tip == 'number'){
                    $result = $this->getValoareIntTable()->getValue($produs->id,$atribut->id);
                }
                if($atribut->atribut->tip == 'text') {
                    $result = $this->getValoareVarcharTable()->getValue($produs->id,$atribut->id);
                }
                foreach($result as $res):
                    $atributes[] = [$res->id_produs=>[$res->id_atribut => $res->valoare]];
                endforeach;
                
            endforeach; 
        endforeach;
        
        $categorii = $this->getAtributsetTable()->fetchAll();
        
        foreach ($categorii as $atributset):
            $categorie[$atributset->id] = $atributset->denumire;
        endforeach;
        
        
        $produse = $this->getProdusTable()->getProdusByAtributset($idcat);
          $atribute = $this->getAtributsetTable()->joinAtribut($idcat);
//        $produs = $this->getProdusTable()->joinProdusAtributInt(16);
        
        
         $preturi =  $this->getPretTable()->fetchAll();
         $today = date("Y-m-d");
         foreach ($preturi as $p):
            $data_inceput = $p->data_inceput;
            $data_sfarsit = $p->data_sfarsit;
            if($data_inceput < $today && $today<$data_sfarsit){
                $pret[$p->id_produs] = $p->pretspecialcutva;
            } else {
             $pret[$p->id_produs] = $p->pretcutva;
            }
         endforeach;
         
         
         $stocuri = $this->getStocTable()->fetchAll();
         foreach ($stocuri as $s):
             $stoc[$s->id_produs] = $s->stoc;
         endforeach;
         
       return array('produse' => $produse, 'categorie' => $categorie, 'atribute' => $atribute, 'atributes' => $atributes,
           'preturi'=>$pret, 'stoc'=>$stoc);
       
    }
                
      
}       

