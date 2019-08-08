<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="report_shop")
*/

class ReportShop
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="report_shop")
	* @ORM\JoinColumn(name="customer",referencedColumnName="id")
	*/
	protected $customer;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Shop",inversedBy="report_shop")
	* @ORM\JoinColumn(name="shop",referencedColumnName="id")
	*/
	protected $shop;
	/**
	* @ORM\Column(name="message")
	*/
	protected $message;
	/**
	* @ORM\Column(name="is_read")
	*/
	protected $is_read;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;

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

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setIsRead($is_read)
	{
		$this->is_read = $is_read;
	}

	public function getIsRead()
	{
		return $this->is_read;
	}

	public function setTimeCreated($time_created)
	{
		$this->time_created = $time_created;
	}

	public function getTimeCreated()
	{
		return $this->time_created;
	}
}
