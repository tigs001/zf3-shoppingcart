<?php

namespace ShoppingCartTest\Controller;

use ShoppingCart\Controller\ShoppingCartController;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;


class ShoppingCartControllerTest extends AbstractHttpControllerTestCase
{



    /**
     *
     */
    public function setUp()
    {
        $this->setApplicationConfig(\ShoppingCartTest\Bootstrap::getConfig());
        parent::setUp();
    }



    public function testLoadPlugin()
    {
        $this->dispatch('/testloadplugin');
        $this->assertResponseStatusCode(200,$this->getResponse()->getContent());
        $this->assertModuleName('shoppingcart');
        $this->assertControllerName('ShoppingCart\Controller\ShoppingCartController');
        $this->assertControllerClass('ShoppingCartController');
        $this->assertMatchedRouteName('testloadplugin');
        $this->assertContains("<p>Number of items in shopping cart: 0</p>\n", $this->getResponse()->getContent());
    }



    public function testViewHelper()
    {
        $this->dispatch('/testviewhelper');
        $this->assertResponseStatusCode(200,$this->getResponse()->getContent());
        $this->assertModuleName('shoppingcart');
        $this->assertControllerName('ShoppingCart\Controller\ShoppingCartController');
        $this->assertControllerClass('ShoppingCartController');
        $this->assertMatchedRouteName('testviewhelper');
        $this->assertContains("<p>Total sum of shopping cart: 0</p>\n", $this->getResponse()->getContent());
    }




}

