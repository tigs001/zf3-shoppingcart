<?php
namespace ShoppingCart\Factory;

use Interop\Container\ContainerInterface;
use ShoppingCart\Controller\ShoppingCartController;



class ShoppingCartControllerFactory
{
	/**
	 * __invoke() - Called to invoke the factory.
	 *
	 * @param \Interop\Container\ContainerInterface $container
	 *
	 *
	 * @return \ShoppingCart\Controller\ShoppingCartController
	 */
	public function __invoke(ContainerInterface $container)
    {
    	/*
    	 *
    	 */

        $controller  				= new ShoppingCartController();

        return $controller;
    }
}

