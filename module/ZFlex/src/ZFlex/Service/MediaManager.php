<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class MediaManager implements ServiceManagerAwareInterface
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

	public function make()
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$directory = $sm->get('config')['upload_location_img'];
        $images = glob($directory . "*.*");
        $media =array();
        foreach($images as $image)
        {
          $media[] = basename($image);
        }
		$filename = $sm->get('config')['upload_location_img'].'\\';
		$images = array();
		foreach($media as $image)
		{
			$images[$image]['name'] = $image;
			$images[$image]['size'] = filesize($filename.$image) / 1024;
			$images[$image]['mime'] = getimagesize($filename.$image)['mime'];
			$images[$image]['time'] = date('h:i:s d/m/Y',filemtime($filename.$image));
		}
		return $images;
	}

	public function add($file)
	{
		$em = $this->getEM();
		$sm = $this->getServiceLocator();
		$gallery = new \ZFlex\Framework\Gallery;
		$location = $gallery->getFullDir();
		$validator = new \Zend\Validator\File\Exists();
        $validator->addDirectory($location);
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $adapter->setValidators(array(),$file['name']);
        if($validator->isValid($file['name'])){
            $adapter->setDestination($location);
            if($adapter->receive($file['name']))
            {   
                return true;
            }
        }else{
            $adapter->setDestination($location);
            if($adapter->receive($file['name']))
            {   
                return true;
            }
        }
	}

	public function edit(Array $dataInput,$member)
	{
		
	}

	public function delete($image)
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$gallery = new \ZFlex\Framework\Gallery;
		$location = $gallery->getFullDir();
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        unlink($location.$image);
	}
}