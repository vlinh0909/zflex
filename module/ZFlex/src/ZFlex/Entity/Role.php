<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="roles")
*/
class Role
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="name")
	*/
	protected $name;
	/**
	* @ORM\Column(name="slug")
	*/
	protected $slug;
	/**
	* @ORM\Column(name="access")
	*/
	protected $access;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\Permission",mappedBy="role_id")
	* @ORM\JoinColumn(name="id",referencedColumnName="role_id")
	*/
	protected $permission;

	public function __construct()
    {
    	$this->permission = new ArrayCollection();
    }

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return  $this->name;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

	public function getSlug()
	{
		return  $this->slug;
	}

	public function setAccess($access)
	{
		$this->access = $access;
	}

	public function getAccess()
	{
		return  $this->access;
	}

	public function getPermission()
	{
		return $this->permission;
	}
}