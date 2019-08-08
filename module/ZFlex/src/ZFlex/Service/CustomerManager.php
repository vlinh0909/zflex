<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class CustomerManager implements ServiceManagerAwareInterface
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
		$sm = $this->getServiceLocator();
		$bcrypt = new \Zend\Crypt\Password\Bcrypt;
		$location =$sm->get('config')['upload_location_avatar'];
		$validator = new \Zend\Validator\File\Exists();
		$validator->addDirectory($location);
		$adapter = new \Zend\File\Transfer\Adapter\Http();
		$adapter->setValidators(array(),$dataInput['image']['name']);
		$customer = new \ZFlex\Entity\Customer;
		$customer->setEmail($dataInput['email']);
        $customer->setUsername($dataInput['username']);
        $customer->setPassword($bcrypt->create($dataInput['password']));
        $customer->setPrice($dataInput['price']);
        $customer->setStatus($dataInput['status']);
		$customer->setTimeCreated(date('Y-m-d H:i:s'));
		if($validator->isValid($dataInput['image']['name'])){
			$name_folder = str_replace(".","-",$dataInput['image']['name'].time());
			$new_folder = $location."/".$name_folder;
			mkdir($new_folder);
			$adapter->setDestination($new_folder);
			if($adapter->receive($dataInput['image']['name']))
			{	
				$customer->setImage($name_folder."/".$dataInput['image']['name']);
			}
		}else{
			$adapter->setDestination($location);
			if($adapter->receive($dataInput['image']['name']))
			{	
				$customer->setImage($dataInput['image']['name']);
			}
		}
		$em->persist($customer);
        $em->flush();
	}

	public function edit(Array $dataInput,$customer)
	{
		$bcrypt = new \Zend\Crypt\Password\Bcrypt;
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$location =$sm->get('config')['upload_location_avatar'];
		if(!empty($dataInput['image']['name']))
		{
			$image = $customer->getImage();
			unlink($location.'/'.$image);
			$validator = new \Zend\Validator\File\Exists();
	        if (stripos($image, "/") !== false) {
	            $arr_image = explode('/',$image);
	            rmdir($location."/".$arr_image[0]);
				$validator->addDirectory($location.$arr_image[0]);
	        }else{
	        	$validator->addDirectory($location);
	        }
	        $adapter = new \Zend\File\Transfer\Adapter\Http();
			$adapter->setValidators(array(),$dataInput['image']['name']);
			if($validator->isValid($dataInput['image']['name'])){
				$name_folder = str_replace(".","-",$dataInput['image']['name'].time());
				$new_folder = $location."/".$name_folder;
				mkdir($new_folder);
				$adapter->setDestination($new_folder);
				if($adapter->receive($dataInput['image']['name']))
				{	
					$customer->setImage($name_folder."/".$dataInput['image']['name']);
				}
			}else{
				$adapter->setDestination($location);
				if($adapter->receive($dataInput['image']['name']))
				{	
					$customer->setImage($dataInput['image']['name']);
				}
			}
		}
		if(!empty($dataInput['password']))
		{
			$customer->setPassword($bcrypt->create($dataInput['password']));
		}
		$customer->setEmail($dataInput['email']);
		$customer->setUsername($dataInput['username']);
		$customer->setPrice($dataInput['price']);
		$customer->setStatus($dataInput['status']);
		$customer->setTimeCreated(date('Y-m-d H:i:s'));
        $em->persist($customer);
        $em->flush();
		
	}

	public function delete($id)
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$location =$sm->get('config')['upload_location_avatar'];
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $customer = $em->getRepository('ZFlex\Entity\Customer')->findOneBy(array('id' => $id));
        $image = $customer->getImage();
        unlink($location.'/'.$image);
        if (stripos($image, "/") !== false) {
            $arr_image = explode('/',$image);
            rmdir($location."/".$arr_image[0]);
        }
        $em->remove($customer);
        $em->flush(); 
	}
}