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
class Buttongroup extends Void
{
    protected $tagname = 'div';
    
    protected $classnames = 'button-group btn-group';
    
    protected $block = false;
    
    protected $_sizes = array('default','xs','sm','lg');
    protected $_foundations_sizes = array(
        'xs' => 'tiny', 'xs' => 'small', 'lg' => 'large', 'default' => '',
    );
    
    /**
     * View helper entry point:
     * Retrieves helper and optionally sets component options to operate on
     *
     * @param  array|StdClass $options [optional] component options to operate on
     * @return self
     */
    public function __invoke($options = array())
    {
        parent::__invoke($options);
        $component = clone $this;
        
        $this->setHeader('')->setFooter('');

        if ( isset($options["attributes"]) && is_array($options["attributes"]) ) {
            $component->setAttributes($options["attributes"]);
        }
        $component->setAttributes(array_merge_recursive($component->getAttributes(), array(
            'role' => 'group'
        )));
        
        if ( isset($options["vertical"]) && !!$options["vertical"] ) {
            $component->setClassnames('btn-group-vertical vertical');
        } else if ( isset($options["justified"]) && !!$options["justified"] ) {
            $component->addClass('btn-group-justified');
        }
        
        if ( isset($options["size"]) && in_array($options["size"], $component->getSizes()) ) {
            $component->addClass('btn-group-'.$options["size"].' '.strtolower($this->_foundations_sizes["size"]));
        }
        if ( isset($options["block"]) ) {
            $component->setBlock($options["block"]);
        }
        if ($component->getBlock()) $component->addClass('btn-block expanded');
        
        
        
        if ( isset($options["buttons"]) && !empty($options["buttons"]) ) {
            $component->setContent($options["buttons"]);
        } else if ( isset($options["content"]) && !empty($options["content"]) ) {
            $component->setContent($options["content"]);
        }

        return $component;
    }
    
    /**
     * @return the $_sizes
     */
    public function getSizes() {
        return $this->_sizes;
    }

    /**
     * @param multitype:string  $_sizes
     */
    public function setSizes($_sizes) {
        $this->_sizes = $_sizes;
        return $this;
    }

    /**
     * @return the $block
     */
    public function getBlock() {
        return $this->block;
    }
    
    /**
     * @param boolean $block
     */
    public function setBlock($block) {
        $this->block = !!$block;
        return $this;
    }

    
    
}