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
use Exception;

class CardController extends Controller
{

    public function cardAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('FormElementManager')->get('CardForm');
        return $this->loadTemplate(array('form' => $form));   
    }

    public function cardHandingAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            if ($this->getRequest()->isPost()) {
                $customer = $this->FrontendData()->CustomerInfo();
                if(!empty($customer))
                {
                    $gamebank = new \ZFlex\Framework\Gamebank;
                    $seri =strip_tags($this->getRequest()->getPost('seri'));
                    $pin = strip_tags($this->getRequest()->getPost('pin'));
                    $card_type_id = strip_tags($this->getRequest()->getPost('card_type_id'));
                    $data = $gamebank->CardCharging($seri,$pin,$card_type_id);
                    $ajax = new \Zend\View\Model\JsonModel(array(
                        'result' => $data,
                        'code' => $data['code']
                    ));
                    if($data['code'] == 0)
                    {
                        if($data['info_card'] != 0 && is_numeric($data['info_card']))
                        {
                            $fb_id = $customer->getFbId();
                            $em = $this->getEM();
                            $customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('fb_id' => $fb_id));
                            $before_money = $customer->getMoney();
                            $current_money =(int) $before_money + (int) $data['info_card'];
                            $customer->setMoney($current_money);
                            $em->persist($customer);
                            $em->flush();
                        }
                    }
                    return $ajax;
                }
            }
        }else{
            return $this->redirect()->toRoute('home');
        }
    }
}
