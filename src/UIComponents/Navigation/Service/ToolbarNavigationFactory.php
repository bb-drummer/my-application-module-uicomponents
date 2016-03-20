<?php
namespace UIComponents\Navigation\Service;

class ToolbarNavigationFactory extends \Zend\Navigation\Service\ConstructedNavigationFactory 
{
	/**
	 * @var string|\Zend\Config\Config|array
	 */
	protected $config;

	
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getName()
	{
		return 'toolbarnavigation';
	}

}