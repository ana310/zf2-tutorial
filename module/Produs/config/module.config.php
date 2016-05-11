<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Produs\Controller\Produs' => 'Produs\Controller\ProdusController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'produs' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/produs[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>array(
                        'controller' => 'Produs\Controller\Produs',
                        'action' => 'index',
                    ),
                ),
            ),
        ),       
    ),
    'view_manager' => array(
        
        'template_path_stack' => array(
            'produs' => __DIR__ . '/../view',
        ),
    ),
);