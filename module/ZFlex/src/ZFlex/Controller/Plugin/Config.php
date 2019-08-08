<?php
namespace ZFlex\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Config extends AbstractPlugin
{
    public function Ajax_ID($name)
    {
        $sm = $this->getController()->getServiceLocator();
        if(empty($name))
		{
			$_id = $sm->get('config')['ajax']['delete']['_id'];
		}
		else{
			$_id = $sm->get('config')['ajax']['delete']['_id'][$name];
		}
		return $_id;
    }
}