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

namespace UIComponents\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Exception;
use Zend\View\Renderer\RendererInterface as Renderer;
use Zend\Mvc\Application;
use UIComponents\View\Helper\Bootstrap\Components;

/**
 * Proxy helper for retrieving navigational helpers and forwarding calls
 */
class Utilities extends AbstractProxyHelper
{
	/**
	 * View helper namespace
	 *
	 * @var string
	 */
	const NS = 'UIComponents\View\Helper\Utilities';
	/**
	 * Helper entry point
	 *
	 * @param  string|AbstractContainer $container container to operate on
	 * @return Bootstrap
	 */
	public function __invoke($container = null)
	{
		if (null !== $container) {
			$this->setContainer($container);
		}

		return $this;
	}

	/**
	 * Retrieve plugin loader for navigation helpers
	 *
	 * Lazy-loads an instance of Navigation\HelperLoader if none currently
	 * registered.
	 *
	 * @return Bootstrap\PluginManager
	 */
	public function getPluginManager()
	{
		if (null === $this->plugins) {
			$this->setPluginManager(new Utilities\PluginManager());
		}

		return $this->plugins;
	}
}
