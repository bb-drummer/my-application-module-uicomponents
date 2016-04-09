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

namespace UIComponents\View\Helper\Components;

use Zend\View\HelperPluginManager;
use Locale;

class Languagemenu extends \UIComponents\View\Helper\AbstractHelper

{
    
    /**
     * @var Detector $detector
     */
    protected $detector;

    /**
     * Set the class to be used on the list container
     *
     * @var string || null
     */
    protected $class;

    /**
     * Method used to construct a title for each item
     *
     * @var string || null
     */
    protected $titleMethod = 'displayLanguage';

    /**
     * Flag to specify specifies whether the title should be in the current locale
     *
     * @var boolean default false
     */
    protected $titleInCurrentLocale = false;

    /**
     * Method used to construct a label for each item
     *
     * @var string || null
     */
    protected $labelMethod = 'displayLanguage';

    /**
     * Flag to specify specifies whether the label should be in the current locale
     *
     * @var boolean default true
     */
    protected $labelInCurrentLocale = true;

    /**
     * Flag to specify the current locale should be omitted from the menu
     *
     * @var boolean default false
     */
    protected $omitCurrent = false;

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

    /**
     * @param Detector $detector
     */
    public function setDetector($detector)
    {
        $this->detector = $detector;
        return $this;
    }

    /**
     * @return Detector $detector
     */
    public function getDetector()
    {
        if (!$this->detector) {
            $serviceLocator = $this->getServiceLocator();
            if ($serviceLocator instanceof HelperPluginManager) {
                $serviceLocator = $serviceLocator->getServiceLocator();
            }
            $this->detector = $serviceLocator->get('SlmLocale\Locale\Detector');
        }
        return $this->detector;
    }

    /**
     * @param string $class
     */
    public function setUlClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * @return string
     */
    public function getUlClass()
    {
        return $this->class;
    }

    /**
     * @param string $itemTitleMethod
     */
    public function setTitleMethod($titleMethod)
    {
        $this->checkLocaleMethod($titleMethod);

        $this->titleMethod = $titleMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitleMethod()
    {
        return $this->titleMethod;
    }

    /**
     * @param boolean $flag
     */
    public function setTitleInCurrentLocale($flag)
    {
        $this->titleInCurrentLocale = (bool) $flag;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getTitleInCurrentLocale()
    {
        return $this->titleInCurrentLocale;
    }

    /**
     * @param string $labelMethod
     */
    public function setLabelMethod($labelMethod)
    {
        $this->checkLocaleMethod($labelMethod);

        $this->labelMethod = $labelMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelMethod()
    {
        return $this->labelMethod;
    }

    /**
     * @param boolean $flag
     */
    public function setLabelInCurrentLocale($flag)
    {
        $this->labelInCurrentLocale = (bool) $flag;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getLabelInCurrentLocale()
    {
        return $this->labelInCurrentLocale;
    }

    /**
     * @param boolean $omitCurrent
     */
    public function setOmitCurrent($omitCurrent)
    {
        $this->omitCurrent = (bool) $omitCurrent;
        return $this;
    }

    /**
     * @return boolean
     */
    public function omitCurrent()
    {
        return $this->omitCurrent;
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
     * build markup
     *
     * @return string
     */
    public function buildComponent()
    {    
        if (!($detector = $this->getDetector())) {
            throw new RuntimeException('To assemble an url, a detector is required');
        }

        $class = $this->getUlClass();
        $liclass = $this->getSubLiClassLevel0();
        $subulclass = $this->getSubUlClassLevel1();
        $iconprefixclass = $this->getIconPrefixClass();

        $list     = '';
        $current  = Locale::getDefault();
        foreach($detector->getSupported() as $locale) {
            if ($this->omitCurrent() && $current === $locale) {
                continue;
            }

            $titleLocale = $this->getTitleInCurrentLocale() ? $locale : $current;
            $labelLocale = $this->getLabelInCurrentLocale() ? $locale : $current;

            $url   = $this->getView()->localeUrl($locale);
            $title = $this->getLocaleProperty($this->getTitleMethod(), $locale, $titleLocale);
            $label = $this->getLocaleProperty($this->getLabelMethod(), $locale, $labelLocale);
            $primary = $this->getLocaleProperty('primaryLanguage', $locale, true);
            $displayName = $this->getLocaleProperty('displayName', $locale, $labelLocale);

            $item = sprintf(
                '<li><a href="%s" title="%s"%s>%s</a></li>' . "\n",
                $url,
                $displayName,
                ($current === $locale) ? ' class="active"' : '',
                (($iconprefixclass) ? '<span class="' . $iconprefixclass . $primary . '"></span> ' : '') . $label
            );

            $list .= $item;
        }
        $attributes = $this->getAttributes();
        $html  = 
            '<ul'.(($class) ? sprintf(' class="%s"', $class) : '').' '.($this->htmlAttribs($attributes)).'>'.
                '<li'.(($liclass) ? sprintf(' class="%s"', $liclass) : '').'>'.
                    '<a href="" class="'.(($liclass) ? $liclass.'-toggle' : '').'" data-toggle="'.(($liclass) ? $liclass : '').'" role="button" aria-haspopup="true" aria-expanded="false" title="'.Locale::getDisplayName(null).'">'.
                        '<span class="'.(($iconprefixclass) ? $iconprefixclass : '').Locale::getPrimaryLanguage(null).'"></span> '.
                        ''.Locale::getDisplayLanguage(null). // ' - '.Locale::getDefault().' - '.Locale::getPrimaryLanguage(null).''.
                        '<span class="caret"></span>'.
                    '</a>'.
                       sprintf(
                        '<ul%s>%s</ul>',
                        ($subulclass) ? sprintf(' class="%s"', $subulclass) : '',
                        $list
                       ).
                   '</li>'.
            '</ul>'
        ;

        return $html;
        
        return '<h2>'.__CLASS__.'</h2>';
    }
    
    /**
     * Check whether method part of the Locale class is
     *
     * @param  string $method Method to check
     * @throws RuntimeException If method is not part of locale
     * @return true
     */
    protected function checkLocaleMethod($method)
    {
        $options = array(
                'displayLanguage',
                'displayName',
                'displayRegion',
                'displayScript',
                'displayVariant',
                'primaryLanguage',
                'region',
                'script'
        );
    
        if (!in_array($method, $options)) {
            throw new RuntimeException(sprintf(
                    'Unknown method "%s" for Locale, expecting one of these: %s.',
                    $method,
                    implode(', ', $options)
            ));
        }
    }
    
    /**
     * Retrieves a value by property from Locale
     *
     * @param $property
     * @param $locale
     * @param bool $in_locale
     * @return mixed
     */
    protected function getLocaleProperty($property, $locale, $in_locale = false)
    {
        $callback = sprintf('\Locale::get%s', ucfirst($property));
    
        $args = array($locale);
    
        if ($in_locale && !in_array($property, array('primaryLanguage', 'region', 'script'))) {
            $args[] = $in_locale;
        }
    
        return call_user_func_array($callback, $args);
    }
    
}