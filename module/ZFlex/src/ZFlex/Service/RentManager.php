<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class RentManager implements ServiceManagerAwareInterface
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
    	$category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('code' => $dataInput['category']));
		$rent = new \ZFLex\Entity\Rent;
		$rent->setUsername($dataInput['username']);
		$rent->setPassword($dataInput['password']);
		$rent->setStatus($dataInput['status']);
		$rent->setDescription($dataInput['description']);
		$rent->setCategory($category);
		$rent->setTimeCreated(\Carbon\Carbon::now());
		$em->persist($rent);
		$em->flush();
    }

    public function edit(Array $dataInput,$rent)
    {
    	$em = $this->getEM();
    	$category = $em->getRepository('ZFlex\Entity\Category')->findOneBy(array('code' => $dataInput['category']));
		$rent->setUsername($dataInput['username']);
		$rent->setPassword($dataInput['password']);
		$rent->setStatus($dataInput['status']);
		$rent->setDescription($dataInput['description']);
		$rent->setCategory($category);
		$rent->setTimeCreated(\Carbon\Carbon::now());
		$em->persist($rent);
		$em->flush();
    }

    public function delete($id)
    {
    	$em = $this->getEM();
    	$rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
    	$em->remove($rent);
    	$em->flush();
    }

    public function updatePassword($id)
    {
    	$em = $this->getEM();
    	$rent = $em->getRepository('ZFlex\Entity\Rent')->findOneBy(array('id' => $id));
		$rent->setTimeStart(null);
		$rent->setTimeEnd(null);
		$em->persist($rent);
		$em->flush();
    }

    
}