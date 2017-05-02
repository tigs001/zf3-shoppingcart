<?php
namespace ShoppingCart;

return array(
    'router' => array(
        'routes' => array(
                   
        ),
    ),
    'controller_plugins' => array (
        'factories' => array (
            'Controller\Plugin\ShoppingCart::class' => 'Factory\ShoppingCartFactory:class'
        )
    )
);
