<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * TwitterBootstrap API
 *
 * @package		[MyApplication]
 * @package		BB's Zend Framework 2 Components
 * @package		TwitterBootstrap API
 * @author		Björn Bartels <development@bjoernbartels.earth>
 * @link		https://gitlab.bjoernbartels.earth/groups/zf2
 * @license		http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright	copyright (c) 2016 Björn Bartels <development@bjoernbartels.earth>
 */

namespace UIComponents\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Exception;
use Zend\View\Renderer\RendererInterface as Renderer;

/**
 * Proxy helper for retrieving navigational helpers and forwarding calls
 */
class Components extends Components\AbstractHelper
{
	/**
	 * View helper namespace
	 *
	 * @var string
	 */
	const NS = 'UIComponents\View\Helper\Components';

	/**
	 * Default proxy to use in {@link render()}
	 *
	 * @var string
	 */
	protected $defaultProxy = 'void';

	/**
	 * Indicates whether or not a given helper has been injected
	 *
	 * @var array
	 */
	protected $injected = [];

	/**
	 * Whether ACL should be injected when proxying
	 *
	 * @var bool
	 */
	protected $injectAcl = true;

	/**
	 * Whether container should be injected when proxying
	 *
	 * @var bool
	 */
	protected $injectContainer = true;

	/**
	 * Whether translator should be injected when proxying
	 *
	 * @var bool
	 */
	protected $injectTranslator = true;

	/**
	 * @var Navigation\PluginManager
	 */
	protected $plugins;

	/**
	 * AbstractContainer to operate on by default
	 *
	 * @var Navigation\AbstractContainer
	 */
	protected $container;

	/**
	 * Helper entry point
	 *
	 * @param  string|AbstractContainer $container container to operate on
	 * @return Components
	 */
	public function __invoke($options = array())
	{
		if (isset($options['container']) && null !== $options['container']) {
			$this->setContainer($options['container']);
		}

		return ($this);
	}

	/**
	 * Magic overload: Proxy to other navigation helpers or the container
	 *
	 * Examples of usage from a view script or layout:
	 * <code>
	 *   echo $this->Components()->Widget(...);
	 * </code>
	 *
	 * @param  string $method			 helper name or method name in container
	 * @param  array  $arguments		  [optional] arguments to pass
	 * @throws \Zend\View\Exception\ExceptionInterface		if proxying to a helper, and the
	 *									helper is not an instance of the
	 *									interface specified in
	 *									{@link findHelper()}
	 * @throws \Zend\View\Exception\ExceptionInterface  if method does not exist in container
	 * @return mixed					  returns what the proxied call returns
	 */
	public function __call($method, array $arguments = [])
	{
		// check if call should proxy to another helper
		$helper = $this->findHelper($method, false);
		if ($helper) {
			//if ($helper instanceof ServiceLocatorAwareInterface && $this->getServiceLocator()) {
			if (method_exists($helper, "setServiceLocator") && $this->getServiceLocator()) {
				$helper->setServiceLocator($this->getServiceLocator());
			}
			return call_user_func_array($helper, $arguments);
		}

		// default behaviour: proxy call to container
		return parent::__call($method, $arguments);
	}

	/**
	 * Sets navigation container the helper operates on by default
	 *
	 * Implements {@link HelperInterface::setContainer()}.
	 *
	 * @param  string|Navigation\AbstractContainer $container Default is null, meaning container will be reset.
	 * @return AbstractHelper
	 */
	public function setContainer($container = null)
	{
		$this->parseContainer($container);
		$this->container = $container;

		return $this;
	}

	/**
	 * Returns the navigation container helper operates on by default
	 *
	 * Implements {@link HelperInterface::getContainer()}.
	 *
	 * If no container is set, a new container will be instantiated and
	 * stored in the helper.
	 *
	 * @return Navigation\AbstractContainer	navigation container
	 */
	public function getContainer()
	{
		if (null === $this->container) {
			$this->container = new \UIComponents\Navigation\Navigation();
		}

		return $this->container;
	}

	/**
	 * Renders helper
	 *
	 * @param  AbstractContainer $container
	 * @return string
	 * @throws Exception\RuntimeException
	 */
	public function render($container = null)
	{
		return '';
	}

	/**
	 * Returns the helper matching $proxy
	 *
	 * The helper must implement the interface
	 * {@link UIComponents\View\Helper\Components\HelperInterface}.
	 *
	 * @param string $proxy  helper name
	 * @param bool   $strict [optional] whether exceptions should be
	 *								  thrown if something goes
	 *								  wrong. Default is true.
	 * @throws Exception\RuntimeException if $strict is true and helper cannot be found
	 * @return \UIComponents\View\Helper\Components\HelperInterface  helper instance
	 */
	public function findHelper($proxy, $strict = true)
	{
		$plugins = $this->getPluginManager();
		if (!$plugins->has($proxy)) {
			if ($strict) {
				throw new Exception\RuntimeException(sprintf(
					'Failed to find plugin for %s',
					$proxy
				));
			}
			return false;
		}

		$helper	= $plugins->get($proxy);

		if ($helper && ($helper instanceof \Zend\View\Helper\Navigation\Menu)) {
			
			$container = $this->getContainer();
			$hash	  = spl_object_hash($container) . spl_object_hash($helper);
			if (!isset($this->injected[$hash])) {
				$helper->setContainer();
				$this->inject($helper);
				$this->injected[$hash] = true;
			} else {
				if ($this->getInjectContainer()) {
					$helper->setContainer($container);
				}
			}
			
		}
		
		return $helper;
	}

	/**
	 * Injects container, ACL, and translator to the given $helper if this
	 * helper is configured to do so
	 *
	 * @param  \Zend\View\Helper\AbstractHelper $helper helper instance
	 * @return void
	 */
	protected function inject(\Zend\View\Helper\AbstractHelper $helper)
	{
		if ($this->getInjectContainer() && !$helper->hasContainer()) {
			$helper->setContainer($this->getContainer());
		}

		if ($this->getInjectAcl()) {
			if (!$helper->hasAcl()) {
				$helper->setAcl($this->getAcl());
			}
			if (!$helper->hasRole()) {
				$helper->setRole($this->getRole());
			}
		}

		if ($this->getInjectTranslator() && !$helper->hasTranslator()) {
			$helper->setTranslator(
				$this->getTranslator(),
				$this->getTranslatorTextDomain()
			);
		}
	}

	/**
	 * Sets the default proxy to use in {@link render()}
	 *
	 * @param  string $proxy default proxy
	 * @return Bootstrap
	 */
	public function setDefaultProxy($proxy)
	{
		$this->defaultProxy = (string) $proxy;
		return $this;
	}

	/**
	 * Returns the default proxy to use in {@link render()}
	 *
	 * @return string
	 */
	public function getDefaultProxy()
	{
		return $this->defaultProxy;
	}

	/**
	 * Sets whether container should be injected when proxying
	 *
	 * @param  bool $injectContainer
	 * @return Bootstrap
	 */
	public function setInjectContainer($injectContainer = true)
	{
		$this->injectContainer = (bool) $injectContainer;
		return $this;
	}

	/**
	 * Returns whether container should be injected when proxying
	 *
	 * @return bool
	 */
	public function getInjectContainer()
	{
		return $this->injectContainer;
	}

	/**
	 * Sets whether ACL should be injected when proxying
	 *
	 * @param  bool $injectAcl
	 * @return NavigBootstrapation
	 */
	public function setInjectAcl($injectAcl = true)
	{
		$this->injectAcl = (bool) $injectAcl;
		return $this;
	}

	/**
	 * Returns whether ACL should be injected when proxying
	 *
	 * @return bool
	 */
	public function getInjectAcl()
	{
		return $this->injectAcl;
	}

	/**
	 * Sets whether translator should be injected when proxying
	 *
	 * @param  bool $injectTranslator
	 * @return Bootstrap
	 */
	public function setInjectTranslator($injectTranslator = true)
	{
		$this->injectTranslator = (bool) $injectTranslator;
		return $this;
	}

	/**
	 * Returns whether translator should be injected when proxying
	 *
	 * @return bool
	 */
	public function getInjectTranslator()
	{
		return $this->injectTranslator;
	}

	/**
	 * Set manager for retrieving navigation helpers
	 *
	 * @param  Components\PluginManager $plugins
	 * @return Components
	 */
	public function setPluginManager(Components\PluginManager $plugins)
	{
		$renderer = $this->getView();
		if ($renderer) {
			$plugins->setRenderer($renderer);
		}
		$this->plugins = $plugins;

		return $this;
	}

	/**
	 * Retrieve plugin loader for navigation helpers
	 *
	 * Lazy-loads an instance of Navigation\HelperLoader if none currently
	 * registered.
	 *
	 * @return Components\PluginManager
	 */
	public function getPluginManager()
	{
		if (null === $this->plugins) {
			$this->setPluginManager(new Components\PluginManager());
		}

		return $this->plugins;
	}

	/**
	 * Set the View object
	 *
	 * @param  Renderer $view
	 * @return self
	 */
	public function setView(Renderer $view)
	{
		parent::setView($view);
		if ($view && $this->plugins) {
			$this->plugins->setRenderer($view);
		}
		return $this;
	}
}
