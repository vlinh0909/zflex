<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ZFlexFrontend\Controller\Index' => 'ZFlexFrontend\Controller\IndexController',
            'ZFlexFrontend\Controller\Card' => 'ZFlexFrontend\Controller\CardController',
            'ZFlexFrontend\Controller\Handing' => 'ZFlexFrontend\Controller\HandingController',
            'ZFlexFrontend\Controller\Shop' => 'ZFlexFrontend\Controller\ShopController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/[index.html]',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'api' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/api[/]',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Api',
                        'action'     => 'index',
                    ),
                ),
            ),
            'shop_info' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/thong-tin-shop-[:id[.html]]',
                    'constraints' => array(
                        'id'         => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'shop-info',
                    ),
                ),
            ),
            'fb_login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'fb-login',
                    ),
                ),
            ),
            'notification' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/thong-bao.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'notification',
                    ),
                ),
            ),
            'fb_login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/login.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'fb-login',
                    ),
                ),
            ),
            'create_shop' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/tao-shop.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'create-shop',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/fb_login.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'login',
                    ),
                ),
            ),
            'history_rent' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/lich-su-thue-acc.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'history-rent',
                    ),
                ),
            ),
            'rent' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/thue-acc.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'rent',
                    ),
                ),
            ),
            'fb_logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/logout.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'     => 'fb-logout',
                    ),
                ),
            ),
            'card' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/nap-card.html',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Card',
                        'action'     => 'card',
                    ),
                ),
            ),
            'card-handing' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/card-handing',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Card',
                        'action'     => 'card-handing',
                    ),
                ),
            ),
            'product_details' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/chi-tiet-tai-khoan[/tai-khoan-lmht-[:id[.html]]]',
                    'constraints' => array(
                        'id'         => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Index',
                        'action'        => 'product-details',
                    ),
                ),
            ),
            'handing' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/handing[/:action[/:id]]',
                    'constraints' => array(
                        'id'         => '[0-9]+',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Handing',
                        'action'        => 'buy',
                    ),
                ),
            ),
            'ajax' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/ajax[/:action[/:id]]',
                    'constraints' => array(
                        'id'         => '[0-9]+',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Handing',
                        'action'        => 'load-shop',
                    ),
                ),
            ),
            'shop' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/shop',
                    'defaults' => array(
                        'controller' => 'ZFlexFrontend\Controller\Shop',
                        'action'        => 'shop-dashboard',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action[/:id][.html]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+'
                            ),
                            'defaults' => array(
                                'controller' => 'ZFlexFrontend\Controller\Shop',
                                'action'        => 'shop-dashboard',
                            ),
                        ),
                    ),
                )
            )
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            // 'application' => array(
            //     'type'    => 'Literal',
            //     'options' => array(
            //         'route'    => '/application',
            //         'defaults' => array(
            //             '__NAMESPACE__' => 'ZFlexFrontend\Controller',
            //             'controller'    => 'Index',
            //             'action'        => 'index',
            //         ),
            //     ),
            //     'may_terminate' => true,
            //     'child_routes' => array(
            //         'default' => array(
            //             'type'    => 'Segment',
            //             'options' => array(
            //                 'route'    => '/[:controller[/:action]]',
            //                 'constraints' => array(
            //                     'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            //                     'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
            //                 ),
            //                 'defaults' => array(
            //                 ),
            //             ),
            //         ),
            //     ),
            // ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ZFlexFrontend' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/ZFlexFrontend/layout/blackandwhite/layout.phtml',
            'partial/nav_shop' =>__DIR__ . '/../view/ZFlexFrontend/layout/blackandwhite/partial/nav_shop.phtml',
            'partial/errors' =>__DIR__ . '/../view/ZFlexFrontend/layout/blackandwhite/partial/errors.phtml',
            'partial/more' =>__DIR__ . '/../view/ZFlexFrontend/layout/blackandwhite/partial/more.phtml',
            // 'layout/denied' => __DIR__ . '/../view/layout/denied.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ),
);
