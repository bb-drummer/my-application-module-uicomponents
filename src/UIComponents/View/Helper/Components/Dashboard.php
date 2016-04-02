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

namespace UIComponents\View\Helper\Components;

/**
 *
 * render nothing
 *
 */
class Dashboard extends Void
{
	protected $tagname = 'section';
	
	protected $classnames = 'dashboard';
	
	/**
	 * View helper entry point:
	 * Retrieves helper and optionally sets component options to operate on
	 *
	 * @param  array|StdClass $options [optional] component options to operate on
	 * @return self
	 */
	public function __invoke($options = array())
	{
		parent::__invoke($options);
		return $this;
	}
	
}