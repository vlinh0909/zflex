<?php 
namespace ZFlexFrontend\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Data extends AbstractHelper
{

	protected $sm;

	public function __construct($sm)
	{
		$this->sm = $sm;
	}

	public function getEM()
	{
		$serviceLocator = \Factory\ServiceLocatorFactory::getServiceLocator();
		return $serviceLocator->get('doctrine.entitymanager.orm_default');
	}

    public function getServiceLocator()
    {
        $serviceLocator = \Factory\ServiceLocatorFactory::getServiceLocator();
        return $serviceLocator;
    }

	public function getProducts($game = null)
	{
		$em = $this->getEM();
        $products = $em->getRepository('ZFlex\Entity\Product')->findBy(array('status' => 1),array('id'=>'ASC'));
		return $products;
	}

    public function RankLabel($key)
    {
        $sm = $this->getServiceLocator();
        $plugin = $sm->get('ControllerPluginManager')->get('Data');
        $rank = $plugin->RankOptions();
        return $rank[$key];
    }

    public function getRepComment($id){
        $em = $this->getEM();
        $comment = $em->getRepository('ZFlex\Entity\CommentShop')->findBy(array('rep_comment' => $id));
        return $comment;
    }

    public function countRating()
    {
        if(!empty($this->CustomerInfo()))
        {
        $shop = $this->CustomerInfo()->getShop();
        $em = $this->getEM();
        $qb = $em->createQueryBuilder();
        $qb->select('count(comment_shop.id)');
        $qb->from('ZFlex\Entity\CommentShop','comment_shop');
        $qb->where('comment_shop.shop = :shop');
        $qb->andWhere('comment_shop.rep_comment = :rep_comment');
        $qb->setParameter('shop', $shop);
        $qb->setParameter('rep_comment', 0);
        $count = $qb->getQuery()->getSingleScalarResult();
        return $count;
        }
    }

    public function sumRating()
    {
        if(!empty($this->CustomerInfo()))
        {
        $shop = $this->CustomerInfo()->getShop();
        $em = $this->getEM();
        $qb = $em->createQueryBuilder();
        $qb->select('sum(comment_shop.score)');
        $qb->from('ZFlex\Entity\CommentShop','comment_shop');
        $qb->where('comment_shop.shop = :shop');
        $qb->andWhere('comment_shop.rep_comment = :rep_comment');
        $qb->setParameter('shop', $shop);
        $qb->setParameter('rep_comment', 0);
        $sum = $qb->getQuery()->getSingleScalarResult();
        return $sum;
        }
    }

    public function MainMenu()
    {
        $em = $this->getEM();
        $menu = $em->getRepository('ZFlex\Entity\Menu')->findOneBy(array('code' => 'main_menu'));
        return unserialize($menu->getData());
    }

    public function FrameLabel($key)
    {
        $sm = $this->getServiceLocator();
        $plugin = $sm->get('ControllerPluginManager')->get('Data');
        $rank = $plugin->FrameOptions();
        return $rank[$key];
    }

    public function PriceProduct($price,$id)
    {
        $em = $this->getEM();
        $q = $em->createQuery("select u from ZFlex\Entity\Product u where u.price = $price and u.id != $id");
        return $q->getResult();
    }

    public function CustomerInfo()
    {
        $sm = $this->getServiceLocator();
        $id  = $sm->get('ControllerPluginManager')->get('Framework')->FacebookInfo('id');
        return $this->getEM()->getRepository('ZFlex\Entity\Customer')->findOneBy(array('fb_id' => $id));
    }

    public function HistoryRent()
    {
        return $this->getEM()->getRepository('ZFlex\Entity\HistoryRent')->findBy(array('boss' => $this->CustomerInfo()));
    }

    public function NameTheme()
    {
        $sm = $this->getServiceLocator();
        return $sm->get('config')['website']['theme'];
    }

    public function CheckShop()
    {
        $em = $this->getEM();
        if($this->CustomerInfo())
        {
            if($this->CustomerInfo()->getOpenShop() == 1){
                $shop = $em->getRepository('ZFlex\Entity\Shop')->findOneBy(array('customer' => $this->CustomerInfo() ));
                if($shop->getShopName() == '' | $shop->getUrlFacebook() == '' | $shop->getPhoneNumber() == '' | $shop->getBanner() == '' | $shop->getBank() == '' | $shop->getStkBank() == '' | $shop->getCtkBank() == '')
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    }

    public function Category()
    {
        $em = $this->getEM();
        $categories = $em->getRepository('ZFlex\Entity\Category')->findBy(array(),array('order_by' => 'DESC'));
        $value_options = [];
        foreach($categories as $category)
        {
            $value_options[$category->getCode()] = $category->getName();
        }
        return $value_options;

    }

    public function ReportRent($id)
    {
        $em = $this->getEM();
        $report_rent = $em->getRepository('ZFlex\Entity\ReportRent')->findBy(array('shop' => $id),array('id' => 'DESC'));
        return $report_rent;
    }
}