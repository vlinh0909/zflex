<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Entity(repositoryClass="\ZFlex\Repository\RentRepository")
* @ORM\Table(name="rents")
*/

class Rent
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
	* @ORM\Column(name="description")
	*/
	protected $description;
	/**
	* @ORM\Column(name="rent_times")
	*/
	protected $rent_times;
	/**
	* @ORM\Column(name="sum_money")
	*/
	protected $sum_money;
	/**
	* @ORM\Column(name="status")
	*/
	protected $status;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Category",inversedBy="rent")
	* @ORM\JoinColumn(name="category",referencedColumnName="id")
	*/
	protected $category;
	/**
	* @ORM\Column(name="rent_time")
	*/
	protected $rent_time;
	/**
	* @ORM\Column(name="is_giahan")
	*/
	protected $is_giahan;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="rent")
	* @ORM\JoinColumn(name="customer_id",referencedColumnName="id")
	*/
	protected $customer;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\HistoryRent",mappedBy="rent")
	* @ORM\JoinColumn(name="id",referencedColumnName="rent_id")
	*/
	protected $history_rent;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\HistoryRent",mappedBy="boss")
	* @ORM\JoinColumn(name="id",referencedColumnName="boss")
	*/
	protected $history_rent_boss;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\ReportRent",mappedBy="rent")
	* @ORM\JoinColumn(name="id",referencedColumnName="rent")
	*/
	protected $report_rent;

	public function __construct()
    {
    	$this->history_rent = new ArrayCollection();
    	$this->customer = new ArrayCollection();
    	$this->report_rent = new ArrayCollection();
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

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setIsGiaHan($is_giahan)
	{
		$this->is_giahan = $is_giahan;
	}

	public function getIsGiaHan()
	{
		return $this->is_giahan;
	}

	public function setRentTimes($rent_times)
	{
		$this->rent_times = $rent_times;
	}

	public function getRentTimes()
	{
		return $this->rent_times;
	}

	public function setSumMoney($sum_money)
	{
		$this->sum_money = $sum_money;
	}

	public function getSumMoney()
	{
		return $this->sum_money;
	}

	public function setCategory($category)
	{
		$this->category = $category;
	}

	public function getCategory()
	{
		return $this->category;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function setRentTime($rent_time)
	{
		$this->rent_time = $rent_time;
	}

	public function getRentTime()
	{
		return $this->rent_time;
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

	public function setHistoryRent($history_rent)
	{
		$this->history_rent = $history_rent;
	}

	public function getHistoryRent()
	{
		return $this->history_rent;
	}

	public function setHistoryRentBoss($history_rent_boss)
	{
		$this->history_rent_boss = $history_rent_boss;
	}

	public function getHistoryRentBoss()
	{
		return $this->history_rent_boss;
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
