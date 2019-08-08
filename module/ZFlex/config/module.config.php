<?php
namespace ZFlex;

return array(
    'controllers' => array(
        'invokables' => array(
            'ZFlex\Controller\Member' => 'ZFlex\Controller\MemberController',
            'ZFlex\Controller\Dashboard' => 'ZFlex\Controller\DashboardController',
            'ZFlex\Controller\Auth' => 'ZFlex\Controller\AuthController',
            'ZFlex\Controller\Permission' => 'ZFlex\Controller\PermissionController',
            'ZFlex\Controller\Role' => 'ZFlex\Controller\RoleController',
            'ZFlex\Controller\Acl' => 'ZFlex\Controller\AclController',
            'ZFlex\Controller\Customer' => 'ZFlex\Controller\CustomerController',
            'ZFlex\Controller\Media' => 'ZFlex\Controller\MediaController',
            'ZFlex\Controller\Category' => 'ZFlex\Controller\CategoryController',
            'ZFlex\Controller\Rent' => 'ZFlex\Controller\RentController',
            'ZFlex\Controller\Content' => 'ZFlex\Controller\ContentController',
            'ZFlex\Controller\Ajax' => 'ZFlex\Controller\AjaxController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZFlex' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/backend' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/login' => __DIR__ . '/../view/layout/login.phtml',
            'layout/denied' => __DIR__ . '/../view/layout/denied.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),
    'service_manager' => array(
        'factories' => array(
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'ZFlex\Entity\Member',
                'identity_property' => 'username',
                'credential_property' => 'password',
                'credential_callable' => function(\ZFlex\Entity\Member $member,$passwordGiven)
                {
                    $bcrypt = new \Zend\Crypt\Password\Bcrypt;
                    if($bcrypt->verify($passwordGiven,$member->getPassword()) && ($member->getStatus() == 1))
                    {
                        \ZFlex\Framework\Log\Logger::write(\ZFlex\Framework\Log\Logger::LOGIN_HISTORY,$member->getUsername()." đăng nhập thành công !",\Zend\Log\Logger::NOTICE);
                        return TRUE;
                    }
                    else
                    {
                        return FALSE;
                    }
                }
            ),
        ),
    ),
    'upload_location_banner' => dirname(__DIR__).'/../../public/img/banner_shop/',
    'upload_location_img' => dirname(__DIR__).'/../../public/img/media/',
    'location_plugins' => dirname(__DIR__).'/../../app/code/',
    'ajax' => array(
        'delete' => array(
            '_id' => array(
                'member' => 5,
                'customer' => 10,
                'permission' => 6,
                'role' => 1
            )   
        )
    ),
    'namespaces' => array(
        'plugin' => "\ZFlex\App\Code\\"
    ),
);
