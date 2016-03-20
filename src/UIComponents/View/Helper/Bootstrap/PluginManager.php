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

namespace UIComponents\View\Helper\Bootstrap;

use Zend\View\Exception;
use Zend\View\HelperPluginManager;

/**
 * Plugin manager implementation for 'Bootstrap' helpers
 *
 * Enforces that helpers retrieved are instances of
 * Bootstrap\HelperInterface. Additionally, it registers a number of default
 * helpers.
 */
class PluginManager extends HelperPluginManager
{
	/**
	 * Default set of helpers
	 *
	 * @var array
	 */
	protected $invokableClasses = [
		'void'				=> 'UIComponents\View\Helper\Bootstrap\Void',
		'config'			=> 'UIComponents\View\Helper\Bootstrap\Config',
		'apptitle'			=> 'UIComponents\View\Helper\Bootstrap\AppTitle',
		'appfavicon'		=> 'UIComponents\View\Helper\Bootstrap\AppFavicon',
		'applogo'			=> 'UIComponents\View\Helper\Bootstrap\AppLogo',
		'components'		=> 'UIComponents\View\Helper\Bootstrap\Components',
		'navbar'			=> 'UIComponents\View\Helper\Bootstrap\Navbar',
		'breadcrumbs'		=> 'UIComponents\View\Helper\Bootstrap\Breadcrumbs',
	];

	/**
	 * Validate the plugin
	 *
	 * Checks that the helper loaded is an instance of AbstractHelper.
	 *
	 * @param  mixed $plugin
	 * @return void
	 * @throws Exception\InvalidArgumentException if invalid
	 */
	public function validatePlugin($plugin)
	{
		if ($plugin instanceof \Zend\View\Helper\AbstractHelper) {
			// we're okay
			return;
		}

		throw new Exception\InvalidArgumentException(sprintf(
			'Plugin of type %s is invalid; must implement %s\AbstractHelper',
			(is_object($plugin) ? get_class($plugin) : gettype($plugin)),
			__NAMESPACE__
		));
	}
}
