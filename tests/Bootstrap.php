<?php

/**
 * Almost all of the testing code and logic, including how to structure
 * the tests and how to test a service came from the neilime/zf2-assets-bundle
 * project.
 *
 * All credit should go to those contributors.
 *
 * @link https://github.com/neilime/zf2-assets-bundle
 */



namespace ShoppingCartTest;

error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

// Composer autoloading
if (! file_exists($sComposerAutoloadPath = __DIR__ . '/../vendor/autoload.php')) {
    throw new \RuntimeException('Composer autoload file "' . $sComposerAutoloadPath . '" does not exist');
}
if (false === (include $sComposerAutoloadPath)) {
    throw new \RuntimeException('An error occured while including composer autoload file "' . $sComposerAutoloadPath . '"');
}

class Bootstrap {

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected static $serviceManager;

    /**
     * @var array
     */
    protected static $config;

    /**
     * Initialize bootstrap
     */
    public static function init() {
        //Load the user-defined test configuration file, if it exists;
        $aTestConfig = include is_readable(__DIR__ . '/TestConfig.php') ? __DIR__ . '/TestConfig.php' : __DIR__ . '/TestConfig.php.dist';
        $aZf2ModulePaths = array();
        if (isset($aTestConfig['module_listener_options']['module_paths'])) {
            foreach ($aTestConfig['module_listener_options']['module_paths'] as $sModulePath) {
                if (($sPath = static::findParentPath($sModulePath))) {
                    $aZf2ModulePaths[] = $sPath;
                }
            }
        }


        //Use ModuleManager to load this module and it's dependencies
        static::$config = \Zend\Stdlib\ArrayUtils::merge(array(
                    'module_listener_options' => array(
                        'module_paths' => $aZf2ModulePaths
                    )
                        ), $aTestConfig);

        /*
         * Because a lot of our tests rely on newly creating
         * services, with often different parameters in order
         * to test their behaviour, I am going set "shared_by_default"
         * to false.  This will cause the service manager to always
         * execute a new initialiser for any service.
         *
         * While this should assist testing, it is not how we
         * would be configured in an application environment, so
         * it may cause invalid test results.  However at this time
         * it seems like the better option.
         */
        $smconfig = new \Zend\Mvc\Service\ServiceManagerConfig();
        $mergedconfig = array_merge($smconfig->toArray(), array(
         														'shared_by_default' => false,
							        						));
        static::$serviceManager = new \Zend\ServiceManager\ServiceManager($mergedconfig);
        static::$serviceManager->setService('ApplicationConfig', static::$config);

        $modulemanager = static::$serviceManager->get('ModuleManager');
        $modulemanager->loadModules();
    }



    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public static function getServiceManager() {
        return static::$serviceManager;
    }



    /**
     * @return array
     */
    public static function getConfig() {
        return static::$config;
    }



    /**
     * Retrieve parent for a given path
     * @param string $sPath
     * @return boolean|string
     */
    public static function findParentPath($sPath) {
        $sCurrentDir = __DIR__;
        $sPreviousDir = '.';
        while (!is_dir($sPreviousDir . '/' . $sPath)) {
            $sCurrentDir = dirname($sCurrentDir);
            if ($sPreviousDir === $sCurrentDir) {
                return false;
            }
            $sPreviousDir = $sCurrentDir;
        }
        return $sCurrentDir . '/' . $sPath;
    }

}

\ShoppingCartTest\Bootstrap::init();
