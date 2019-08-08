<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;

class PermissionController extends Controller
{

	public function listAction()
	{
		$em = $this->getEM();
		$permissions = $em->getRepository('ZFlex\Entity\Permission')->findAll();
		$flash = $this->flashMessenger()->getMessages();
		return new ViewModel(array('flash' => $flash,'permissions' => $permissions));		
	}

	public function addAction()
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$form = $sm->get('FormElementManager')->get('PermissionForm');
		$options = array();
		$roles = $em->getRepository('ZFlex\Entity\Role')->findAll();
		foreach($roles as $role){
			$options[$role->getId()] = $role->getName();
		}
		$form->get('role_id')->setValueOptions($options);
		$request = $this->getRequest();
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				$dataInput = $form->getData();
				$sm->get('PermissionManager')->add($dataInput);
				$this->flashMessenger()->addSuccessMessage("Thêm quyền ".$dataInput['name']." thành công !");
                return $this->redirect()->toRoute('zflex/permission',array('action' => 'list'));
			}
		}
		return new ViewModel(array('form' => $form));
	}

	public function editAction()
	{
		$id = $this->params()->fromRoute('id');
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$permission = $em->getRepository('ZFlex\Entity\Permission')->findOneBy(array('id' => $id));
		$form = $sm->get('FormElementManager')->get('PermissionForm');
		\ZFlex\Framework\Validator::NoRecordExistsEdit($form,'name',$id);
		\ZFlex\Framework\Validator::NoRecordExistsEdit($form,'slug',$id);
		$options = array();
		$roles = $em->getRepository('ZFlex\Entity\Role')->findAll();
		foreach($roles as $role){
			$options[$role->getId()] = $role->getName();
		}
		$form->get('role_id')->setValueOptions($options);
		$request = $this->getRequest();
		if($request->isPost())
		{
			$data = $request->getPost();
			$form->setData($data);
			if($form->isValid())
			{
				$dataInput = $form->getData();
				$sm->get('PermissionManager')->edit($dataInput,$permission);
				$this->flashMessenger()->addSuccessMessage("Sửa quyền ".$dataInput['name']." thành công !");
                return $this->redirect()->toRoute('zflex/permission',array('action' => 'list'));
			}
		}
		$form->setData(
			array(
				'name' => $permission->getName(),
				'slug' => $permission->getSlug(),
				'role_id' => $permission->getRoleId()->getId()
			)
		);
		return new ViewModel(array('form' => $form,'id' => $id,'name' => $permission->getName()));
	}

	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		$em = $this->getEM();
		$permission = $em->getRepository('ZFlex\Entity\Permission')->findOneBy(array('id' => $id));
		$ajax = $this->Ajax();
		return $ajax->DeleteAjax($permission,$this->Config()->Ajax_ID('permission'));
	}
}