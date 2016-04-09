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

/**
 *
 * render nothing
 *
 */
class Void extends \UIComponents\View\Helper\AbstractHelper 
//implements \Zend\ServiceManager\ServiceLocatorAwareInterface
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

        return ($this);
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