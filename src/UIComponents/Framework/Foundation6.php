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
 * Zurb Foundation v6 - UI framework classname collection
 *        
 */
class Foundation6 extends ClassnameCollectionAbstract {
	
	/** @var  string  $framework  framework names, these classnames are related to */
	public $framework = "Foundation";
	
	/** @var  string  $version  framework version, these classnames are related to */
	public $version = "6.1.2";
	
	/** @var  array  $size  generic sizes */
    public $size = array(
        "xs"    => "tiny",
        "s"     => "small",
        "m"     => "medium",
        "l"     => "large",
        "xl"    => "xlarge",
    );
    
	/** @var  array  $column  generic column classname */
    public $column = "columns";
	/** @var  array  $columnsize  column sizes classnames*/
    public $columnsize = array(
        "xs"    => "tiny-",
        "s"     => "small-",
        "m"     => "medium-",
        "l"     => "large-",
        "xl"    => "xlargel-",
    );
    
	/** @var  array  $status  status related classnames */
    public $status = array(
        "default"    => "",
        "info"       => "info",
        "success"    => "success",
        "primary"    => "primary",
        "warning"    => "warning",
        "error"      => "alert",
    );
    
	/** @var  array  $panel  panel related classnames */
    public $panel = array(
        "prefix"     => "panel-",
        "wrapper"    => "panel",
        "header"     => "panel-header",
        "body"       => "panel-body",
        "footer"     => "panel-footer",
    );
    
	/** @var  array  $control  control related classnames */
    public $control = array(
        "button" => array(
            "prefix"     => "button-",
            "button"     => "button",
        ),
        "buttongroup" => array(
            "wrapper"    => "button-group",
        ),
    );
    
	/** @var  array  $form  form generation related classnames */
    public $form = array(
        "formgroup" => array(
            "wrapper"    => "form-group",
        ),
    );
    
	/** @var  array  $table  table related classnames */
    public $table = array(
    );
    
	/** @var  array  $widget  widgets' classnames */
    public $widget = array(
        "navigation" => array(
            "wrapper" => "top-bar",
            "main" => array(
                "ULclass" => "dropdown menu top-bar-left",
            ),
            "sidebar" => array(
                "ULclass" => "sidebar sidebar-nav",
            ),
            "lang" => array(
                "ULclass" => "dropdown menu top-bar-right",
            ),
            "userprofile" => array(
                "ULclass" => "dropdown menu top-bar-right",
            ),
        ),
        "breadcrumbs" => array(
            "ULclass" => "breadcrumb",
        ),
        "toolbar" => array(
            "ULclass" => "toolbar",
        ),
    );
		
}

?>