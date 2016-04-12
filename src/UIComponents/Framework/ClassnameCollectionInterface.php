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
	public $framework;
	
	/** @var  string  $version  framework version, these classnames are related to */
	public $version;
	
	/** @var  array  $size  generic sizes */
	public $size;
	
	/** @var  array  $column  generic column classname */
	public $column;
	
	/** @var  array  $columnsize  column sizes classnames*/
	public $columnsize;
	
	/** @var  array  $status  status related classnames */
	public $status;
	
	/** @var  array  $panel  panel related classnames */
	public $panel;
	
	/** @var  array  $control  control related classnames */
	public $control;
	
	/** @var  array  $form  form generation related classnames */
	public $form;
	
	/** @var  array  $table  table related classnames */
	public $table;
	
	/** @var  array  $widget  widgets' classnames */
	public $widget;
	
}
