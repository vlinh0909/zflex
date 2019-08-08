<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class AjaxController extends Controller
{
	public function readReportAction()
    {
       	if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
            	$id = strip_tags($this->getRequest()->getPost('id'));
                if(is_numeric($id)):
                	$em = $this->getEM();
                	$report_shop = $em->getRepository('ZFlex\Entity\ReportShop')->findOneBy(array('id' => $id));
                	$report_shop->setIsRead(1);
                	$em->persist($report_shop);
                	$em->flush();
                	$data = 1;
                	$ajax = new JsonModel(array(
                        'result' => $data
                    ));
                    return $ajax;
                endif;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function withdrawAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $id = strip_tags($this->getRequest()->getPost('id'));
                if(is_numeric($id)):
                    $em = $this->getEM();
                    $withdraw = $em->getRepository('ZFlex\Entity\Withdraw')->findOneBy(array('id' => $id));
                    $withdraw->setIsSend(1);
                    $em->persist($withdraw);
                    $em->flush();
                    $data = true;
                    $ajax = new JsonModel(array(
                        'result' => $data
                    ));
                    return $ajax;
                endif;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }

    public function banIpAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $value = strip_tags($this->getRequest()->getPost('value'));
                $em = $this->getEM();
                $ip = new \ZFlex\Entity\BanIp;
                $ip->setIp($value);
                $em->persist($ip);
                $em->flush();
                $data = true;
                $ajax = new JsonModel(array(
                    'result' => $data
                ));
                return $ajax;
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }
}