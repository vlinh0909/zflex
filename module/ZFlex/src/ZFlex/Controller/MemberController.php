<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManager;
use Zend\Session\Container;

class MemberController extends Controller
{

    public function listAction()
    {
        $em = $this->getEM();
        $page =(int) $this->params()->fromRoute('page');
        $pagingConfig = array(
            'ItemCountPerPage' => 10,
            'CurrentPageNumber' => $page 
        );
        $repository = $em->getRepository('ZFlex\Entity\Member');
        $paginator = new \ZFlexPL\Paginator\Paginator;
        $paging = $paginator->make($repository,$pagingConfig);
        $flash = $this->flashMessenger()->getMessages();
        return new ViewModel(array('flash' => $flash,'paging' => $paging));
    }

    public function addAction()
    {
    	$sm = $this->getServiceLocator();
        $em = $this->getEM();
    	$form = $sm->get('FormElementManager')->get('MemberForm');
        $cat = $em->getRepository("ZFlex\Entity\Member")->find(1);
        $permissions = $em->getRepository("ZFlex\Entity\Permission")->findAll();
        $options = array();
        foreach($permissions as $permission)
        {
            $options[$permission->getId()] = $permission->getName();
        }
        $form->get('permission')->setValueOptions($options);
        $request = $this->getRequest();
        if($request->isPost())
        {
            $post = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            $data = array_merge_recursive($post, $file);
            $form->setData($data);
            if($form->isValid())
            {
                $dataInput = $form->getData();
                $sm->get('MemberManager')->add($data);
                $this->flashMessenger()->addSuccessMessage("Thêm tài khoản thành công !");
                return $this->redirect()->toRoute('zflex/member',array('action' => 'list'));
            }
        }
    	return new ViewModel(array('form' => $form));
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        $sm = $this->getServiceLocator();
        $em = $this->getEM();
        $form = $sm->get('FormElementManager')->get('MemberForm');
        \ZFlex\Framework\Validator::NoRecordExistsEdit($form,['email','username'],$id);
        $member = $em->getRepository('ZFlex\Entity\Member')->findOneBy(array('id' => $id));
        $permissions = $em->getRepository("ZFlex\Entity\Permission")->findAll();
        $options = array();
        foreach($permissions as $permission)
        {
            $options[$permission->getId()] = $permission->getName();
        }
        $form->get('permission')->setValueOptions($options);
        $request = $this->getRequest();
        $form->getInputFilter()->get('password')->setRequired(false);
        $form->getInputFilter()->get('image')->setRequired(false);
        if($request->isPost())
        {
            $post = $request->getPost()->toArray();
            $file = $request->getFiles()->toArray();
            $data = array_merge_recursive($post, $file);
            $form->setData($data);
            if($form->isValid())
            {
                $dataInput = $form->getData();
                $editMember = $sm->get('MemberManager')->edit($dataInput,$member);
                $this->flashMessenger()->addSuccessMessage("Sửa tài khoản thành công !");
                return $this->redirect()->toRoute('zflex/member',array('action' => 'list'));
            }
        }
        $form->setData
        (
            array(
                'email' => $member->getEmail(),
                'username' => $member->getUsername(),
                'fullname' => $member->getFullName(),
                'permission' => $member->getPermission()->getId(),
                'status' => $member->getStatus()
            )
        );
        $old_image = $member->getImage();
        return new ViewModel(array('form' => $form,'old_image' => $old_image,'id' => $member->getId()));
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');
        $em = $this->getEM();
        $sm = $this->getServiceLocator();
        $authService = $sm->get('ZendAuth');
        $authService->getStorage()->read();
        if($authService->getId() != $id || $id == 1)
        {
            $ajax = $this->Ajax();
            return $ajax->DeleteAjaxService($id,'MemberManager',$this->Config()->Ajax_ID('member'));
        }
    }

    public function multiAction()
    {

        $sm = $this->getServiceLocator();
        $em = $this->getEM();
        $request = $this->getRequest();
        if($request->isPost())
        {
            $data = $request->getPost()->toArray();
            $sm->get('GeneralManager')->Multi($data,'ZFlex\Entity\Member');
        }
        $this->flashMessenger()->addSuccessMessage('Cập nhật thành công !');
        return $this->redirect()->toRoute('zflex/member',array('action'=>'list'));
    }

    public function clearAction() {
        $session = new Container("fb_info");
        $session->getManager()->getStorage()->clear('fb_info');
        return $this->redirect()->toRoute('zflex');
    }
}
