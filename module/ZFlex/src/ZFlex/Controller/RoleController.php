<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;

class RoleController extends Controller
{

	public function listAction()
	{
		$em = $this->getEM();
		$roles = $em->getRepository('ZFlex\Entity\Role')->findAll();
		return new ViewModel(array('roles' => $roles));
	}

	public function addAction()
	{
		$sm = $this->getServiceLocator();
		$form = $sm->get('FormElementManager')->get('RoleForm');
		$request = $this->getRequest();
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				$sm->get('RoleManager')->add($data);
				$this->flashMessenger()->addSuccessMessage("Thêm luật thành công");
				return $this->redirect()->toRoute('zflex/role',array('action' => 'list'));
			}
		}
		return new ViewModel(array('form' => $form));
	}

	public function editAction()
	{
		$id = $this->params()->fromRoute('id');
		$em = $this->getEM();
		$sm = $this->getServiceLocator();
		$form = $sm->get('FormElementManager')->get('RoleForm');
		$request = $this->getRequest();
		$role = $em->getRepository('ZFlex\Entity\Role')->findOneBy(array('id' => $id));
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				$sm->get('RoleManager')->edit($data,$role);
				$this->flashMessenger()->addSuccessMessage("Sửa luật thành công");
				
				return $this->redirect()->toRoute('zflex/role',array('action' => 'list'));
			}
		}
		$serialize = new \Zend\Serializer\Adapter\PhpSerialize();
		$access = $serialize->unserialize($role->getAccess());
		$form->setData(
			array(
				'name' => $role->getName(),
				'slug' => $role->getSlug(),
			)	
		);
		return new ViewModel(array('form' => $form,'id' => $role->getId(),'access' => $access));
	}

	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		$em = $this->getEM();
		$role = $em->getRepository('ZFlex\Entity\Role')->findOneBy(array('id' => $id));
		$ajax = $this->Ajax();
		return $ajax->DeleteAjax($role,$this->Config()->Ajax_ID('role'));
	}
}