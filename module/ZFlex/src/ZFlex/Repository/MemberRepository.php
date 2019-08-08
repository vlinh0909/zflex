<?php
namespace ZFlex\Repository;

use Doctrine\ORM\EntityRepository;

/*
\ Dùng cho phân trang
*/

class MemberRepository extends EntityRepository
{
	public function Paginator(Array $data)
	{
		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();
		$qb->select('o')->from('\ZFlex\Entity\Member','o')
						->setMaxResults($data['ItemCountPerPage'])
						->setFirstResult(($data['CurrentPageNumber'] - 1) * $data['ItemCountPerPage']);
		$member = $qb->getQuery();
		return $member;
	}
}