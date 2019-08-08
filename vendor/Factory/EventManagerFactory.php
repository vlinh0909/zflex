<?php

namespace Factory;

use Factory\NullServiceLocatorException;
use Zend\EventManager\EventManager;

class EventManagerFactory
{
    /**
     * @var ServiceManager
     */
    private static $eventManager = null;
    
    /**
     * Disable constructor
     */
    private function __construct() { }
    
    /**
     * @throw ServiceLocatorFactory\NullServiceLocatorException
     * @return Zend\ServiceManager\ServiceManager
     */
    public static function getEventManager()
    {
        if(null === self::$eventManager) {
            throw new NullServiceLocatorException('EventManager is not set');
        }
        return self::$eventManager;
    }

    /**
     * @param ServiceManager
     */
    public static function setEventManager(EventManager $em)
    {
        self::$eventManager = $em;
    }
}
