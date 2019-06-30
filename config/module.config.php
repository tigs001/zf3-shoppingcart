<?php
namespace ShoppingCart;


return array(
    'router' => array(
        'routes' => array(
            'shoppingcart' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/shoppingcart',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ShoppingCart\Controller',
                    	'controller' 	=> 'ShoppingCartController',
                        'action'     	=> 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'controlleraction' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            	'controller' => 'ShoppingCartController',
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),
    'controllers' => array(
        'factories' => array(
        	/*
        	 * We need to use factories now, instead of invokables.  6/10/18
        	 *
        	 * We should be able to use class names on the left, but due to
        	 * historical naming conventions, we do not refer elsewhere in code
        	 * to the name "IndexController", but just "Index".
        	 *
        	 * Hence the left of these controllers must be a string, not a ::class.
        	 */
        	'ShoppingCart\Controller\ShoppingCartController' 	=> Factory\ShoppingCartControllerFactory::class,
        ),
    ),
	'controller_plugins' => array (
        'factories' => array (
            'ShoppingCart' => Factory\ShoppingCartPluginFactory::class,
        ),
	),
    'view_helpers' => array (
        'factories' => array (
            'ShoppingCart' => Factory\ShoppingCartViewHelperFactory::class,
        ),
    ),
	'service_manager' => array(
		'factories' => array(
			'ShoppingCart\Service\ShoppingCart' => Factory\ShoppingCartFactory::class,
		),
		'aliases' => array(
			'ShoppingCart' => 'ShoppingCart\Service\ShoppingCart',
		),
	),

);
