<?php 
namespace ZFlex\View\Helper\Button;

class Button
{
	public function Edit($url)
    {
        $button = '<a href="'.$url.'" class="btn btn-outline-warning">Sửa</a>';
        return $button;
    }

    public function Delete($url,$ajax = null)
    {
        if($ajax == 'ajax')
        {
            $button = '<button type="button" data-ajax="'.$url.'" class="btn btn-outline-danger btn-delete-js">Xóa</button>';
        }else{
            $button = '<a href="'.$url.'" class="btn btn-outline-danger">Xóa</a>';
        }
        return $button;
    }
}