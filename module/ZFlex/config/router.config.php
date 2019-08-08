<?php
return array(
	'router' => array(
        'routes' => array(
            'zflex' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/admin_zflex',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'ZFlex\Controller',
                        'controller'    => 'Dashboard',
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
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'member' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/member[/:action[/:id][/page/:page]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+',
                                'page'       => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Member',
                                'action'        => 'list',
                            ),
                        ),
                    ),
                    'ajax' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/ajax[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Ajax',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'media' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/media[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Media',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'auth' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/auth[/:action]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Auth',
                                'action'        => 'login',
                            ),
                        ),
                    ),
                    'permission' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/permission[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Permission',
                                'action'        => 'list',
                            ),
                        ),
                    ),
                    'role' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/role[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Role',
                                'action'        => 'list',
                            ),
                        ),
                    ),
                    'content' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/content[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Content',
                                'action'        => 'theme',
                            ),
                        ),
                    ),
                    'rent' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/rent[/:action[/:id][/page/:page]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'page' => '[0-9]+',
                                'id'         => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Rent',
                                'action'        => 'list',
                            ),
                        ),
                    ),
                    'category' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/category[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Category',
                                'action'        => 'list',
                            ),
                        ),
                    ),
                    'acl' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/denied',
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Acl',
                                'action'        => 'denied',
                            ),
                        ),
                    ),
                    'customer' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/customer[/:action[/:id][/page/:page]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]+',
                                'id'         => '[0-9]+',
                                'page'       => '[0-9]+'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'ZFlex\Controller',
                                'controller'    => 'Customer',
                                'action'        => 'list',
                            ),
                        ),
                    )
                ),
            ),
        ),
    )
);