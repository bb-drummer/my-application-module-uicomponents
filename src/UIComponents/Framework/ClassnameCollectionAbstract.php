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

namespace UIComponents\Framework;

/**
 * abstract UI framework classname collection
 *        
 */
abstract class ClassnameCollectionAbstract implements ClassnameCollectionInterface {
	
	/** @var  string  $framework  framework names, these classnames are related to */
	public static $framework = "Bootstrap";
	
	/** @var  string  $version  framework version, these classnames are related to */
	public static $version = "3.3.0";
	
	/** @var  array  $size  generic sizes */
	public static $size = array(
        "xs"    => "xs",
        "s"     => "s",
        "m"     => "m",
        "l"     => "l",
        "xl"    => "xl",
    );
    
	/** @var  array  $column  generic column classname */
    public static $column = "columns";
	/** @var  array  $columnsize  column sizes classnames*/
    public static $columnsize = array(
        "xs"    => "col-xs-",
        "s"     => "col-s-",
        "m"     => "col-m-",
        "l"     => "col-l-",
        "xl"    => "col-xl-",
    );
    
	/** @var  array  $status  status related classnames */
    public static $status = array(
        "default"    => "default",
        "info"       => "info",
        "success"    => "success",
        "primary"    => "primary",
        "warning"    => "warning",
        "error"      => "error",
    );
    
	/** @var  array  $panel  panel related classnames */
    public static $panel = array(
        "prefix"     => "panel-",
        "wrapper"    => "panel",
        "header"     => "panel-header",
        "body"       => "panel-body",
        "footer"     => "panel-footer",
    );
    
	/** @var  array  $control  control related classnames */
    public static $control = array(
        "button" => array(
            "prefix"    => "btn-",
            "button"    => "btn",
        ),
        "buttongroup" => array(
            "wrapper"    => "btn-group",
        ),
    );
    
	/** @var  array  $form  form generation related classnames */
    public static $form = array(
        "formgroup" => array(
            "wrapper"    => "form-group",
        ),
    );
    
	/** @var  array  $table  table related classnames */
    public static $table = array(
    );
    
	/** @var  array  $widget  widgets' classnames */
    public static $widget = array(
        "navigation" => array(
            "wrapper" => "navbar navbar-inverse",
            "main" => array(
                "ULclass" => "nav navbar-nav",
            ),
            "sidebar" => array(
                "ULclass" => "sidebar sidebar-nav",
            ),
            "lang" => array(
                "ULclass" => "nav navbar-nav navbar-right",
            ),
            "userprofile" => array(
                "ULclass" => "nav navbar-nav navbar-right",
            ),
        ),
        "breadcrumbs" => array(
            "ULclass" => "breadcrumb nav-breadcrumb",
        ),
        "toolbar" => array(
            "ULclass" => "toolbar",
        ),
    );
    
   	/**
	 * create classname collection object
	 * @see \Zend\Config\Config
	 */
	public function __contruct() {
	    return new \Zend\Config\Config( get_object_vars($this) );
	}
		
}
