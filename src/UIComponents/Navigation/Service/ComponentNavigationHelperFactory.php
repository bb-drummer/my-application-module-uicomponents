<?php
namespace UIComponents\Navigation\Service;

class ComponentNavigationHelperFactory extends \Zend\Navigation\Service\ConstructedNavigationFactory 
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
        return 'componentnavigationhelper';
    }

}