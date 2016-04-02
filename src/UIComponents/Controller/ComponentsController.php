<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * BaseApp
 *
 * @package   [MyApplication]
 * @package   BB's Zend Framework 2 Components
 * @package   BaseApp
 * @author    Björn Bartels <development@bjoernbartels.earth>
 * @link      https://gitlab.bjoernbartels.earth/groups/zf2
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright copyright (c) 2016 Björn Bartels <development@bjoernbartels.earth>
 */

namespace UIComponents\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\BaseActionController;

class ComponentsController extends BaseActionController
{
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $this->setActionTitles(
            array(
                'index' => $this->translate("UI Components"),
                'panels' => $this->translate("Panel Elements"),
                'controls' => $this->translate("Controls"),
                'forms' => $this->translate("Form Elements"),
                'tables' => $this->translate("Tables"),
                'widgets' => $this->translate("Widgets"),
            )
        );
        return parent::onDispatch($e);
    }
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function panelsAction()
    {
        return new ViewModel();
    }
    
    public function controlsAction()
    {
        return new ViewModel();
    }
    
    public function formsAction()
    {
        return new ViewModel();
    }
    
    public function tablesAction()
    {
        return new ViewModel();
    }
    
    public function widgetsAction()
    {
        return new ViewModel();
    }

}
