<?php
/**
 * BB's Zend Framework 2 Components
 * 
 * TwitterBootstrap API
 *
 * @package		[MyApplication]
 * @package		BB's Zend Framework 2 Components
 * @package		TwitterBootstrap API
 * @author		Björn Bartels <development@bjoernbartels.earth>
 * @link		https://gitlab.bjoernbartels.earth/groups/zf2
 * @license		http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @copyright	copyright (c) 2016 Björn Bartels <development@bjoernbartels.earth>
 */

return array(
	'controllers' => array(
		'invokables' => array(
			//'Yourmodname\Controller\Index' => 'Yourmodname\Controller\IndexController',
		),
	),
	'router' => array(
		'routes' => array( /*
			'yourmodname' => array(
				'type'	=> 'Literal',
				'options' => array(
					// Change this to something specific to your module
					'route'	=> '/yourmodname',
					'defaults' => array(
						// Change this value to reflect the namespace in which
						// the controllers for your module are found
						'__NAMESPACE__' => 'Yourmodname\Controller',
						'controller'	=> 'Index',
						'action'		=> 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					// This route is a sane default when developing a module;
					// as you solidify the routes for your module, however,
					// you may want to remove it and replace it with more
					// specific routes.
					'default' => array(
						'type'	=> 'Segment',
						'options' => array(
							'route'	=> '/[:controller[/:action]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'	 => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' => array(
							),
						),
					),
				),
			),
		*/ ),
	),
	'service_manager' => array(
		'abstract_factories' => array(
		),
		'factories' => array(
			'toolbarnavigation' => 'UIComponents\Navigation\Service\ToolbarNavigationFactory',
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
);
