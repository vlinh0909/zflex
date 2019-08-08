<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class CategoryManager implements ServiceManagerAwareInterface
{
	protected $sm;

	public function setServiceManager(ServiceManager $sm)
	{
		$this->sm = $sm;
	}

	public function getServiceLocator()
	{
		return $this->sm;
	}

	public function getEM()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    public function add(Array $dataInput)
    {
    	$em = $this->getEM();
    	$category = new \ZFlex\Entity\Category;
		$category->setCode(strip_tags($dataInput['code']));
		$category->setName(strip_tags($dataInput['name']));
		$category->setImage(strip_tags($dataInput['image']));
		$category->setOrderBy(strip_tags($dataInput['order_by']));
		$em->persist($category);
		$em->flush();
    }

    public function edit(Array $dataInput,$category)
    {
    	$em = $this->getEM();
		$category->setCode(strip_tags($dataInput['code']));
		$category->setName(strip_tags($dataInput['name']));
		$category->setImage(strip_tags($dataInput['image']));
		$category->setOrderBy(strip_tags($dataInput['order_by']));
		$em->persist($category);
		$em->flush();
    }

    public function delete($id)
    {
    	$em = $this->getEM();
		$category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('id' => $id));
		// $attributes = $category->getAttribute();
		// foreach($attributes as $attribute)
		// {
		// 	$category->removeAttribute($attribute);
		// }
		$em->remove($category);
		$em->flush();
    }
}