<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Produs;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Produs\Model\Produs;
use Produs\Model\ProdusTable;
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
                'Produs\Model\ProdusTable' => function($sm) {
                    $tableGateway = $sm->get('ProdusTableGateway');
                    $table = new ProdusTable($tableGateway);
                    return $table;
                },
                'ProdusTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Produs());
                    return new TableGateway('produs', $dbAdapter, null, $resultSetPrototype);
                    
                },
             ),
        );
    }
}
