<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Controller;

use Zend\Session\Container;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\AdminForm;
use Admin\Model\Admin;
use Customer\Form\RegisterForm;
/**
 * Description of AdminController
 *
 * @author Mee
 */
class AdminController extends AbstractActionController
{
    protected $adminTable;
    protected $albumTable;
    protected $customerTable;
    protected $adresaTable;
    /**
     * tabela administartor
     * @return type
     */
    public function getAdminTable() {
        if(!($this->adminTable))
        {
            $sm  = $this->getServiceLocator();
            $this->adminTable = $sm->get('Admin\Model\AdminTable');
            
        }
        return $this->adminTable;
    }
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
     * tabela album
     * @return type
     */
    public function getAlbumTable(){
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
      /**
     * tabela adresa
     * @return type
     */
    public function getAdresaTable(){
         if (!$this->adresaTable) {
             $sm = $this->getServiceLocator();
             $this->adresaTable = $sm->get('Customer\Model\AdresaTable');
         }
         return $this->adresaTable;
     }
     /**
      * autentificare administrator
      * @return type
      */
    public function indexAction() {
         
        $login = new Container('utilizator');
        $username = $login->username;
        $this ->layout('admin/layout/layoutlogin.phtml');
        
        if(isset($username)) {
            return $this->redirect()->toRoute('admin', array('action' => 'error', 'id' => 1));
        }
        
        $form = new AdminForm();
        $form->get('submit')->setValue('Login');
        $request = $this->getRequest();
         
         if ($request->isPost()) {
             
             $admin = new Admin();
             $form->setInputFilter($admin->getInputFilter());
             $form->setData($request->getPost());


             if ($form->isValid()) {
                 $admin->exchangeArray($form->getData());
                 $this->getAdminTable()->loginAdmin($admin);
                 return $this->redirect()->toRoute('admin', array('action' => 'a'));
                 
             }
         }

        return array('form' => $form);
    }
    /**
     * afisare admin
     * @return ViewModel
     */
    public function aAction() {
        
        $this ->layout('admin/layout/layoutafisare.phtml');
        $login = new Container('utilizator');
        $username = $login->username;
               return new ViewModel (array (
            'admini' => $this->getAdminTable()->fetchAll(),
                   'username' =>$username,
         ));
    }
    /**
     * afisare albume
     * @return ViewModel
     */
    public function afisareAction(){
         return new ViewModel (array (
            'albume' => $this->getAlbumTable()->fetchAll(),  ));
         
    }
    /**
     * delogare administrator
     * @return type
     */
    public function logoutAction() {
        
        $this ->layout('admin/layout/layoutlogout.phtml');
        $request = $this->getRequest();
         if ($request->isPost()) {
             $logout = $request->getPost('logout', 'Nu');

             if ($logout == 'Da') {  
                  
                 $login = new Container('utilizator');
                 $login->getManager()->getStorage()->clear('utilizator');
                 
                 return $this->redirect()->toRoute('admin', array('action' => 'index'));
             } else {
                 return $this->redirect()->toRoute('admin', array('action' => 'a')); }
         }
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
    /**
     * actiune afisare clienti
     * @return type
     */
    public function customerAction() {
        $this ->layout('admin/layout/layoutcustomer.phtml');
        return array (
            'clienti' => $this->getCustomerTable()->fetchAll(),);
    }
    /**
     * sterge client
     * @param type $param
     */
    public function stergecustomerAction() {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('login');
         }
         
         $this->getCustomerTable()->stergeCustomer($id);
         
         return $this->redirect()->toRoute('admin', array('action' => 'customer'));
         } 
    /**
     * afisare adrese clietni
     * @return type
     */
     public function afiseazaadresaAction(){
         
         $this ->layout('admin/layout/layoutadrese.phtml');
         $id = (int) $this->params()->fromRoute('id', 0);
         
         $idutilizator = new Container('idu');
         $idutilizator->id = $id;
         if (!$id) {
             return $this->redirect()->toRoute('admin', array(
                 'action' => 'error', 'id' => 2,
             ));
         }
         
         try {
             $this->getCustomerTable()->getCustomer($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('admin', array(
                 'action' => 'login'
             ));
         }
    
        return array('adrese' => $this->getCustomerTable()->join($id));    
    
     }
     /**
    * editare informatii client 
    * @return type
    */
    public function editAction(){
        
        $this ->layout('admin/layout/layoutadrese.phtml');
        
        $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('admin', array(
                 'action' => 'error', 'id' => 2,
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
    
                 return $this->redirect()->toRoute('admin', array('action' => 'customer'));
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
    }
    /**
     * sterge adresa customer
     * @return type
     */
     public function stergeadresaAction(){
         $this ->layout('admin/layout/layoutadrese.phtml');
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('admin');
         }
         $idutilizator = new Container('idu');
         
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('deladresa', 'Nu');

             if ($del == 'Da') {
                 $id = (int) $request->getPost('id');
                 $this->getAdresaTable()->stergeAdresa($id);
             }

            return $this->redirect()->toRoute('admin', array('action' => 'afiseazaadresa','id' => $idutilizator->id));
         }

         return array(
             'id'    => $id,
             'adresa' => $this->getAdresaTable()->getAdresa($id)
         );
     }
}
