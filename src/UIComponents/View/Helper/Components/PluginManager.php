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

use UIComponents\View\Helper\AbstractPluginManager;

/**
 * Plugin manager implementation for 'Components' helpers
 *
 * Enforces that helpers retrieved are instances of
 * Components\HelperInterface. Additionally, it registers a number of default
 * helpers.
 */
class PluginManager extends AbstractPluginManager
{
	/**
	 * Default set of helpers
	 *
	 * @var	array
	 */
	protected $invokableClasses = [
			
		'block'				=> 'UIComponents\View\Helper\Components\Block',
		'dashboard'			=> 'UIComponents\View\Helper\Components\Dashboard',
		'panel'				=> 'UIComponents\View\Helper\Components\Panel',
		'toolbar'			=> 'UIComponents\View\Helper\Components\Toolbar',
		'void'				=> 'UIComponents\View\Helper\Components\Void',
		'widget'			=> 'UIComponents\View\Helper\Components\Widget',
		'languagemenu'		=> 'UIComponents\View\Helper\Components\Languagemenu',
		
		// TWBS' markup/css components
		'button'			=> 'UIComponents\View\Helper\Components\Button', // default, drop-down/up, splitted
		'buttongroup'		=> 'UIComponents\View\Helper\Components\Buttongroup',
		'inputgroup'		=> 'UIComponents\View\Helper\Components\Inputgroup',
		'nav'				=> 'UIComponents\View\Helper\Components\Navbar', // set 'alias to' or combine with 'Navbars' !
		'topbar'			=> 'UIComponents\View\Helper\Components\Navbar', // set 'alias to' or combine with 'Navbars' !
		'breadcrumbs'		=> 'UIComponents\View\Helper\Components\Breadcrumbs',
		'pagination'		=> 'UIComponents\View\Helper\Components\Pagination',
		'label'				=> 'UIComponents\View\Helper\Components\Label',
		'badge'				=> 'UIComponents\View\Helper\Components\Badge',
		'jumbotron'			=> 'UIComponents\View\Helper\Components\Jumbotron',
		'pageheader'		=> 'UIComponents\View\Helper\Components\Pageheader',
		'thumbnail'			=> 'UIComponents\View\Helper\Components\Thumbnail',
		'listgroup'			=> 'UIComponents\View\Helper\Components\Listgroup',
		'well'				=> 'UIComponents\View\Helper\Components\Well',

		'progressbar'		=> 'UIComponents\View\Helper\Components\Progressbar',
		'mediaobject'		=> 'UIComponents\View\Helper\Components\Mediaobject',
		'embed'				=> 'UIComponents\View\Helper\Components\Embed',
		'formgroup'			=> 'UIComponents\View\Helper\Components\Formgroup',
			
		// TWBS's javascript components
		'modal'				=> 'UIComponents\View\Helper\Components\Modal',
		'dropdown'			=> 'UIComponents\View\Helper\Components\Dropdown',
		'tab'				=> 'UIComponents\View\Helper\Components\Tab',
		'tooltip'			=> 'UIComponents\View\Helper\Components\Tooltip',
		'popover'			=> 'UIComponents\View\Helper\Components\Popover',
		'alert'				=> 'UIComponents\View\Helper\Components\Alert',
		'button'			=> 'UIComponents\View\Helper\Components\Button',
		'collapsse'			=> 'UIComponents\View\Helper\Components\Collapse',
		'carousel'			=> 'UIComponents\View\Helper\Components\Carousel',
	];

}
