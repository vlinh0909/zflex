<?php
namespace ZFlexFrontend\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Data extends AbstractPlugin
{
    public function getEM()
    {
        return $this->getController()->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    public function CustomerInfo()
    {
        $id  = $this->getController()->Framework()->FacebookInfo('id');
        return $this->getEM()->getRepository('ZFlex\Entity\Customer')->findOneBy(array('fb_id' => $id));
    }

    public function ShopInfo()
    {
    	if($this->CustomerInfo())
    	{
        	$qb = $this->getEM()->getRepository('ZFlex\Entity\Shop')->createQueryBuilder('shop')->select('shop')->where('shop.customer = '.$this->CustomerInfo()->getId());
			$result = $qb->getQuery()->getArrayResult();
			return $result;
    	}
    }

    public function Rent()
    {
        $qb = $this->getEM()->getRepository('ZFlex\Entity\Rent')->createQueryBuilder('rent')->select('rent');
        $result = $qb->getQuery()->getArrayResult();
        return $result;
    }

    public function ReportRent($id)
    {
        $em = $this->getEM();
        $report_rent = $em->getRepository('ZFlex\Entity\ReportRent')->findBy(array('shop' => $id),array('id' => 'DESC'));
        return $report_rent;
    }

    public function AjaxRentList($status)
    {
        $em = $this->getEM();
        $customer = $this->CustomerInfo();
        $value_array = [];
        if($status == 0)
        {
            $rent = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('customer' => $customer),array('id' => 'DESC'));
        }else{
            $rent = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('customer' => $customer,'status' => $status),array('id' => 'DESC'));
        }

        if($status == 2)
        {
            foreach($rent as $k => $v){
                $time_end = \Carbon\Carbon::parse($v->getHistoryRent()->last()->getTimeEnd());
                $value_array[] = [
                    'id' => $v->getId(),
                    'username' => $v->getUsername(),
                    'rent_times' => $v->getRentTimes(),
                    'sum_money' => $v->getSumMoney(),
                    'game' => $v->getCategory()->getName(),
                    'status' => $v->getStatus(),
                    'khach_dang_thue' => $v->getHistoryRent()->last()->getCustomer()->getFbName(),
                    'vuot_thoi_gian' => $time_end->gt(\Carbon\Carbon::now())
                ];
            }
        }else{
            foreach($rent as $k => $v){
                if($v->getStatus() == 2)
                {
                $time_end = \Carbon\Carbon::parse($v->getHistoryRent()->last()->getTimeEnd());
                $value_array[] = [
                    'id' => $v->getId(),
                    'username' => $v->getUsername(),
                    'rent_times' => $v->getRentTimes(),
                    'sum_money' => $v->getSumMoney(),
                    'status' => $v->getStatus(),
                    'khach_dang_thue' => $v->getHistoryRent()->last()->getCustomer()->getFbName(),
                    'game' => $v->getCategory()->getName(),
                    'vuot_thoi_gian' => $time_end->gt(\Carbon\Carbon::now())
                ];
                }else{
                $value_array[] = [
                    'id' => $v->getId(),
                    'username' => $v->getUsername(),
                    'rent_times' => $v->getRentTimes(),
                    'sum_money' => $v->getSumMoney(),
                    'status' => $v->getStatus(),
                    'game' => $v->getCategory()->getName(),
                ];
                }
            }
        }
        return $value_array;
    }

    public function AjaxRentSearch($key_search,$status_search)
    {
        $em = $this->getEM();
        $customer = $this->CustomerInfo();
        $value_array = [];
        if(!empty($customer))
        {
            if($status_search == 0)
            {
                $rent = $em->getRepository("ZFlex\Entity\Rent")->createQueryBuilder('o')
                   ->where('o.customer = :customer')
                   ->andWhere('o.username LIKE :username')
                   ->setParameter('customer', $customer)
                   ->setParameter('username', '%'.$key_search.'%')
                   ->getQuery()
                   ->getResult();
            }else{
                $rent = $em->getRepository("ZFlex\Entity\Rent")->createQueryBuilder('o')
                   ->where('o.customer = :customer')
                   ->andWhere('o.username LIKE :username')
                   ->andWhere('o.status = :status')
                   ->setParameter('customer', $customer)
                   ->setParameter('status', $status_search)
                   ->setParameter('username', '%'.$key_search.'%')
                   ->getQuery()
                   ->getResult();
            }
        
        foreach($rent as $k => $v){
            if($v->getStatus() == 2)
            {
            $time_end = \Carbon\Carbon::parse($v->getHistoryRent()->last()->getTimeEnd());
            $value_array[] = [
                'id' => $v->getId(),
                'username' => $v->getUsername(),
                'rent_times' => $v->getRentTimes(),
                'sum_money' => $v->getSumMoney(),
                'status' => $v->getStatus(),
                'khach_dang_thue' => $v->getHistoryRent()->last()->getCustomer()->getFbName(),
                'game' => $v->getCategory()->getName(),
                'vuot_thoi_gian' => $time_end->gt(\Carbon\Carbon::now())
            ];
            }else{
            $value_array[] = [
                'id' => $v->getId(),
                'username' => $v->getUsername(),
                'rent_times' => $v->getRentTimes(),
                'sum_money' => $v->getSumMoney(),
                'status' => $v->getStatus(),
                'game' => $v->getCategory()->getName(),
            ];
            }
        }
        return $value_array;
        }
    }

    public function AjaxCountRent($code = 'home',$id = 0)
    {
        $em = $this->getEM();
        if($code == 'home')
        {
            if($id != 0){
                $rents = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 1,'customer' => $id));
                $rents_ed = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 2,'customer' => $id));
            }else{
                $rents = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 1));
                $rents_ed = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 2));
            }
        }else{
            $category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('code' => $code));
            if($id != 0){
                $rents = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 1,'customer' => $id,'category' => $category));
                $rents_ed = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 2,'customer' => $id,'category' => $category));
            }else{
                $rents = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 1,'category' => $category));
                $rents_ed = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('status' => 2,'category' => $category));
            }
        }
        return [
            'rent_sansang' => count($rents),
            'rent_dathue' => count($rents_ed)
        ];
    }

    public function AjaxRent($code = 'home',$ready = 1,$page = 1,$id = 0)
    {
        $sm = $this->getController()->getServiceLocator();
        $value_array = [];
        $em = $this->getEM();
        if($code == 'home')
        {
            // $rents = $this->getEM()->getRepository('ZFlex\Entity\Rent')->findAll();
            $pagingConfig = array(
              'ItemCountPerPage' => 16,
              'CurrentPageNumber' => $page,
              'StatusRent' => $ready,
              'CustomerId' => $id
            );
            $repository = $em->getRepository('ZFlex\Entity\Rent');
            $paginator = new \ZFlexPL\Paginator\Paginator;
            $rent = $paginator->make($repository,$pagingConfig);
        }else{
            $category = $this->getEM()->getRepository('ZFlex\Entity\Category')->findOneBy(array('code' => $code))->getId();
            // $rent = $category->getRent();
            $pagingConfig = array(
              'ItemCountPerPage' => 16,
              'CurrentPageNumber' => $page,
              'StatusRent' => $ready,
              'CategoryId' => $category,
              'CustomerId' => $id
            );
            $repository = $em->getRepository('ZFlex\Entity\Rent');
            $paginator = new \ZFlexPL\Paginator\Paginator;
            $rent = $paginator->make($repository,$pagingConfig);
        }
        
        if($ready == 1)
        {
          foreach($rent as $k => $v)
            {
               if($v->getStatus() == $ready)
                {
                    $value_array[] = [
                        'id' => $v->getId(),
                        'description' => $v->getDescription(),
                        'img' => $v->getCategory()->getImage(),
                        'shop_name' => $v->getCustomer()->getShop()->getShopName(),
                        'url_shop' => $this->getController()->url()->fromRoute('shop_info',array('id' => $v->getCustomer()->getShop()->getId())),
                        'url_facebook' => $v->getCustomer()->getShop()->getUrlFacebook(),
                        'rent_time' => unserialize($v->getRentTime())
                    ];
                }  
            }  
        }else{
            foreach($rent as $k => $v)
            {
               if($v->getStatus() == $ready)
                {
                    $value_array[] = [
                        'id' => $v->getId(),
                        'description' => $v->getDescription(),
                        'img' => $v->getCategory()->getImage(),
                        'shop_name' => $v->getCustomer()->getShop()->getShopName(),
                        'url_shop' => $this->getController()->url()->fromRoute('shop_info',array('id' => $v->getCustomer()->getShop()->getId())),
                        'url_facebook' => $v->getCustomer()->getShop()->getUrlFacebook(),
                        'rent_time' => unserialize($v->getRentTime()),
                        'time_end' => $v->getHistoryRent()->last()->getTimeEnd()
                    ];
                }  
            }  
        }
        
        
        return $value_array;
    }

    public function CheckShop()
    {
        $em = $this->getEM();
        if($this->CustomerInfo()->getOpenShop() == 1){
            $shop = $em->getRepository('ZFlex\Entity\Shop')->findOneBy(array('customer' => $this->CustomerInfo() ));
            if($shop->getShopName() == '' | $shop->getUrlFacebook() == '' | $shop->getPhoneNumber() == '' | $shop->getBanner() == '' | $shop->getBank() == '' | $shop->getStkBank() == '' | $shop->getCtkBank() == '')
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }

    public function ChietKhau($number)
    {
        $number = (int) $number;
        $minus = $number * (25 / 100);
        $result =(int) $number - (int) $minus;
        return $result;
    }

    public function MainMenu()
    {
        $em = $this->getEM();
        $sm = $this->getController()->getServiceLocator();
        $url = $sm->get('ViewHelperManager')->get('url');
        $menu = $em->getRepository('ZFlex\Entity\Menu')->findOneBy(array('code' => 'main_menu'));
        return Menu(unserialize($menu->getData()),$url);
    }
}


function Menu($menu,$url)
{
    $result = [];
    foreach($menu as $k => $v){
        if($v->type == 'categories')
        {
            if(!empty($v->children))
            {
                $children = Menu($v->children,$url);
                $result[] = [
                    'title' => $v->title,
                    'target' => $v->target,
                    'url' => $url->__invoke($v->id),
                    'children' => $children
                ];
            }else{
                $result[] = [
                    'title' => $v->title,
                    'target' => $v->target,
                    'url' => $url->__invoke($v->id)
                ];
            }
        }else if($v->type == 'custom'){
            if(!empty($v->children))
            {
                $children = Menu($v->children,$url);
                $result[] = [
                    'title' => $v->title,
                    'url' => $v->url,
                    'target' => $v->target,
                    'children' => $children
                ];
            }else{
                $result[] = [
                    'title' => $v->title,
                    'url' => $v->url,
                    'target' => $v->target
                ];
            }
        }
    }
    return $result;
}