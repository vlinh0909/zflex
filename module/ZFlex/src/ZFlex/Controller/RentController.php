<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;

class RentController extends Controller
{
	public function listAction()
	{
		$em = $this->getEM();
        $page =(int) $this->params()->fromRoute('page');
        $pagingConfig = array(
            'ItemCountPerPage' => 25,
            'CurrentPageNumber' => $page,
            'OrderBy' => 'DESC'
        );
        $repository = $em->getRepository('ZFlex\Entity\Rent');
        $paginator = new \ZFlexPL\Paginator\Paginator;
        $paging = $paginator->make($repository,$pagingConfig);
        return new ViewModel(array('paging' => $paging));
	}

	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
      	$ajax = $this->Ajax();
      	return $ajax->DeleteAjaxService($id,'RentManager');
	}
}	