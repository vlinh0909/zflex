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
use Zend\View\Model\JsonModel;
use Exception;

class HandingController extends Controller
{

     public function loadSendReportAction()
    {
         if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $em = $this->getEM();
                $customer = $this->FrontendData()->CustomerInfo();
                if(!empty($customer))
                {
                    $val = $this->getRequest()->getPost('val');
                    $shop_id =(int) $this->getRequest()->getPost('shop_id');
                    $boss = $em->getRepository('ZFlex\Entity\Shop')->findOneBy(array('id' => $shop_id));
                    $history_rent = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('customer' => $customer,'boss' => $boss->getCustomer()));
                    if(!empty($history_rent))
                    {
                        if($boss->getCustomer()->getId() == $customer->getId())
                        {
                            $ajax = new JsonModel(array(
                                'result' => 'cannot'
                            ));
                            return $ajax;
                        }else{
                            $reported = $em->getRepository('ZFlex\Entity\ReportShop')->findBy(array('customer' => $customer,'shop' => $boss,'is_read' => 0));
                            if(!empty($reported))
                            {
                                $data = 'reported';
                            }else{
                                $reported = new \ZFlex\Entity\ReportShop;
                                $reported->setCustomer($customer);
                                $reported->setShop($boss);
                                $reported->setMessage($val);
                                $reported->setIsRead(0);
                                $reported->setTimeCreated(\Carbon\Carbon::now());

                                $em->persist($reported);
                                $em->flush();
                                $data = true;
                            }
                        }
                    }else{
                        $data = false;
                    }
                    $ajax = new JsonModel(array(
                        'result' => $data
                    ));
                    return $ajax;
                }else{
                    $ajax = new JsonModel(array(
                        'result' => 'not_login'
                    ));
                    return $ajax;
                }
                
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadSendCommentAction(){
         if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $em = $this->getEM();
                $customer = $this->FrontendData()->CustomerInfo();
                if(!empty($customer))
                {
                    $rep_id = $this->getRequest()->getPost('rep_id');
                    $rating = $this->getRequest()->getPost('rating');
                    $val = $this->getRequest()->getPost('val');
                    $shop_id =(int) $this->getRequest()->getPost('shop_id');
                    $boss = $em->getRepository('ZFlex\Entity\Shop')->findOneBy(array('id' => $shop_id));
                    $history_rent = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('customer' => $customer,'boss' => $boss->getCustomer()));
                    
                        if($boss->getCustomer()->getId() == $customer->getId())
                        {
                            if($rep_id != 0)
                            {
                                $comment = new \ZFlex\Entity\CommentShop;
                                $comment->setCustomer($customer);
                                $comment->setShop($boss);
                                $comment->setRepComment($rep_id);
                                $comment->setContent($val);
                                $comment->setScore($rating);
                                $comment->setTimeCreated(\Carbon\Carbon::now());

                                $em->persist($comment);
                                $em->flush();

                                $data = [
                                    'id' => $comment->getId(),
                                    'fb_id' => $customer->getFbId(),
                                    'name' => $customer->getFbName(),
                                    'rating' => $comment->getScore(),
                                    'time' => \Carbon\Carbon::now()->format('H:i:s d/m/Y'),
                                    'content' => $val
                                ];
                            }else{
                                $ajax = new JsonModel(array(
                                    'result' => 'cannot'
                                ));
                                return $ajax;
                            }
                        }else{
                            if(!empty($history_rent))
                            {
                                $commented = $em->getRepository('ZFlex\Entity\CommentShop')->findBy(array('customer' => $customer,'shop' => $boss));
                                if(!empty($commented) && $rep_id == 0)
                                {
                                    $data = 'commented';
                                }else{
                                    $comment = new \ZFlex\Entity\CommentShop;
                                    $comment->setCustomer($customer);
                                    $comment->setShop($boss);
                                    $comment->setRepComment($rep_id);
                                    $comment->setContent($val);
                                    $comment->setScore($rating);
                                    $comment->setTimeCreated(\Carbon\Carbon::now());

                                    $em->persist($comment);
                                    $em->flush();

                                    $data = [
                                        'id' => $comment->getId(),
                                        'fb_id' => $customer->getFbId(),
                                        'name' => $customer->getFbName(),
                                        'rating' => $comment->getScore(),
                                        'time' => \Carbon\Carbon::now()->format('H:i:s d/m/Y'),
                                        'content' => $val
                                    ];
                                }
                            }else{
                                $data = false;
                            }
                        }
                    
                    $ajax = new JsonModel(array(
                        'result' => $data
                    ));
                    return $ajax;
                }else{
                    $ajax = new JsonModel(array(
                        'result' => 'not_login'
                    ));
                    return $ajax;
                }
                
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadShopAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $id = $this->getRequest()->getPost('id');
                $em = $this->getEM();
                $rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
                $data['game'] = $rent->getCategory()->getName();
                $data['shop'] = $rent->getCustomer()->getShop()->getShopName();
                $data['url_shop'] = $this->url()->fromRoute('shop_info',array('id' => $rent->getCustomer()->getShop()->getId()));
                $ajax = new JsonModel(array(
                    'result' => $data
                ));
                return $ajax;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadHandingRentedAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $id = $this->getRequest()->getPost('id');
                $password = $this->getRequest()->getPost('password');
                $status = $this->getRequest()->getPost('status');
                $em = $this->getEM();
                $rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id,'customer' => $this->FrontendData()->CustomerInfo()));
                $time_end = \Carbon\Carbon::parse($rent->getHistoryRent()->last()->getTimeEnd());
                $gt = $time_end->gt(\Carbon\Carbon::now());
                if($gt == false){
                    if($status == 1)
                    {
                        $rent->setStatus(1);
                    }else if($status == 3)
                    {
                        $rent->setStatus(3);
                    }
                    $rent->setPassword($password);
                    $em->persist($rent);
                    $em->flush();
                    $ajax = new JsonModel(array(
                        'result' => $id
                    ));
                    return $ajax;
                }
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadReportRentAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) { 
                $em = $this->getEM();
                $id = $this->getRequest()->getPost('id');
                $msg = $this->getRequest()->getPost('msg');
                $rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
                if(!empty($rent))
                {
                    $time_end = \Carbon\Carbon::parse($rent->getHistoryRent()->last()->getTimeEnd());
                    $customer = $this->FrontendData()->CustomerInfo();
                    if($time_end->gt(\Carbon\Carbon::now()) == true && $rent->getHistoryRent()->last()->getCustomer()->getId() == $customer->getId())
                    {
                        $report_rent = new \ZFlex\Entity\ReportRent;
                        $report_rent->setRent($rent);
                        $report_rent->setMsg($msg);
                        $report_rent->setIsShow(1);
                        $report_rent->setShop($rent->getCustomer()->getShop());
                        $report_rent->setCustomer($customer);
                        $report_rent->setTimeCreated(\Carbon\Carbon::now());
                        $em->persist($report_rent);
                        $em->flush();
                        $ajax = new JsonModel(array(
                            'result' => true
                        ));
                        return $ajax;
                    }else{
                        $ajax = new JsonModel(array(
                            'result' => 'error'
                        ));
                        return $ajax;
                    }
                } 
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadRentListAction()
    {
       if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) { 
                $status = $this->getRequest()->getPost('status');
                $rent = $this->FrontendData()->AjaxRentList($status,21);
                $ajax = new JsonModel(array(
                    'result' => $rent
                ));
                return $ajax;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadRentListSearchAction()
    {
       if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) { 
                $search = $this->getRequest()->getPost('search');
                $status_search = $this->getRequest()->getPost('status_search');
                $rent = $this->FrontendData()->AjaxRentSearch($search,$status_search);
                $ajax = new JsonModel(array(
                    'result' => $rent
                ));
                return $ajax;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadShowReportRentAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $id = $this->getRequest()->getPost('id');
                $em = $this->getEM();
                $report_rent = $em->getRepository('ZFlex\Entity\ReportRent')->findOneBy(array('id' => $id));
                if(!empty($report_rent))
                {
                    if($report_rent->getRent()->getCustomer()->getId() == $this->FrontendData()->CustomerInfo()->getId())
                    {
                        $report_rent->setIsShow(0);
                        $em->persist($report_rent);
                        $em->flush();
                        $ajax = new JsonModel(array(
                            'result' => true
                        ));
                        return $ajax;
                    }
                }
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadRentAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $game = $this->getRequest()->getPost('game');
                $ready = $this->getRequest()->getPost('ready');
                $page = $this->getRequest()->getPost('page');
                $customer_id = $this->getRequest()->getPost('customer_id');
                $em = $this->getEM();
                $rent = $this->FrontendData()->AjaxRent($game,$ready,$page,$customer_id);
                $count = $this->FrontendData()->AjaxCountRent($game,$customer_id);
                $ajax = new JsonModel(array(
                    'result' => $rent,
                    'count' => $count
                ));
                return $ajax;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

public function loadGiaHanAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $customer = $this->FrontendData()->CustomerInfo();
                if(!empty($customer))
                {
                    $em = $this->getEM();
                    $id = $this->getRequest()->getPost('id');
                    $rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
                    if($rent->getStatus() == 2)
                    {
                        if($rent->getIsGiaHan() == 1)
                        {
                            $time_end = \Carbon\Carbon::parse($rent->getHistoryRent()->last()->getTimeEnd());
                            if($time_end->gt(\Carbon\Carbon::now()) == true)
                            {
                                $sm = $this->getServiceLocator();
                                $vm = $sm->get('ViewHelperManager');
                                $data['username'] = $rent->getUsername();
                                $data['url_shop'] = $this->url()->fromRoute('shop_info',array('id' => $rent->getCustomer()->getShop()->getId()));
                                $data['shop'] = $rent->getCustomer()->getShop()->getShopName();
                                $data['img'] = $vm->get('FrontendPath')->BannerShop($rent->getCustomer()->getShop()->getBanner());
                                $data['value_options'] = unserialize($rent->getRentTime());
                                $ajax = new JsonModel(array(
                                    'result' => $data
                                ));
                                return $ajax;
                            }else{
                                $ajax = new JsonModel(array(
                                    'result' => 'error'
                                ));
                                return $ajax;
                            }
                        }else if($rent->getIsGiaHan() == 0){
                            $ajax = new JsonModel(array(
                                'result' => 'not'
                            ));
                            return $ajax;
                        }
                        
                        
                    }else{
                        $ajax = new JsonModel(array(
                            'result' => 'error'
                        ));
                        return $ajax;
                    }
                }
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadHandingGiaHanAction()
    {
         if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $customer = $this->FrontendData()->CustomerInfo();
                if(!empty($customer))
                {
                    $em = $this->getEM();
                    $id = $this->getRequest()->getPost('id');
                    $time = $this->getRequest()->getPost('time');
                    $rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
                    if($rent->getStatus() == 2 && $rent->getIsGiaHan() == 1)
                    {
                        $money = (int) $customer->getMoney();
                        $rent_time = unserialize($rent->getRentTime());
                        $price =(int) $rent_time[$time];
                        if(!empty($price))
                        {
                            $vnd =(int) $money - $price;
                            if($vnd >= 0)
                            {
                                $boss = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('id' => $rent->getCustomer()));
                                $boss->setMoney((int) $boss->getMoney() + $this->FrontendData()->ChietKhau($price));
                                $history_rent = $em->getRepository('ZFlex\Entity\HistoryRent')->findOneBy(array('id' => $rent->getHistoryRent()->last()->getId()));
                                $customer->setMoney($vnd);
                                $time_end = \Carbon\Carbon::parse($history_rent->getTimeEnd());
                                $history_rent->setTimeEnd($time_end->addHours($time));
                                $history_rent->setTime((int) $history_rent->getTime() + (int) $time);
                                $history_rent->setPrice((int) $history_rent->getPrice() + $this->FrontendData()->ChietKhau($price));
                                $history_rent->setGiaHanTimes((int) $history_rent->getGiaHanTimes() + 1);
                                $rent->setRentTimes((int) $rent->getRentTimes() + 1);
                                $rent->setSumMoney((int) $rent->getSumMoney() + $price);
                                $em->persist($boss);
                                $em->persist($rent);
                                $em->persist($customer);
                                $em->persist($history_rent);
                                $em->flush();
                                $data = 1;
                            }else{
                                $data = 0;
                            }
                            $ajax = new JsonModel(array(
                                'result' => $data
                            ));
                            return $ajax;
                        }
                        
                    }

                }
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function loadRentAccountAction()
    {
        // 1 : Sẵn sàng
        // 2 : Đã được thuê or Hết thời gian chờ đổi pass
        // 3 : Ngưng hoạt động
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $customer = $this->FrontendData()->CustomerInfo();
                if(!empty($customer))
                {
                    $em = $this->getEM();
                    $id = $this->getRequest()->getPost('id');
                    $time = $this->getRequest()->getPost('time');
                    $rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
                    if($rent->getStatus() == 1)
                    {
                        $money = (int) $customer->getMoney();
                        $rent_time = unserialize($rent->getRentTime());
                        $price =(int) $rent_time[$time];
                        $price =(int) $rent_time[$time];
                        if(!empty($price))
                        {
                            $vnd =(int) $money - $price;
                            if($vnd >= 0)
                            {
                                $boss = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('id' => $rent->getCustomer()));
                                $boss->setMoney($boss->getMoney() + $this->FrontendData()->ChietKhau($price));
                                $customer->setMoney($vnd);
                                $history_rent = new \ZFlex\Entity\HistoryRent;
                                $history_rent->setCustomer($customer);
                                $history_rent->setBoss($rent->getCustomer());
                                $history_rent->setUsername($rent->getUsername());
                                $history_rent->setPassword($rent->getPassword());
                                $history_rent->setPrice($price);
                                $history_rent->setTime($time);
                                $history_rent->setRent($rent);
                                $history_rent->setGiaHanTimes(0);
                                $history_rent->setTimeRent(\Carbon\Carbon::now());
                                $history_rent->setTimeEnd(\Carbon\Carbon::now()->addHours($time));
                                $rent->setStatus(2);
                                $rent->setRentTimes((int) $rent->getRentTimes() + 1);
                                $rent->setSumMoney((int) $rent->getSumMoney() + $price);
                                $em->persist($boss);
                                $em->persist($customer);
                                $em->persist($history_rent);
                                $em->persist($rent);
                                $em->flush();
                                $data = 1;
                            }else{
                                $data = 0;
                            }
                            $ajax = new JsonModel(array(
                                'result' => $data
                            ));
                            return $ajax;
                        }
                    }
                }else{
                    $ajax = new JsonModel(array(
                        'result' => 'not_login'
                    ));
                    return $ajax;
                }
            }
        }else{
            return $this->redirect()->toRoute('home');
        }

    }

    public function buyAction()
    {
        $fb_id = $this->Framework()->FacebookInfo('id');
        if($fb_id)
        {
            $data = '';

            $product_id = $this->getRequest()->getPost('id');

            $em = $this->getEM();

            $product = $em->getRepository('ZFlex\Entity\Product')->findOneBy(array('id' => $product_id));
            $customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('fb_id' => $fb_id));

            $money = (int) $customer->getMoney();
            $price = (int) $product->getPrice();

            $vnd = $money - $price;

            if($vnd >= 0)
            {
                $history_buy = new \ZFlex\Entity\HistoryBuy;

                $customer->setMoney($vnd);

                $product->setStatus(2);

                $history_buy->setProduct($product->getId());
                $history_buy->setUsername($product->getUsername());
                $history_buy->setPassword($product->getPassword());
                $history_buy->setPrice($product->getPrice());
                $history_buy->setCustomer($this->Framework()->FacebookInfo('id'));
                $history_buy->setTimeBuy(\Carbon\Carbon::now());

                $em->persist($customer);
                $em->persist($history_buy);
                $em->persist($product);
                $em->flush();

                $data = 1;
            }
            else if($vnd < 0)
            {
                $data = 2;
            }
            $ajax = new JsonModel(array(
                'result' => $data
            ));
            return $ajax;
        }
        else
        {
            $ajax = new JsonModel(array(
                'result' => 4
            ));
            return $ajax;
        }
    }
}