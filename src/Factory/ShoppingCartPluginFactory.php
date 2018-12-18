<?php
namespace ShoppingCart\Factory;

use Interop\Container\ContainerInterface;


class ShoppingCartPluginFactory
{
	/**
	 * __invoke() - Called to invoke the factory.  We actuallt return the service now instead.
	 *
	 * @param \Interop\Container\ContainerInterface $container
	 *
	 *
	 * @return \ShoppingCart\Service\ShoppingCart
	 */
	public function __invoke(ContainerInterface $container)
    {
    	/*
    	 *
    	 */

        $cartservice  				= $container->get('ShoppingCart');

        return $cartservice;
    }
}

