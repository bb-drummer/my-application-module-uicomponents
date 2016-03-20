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
class AppTitle extends AbstractHelper // implements \Zend\ServiceManager\ServiceLocatorAwareInterface
{

	/**
	 * View helper entry point:
	 * Retrieves helper and optionally sets container to operate on
	 *
	 * @param  AbstractContainer $container [optional] container to operate on
	 * @return self
	 */
	public function __invoke($short = false)
	{
		return $this->render($short);
	}

	/**
	 * render nothing
	 * 
	 * @return string
	 */
	public function render($short = null)
	{
		$config = new \Zend\Config\Config( $this->getServiceLocator()->getServiceLocator()->get('Config') );
		if ($short === true) {
			return $config->get('app')->get('short_title');
		}
		return $config->get('app')->get('title');
	}
	
}