<?php
namespace UIComponentsTest\Controller;

use \ApplicationTest\Framework\ActionControllerTestCase as ApplicationActionControllerTestCase,
	UIComponents\Controller\ComponentsController,
	Zend\Http\Request,
    Zend\Http\Response,
    Zend\Http\Router,
    Zend\Mvc\MvcEvent,
    Zend\Mvc\Router\RouteMatch,
    Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter,
    Zend\View\VewModel
;

/**
 * @coversDefaultClass \UIComponents\Controller\ComponentsController
 */
class ComponentsControllerTest extends ApplicationActionControllerTestCase // UIComponentsTest\Framework\TestCase
{
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setupController()
    {
    	$serviceLocator = $this->getApplicationServiceLocator();
    	
        $this->setController(new ComponentsController( $serviceLocator ));
        $this->getController()->setServiceLocator( $serviceLocator );
        $this->setRequest(new Request());
        $this->setRouteMatch(new RouteMatch(array('controller' => '\UIComponents\Controller\Components', 'action' => 'index')));
        $this->setEvent(new MvcEvent());
        $config = $serviceLocator->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);
        $this->getEvent()->setRouter($router);
        $this->getEvent()->setRouteMatch($this->getRouteMatch());
        $this->getController()->setEvent($this->getEvent());
        $this->setResponse(new Response());
        
        $this->setZfcUserValidAuthMock();
    }

    /**
     * is the action accessable per request/response action name ?
     *
     * @covers ::indexAction
     */
    public function testIndexActionCanBeDispatched()
    {
        // redirect to whatever is set in route/navigation configuration
        $this->routeMatch->setParam('action', 'index');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf("Zend\View\VewModel", $result);
    }
    
    /**
     * is the action accessable per request/response action name ?
     *
     * @covers ::indexAction
     */
    public function testPanelsActionCanBeDispatched()
    {
        // redirect to whatever is set in route/navigation configuration
        $this->routeMatch->setParam('action', 'panels');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * is the action accessable per request/response action name ?
     *
     * @covers ::indexAction
     */
    public function testControlsActionCanBeDispatched()
    {
        // redirect to whatever is set in route/navigation configuration
        $this->routeMatch->setParam('action', 'controls');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
        /**
     * is the action accessable per request/response action name ?
     *
     * @covers ::indexAction
     */
    public function testFormsActionCanBeDispatched()
    {
        // redirect to whatever is set in route/navigation configuration
        $this->routeMatch->setParam('action', 'forms');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * is the action accessable per request/response action name ?
     *
     * @covers ::indexAction
     */
    public function testTablesActionCanBeDispatched()
    {
        // redirect to whatever is set in route/navigation configuration
        $this->routeMatch->setParam('action', 'tables');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /**
     * is the action accessable per request/response action name ?
     *
     * @covers ::indexAction
     */
    public function testWidgetsActionCanBeDispatched()
    {
        // redirect to whatever is set in route/navigation configuration
        $this->routeMatch->setParam('action', 'widgets');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
    
/**
     * 404 page
     */
    public function test404()
    {
        $this->routeMatch->setParam('action', 'not-implemented-yet');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }
    
}