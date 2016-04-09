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

namespace UIComponents\Navigation;

use Zend\Navigation\AbstractContainer as ZendNavigationAbstractContainer;

/**
 * components' container class for {@link Zend\Navigation\Page} pages
 */
class Navigation extends ZendNavigationAbstractContainer
{
    /**
     * Creates a new navigation container
     *
     * @param  array|Traversable $pages    [optional] pages to add
     * @throws Exception\InvalidArgumentException  if $pages is invalid
     */
    public function __construct($pages = null)
    {
        if ($pages && (!is_array($pages) && !$pages instanceof Traversable)) {
            throw new Exception\InvalidArgumentException(
                'Invalid argument: $pages must be an array, an '
                . 'instance of Traversable, or null'
            );
        }

        if ($pages) {
            $this->addPages($pages);
        }
    }
}
