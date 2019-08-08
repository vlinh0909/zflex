<?php
namespace ZFlexPL\Data;

class RoleData
{
	public static function RoleData()
	{
		return array(
			'zflex' => array(
				'dashboard' => array(
					'index' => array(
						'label' => 'Dashboard',
						'controller' => 'dashboard',
						'action' => 'index'
					)
				),
				'ajax' => array(
					'read-report' => array(
						'label' => 'Xử Lý Tố Cáo Shop',
						'controller' => 'ajax',
						'action' => 'read-report'
					),
					'withdraw' => array(
						'label' => 'Xử Lý Chuyển Tiền',
						'controller' => 'ajax',
						'action' => 'withdraw'
					)
				),
				'category' => array(
					'add' => array(
						'label' => 'Thêm Category',
						'controller' => 'category',
						'action' => 'add'
					),
					'edit' => array(
						'label' => 'Chỉnh Sửa Category',
						'controller' => 'category',
						'action' => 'edit'
					),
					'list' => array(
						'label' => 'Danh Sách Category',
						'controller' => 'category',
						'action' => 'list'
					),
					'delete' => array(
						'label' => 'Xóa Category',
						'controller' => 'category',
						'action' => 'delete'
					)
				),
				'category' => array(
					'add' => array(
						'label' => 'Thêm Category',
						'controller' => 'category',
						'action' => 'add'
					),
					'edit' => array(
						'label' => 'Chỉnh Sửa Category',
						'controller' => 'category',
						'action' => 'edit'
					),
					'list' => array(
						'label' => 'Danh Sách Category',
						'controller' => 'category',
						'action' => 'list'
					),
					'delete' => array(
						'label' => 'Xóa Category',
						'controller' => 'category',
						'action' => 'delete'
					)
				),
				'member' => array(
					'add' => array(
						'label' => 'Thêm Ban Quản Trị',
						'controller' => 'member',
						'action' => 'add'
					),
					'edit' => array(
						'label' => 'Chỉnh Sửa Ban Quản Trị',
						'controller' => 'member',
						'action' => 'edit'
					),
					'list' => array(
						'label' => 'Xem Danh Sách Ban Quản Trị',
						'controller' => 'member',
						'action' => 'list'
					),
					'delete' => array(
						'label' => 'Xóa Ban Quản Trị',
						'controller' => 'member',
						'action' => 'delete'
					),
					'multi' => array(
						'label' => 'Xử Lý Nhiều Dữ Liệu',
						'controller' => 'member',
						'action' => 'multi'
					),
				),
				'permission' => array(
					'add' => array(
						'label' => 'Thêm Quyền',
						'controller' => 'permission',
						'action' => 'add'
					),
					'edit' => array(
						'label' => 'Chỉnh Sửa Quyền',
						'controller' => 'permission',
						'action' => 'edit'
					),
					'list' => array(
						'label' => 'Xem Danh Sách Quyền',
						'controller' => 'permission',
						'action' => 'list'
					),
					'delete' => array(
						'label' => 'Xóa Quyền',
						'controller' => 'permission',
						'action' => 'delete'
					),
				),
				'role' => array(
					'add' => array(
						'label' => 'Thêm Luật',
						'controller' => 'role',
						'action' => 'add'
					),
					'edit' => array(
						'label' => 'Chỉnh Sửa Luật',
						'controller' => 'role',
						'action' => 'edit'
					),
					'list' => array(
						'label' => 'Xem Danh Sách Luật',
						'controller' => 'role',
						'action' => 'list'
					),
					'delete' => array(
						'label' => 'Xóa Luật',
						'controller' => 'role',
						'action' => 'delete'
					),
				),
				'customer' => array(
					'edit' => array(
						'label' => 'Sửa Khách Hàng',
						'controller' => 'customer',
						'action' => 'edit'
					),
					'list' => array(
						'label' => 'Xem Danh Sách Khách Hàng',
						'controller' => 'customer',
						'action' => 'list'
					),
				),
				'content' => array(
					'menu' => array(
						'label' => 'Danh Sách Menu',
						'controller' => 'content',
						'action' => 'menu'
					),
					'menu-add' => array(
						'label' => 'Thêm Menu',
						'controller' => 'content',
						'action' => 'menu-add'
					),
					'menu-edit' => array(
						'label' => 'Chỉnh Sửa Menu',
						'controller' => 'content',
						'action' => 'menu-edit'
					),
					'menu-delete' => array(
						'label' => 'Xóa Menu',
						'controller' => 'content',
						'action' => 'menu-delete'
					)
				),
				'rent' => array(
					'list' => array(
						'label' => 'Danh Sách Sản Phẩm',
						'controller' => 'rent',
						'action' => 'list'
					),
					'delete' => array(
						'label' => 'Xóa Sản Phẩm',
						'controller' => 'rent',
						'action' => 'delete'
					)
				),
				'media' => array(
					'index' => array(
						'label' => 'Danh Sách Media',
						'controller' => 'media',
						'action' => 'index'
					),
					'add' => array(
						'label' => 'Thêm Media',
						'controller' => 'media',
						'action' => 'add'
					),
					'load' => array(
						'label' => 'Load Media',
						'controller' => 'media',
						'action' => 'load'
					),
					'create-folder' => array(
						'label' => 'Tạo Thư Mục Media',
						'controller' => 'media',
						'action' => 'create-folder'
					),
					'load-delete-folder' => array(
						'label' => 'Xóa Thư Mục Media',
						'controller' => 'media',
						'action' => 'load-delete-folder'
					),
					'rename' => array(
						'label' => 'Đổi Tên Media',
						'controller' => 'media',
						'action' => 'rename'
					),
					'load-delete' => array(
						'label' => 'Xóa Ảnh Media',
						'controller' => 'media',
						'action' => 'load-delete'
					)

				),
				'setting' => array(
					'index' => array(
						'label' => 'Cài Đặt',
						'controller' => 'setting',
						'action' => 'index'
					)
				)
			)
		);
	}
}