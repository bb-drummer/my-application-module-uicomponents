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

namespace UIComponents\View\Helper;

use Zend\View\Exception;
use Zend\View\HelperPluginManager;

/**
 * Plugin manager implementation for 'Components' helpers
 *
 * Enforces that helpers retrieved are instances of
 * Components\HelperInterface. Additionally, it registers a number of default
 * helpers.
 */
class AbstractPluginManager extends HelperPluginManager
{
    /**
     * Default set of helpers
     *
     * @var    array
     */
    protected $invokableClasses = [ ];

    /**
     * Validate the plugin
     *
     * Checks that the helper loaded is an instance of AbstractHelper.
     *
     * @param    mixed $plugin
     * @return    void
     * @throws    Exception\InvalidArgumentException if invalid
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
