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
class Panel extends Void
{
    protected $tagname = 'div';
    
    protected $classnames = 'panel panel-default';
    
    protected $classnamesHeader = 'panel-heading';
    
    protected $classnamesBody = 'panel-body';
    
    protected $classnamesFooter = 'panel-footer';
    
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
        return $this;
    }
    
    /**
     * @return string the assemled component rendered to HTML
     */
    public function buildComponent() {
        if ( empty($this->getTagname()) ) {
            $this->setTagname('div');
            // return '';
        }
        
        $header = $this->getHeader();
        if (is_string($header) && !preg_match("/class=\"(.*)".$this->getClassnamesHeader()."(.*)\"/", $header)) {
            $header = $this->_createElement($this->getTagname(), $this->getClassnamesHeader(), [], $header);
        }
            
        $footer = $this->getFooter();
        if (is_string($footer) && !preg_match("/class=\"(.*)".$this->getClassnamesFooter()."(.*)\"/", $footer)) {
            $footer = $this->_createElement($this->getTagname(), $this->getClassnamesFooter(), [], $footer);
        }
        
        $body = $this->getContent();
        if (is_string($body) && !preg_match("/class=\"(.*)".$this->getClassnamesBody()."(.*)\"/", $body)) {
            $body = $this->_createElement($this->getTagname(), $this->getClassnamesBody(), [], $body);
        }
        
        $content = (array($header, $body, $footer));
        if ( is_array($body) && !isset($body["tagname"])) {
            $content = array_merge(array($header), ($body), array($footer));
        }
        
        $component = $this->_createElement($this->getTagname(), $this->getClassnames(), (array)$this->getAttributes(), $content);

        return $component;

    } 
    
    /**
     * @return the $classnamesHeader
     */
    public function getClassnamesHeader() {
        return $this->classnamesHeader;
    }

    /**
     * @param string $classnamesHeader
     */
    public function setClassnamesHeader($classnamesHeader) {
        $this->classnamesHeader = $classnamesHeader;
        return ($this);
    }

    /**
     * @return the $classnamesBody
     */
    public function getClassnamesBody() {
        return $this->classnamesBody;
    }

    /**
     * @param string $classnamesBody
     */
    public function setClassnamesBody($classnamesBody) {
        $this->classnamesBody = $classnamesBody;
        return ($this);
    }

    /**
     * @return the $classnamesFooter
     */
    public function getClassnamesFooter() {
        return $this->classnamesFooter;
    }

    /**
     * @param string $classnamesFooter
     */
    public function setClassnamesFooter($classnamesFooter) {
        $this->classnamesFooter = $classnamesFooter;
        return ($this);
    }

    

}