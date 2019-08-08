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
use Zend\Mvc\MvcEvent;
use Zend\Math\Rand;
use Zend\Validator\Csrf;

class ShopController extends Controller
{

	public function onDispatch(MvcEvent $e)
	{
		$customer = $this->FrontendData()->CustomerInfo();
		if(!$customer || $customer->getOpenShop() != 1)
		{
			return $this->redirect()->toRoute('home');
		}else{
			if($this->params('action') != 'shop-setting')
			{
				if($this->FrontendData()->CheckShop() == false)
				{
					return $this->redirect()->toRoute('shop/defaults',array('action' => 'shop-setting'));
				}
			}	
		}
		
		return parent::onDispatch($e);
	}

	public function shopHelpAction()
	{
		$em = $this->getEM();
		return $this->loadTemplate();
	}

	public function shopStatisticalAction(){
		$arr_elm = [
			'day_0' => \Carbon\Carbon::now()->format('d/m/Y'),
			'day_1' =>  \Carbon\Carbon::now()->subDays(1)->format('d/m/Y'),
			'day_2' =>  \Carbon\Carbon::now()->subDays(2)->format('d/m/Y'),
			'day_3' =>  \Carbon\Carbon::now()->subDays(3)->format('d/m/Y'),
			'day_4' =>  \Carbon\Carbon::now()->subDays(4)->format('d/m/Y'),
			'day_5' =>  \Carbon\Carbon::now()->subDays(5)->format('d/m/Y'),
			'day_6' =>  \Carbon\Carbon::now()->subDays(6)->format('d/m/Y'),
		];
		$total = [
			0 => 0,
			1  => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0
		];
		$money = [
			0 => 0,
			1  => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			5 => 0,
			6 => 0
		];
		$em = $this->getEM();
		$customer = $this->FrontendData()->CustomerInfo();
		$static = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('boss'=> $customer),array('id' => 'DESC'));
		foreach($static as $k => $v){
			$start  = date_create(\Carbon\Carbon::parse($v->getTimeRent())->format('Y-m-d'));
			$end 	= date_create(); // Current time and date
			$diff  	= date_diff( $start, $end );
			if($diff->d == 0) {
				++$total[0];
				$money[0] += $v->getPrice();
			}else if($diff->d == 1){
				++$total[1];
				$money[1] += $v->getPrice();
			}else if($diff->d == 2){
				++$total[2];
				$money[2] += $v->getPrice();
			}else if($diff->d == 3){
				++$total[3];
				$money[3] += $v->getPrice();
			}else if($diff->d == 4){
				++$total[4];
				$money[4] += $v->getPrice();
			}else if($diff->d == 5){
				++$total[5];
				$money[5] += $v->getPrice();
			}else if($diff->d == 6){
				++$total[6];
				$money[6] += $v->getPrice();
			}
		}

		return $this->loadTemplate(array('total' => $total,'static' => $arr_elm,'money' => $money));
	}

	public function shopWithdrawAction()
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$form = $sm->get('FormElementManager')->get('CsrfForm');
		$customer = $this->FrontendData()->CustomerInfo();
		$flash = $this->flashMessenger()->getMessages();
		$request = $this->getRequest();
		$errors = [];
		$history_withdraw = $em->getRepository('ZFlex\Entity\Withdraw')->findBy(array('customer' => $customer),array('id' => 'DESC'));
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				$current_money = $customer->getMoney();
				$money =(int) $current_money - (int)$data['money'];
				if($money >=  0 && $data['money'] >= 200000)
				{
					$widthdraw = new \ZFlex\Entity\Withdraw;
					$widthdraw->setCustomer($customer);
					$widthdraw->setMoney(strip_tags($data['money']));
					$widthdraw->setNote(strip_tags($data['note']));
					$widthdraw->setIsSend(0);
					$widthdraw->setTimeCreated(\Carbon\Carbon::now());
					$customer->setMoney($money);
					$em->persist($widthdraw);
					$em->persist($customer);
					$em->flush();
					$this->flashMessenger()->addMessage("Gửi yêu cầu thành công !");
					return $this->redirect()->toRoute('shop/defaults',array('action' => 'shop-withdraw'));
				}else{
					$errors[] = "Số tiền bạn yêu cầu rút lớn hơn so với số tiền hiện tại của bạn !";
				}
				
			}
		}
		return $this->loadTemplate(array('form' => $form,'history_withdraw'=>$history_withdraw,'errors' => $errors,'flash' => $flash));
	}
	
	public function shopReupAction()
	{
		
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$customer = $this->FrontendData()->CustomerInfo();
		$_report = $this->FrontendData()->ReportRent($customer->getShop());
		$_reup = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('boss' => $customer),array('id' => 'DESC'));
		$id = [];
		$reup = [];
		$report = [];
		foreach($_reup as $k => $v):

		if(in_array($v->getRent()->getId(),$id)){
			break;
		}else{

		$id[] = $v->getRent()->getId();
	  	$time_end = \Carbon\Carbon::parse($v->getTimeEnd());
  		$gt = $time_end->gt(\Carbon\Carbon::now());
  		if($gt == false && $v->getRent()->getStatus() == 2):
  			$number_random = Rand::getInteger(10000,99999);
			$pass_random = $sm->get('config')['website']['password_rent'].$number_random;
  			$reup[] = [
  				'id' => $v->getRent()->getId(),
  				'time_end' => $v->getTimeEnd(),
  				'username' => $v->getUsername(),
  				'password' => $v->getPassword(),
  				'new_password' => $pass_random,
  				'game' => $v->getRent()->getCategory()->getName()
  			];
		endif;
		}

		endforeach;
		foreach($_report as $val){
			if($val->getIsShow() == 1){
				$report[] = [
					'id' => $val->getId(),
					'username' => $val->getRent()->getUsername(),
					'msg' => $val->getMsg(),
					'game' => $val->getRent()->getCategory()->getName(),
					'time' => \Carbon\Carbon::parse($val->getTimeCreated())->format('h:i:s A \N\g\à\y d/m/Y')
				];
			}
			
		};
		return $this->loadTemplate(array('reup' => $reup,'report' => $report));
	}

	public function shopListAction()
	{
		$customer = $this->FrontendData()->CustomerInfo();
		$em = $this->getEM();
		$rents = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('customer' => $customer),array('id' => 'DESC'));
		$count = [
			'total' => count($rents),
			'dang_thue' => count($em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 2))),
			'san_sang' => count($em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 1))),
			'ngung_hoat_dong' => count($em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 3)))
		];
		return $this->loadTemplate(array('rents' => $rents,'count' => $count));
	}

	public function shopDashboardAction()
	{
		$shop = $this->FrontendData()->CustomerInfo()->getShop();
		$em = $this->getEM();
		$history_rents = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('boss' => $this->FrontendData()->CustomerInfo()));
		$comment_shop = $em->getRepository('ZFlex\Entity\CommentShop')->findBy(array('shop' => $shop->getId()),array('id' => 'DESC'));
		return $this->loadTemplate(array('comment_shop'=>$comment_shop,'shop' => $shop,'history_rents' => $history_rents));
	}

	public function shopHistoryAction()
	{
		$customer = $this->FrontendData()->CustomerInfo();
		$em = $this->getEM();
		$history_rents = $em->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('boss' => $customer),array('id'=>'DESC'));
		return $this->loadTemplate(array('history_rents' => $history_rents));
	}
	

	public function shopAddAction()
	{
		$number_random = Rand::getInteger(10000,99999);
		
		$sm = $this->getServiceLocator();
		$pass_random =$sm->get('config')['website']['password_rent'].$number_random;
		$form = $sm->get('FormElementManager')->get('CsrfForm');
		
		
		$request = $this->getRequest();
		$rent_time = [];
		$errors = [];
		$em = $this->getEM();
		if($request->isPost())
    	{
    		$data = $request->getPost()->toArray();
    		$form->setData($data);
    		if(array_key_exists('hours',$data))
    		{
    			foreach($data['money'] as $key => $money)
	    		{
					if(array_key_exists($key,$data['hours']))
	    			{
	    				if($money != '' && is_numeric($money))
	    				{
	    					$rent_time[$key] = $money;
	    				}
	    			}
	    			
	    		}
    		}else{
    			$errors[] = 'Bạn đã tắt tất cả khung giờ , phải có ít nhất 1 khung giờ được bật !';
    		}
    		
    		if($data['money'][3] == '' && $data['money'][8] == '' && $data['money'][20] == '' && $data['money'][36] == '' && $data['money'][72] == '')
    		{
    			$errors[] = 'Bạn đã nhập giá cho ít nhất một khung giờ !';
    		}

    		if(empty($errors) && $form->isValid())
    		{
    			$category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('code' => $data['game']));

    			$rent = new \ZFlex\Entity\Rent;
    			$rent->setUsername(strip_tags($data['username']));
    			$rent->setPassword(strip_tags($data['password_hidden']));
    			if(!empty($data['description']))
    			{
    				$rent->setDescription(strip_tags($data['description']));
    			}
    			$rent->setCategory($category);
    			if(isset($data['is_ngunghoatdong']) && $rent->getStatus() != 2)
    			{
    				if($data['is_ngunghoatdong'] == 'on')
    				{
    					$rent->setStatus(3);
    				}
    			}else{
    				$rent->setStatus(1);
    			}
    			$rent->setRentTimes(0);
    			$rent->setSumMoney(0);
    			if(isset($data['is_giahan']))
    			{
    				if($data['is_giahan'] == 'on')
    				{
    					$rent->setIsGiaHan(1);
    				}
    			}else{
    				$rent->setIsGiaHan(0);
    			}
    			$rent->setRentTime(serialize($rent_time));
    			$rent->setCustomer($this->FrontendData()->CustomerInfo());
    			$rent->setTimeCreated(\Carbon\Carbon::now());
    			$em->persist($rent);
    			$em->flush();
    			return $this->redirect()->toRoute('shop/defaults',array('action' => 'shop-edit','id' => $rent->getId()));
    		}
    	}
		return $this->loadTemplate(array('pass_random' => $pass_random,'errors' => $errors,'form' => $form));
	}

	public function shopEditAction()
	{
		$sm = $this->getServiceLocator();
		$id = $this->params()->fromRoute('id');
		if(!$id) return $this->redirect()->toRoute('shop');
		$form = $sm->get('FormElementManager')->get('CsrfForm');
		$em = $this->getEM();
		$customer = $this->FrontendData()->CustomerInfo();
		$rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id,'customer' => $customer));
		if(!empty($rent))
		{
			
			$request = $this->getRequest();
			$rent_time = [];
			$errors = [];
			
			if($request->isPost())
	    	{
	    		$data = $request->getPost()->toArray();
	    		$form->setData($data);
	    		if(array_key_exists('hours',$data))
	    		{
	    			foreach($data['money'] as $key => $money)
		    		{
						if(array_key_exists($key,$data['hours']))
		    			{
		    				if($money != '')
		    				{
		    					$rent_time[$key] = $money;
		    				}
		    			}
		    			
		    		}
	    		}else{
	    			$errors[] = 'Bạn đã tắt tất cả khung giờ , phải có ít nhất 1 khung giờ được bật !';
	    		}

	    		if($data['money'][3] == '' && $data['money'][8] == '' && $data['money'][20] == '' && $data['money'][36] == '' && $data['money'][72] == '')
	    		{
	    			$errors[] = 'Bạn đã nhập giá cho ít nhất một khung giờ !';
	    		}
	    		
	    		if(empty($errors) && $form->isValid())
	    		{
	    			$category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('code' => $data['game']));

	    			$rent->setUsername(strip_tags($data['username']));
	    			if(!empty($data['description']))
	    			{
	    				$rent->setDescription(strip_tags($data['description']));
	    			}
	    			$rent->setCategory($category);
	    			if(isset($data['is_giahan']))
	    			{
	    				if($data['is_giahan'] == 'on')
	    				{
	    					$rent->setIsGiaHan(1);
	    				}
	    			}else{
	    				$rent->setIsGiaHan(0);
	    			}
	    			if(isset($data['is_ngunghoatdong']) && $rent->getStatus() != 2)
	    			{
	    				if($data['is_ngunghoatdong'] == 'on')
	    				{
	    					$rent->setStatus(3);
	    				}
	    			}else{
	    				$rent->setStatus(1);
	    			}
	    			$rent->setRentTime(serialize($rent_time));
	    			$em->persist($rent);
	    			$em->flush();
	    			
	    		}
	    	}
			return $this->loadTemplate(array('rent' => $rent,'form' => $form));
		}else{
			echo "Bạn đã bị hệ thống ghi lại về hành động truy cập vào sản phẩm của người khác!<br><a href='".$this->url()->fromRoute("shop/defaults",array('action' => 'shop-dashboard'))."'>Quay lại shop</a>";
			\ZFlex\Framework\Log\Logger::write(\ZFlex\Framework\Log\Logger::HACKER_BUG,$customer->getFbName(). "(id:".$customer->getId().",fb_id:".$customer->getFbId().",ip:".$this->Data()->getIP()->ip.") nghi vấn muốn phá hoại (url:".$this->getRequest()->getUriString().")!",\Zend\Log\Logger::WARN);
			return $this->getResponse();
		}
		
	}

    public function shopSettingAction()
    {
    	$shop = $this->FrontendData()->ShopInfo()[0];
    	$request = $this->getRequest();
    	if($request->isPost())
    	{
    		$sm = $this->getServiceLocator();
    		$em = $this->getEM();
    		$data = array_merge_recursive($request->getPost()->toArray(), $request->getFiles()->toArray());
			$shop = $em->getRepository('ZFlex\Entity\Shop')->findOneBy(array('customer' => $this->FrontendData()->CustomerInfo()));
    		$shop->setUrlFacebook($data['url_facebook']);
    		$shop->setPhoneNumber($data['phone_number']);
    		$shop->setBank($data['bank']);
    		$shop->setStkBank($data['stk_bank']);
    		$shop->setCtkBank($data['ctk_bank']);
    		if($data['banner']['tmp_name'])
    		{
    			$location = $sm->get('config')['upload_location_banner'];
	    		$tmp_name = $data['banner']['tmp_name'];
	    		if(file_exists($location.$data['banner']['name'])) {
	    			$filename = time().$data['banner']['name'];
	  			}else{
	  				$filename = $data['banner']['name'];
	  			}

	  			if($shop->getBanner() != 'default_banner.jpg')
	  			{
	  				unlink($location.$shop->getBanner());
	  			}
	  			move_uploaded_file($tmp_name,$location.$filename);
	  			$shop->setBanner($filename);
    		}
    		
		    $em->persist($shop);
		    $em->flush();
    		return $this->redirect()->toRoute('shop/defaults',array('action' => 'shop-setting'));
    		
    	}
        return $this->loadTemplate(array('shop' => $shop));
    }
}
