<?php

/*
 * This is the application configuration for testing.
 * Include items here that do not need to be in the
 * module configuration when it is deployed as part
 * of another application.
 */
return array(
    'router' => array(
    	'routes' => array(
            'testloadplugin' => array(
                'type' => 'Zend\Router\Http\Literal',
                'options' => array(
                    'route' => '/testloadplugin',
                    'defaults' => array('controller' => 'ShoppingCart\Controller\ShoppingCartController', 'action' => 'testloadplugin')
                )
            ),
            'testviewhelper' => array(
                'type' => 'Zend\Router\Http\Literal',
                'options' => array(
                    'route' => '/testviewhelper',
                    'defaults' => array('controller' => 'ShoppingCart\Controller\ShoppingCartController', 'action' => 'testviewhelper')
                )
            ),
        )
    ),
    'controllers' => array(
    	'factories' => array(
			'ShoppingCart\Controller\ShoppingCartController' => ShoppingCart\Factory\ShoppingCartControllerFactory::class,
    	),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'         						=> __DIR__ . '/view/layout/layout.phtml',
        	'error/404'             						=> __DIR__ . '/view/error/404.phtml',
            'error/index'           						=> __DIR__ . '/view/error/index.phtml',
        	'shopping-cart/shopping-cart/testloadplugin' 	=> __DIR__ . '/view/shopping-cart/testloadplugin.phtml',
        	'shopping-cart/shopping-cart/testviewhelper' 	=> __DIR__ . '/view/shopping-cart/testviewhelper.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
