<?php
namespace ShoppingCartTest;


class ModuleTest extends \PHPUnit\Framework\TestCase {

	/**
	 * @var \ShoppingCart\Module
	 */
	protected $module;

	/**
	 * @var \Zend\Mvc\MvcEvent
	 */
	protected $event;


	/**
	 * setUp()
	 */
	public function setUp() {
		$this->module = new \ShoppingCart\Module();
		$aConfiguration = \ShoppingCartTest\Bootstrap::getServiceManager()->get('Config');
		$this->event = new \Zend\Mvc\MvcEvent();
		$this->event
			->setViewModel(new \Zend\View\Model\ViewModel())
			->setApplication(\ShoppingCartTest\Bootstrap::getServiceManager()->get('Application'))
			->setRouter(\Zend\Router\Http\TreeRouteStack::factory(isset($aConfiguration['router'])?$aConfiguration['router']:array()))
			->setRouteMatch(new \Zend\Router\RouteMatch(array('controller' => 'test-module','action' => 'test-module\index-controller')));
	}


    public function testGetConfig(){
    	$this->assertTrue(is_array($this->module->getConfig()));
    }
}
