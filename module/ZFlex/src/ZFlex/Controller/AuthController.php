<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

class AuthController extends Controller
{

	public function onDispatch(MvcEvent $e)
    {
        $reponse = parent::onDispatch($e);
        $this->layout()->setTemplate('layout/login');
        return $reponse;
    }

	public function loginAction()
	{		
		$sm = $this->getServiceLocator();
		$form = $sm->get('FormElementManager')->get('LoginForm');
		$request = $this->getRequest();
		$errors = [];
		$bcrypt = new \Zend\Crypt\Password\Bcrypt;
		if($request->isPost())
		{
			$data = $request->getPost()->toArray();
			$form->setData($data);
			if($form->isValid())
			{
				$dataInput = $form->getData();
				$authService = $sm->get('ZendAuth');
				$authService->getAdapter()
							->setIdentityValue(strip_tags($dataInput['username']))
							->setCredentialValue(strip_tags($dataInput['password']));
				$result = $authService->authenticate();
				if($result->isValid())
				{
					session_regenerate_id();
					$store = $result->getIdentity();
					$authService->getStorage()->write($store); 
					return $this->redirect()->toRoute('zflex');
				}
				else
				{
					$this->flashMessenger()->addWarningMessage('Sai tài khoản hoặc mật khẩu !');
				}
			}
		}
		return new ViewModel(array('form' => $form,'errors' => $errors));
	}

	public function logoutAction()
	{
		$sm = $this->getServiceLocator();
		$authService = $sm->get('ZendAuth');
		$authService->clearIdentity();
		return $this->redirect()->toRoute('zflex/auth');
	}
}