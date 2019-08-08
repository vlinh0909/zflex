<?php
namespace ZFlex\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
* @ORM\Entity
* @ORM\Entity(repositoryClass="\ZFlex\Repository\MemberRepository")
* @ORM\Table(name="members")
*/
class Member
{
	/**
	* @ORM\Id
	* @ORM\Column(name="id")
	* @ORM\GeneratedValue
	*/
	protected $id;
	/**
	* @ORM\Column(name="email")
	*/
	protected $email;
	/**
	* @ORM\Column(name="username")
	*/
	protected $username;
	/**
	* @ORM\Column(name="password")
	*/
	protected $password;
	/**
	* @ORM\Column(name="fullname")
	*/
	protected $fullname;
	/**
	* @ORM\ManyToOne(targetEntity="\ZFlex\Entity\Permission",inversedBy="member")
	* @ORM\JoinColumn(name="permission",referencedColumnName="id")
	*/
	protected $permission;
	/**
	* @ORM\Column(name="status")
	*/
	protected $status;
	/**
	* @ORM\Column(name="image")
	*/
	protected $image;
	/**
	* @ORM\Column(name="time_created")
	*/
	protected $time_created;
	
	public function __construct()
    {
    	$this->permission = new ArrayCollection();
    }

	/* == ID == */

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	/* == EMAIL == */

	public function setEmail($email)
	{	
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}

	/* == USERNAME == */

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getUsername()
	{
		return $this->username;
	}

	/* == PASSWORD == */

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getPassword()
	{
		return $this->password;
	}

	/* == FULLNAME == */

	public function setFullName($fullname)
	{
		$this->fullname = $fullname;
	}

	public function getFullName()
	{
		return $this->fullname;
	}

	/* == PERMISSION == */

	public function setPermission($permission)
	{
		$this->permission = $permission;
	}

	public function getPermission()
	{
		return $this->permission;
	}

	/* == STATUS == */

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getStatus()
	{
		return $this->status;
	}

	/* == IMAGE == */

	public function setImage($image)
	{
		$this->image = $image;
	}

	public function getImage()
	{
		return $this->image;
	}

	/* == TIME_CREATED == */

	public function setTimeCreated($time_created)
	{
		$this->time_created = $time_created;
	}

	public function getTimeCreated()
	{
		return $this->time_created;
	}
}