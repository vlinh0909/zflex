<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="report_rent")
*/

class ReportRent
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="msg")
	*/
	protected $msg;
	/**
	* @ORM\Column(name="is_show")
	*/
	protected $is_show;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Rent",inversedBy="report_rent")
	* @ORM\JoinColumn(name="rent",referencedColumnName="id")
	*/
	protected $rent;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="report_rent")
	* @ORM\JoinColumn(name="customer",referencedColumnName="id")
	*/
	protected $customer;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Shop",inversedBy="report_rent")
	* @ORM\JoinColumn(name="shop",referencedColumnName="id")
	*/
	protected $shop;

	public function __construct()
	{
		$this->rent = new ArrayCollection;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setMsg($msg)
	{
		$this->msg = $msg;
	}

	public function getMsg()
	{
		return $this->msg;
	}

	public function setIsShow($is_show)
	{
		$this->is_show = $is_show;
	}

	public function getIsShow()
	{
		return $this->is_show;
	}


	public function setTimeCreated($time_created)
	{
		$this->time_created = $time_created;
	}

	public function getTimeCreated()
	{
		return $this->time_created;
	}

	public function setRent($rent)
	{
		$this->rent = $rent;
	}

	public function getRent()
	{
		return $this->rent;
	}

	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function setShop($shop)
	{
		$this->shop = $shop;
	}

	public function getShop()
	{
		return $this->shop;
	}
}
