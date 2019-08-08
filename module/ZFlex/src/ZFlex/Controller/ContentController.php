<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;

class ContentController extends Controller
{
	public function menuAction()
	{
		$em = $this->getEM();
		$menus = $em->getRepository('ZFlex\Entity\Menu')->findAll();
		return new ViewModel(array('menus' => $menus));
	}

	public function menuAddAction()
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$form = $sm->get('FormElementManager')->get('MenuForm');
		$categories = $em->getRepository('ZFlex\Entity\Category')->findAll();
		$value_options = array();
		foreach($categories as $category)
		{
			$value_options[$category->getId()] = $category->getName();
		}
		$request = $this->getRequest();
		if($request->isPost())
		{
			$data = $request->getPost();
			$form->setData($data);
			if($form->isValid())
			{
				$dataInput = $form->getData();
				$sm->get('MenuManager')->add($dataInput);
				$this->flashMessenger()->addSuccessMessage("Thêm menu thành công !");
				$this->redirect()->toRoute('zflex/content',array('action' => 'menu'));
			}
			
		}
		return new ViewModel(array('form' => $form,'categories' => $value_options));
	}

	public function menuEditAction()
	{
		$id = $this->params()->fromRoute('id');
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$form = $sm->get('FormElementManager')->get('MenuForm');
		\ZFlex\Framework\Validator::NoRecordExistsEdit($form,['name','code'],$id);
		$categories = $em->getRepository('ZFlex\Entity\Category')->findAll();
		$menu = $em->getRepository('ZFlex\Entity\Menu')->findOneBy(array('id' => $id));
		$value_options = array();
		foreach($categories as $category)
		{
			$value_options[$category->getId()] = $category->getName();
		}
		$request = $this->getRequest();
		if($request->isPost())
		{
			$data = $request->getPost();
			$form->setData($data);
			if($form->isValid())
			{
				$dataInput = $form->getData();
				$sm->get('MenuManager')->edit($dataInput,$menu);
				$this->flashMessenger()->addSuccessMessage("Sửa menu thành công !");
				$this->redirect()->toRoute('zflex/content',array('action' => 'menu'));
			}
			
		}
		$form->setData(
			array(
				'name' => $menu->getName(),
				'code' => $menu->getCode(),
				'status' => $menu->getStatus(),
				'data' => $menu->getData()
			)
		);
		return new ViewModel(array('form' => $form,'categories' => $value_options,'menu' => $menu->getData(),'id' => $menu->getId()));
	}

	public function menuDeleteAction()
	{
		$id = $this->params()->fromRoute('id');
		$ajax = $this->Ajax();
      	return $ajax->DeleteAjaxService($id,'MenuManager');
	}
}