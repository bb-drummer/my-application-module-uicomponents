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
class Button extends Void
{
    protected $tagname = 'a';
    
    protected $classnames = 'button btn';
    
    protected $drop = false;
    
    protected $block = false;
    
    protected $active = false;
    
    protected $_tags = array('a','input','button');
    
    protected $_sizes = array('xs','sm','lg');
    protected $_foundations_sizes = array(
        'xs' => 'tiny', 'xs' => 'small', 'lg' => 'large',
    );

    protected $_types = array('default','primary','success','info','warning','alert','danger','link');
    
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
        
        $component->setHeader('')->setFooter('');
        
        // tag options
        if ( isset($options["tagname"]) && in_array(strtolower($options["tagname"]), $component->getTags()) ) {
            $component->setTagname(strtolower($options["tagname"]));
        } else {
            $component->setTagname('a');
        }
        if ( isset($options["attributes"]) && is_array($options["attributes"]) ) {
            $component->setAttributes($options["attributes"]);
        }
        
        // bootstrap options
        if ( isset($options["size"]) && in_array(strtolower($options["size"]), $component->getSizes()) ) {
            $component->addClass('btn-'.strtolower($options["size"]).' '.strtolower($this->_foundations_sizes["size"]));
        }
        if ( isset($options["type"]) && in_array(strtolower($options["type"]), $component->getTypes()) ) {
            $component->addClass('btn-'.strtolower($options["type"]).' '.strtolower($options["type"]));
        } else {
            $component->addClass('btn-default');
        }
        if ( isset($options["drop"]) ) {
            $component->setDrop($options["drop"]);
        }
        if ( isset($options["block"]) ) {
            $component->setBlock($options["block"]);
        }
        if ( isset($options["active"]) ) {
            $component->setActive($options["active"]);
        }

        if ($component->getBlock()) $component->addClass('btn-block expanded');
        if ($component->getActive()) $component->addClass('active');
        
        if ($component->getTagname() == 'a') {
            $component->setAttributes(array_merge_recursive($component->getAttributes(), array(
                'role' => 'button'
            )));
            if ( isset($options["disabled"]) ) {
                $component->addClass('disabled');
            }
        } else {
            $component->setAttributes(array_merge_recursive($component->getAttributes(), array(
                'type' => 'button'
            )));
            if ( isset($options["disabled"]) ) {
                $component->setAttributes(array_merge_recursive($component->getAttributes(), array(
                    'disabled' => 'disabled'
                )));
            }
        }
        
        // tag content
        if ( isset($options["label"]) && !empty($options["label"]) ) {
            $component->setContent($options["label"]);
        } else if ( isset($options["content"]) && !empty($options["content"]) ) {
            $component->setContent($options["content"]);
        }
        
        //$component = clone $this;
        return $component;
        // return $this;
    }
    
    //
    // private getters/setters
    //
    
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
     * @return the $_types
     */
    public function getTypes() {
        return $this->_types;
    }

    /**
     * @param multitype:string  $_types
     */
    public function setTypes($_types) {
        $this->_types = $_types;
        return $this;
    }
    
    /**
     * @return the $_tags
     */
    public function getTags() {
        return $this->_tags;
    }

    /**
     * @param multitype:string  $_tags
     */
    public function setTags($_tags) {
        $this->_tags = $_tags;
        return $this;
    }

    
    //
    // option getters/setters
    //
    
    
    /**
     * @return the $drop
     */
    public function getDrop() {
        return $this->drop;
    }

    /**
     * @param string $drop
     */
    public function setDrop($drop) {
        if ( in_array(strtolower($drop), array('up','down'))) {
            $this->drop = $drop;
        }
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

    /**
     * @return the $active
     */
    public function getActive() {
        return $this->active;
    }
    
    /**
     * @param boolean $active
     */
    public function setActive($active) {
        $this->active = !!$active;
        return $this;
    }
    
    

    
    
}