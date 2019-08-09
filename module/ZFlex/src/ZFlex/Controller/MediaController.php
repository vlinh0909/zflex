<?php
namespace ZFlex\Controller;

use Zend\View\Model\ViewModel;
 
use Zend\Validator\File\Size;

class MediaController extends Controller
{

	public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $__image = $sm->get('MediaManager')->make();
        $form = $sm->get('FormElementManager')->get('MediaForm');
        return new ViewModel(array('images' => $__image,'form' => $form));
    }

    public function addAction()
    {
        $sm = $this->getServiceLocator();
         
        if (!empty($_FILES)) {

            $file = $_FILES['file']; 

            $sm->get('MediaManager')->add($file);
             
        }
        return false;
    }

    public function loadAction()
    {
        $value = $this->getRequest()->getPost('dir');
        $gallery = new \ZFlex\Framework\Gallery;
        $gallery->setCurrentPath($value);
        $data = new \Zend\View\Model\JsonModel(array(
                    'result' => $value
         ));
        return $data;
    }

    public function createFolderAction()
    {
        $name = $this->getRequest()->getPost('name');
        $gallery = new \ZFlex\Framework\Gallery;
        $gallery->createFolder($name);
        $data = new \Zend\View\Model\JsonModel(array(
                    'result' => $name
        ));
        return $data;
    }

    public function loadDeleteFolderAction()
    {
        $name = $this->getRequest()->getPost('name');
        $gallery = new \ZFlex\Framework\Gallery;
        $gallery->deleteFolder($name);
        $data = new \Zend\View\Model\JsonModel(array(
                    'result' => $name
        ));
        return $data;
    }


    public function renameAction()
    {
        $old_name = $this->getRequest()->getPost('old_name');
        $new_name = $this->getRequest()->getPost('new_name');
        $gallery = new \ZFlex\Framework\Gallery;
        $gallery->rename($old_name,$new_name);
        $data = new \Zend\View\Model\JsonModel(array(
                    'result' => $new_name
        ));
        return $data;
    }

    public function loadDeleteAction()
    {
        $value = $this->getRequest()->getPost('data');
        if(!empty($value))
        {
            $sm = $this->getServiceLocator();
            foreach($value as $val)
            {
                $sm->get('MediaManager')->delete($val);
            }
            $status = 'ok';
            $data = new \Zend\View\Model\JsonModel(array(
                    'result' => $status,
            ));
        }else{
            $data = new \Zend\View\Model\JsonModel(array(
                    'result' => '',
            ));
        }
        return $data;
    }
}