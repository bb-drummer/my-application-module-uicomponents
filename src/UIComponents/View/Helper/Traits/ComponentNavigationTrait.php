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

namespace UIComponents\View\Helper\Traits;

use Zend\Navigation\AbstractContainer;
use \Zend\Navigation\Page\AbstractPage;
use Admin\View\Helper\Isallowed;

/**
 *
 * @method \Admin\View\Helper\Isallowed isAllowed($resource)
 * @author bba
 *        
 */
trait ComponentNavigationTrait {
	
    /**
     * AbstractContainer to operate on by default
     *
     * @var Navigation\AbstractContainer
     */
    protected $container;

    /**
     * The minimum depth a page must have to be included when rendering
     *
     * @var int
     */
    protected $minDepth;

    /**
     * The maximum depth a page can have to be included when rendering
     *
     * @var int
     */
    protected $maxDepth;

    /**
     * Indentation string
     *
     * @var string
     */
    protected $indent = '';

    /**
     * Whether invisible items should be rendered by this helper
     *
     * @var bool
     */
    protected $renderInvisible = false;

    /**
     * Sets navigation container the helper operates on by default
     *
     * Implements {@link HelperInterface::setContainer()}.
     *
     * @param    string|Navigation\AbstractContainer $container Default is null, meaning container will be reset.
     * @return self
     */
    public function setContainer($container = null)
    {
        //$this->parseContainer($container);
        $this->container = $container;

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
     * @return Navigation\AbstractContainer|Components    navigation container
     */
    public function getContainer()
    {
        if (null === $this->container) {
            $this->container = new \UIComponents\View\Helper\Components();
        }

        return $this->container;
    }

    /**
     * Checks if the helper has a container
     *
     * Implements {@link HelperInterface::hasContainer()}.
     *
     * @return bool
     */
    public function hasContainer()
    {
        return null !== $this->container;
    }

    /**
     * Retrieve whitespace representation of $indent
     *
     * @param    int|string $indent
     * @return string
     */
    protected function getWhitespace($indent)
    {
        if (is_int($indent)) {
            $indent = str_repeat(' ', $indent);
        }

        return (string) $indent;
    }

    /**
     * Set the indentation string for using in {@link render()}, optionally a
     * number of spaces to indent with
     *
     * @param    string|int $indent
     * @return self
     */
    public function setIndent($indent)
    {
        $this->indent = $this->getWhitespace($indent);
        return $this;
    }

    /**
     * Returns indentation
     *
     * @return string
     */
    public function getIndent()
    {
        return $this->indent;
    }

    /**
     * Sets the maximum depth a page can have to be included when rendering
     *
     * @param    int $maxDepth Default is null, which sets no maximum depth.
     * @return self
     */
    public function setMaxDepth($maxDepth = null)
    {
        if (null === $maxDepth || is_int($maxDepth)) {
            $this->maxDepth = $maxDepth;
        } else {
            $this->maxDepth = (int) $maxDepth;
        }

        return $this;
    }

    /**
     * Returns maximum depth a page can have to be included when rendering
     *
     * @return int|null
     */
    public function getMaxDepth()
    {
        return $this->maxDepth;
    }

    /**
     * Sets the minimum depth a page must have to be included when rendering
     *
     * @param    int $minDepth Default is null, which sets no minimum depth.
     * @return self
     */
    public function setMinDepth($minDepth = null)
    {
        if (null === $minDepth || is_int($minDepth)) {
            $this->minDepth = $minDepth;
        } else {
            $this->minDepth = (int) $minDepth;
        }

        return $this;
    }

    /**
     * Returns minimum depth a page must have to be included when rendering
     *
     * @return int|null
     */
    public function getMinDepth()
    {
        if (!is_int($this->minDepth) || $this->minDepth < 0) {
            return 0;
        }

        return $this->minDepth;
    }

    /**
     * Render invisible items?
     *
     * @param    bool $renderInvisible
     * @return self
     */
    public function setRenderInvisible($renderInvisible = true)
    {
        $this->renderInvisible = (bool) $renderInvisible;
        return $this;
    }

    /**
     * Return renderInvisible flag
     *
     * @return bool
     */
    public function getRenderInvisible()
    {
        return $this->renderInvisible;
    }

    /**
     * Finds the deepest active page in the given container
     *
     * @param    Navigation\AbstractContainer $container    container to search
     * @param    int|null             $minDepth    [optional] minimum depth
     *                                            required for page to be
     *                                            valid. Default is to use
     *                                            {@link getMinDepth()}. A
     *                                            null value means no minimum
     *                                            depth required.
     * @param    int|null             $maxDepth    [optional] maximum depth
     *                                            a page can have to be
     *                                            valid. Default is to use
     *                                            {@link getMaxDepth()}. A
     *                                            null value means no maximum
     *                                            depth required.
     * @return array                            an associative array with
     *                                            the values 'depth' and
     *                                            'page', or an empty array
     *                                            if not found
     */
    public function findActive($container, $minDepth = null, $maxDepth = -1)
    {
    	
        if (!is_int($minDepth)) {
            $minDepth = $this->getMinDepth();
        }
        if ((!is_int($maxDepth) || $maxDepth < 0) && null !== $maxDepth) {
            $maxDepth = $this->getMaxDepth();
        }

        $found    = null;
        $foundDepth = -1;
        $iterator = new RecursiveIteratorIterator(
            $container,
            RecursiveIteratorIterator::CHILD_FIRST
        );

        /** @var \Zend\Navigation\Page\AbstractPage $page */
        foreach ($iterator as $page) {
            $currDepth = $iterator->getDepth();
            if ($currDepth < $minDepth || !$this->accept($page)) {
                // page is not accepted
                continue;
            }

            if ($page->isActive(false) && $currDepth > $foundDepth) {
                // found an active page at a deeper level than before
                $found = $page;
                $foundDepth = $currDepth;
            }
        }

        if (is_int($maxDepth) && $foundDepth > $maxDepth) {
            while ($foundDepth > $maxDepth) {
                if (--$foundDepth < $minDepth) {
                    $found = null;
                    break;
                }

                $found = $found->getParent();
                if (!$found instanceof AbstractPage) {
                    $found = null;
                    break;
                }
            }
        }

        if ($found) {
            return ['page' => $found, 'depth' => $foundDepth];
        }

        return [];
    }

    /**
     * Verifies container and eventually fetches it from service locator if it is a string
     *
     * @param    Navigation\AbstractContainer|string|null $container
     * @throws Exception\InvalidArgumentException
     */
    protected function parseContainer(&$container = null)
    {
        if (null === $container) {
            return;
        }

        if (is_string($container)) {
            if (!$this->getServiceLocator()) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Attempted to set container with alias "%s" but no ServiceLocator was set',
                    $container
                ));
            }

            /**
             * Load the navigation container from the root service locator
             *
             * The navigation container is probably located in Zend\ServiceManager\ServiceManager
             * and not in the View\HelperPluginManager. If the set service locator is a
             * HelperPluginManager, access the navigation container via the main service locator.
             */
            $sl = $this->getServiceLocator();
            if ($sl instanceof \Zend\View\HelperPluginManager) {
                //$sl = $sl->getServiceLocator();
            }
            $container = $sl->get($container);
            return;
        }

        if (!$container instanceof \Zend\Navigation\AbstractContainer) {
            throw new    Exception\InvalidArgumentException(
                'Container must be a string alias or an instance of '
                . 'Zend\Navigation\AbstractContainer'
            );
        }
    }

    // Iterator filter methods:

    /**
     * Determines whether a page should be accepted when iterating
     *
     * Default listener may be 'overridden' by attaching listener to 'isAllowed'
     * method. Listener must be 'short circuited' if overriding default ACL
     * listener.
     *
     * Rules:
     * - If a page is not visible it is not accepted, unless RenderInvisible has
     *    been set to true
     * - If $useAcl is true (default is true):
     *        - Page is accepted if listener returns true, otherwise false
     * - If page is accepted and $recursive is true, the page
     *    will not be accepted if it is the descendant of a non-accepted page
     *
     * @param    AbstractPage    $page        page to check
     * @param    bool            $recursive    [optional] if true, page will not be
     *                                        accepted if it is the descendant of
     *                                        a page that is not accepted. Default
     *                                        is true
     *
     * @return    bool                        Whether page should be accepted
     */
    public function accept(AbstractPage $page, $recursive = true)
    {
        $accept = true;

        if (!$page->isVisible(false) && !$this->getRenderInvisible()) {
            $accept = false;
        } elseif ($this->getUseAcl()) {
            $acl = $this->getAcl();
            $role = $this->getRole();
            $params = ['acl' => $acl, 'page' => $page, 'role' => $role];
            $accept = $this->isAllowed($params);
        }

        if ($accept && $recursive) {
            $parent = $page->getParent();

            if ($parent instanceof AbstractPage) {
                $accept = $this->accept($parent, true);
            }
        }

        return $accept;
    }

    /**
     * Get the service locator.
     *
     * @abstract
     * @return ServiceLocatorInterface
     */
    abstract public function getServiceLocator();
    
    /**
     * Returns ACL or null if it isn't set using {@link setAcl()} or
     * {@link setDefaultAcl()}
     *
     * Implements {@link HelperInterface::getAcl()}.
     *
     * @return Acl\AclInterface|null    ACL object or null
     */
    abstract public function getAcl();
    
    /**
     * Returns whether ACL should be used
     *
     * Implements {@link HelperInterface::getUseAcl()}.
     *
     * @return bool
     */
    abstract public function getUseAcl();

    /**
     * Returns ACL role to use when iterating pages, or null if it isn't set
     * using {@link setRole()} or {@link setDefaultRole()}
     *
     * Implements {@link HelperInterface::getRole()}.
     *
     * @return string|Acl\Role\RoleInterface|null
     */
    abstract public function getRole();
    
}

?>