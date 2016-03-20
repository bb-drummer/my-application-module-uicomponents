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

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 *
 * Helper for recursively rendering 'Bootstrap' compatible multi-level menus
 * 
 * @see \UIComponents\View\Helper\Navigation\Menu
 */
class Navbar extends \UIComponents\View\Helper\Navigation\Menu // implements ServiceLocatorAwareInterface
{
	//use ServiceLocatorAwareTrait;
	
	/**
	 * View helper entry point:
	 * Retrieves helper and optionally sets container to operate on
	 *
	 * @param  AbstractContainer $container [optional] container to operate on
	 * @return self
	 */
	public function __invoke($container = null)
	{
		if (null !== $container) {
			$this->setContainer($container);
		}

		return (clone $this);
	}

	
}