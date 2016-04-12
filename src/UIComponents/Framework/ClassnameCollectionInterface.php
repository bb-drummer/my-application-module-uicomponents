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
	public $framework = "";
	
	/** @var  string  $version  framework version, these classnames are related to */
	public $version = "0.0";
	
	/** @var  array  $size  generic sizes */
	public $size = array();
	
	/** @var  array  $column  generic column classname */
	public $column = "";
	/** @var  array  $columnsize  column sizes classnames*/
	public $columnsize = array();
	
	/** @var  array  $status  status related classnames */
	public $status = array();
	
	/** @var  array  $panel  panel related classnames */
	public $panel = array();
	
	/** @var  array  $control  control related classnames */
	public $control = array();
	
	/** @var  array  $form  form generation related classnames */
	public $form = array();
	
	/** @var  array  $table  table related classnames */
	public $table = array();
	
	/** @var  array  $widget  widgets' classnames */
	public $widget = array();
	
}
