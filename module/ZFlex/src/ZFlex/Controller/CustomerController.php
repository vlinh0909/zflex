<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;

class CustomerController extends Controller
{

    public function listAction()
    {
      $em = $this->getEM();
      $page =(int) $this->params()->fromRoute('page');
      $pagingConfig = array(
          'ItemCountPerPage' => 20,
          'CurrentPageNumber' => $page 
      );
      $repository = $em->getRepository('ZFlex\Entity\Customer');
      $paginator = new \ZFlexPL\Paginator\Paginator;
      $paging = $paginator->make($repository,$pagingConfig);
      $flash = $this->flashMessenger()->getMessages();
      return new ViewModel(array('flash' => $flash,'paging' => $paging));
    }

    public function unlockAction()
    {
      $id = $this->params()->fromRoute('id');
      $em = $this->getEM();
      $customer = $em->getRepository('ZFlex\Entity\Customer')->find($id);
      $customer->setIsBlock(0);
      $em->persist($customer);
      $em->flush();
      return $this->redirect()->toRoute('zflex/customer',array('action' => 'list'));
    }

    public function lockAction()
    {
      $em = $this->getEM();
      $id =(int) $this->getRequest()->getPost('id');
      $value = $this->getRequest()->getPost('value');
      $customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('id' =>$id));
      $customer->setIsBlock(1);
      $em->persist($customer);
      $banned = new \ZFlex\Entity\Banned;
      $banned->setCustomer($customer);
      $banned->setReason($value);
      $banned->setTimeCreated(\Carbon\Carbon::now());
      $em->persist($banned);
      $em->flush();
      $ajax = new \Zend\View\Model\JsonModel(array(
          'result' => $value
      ));
      return $ajax;
    }

   	public function editAction()
   	{
   		$id = $this->params()->fromRoute('id');
        $sm = $this->getServiceLocator();
        $em = $this->getEM();
        $form = $sm->get('FormElementManager')->get('CustomerForm');
        $customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('id' => $id));
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();
            $form->setData($data);
            if($form->isValid())
            {
                if(is_numeric($data['money']))
                {
                $customer->setMoney((int) $data['money']);
                $em->persist($customer);
                $em->flush();
                return $this->redirect()->toRoute('zflex/customer',array('action' => 'list'));
                }
            }
        }
        return new ViewModel(array('form' => $form,'customer' => $customer));
   	}

}