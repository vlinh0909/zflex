<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

/*
\ Xử lý thêm,sửa,xóa các dữ liệu của bảng "member"
*/

class MemberManager implements ServiceManagerAwareInterface
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
		$sm = $this->getServiceLocator();
		$bcrypt = new \Zend\Crypt\Password\Bcrypt;
		$permission = $em->getRepository('\ZFlex\Entity\Permission')->findOneBy(array('id' => $dataInput['permission']));
		$member = new \ZFlex\Entity\Member;
		$member->setEmail($dataInput['email']);
        $member->setUsername(strip_tags($dataInput['username']));
        $member->setPassword(strip_tags($bcrypt->create($dataInput['password'])));
        $member->setFullName(strip_tags($dataInput['fullname']));
        $member->setPermission($permission);
        $member->setStatus(strip_tags($dataInput['status']));
        $member->setImage(strip_tags($dataInput['image']));
		$member->setTimeCreated(date('Y-m-d H:i:s'));
		$em->persist($member);
        $em->flush();
		
	}

	public function edit(Array $dataInput,$member)
	{
		$bcrypt = new \Zend\Crypt\Password\Bcrypt;
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$permission = $em->getRepository('\ZFlex\Entity\Permission')->findOneBy(array('id' => $dataInput['permission']));
		if(!empty($dataInput['image']))
		{
			$member->setImage(strip_tags($dataInput['image']));
		}
		if(!empty($dataInput['password']))
		{
			$member->setPassword(strip_tags($bcrypt->create($dataInput['password'])));
		}
		$member->setEmail(strip_tags($dataInput['email']));
		$member->setUsername(strip_tags($dataInput['username']));
		$member->setFullName(strip_tags($dataInput['fullname']));
		$member->setPermission($permission);
		$member->setStatus(strip_tags($dataInput['status']));
		$member->setTimeCreated(date('Y-m-d H:i:s'));
        $em->persist($member);
        $em->flush();
		
	}

	public function delete($id)
	{
		$em = $this->getEM();
        $member = $em->getRepository('\ZFlex\Entity\Member')->findOneBy(array('id' => $id));
        $em->remove($member);
        $em->flush(); 
	}
}