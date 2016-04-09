<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * UI Components
 *
 * @package     [MyApplication]
 * @subpackage  BB's Zend Framework 2 Components
 * @subpackage  UI Components
 * @author      Björn Bartels <coding@bjoernbartels.earth>
 * @link        https://gitlab.bjoernbartels.earth/groups/zf2
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright   copyright (c) 2016 Björn Bartels <coding@bjoernbartels.earth>
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
     * @var    array
     */
    protected $invokableClasses = [

    	// panels
    	//
        'void'              => 'UIComponents\View\Helper\Components\Void',
        'block'             => 'UIComponents\View\Helper\Components\Block',
        //'well'              => 'UIComponents\View\Helper\Components\Well',
        //'jumbotron'         => 'UIComponents\View\Helper\Components\Jumbotron',
        'panel'             => 'UIComponents\View\Helper\Components\Panel',
        'widget'            => 'UIComponents\View\Helper\Components\Widget',
        'dashboard'         => 'UIComponents\View\Helper\Components\Dashboard',

    	// page components
    	//
        'nav'               => 'UIComponents\View\Helper\Components\Navbar', // set 'alias to' or combine with 'Navbars' !
        'topbar'            => 'UIComponents\View\Helper\Components\Navbar', // set 'alias to' or combine with 'Navbars' !
        'breadcrumbs'       => 'UIComponents\View\Helper\Components\Breadcrumbs',
        'languagemenu'      => 'UIComponents\View\Helper\Components\Languagemenu',
    	'toolbar'           => 'UIComponents\View\Helper\Components\Toolbar',
        
        // controls
        //
        'button'            => 'UIComponents\View\Helper\Components\Button', // default, drop-down/up, splitted
        'buttongroup'       => 'UIComponents\View\Helper\Components\Buttongroup',
    	//'inputgroup'        => 'UIComponents\View\Helper\Components\Inputgroup',
        //'progressbar'       => 'UIComponents\View\Helper\Components\Progressbar',

    	// forms
    	//
        'formgroup'         => 'UIComponents\View\Helper\Components\Formgroup',
    	
    	// lists/tables
    	//
        //'listgroup'         => 'UIComponents\View\Helper\Components\Listgroup',
        'table'         	=> 'UIComponents\View\Helper\Components\Listgroup',
    	//'pagination'        => 'UIComponents\View\Helper\Components\Pagination',
    	
    	// widgets
    	//
        //'label'             => 'UIComponents\View\Helper\Components\Label',
        //'badge'             => 'UIComponents\View\Helper\Components\Badge',
        //'pageheader'        => 'UIComponents\View\Helper\Components\Pageheader',
        //'thumbnail'         => 'UIComponents\View\Helper\Components\Thumbnail',

        //'mediaobject'       => 'UIComponents\View\Helper\Components\Mediaobject',
        //'embed'             => 'UIComponents\View\Helper\Components\Embed',
            
        // javascript components
        //
        //'datatable'         => 'UIComponents\View\Helper\Components\Datatable',
        'modal'             => 'UIComponents\View\Helper\Components\Modal',
        //'dropdown'          => 'UIComponents\View\Helper\Components\Dropdown',
        //'tab'               => 'UIComponents\View\Helper\Components\Tab',
        //'tooltip'           => 'UIComponents\View\Helper\Components\Tooltip',
        //'popover'           => 'UIComponents\View\Helper\Components\Popover',
        //'alert'             => 'UIComponents\View\Helper\Components\Alert',
        //'button'            => 'UIComponents\View\Helper\Components\Button',
        //'collapse'          => 'UIComponents\View\Helper\Components\Collapse',
        //'carousel'          => 'UIComponents\View\Helper\Components\Carousel',
    ];

}
