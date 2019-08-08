<?php
namespace ZFlexPL\Data;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class WidgetData extends AbstractPlugin
{

	public static function WidgetData()
	{
		return array(
			array(
				'link' => 'https://facebook.com',
			    'color' => 'red',
			    'label' => 'Tổng thu nhập',
			    'icon' => 'icon-cart4',
			    'values' => array(
			      'prefix' => '',
			      'value' => '100000',
			      'stuffix' => '$'
			    )
			),
			array(
				'link' => 'https://google.com',
			    'color' => 'green',
			    'label' => 'Thành viên',
			    'icon' => 'icon-users',
			    'values' => array(
			      'prefix' => '',
			      'value' => '4',
			      'stuffix' => ''
			    )
			),
			array(
				'link' => 'https://twitter.com',
			    'color' => 'blue',
			    'label' => 'Like Fanpage',
			    'icon' => 'icon-facebook',
			    'values' => array(
			      'prefix' => '',
			      'value' => '433',
			      'stuffix' => 'Like'
			    )
			),
			array(
				'link' => 'https://instagram.com',
			    'color' => 'orange',
			    'label' => 'Tổng thu nhập',
			    'icon' => 'icon-cart4',
			    'values' => array(
			      'prefix' => '',
			      'value' => '100000',
			      'stuffix' => ''
			    )
			),
		);
	}
}