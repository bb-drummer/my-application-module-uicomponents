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

namespace UIComponents\View\Helper;

use RecursiveIteratorIterator;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\Navigation\Page\AbstractPage;
use Zend\Navigation\AbstractContainer;
use Zend\Permissions\Acl;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View;
use Zend\View\Exception;
use \UIComponents\Translator\TranslatorAwareInterfaceTrait;
use \UIComponents\View\Helper\Traits\ComponentClassnamesTrait;
use \UIComponents\View\Helper\Traits\ComponentAttributesTrait;
use \UIComponents\View\Helper\Traits\ComponentServiceManagersTrait;
use \UIComponents\View\Helper\Traits\ComponentAclTrait;
use \UIComponents\View\Helper\Traits\ComponentNavigationTrait;

/**
 * Base class for navigational helpers
 */
abstract class AbstractHelper extends \Zend\View\Helper\AbstractHtmlElement implements
    EventManagerAwareInterface,
    HelperInterface,
    ServiceLocatorAwareInterface,
    TranslatorAwareInterface
{
    
    use TranslatorAwareInterfaceTrait;
    use ComponentClassnamesTrait;
    use ComponentAttributesTrait;
    use ComponentServiceManagersTrait;
    use ComponentAclTrait;
    use ComponentNavigationTrait;
    
    //
    // component related vars/properties/providers/services...
    //
    
    /**
     * component's tag-name
     *
     * @var string
     */
    protected $tagname = 'div';
    
    
    /**
     * component's header
     *
     * @var mixed
     */
    protected $header = null;
    
    /**
     * component's footer
     *
     * @var mixed
     */
    protected $footer = null;
    
    /**
     * component's main content
     *
     * @var string|array
     */
    protected $content = '';
    
    /**
     * component's size attributes
     *
     * @var string|array
     */
    protected $size = '';
    
    

    /**
     * DOM object container needed for element creation with php's default DOM method
     * 
     * @var \DOMDocument
     */
    protected $_DOMDoc = null;
    
    

   /**
     * Magic overload: Proxy calls to the navigation container
     *
     * @param    string $method    method name in container
     * @param    array    $arguments rguments to pass
     * @return mixed
     * @throws Navigation\Exception\ExceptionInterface
     */
    public function __call($method, array $arguments = [])
    {
        return call_user_func_array(
            [$this->getContainer(), $method],
            $arguments
        );
    }

    /**
     * Magic overload: Proxy to {@link render()}.
     *
     * This method will trigger an E_USER_ERROR if rendering the helper causes
     * an exception to be thrown.
     *
     * Implements {@link HelperInterface::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * render component
     * 
     * @param boolean $output
     * 
     * @return string
     */
    public function render($output = false)
    {    
        try {
            
            if ($output) {
                echo $this->buildComponent();
            }
            return $this->buildComponent();
            
        } catch (\Exception $e) {
            
            $msg = get_class($e) . ': ' . $e->getMessage() . "\n" . $e->getTraceAsString();
            trigger_error($msg, E_USER_ERROR);
            return '';
            
        }
    }

    /**
     * Determines whether a page should be allowed given certain parameters
     *
     * @param    array    $params
     * @return    bool
     */
    protected function isAllowed($params)
    {
        $results = $this->getEventManager()->trigger(__FUNCTION__, $this, $params);
        return $results->last();
    }

    // Util methods:

    /**
     * Returns an HTML string containing an 'a' element for the given page
     *
     * @param    AbstractPage $page    page to generate HTML for
     * @return string                HTML string (<a href="…">Label</a>)
     */
    public function htmlify(AbstractPage $page)
    {
        $label = $this->translate($page->getLabel(), $page->getTextDomain());
        $title = $this->translate($page->getTitle(), $page->getTextDomain());

        // get attribs for anchor element
        $attribs = [
            'id'     => $page->getId(),
            'title'    => $title,
            'class'    => $page->getClass(),
            'href'    => $page->getHref(),
            'target' => $page->getTarget()
        ];

        /** @var \Zend\View\Helper\EscapeHtml $escaper */
        $escaper = $this->view->plugin('escapeHtml');
        $label    = $escaper($label);

        return '<a' . $this->htmlAttribs($attribs) . '>' . $label . '</a>';
    }

    /**
     * Normalize an ID
     *
     * Overrides {@link View\Helper\AbstractHtmlElement::normalizeId()}.
     *
     * @param    string $value
     * @return string
     */
    protected function normalizeId($value)
    {
        $prefix = get_class($this);
        $prefix = strtolower(trim(substr($prefix, strrpos($prefix, '\\')), '\\'));

        return $prefix . '-' . $value;
    }

    //
    // component related methods
    //
    
    /**
     * @return string the assemled component rendered to HTML
     */
    public function buildComponent() {
        $html = ' '.__CLASS__.' ';
        if ( empty($this->getTagname()) ) {
            return '';
        }
        
        $header = $this->getHeader();
        
        $footer = $this->getFooter();
        
        $body = $this->getContent();
        
        $content = (array($header, $body, $footer));
        if ( is_array($body) && !isset($body["tagname"])) {
            $content = array_merge(array($header), ($body), array($footer));
        }
        
        $component = $this->_createElement($this->getTagname(), $this->getClassnames(), (array)$this->getAttributes(), $content);

        return $component;

    } 
    
    /**
     * create the component markup
     * 
     * @param string $tagname 
     * @param string $classnames 
     * @param array $attributes 
     * @param string|mixed $content 
     * 
     * @return string the component markup
     */
    public function _createElement($tagname = 'div', $classnames = '', $attributes = array(), $content = '') {
        $html = '';
        $html .= '<'.$tagname.''.((isset($classnames) && !empty($classnames)) ? ' class="'.$classnames.'"' : '').' '.$this->htmlAttribs($attributes).'>';
        if (!empty($content)) {
            if ( $content instanceof AbstractHelper ) {
                $html .= $content->render();
            } else if ( is_array($content) && isset($content['tagname']) ) {
                $html .= $this->_createElement(
                    $content['tagname'],
                    (isset($content['classnames']) && !empty($content['classnames']) ? $content['classnames'] : (isset($content['class']) && !empty($content['class']) ? $content['class'] : '')),
                    (isset($content['attributes']) && !empty($content['attributes']) ? $content['attributes'] : (isset($content['attr']) && !empty($content['attr']) ? $content['attr'] : '')),
                    (isset($content['content']) && !empty($content['content']) ? $content['content'] : '')
                );
            } else if ( is_array($content) ) {
                foreach ($content as $key => $item) {
                    if ( $item instanceof AbstractHelper ) {
                        $html .= $item->render();
                    } else if ( is_array($item) && isset($item['tagname']) ) {
                        $html .= $this->_createElement(
                            $item['tagname'],
                            (isset($item['classnames']) && !empty($item['classnames']) ? $item['classnames'] : (isset($item['class']) && !empty($item['class']) ? $item['class'] : '')),
                            (array)(isset($item['attributes']) && !empty($item['attributes']) ? $item['attributes'] : (isset($item['attr']) && !empty($item['attr']) ? $item['attr'] : '')),
                            (isset($item['content']) && !empty($item['content']) ? $item['content'] : '')
                        );
                    } else if ( is_array($item) ) {
                        foreach ($content as $key => $value) {
                            $html .= (string)$value;
                        }
                    } else {
                        $html .= $item;
                    }
                }
            } else {
                $html .= $content;
            }
        }
        $html .= '</'.$tagname.'>';
        
        return $html;
    } 
    
    
    //
    // component related getters/setters
    //
    
    /**
     * get main tag-name
     * 
     * @return string the $tagname
     */
    public function getTagname() {
        return $this->tagname;
    }

    /**
     * set main tag-name
     * 
     * @param string $tagname
     */
    public function setTagname($tagname) {
        if ( null !== $tagname ) {
            $this->tagname = $tagname;
        }
        return $this;
    }

    /**
     * get the element header
     * 
     * @return mixed the $header
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * set the element header
     * 
     * @param mixed $header
     */
    public function setHeader($header) {
        if ( null !== $header ) {
            $this->header = $header;
        }
        return $this;
    }

    /**
     * get the element footer
     * 
     * @return mixed the $footer
     */
    public function getFooter() {
        return $this->footer;
    }

    /**
     * set the element footer
     * 
     * @param mixed $footer
     */
    public function setFooter($footer = null) {
        if ( null !== $footer ) {
            $this->footer = $footer;
        }
        return $this;
    }

    /**
     * get the element content
     * @return the $content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * set the element content
     * 
     * @param string|array $content
     */
    public function setContent($content = '') {
        $this->content = $content;
        return $this;
    }
    
    /**
     * get DOM object
     * 
     * @return the $_DOMDoc
     */
    public function getDOMDoc() {
        if ( ! $this->_DOMDoc instanceof \DOMDocument ) {
            $this->_DOMDoc = new \DOMDocument();
        }
        return $this->_DOMDoc;
    }

    /**
     * set DOM object
     * 
     * @param \DOMDocument $_DOMDoc
     */
    public function setDOMDoc(\DOMDocument $_DOMDoc) {
        $this->_DOMDoc = $_DOMDoc;
        return $this;
    }
    
}
