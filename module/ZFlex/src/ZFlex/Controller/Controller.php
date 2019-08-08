<?php
namespace ZFlex\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class Controller extends AbstractActionController
{
	public function getEM()
	{
		return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}

	public function onDispatch(MvcEvent $e)
    {
        $reponse = parent::onDispatch($e);
        $this->layout()->setTemplate('layout/backend');
        return $reponse;
    }
}