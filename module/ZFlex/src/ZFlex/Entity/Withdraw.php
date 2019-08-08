<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="withdraw")
*/

class Withdraw
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="withdraw")
	* @ORM\JoinColumn(name="customer",referencedColumnName="id")
	*/
	protected $customer;
	/**
	* @ORM\Column(name="note")
	*/
	protected $note;
	/**
	* @ORM\Column(name="is_send")
	*/
	protected $is_send;
	/**
	* @ORM\Column(name="money")
	*/
	protected $money;
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

	public function setNote($note)
	{
		$this->note = $note;
	}

	public function getNote()
	{
		return $this->note;
	}

	public function setMoney($money)
	{
		$this->money = $money;
	}

	public function getMoney()
	{
		return $this->money;
	}

	public function setIsSend($is_send)
	{
		$this->is_send = $is_send;
	}

	public function getIsSend()
	{
		return $this->is_send;
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
