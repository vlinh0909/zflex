<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class RoleManager implements ServiceManagerAwareInterface
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
		$serialize = new \Zend\Serializer\Adapter\PhpSerialize;
		$access = $serialize->serialize($dataInput['zflex']);
		$role = new \ZFlex\Entity\Role;
		$role->setName(strip_tags($dataInput['name']));
		$role->setSlug(strip_tags($dataInput['slug']));
		$role->setAccess($access);
		$em->persist($role);
		$em->flush();
		
	}

	public function edit(Array $dataInput,$role)
	{
		$em = $this->getEM();
		$serialize = new \Zend\Serializer\Adapter\PhpSerialize;
		$access = $serialize->serialize($dataInput['zflex']);
		$role->setName(strip_tags($dataInput['name']));
		$role->setSlug(strip_tags($dataInput['slug']));
		$role->setAccess($access);
		$em->persist($role);
		$em->flush();
		
	}

}