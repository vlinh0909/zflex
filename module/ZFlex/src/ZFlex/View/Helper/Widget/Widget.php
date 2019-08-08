<?php 
namespace ZFlex\View\Helper\Widget;

class Widget
{
    public function open()
    {
        $view = '';
        $view .= '<div class="widget-list">';
            $view .= '<div class="row">';
        return $view; 
    }

	public function show(Array $config)
    {
        $view = '';
        $view .= '<div class="col-md-3 col-12 mt-3">';
            $view .= '<div class="widget text-white" style="background-color:gray;">';
                $view .= '<div class="widget-heading">';
                    $view .= '<p class="widget-title m-0">'.$config['label'].'</p>';
                    $view .= '<i class="'.$config['icon'].' widget-icon"></i>';
                $view .= '</div>';
                $view .= '<p class="widget-value">';
                    $view .= $config['values']['prefix'].' <span class="counter">'.$config['values']['value'].'</span> '.$config['values']['stuffix'];
                $view .= '</p>';
                $view .= '<a href="'.$config['link'].'" class="widget-footer">Chi tiết<i class="fa fa-arrow-circle-right"></i></a>';
            $view .= '</div>';
        $view .= '</div>';
        return $view;
    }

    public function close()
    {
        $view = '';
        $view .= '</div>';
            $view .= '</div>';
        return $view;
    }
}