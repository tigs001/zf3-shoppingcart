<?php
namespace ShoppingCart;


return array(
    'router' => array(
        'routes' => array(

        ),
    ),
    'controller_plugins' => array (
        'factories' => array (
            Controller\Plugin\ShoppingCart::class => Factory\ShoppingCartFactory::class,
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
