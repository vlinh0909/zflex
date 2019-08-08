<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="comment_shop")
*/

class CommentShop
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Customer",inversedBy="comment_shop")
	* @ORM\JoinColumn(name="customer",referencedColumnName="id")
	*/
	protected $customer;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Shop",inversedBy="comment_shop")
	* @ORM\JoinColumn(name="shop",referencedColumnName="id")
	*/
	protected $shop;
	/**
	* @ORM\Column(name="content")
	*/
	protected $content;
	/**
	* @ORM\Column(name="rep_comment")
	*/
	protected $rep_comment;
	/**
	* @ORM\Column(name="score")
	*/
	protected $score;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;

	public function __construct()
	{
		$this->category = new ArrayCollection;
		$this->entity = new ArrayCollection;
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

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setRepComment($rep_comment)
	{
		$this->rep_comment = $rep_comment;
	}

	public function getRepComment()
	{
		return $this->rep_comment;
	}

	public function setScore($score)
	{
		$this->score = $score;
	}

	public function getScore()
	{
		return $this->score;
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
