<?php

namespace ShoppingCartTest\Service;


use ShoppingCartTest\Bootstrap;


class ShoppingCartTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \ShoppingCart\Service\ShoppingCart
     */
    protected $cart;


    /**
     * Three products for testing.
     *
     * When we generate a token, we use the 'id' and the 'price' fields.
     * So if we have 2 entries the same, it will not work correctly.
     * TODO:  We should probably have a test for this !
     */
    protected $threeproducts = array(
							    	array(
									    'id'      => 'XYZ',
									    'qty'     => 1,
									    'price'   => 15.15,
									    'product' => 'Book: ZF2 for beginners',
									),
								    array(
								        'id'      => 'XYZ2',
								        'qty'     => 1,
								        'price'   => 15.15,
								        'product' => 'Book: ZF2 for beginners',
								    ),
								    array(
								        'id'      => 'ZYX',
								        'qty'     => 3,
								        'price'   => 19.99,
								        'product' => 'Book: ZF2 for advanced users',
								    ),
								);




    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp()
    {
        // Empty cache and processed directories
        $sm = \ShoppingCartTest\Bootstrap::getServiceManager();
        $this->cart = $sm->get('ShoppingCart');
    }



    /**
     *
     */
	public function testInsert()
	{
		$product = array(
		    'id'      => 'XYZ',
		    'qty'     => 1,
		    'price'   => 15.15,
		    'product' => 'Book: ZF2 for beginners',
		);
		$result = $this->cart->insert($product);
		$this->assertTrue($result);
	}



	/**
	 *
	 */
	public function testInsertTwoProducts()
	{
		/*
		 *
		 */
		$products = array(
		    array(
		        'id'      => 'XYZ',
		        'qty'     => 1,
		        'price'   => 15.15,
		        'product' => 'Book: ZF2 for beginners',
		    ),
		    array(
		        'id'      => 'ZYX',
		        'qty'     => 3,
		        'price'   => 19.99,
		        'product' => 'Book: ZF2 for advanced users',
		    )
		);
		$result = $this->cart->insert($products);
		$this->assertTrue($result);
	}



	/**
	 *
	 */
	public function testTotalSum()
	{
		/*
		 * The amount should be:
		 *    1 * $15.15
		 *    1 * $15.15
		 *    3 * $19.99
		 *    ----------
		 *        $90.37
		 */
		$this->cart->destroy();
		$result = $this->cart->insert($this->threeproducts);
		$this->assertTrue($result);

		$sum = $this->cart->total_sum();
		$this->assertEquals(90.27, $sum);
	}



	/**
	 * testTotalSumWithVat() - Tests the total sum feature with VAT added.
	 *
	 * The default VAT is set to 25%.
	 */
	public function testTotalSumWithVat()
	{
		/*
		 * The amount should be:
		 *    1 * $15.15
		 *    1 * $15.15
		 *    3 * $19.99
		 *    ----------
		 *        $90.37 * 1.25
		 *
		 *     = $112.84
		 */
		$this->cart->destroy();
		$result = $this->cart->insert($this->threeproducts);
		$this->assertTrue($result);

		$sum = $this->cart->total_sum(2, true);
		$this->assertEquals(112.84, $sum);
	}



	/**
	 *
	 */
	public function testTotalItems()
	{
		/*
		 * The amount should be:
		 *    1 * $15.15
		 *    1 * $15.15
		 *    3 * $19.99
		 *    ----------
		 *    5
		 */
		$this->cart->destroy();
		$result = $this->cart->insert($this->threeproducts);
		$this->assertTrue($result);

		$numitems = $this->cart->total_items();
		$this->assertEquals(5, $numitems);
	}



	/**
	 *
	 */
	public function testGetContent()
	{
		/*
		 * This test relies on the data inserted by above tests.
		 */
		$this->cart->destroy();
		$result = $this->cart->insert($this->threeproducts);
		$this->assertTrue($result);

		$contents = $this->cart->cart();
		$this->assertIsArray($contents);

		$this->assertCount(3, $contents);
	}


	/**
	 *
	 */
	public function testRemove()
	{
		/*
		 * This test relies on the data inserted by above tests.
		 */

		$this->cart->destroy();
		$result = $this->cart->insert($this->threeproducts);
		$this->assertTrue($result);

		/*
		 * We will remove the first token
		 * from the cart.  The tokens
		 * are the array keys of the content.
		 */
		$contents = $this->cart->cart();
		$this->assertIsArray($contents);
		$this->assertCount(3, $contents);

		reset($contents);
		$token = key($contents);
		$this->assertIsString($token);

		$result = $this->cart->remove($token);
		$this->assertTrue($result);

		/*
		 * We should have removed the first entry,
		 * leaving only the second and thirt, which have a
		 * quantity of 4.
		 */
		$numitems = $this->cart->total_items();
		$this->assertEquals(4, $numitems);
	}



	/**
	 *
	 */
	public function testDestroy()
    {
		$this->cart->destroy();
		$result = $this->cart->insert($this->threeproducts);
		$this->assertTrue($result);

    	$result = $this->cart->destroy();
    	$this->assertTrue($result);
    }



	/**
	 * @expectedException \Zend\ServiceManager\Exception\ServiceNotCreatedException
	 */
	public function testUnconfiguredThowsException()
	{
		/*
		 * Forcibly remove the shopping_cart configuration
		 * from the Service Manager.  And then reinitialise
		 * our shopping cart.  An exception should be thrown.
		 *
		 * Create a new service manager for this.
		 */
        $smconfig = new \Zend\Mvc\Service\ServiceManagerConfig();
        $mergedconfig = array_merge($smconfig->toArray(), array(
         														'shared_by_default' => false,
							        						));
        $oursm = new \Zend\ServiceManager\ServiceManager($mergedconfig);


        //Load the user-defined test configuration file, if it exists;
        $aTestConfig = include is_readable(__DIR__ . '/../../TestConfig.php') ? __DIR__ . '/../../TestConfig.php' : __DIR__ . '/../../TestConfig.php.dist';
        $aZf2ModulePaths = array();
        if (isset($aTestConfig['module_listener_options']['module_paths'])) {
            foreach ($aTestConfig['module_listener_options']['module_paths'] as $sModulePath) {
                if (($sPath = Bootstrap::findParentPath($sModulePath))) {
                    $aZf2ModulePaths[] = $sPath;
                }
            }
        }

        //Use ModuleManager to load this module and it's dependencies
        $config = \Zend\Stdlib\ArrayUtils::merge(array(
                    'module_listener_options' => array(
                        'module_paths' => $aZf2ModulePaths
                    )
                        ), $aTestConfig);

        $oursm->setService('ApplicationConfig', $config);

        /*
         * Do NOT load the modules via module manager,
         * or our full configuration is loaded, which
         * we do not want to occur for this test.
         */
        // $modulemanager = $oursm->get('ModuleManager');
		// $modulemanager->loadModules();

		// Set the modified config back into the service manager.
		$oursm->setService('Configuration', $config);

        /*
		 * Manually create our factory so it is unconfigured.
		 */
        $oursm->setFactory('ShoppingCart', \ShoppingCart\Factory\ShoppingCartFactory::class);

        // Destroy any existing cart.
        $this->cart->destroy();

// 		$config = $oursm->get('Configuration'); 	/* @var $config \Zend\Config\Config */



		/*
		 * Now test the creation of the cart, using our
		 * own service manager.
		 */
		$this->cart = $oursm->get('ShoppingCart');

		$this->fail('The expected unconfigured exception was not thrown.');
	}



	/**
	 * testGetView() - Mainly for test coverage.  This functionality would not be used in reality.
	 */
	public function testGetView()
    {
		/*
		 * I expect the view to be null during this test.
		 * It would only be set when being called as a View Helper
		 */
		$view = $this->cart->getView();
		$this->assertNull($view);
    }



    /**
     * testInsertInvalidContent() - Tests that the exception is thrown when we supply an empty array.
     * It is not longer possible to pass something other than an array with PHP 7 type checking,
     * so only the empty array needs to be tested.
     *
	 * @expectedException \Exception
     */
	public function testInsertInvalidContent()
	{
		$product = array();

        $result = $this->cart->insert($product);

		$this->fail('The expected only correct values exception was not thrown.');
	}



    /**
     * testInsertInvalidContent2() - Tests that the exception is thrown when we supply an array with one
     * element as an empty array.
     *
	 * @expectedException \Exception
     */
	public function testInsertInvalidContent2()
	{
		$product = array(array());

        $result = $this->cart->insert($product);

		$this->fail('The expected only correct values exception was not thrown.');
	}



    /**
     * testIsMultidimentionPrivate() - Runs a test of isMultidimention() and passes in
     * invalid content.  This is probably unnecessary, its only for complete cover coverage.
     */
	public function testIsMultidimentionPrivate()
	{
		/*
		 * Use a reflection class to get at the private method.
		 */

		$reflection = new \ReflectionClass(get_class($this->cart));
		$method = $reflection->getMethod('isMultidimention');
		$method->setAccessible(true);

		$product = 'Something';

        $result = $method->invokeArgs($this->cart, array($product));

		$this->assertFalse($result);
	}





}
