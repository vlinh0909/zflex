<?php
namespace ZFlex\Controller\Plugin;
	
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Ajax extends AbstractPlugin
{
	public function getEM()
	{
		return $this->getController()->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}

	public function DeleteAjax($entity,$_id = 0)
	{
		$em = $this->getEM();
		$data = '';
		if($entity->getId() == $_id)
		{
			$data = 'warning';
		}else{
			$data = 'ok';
			$em->remove($entity);
        	$em->flush();
		}
		$ajax = new \Zend\View\Model\JsonModel(array(
            'result' => $data,
	    ));
	    return $ajax;
	}

	public function DeleteAjaxService($id,$entity,$_id = 0)
	{
				$sm = $this->getController()->getServiceLocator();
				$data = '';
				if($id == $_id)
				{
					$data = 'warning';
				}else{
					$data = 'ok';
					$sm->get($entity)->delete($id);
				}
				$ajax = new \Zend\View\Model\JsonModel(array(
		            'result' => $data,
			    ));
			    return $ajax;
	}

}