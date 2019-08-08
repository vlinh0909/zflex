<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class PermissionManager implements ServiceManagerAwareInterface
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
		$role = $em->getRepository('\ZFlex\Entity\Role')->findOneBy(array('id' => $dataInput['role_id']));
		$permission = new \ZFlex\Entity\Permission;
		$permission->setName(strip_tags($dataInput['name']));
		$permission->setSlug(strip_tags($dataInput['slug']));
		$permission->setRoleId($role);
		$em->persist($permission);
		$em->flush();
		
	}

	public function edit(Array $dataInput,$permission)
	{
		$em = $this->getEM();
		$role = $em->getRepository('\ZFlex\Entity\Role')->findOneBy(array('id' => $dataInput['role_id']));
		$permission->setName(strip_tags($dataInput['name']));
		$permission->setSlug(strip_tags($dataInput['slug']));
		$permission->setRoleId($role);
		$em->persist($permission);
		$em->flush();
	
	}
}