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
class AppTitle extends \UIComponents\View\Helper\AbstractHelper 
{

    /**
     * View helper entry point:
     * Retrieves application's title string
     *
     * @param  boolean $short [optional] application's title string (short version)
     * @return string
     */
    public function __invoke($short = false)
    {
        return $this->render($short);
    }

    /**
     * return application's title string
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