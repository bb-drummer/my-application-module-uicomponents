<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * UI Components
 *
 * @package        [MyApplication]
 * @package        BB's Zend Framework 2 Components
 * @package        UI Components
 * @author        Björn Bartels <development@bjoernbartels.earth>
 * @link        https://gitlab.bjoernbartels.earth/groups/zf2
 * @license        http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright    copyright (c) 2016 Björn Bartels <development@bjoernbartels.earth>
 */

namespace UIComponents\View\Helper;

use Zend\View\Exception;

/**
 * Proxy helper for retrieving navigational helpers and forwarding calls
 */
class Components extends AbstractProxyHelper
{
    /**
     * View helper namespace
     *
     * @var string
     */
    const NS = 'UIComponents\View\Helper\Components';

    /**
     * Helper entry point
     *
     * @param  string|AbstractContainer $container container to operate on
     * @return Components
     */
    public function __invoke($options = array())
    {
        if (isset($options['container']) && null !== $options['container']) {
            $this->setContainer($options['container']);
        }

        return ($this);
    }

    /**
     * Renders helper
     *
     * @param  AbstractContainer $container
     * @return string
     * @throws Exception\RuntimeException
     */
    public function render($container = null)
    {
        return '';
    }

    /**
     * Retrieve plugin loader for navigation helpers
     *
     * Lazy-loads an instance of Navigation\HelperLoader if none currently
     * registered.
     *
     * @return Components\PluginManager
     */
    public function getPluginManager()
    {
        if (null === $this->plugins) {
            $this->setPluginManager(new Components\PluginManager());
        }

        return $this->plugins;
    }

}
