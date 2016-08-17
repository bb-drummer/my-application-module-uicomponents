<?php

namespace UIComponentsTest;

use ApplicationTest\Bootstrap as ApplicationTestBootstrap;
use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap extends ApplicationTestBootstrap
{
/*    protected static $serviceManager;
*/
    public static function init()
    {
        $zf2ModulePaths = array(dirname(dirname(__DIR__)));
        if (($path = static::findParentPath('vendor'))) {
            $zf2ModulePaths[] = $path;
        }
        if (($path = static::findParentPath('module')) !== $zf2ModulePaths[0]) {
            $zf2ModulePaths[] = $path;
        }

        static::initAutoloader();

        // use ModuleManager to load this module and it's dependencies
        $config = array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths,
            ),
            'modules' => array(
                'Application',
                'Admin',
                'UIComponents',
            )
        );

        $config = array_merge_recursive(static::getApplicationConfig(), $config);
        
        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }
/*
    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        chdir($rootPath);
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (file_exists($vendorPath.'/autoload.php')) {
            include $vendorPath.'/autoload.php';
        }

        if (! class_exists('Zend\Loader\AutoloaderFactory')) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install`'
            );
        }

        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }

    protected static function getApplicationConfig()
    {
        $applicationGlobalConfigFile    = __DIR__ . '/../../../config/application.config.php';
        $genericGlobalConfigFile    = __DIR__ . '/../../../config/autoload/global.php';
        
        $localConfigs = array();
        $files = scandir(__DIR__ . '/../../../config/autoload/');
        
        foreach ($files as $key => $filename) {
            $filepath = __DIR__ . '/../../../config/autoload/' . $filename ;
            if ((strpos($filename, 'local.php') !== false) && is_readable($filepath) ) { 
                array_merge_recursive($localConfigs, include $filepath);
            }
        }
        
        // load setting from DB...
        
        return array_merge_recursive(
            ( is_readable($applicationGlobalConfigFile) ? include $applicationGlobalConfigFile : array() ),
            ( is_readable($genericGlobalConfigFile) ? include $genericGlobalConfigFile : array() ),
            $localConfigs
        );
    }
*/
}

Bootstrap::init();
Bootstrap::chroot();

