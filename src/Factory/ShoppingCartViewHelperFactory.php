<?php
namespace ShoppingCart\Factory;

use Interop\Container\ContainerInterface;


class ShoppingCartViewHelperFactory
{
	/**
	 * __invoke() - Called to invoke the factory.  We actually return the service now instead.
	 *
	 * We possibly don't need this, as it is the same code as the controller plugin.
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

