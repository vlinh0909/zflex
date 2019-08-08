<?php
namespace ZFlexPL\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class Paginator{
	public function make($repository,Array $pagingConfig)
	{
	    $data = $repository->Paginator($pagingConfig);
	    $ormPaging = new ORMPaginator($data);
	    $adapter = new DoctrineAdapter($ormPaging);
	    $paging = new \Zend\Paginator\Paginator($adapter);
	    $paging->setDefaultItemCountPerPage($pagingConfig['ItemCountPerPage']);
	    $paging->setCurrentPageNumber($pagingConfig['CurrentPageNumber']);
	    return $paging;
	}
}