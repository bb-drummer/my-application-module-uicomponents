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

/**
 *
 * render nothing
 *
 */
class Formgroup extends Void
{
	protected $tagname = 'div';
	
	protected $classnames = 'form-group';
	
	protected $form = null;
	
	/**
	 * View helper entry point:
	 * Retrieves helper and optionally sets component options to operate on
	 *
	 * @param  array|StdClass $formoptions [optional] component options to operate on
	 * @param  string $field [optional] component options to operate on
	 * @return self
	 */
	public function __invoke($formoptions = array(), $field = null) {
		parent::__invoke(array());
		$form = null; 
		$field = null;
		if ( !is_array($formoptions) && ($formoptions instanceof \Zend\Form\Form) && (func_num_args() == 2) ) {
			$form	= $formoptions;
			$field	= func_get_arg(1);
		} else if ( isset($formoptions["form"]) && isset($formoptions["field"]) && ($formoptions["form"] instanceof \Zend\Form\Form) ) {
			$form	= $formoptions["form"];
			$field	= $formoptions["field"];
		} else
		if ( !($form instanceof \Zend\Form\Form) || empty($field) ) {
			return "";
		}
		$this->setForm($form);
		
		if ( is_string($field) ) {
			$field = $form->get($field);
			if (!$field) {
				return "";
			}
		} else if ( !($field instanceof \Zend\Form\Element) ) {
			return "";
		}
		if ( !empty($this->getView()->formElementErrors($field)) ) {
			$this->addClass('has-error');
		}
		$this->setHeader( $this->getView()->formLabel($field) );
		if ( $field->getAttribute('type') == 'select' ) {
			$this->setContent( $this->getView()->formSelect($field->setAttributes(array('class' => 'form-control'))) );
		} else {
			$this->setContent( $this->getView()->formInput($field->setAttributes(array('class' => 'form-control'))) );
		}
		$this->setFooter( $this->getView()->formElementErrors($field) );
		
		$component = clone $this;
		return $component;
	}
	
	/**
	 * @return the $form
	 */
	public function getForm() {
		return $this->form;
	}

	/**
	 * @param field_type $form
	 */
	public function setForm($form) {
		$this->form = $form;
		return ($this);
	}

	
	
}