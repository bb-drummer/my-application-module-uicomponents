<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * UI Components
 *
 * @package		[MyApplication]
 * @package		BB's Zend Framework 2 Components
 * @package		UI Components
 * @author		Björn Bartels <development@bjoernbartels.earth>
 * @link		https://gitlab.bjoernbartels.earth/groups/zf2
 * @license		http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright	copyright (c) 2016 Björn Bartels <development@bjoernbartels.earth>
 */

namespace UIComponents\View\Helper\Components;

use \RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 *
 * Helper for rendering 'Bootstrap' 
 * 
 * @see \UIComponents\View\Helper\Navigation\Menu
 */
class Toolbar extends \UIComponents\View\Helper\Navigation\Menu // implements ServiceLocatorAwareInterface
{
	//use ServiceLocatorAwareTrait;
	
	/**
	 * component's tag-name
	 *
	 * @var string
	 */
	protected $tagname = 'div';
	
	/**
	 * component's class-names
	 *
	 * @var string
	 */
	protected $classnames = 'toolbar toolbar-default callout small';
	
	/**
	 * component's attributes
	 *
	 * @var array
	 */
	protected $attributes = array();
	
	/**
	 * component's size attributes
	 *
	 * @var string|array
	 */
	protected $size = '';
	
	/**
	 * AbstractContainer to operate on by default
	 *
	 * @var Navigation\AbstractContainer
	 */
	protected $container;

	/**
	 * View helper entry point:
	 * Retrieves helper and optionally sets container to operate on
	 *
	 * @param  AbstractContainer $container [optional] container to operate on
	 * @return self
	 */
	public function __invoke($container = null)
	{
		if (null !== $container) {
			$this->setContainer($container);
		}

		return (clone $this);
	}
	
	/**
	 * Renders a normal menu (called from {@link renderMenu()})
	 *
	 * @param	AbstractContainer $container			container to render
	 * @param	string			$ulClass			CSS class for first UL
	 * @param	string			$indent			 initial indentation
	 * @param	int|null			$minDepth			minimum depth
	 * @param	int|null			$maxDepth			maximum depth
	 * @param	bool				$onlyActive		 render only active branch?
	 * @param	bool				$escapeLabels		Whether or not to escape the labels
	 * @param	bool				$addClassToListItem Whether or not page class applied to <li> element
	 * @param	string			$liActiveClass		CSS class for active LI
	 * @return string
	 */
	protected function renderNormalMenu(
		\Zend\Navigation\AbstractContainer $container,
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
			$foundPage	= $found['page'];
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
			$myIndent = $indent . str_repeat('	', $depth);

			if ($depth > $prevDepth) {
				// start new ul tag
				$ulClass = '' . 
					($depth == 0 ? $this->getUlClass() : 
							($depth == 1 ? $this->getSubUlClassLevel1() : $this->getSubUlClass())
					) . 
					' level_' . $depth . 
				'';
				if ($ulClass && $depth ==	0) {
					$ulClass = ' class="' . $escaper($ulClass) . '"';
				} else {
					$ulClass = ' class="' . $escaper($ulClass) . '"';
				}
				$html .= $myIndent . '<' . $this->getTagname() . $ulClass . '>' . PHP_EOL;
			} elseif ($prevDepth > $depth) {
				// close li/ul tags until we're at current depth
				for ($i = $prevDepth; $i > $depth; $i--) {
					$ind = $indent . str_repeat('		', $i);
					//$html .= $ind . '	</li>' . PHP_EOL;
					$html .= $ind . '</' . $this->getTagname() . '>' . PHP_EOL;
				}
				// close previous li tag
				//$html .= $myIndent . '	</li>' . PHP_EOL;
			} else {
				// close previous li tag
				//$html .= $myIndent . '	</li>' . PHP_EOL;
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

			$html .= /* $myIndent . '	<li' . $liClass . '>' . PHP_EOL
				. */ $myIndent . '		' . $this->htmlify($page, $escapeLabels, $addClassToListItem) . PHP_EOL;

			// store as previous depth for next iteration
			$prevDepth = $depth;
		}

		if ($html) {
			// done iterating container; close open ul/li tags
			for ($i = $prevDepth+1; $i > 0; $i--) {
				$myIndent = $indent . str_repeat('		', $i-1);
				$html .= /*$myIndent . '	</li>' . PHP_EOL
					. */ $myIndent . '</' . $this->getTagname() . '>' . PHP_EOL;
			}
			$html = rtrim($html, PHP_EOL);
		}

		return $html;
	}
	
	//
	// component related getters/setters
	//
	
	/**
	 * @return the $tagname
	 */
	public function getTagname() {
		return $this->tagname;
	}

	/**
	 * @param string $tagname
	 */
	public function setTagname($tagname) {
		if ( null !== $tagname ) {
			$this->tagname = $tagname;
		}
		return $this;
	}

}