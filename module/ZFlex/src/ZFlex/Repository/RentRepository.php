<?php
namespace ZFlex\Repository;

use Doctrine\ORM\EntityRepository;

/*
\ Dùng cho phân trang
*/

class RentRepository extends EntityRepository
{
	public function Paginator(Array $data)
	{
		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();
		if(!empty($data['OrderBy']))
		{
			$qb->select('o')->from('\ZFlex\Entity\Rent','o')
						->setMaxResults($data['ItemCountPerPage'])
						->setFirstResult(($data['CurrentPageNumber'] - 1) * $data['ItemCountPerPage'])
						->orderBy('o.id','DESC');;
		}else{
			$qb->select('o')->where('o.status = '.$data['StatusRent'].(!empty($data['CategoryId']) ? ' AND o.category = '.$data['CategoryId'] : '').(($data['CustomerId'] != 0) ? ' AND o.customer = '.$data['CustomerId'] : ''))->from('\ZFlex\Entity\Rent','o')
						->setMaxResults($data['ItemCountPerPage'])
						->setFirstResult(($data['CurrentPageNumber'] - 1) * $data['ItemCountPerPage']);
		}
		
		$rent = $qb->getQuery();
		return $rent;
	}
}