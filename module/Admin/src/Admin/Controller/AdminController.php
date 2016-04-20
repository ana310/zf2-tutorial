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

/**
 * Description of AdminController
 *
 * @author Mee
 */
class AdminController extends AbstractActionController
{
    protected $adminTable;
    protected $albumTable;
    
    public function getAdminTable()
    {
        if(!($this->adminTable))
        {
            $sm  = $this->getServiceLocator();
            $this->adminTable = $sm->get('Admin\Model\AdminTable');
            
        }
        return $this->adminTable;
    }
    
    public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
     
    public function indexAction() {
         
        $login = new Container('utilizator');
        $username = $login->username;
        $this ->layout('admin/layout/layout.phtml');
        
        if(isset($username)) {
            return $this->redirect()->toRoute('admin', array('action' => 'error', 'id' => 1));
        }
        
        $form = new AdminForm();
        $form->get('submit')->setValue('Login');
        //$this ->layout('layout');
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
    
    public function aAction() {
        
         $login = new Container('utilizator');
        $username = $login->username;
               return new ViewModel (array (
            'admini' => $this->getAdminTable()->fetchAll(),
                   'username' =>$username,
         ));
    }
    public function afisareAction(){
         return new ViewModel (array (
            'albume' => $this->getAlbumTable()->fetchAll(),  ));
         
    }
    
    public function logoutAction() {
        
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
    
    public function errorAction(){
        
         $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 1) {
            echo "Sunteti deja autentificat.<a href=\"../logout\">Logout</a>";
        }
    }
    
}
