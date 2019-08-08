<?php
namespace ZFlexPL\Controller\Plugin;
	
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;

class AclPlugin extends AbstractPlugin
{
	protected $role;
	protected $access;

	public function getAuthService()
	{
		$sm = $this->getController()->getServiceLocator();
		$authService = $sm->get('ZendAuth');
		if($authService->hasIdentity())
		{
			$user = $authService->getStorage()->read();
			$this->role = $user->getPermission()->getSlug();
			$this->access = $user->getPermission()->getRoleId()->getAccess();
		}else{
			$this->role = 'guest';
		}
		return $this->role;
	}

	public function getAccess()
	{
		return $this->access;
	}

	public function configACL()
	{
		$role = $this->getAuthService();
		$acl = new Acl;
		$acl->deny();
		$acl->addRole(new Role('guest'));
		if($role != 'super_adminstrator' && $role != 'guest'){
			$acl->addRole(new Role($role),array('guest'));
		}
		$acl->addRole(new Role('super_adminstrator'));
		$acl->addResource('zflex')
			->addResource('zflex:member','zflex')
			->addResource('zflex:dashboard','zflex')
			->addResource('zflex:role','zflex')
			->addResource('zflex:permission','zflex')
			->addResource('zflex:auth','zflex')
			->addResource('zflex:customer','zflex')
			->addResource('zflex:media','zflex')
			->addResource('zflex:category','zflex')
			->addResource('zflex:rent','zflex')
			->addResource('zflex:content','zflex')
			->addResource('zflex:setting','zflex')
			->addResource('zflex:ajax','zflex')
			->addResource('zflex:ip','zflex')
			->addResource('zflex:acl','zflex');

		if(!empty($this->getAccess())){
			$serialize = new \Zend\Serializer\Adapter\PhpSerialize;
			$rule = $serialize->unserialize($this->getAccess());
			if($role != 'super_adminstrator' && $role != 'guest'){
				$rule['acl'] = array('denied');
				$rule['auth'] = array('logout');
			}
			$acl->allow('guest','zflex:auth',array('login'));	
			$acl->allow('guest','zflex:acl',array('denied'));	

			if($role != 'super_adminstrator' && !empty($rule))
			{
				$module = 'zflex';
				foreach($rule as $controller => $action)
				{
					$acl->allow($role,"$module:$controller",$action);
				}
		}
		}
		$acl->allow('super_adminstrator');

		return $acl;
	}

	public function RoleAccess($e)
	{
		$role = $this->getAuthService();
		$acl = $this->configACL();
		$route = $e->getRouteMatch();
        $controller = $route->getParam('controller');
        $arr = explode('\\',$controller);
        $moduleName = strtolower(substr($controller,0,strpos($controller,'\\')));
        $controllerName = strtolower(array_pop($arr));
        $actionName = $route->getParam('action');
        if(!$acl->isAllowed($role,$moduleName.':'.$controllerName,$actionName))
        {
            $response = $e->getResponse();
            $response->setStatusCode(403)->setContent('Forbidden');
            $response->sendHeaders(); 
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
				$e->stopPropagation();
			}
        }
	}
}