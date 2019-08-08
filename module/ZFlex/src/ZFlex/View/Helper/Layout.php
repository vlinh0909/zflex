<?php 
namespace ZFlex\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Layout extends AbstractHelper
{

    protected $sm;

    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    public function getEM()
    {
        return $this->sm->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    public function Status($entity,$_status = 1)
    {
        if($entity == $_status)
        {
            $status = "<td><span class='label label-activated'>kích hoạt</span></td>";
        }else if($entity == 2){
            $status = "<td><span class='label label-disabled'>đã bán</span></td>";
        }else{
            $status = "<td><span class='label label-disabled'>vô hiệu hóa</span></td>";

        }
        return $status;
    }

    public function YesNo($entity,$_status = 1)
    {
        if($entity == $_status)
        {
            $status = "<td><span class='label label-activated'>TRUE</span></td>";
        }else{
            $status = "<td><span class='label label-disabled'>FALSE</span></td>";
        }
        return $status;
    }

    public function Breadcrumbs($controller = null)
    {
        $breadcumbs = '';
        $breadcumbs = '<div class="page-title clearfix">';
            $breadcumbs .= '<div class="page-title-left float-left">';
                $breadcumbs .= '<p class="lead mb-1"><strong>'.$controller.'</strong><span class="text-muted"></span></p>';
            $breadcumbs .= '</div>';
            $breadcumbs .= '<div class="page-title-right float-right">';
                $partial = array('partial/breadcrumbs.phtml', 'default');
                $navigation = $this->getView()->plugin('navigation');
                $breadcumbs .= $navigation('navigation')->breadcrumbs()->setLinkLast(false)->setMinDepth(0)->setPartial($partial);
            $breadcumbs .= '</div>';
        $breadcumbs .= '</div>';
        return $breadcumbs;
    }

    public function Menu($acl = null,$role = null)
    {
        $partial = array('partial/navigation.phtml', 'default');
        $navigation = $this->getView()->plugin('navigation');
        $navigation('navigation')->menu()->setAcl($acl)->setRole($role)->setPartial($partial)->setUlClass('list-unstyled text-center side-menu text-white');
        return $navigation('navigation')->menu()->render();
    }

    public function CheckboxRole($access = "")
    {
        $layout = "";
        $role = \ZFlexPL\Data\RoleData::RoleData();
        foreach($role['zflex'] as $controller => $value)
        {
            foreach($value as $action => $val)
            {
                if(!empty($access)){
                    if(array_key_exists($controller,$access)){
                        if(in_array($action,$access[$controller])){
                            $layout.= '<div class="col-6"><input checked name="zflex['.$controller.'][]" value="'.$action.'" class="cbx-input cbx-child" id="'.$action.$controller.'" type="checkbox" /><label class="cbx" for="'.$action.$controller.'"></label><label class="lbl ml-2 mt-1" for="'.$action.$controller.'">'.$val['label']." ( <b class='text-muted'>$val[controller] - $val[action] </b> )".'</label></div>';
                        }else{
                            $layout.= '<div class="col-6"><input name="zflex['.$controller.'][]" value="'.$action.'" class="cbx-input cbx-child" id="'.$action.$controller.'" type="checkbox" /><label class="cbx" for="'.$action.$controller.'"></label><label class="lbl ml-2 mt-1" for="'.$action.$controller.'">'.$val['label']." ( <b class='text-muted'>$val[controller] - $val[action] </b> )".'</label></div>';
                        }
                        
                    }else{
                        $layout.= '<div class="col-6"><input name="zflex['.$controller.'][]" value="'.$action.'" class="cbx-input cbx-child" id="'.$action.$controller.'" type="checkbox" /><label class="cbx" for="'.$action.$controller.'"></label><label class="lbl ml-2 mt-1" for="'.$action.$controller.'">'.$val['label']." ( <b class='text-muted'>$val[controller] - $val[action] </b> )".'</label></div>';
                    }
                }else{
                    $layout.= '<div class="col-6"><input name="zflex['.$controller.'][]" value="'.$action.'" class="cbx-input cbx-child" id="'.$action.$controller.'" type="checkbox" /><label class="cbx" for="'.$action.$controller.'"></label><label class="lbl ml-2 mt-1" for="'.$action.$controller.'">'.$val['label']." ( <b class='text-muted'>$val[controller] - $val[action] </b> )".'</label></div>';
                }
                
            }
        }
        return $layout;
    }

    public function MenuNestableHtml($val)
    {
        $xhtml = '';
        
            if($val->type == 'custom'){
            $xhtml .= '<li class="dd-item" data-target="'.$val->target.'" data-type="'.$val->type.'" data-icon="'.$val->icon.'" data-url="'.$val->url.'"" data-id="'.$val->id.'" data-title="'.$val->title.'">';
            }else{
            $xhtml .= '<li class="dd-item" data-target="'.$val->target.'" data-type="'.$val->type.'" data-icon="'.$val->icon.'" data-id="'.$val->id.'" data-title="'.$val->title.'">';    
            }
                $xhtml .= '<div class="dd-handle">';
                    $xhtml .= '<span class="float-left">'.$val->title.'</span>';
                    $xhtml .= '<span class="float-right">'.$val->type.'</span>';
                $xhtml .= '</div>';
                $xhtml .= '<a href="javascript:void(0)" class="show-item-details">';
                    $xhtml .= '<i class="fa fa-angle-down"></i>';
                $xhtml .= '</a>';
                $xhtml .= '<div class="clearfix"></div>';
                $xhtml .= '<div class="item-details">';
                    $xhtml .= '<div class="fields">';
                        $xhtml .= '<label>';
                            $xhtml .= '<span class="text">Title</span>';
                            $xhtml .= '<input type="text" name="title" value="'.$val->title.'">';
                        $xhtml .= '</label>';
                        $xhtml .= '<label>';
                            $xhtml .= '<span class="text">Icon Font</span>';
                            $xhtml .= '<input type="text" name="icon" value="'.$val->icon.'">';
                        $xhtml .= '</label>';
                        if($val->type == 'custom'){
                        $xhtml .= '<label>';
                            $xhtml .= '<span class="text">Url</span>';
                            $xhtml .= '<input type="text" name="url" value="'.$val->url.'">';
                        $xhtml .= '</label>';
                        }
                        $xhtml .= '<label>';
                            $xhtml .= '<span class="text">Target Type</span>';
                            $xhtml .= '<select class="select-target">';
                                $xhtml .= '<option value="_self" '.($val->target == '_self' ? 'selected' : '').'>By Default</option>';
                                $xhtml .= '<option value="_blank" '.($val->target == '_blank' ? 'selected' : '').'>Blank</option>';
                            $xhtml .= '</select>';
                        $xhtml .= '</label>';
                    $xhtml .= '</div>';
                    $xhtml .= '<div class="text-right">';
                        $xhtml .= '<button type="button" class="btn btn-danger btn-sm btn-mini btn-remove-menu">Remove</button>';
                    $xhtml .= '</div>';
                $xhtml .= '</div>';
                $xhtml .= $this->MenuNestableChildren($val);
            $xhtml .= '</li>';  

            return $xhtml;
    }

    public function MenuNestableChildren($val)
    {
        $xhtml = '';
        foreach($val as $key => $value)
        {
            if($key == 'children'){
                $xhtml .= '<ol class="dd-list">';
                foreach($value as $_value){
                    $xhtml .= $this->MenuNestableHtml($_value);
                }
                $xhtml .= '</ol>';
            }
        }
        return $xhtml;
    }

    public function MenuNestable($values)
    {
        $xhtml = '';
        foreach($values as $k => $val)
        {
            $xhtml .= $this->MenuNestableHtml($val);
        }
        return $xhtml;
    }

    public function RentTime($values = null)
    {
        $html = '';
        $html .= '<button type="button" class="btn btn-secondary btn-rent-add my-3 rent-hide"><small>Add Option</small></button>';
        $html .= '<table class="table table-responsive rent-hide">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<th>Hiển thị</th>';
                $html .= '<th>Giờ</th>';
                $html .= '<th>Tiền</th>';
                $html .= '<th></th>';
            $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody class="draggable rent-tbody">';
            $options = array(
                array(
                    'isShow' => 1,
                    'hours' => 3,
                    'price' => 5000
                ),
                array(
                    'isShow' => 1,
                    'hours' => 8,
                    'price' => 10000
                ),
                array(
                    'isShow' => 1,
                    'hours' => 20,
                    'price' => 20000
                ),
                array(
                    'isShow' => 1,
                    'hours' => 36,
                    'price' => 30000
                ),
                array(
                    'isShow' => 1,
                    'hours' => 72,
                    'price' => 50000
                ),
            );
            $stt = 0;
            if(!empty($values))
            {
                foreach($values as $k => $option):
                $html .= '<tr data-rent="'.$stt.'">';
                    $html .= '<td>';
                        $html .= '<i class="icon-more handle"></i>';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<div class="cntr">';
                        if($option['is_show'] == 1)
                        {
                        $html .= '<input checked="checked" class="cbx-input isShow" id="'.$stt.'" name="show['.$stt.']" type="checkbox">';
                        }
                        else{
                        $html .= '<input class="cbx-input isShow" id="'.$stt.'" name="show['.$stt.']" type="checkbox">';
                        }
                        
                        $html .= '<label class="cbx" for="'.$stt.'"></label><label class="lbl" for="'.$stt.'"></label></div>';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<input type="number" name="hours['.$stt.'][]" class="form-control" placeholder="giờ" value="'.$option['hours'].'">';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<input type="number" name="price['.$stt.'][]" class="form-control" placeholder="tiền" value="'.$option['price'].'">';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<button type="button" data-rent="'.$stt.'" class="btn btn-secondary ml-3 rent-delete"><small>Delete</small></button>';
                    $html .= '</td>';
                $html .= '</tr>';
                $stt++;
                endforeach;  
            }else{
                foreach($options as $k => $option):
                $html .= '<tr data-rent="'.$stt.'">';
                    $html .= '<td>';
                        $html .= '<i class="icon-more handle"></i>';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<div class="cntr"><input checked="checked" class="cbx-input isShow" id="'.$stt.'" name="show['.$stt.']" type="checkbox"><label class="cbx" for="'.$stt.'"></label><label class="lbl" for="'.$stt.'"></label></div>';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<input type="number" name="hours['.$stt.'][]" class="form-control" placeholder="giờ" value="'.$option['hours'].'">';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<input type="number" name="price['.$stt.'][]" class="form-control" placeholder="tiền" value="'.$option['price'].'">';
                    $html .= '</td>';
                    $html .= '<td>';
                        $html .= '<button type="button" data-rent="'.$stt.'" class="btn btn-secondary ml-3 rent-delete"><small>Delete</small></button>';
                    $html .= '</td>';
                $html .= '</tr>';
                $stt++;
                endforeach;  
            }
            
        $html .= '</tbody>';
        $html .= '</table>';
        return $html;
    }

    public function AttributeEdit($attribute)
    {
        $html = '';
        if($attribute->getType() == 'multiselect' || $attribute->getType() == 'select')
        {
        $html .= '<button type="button" class="btn btn-secondary btn-attribute-add my-3 attribute-hide"><small>Add Option</small></button>';
        $html .= '<table class="table table-responsive attribute-hide">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th></th>';
                $html .= '<th>Is Default</th>';
                $html .= '<th>Admin</th>';
                $html .= '<th>Default Store View</th>';
                $html .= '<th></th>';
            $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody class="draggable attribute-tbody">';
        $stt = 0;
        $value_options = unserialize($attribute->getAttributeValueOptions()->getValueOptions());
            foreach($value_options as $value){
            $html .= '<tr data-attribute="'.$stt.'">';
                $html .= '<td>';
                    $html .='<i class="icon-more handle"></i>';
                $html .= '</td>';
                $html .='<td>';
                    $html .='<div class="cntr">';
                        if($value['is_default'] == 1)
                        {
                        $html .='<input class="cbx-input isDefault" id="'.$stt.'" name="default['.$stt.']" type="checkbox" checked>';
                        }
                        else{
                        $html .='<input class="cbx-input isDefault" id="'.$stt.'" name="default['.$stt.']" type="checkbox">';
                        }
                        $html .='<label class="cbx" for="'.$stt.'"></label><label class="lbl" for="'.$stt.'"></label>';
                    $html .= '</div>';
                $html .= '</td>';
                $html .= '<td>';
                    $html .= '<input type="text" name="option['.$stt.'][]" class="form-control" placeholder="option" value="'.$value['code'].'">';
                $html .= '</td>';
                $html .= '<td>';
                    $html .='<input type="text" name="value['.$stt.'][]" class="form-control" placeholder="value" value="'.$value['label'].'">';
                $html .= '</td>';
                $html .= '<td>';
                    $html .='<button type="button" data-attribute="'.$stt.'" class="btn btn-secondary ml-3 attribute-delete"><small>Delete</small></button>';
                $html .= '</td>';
            $html .='</tr>';
            $stt++;
            }
        $html .= '</tbody>';
        $html .= '</table>';
        }
        return $html;
    }

    public function FlashMessenger()
    {
        $flash = $this->getView()->plugin('flashmessenger');
        $flash->setMessageOpenFormat('<div%s>
             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                 &times;
             </button>
             <ul class="m-0 p-0"><li>')
             ->setMessageSeparatorString('</li><li>')
             ->setMessageCloseString('</li></ul></div>');
        $show = '';
        $show .= $flash->render('error',   array('alert', 'alert-dismissible', 'alert-danger'));
        $show .= $flash->render('info',    array('alert', 'alert-dismissible', 'alert-info'));
        $show .= $flash->render('default', array('alert', 'alert-dismissible', 'alert-warning'));
        $show .= $flash->render('success', array('alert', 'alert-dismissible', 'alert-success'));
        return $show;
    }

    public function SetMedia($input,$id = 0,$image = null,$multi = false,$text = 'OPEN MEDIA')
    {
        $xhtml = '';
        $xhtml .= '<div class="review" data-review-id="'.$id.'">';
        if(!empty($image)):
            if(is_array($image)):
            foreach($image as $_image)
            {
            $xhtml .= '<div class="img-review" data-toggle="modal" data-target="#mediaModalMulti">';
                $xhtml .= '<img src="'.$_image.'"/>';
                $xhtml .= '<i class="icon-bin" data-review-id="'.$id.'"></i>';
                $xhtml .= '<div class="name">'.basename($_image).'</div>';
            $xhtml .= '</div>';    
            }
            else:
            $xhtml .= '<div class="img-review" data-toggle="modal" data-target="#mediaModal">';
                $xhtml .= '<img src="'.$image.'"/>';
                $xhtml .= '<i class="icon-bin icon-bin-single" data-review-id="'.$id.'"></i>';
                $xhtml .= '<div class="name">'.basename($image).'</div>';
            $xhtml .= '</div>';
            endif;
        endif;
        $xhtml .= '</div>';
        if($multi == true):
        $xhtml .= '<button type="button" class="btn btn-dark btn-block btn-lg btn-open-media" data-media-id="'.$id.'" data-toggle="modal" data-target="#mediaModalMulti">';
        else:
        $xhtml .= '<button type="button" class="btn btn-dark btn-block btn-lg btn-open-media" data-media-id="'.$id.'" data-toggle="modal" data-target="#mediaModal">';
        endif;
            $xhtml .= $text;
        $xhtml .= '</button>';
        if(is_array($image)):
        $str = '';
        foreach($image as $k => $_image)
        {
            $str .= $_image.',';
        }
        $xhtml .= $this->view->formElement($input->setAttribute('data-review-id',$id)->setValue($str));
        else:
        $xhtml .= $this->view->formElement($input->setAttribute('data-review-id',$id)->setValue($image));
        endif;
        return $xhtml;
    }

    public function MediaModal($multi = false,$modal = true,$id = 0)
    {
        $xhtml = '';
        if($modal == true):
            if($multi == true):
            $xhtml .= '<div class="modal fade" id="mediaModalMulti">';
            else:
            $xhtml .= '<div class="modal fade" id="mediaModal">';
            endif;
              $xhtml .= '<div class="modal-dialog modal-lg">';
                $xhtml .= '<div class="modal-content">';
                  $xhtml .= '<div class="modal-header modal-header-media"><p class="m-0"><i class="icon-images3 mr-2"></i>Media gallery</p>';
                  $xhtml .= '</div>';
                  $xhtml .= '<div class="modal-body">';
        endif;
                $gallery = new \ZFlex\Framework\Gallery;
                $gallery->setCurrentPath($_SESSION['media_current_path']);
                $current_path = $gallery->getCurrentPath();
                $xhtml .='<div class="box bg-white mt-3">';
                    $xhtml .='<div class="box-heading">';
                        $xhtml .='<p class="lead">Media</p>';
                        $xhtml .='<div class="btn-group">';
                            $xhtml .='<div class="dropdown btn-add">';
                            if($multi == true):
                                $xhtml .='<button type="button" class="btn-add btn btn-dark ml-3 media-select">SELECT</button>'; 
                            endif;
                              $xhtml .='<button class="btn btn-info dropdown-toggle ml-3 btn-media-actions" type="button" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Actions';
                              $xhtml .='</button>';
                              $xhtml .='<ul class="dropdown-menu dropdown-menu-right media-action" aria-labelledby="dropdown">';
                                $xhtml .='<li class="dropdown-item gallery-delete"><i class="fa fa-trash"></i>Delete</li>';
                                $xhtml .='<li class="dropdown-item gallery-create-folder"><i class="icon-folder-plus2"></i>Create Folder</li>';
                                $xhtml .='<li class="dropdown-item gallery-rename"><i class="icon-pencil5"></i>Rename</li>';
                              $xhtml .='</ul>';
                            $xhtml .='</div>';
                            $xhtml .='<button type="button" class="btn-add btn btn-info ml-3 js-dropzone-upload dz-clickable" id="ZFlexUpload">Upload <i class="icon-upload4" aria-hidden="true"></i></button>';
                        $xhtml .='</div>';
                    $xhtml .='</div>';
                    $xhtml .='<div class="box-body box-media box-media-'.$id.'">';
                        $xhtml .= '<small class="text-muted mb-3 d-block">media/'.$current_path.'</small>';
                        $xhtml .='<div class="row">';
                            $xhtml .='<div class="col-12 col-sm-8 media-items">';
                                if($multi == true):
                                    $xhtml .='<ul class="list-inline list-media list-media-multi">';
                                else:
                                    $xhtml .='<ul class="list-inline list-media list-media-single">';    
                                endif;
                                    
                                    $images = $gallery->getElementsArray();
                                    // $sm = $this->sm->getServiceLocator();
                                    // $images = $sm->get('MediaManager')->make();
                                    if($current_path !== ''):
                                        $xhtml .='<li class="media-item media-item-folder" data-media-dir="'.$gallery->getBackPath($current_path).'">';
                                            $xhtml .='<div class="media-thumbnail">';
                                                $xhtml .='<i class="icon-square-left"></i>';
                                            $xhtml .='</div>';
                                            $xhtml .='<div class="media-description">';
                                                $xhtml .='<div class="media-title">...</div>';
                                            $xhtml .='</div>';
                                        $xhtml .='</li>'; 
                                    endif;
                                    foreach($images as $key => $image){
                                    if($key === "folder.con"):
                                        foreach($image as $key => $folder):
                                            $xhtml .='<li class="media-item media-item-folder" data-name="'.$folder["name"].'" data-media-dir="'.$current_path.$folder["name"].'/">';
                                                $xhtml .='<div class="media-thumbnail">';
                                                    $xhtml .='<i class="icon-folder2"></i>';
                                                $xhtml .='</div>';
                                                $xhtml .='<div class="media-description">';
                                                    $xhtml .='<div class="media-title">'.$folder['name'].' ( item '. $folder['items'] .')</div>';
                                                $xhtml .='</div>';
                                            $xhtml .='</li>'; 
                                        endforeach;
                                    else:
                                        $xhtml .='<li class="media-item media-item-modal" data-name="'.$image['name'].'">';
                                            $xhtml .='<div class="media-thumbnail">';
                                                $xhtml .='<img src="'.$this->view->Path()->PathIMG($current_path.$image['name']).'" data-image-name="'.$image['name'].'" data-image-size="'.round($image['size'],2).'" data-image-mime="'.$image['mime'].'" data-image-time="'.$image['time'].'" class="img-media">';
                                            $xhtml .='</div>';
                                            $xhtml .='<div class="media-description">';
                                                $xhtml .='<div class="media-title">'.$image['name'].'</div>';
                                            $xhtml .='</div>';
                                        $xhtml .='</li>';
                                    endif;
                                    
                                    }
                                $xhtml .='</ul>';
                            $xhtml .='</div>';
                            $xhtml .='<div class="col-12 col-sm-4 media-details">';
                                $xhtml .='<div class="media-thumbnail-details d-flex justify-content-center">';
                                    $xhtml .='<a data-fancybox="gallery" href=""><img src="'.$this->view->Path()->PathIMG('no-image.png').'" class="img-detail" height="200px"></a>';
                                $xhtml .='</div>';
                                $xhtml .='<div class="media-description-details">';
                                    $xhtml .='<div class="media-name">';
                                        $xhtml .='<p>Name</p>';
                                        $xhtml .='<span data-media="name"></span>';
                                    $xhtml .='</div>';
                                    $xhtml .='<div class="media-name">';
                                        $xhtml .='<p>Size</p>';
                                        $xhtml .='<span data-media="size"></span>';
                                    $xhtml .='</div>';
                                    $xhtml .='<div class="media-name">';
                                        $xhtml .='<p>Full url</p>';
                                        $xhtml .='<input type="" name="" class="input-group media-url" value="">';
                                    $xhtml .='</div>';
                                    $xhtml .='<div class="media-name">';
                                        $xhtml .='<p>Type</p>';
                                        $xhtml .='<span data-media="mime"></span>';
                                    $xhtml .='</div>';
                                    $xhtml .='<div class="media-name">';
                                        $xhtml .='<p>Uploaded at</p>';
                                        $xhtml .='<span data-media="time"></span>';
                                    $xhtml .='</div>';
                                $xhtml .='</div>';
                            $xhtml .='</div>';
                        $xhtml .='</div>';
                    $xhtml .='</div>';
        if($modal == true):
                $xhtml .='</div>';
              $xhtml .= '</div>';
            $xhtml .= '</div>';
          $xhtml .='</div>';
        $xhtml .='</div>';
        endif;
        return $xhtml;
    }

    public function Multi()
    {
        return '<select class="box-select" name="action">
            <option value="deleted">Xóa</option>
            <option value="activated">Kích hoạt</option>
            <option value="disabled">Vô hiệu hóa</option>
        </select>
        <button class="btn btn-secondary ml-2">Thực hiện</button>';
    }

    public function Button()
    {
        return new \ZFlex\View\Helper\Button\Button;
    }

    public function Widget()
    {
        return new \ZFlex\View\Helper\Widget\Widget;
    }
}