<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZFlexFrontend;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

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
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
         if (!session_id()) {
            @session_start();
        }
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $sm = $e->getApplication()->getServiceManager();
        $em = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
        $nameTheme = $sm->get('config')['website']['theme'];
        $session = new Container('fb_info');
        if($session->offsetExists('id'))
        {
            $fb_info = $session;
        }
        if(!empty($fb_info))
        {
            $customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('fb_id' => $fb_info->id));
            $shared = $eventManager->getSharedManager();
            $shared->attach(__NAMESPACE__,'dispatch',function($eV) use ($customer,$fb_info,$viewModel)
            {
                $controller = $eV->getTarget();
                if($customer->getIsBlock() == 0)
                {
                    $viewModel->facebook_id = $fb_info->id;
                    $viewModel->facebook_name = $fb_info->name;
                    $viewModel->money = $customer->getMoney();   
                    $viewModel->menu = $controller->FrontendData()->MainMenu();
                }else{
                    $controller->plugin('redirect')->toRoute('fb_logout');
                }
            },99999);    
        }else{
            $shared = $eventManager->getSharedManager();
            $shared->attach(__NAMESPACE__,'dispatch',function($eV) use ($viewModel)
            {
                $controller = $eV->getTarget();
                $viewModel->menu = $controller->FrontendData()->MainMenu();
            },555);    
        }
        
        $viewModel->nameTheme = $nameTheme;
        $viewModel->site = $sm->get('config')['website'];;
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'FrontendPath' => function($sm)
                {
                    $helper = new \ZFlexFrontend\View\Helper\Path($sm);
                    return $helper;
                },
                'FrontendData' => function($sm)
                {
                    $helper = new \ZFlexFrontend\View\Helper\Data($sm);
                    return $helper;
                }
            )  
        );
    }

    public function getControllerPluginConfig() {
        return array(
            'invokables' => array(
                'FrontendData' => 'ZFlexFrontend\Controller\Plugin\Data'
            )
        );
    }
}
