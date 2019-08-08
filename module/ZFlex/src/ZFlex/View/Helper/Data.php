<?php 
namespace ZFlex\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Data extends AbstractHelper
{

	protected $sm;

    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function getEM()
    {
        return $this->sm->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    public function ReportShop($id = null)
    {
    	$em = $this->getEM();
        if($id)
        {
    	$report_shop = $em->getRepository('ZFlex\Entity\ReportShop')->findBy(array('shop' => $id),array('id' => 'DESC'));
        }else{
        $report_shop = $em->getRepository('ZFlex\Entity\ReportShop')->findBy(array(),array('id' => 'DESC')); 
        }
    	return $report_shop;
    }

    public function Site()
    {
        return $this->sm->getServiceLocator()->get('config')['website'];
    }

    public function Bank()
    {
        $bank = array(
            'vietcombank' => 'Vietcombank',
            'bidv' => 'BIDV',
            'acb' => 'ACB',
            'vietinbank' => 'Vietinbank',
            'techcombank' => 'Techcombank',
            'vpbank' => 'VPBank',
            'agribank' => 'Agribank',
            'mbbank' => 'MBBank',
            'shb' => 'SHB'
        );
        return $bank;
    }
    
    public function RequestWithdraw($id = null)
    {
        $em = $this->getEM();
        if($id)
        {
        $request_withdraw = $em->getRepository('ZFlex\Entity\Withdraw')->findBy(array('customer' => $id),array('id' => 'DESC'));
        }else{
        $request_withdraw = $em->getRepository('ZFlex\Entity\Withdraw')->findBy(array(),array('id' => 'DESC')); 
        }
        return $request_withdraw;
    }

    public function getIP()
    {
        $json = file_get_contents('https://freegeoip.net/json/');
        $obj = json_decode($json);
        return $obj;
    }

    public function RentByCustomer($customer)
    {
        $em = $this->getEM();
        $rent = $em->getRepository('ZFlex\Entity\Rent')->findBy(array('boss' => $customer),array('id' => 'DESC'));
        return $rent;
    }

    public function CountReport()
    {
        $em = $this->getEM();
        $count = [];
        $count['readed'] = count($em->getRepository('ZFlex\Entity\ReportShop')->findBy(array('is_read' => 1)));
        $count['read'] = count($em->getRepository('ZFlex\Entity\ReportShop')->findBy(array('is_read' => 0)));
        return $count;
    }

    public function CountWithdraw()
    {
        $em = $this->getEM();
        $count = [];
        $count['sended'] = count($em->getRepository('ZFlex\Entity\Withdraw')->findBy(array('is_send' => 1)));
        $count['send'] = count($em->getRepository('ZFlex\Entity\Withdraw')->findBy(array('is_send' => 0)));
        return $count;
    }

    public function CountRent()
    {
        $em = $this->getEM();
        $count = count($em->getRepository('ZFlex\Entity\Rent')->findAll());
        return $count;
    }

    public function CountCustomer()
    {
        $em = $this->getEM();
        $count = count($em->getRepository('ZFlex\Entity\Customer')->findAll());
        return $count;
    }

    public function CountMember()
    {
        $em = $this->getEM();
        $count = count($em->getRepository('ZFlex\Entity\Member')->findAll());
        return $count;
    }

    public function CountShop()
    {
        $em = $this->getEM();
        $count = count($em->getRepository('ZFlex\Entity\Shop')->findAll());
        return $count;
    }
}