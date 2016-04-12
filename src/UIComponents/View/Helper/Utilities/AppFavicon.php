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
class AppFavicon extends \UIComponents\View\Helper\AbstractHelper 
{

    /**
     * View helper entry point:
     * Retrieves application's favicon image path string
     *
     * @return string
     */
    public function __invoke()
    {
        return $this->render();
    }

    /**
     * render application's favicon image path string
     * 
     * @return string
     */
    public function render($container = null)
    {
        $config = new \Zend\Config\Config( $this->getServiceLocator()->getServiceLocator()->get('Config') );
        return $config->get('app')->get('favicon');
    }
    
}