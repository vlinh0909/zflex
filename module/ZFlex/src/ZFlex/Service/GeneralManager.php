<?php
namespace ZFlex\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class GeneralManager implements ServiceManagerAwareInterface
{
	private $sm;

	public function setServiceManager(ServiceManager $sm)
	{
		$this->sm = $sm;
	}

	public function getServiceLocator()
	{
		return $this->sm;
	}

	public function getEM()
	{
		return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
	}

	public function Multi($data,$entity,$status = 'status')
	{
		$sm = $this->getServiceLocator();
		$em = $this->getEM();
		$ids = implode(',',$data['id']);
		$qb = $em->createQueryBuilder();
		switch ($data['action']) {
			case 'deleted':
				$arr = explode('\\',$entity);
	        	foreach($data['id'] as $id)
	        	{
	        		$sm->get(ucfirst(array_values(array_slice($arr, -1))[0]).'Manager')->delete($id);
	        	}
				break;
			case 'activated':
		        $query = $qb->update($entity,'o')
		        			->set("o.$status",'1')
		                    ->where("o.id in ($ids)")
		                    ->getQuery();
		        $results = $query->execute();
	        	foreach ($results as $result){
		          	$em->persist($result);
		        }
		        $em->flush();
				break;
			case 'disabled':
		        $query = $qb->update($entity,'o')
		        			->set("o.$status",'0')
		                    ->where("o.id in ($ids)")
		                    ->getQuery();
		        $results = $query->execute();
	        	foreach ($results as $result){
		          	$em->persist($result);
		        }
		        $em->flush();
				break;
		}
        
	}
}