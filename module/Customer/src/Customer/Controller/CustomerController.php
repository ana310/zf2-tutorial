<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer\Controller;
/**
 * Description of CustomerController
 *
 * @author Mee
 */
use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Helper\ViewModel;
use Customer\Form\CustomerForm;
use Customer\Form\RegisterForm;
use Customer\Form\AdresaForm;
use Zend\Session\Container;
use Customer\Model\Customer;
use Customer\Model\Adresa;
use Zend\Http\Header\SetCookie;

class CustomerController  extends AbstractActionController{
    
    protected $customerTable;
    protected $adresaTable;
    protected $grupTable;
    protected $atributsetTable;
    protected $produsTable;
    protected $imagineTable;




    /**
     * returneaza tabela customer
     * @return type
     */
    public function getCustomerTable(){
        if(!($this->customerTable)){
            $sm = $this->getServiceLocator();
            $this->customerTable = $sm->get('Customer\Model\CustomerTable');
        }
        return $this->customerTable;
    }
    /**
     * returneaza tabela adresa
     * @return type
     */
    public function getAdresaTable(){
         if(!($this->adresaTable)){
            $sm = $this->getServiceLocator();
            $this->adresaTable = $sm->get('Customer\Model\AdresaTable');
        }
        return $this->adresaTable;
    }
    /**
     * returneaza tabela grup
     * @return type
     */
    public function getGrupTable(){
         if(!($this->grupTable)){
            $sm = $this->getServiceLocator();
            $this->grupTable = $sm->get('Customer\Model\GrupTable');
        }
        return $this->grupTable;
    }
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
     * actiune afisare grupuri
     * @return type
     */
    public function grupAction() {
        return array (
            'grupuri' => $this->getGrupTable()->fetchAll(),); 
    } 
    /**
     * actiune afisare pagina principala
     */
    public function indexAction() {
        
        $this ->layout('customer/layout/layout.phtml');
             
         $id = (int) $this->params()->fromRoute('id', 0);
         if(!$id){
             $atributsets = $this->getAtributsetTable()->fetchAll();
             foreach ($atributsets as $a) {
                $categorii[$a->id] = $a->denumire;
             }
             $imagine = $this->getImagineTable()->fetchAll();
             foreach($imagine as $i){
                $imagini[$i->id_produs] = $i->denumire;
             }
            return array('produse' => $this->getProdusTable()->fetchAll(), 'categorii' => $categorii, 'imagini' =>$imagini);
         }
        
        $token = str_shuffle('0123456789zxcvbnmlkjhgfdsaqwertyuiop#&~_');
        $ip = $this->getRequest()->getServer('REMOTE_ADDR'); 
        $cookie = new SetCookie('variabilacos', $token, time() + 24*4*60*60); // now + 1 year
        $response = $this->getResponse()->getHeaders();
        $response->addHeader($cookie);
        
        
    }
    /**
     * actiune autentificare client
     * @return type
     */
    public function loginAction() {
         
        $login = new Container('utilizator');
        $username = $login->username;
       
        $this ->layout('customer/layout/layoutlogin.phtml');
        
        if(isset($username)) {
            return $this->redirect()->toRoute('customer', array('action' => 'error', 'id' => 1));
        }
        
        $form = new CustomerForm();
        $form->get('submit')->setValue('Login');
        $request = $this->getRequest();
        
        if($request->isPost()) {
            
            $customer = new Customer();
           
            $form->setInputFilter($customer->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid()){
                
                $customer->exchangeArray($form->getData());
                $this->getCustomerTable()->loginCustomer($customer);
                return $this->redirect()->toRoute('customer', array('action' => 'index'));
            }
            
        }
        
        return array('form' => $form);
    }
    /**
     * actiune iesire cont client
     * @return type
     */
    public function logoutAction() {
        
        $this ->layout('customer/layout/layoutlogout.phtml');
        $request = $this->getRequest();
         if ($request->isPost()) {
             $logout = $request->getPost('logout', 'Nu');

             if ($logout == 'Da') {  
                  
                 $login = new Container('utilizator');
                 $login->getManager()->getStorage()->clear('utilizator');
                 
                 return $this->redirect()->toRoute('customer', array('action' => 'login'));
             } else {
                 return $this->redirect()->toRoute('customer', array('action' => 'index')); }
         }
    }
    /**
     * inregistrare client nou
     * @return type
     */
    public function  registerAction(){
        
        $this ->layout('customer/layout/layout.phtml');
        $form = new RegisterForm();
        $form->get('submit') ->setValue('Inregistrare');
        
        $request = $this->getRequest();
        if($request->isPost()){
            
            
            $customer = new Customer();
            $form->setInputFilter($customer->getInputFilterRegister());
            $form->setData($request->getPost());
            if($form->isValid()){
                
                $values = $form->getData();
                $parola = $values['parola'];
                $confirmaparola = $values['confirmaparola'];
                if($parola == $confirmaparola) {
                    
                    $customer->exchangeArray($form->getData());
                    $this->getCustomerTable()->registerCustomer($customer);
                    return $this->redirect()->toRoute('customer', array('action' => 'customer'));
                    
                } else {echo "Parolele nu corespund";}              
            }
        }
        return array('form' => $form);
    }
    /**
    * editare informatii client 
    * @return type
    */
    public function editAction(){
        
        $this ->layout('customer/layout/layout.phtml');
        
        $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'register'
             ));
         }

         try {
             $customer = $this->getCustomerTable()->getCustomer($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'login'
             ));
         }

         $form  = new RegisterForm();
         $form->bind($customer);
         $form->get('submit')->setAttribute('value', 'Edit');
         $form->get('username')->setAttribute('disabled', 'disabled');
         $form->get('email')->setAttribute('disabled', 'disabled');
         $form->get('parola')->setAttribute('disabled', 'disabled');
         $form->get('confirmaparola')->setAttribute('disabled', 'disabled');
         $request = $this->getRequest();
         
        $edit = new Container('editare');
        $edit->username = $form->get('username')->getValue();
        $edit->email = $form->get('email')->getValue();
        $edit->parola = $form->get('parola')->getValue();
        
         if ($request->isPost()) {
             $form->setInputFilter($customer->getInputFilterEdit());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getCustomerTable()->registerCustomer($customer);
    
                 return $this->redirect()->toRoute('customer', array('action' => 'customer'));
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
    }
    /**
     * afisare adrese clietni
     * @return type
     */
     public function afiseazaadresaAction(){
         
         $this ->layout('customer/layout/layout.phtml');
         $id = (int) $this->params()->fromRoute('id', 0);
         
         if (!$id) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'login'
             ));
         }

         try {
             $this->getCustomerTable()->getCustomer($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'login'
             ));
         }
    
        return array('adrese' => $this->getCustomerTable()->join($id));
       
    
     }
   /**
    * adauga adresa noua
    * @return type
    */
    public function addadresaAction() {
         
        $this ->layout('customer/layout/layout.phtml');
        $login = new Container('utilizator');
//        $username = $login->username;
        $id_customer = $login->id;
        
        if(!$id_customer){
            return $this->redirect()->toRoute('customer', array('action' => 'login'));
        }
        
        $form = new AdresaForm();
        $form->get('submit') ->setValue('Adauga adresa');
        //$form->get('id')->setAttribute('disabled', 'disabled');
        $request = $this->getRequest();
        
        if($request->isPost()){
            
            $adresa = new Adresa();
            $form->setInputFilter($adresa->getInputFilterAdd());
            $form->setData($request->getPost());
            
            if($form->isValid()){
                
                $adresa->exchangeArray($form->getData());
                $this->getAdresaTable()->adaugaAdresa($adresa);
                    return $this->redirect()->toRoute('customer', array('action' => 'afiseazaadresa', 'id' => $id_customer));       
            }
        }
        return array('form' => $form);
         
    }
    /**
     * editeaza adresa client 
     * @return type
     */
    public function editadresaAction() {
        $this ->layout('customer/layout/layout.phtml');
        
         $id = (int) $this->params()->fromRoute('id', 0);
         
         if (!$id) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'addadresa'
             ));
         }

         try {
             $adresa = $this->getAdresaTable()->getAdresa($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'login'
             ));
         }

        $login = new Container('utilizator');
        $id_customer = $login->id;
        
         $form  = new AdresaForm();
         $form->bind($adresa);
         //$form->get('id')->setAttribute('value', $id);
       
         $id = $this->params()->fromRoute('id',0);
        
         $form->get('submit')->setAttribute('value', 'Edit adresa');
         $request = $this->getRequest();
         if ($request->isPost()) {
            
             $form->setInputFilter($adresa->getInputFilter());
            
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
                 $this->getAdresaTable()->adaugaAdresa($adresa,$id);
                return $this->redirect()->toRoute('customer', array('action' => 'afiseazaadresa','id' => $id_customer ));
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
        
    }
    /**
     * afisare informatii cont personal
     * @return type
     */
    public function contAction(){
         $login = new Container('utilizator');
        $id = $login->id;
        
        $this ->layout('customer/layout/layoutcont.phtml');
        if(isset($id)){
            return array(
          'cont' => $this->getCustomerTable()->getCustomer($id),
        );
        }
             
        
    }
    /**
     * stergere adresa client
     * @return type
     */
    public function stergeadresaAction(){
        
        $this ->layout('customer/layout/layout.phtml');
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('customer');
         }
         
        $login = new Container('utilizator');
        $id_customer = $login->id;
        
        $request = $this->getRequest();
        if ($request->isPost()) {
             $del = $request->getPost('deladresa', 'Nu');

             if ($del == 'Da') {
                 $id = (int) $request->getPost('id');
                 $this->getAdresaTable()->stergeAdresa($id);
             }

            return $this->redirect()->toRoute('customer', array('action' => 'afiseazaadresa', 'id' => $id_customer));
         }

         return array(
             'id'    => $id,
             'adresa' => $this->getAdresaTable()->getAdresa($id)
         );
     }
    /**
     * returneaza eroare
     */
    public function errorAction(){
        
    }
    
    public function adaugaincosAction(){
    
     
        }

}
