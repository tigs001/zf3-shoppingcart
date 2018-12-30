<?php
namespace ShoppingCart;


return array(
    'router' => array(
        'routes' => array(

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
