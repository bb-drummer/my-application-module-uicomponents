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
trait ComponentAttributesTrait {

    /**
     * component's attributes
     *
     * @var array
     */
    protected $attributes = array();
    
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

        $xhtml = '';
        $oView = $this->getView();
        $escaper        = function ($val) { return $val; };
        $escapeHtmlAttr = function ($val) { return $val; };
        if ( ($oView instanceof \Zend\View\Renderer\RendererInterface) ) {
            $escaper        = $oView->plugin('escapehtml');
            $escapeHtmlAttr = $oView->plugin('escapehtmlattr');
        }
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

}

?>