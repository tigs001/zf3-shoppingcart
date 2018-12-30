<?php

namespace ShoppingCart\Controller;

use Zend\View\Model\ViewModel;


/**
 * ShoppingCartTestController - A controller that is mainly a dummy controller
 * for testing our controller plugin and view helper.
 */
class ShoppingCartController extends \Zend\Mvc\Controller\AbstractActionController
{

	/**
	 * loadPlugin() - Simply loads the controller plugin.
	 *
	 * @return ViewModel - With the variable "cart" as the shopping cart.
	 */
	public function testloadpluginAction()
	{

		$cart = $this->ShoppingCart();

        return new ViewModel(array(
						            'cart' => $cart,
						        ));
	}



	/**
	 * testviewhelperAction() - Performs a simple output of the number of items in the cart to ensure
	 * we can use it as a view helper successfully.
	 *
	 * @return ViewModel
	 */
	public function testviewhelperAction()
	{
		/*
		 * There is nothing to do here.
		 * The call to the view helper is inside the view script (.phtml) file.
		 */

		return new ViewModel(array());
	}
}


