<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

class AclController extends Controller
{
	public function deniedAction()
    {
        return new ViewModel();
    }
}