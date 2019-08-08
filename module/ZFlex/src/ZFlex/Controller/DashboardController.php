<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;
use ZFlex\Framework\Log\Logger;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return new ViewModel();
    }

    
}
