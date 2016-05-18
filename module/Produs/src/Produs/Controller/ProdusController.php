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
use Zend\Validator\File\Size;
use Produs\Model\Imagine;
use \Exception;

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
    protected $imagineTable;


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
     * tabela imagini
     * @return type
     */
    public function getImagineTable(){
         if(!$this->imagineTable) {
            $sm = $this->getServiceLocator();
            $this->imagineTable = $sm->get('Produs\Model\ImagineTable');
        }
        return $this->imagineTable;
    }
    /**
     * afisare produse --incomplet
     * @return type
     */
    public function indexAction() {
        $atributsets = $this->getAtributsetTable()->fetchAll();
        foreach ($atributsets as $a) {
            $categorii[$a->id] = $a->denumire;
        }
        $imagine = $this->getImagineTable()->fetchAll();
        $imagini[] = null;
        foreach($imagine as $i){
            $imagini[$i->id_produs] = $i->denumire;
        }
       return array('produse' => $this->getProdusTable()->fetchAll(), 'categorii' => $categorii, 'imagini' =>$imagini);
        
       
    }
    /**
     * introducere produs
     * @return type
     */
    public function introducereprodusAction(){
        
         $this ->layout('produs/layout/layoutprodus.phtml');
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
        
       //verific daca numele luat din formular corespunde cu ceva din baza de date
       $str = $this->request->getRequestUri();
       if(strpos($str,'name') != false){ 
           $imagini = $this->getImagineTable()->fetchAll();
           $nume = substr($str, stripos($str,'=')+1);
           $numenou = str_replace('%20', '-', $nume);
           
           foreach($imagini as $i){
               if(substr($i->denumire,0,stripos($i->denumire,'.')) == strtolower($numenou)){
                   echo "Exista deja o imagine cu acest nume.";
                   die;
               }              
             } die;
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
                if($atribut->atribut->required == '1'){
                    $required = true ;
                } else{
                    $required = false;
                }
                
               
                
                $element = new Element\Text($nume);
                $element ->setLabel(ucfirst($nume));
                $element ->setAttributes(array( 'type' => $tip, 'required' => $required));
                $produsform->add($element);
                
                $inputElement = new Input($nume);
                $inputFilter->add($inputElement);

                $numefield[] = $nume;
            endforeach;
           
            //validarea datelor introduse in formular si introducerea lor in baza de date
                if($request->isPost()){
                    
                    $post = array_merge_recursive(
                        $request->getPost()->toArray(),
                        $request->getFiles()->toArray()
                    );
                    
                   
                 $produsform->setInputFilter($produs->getInputFilter()); 
                 $produsform->setData($post);
                 
                 
                    if($produsform->isValid()){
                        
                         $filename = $_FILES["imagine"]["name"];
                         $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
                         $file_ext = substr($filename, strripos($filename, '.')); // get file name
                         $filesize = $_FILES["imagine"]["size"];
                         $allowed_file_types = array('.jpg','.png','.gif');	

                                    if (in_array($file_ext,$allowed_file_types) && ($filesize > 200))
                                    {	
                                            // Rename file
                                            $name = strtolower(str_replace(' ','-',$produsform->getData()['nume']));
                                            $newfilename = $name. $file_ext;
                                            if (file_exists("E:/licenta/xamp/htdocs/zf2-tutorial/public/img/produse/" . $newfilename))
                                            {
                                                    // file already exists error
                                                    echo "You have already uploaded this file.";
                                            }
                                            else
                                            {		
                                                    move_uploaded_file($_FILES["imagine"]["tmp_name"], "E:/licenta/xamp/htdocs/zf2-tutorial/public/img/produse/" . $newfilename);
                                                    echo "File uploaded successfully.";		
                                            }
                                    }
                                    elseif (empty($file_basename))
                                    {	
                                            // file selection error
                                            echo "Please select a file to upload.";
                                    } 
                                    elseif ($filesize < 200)
                                    {	
                                            // file size error
                                            echo "The file you are trying to upload is too large.";
                                    }
                                    else
                                    {
                                            // file type error
                                            echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
                                            unlink($_FILES["imagine"]["tmp_name"]);
                                    }      

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

                                
                               $this->getImagineTable()->adaugaProdus($newfilename, $id_produs);
                                
                               
                                return $this->redirect()->toRoute('produs', array(
                                   'action' => 'afisareproduse' ));

                            } 
                }
             return array('produsform' => $produsform, 'numefield' => $numefield,);
     
               }
    /**
     * afisare produse in functie de atributsets
     * @return type
     */
    public function afisareproduseAction(){
         
        $this ->layout('produs/layout/layoutprodus.phtml');
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
         
          $imagine = $this->getImagineTable()->fetchAll();
        $imagini[] = null;
        foreach($imagine as $i){
            $imagini[$i->id_produs] = $i->denumire;
        }
         
       return array('produse' => $produse, 'categorie' => $categorie, 'atribute' => $atribute, 'atributes' => $atributes, 'imagini' => $imagini,
           'preturi'=>$pret, 'stoc'=>$stoc, 'id_categorie' => $idcat);
       
    }
    /**
     * setarea statusului unui produs ca fiind indisponibil
     * @return type
     */
    public function stergeprodusAction(){
        
         $id = (int) $this->params()->fromRoute('id', 0);
         
        $produs = $this->getProdusTable()->getProdusById($id);
        foreach ($produs as $p):
             $id_atributset = $p->idatributset;
        endforeach;
     
         $this->getProdusTable()->stergeProdus($id);
          return $this->redirect()->toRoute('produs', array(
                            'action' => 'afisareproduse', 'id' => $id_atributset ));
         
    }
      
}       

