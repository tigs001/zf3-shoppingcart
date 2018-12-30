<?php

namespace ShoppingCartTest\Hydrator;


use ShoppingCartTest\Bootstrap;
use ShoppingCart\Hydrator\ShoppingCartHydrator;
use ShoppingCart\Entity\ShoppingCartEntity;



class ShoppingCartHydratorTest extends \PHPUnit\Framework\TestCase
{

	/**
	 * @var \ShoppingCart\Hydrator\ShoppingCartHydrator
	 */
	protected $hydrator;



    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp()
    {
    	$this->hydrator = new ShoppingCartHydrator();
    }



    /**
     *
     */
	public function testExtract()
	{
		$entity = new ShoppingCartEntity();
		$entity->setId(12);
		$entity->setProduct('productname');
		$entity->setPrice(23.45);
		$entity->setQty(6.7);
		$entity->setProductProperties(array('prop1' => 'p1', 'prop2' => 'p2'));

		$data = $this->hydrator->extract($entity);

		$this->assertIsArray($data);

		$this->assertArrayHasKey('id', $data);
		$this->assertEquals(12, $data['id']);

		$this->assertArrayHasKey('product', $data);
		$this->assertEquals('productname', $data['product']);

		$this->assertArrayHasKey('price', $data);
		$this->assertEquals(23.45, $data['price']);

		$this->assertArrayHasKey('qty', $data);
		$this->assertEquals(6.7, $data['qty']);

		$this->assertArrayHasKey('product_properties', $data);
		$this->assertIsArray($data['product_properties']);
	}



    /**
     * @expectedException \Exception
     */
	public function testExtractInvalidInput()
	{
		$entity = new \stdClass();

		$data = $this->hydrator->extract($entity);

		$this->fail('The expected $object must implement ShoppingCart\Entity\ShoppingCartEntityInterface exception was not thrown.');
	}



    /**
     * @expectedException \Exception
     */
	public function testHydrateInvalidInput()
	{
		$entity = new \stdClass();
		$data = array();

		$this->hydrator->hydrate($data, $entity);

		$this->fail('The expected $object must implement ShoppingCart\Entity\ShoppingCartEntityInterface exception was not thrown.');
	}




}
