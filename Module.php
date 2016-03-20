<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * UI Components
 *
 * @package		[MyApplication]
 * @package		BB's Zend Framework 2 Components
 * @package		UI Components
 * @author		Björn Bartels <development@bjoernbartels.earth>
 * @link		https://gitlab.bjoernbartels.earth/groups/zf2
 * @license		http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright	copyright (c) 2016 Björn Bartels <development@bjoernbartels.earth>
 */

namespace UIComponents;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceManager;

// navigation
use Zend\View\HelperPluginManager;
use Zend\Permissions\Acl\Acl;

//use UIComponents\Model\UIComponents;

class Module implements AutoloaderProviderInterface, ServiceLocatorAwareInterface
{
	
	protected $application;
	
	protected $serviceManager;
    protected $serviceLocator;
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $oEvent)
    {
        $eventManager = $oEvent->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $this->setServiceManager($oEvent->getApplication()->getServiceManager());
        $this->setApplication( (new \Application\Module) );
        $this->getApplication()->setServiceLocator($oEvent->getApplication()->getServiceManager());
    }

    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    			),
    	);
    }

	public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'bootstrap' => function(\Zend\View\HelperPluginManager $oHelperPluginManager) {
					$this->setServiceLocator($oHelperPluginManager->getServiceLocator());

					$acl = \Admin\Module::initACL($oHelperPluginManager->getServiceLocator()); 

					/** @var \UIComponents\View\Helper\Bootstrap $bootstrap */
					$bootstrap = $oHelperPluginManager->get('UIComponents\View\Helper\Bootstrap');
					$bootstrap->setAcl($acl);
					$bootstrap->setServiceLocator($oHelperPluginManager->getServiceLocator());
					
					$oAuth = $oHelperPluginManager->getServiceLocator()->get('zfcuser_auth_service');
					if ( $oAuth->hasIdentity() ) {
						$oUser = $oAuth->getIdentity();
						$bootstrap->setRole( $oUser->getAclrole() );
					} else {
						$bootstrap->setRole('public');
					}
					
					return $bootstrap;
				},
				'components' => function(\Zend\View\HelperPluginManager $oHelperPluginManager) {
					$this->setServiceLocator($oHelperPluginManager->getServiceLocator());
					
					$acl = \Admin\Module::initACL($oHelperPluginManager->getServiceLocator()); 
					
					/** @var \UIComponents\View\Helper\Components $components */
					$components = $oHelperPluginManager->get('UIComponents\View\Helper\Components');
					$components->setAcl($acl);
					$components->setServiceLocator($oHelperPluginManager->getServiceLocator());
					
					$oAuth = $oHelperPluginManager->getServiceLocator()->get('zfcuser_auth_service');
					if ( $oAuth->hasIdentity() ) {
						$oUser = $oAuth->getIdentity();
						$components->setRole( $oUser->getAclrole() );
					} else {
						$components->setRole('public');
					}
					
					return $components;
				},
				'toolbar' => function(HelperPluginManager $pm) {
					$this->setServiceLocator($pm->getServiceLocator());
					$acl = \Admin\Module::initACL($pm->getServiceLocator());

					/** @var \UIComponents\View\Helper\Components\Toolbar $navigation */
					$navigation = $pm->get('UIComponents\View\Helper\Components\Toolbar');
					$navigation->setAcl($acl);
					$navigation->setServiceLocator($oHelperPluginManager->getServiceLocator());
					
					$oAuth = $pm->getServiceLocator()->get('zfcuser_auth_service');
					if ( $oAuth->hasIdentity() ) {
						$oUser = $oAuth->getIdentity();
						$navigation->setRole( $oUser->getAclrole() );
					} else {
						$navigation->setRole('public');
					}
					
					return $navigation;
				},
			)
		);
	}

	/**
     * Retrieve application instance
     *
     * @return Application 
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set application instance
     *
     * @param $application
     * @return User
     */
    public function setApplication(\Application\Module $application)
    {
        $this->application = $application;
        return $this;
    }

	/**
     * Retrieve service manager instance
     *
     * @return ServiceManager 
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Set serviceManager instance
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
