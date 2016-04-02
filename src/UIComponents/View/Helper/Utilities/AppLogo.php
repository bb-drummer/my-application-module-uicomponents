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

namespace UIComponents\View\Helper\Utilities;

/**
 *
 * render nothing
 *
 */
class AppLogo extends \UIComponents\View\Helper\AbstractHelper 
//implements \Zend\ServiceManager\ServiceLocatorAwareInterface
{

    /**
     * View helper entry point:
     * Retrieves helper and optionally sets container to operate on
     *
     * @param  AbstractContainer $container [optional] container to operate on
     * @return self
     */
    public function __invoke()
    {
        return $this->render();
    }

    /**
     * render nothing
     * 
     * @return string
     */
    public function render($container = null)
    {
        $config = new \Zend\Config\Config( $this->getServiceLocator()->getServiceLocator()->get('Config') );
        return $config->get('app')->get('logo');
    }
    
}