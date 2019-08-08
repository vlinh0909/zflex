<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZFlex;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        $module = include __DIR__ . '/config/module.config.php';
        $router = include __DIR__ . '/config/router.config.php';
        return array_merge($module,$router);
    }

    public function onBootstrap(MvcEvent $e)
    {
        if (!session_id()) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set("session.gc_maxlifetime", 43200);
            ini_set("session.cookie_lifetime", 43200);
            // ini_set('session.cookie_secure', 1);
            @session_start();
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $sm = $e->getApplication()->getServiceManager();
        // TABLE PREFIX
        $tablePrefix = new \ZFlex\DoctrineExtension\TablePrefix(ZFLEX_DB_PREFIX);
        $em = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
        $evm = $em->getEventManager();
        $evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);
        $eventManager        = $e->getApplication()->getEventManager();
        // $eventManager->attach(new \ZFlex\App\Code\Coupon\CaseStudyListener);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $shared = $eventManager->getSharedManager();
        $shared->attach(__NAMESPACE__,'dispatch',function($e) use ($sm)
        {
            $controller = $e->getTarget();
            $route = $e->getRouteMatch();
            $actionName = $route->getParam('action');
            $_controller = $route->getParam('controller');
            $arr = explode('\\',$_controller);
            if($controller instanceof Controller\AuthController && $actionName != 'logout'){
                $controller->layout('layout/login');
            }else{
                $aclPlugin = $sm->get('ControllerPluginManager')->get('ZFlexPL\Controller\Plugin\AclPlugin');
                if($aclPlugin->getAuthService() == 'guest'){
                    $controller->plugin('redirect')->toRoute('zflex/auth',array('login'));
                }
                $authService = $sm->get('ZendAuth');
                $authService->getStorage()->read();
                $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
                $viewModel->user = $authService->getIdentity();
                $viewModel->acl = $aclPlugin->configACL();
                $viewModel->role = $aclPlugin->getAuthService();
                $viewModel->controller  = array_pop($arr);
                $aclPlugin->RoleAccess($e);
                $response = $e->getResponse();
                if($response->getStatusCode() == 403)
                {
                    $controller->plugin('redirect')->toRoute('zflex/acl');
                    // $e->stopPropagation();

                }
            }
        },999999);     
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'Path' => function($sm)
                {
                    $helper = new \ZFlex\View\Helper\Path($sm);
                    return $helper;
                },
                'Layout' => function($sm)
                {
                    $helper = new \ZFlex\View\Helper\Layout($sm);
                    return $helper;
                },
                'Script' => function($sm)
                {
                    $helper = new \ZFlex\View\Helper\Script;
                    return $helper;
                },
                'Data' => function($sm)
                {
                    $helper = new \ZFlex\View\Helper\Data($sm);
                    return $helper;
                },
            )  
        );
    }

    public function getControllerPluginConfig() {
        return array(
            'invokables' => array(
                'Config' => 'ZFlex\Controller\Plugin\Config',
                'Media' => 'ZFlex\Controller\Plugin\Media',
                'Ajax' => 'ZFlex\Controller\Plugin\Ajax',
                'Data' => 'ZFlex\Controller\Plugin\Data',
                'Framework' => 'ZFlex\Framework\Framework',
            )
        );
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'MemberForm' => function($sm)
                {
                    $form = new \ZFlex\Form\MemberForm('Member_Form');
                    return $form;
                },
                'LoginForm' => function($sm)
                {
                    $form = new \ZFlex\Form\LoginForm('Login_Form');
                    return $form;
                },
                'PermissionForm' => function($sm)
                {
                    $form = new \ZFlex\Form\PermissionForm('Permission_Form');
                    return $form;
                },
                'RoleForm' => function($sm)
                {
                    $form = new \ZFlex\Form\RoleForm('Role_Form');
                    return $form;
                },
                'CustomerForm' => function($sm)
                {
                    $form = new \ZFlex\Form\CustomerForm('Customer_Form');
                    return $form;
                },
                'CustomForm' => function($sm)
                {
                    $form = new \ZFlex\Form\CustomForm('Custom_Form');
                    return $form;
                },
                'AttributeForm' => function($sm)
                {
                    $form = new \ZFlex\Form\AttributeForm('Attribute_Form');
                    return $form;
                },
                'CategoryForm' => function($sm)
                {
                    $form = new \ZFlex\Form\CategoryForm('Category_Form');
                    return $form;
                },
                'ProductForm' => function($sm)
                {
                    $form = new \ZFlex\Form\ProductForm('Product_Form');
                    return $form;
                },
                'MediaForm' => function($sm)
                {
                    $form = new \ZFlex\Form\MediaForm('Media_Form');
                    return $form;
                },
                'RentForm' => function($sm)
                {
                    $form = new \ZFlex\Form\RentForm('Rent_Form');
                    return $form;
                },
                'SettingForm' => function($sm)
                {
                    $form = new \ZFlex\Form\SettingForm('Setting_Form');
                    return $form;
                },
                'MenuForm' => function($sm)
                {
                    $form = new \ZFlex\Form\MenuForm('Menu_Form');
                    return $form;
                },
                'ChampionForm' => function($sm)
                {
                    $form = new \ZFlex\Form\ChampionForm('Champion_Form');
                    return $form;
                },
                'SkinForm' => function($sm)
                {
                    $form = new \ZFlex\Form\SkinForm('Skin_Form');
                    return $form;
                },
                'CardForm' => function($sm)
                {
                    $form = new \ZFlex\Form\CardForm('Card_Form');
                    return $form;
                },
                'CsrfForm' => function($sm)
                {
                    $form = new \ZFlex\Form\CsrfForm('Csrf_Form');
                    return $form;
                }
            )  
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'MemberManager' => 'ZFlex\Service\MemberManager',
                'PermissionManager' => 'ZFlex\Service\PermissionManager',
                'GeneralManager' => 'ZFlex\Service\GeneralManager',
                'RoleManager' => 'ZFlex\Service\RoleManager',
                'CustomerManager' => 'ZFlex\Service\CustomerManager',
                'AttributeManager' => 'ZFlex\Service\AttributeManager',
                'CategoryManager' => 'ZFlex\Service\CategoryManager',
                'ProductManager' => 'ZFlex\Service\ProductManager',
                'MediaManager' => 'ZFlex\Service\MediaManager',
                'PluginManager' => 'ZFlex\Service\PluginManager',
                'RentManager' => 'ZFlex\Service\RentManager',
                'MenuManager' => 'ZFlex\Service\MenuManager',
                'ChampionManager' => 'ZFlex\Service\ChampionManager',
                'SkinManager' => 'ZFlex\Service\SkinManager',
            ),
            'factories' => array(
                'ZendAuth' => function ($sm) {
                    return $sm->get('doctrine.authenticationservice.orm_default');
                },
                'navigation' => 'ZFlexPL\Navigation\ZFlexPLNavigationFactory',
            ),
        );
    }
}
