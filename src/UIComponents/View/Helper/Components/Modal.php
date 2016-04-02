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
class Modal extends Panel
{
    protected $tagname = 'div';
    
    protected $classnames = 'modal modal-default';
    
    protected $classnamesHeader = 'modal-header';
    
    protected $classnamesBody = 'modal-body';
    
    protected $classnamesFooter = 'modal-footer';
    
    
    protected $classnamesDialog = 'modal-dialog';
    
    protected $classnamesContent = 'modal-content';
    
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
        
        $contentElement = $this->_createElement($this->getTagname(), $this->getClassnamesContent(), (array)$this->getAttributes(), $content);
        $dialogElement = $this->_createElement($this->getTagname(), $this->getClassnamesDialog(), [], $contentElement);
        $component = $this->_createElement($this->getTagname(), $this->getClassnames(), [], $dialogElement);
        return $component;

    } 
    
    /**
     * @return the $classnamesDialog
     */
    public function getClassnamesDialog() {
        return $this->classnamesDialog;
    }

    /**
     * @param string $classnamesDialog
     */
    public function setClassnamesDialog($classnamesDialog) {
        $this->classnamesDialog = $classnamesDialog;
        return $this;
    }

    /**
     * @return the $classnamesContent
     */
    public function getClassnamesContent() {
        return $this->classnamesContent;
    }

    /**
     * @param string $classnamesContent
     */
    public function setClassnamesContent($classnamesContent) {
        $this->classnamesContent = $classnamesContent;
        return $this;
    }
    
}