<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * UI Components module configuration
 *
 * @package     [MyApplication]
 * @subpackage  BB's Zend Framework 2 Components
 * @subpackage  UI Components
 * @author      Björn Bartels <coding@bjoernbartels.earth>
 * @link        https://gitlab.bjoernbartels.earth/groups/zf2
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright   copyright (c) 2016 Björn Bartels <coding@bjoernbartels.earth>
 */

return array(
    'controllers' => array(
        'factories' => array(
            'UIComponents\Controller\Components' => 'UIComponents\Factory\ComponentsControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'uicomponentstestpages' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/uicomponents-testpages',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'UIComponents\Controller',
                        'controller'    => 'UIComponents\Controller\Components',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'components',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
        ),
        'factories' => array(
            'componentnavigationhelper' => 'UIComponents\Navigation\Service\ComponentNavigationHelperFactory',
        ),
        'invokables' => array(
        ),
        'aliases' => array(
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'UIComponents' => __DIR__ . '/../view',
        ),
    ),
        
    'navigation' => array(
        'default' => array(
            'home' => array(
                'pages' => array(
                    array(
                        'label'      => 'UI components tests',
                        'icon'       => 'cubes',
                        'route'      => 'uicomponentstestpages/default',
                        'pages' => array(
                            array(
                                'label'      => 'panels',
                                'icon'       => 'desktop',
                                'route'      => 'uicomponentstestpages/default',
                                'action'     => 'panels',
                            ),
                            array(
                                'label'      => 'controls',
                                'icon'       => 'gamepad',
                                'route'      => 'uicomponentstestpages/default',
                                'action'     => 'controls',
                            ),
                            array(
                                'label'      => 'forms',
                                'icon'       => 'server',
                                'route'      => 'uicomponentstestpages/default',
                                'action'     => 'forms',
                            ),
                            array(
                                'label'      => 'tables',
                                'icon'       => 'table',
                                'route'      => 'uicomponentstestpages/default',
                                'action'     => 'tables',
                            ),
                            array(
                                'label'      => 'widgets',
                                'icon'       => 'pie-chart',
                                'route'      => 'uicomponentstestpages/default',
                                'action'     => 'widgets',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
);
