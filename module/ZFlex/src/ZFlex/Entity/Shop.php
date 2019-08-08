<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="shop")
*/

class Shop
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="shop_name")
	*/
	protected $shop_name;
	/**
	* @ORM\Column(name="url_facebook", options={"default":""})
	*/
	protected $url_facebook;
	/**
	* @ORM\Column(name="phone_number", options={"default":""})
	*/
	protected $phone_number;
	/**
	* @ORM\Column(name="banner", options={"default":""})
	*/
	protected $banner;
	/**
	* @ORM\Column(name="bank", options={"default":""})
	*/
	protected $bank;
	/**
	* @ORM\Column(name="stk_bank", options={"default":""})
	*/
	protected $stk_bank;
	/**
	* @ORM\Column(name="ctk_bank", options={"default":""})
	*/
	protected $ctk_bank;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;
	/**
    * @ORM\OneToOne(targetEntity="\ZFlex\Entity\Customer", inversedBy="shop")
    * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
    */
	protected $customer;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\CommentShop",mappedBy="shop")
	* @ORM\JoinColumn(name="id",referencedColumnName="shop")
	*/
	protected $comment_shop;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\ReportShop",mappedBy="shop")
	* @ORM\JoinColumn(name="id",referencedColumnName="shop")
	*/
	protected $report_shop;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\ReportRent",mappedBy="shop")
	* @ORM\JoinColumn(name="id",referencedColumnName="shop")
	*/
	protected $report_rent;

	public function __construct()
	{

	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setShopName($shop_name)
	{
		$this->shop_name = $shop_name;
	}

	public function getShopName()
	{
		return $this->shop_name;
	}

	public function setUrlFacebook($url_facebook)
	{
		$this->url_facebook = $url_facebook;
	}

	public function getUrlFacebook()
	{
		return $this->url_facebook;
	}

	public function setPhoneNumber($phone_number)
	{
		$this->phone_number = $phone_number;
	}

	public function getPhoneNumber()
	{
		return $this->phone_number;
	}

	public function setBanner($banner)
	{
		$this->banner = $banner;
	}

	public function getBanner()
	{
		return $this->banner;
	}

	public function setBank($bank)
	{
		$this->bank = $bank;
	}

	public function getBank()
	{
		return $this->bank;
	}

	public function setStkBank($stk_bank)
	{
		$this->stk_bank = $stk_bank;
	}

	public function getStkBank()
	{
		return $this->stk_bank;
	}
	public function setCtkBank($ctk_bank)
	{
		$this->ctk_bank = $ctk_bank;
	}

	public function getCtkBank()
	{
		return $this->ctk_bank;
	}

	public function setTimeCreated($time_created)
	{
		$this->time_created = $time_created;
	}

	public function getTimeCreated()
	{
		return $this->time_created;
	}

	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function setCommentShop($comment_shop)
    {
    	$this->comment_shop = $comment_shop;
    }

    public function getCommentShop()
    {
    	return $this->comment_shop;
    }

    public function setReportShop($report_shop)
    {
    	$this->report_shop = $report_shop;
    }

    public function getReportShop()
    {
    	return $this->report_shop;
    }

    public function setReportRent($report_rent)
    {
    	$this->report_rent = $report_rent;
    }

    public function getReportRent()
    {
    	return $this->report_rent;
    }

}
