<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZFlexFrontend\Controller;

use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;

class IndexController extends Controller
{
    public function indexAction()
    {
        $em = $this->getEM();

        $pagingConfig = array(
          'ItemCountPerPage' => 16,
          'CurrentPageNumber' => 1,
          'StatusRent' => 1,
          'CustomerId' => 0
        );

        $repository = $em->getRepository('ZFlex\Entity\Rent');
        $paginator = new \ZFlexPL\Paginator\Paginator;
        $paging = $paginator->make($repository,$pagingConfig);
        $count = $this->FrontendData()->AjaxCountRent('home');
        return $this->loadTemplate(array('rents' => $paging,'count' => $count));
    }

    public function productDetailsAction()
    {
    	$id = $this->params()->fromRoute('id');
    	$em = $this->getEM();
    	$product = $em->getRepository('ZFlex\Entity\Product')->findOneBy(array('id' => $id,'status' => 1));
    	return $this->loadTemplate(array('product' => $product));
    }

    public function fbLoginAction()
    {
        $login_facebook = new \ZFlex\Framework\Framework;
        
        $login_facebook->CallbackLoginFacebook();
        return false;
    }

    public function loginAction()
    {
        // $sm = $this->getServiceLocator();
        $url_login_fb = $this->Framework()->URLLoginFacebook();
        $this->redirect()->toUrl($url_login_fb);
    }

    public function fbLogoutAction()
    {
        $fb = $this->Framework()->Facebook();
        $helper = $fb->getRedirectLoginHelper();
        $logoutURL = $helper->getLogoutUrl($_SESSION['fb_access_token'],'http://localhost/zflex/');
        unset($_SESSION['fb_access_token']);
        unset($_SESSION['fb_info']);
        return $this->redirect()->toUrl($logoutURL);
    }

    public function historyRentAction()
    {
        $em = $this->getEM();
        $history_rent = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('customer' => $this->FrontendData()->CustomerInfo()),array('id' => 'DESC'));
        return $this->loadTemplate(array('history_rent' => $history_rent));
    }

    public function shopInfoAction()
    {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEM();
        $shop = $em->getRepository('ZFlex\Entity\Shop')->findOneBy(array('id' => $id));
        if(!empty($shop))
        {
            $customer_id = $shop->getCustomer()->getId();
            $pagingConfig = array(
              'ItemCountPerPage' => 16,
              'CurrentPageNumber' => 1,
              'StatusRent' => 1,
              'CustomerId' => $customer_id
            );

            $repository = $em->getRepository('ZFlex\Entity\Rent');
            $paginator = new \ZFlexPL\Paginator\Paginator;
            $paging = $paginator->make($repository,$pagingConfig);
            $count = $this->FrontendData()->AjaxCountRent('home',$customer_id);
            $luotthue = count($em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('boss' => $customer_id)));
            $comment_shop = $em->getRepository('ZFlex\Entity\CommentShop')->findBy(array('shop' => $id),array('id' => 'DESC'));
            return $this->loadTemplate(array('rents' => $paging,'count' => $count,'id' => $customer_id,'shop' => $shop,'luotthue' => $luotthue,'comment_shop' => $comment_shop));
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

   
    // public function loadRentReadyAction()
    // {
    //     if ($this->getRequest()->isXmlHttpRequest()) {
    //         if ($this->getRequest()->isPost()) {
    //             $game = $this->getRequest()->getPost('game');
    //             $page = $this->getRequest()->getPost('page');
    //             $ready = $this->getRequest()->getPost('ready');
    //             $em = $this->getEM();
    //             $rent = $this->FrontendData()->AjaxRent($game);
    //             $count = $this->FrontendData()->AjaxCountRent($game);

    //             $ajax = new JsonModel(array(
    //                 'result' => $rent,
    //                 'count' => $count
    //             ));
    //             return $ajax;
    //         }
    //     }else{
    //         return $this->redirect()->toRoute('home');
    //     }
    // }

    

    public function rentAction()
    {
        $em = $this->getEM();

        $pagingConfig = array(
          'ItemCountPerPage' => 16,
          'CurrentPageNumber' => 1,
          'StatusRent' => 1,
          'CustomerId' => 0
        );

        $repository = $em->getRepository('ZFlex\Entity\Rent');
        $paginator = new \ZFlexPL\Paginator\Paginator;
        $paging = $paginator->make($repository,$pagingConfig);
        $count = $this->FrontendData()->AjaxCountRent('home');
        return $this->loadTemplate(array('rents' => $paging,'count' => $count));
    }

    public function notificationAction()
    {
        $block = new Container('block');
        if(!$block->offsetExists('block'))
        {
            return $this->redirect()->toRoute('home');
        }else
        {
            echo $block->block;
        }
        unset($_SESSION['block']);
        return $this->getResponse();
    }

    public function createShopAction()
    {
        $fb_info = $this->Framework()->FacebookInfo();
        $customer = $this->FrontendData()->CustomerInfo();
        if(!$fb_info)
        {
            return $this->redirect()->toRoute('login');
        }else if($customer->getOpenShop() == 1)
        {
            return $this->redirect()->toRoute('home');
        }
        $em = $this->getEM();
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('CsrfForm');
        $request = $this->getRequest();
        $error = '';
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();
            $form->setData($data);
            $options_count = array(
                'where' => 'shop_name',
                'value' => $data['name_shop'],
                'entity' => 'shop'
            );
            if($form->isValid())
            {
                $count = $this->Data()->count($options_count);
                if($data['name_shop'])
                {
                    if($count == 0)
                    {
                        $money = (int) $customer->getMoney();
                        if($money >= 20000)
                        {
                            $shop = new \ZFlex\Entity\Shop;
                            $shop->setShopName($data['name_shop']);
                            $shop->setCustomer($customer);
                            $shop->setBanner('default_banner.jpg');
                            $shop->setTimeCreated(\Carbon\Carbon::now());
                            $customer->setOpenShop(1);
                            $vnd = $money - 20000;
                            $customer->setMoney($vnd);
                            $em->persist($shop);
                            $em->persist($customer);
                            $em->flush();
                            return $this->redirect()->toRoute('shop',array('action' => 'shop-setting'));
                        }
                    }
                    else
                    {
                        $error = 'Đã tồn tại tên shop '.$data['name_shop'].' này !';
                    }
                }
            }else{
                $error = 'Chưa nhập tên shop !';
            }
            
        }
        return $this->loadTemplate(array('customer' => $customer,'error' => $error,'form' => $form));
    }
}
