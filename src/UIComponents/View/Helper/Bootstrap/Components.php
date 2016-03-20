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

/**
 *
 * Helper to get Components colletion opject/view helper plugin
 * 
 */
class Components extends \UIComponents\View\Helper\Navigation\Menu
{

	/**
	 * View helper entry point:
	 * Retrieves helper and optionally sets container to operate on
	 *
	 * @param  AbstractContainer $container [optional] container to operate on
	 * @return self
	 */
	public function __invoke($options = array())
	{
		return $this->view->components($options);
	}

	
}