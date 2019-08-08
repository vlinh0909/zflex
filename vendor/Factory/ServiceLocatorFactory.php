<?php

namespace Factory;

use Factory\NullServiceLocatorException;
use Zend\ServiceManager\ServiceManager;

class ServiceLocatorFactory
{
    /**
     * @var ServiceManager
     */
    private static $serviceManager = null;
    
    /**
     * Disable constructor
     */
    private function __construct() { }
    
    /**
     * @throw ServiceLocatorFactory\NullServiceLocatorException
     * @return Zend\ServiceManager\ServiceManager
     */
    public static function getServiceLocator()
    {
        if(null === self::$serviceManager) {
            throw new NullServiceLocatorException('ServiceLocator is not set');
        }
        return self::$serviceManager;
    }

    /**
     * @param ServiceManager
     */
    public static function setServiceLocator(ServiceManager $sm)
    {
        self::$serviceManager = $sm;
    }
}
