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
use Produs\Model\AtributsetTable;
use Produs\Model\Atributset;
use Produs\Model\Atribut;
use Produs\Model\AtributTable;
use Produs\Model\AtributAtributsetTable;
use Produs\Model\AtributAtributset;
use Produs\Model\ValoareInt;
use Produs\Model\ValoareIntTable;
use Produs\Model\ValoareVarchar;
use Produs\Model\ValoareVarcharTable;
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
                'Produs\Model\AtributsetTable' => function($sm) {
                    $tableGateway = $sm->get('AtributsetTableGateway');
                    $table = new AtributsetTable($tableGateway);
                    return $table;
                },
                'AtributsetTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Atributset());
                    return new TableGateway('atributset', $dbAdapter, null, $resultSetPrototype);
                },
                'Produs\Model\AtributTable' => function($sm) {
                    $tableGateway = $sm->get('AtributTableGateway');
                    $table = new AtributTable($tableGateway);
                    return $table;
                },
                'AtributTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Atribut());
                    return new TableGateway('atribut', $dbAdapter, null, $resultSetPrototype);
                },  
                'Produs\Model\AtributAtributsetTable' => function($sm) {
                    $tableGateway = $sm->get('AtributAtributsetTableGateway');
                    $table = new AtributAtributsetTable($tableGateway);
                    return $table;
                },
                'AtributAtributsetTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new AtributAtributset());
                    return new TableGateway('atribut_atributset', $dbAdapter, null, $resultSetPrototype);
                },
                'Produs\Model\ValoareIntTable' => function($sm) {
                    $tableGateway = $sm->get('ValoareIntTableGateway');
                    $table = new ValoareIntTable($tableGateway);
                    return $table;
                },
                'ValoareIntTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ValoareInt());
                    return new TableGateway('valoriatributeint', $dbAdapter, null, $resultSetPrototype);
                },
                'Produs\Model\ValoareVarcharTable' => function($sm) {
                    $tableGateway = $sm->get('ValoareVarcharTableGateway');
                    $table = new ValoareVarcharTable($tableGateway);
                    return $table;
                },
                'ValoareVarcharTableGateway' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ValoareVarchar());
                    return new TableGateway('valoriatributetext', $dbAdapter, null, $resultSetPrototype);
                },
             ),
        );
    }
}
