<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
define('HOST','localhost');
define('USER','root');
define('PASS','mysql');
define('DBNAME','zflex');
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function($sm){
                $adapterFactory = new Zend\Db\Adapter\AdapterServiceFactory;
                $adapter =$adapterFactory->createService($sm);
                \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($adapter);
                return $adapter;
            }
        ),
    ),
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => HOST,
                    'user'     => USER,
                    'password' => PASS,
                    'dbname'   => DBNAME,
                    'driverOptions' => array( 1002 => 'SET NAMES UTF8' )
                ],
            ],
        ],
    ]
);
