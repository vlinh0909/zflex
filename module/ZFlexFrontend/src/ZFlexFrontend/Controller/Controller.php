<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZFlexFrontend\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

class Controller extends AbstractActionController
{

	protected $nameTheme;

	const TEMPLATE = "ZFlexFrontend/layout/";

	public function getEM()
	{
		return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}

	public function loadTemplate(Array $params = [])
	{
		$actionName = $this->params('action');
		$controller = explode("\\",$this->params('controller'));
		$controllerName = lcfirst(array_pop($controller));
		$params['action'] = $actionName;
		$viewModel = new ViewModel($params);
        $viewModel->setTemplate(self::TEMPLATE.$this->nameTheme."/".$controllerName."/".$actionName.".phtml");
        return $viewModel;
	}

    public function onDispatch(MvcEvent $e)
    {
    	$sm = $this->getServiceLocator();
    	// echo $this->Framework()->FacebookInfo('id');
    	$this->nameTheme = $sm->get('config')['website']['theme'];
        $reponse = parent::onDispatch($e);
        return $reponse;
    }

}
