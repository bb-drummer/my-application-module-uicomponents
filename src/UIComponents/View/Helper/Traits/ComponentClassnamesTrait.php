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

/**
 *
 * @author bba
 *        
 */
trait ComponentClassnamesTrait {

	/**
     * component's class-names
     *
     * @var string
     */
    protected $classnames = '';
    
    /**
     * get class names
     * 
     * @return string the $classnames
     */
    public function getClassnames() {
        return $this->classnames;
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
    
}

?>