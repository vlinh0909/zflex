<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="categories")
*/

class Category
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="code")
	*/
	protected $code;
	/**
	* @ORM\Column(name="name")
	*/
	protected $name;
	/**
	* @ORM\Column(name="order_by")
	*/
	protected $order_by;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\Rent",mappedBy="category")
	* @ORM\JoinColumn(name="id",referencedColumnName="category")
	*/
	protected $rent;
	/**
	* @ORM\Column(name="image")
	*/
	protected $image;

	public function __construct()
	{
		$this->rent = new ArrayCollection();
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setOrderBy($order_by)
	{
		$this->order_by = $order_by;
	}

	public function getOrderBy()
	{
		return $this->order_by;
	}

	public function setRent($rent)
	{
		$this->rent = $rent;
	}

	public function getRent()
	{
		return $this->rent;
	}

    public function setImage($image)
	{
		$this->image = $image;
	}

	public function getImage()
	{
		return $this->image;
	}
}
