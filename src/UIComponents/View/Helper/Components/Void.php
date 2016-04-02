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

namespace UIComponents\View\Helper\Components;

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
     * Retrieves helper and optionally sets component options to operate on
     *
     * @param  array|StdClass $options [optional] component options to operate on
     * @return self
     */
    public function __invoke($options = array())
    {
        if ( is_object($options) && method_exists($options, 'toArray') ) {
            $options = $options->toArray();
        } else if ( is_object($options) ) {
            $options = (array)$options;
        }
        
        if (isset($options['container']) && (null !== $options['container'])) {
            $this->setContainer($options['container']);
        }
    
        if (isset($options['tagname']) && (null !== $options['tagname'])) {
            $this->setTagname($options['tagname']);
        }
        if (isset($options['class']) && (null !== $options['class'])) {
            $this->setClassnames($options['class']);
        }
        if (isset($options['classnames']) && (null !== $options['classnames'])) {
            $this->setClassnames($options['classnames']);
        }

        if (isset($options['attr']) && (null !== $options['attr'])) {
            $this->setAttributes($options['attr']);
        }
        if (isset($options['attributes']) && (null !== $options['attributes'])) {
            $this->setAttributes($options['attributes']);
        }

        if (isset($options['content']) && (null !== $options['content'])) {
            $this->setContent($options['content']);
        }
        if (isset($options['children']) && (null !== $options['children'])) {
            $this->setContent($options['children']);
        }
        
        $component = clone $this;
        return $component;
    }
    
}