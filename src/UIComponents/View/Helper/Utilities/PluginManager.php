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

namespace UIComponents\View\Helper\Utilities;

use UIComponents\View\Helper\AbstractPluginManager;

/**
 * Plugin manager implementation for 'Utilities' helpers
 *
 * Enforces that helpers retrieved are instances of
 * HelperInterface. Additionally, it registers a number of default
 * helpers.
 */
class PluginManager extends AbstractPluginManager
{
    /**
     * Default set of helpers
     *
     * @var array
     */
    protected $invokableClasses = [
        'void'          => 'UIComponents\View\Helper\Utilities\Void',
    		
        'config'        => 'UIComponents\View\Helper\Utilities\Config',
    		
        'apptitle'      => 'UIComponents\View\Helper\Utilities\AppTitle',
        'appfavicon'    => 'UIComponents\View\Helper\Utilities\AppFavicon',
        'applogo'       => 'UIComponents\View\Helper\Utilities\AppLogo',

    	'framework'     => 'UIComponents\View\Helper\Utilities\Framework',
    ];
    
}
