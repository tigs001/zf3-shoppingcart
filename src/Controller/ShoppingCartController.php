<?php

namespace ShoppingCart\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Json\Json;



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



	/**
	 * indexAction() - A default non action.  Just returns a "result" => "OK".
	 *
	 * @return JsonModel - With 'result' as human readable and 'resultcode' integer.  0 = success.
	 */
	public function indexAction()
	{
		/*
		 *
		 */

		return new JsonModel(array(
							'result' 		=> 'OK',
							'resultcode' 	=> 0,
						));
	}



	/**
	 * contentsAction() - Returns the shopping cart contents
	 *
	 * @return JsonModel
	 */
	public function contentsAction()
	{
		/*
		 *
		 */

		$cart = $this->ShoppingCart(); 	/* @var $cart \ShoppingCart\Service\ShoppingCart */

		$cartdata = array();
		foreach ($cart->cart() as $onekey => $oneentity)
		{
			/* @var $oneentity \ShoppingCart\Entity\ShoppingCartEntity */

			$onearray = array();

			$reflection = new \ReflectionClass($oneentity);
			foreach ($reflection->getProperties() as $prop)
			{
				/*
				 * The existing ShoppingCartEntity uses the strategy where
				 * an underscore is converted to a name without underscores,
				 * and the following letter is capitalised.
				 */
				// $getmethod = 'get' . ucfirst($prop->getName());
				$getmethod = 'get' . implode('', array_map('ucfirst', explode('_', $prop->getName())));
				$onearray[$prop->getName()] = $oneentity->$getmethod();
			}

			$cartdata[$onekey] = $onearray;
		}


		$contents = new JsonModel(array(
								'contents' 		=> $cartdata,
								'total_sum' 	=> $cart->total_sum(),
								'total_items' 	=> $cart->total_items(),
							));

		return $contents;
	}



	/**
	 * addAction() - Adds itesm to the shopping cart
	 *
	 * @return JsonModel With 'result' as human readable and 'resultcode' integer.  0 = success.
	 */
	public function addAction()
	{
		/*
		 *
		 */

		$cart = $this->ShoppingCart(); 	/* @var $cart \ShoppingCart\Service\ShoppingCart */

		/*
		 * Get the json payload.
		 */
		$request = $this->getRequest();
		if ($request->isXmlHttpRequest())
		{
			$payload = $request->getContent();
			$jdata = json_decode($payload, true);
		}


		/*
		 * Now add the JSON data into our shopping cart.
		 */
		$cart->insert($jdata);

		/*
		 * Return success.
		 */
		$contents = new JsonModel(array(
								'result' 		=> 'OK',
								'resultcode' 	=> 0,
							));

		return $contents;
	}

}


