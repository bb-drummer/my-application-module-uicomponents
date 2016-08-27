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

use \UIComponents\Template as UITemplate;

/**
 *
 * generates a template object to use in view script
 *
 */
class Template extends \UIComponents\View\Helper\AbstractHelper 
{

    /**
     * View helper entry point:
     * Retrieves a new template object
     *
     * @return \UIComponents\Template\Template
     */
    public function __invoke()
    {
        return new UITemplate();
    }
    
}