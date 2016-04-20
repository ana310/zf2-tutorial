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


class CustomerController  extends AbstractActionController{
    
    protected $customerTable;
    protected $adresaTable;
    protected $grupTable;
    
    
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
    }
    /**
     * actiune autentificare client
     * @return type
     */
    public function loginAction() {
         
        $login = new Container('utilizator');
        $username = $login->username;
       
        $this ->layout('customer/layout/layout.phtml');
        
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
         
         $id = (int) $this->params()->fromRoute('id', 0);
         
         if (!$id) {
             return $this->redirect()->toRoute('customer', array(
                 'action' => 'customer'
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

         $form  = new AdresaForm();
         $form->bind($adresa);
         $form->get('submit')->setAttribute('value', 'Edit adresa');
         $request = $this->getRequest();
          
         if ($request->isPost()) {
            
             $form->setInputFilter($adresa->getInputFilter());
             $form->setData($request->getPost());
             
             
             if ($form->isValid()) {
                 
                $this->getAdresaTable()->adaugaAdresa($adresa);
                 return $this->redirect()->toRoute('customer', array('action' => 'afiseazaadresa'));
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
        $this ->layout('customer/layout/layout.phtml');
        return array(
          'cont' => $this->getCustomerTable()->getCustomer($id),
        );
    }
    /**
     * stergere adresa client
     * @return type
     */
    public function stergeadresaAction(){
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
        
         $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 1) {
            echo "Sunteti deja autentificat.<a href=\"../logout\">Logout</a>";
        } elseif($id == 2) {
             echo "S-a produs o eroare, utilizatorul cu acest id nu exista.";
        }
    }
    
}
