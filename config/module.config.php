<?php

return array(
    'router' => array(
        'routes' => array(
                   
        ),
    ),
    'controller_plugins' => array (
        'factories' => array (
            'ShoppingCart\Controller\Plugin\ShoppingCart::class' => 'ShoppingCart\Factory\ShoppingCartFactory:class'
        )
    )
);
