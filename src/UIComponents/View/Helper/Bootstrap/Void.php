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

namespace UIComponents\View\Helper\Bootstrap;

/**
 *
 * render nothing
 *
 */
class Void extends AbstractHelper implements \Zend\ServiceManager\ServiceLocatorAwareInterface
{

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

		return $this;
	}

	/**
	 * render nothing
	 * 
	 * @return string
	 */
	public function render($container = null)
	{
		$html = '';
		
		return $html;
	}

}