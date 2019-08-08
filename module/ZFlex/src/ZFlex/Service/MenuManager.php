<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class MenuManager implements ServiceManagerAwareInterface
{
	private $sm;

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
        die('sorry :(');
		$menu = new \ZFlex\Entity\Menu;
		$menu->setName(strip_tags($dataInput['name']));
		$menu->setCode(strip_tags($dataInput['code']));
		$menu->setData(serialize(json_decode($dataInput['data'])));
		$menu->setStatus(strip_tags($dataInput['status']));
		$menu->setTimeCreated(\Carbon\Carbon::now());

		$em->persist($menu);
		$em->flush();
	}

	public function edit(Array $dataInput,$menu)
	{
		$em = $this->getEM();
		$menu->setName(strip_tags($dataInput['name']));
		$menu->setCode(strip_tags($dataInput['code']));
		$menu->setData(serialize(json_decode($dataInput['data'])));
		$menu->setStatus(strip_tags($dataInput['status']));
		$menu->setTimeCreated(\Carbon\Carbon::now());

		$em->persist($menu);
		$em->flush();
		
	}

	public function delete($id)
	{
		$em = $this->getEM();
        $menu = $em->getRepository('ZFlex\Entity\Menu')->findOneBy(array('id' => $id));
        $em->remove($menu);
        $em->flush(); 
	}
}