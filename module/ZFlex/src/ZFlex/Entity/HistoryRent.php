<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="history_rent")
*/

class HistoryRent
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="username")
	*/
	protected $username;
	/**
	* @ORM\Column(name="password")
	*/
	protected $password;
	/**
	* @ORM\Column(name="price")
	*/
	protected $price;
	/**
	* @ORM\Column(name="time")
	*/
	protected $time;
	/**
	* @ORM\Column(name="time_rent")
	*/
	protected $time_rent;
	/**
	* @ORM\Column(name="time_end")
	*/
	protected $time_end;
	/**
	* @ORM\Column(name="giahan_times")
	*/
	protected $giahan_times;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="history_rent")
	* @ORM\JoinColumn(name="customer_id",referencedColumnName="id")
	*/
	protected $customer;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="history_rent_boss")
	* @ORM\JoinColumn(name="boss",referencedColumnName="id")
	*/
	protected $boss;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Rent",inversedBy="history_rent")
	* @ORM\JoinColumn(name="rent_id",referencedColumnName="id")
	*/
	protected $rent;


	public function __construct()
	{
		$this->rent = new ArrayCollection();
		$this->customer = new ArrayCollection();
		$this->boss = new ArrayCollection();
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function setTime($time)
	{
		$this->time = $time;
	}

	public function getTime()
	{
		return $this->time;
	}

	public function setGiaHanTimes($giahan_times)
	{
		$this->giahan_times = $giahan_times;
	}

	public function getGiaHanTimes()
	{
		return $this->giahan_times;
	}

    public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function setBoss($boss)
	{
		$this->boss = $boss;
	}

	public function getBoss()
	{
		return $this->boss;
	}

	public function setTimeRent($time_rent)
	{
		$this->time_rent = $time_rent;
	}

	public function getTimeRent()
	{
		return $this->time_rent;
	}

	public function setTimeEnd($time_end)
	{
		$this->time_end = $time_end;
	}

	public function getTimeEnd()
	{
		return $this->time_end;
	}

	public function setRent($rent)
	{
		$this->rent = $rent;
	}

	public function getRent()
	{
		return $this->rent;
	}
}
