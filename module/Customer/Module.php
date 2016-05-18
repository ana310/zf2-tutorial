<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Customer;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Customer\Model\Customer;
use Customer\Model\CustomerTable;
use Customer\Model\Adresa;
use Customer\Model\AdresaTable;
use Customer\Model\Grup;
use Customer\Model\GrupTable;
use Customer\Model\Cos;
use Customer\Model\CosTable;
use Customer\Model\ProdusCos;
use Customer\Model\ProdusCosTable;
use Customer\Model\Comanda;
use Customer\Model\ComandaTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
/**
 * Description of Module
 *
 * @author Mee
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface{
    
    public function getAutoloaderConfig() 
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__.'/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
   
    }

    public function getConfig() {
            return include __DIR__ . '/config/module.config.php';
    }

    public function  getServiceConfig()
    {
        return array(
            'factories' => array(
                'Customer\Model\CustomerTable' => function($sm) {
                    $tableGateway = $sm->get('CustomerTableGateway');
                    $table = new CustomerTable($tableGateway);
                    return $table;
                },
                'CustomerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Customer());
                    return new TableGateway('customer', $dbAdapter, null, $resultSetPrototype);
                    
                },
                'Customer\Model\AdresaTable' => function($sm) {
                    $tableGateway = $sm->get('AdresaTableGateway');
                    $table = new AdresaTable($tableGateway);
                    return $table;
                },
                'AdresaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Adresa());
                    return new TableGateway('adresa', $dbAdapter, null, $resultSetPrototype);
                    
                },
                'Customer\Model\GrupTable' => function($sm) {
                    $tableGateway = $sm->get('GrupTableGateway');
                    $table = new GrupTable($tableGateway);
                    return $table;
                },
                'GrupTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Grup());
                    return new TableGateway('grup', $dbAdapter, null, $resultSetPrototype);
                    
                },
                'Customer\Model\CosTable' => function($sm) {
                    $tableGateway = $sm->get('CosTableGateway');
                    
                    $table = new CosTable($tableGateway);
                    return $table;
                },
                'CosTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Cos());
                    return new TableGateway('cos', $dbAdapter, null, $resultSetPrototype);
                    
                },
                'Customer\Model\ProdusCosTable' => function($sm) {
                    $tableGateway = $sm->get('ProdusCosTableGateway');
                    $table = new ProdusCosTable($tableGateway);
                    return $table;
                },
                'ProdusCosTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProdusCos());
                    return new TableGateway('produscos', $dbAdapter, null, $resultSetPrototype);
                    
                },
                'Customer\Model\ComandaTable' => function($sm) {
                    $tableGateway = $sm->get('ComandaTableGateway');
                    $table = new ComandaTable($tableGateway);
                    return $table;
                },
                'ComandaTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Comanda());
                    return new TableGateway('comanda', $dbAdapter, null, $resultSetPrototype);
                    
                },
            ),
        );
    }
}
