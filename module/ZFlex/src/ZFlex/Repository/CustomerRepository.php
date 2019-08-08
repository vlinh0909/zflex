<?php
namespace ZFlex\Repository;

use Doctrine\ORM\EntityRepository;

/*
\ Dùng cho phân trang
*/

class CustomerRepository extends EntityRepository
{
	public function Paginator(Array $data)
	{
		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();
		$qb->select('o')->from('\ZFlex\Entity\Customer','o')
						->setMaxResults($data['ItemCountPerPage'])
						->setFirstResult(($data['CurrentPageNumber'] - 1) * $data['ItemCountPerPage']);
		$customer = $qb->getQuery();
		return $customer;
	}
}