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

namespace UIComponents\View\Helper\Navigation;

use \RecursiveIteratorIterator;
use \Zend\Navigation\AbstractContainer;
use \Zend\Navigation\Page\AbstractPage;
use \Zend\ServiceManager\ServiceLocatorInterface;
use \Zend\View\Exception;

/**
 *
 * Helper for recursively rendering 'Bootstrap' compatible multi-level menus
 *
 */
class Menu extends \Zend\View\Helper\Navigation\Menu
{

    /**
     * default CSS class to use for li elements
     *
     * @var string
     */
    protected $defaultLiClass = '';

    /**
     * CSS class to use for the ul sub-menu element
     *
     * @var string
     */
    protected $subUlClass = 'dropdown-menu';

    /**
     * CSS class to use for the 1. level (NOT root level!) ul sub-menu element
     *
     * @var string
     */
    protected $subUlClassLevel1 = 'dropdown-menu';

    /**
     * CSS class to use for the active li sub-menu element
     *
     * @var string
     */
    protected $subLiClass = 'dropdown-submenu';

    /**
     * CSS class to use for the active li sub-menu element
     *
     * @var string
     */
    protected $subLiClassLevel0 = 'dropdown';

    /**
     * CSS class prefix to use for the menu element's icon class
     *
     * @var string
     */
    protected $iconPrefixClass = 'icon-';

    /**
     * HREF string to use for the sub-menu toggle element's HREF attribute, 
     * to override current page's href/'htmlify' setting
     *
     * @var string
     */
    protected $hrefSubToggleOverride = null;

    /**
     * Partial view script to use for rendering menu link/item
     *
     * @var string|array
     */
    protected $htmlifyPartial = null;

    //
    // component related vars/properties/providers/services...
    //
    
    /**
     * component's class-names
     *
     * @var string
     */
    protected $classnames = '';
    
    /**
     * component's attributes
     *
     * @var array
     */
    protected $attributes = array();
    
    

    /**
     * View helper entry point:
     * Retrieves helper and optionally sets container to operate on
     *
     * @param    AbstractContainer $container [optional] container to operate on
     * @return self
     */
    public function __invoke($container = null)
    {
        if (null !== $container) {
            $this->setContainer($container);
        }

        return $this;
    }
    
    /**
     * Returns the navigation container helper operates on by default
     *
     * Implements {@link HelperInterface::getContainer()}.
     *
     * If no container is set, a new container will be instantiated and
     * stored in the helper.
     *
     * @return Navigation\AbstractContainer    navigation container
     */
    public function getContainer()
    {
        if (null === $this->container) {
            $this->container = new \UIComponents\Navigation\Navigation();
        }

        return $this->container;
    }

    /**
     * Renders helper
     *
     * Renders a HTML 'ul' for the given $container. If $container is not given,
     * the container registered in the helper will be used.
     *
     * Available $options:
     *
     *
     * @param    AbstractContainer $container [optional] container to create menu from.
     *                                        Default is to use the container retrieved
     *                                        from {@link getContainer()}.
     * @param    array             $options    [optional] options for controlling rendering
     * @return string
     */
    public function renderMenu($container = null, array $options = [])
    {
        $this->parseContainer($container);
        if (null === $container) {
            $container = $this->getContainer();
        }


        $options = $this->normalizeOptions($options);

        if ($options['onlyActiveBranch'] && !$options['renderParents']) {
            $html = $this->renderDeepestMenu(
                $container,
                $options['ulClass'],
                $options['indent'],
                $options['minDepth'],
                $options['maxDepth'],
                $options['escapeLabels'],
                $options['addClassToListItem'],
                $options['liActiveClass']
            );
        } else {
            $html = $this->renderNormalMenu(
                $container,
                $options['ulClass'],
                $options['indent'],
                $options['minDepth'],
                $options['maxDepth'],
                $options['onlyActiveBranch'],
                $options['escapeLabels'],
                $options['addClassToListItem'],
                $options['liActiveClass']
            );
        }

        return $html;
    }

    /**
     * Renders a normal menu (called from {@link renderMenu()})
     *
     * @param    AbstractContainer $container            container to render
     * @param    string            $ulClass            CSS class for first UL
     * @param    string            $indent             initial indentation
     * @param    int|null            $minDepth            minimum depth
     * @param    int|null            $maxDepth            maximum depth
     * @param    bool                $onlyActive         render only active branch?
     * @param    bool                $escapeLabels        Whether or not to escape the labels
     * @param    bool                $addClassToListItem Whether or not page class applied to <li> element
     * @param    string            $liActiveClass        CSS class for active LI
     * @return string
     */
    protected function renderNormalMenu(
        AbstractContainer $container,
        $ulClass,
        $indent,
        $minDepth,
        $maxDepth,
        $onlyActive,
        $escapeLabels,
        $addClassToListItem,
        $liActiveClass
    ) {
        $html = '';

        // find deepest active
        $found = $this->findActive($container, $minDepth, $maxDepth);
        /* @var $escaper \Zend\View\Helper\EscapeHtmlAttr */
        $escaper = $this->view->plugin('escapeHtmlAttr');

        if ($found) {
            $foundPage    = $found['page'];
            $foundDepth = $found['depth'];
        } else {
            $foundPage = null;
        }

        // create iterator
        $iterator = new RecursiveIteratorIterator(
            $container,
            RecursiveIteratorIterator::SELF_FIRST
        );
        if (is_int($maxDepth)) {
            $iterator->setMaxDepth($maxDepth);
        }

        // iterate container
        $prevDepth = -1;
        foreach ($iterator as $page) {
            $depth = $iterator->getDepth();
            $page->set('level', $depth);
            $isActive = $page->isActive(true);
            if ($depth < $minDepth || !$this->accept($page)) {
                // page is below minDepth or not accepted by acl/visibility
                continue;
            } elseif ($onlyActive && !$isActive) {
                // page is not active itself, but might be in the active branch
                $accept = false;
                if ($foundPage) {
                    if ($foundPage->hasPage($page)) {
                        // accept if page is a direct child of the active page
                        $accept = true;
                    } elseif ($foundPage->getParent()->hasPage($page)) {
                        // page is a sibling of the active page...
                        if (!$foundPage->hasPages(!$this->renderInvisible) ||
                            is_int($maxDepth) && $foundDepth + 1 > $maxDepth) {
                            // accept if active page has no children, or the
                            // children are too deep to be rendered
                            $accept = true;
                        }
                    }
                }

                if (!$accept) {
                    continue;
                }
            }

            // make sure indentation is correct
            $depth -= $minDepth;
            $myIndent = $indent . str_repeat('    ', $depth);
            $attributes = $this->getAttributes();
            if ($depth > $prevDepth) {
                // start new ul tag
                $ulClass = '' . 
                    ($depth == 0 ? $this->getUlClass() : 
                            ($depth == 1 ? $this->getSubUlClassLevel1() : $this->getSubUlClass())
                    ) . 
                    ' level_' . $depth . 
                '';
                if ($ulClass && $depth ==    0) {
                    $ulClass = ' class="' . $escaper($ulClass) . '"';
                } else {
                    $ulClass = ' class="' . $escaper($ulClass) . '"';
                }
                $html .= $myIndent . '<ul' . $ulClass . ' '.($depth == 0 ? $this->htmlAttribs($attributes) : '').'>' . PHP_EOL;
            } elseif ($prevDepth > $depth) {
                // close li/ul tags until we're at current depth
                for ($i = $prevDepth; $i > $depth; $i--) {
                    $ind = $indent . str_repeat('        ', $i);
                    $html .= $ind . '    </li>' . PHP_EOL;
                    $html .= $ind . '</ul>' . PHP_EOL;
                }
                // close previous li tag
                $html .= $myIndent . '    </li>' . PHP_EOL;
            } else {
                // close previous li tag
                $html .= $myIndent . '    </li>' . PHP_EOL;
            }

            // render li tag and page
            $liClasses = [];
            // Is page active?
            if ($isActive) {
                $liClasses[] = $liActiveClass;
            }
            if (!empty($this->getDefaultLiClass())) {
                $liClasses[] = $this->getDefaultLiClass();
            }
            $isBelowMaxLevel = ($maxDepth > $depth) || ($maxDepth === null) || ($maxDepth === false);
            if (!empty($page->pages) && $isBelowMaxLevel) {
                $liClasses[] = ($depth == 0 ? $this->getSubLiClassLevel0() : $this->getSubLiClass());
            }
            // Add CSS class from page to <li>
            if ($addClassToListItem && $page->getClass()) {
                $liClasses[] = $page->getClass();
            }
            $liClass = empty($liClasses) ? '' : ' class="' . $escaper(implode(' ', $liClasses)) . '"';

            $html .= $myIndent . '    <li' . $liClass . '>' . PHP_EOL
                . $myIndent . '        ' . $this->htmlify($page, $escapeLabels, $addClassToListItem) . PHP_EOL;

            // store as previous depth for next iteration
            $prevDepth = $depth;
        }

        if ($html) {
            // done iterating container; close open ul/li tags
            for ($i = $prevDepth+1; $i > 0; $i--) {
                $myIndent = $indent . str_repeat('        ', $i-1);
                $html .= $myIndent . '    </li>' . PHP_EOL
                    . $myIndent . '</ul>' . PHP_EOL;
            }
            $html = rtrim($html, PHP_EOL);
        }

        return $html;
    }

    /**
     * Converts an associative array to a string of tag attributes.
     *
     * Overloads {@link View\Helper\AbstractHtmlElement::htmlAttribs()}.
     *
     * @param    array $attribs    an array where each key-value pair is converted
     *                         to an attribute name and value
     * @return string
     */
    public function htmlAttribs($attribs)
    {
        // filter out null values and empty string values
        // except for "data-" and "aria-" attributes
        foreach ($attribs as $key => $value) {
            if ($value === null || (is_string($value) && !strlen($value))) {
                if ( (strpos($key, "data") === false) && (strpos($key, "aria") === false) ) {
                    unset($attribs[$key]);
                }
            }
        }

        $xhtml          = '';
        $escaper        = $this->getView()->plugin('escapehtml');
        $escapeHtmlAttr = $this->getView()->plugin('escapehtmlattr');

        foreach ((array) $attribs as $key => $val) {
            $key = $escaper($key);

            if (('on' == substr($key, 0, 2)) || ('constraints' == $key)) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    $val = \Zend\Json\Json::encode($val);
                }
            } else {
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
            }

            $val = $escapeHtmlAttr($val);

            if ('id' == $key) {
                $val = $this->normalizeId($val);
            }

            if (strpos($val, '"') !== false) {
                $xhtml .= " $key='$val'";
            } else {
                $xhtml .= " $key=\"$val\"";
            }
        }

        return $xhtml;
    }

    /**
     * Returns an HTML string containing an 'a' element for the given page if
     * the page's href is not empty, and a 'span' element if it is empty
     *
     * Overrides {@link AbstractHelper::htmlify()}.
     *
     * @param    AbstractPage $page                page to generate HTML for
     * @param    bool         $escapeLabel        Whether or not to escape the label
     * @param    bool         $addClassToListItem Whether or not to add the page class to the list item
     * @return string
     */
    public function htmlify(AbstractPage $page, $escapeLabel = true, $addClassToListItem = false)
    {
        $partial = $this->getHtmlifyPartial();
        if ($partial) {
            return $this->renderHtmlifyPartial($page, $escapeLabel, $addClassToListItem, $partial);
        }
        // get attribs for element
        $attribs = [
                'id'     => $page->getId(),
                'title'    => $this->translate($page->getTitle(), $page->getTextDomain()),
        ];
        $classnames = array();
        if ( $addClassToListItem === false ) {
            $class = $page->getClass();
            if (!empty($class)) {
                $classnames[] = $page->getClass();
            }
        }
        $maxDepth = $this->getMaxDepth();
        $depth = $page->get('level');
        $isBelowMaxLevel = ($maxDepth > $depth) || ($maxDepth === null) || ($maxDepth === false);
        if ( !empty($page->pages) && $isBelowMaxLevel ) {
            $classnames[] = 'dropdown-toggle';
            $attribs['data-toggle'] = (($depth == 0) ? $this->getSubLiClassLevel0() : $this->getSubLiClass());
        }
        $attribs['class'] = implode(" ", $classnames);
        
        // does page have a href?
        $href = (
            !empty($page->pages) && !empty($this->getHrefSubToggleOverride()) ?
                $this->getHrefSubToggleOverride() : $page->getHref()
        );
        $element = 'a';
        if ($href) {
            $attribs['href'] = $href;
            $attribs['target'] = $page->getTarget();
        } else {
            $attribs['href'] = '#';
        }
        
        $html    = '<' . $element . $this->htmlAttribs($attribs) . '>';
        $html .= ($page->get('icon') ? '<span class="' . $this->getIconPrefixClass() . '' . $page->get('icon') . '"></span> ' : '' );
        $label = $this->translate($page->getLabel(), $page->getTextDomain());
        if ($escapeLabel === true) {
            /** @var \Zend\View\Helper\EscapeHtml $escaper */
            $escaper = $this->view->plugin('escapeHtml');
            $html .= $escaper($label);
        } else {
            $html .= $label;
        }
        $html .= '</' . $element . '>';
    
        return $html;
    }

    /**
     * Renders the given $page by invoking the partial view helper
     *
     * The container will simply be passed on as a model to the view script
     * as-is, and will be available in the partial script as 'container', e.g.
     * <code>echo 'Number of pages: ', count($this->container);</code>.
     *
     * @param    Page     $container [optional] container to pass to view
     *                                    script. Default is to use the container
     *                                    registered in the helper.
     * @param    string|array    $partial    [optional] partial view script to use.
     *                                    Default is to use the partial
     *                                    registered in the helper. If an array
     *                                    is given, it is expected to contain two
     *                                    values; the partial view script to use,
     *                                    and the module where the script can be
     *                                    found.
     * @return string
     * @throws Exception\RuntimeException if no partial provided
     * @throws Exception\InvalidArgumentException if partial is invalid array
     */
    public function renderHtmlifyPartial(AbstractPage $page, $escapeLabel = true, $addClassToListItem = false, $partial = null)
    {
        if (null === $partial) {
            $partial = $this->getPartial();
        }
    
        if (empty($partial)) {
            throw new Exception\RuntimeException(
                    'Unable to render menu: No partial view script provided'
                    );
        }
        $model = [
            'page' => $page,
            'escapeLabel' => $escapeLabel,
            'addClassToListItem' => $addClassToListItem,
            'menu' => (clone $this),
            
        ];
    
        /** @var \Zend\View\Helper\Partial $partialHelper */
        $partialHelper = $this->view->plugin('partial');
    
        if (is_array($partial)) {
            if (count($partial) != 2) {
                throw new Exception\InvalidArgumentException(
                        'Unable to render menu: A view partial supplied as '
                        .    'an array must contain two values: partial view '
                        .    'script and module where script can be found'
                        );
            }
    
            return $partialHelper($partial[0], $model);
        }
    
        return $partialHelper($partial, $model);
    }
    
    /**
     * @return the $defaultLiClass
     */
    public function getDefaultLiClass() {
        return $this->defaultLiClass;
    }

    /**
     * @param string $defaultLiClass
     */
    public function setDefaultLiClass($defaultLiClass) {
        $this->defaultLiClass = $defaultLiClass;
        return $this;
    }

    /**
     * @return the $subUlClass
     */
    public function getSubUlClass() {
        return $this->subUlClass;
    }

    /**
     * @param string $subUlClass
     */
    public function setSubUlClass($subUlClass) {
        $this->subUlClass = $subUlClass;
        return $this;
    }

    /**
     * @return the $subUlClassLevel1
     */
    public function getSubUlClassLevel1() {
        return $this->subUlClassLevel1;
    }

    /**
     * @param string $subUlClassLevel1
     */
    public function setSubUlClassLevel1($subUlClassLevel1) {
        $this->subUlClassLevel1 = $subUlClassLevel1;
        return $this;
    }

    /**
     * @return the $subLiClass
     */
    public function getSubLiClass() {
        return $this->subLiClass;
    }

    /**
     * @param string $subLiClass
     */
    public function setSubLiClass($subLiClass) {
        $this->subLiClass = $subLiClass;
        return $this;
    }

    /**
     * @return the $subLiClassLevel0
     */
    public function getSubLiClassLevel0() {
        return $this->subLiClassLevel0;
    }
    
    /**
     * @param string $subLiClassLevel0
     */
    public function setSubLiClassLevel0($subLiClassLevel0) {
        $this->subLiClassLevel0 = $subLiClassLevel0;
        return $this;
    }
    
    /**
     * @return the $iconPrefixClass
     */
    public function getIconPrefixClass() {
        return $this->iconPrefixClass;
    }

    /**
     * @param string $iconPrefixClass
     */
    public function setIconPrefixClass($iconPrefixClass) {
        $this->iconPrefixClass = $iconPrefixClass;
        return $this;
    }
    
    /**
     * @return the $hrefSubToggleOverride
     */
    public function getHrefSubToggleOverride() {
        return $this->hrefSubToggleOverride;
    }

    /**
     * @param string $hrefSubToggleOverride
     */
    public function setHrefSubToggleOverride($hrefSubToggleOverride) {
        $this->hrefSubToggleOverride = $hrefSubToggleOverride;
        return $this;
    }

    /**
     * Sets which partial view script to use for rendering menu
     *
     * @param    string|array $partial partial view script or null. If an array is
     *                                given, it is expected to contain two
     *                                values; the partial view script to use,
     *                                and the module where the script can be
     *                                found.
     * @return self
     */
    public function setHtmlifyPartial($partial)
    {
        if (null === $partial || is_string($partial) || is_array($partial)) {
            $this->htmlifyPartial = $partial;
        }
    
        return $this;
    }
    
    /**
     * Returns partial view script to use for rendering menu
     *
     * @return string|array|null
     */
    public function getHtmlifyPartial()
    {
        return $this->htmlifyPartial;
    }
    
    /**
     * Translate a message (for label, title, …)
     *
     * @param    string $message    ID of the message to translate
     * @param    string $textDomain Text domain (category name for the translations)
     * @return string             Translated message
     */
    public function translate($message, $textDomain = null)
    {
        return parent::translate($message, $textDomain);
    }
    
    /**
     * set class names
     * 
     * @param string $classnames
     */
    public function setClassnames($classnames) {
        if ( null !== $classnames ) {
            $this->classnames = $classnames;
        }
        return $this;
    }

    /**
     * check if classname occurs in classnames
     * 
     * @param string $classname
     * @return boolean 
     */
    public function hasClass ($classname) {
        $classname = trim($classname);
        if (!empty($classname)) {
            $classes = explode(" ", $this->getClassnames());
            return in_array($classname, $classes);
        }
        return (false);
    }

    /**
     * add classname to classnames
     * 
     * @param string $classname
     */
    public function addClass ($classname) {
        $classname = trim($classname);
        if (!empty($classname)) {
            $classes = explode(" ", $this->getClassnames());
            if (!in_array($classname, $classes)) {
                $classes[] = $classname;
            }
            $this->setClassnames(implode(" ", $classes));
        }
        return $this;
    }

    /**
     * add classname to classnames
     * 
     * @param string $classname
     */
    public function removeClass ($classname) {
        $classname = trim($classname);
        if (!empty($classname) && $this->hasClass($classname)) {
            $classes = explode(" ", $this->getClassnames());
            foreach ($classes as $idx => $current_class) {
                if ($classname == $current_class) {
                    unset($classes[$idx]);
                }
            }
        }
        return $this;
    }
    
    /**
     * get a single HTML atrributes
     * 
     * @param string $name the attribute to get
     * @return the $attribute 
     */
    public function getAttribute($name) {
        return ( isset($this->attributes[$name]) ? $this->attributes[$name] : null );
    }

    /**
     * set a single HTML attribute
     * 
     * @param string $attribute 
     * @param mixed $value
     */
    public function setAttribute($attribute, $value = "") {
        if ( null !== $attribute ) {
            $this->attributes[$attribute] = $value;
        }
        return $this;
    }

    /**
     * get all attributes
     * 
     * @return the $attributes
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * set attributes
     * 
     * @param array $attributes
     */
    public function setAttributes($attributes) {
        if ( is_array($attributes) ) {
            $this->attributes = array_merge_recursive($this->attributes, $attributes);
        }
        return $this;
    }
    
}