<?php
namespace UIComponentsTest;

use UIComponentsTest\Framework\TestCase as UIComponentsTestCase;
use phpDocumentor\Reflection\Types\This;
use Zend\Di\ServiceLocator as ZendServiceLocator;

/**
 * [MyApplication] UIComponents module tests
 *
 * @package   [MyApplication]
 * @package   BB's Zend Framework 2 Components
 * @package   AdminModule
 * @author    Björn Bartels <coding@bjoernbartels.earth>
 * @link      https://gitlab.bjoernbartels.earth/groups/zf2
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright copyright (c) 2016 Björn Bartels <coding@bjoernbartels.earth>
 */
class UIComponentsTest extends UIComponentsTestCase
{

    public function testLocator()
    {
    	$this->setLocator( new ZendServiceLocator );
        $this->assertInstanceOf('Zend\Di\LocatorInterface', $this->getLocator());
    }
}
