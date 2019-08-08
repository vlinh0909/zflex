<?php
namespace ZFlex\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Path extends AbstractHelper
{
	protected $sm;

	public function __construct($sm)
	{
		$this->sm = $sm;
	}

	public function PathAvatar($image = null)
	{
		$path = $this->getView()->plugin('basepath');
        return $path('img/avatar/').$image;
	}

	public function PathIMG($image = null)
	{
		$path = $this->getView()->plugin('basepath');
        return $path('img/media/').$image;
	}

	public function DirIMG()
	{
		$sm = \Factory\ServiceLocatorFactory::getServiceLocator();
		$directory = $sm->get('config')['upload_location_img'];
		return $directory;
	}

	public function MemberList()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/member');
	}

	public function MemberAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/member',array('action' => 'add'));
	}

	public function MemberEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/member',array('action' => 'edit','id' => $id));
	}

	public function MemberDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/member',array('action' => 'delete','id' => $id));
	}

	public function PermissionList()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/permission');
	}

	public function PermissionAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/permission',array('action' => 'add'));
	}

	public function PermissionEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/permission',array('action' => 'edit','id' => $id));
	}

	public function PermissionDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/permission',array('action' => 'delete','id' => $id));
	}

	public function RoleList()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/role');
	}

	public function RoleAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/role',array('action' => 'add'));
	}

	public function RoleEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/role',array('action' => 'edit','id' => $id));
	}

	public function RoleDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/role',array('action' => 'delete','id' => $id));
	}

	public function MemberMulti()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/member',array('action' => 'multi'));
	}

	public function CustomerAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/customer',array('action' => 'add'));
	}

	public function CustomerDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/customer',array('action' => 'delete','id' => $id));
	}

	public function CustomerEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/customer',array('action' => 'edit','id' => $id));
	}

	public function CustomerMulti()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/customer',array('action' => 'multi'));
	}

	public function ProductAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'add'));
	}

	public function ProductEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'edit','id' => $id));
	}

	public function ProductMulti()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'multi'));
	}

	public function ProductDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'delete','id' => $id));
	}

	public function AttributeAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/attribute',array('action' => 'add'));
	}

	public function AttributeEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/attribute',array('action' => 'edit','id' => $id));
	}

	public function AttributeDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/attribute',array('action' => 'delete','id' => $id));
	}

	public function CategoryAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/category',array('action' => 'add'));
	}

	public function CategoryEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/category',array('action' => 'edit','id' => $id));
	}

	public function CategoryDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/category',array('action' => 'delete','id' => $id));
	}

	public function RentAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/rent',array('action' => 'add'));
	}

	public function RentEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/rent',array('action' => 'edit','id' => $id));
	}

	public function RentDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/rent',array('action' => 'delete','id' => $id));
	}

	public function MenuAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/content',array('action' => 'menu-add'));
	}

	public function MenuEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/content',array('action' => 'menu-edit','id' => $id));
	}

	public function MenuDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/content',array('action' => 'menu-delete','id' => $id));
	}

	public function ChampionAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'champion-add'));
	}

	public function ChampionEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'champion-edit','id' => $id));
	}

	public function ChampionDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'champion-delete','id' => $id));
	}

	public function SkinAdd()
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'skin-add'));
	}

	public function SkinEdit($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'skin-edit','id' => $id));
	}

	public function SkinDelete($id)
	{
		$path = $this->getView()->plugin('url');
        return $path('zflex/product',array('action' => 'skin-delete','id' => $id));
	}
}