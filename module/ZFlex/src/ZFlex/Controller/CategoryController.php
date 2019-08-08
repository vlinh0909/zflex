<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;

class CategoryController extends Controller
{

	public function addAction()
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$request = $this->getRequest();
		$form = $sm->get('FormElementManager')->get('CategoryForm');
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				// $dataInput = $form->getData();
				$sm->get('CategoryManager')->add($data);
				$this->flashMessenger()->addSuccessMessage("Thêm danh mục thành công !");
				$this->redirect()->toRoute('zflex/category',array('action' => 'list'));
			}
		}
		return new ViewModel(array('form' => $form));
	}


	public function listAction()
	{
		$em = $this->getEM();
		$categories = $em->getRepository('ZFlex\Entity\Category')->findAll();
		return new ViewModel(array('categories' => $categories));
	}

	public function editAction()
	{
		$id = $this->params()->fromRoute('id');
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$request = $this->getRequest();
		$form = $sm->get('FormElementManager')->get('CategoryForm');
		\ZFlex\Framework\Validator::NoRecordExistsEdit($form,['name','code'],$id);
		$category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('id' => $id));
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				// $dataInput = $form->getData();
				$sm->get('CategoryManager')->edit($data,$category);
				$this->flashMessenger()->addSuccessMessage("Sửa danh mục thành công !");
				$this->redirect()->toRoute('zflex/category',array('action' => 'list'));
			}
		}
		$form->setData(
			array(
				'code' => $category->getCode(),
				'name' => $category->getName(),
				'order_by' => $category->getOrderBy()
			)
		);
		$old_image = $category->getImage();
		return new ViewModel(array('form' => $form,'id' => $id,'old_image' => $old_image));
	}

	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		$ajax = $this->Ajax();
      	return $ajax->DeleteAjaxService($id,'CategoryManager');
	}

}