<?php 
namespace ZFlexFrontend\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Path extends AbstractHelper
{

	protected $sm;

	protected $nameTheme;

	public function __construct($sm)
	{
		$this->sm = $sm;
		$serviceLocator = \Factory\ServiceLocatorFactory::getServiceLocator();
		$this->nameTheme = $serviceLocator->get('config')['website']['theme'];
	}

	public function getServiceLocator()
	{
		return \Factory\ServiceLocatorFactory::getServiceLocator();
	}

	public function PublicTheme($_path = null)
	{
		$path = $this->getView()->plugin('basepath');
	    return $path("/".$this->nameTheme).$_path;
	}

	public function ThemeIMG($_path = null)
	{
		$path = $this->getView()->plugin('basepath');
	    return $path("/".$this->nameTheme."/img/").$_path;
	}

	public function BannerShop($image = null)
	{
		$path = $this->getView()->plugin('basepath');
        return $path('img/banner_shop/').$image;
	}

	public function LoginFacebook()
	{
		$url_login_fb = new \ZFlex\Framework\Framework;
		return $url_login_fb->URLLoginFacebook();
	}
}