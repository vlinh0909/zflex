<?php
return array(
	'navigation' => array(
		'zflex' => array(
			array(
				'label' => 'Dashboard',
				'icon' => 'fa fa-tachometer',
				'route' => 'zflex',
				'resource' => 'zflex:dashboard',
			),
			array(
				'label' => 'Sản phẩm',
				'icon' => 'icon-cart',
				'route' => 'zflex/rent',
				'resource' => 'zflex:rent',
			),
			array(
				'label' => 'Game',
				'icon' => 'fa fa-sitemap',
				'route' => 'zflex/category',
				'resource' => 'zflex:category',
			),
			array(
				'label' => 'Appearence',
				'icon' => 'fa fa-paint-brush',
				'route' => 'zflex/content',
				'resource' => 'zflex:content',
				'hidden' => false,
				'pages' => array(
					array(
						'label' => 'Menu',
						'route' => 'zflex/content',
						'action' => 'menu'
					),
					array(
						'label' => 'Add Menu',
						'route' => 'zflex/content',
						'hidden' => true,
						'action' => 'menu-add'
					)
				)
			),
			array(
				'label' => 'Ban quản trị',
				'icon' => 'icon-man',
				'route' => 'zflex/member',
				'resource' => 'zflex:member',
				'hidden' => true,
				'pages' => array(
					array(
						'label' => 'Danh sách',
						'route' => 'zflex/member',
						'action' => 'list'
					),
					array(
						'label' => 'Thêm',
						'route' => 'zflex/member',
						'action' => 'add'
					),
					array(
						'label' => 'Sửa',
						'route' => 'zflex/member',
						'action' => 'edit'
					),
				)
			),
			array(
				'label' => 'Khách hàng',
				'icon' => 'icon-man',
				'route' => 'zflex/customer',
				'resource' => 'zflex:customer',
				'hidden' => true,
				'pages' => array(
					array(
						'label' => 'Danh sách',
						'route' => 'zflex/customer',
						'action' => 'list'
					),
					array(
						'label' => 'Thêm',
						'route' => 'zflex/customer',
						'action' => 'add'
					),
					array(
						'label' => 'Sửa',
						'route' => 'zflex/customer',
						'action' => 'edit'
					),
				)
			),
			array(
				'label'	=> 'Phân quyền',
				'icon' => 'icon-shield2',
				'route' => 'zflex/permission',
				'resource' => 'zflex:permission',
				'hidden' => true,
				'pages' => array(
					array(
						'label' => 'Danh sách',
						'route' => 'zflex/permission',
						'action' => 'list'
					),
					array(
						'label' => 'Thêm',
						'route' => 'zflex/permission',
						'action' => 'add'
					),
					array(
						'label' => 'Sửa',
						'route' => 'zflex/permission',
						'action' => 'edit'
					),
				)
			),
			array(
				'label' => 'Luật',
				'icon' => 'icon-lock2',
				'route' => 'zflex/role',
				'resource' => 'zflex:role',
				'hidden' => true,
				'pages' => array(
					array(
						'label' => 'Danh sách',
						'route' => 'zflex/role',
						'action' => 'list'
					),
					array(
						'label' => 'Thêm',
						'route' => 'zflex/role',
						'action' => 'add'
					),
					array(
						'label' => 'Sửa',
						'route' => 'zflex/role',
						'action' => 'edit'
					)
				)
			)
		)	
	)
);