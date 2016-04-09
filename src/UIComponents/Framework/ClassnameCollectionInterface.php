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
 * abstract UI framework classname collection interface
 *        
 */
interface ClassnameCollectionInterface {
	
	/** @var  string  $framework  framework names, these classnames are related to */
	public static $framework = "";
	
	/** @var  string  $version  framework version, these classnames are related to */
	public static $version = "0.0";
	
	/** @var  array  $size  generic sizes */
	public static $size = array();
	
	/** @var  array  $column  generic column classname */
	public static $column = "";
	/** @var  array  $columnsize  column sizes classnames*/
	public static $columnsize = array();
	
	/** @var  array  $status  status related classnames */
	public static $status = array();
	
	/** @var  array  $panel  panel related classnames */
	public static $panel = array();
	
	/** @var  array  $control  control related classnames */
	public static $control = array();
	
	/** @var  array  $form  form generation related classnames */
	public static $form = array();
	
	/** @var  array  $table  table related classnames */
	public static $table = array();
	
	/** @var  array  $widget  widgets' classnames */
	public static $widget = array();
	
}
