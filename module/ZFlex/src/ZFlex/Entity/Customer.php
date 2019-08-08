<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Entity(repositoryClass="\ZFlex\Repository\CustomerRepository")
* @ORM\Table(name="customers")
*/

class Customer
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="fb_id")
	*/
	protected $fb_id;
	/**
	* @ORM\Column(name="fb_name")
	*/
	protected $fb_name;
	/**
	* @ORM\Column(name="money")
	*/
	protected $money;
	/**
	* @ORM\Column(name="open_shop")
	*/
	protected $open_shop;
	/**
	* @ORM\Column(name="is_block")
	*/
	protected $is_block;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;
	/**
    * @ORM\OneToOne(targetEntity="\ZFlex\Entity\Shop", mappedBy="customer",cascade={"remove"})
    */
	protected $shop;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\Banned",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer_id")
	*/
	protected $banned;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\Rent",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer_id")
	*/
	protected $rent;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\HistoryRent",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer_id")
	*/
	protected $history_rent;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\HistoryRent",mappedBy="boss")
	* @ORM\JoinColumn(name="id",referencedColumnName="boss")
	*/
	protected $history_rent_boss;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\ReportRent",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer")
	*/
	protected $report_rent;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\CommentShop",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer")
	*/
	protected $comment_shop;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\ReportShop",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer")
	*/
	protected $report_shop;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\Withdraw",mappedBy="customer")
	* @ORM\JoinColumn(name="id",referencedColumnName="customer")
	*/
	protected $withdraw;

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

	public function setMoney($money)
	{	
		$this->money = $money;
	}

	public function getMoney()
	{
		return $this->money;
	}

	public function setFbId($fb_id)
	{
		$this->fb_id = $fb_id;
	}

	public function getFbId()
	{
		return $this->fb_id;
	}

	public function setFbName($fb_name)
	{
		$this->fb_name = $fb_name;
	}

	public function getFbName()
	{
		return $this->fb_name;
	}

	public function setOpenShop($open_shop)
	{
		$this->open_shop = $open_shop;
	}

	public function getOpenShop()
	{
		return $this->open_shop;
	}

	public function setTimeCreated($time_created)
	{
		$this->time_created = $time_created;
	}

	public function getTimeCreated()
	{
		return $this->time_created;
	}

	public function setShop($shop)
	{
		$this->shop = $shop;
	}

	public function getShop()
	{
		return $this->shop;
	}

	public function setIsBlock($is_block)
	{
		$this->is_block = $is_block;
	}

	public function getIsBlock()
	{
		return $this->is_block;
	}

	public function setBanned($banned)
	{
		$this->banned = $banned;
	}

	public function getBanned()
	{
		return $this->banned;
	}

	public function setRent($rent)
	{
		$this->rent = $rent;
	}

	public function getRent()
	{
		return $this->rent;
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
}
