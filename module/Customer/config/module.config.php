<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Customer\Controller\Customer' => 'Customer\Controller\CustomerController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'customer' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/customer[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' =>array(
                        'controller' => 'Customer\Controller\Customer',
                        'action' => 'index',
                    ),
                ),
            ),
        ),       
    ),
    'view_manager' => array(
        
        'template_path_stack' => array(
            'customer' => __DIR__ . '/../view',
        ),
    ),
);