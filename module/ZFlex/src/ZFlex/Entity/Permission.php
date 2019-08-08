<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Table(name="permissions")
*/
class Permission
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
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Role",inversedBy="permission")
	* @ORM\JoinColumn(name="role_id",referencedColumnName="id")
	*/
	protected $role_id;
	/**
	* @ORM\OneToMany(targetEntity="\ZFlex\Entity\Member",mappedBy="permission")
	* @ORM\JoinColumn(name="id",referencedColumnName="permission")
	*/
	protected $member;

	public function __construct()
    {
    	$this->role_id = new ArrayCollection();
    	$this->member = new ArrayCollection();
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

	public function setRoleId($role_id)
	{
		$this->role_id = $role_id;
	}

	public function getRoleId()
	{
		return $this->role_id;
	}

	public function getMember()
	{
		return $this->member;
	}
}